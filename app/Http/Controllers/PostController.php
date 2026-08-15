<?php

namespace App\Http\Controllers;

use App\Jobs\NotifySubscribersOfPublishedPost;
use App\Models\Post;
use App\Models\Category;
use App\Services\PostCacheService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $staticPosts = Cache::tags(['blog'])->remember('posts_static', 3600, function () {
            return Post::with(['author', 'category'])
                ->where('status', 'published')
                ->orderBy('published_at', 'desc')
                ->get()
                ->map(fn($p) => [
                    'id' => $p->id,
                    'title' => $p->title,
                    'slug' => $p->slug,
                    'excerpt' => $p->excerpt,
                    'content' => $p->content,
                    'image' => $p->featured_image,
                    'published_at' => $p->published_at?->toDateTimeString(),
                    'category' => $p->category ? [
                        'name' => $p->category->name,
                        'slug' => $p->category->slug,
                    ] : null,
                ])
                ->toArray();
        });

        $postIds = array_column($staticPosts, 'id');

        $liveStats = Post::whereIn('id', $postIds)
            ->get(['id', 'views', 'reading_time'])
            ->keyBy('id');

        $reviewStats = DB::table('reviews')
            ->select('post_id', DB::raw('AVG(rating) as avg_rating'), DB::raw('COUNT(*) as reviews_count'))
            ->whereIn('post_id', $postIds)
            ->groupBy('post_id')
            ->get()
            ->keyBy('post_id');

        $likeStats = collect();
        if (Schema::hasTable('post_likes')) {
            $likeStats = DB::table('post_likes')
                ->select('post_id', DB::raw('COUNT(*) as likes_count'))
                ->whereIn('post_id', $postIds)
                ->groupBy('post_id')
                ->get()
                ->keyBy('post_id');
        }

        $posts = collect($staticPosts)->map(function ($post) use ($liveStats, $reviewStats, $likeStats) {
            $stats = $liveStats->get($post['id']);
            $reviews = $reviewStats->get($post['id']);
            $likes = $likeStats->get($post['id']);

            $post['views'] = $stats->views ?? 0;
            $post['reading_time'] = $stats->reading_time ?? 0;
            $post['average_rating'] = $reviews ? round((float) $reviews->avg_rating, 1) : 0;
            $post['reviews_count'] = $reviews->reviews_count ?? 0;
            $post['likes_count'] = $likes->likes_count ?? 0;

            return $post;
        })->toArray();

        $popularPosts = collect($posts)
            ->sortByDesc('views')
            ->take(4)
            ->map(fn($p) => [
                'title' => $p['title'],
                'slug' => $p['slug'],
                'views' => $p['views'],
            ])
            ->values()
            ->toArray();

        $postCount = count($posts);
        $totalViews = array_sum(array_column($posts, 'views'));

        $allReviews = DB::table('reviews')
            ->join('posts', 'posts.id', '=', 'reviews.post_id')
            ->join('users', 'users.id', '=', 'reviews.user_id')
            ->where('posts.status', 'published')
            ->whereNotNull('reviews.review_text')
            ->where('reviews.review_text', '!=', '')
            ->select(
                'reviews.rating',
                'reviews.review_text',
                'reviews.created_at',
                'users.name as user_name',
                'posts.title as post_title',
                'posts.slug as post_slug'
            )
            ->orderByDesc('reviews.created_at')
            ->get()
            ->map(fn($r) => [
                'rating' => $r->rating,
                'review_text' => $r->review_text,
                'created_at' => $r->created_at,
                'user' => ['name' => $r->user_name],
                'post' => ['title' => $r->post_title, 'slug' => $r->post_slug],
            ])
            ->toArray();

        $authorCount = Cache::tags(['blog'])->remember('author_count', 3600, function () {
            return DB::table('users')->count();
        });

        $categories = Cache::tags(['blog'])->remember('categories', 3600, function () {
            return Category::orderBy('name')->get()->map(fn($c) => [
                'name' => $c->name,
                'slug' => $c->slug,
            ])->toArray();
        });

        $allPosts = Cache::remember('search-index', 3600, function () {
            return Post::where('status', 'published')
                ->get()
                ->map(fn($p) => [
                    'id' => $p->id,
                    'title' => $p->title,
                    'slug' => $p->slug,
                    'excerpt' => $p->excerpt,
                    'views' => $p->views,
                ])
                ->toArray();
        });

        return view('posts.index', compact('posts', 'popularPosts', 'postCount', 'totalViews', 'authorCount', 'allPosts', 'categories', 'allReviews'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:posts,slug',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
            $count = Post::where('slug', $validated['slug'])->count();
            if ($count > 0) {
                $validated['slug'] = $validated['slug'] . '-' . ($count + 1);
            }
        }

        $imagePath = null;
        if ($request->hasFile('featured_image')) {
            $image = $request->file('featured_image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('public/featured_images', $imageName);
            $imagePath = str_replace('public/', 'storage/', $imagePath);
        }

        $post = Post::create([
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'content' => $validated['content'],
            'status' => $validated['status'],
            'published_at' => $validated['published_at'],
            'featured_image' => $imagePath,
            'author_id' => Auth::id(),
            'category_id' => $validated['category_id'],
            'views' => 0,
        ]);

        $this->clearPostCache();

        if ($validated['status'] === 'published') {
            // Notify all users that a new post has gone live
            NotifySubscribersOfPublishedPost::dispatch($post);

            return redirect()->route('posts.show', $post->slug)
                ->with('success', 'Post published successfully!');
        }

        return redirect()->route('posts.show', $post->slug)
            ->with('success', 'Post saved as draft!');
    }

  public function show($slug, PostCacheService $postCache)
{
    // Try to get cached post data first
    $cached = $postCache->getBySlug($slug);
    
    if ($cached && isset($cached['is_full_cache'])) {
        // --- USE CACHED DATA ---
        // Create a Post object from cached data
        $post = new Post();
        $post->id = $cached['id'];
        $post->title = $cached['title'];
        $post->slug = $cached['slug'];
        $post->content = $cached['content'];
        $post->excerpt = $cached['excerpt'];
        $post->status = $cached['status'];
        $post->views = $cached['views'];
        $post->featured_image = $cached['featured_image_raw'];
        $post->reading_time = $cached['reading_time'] ?? 0;
        
        // Set dates
        if ($cached['published_at_raw']) {
            $post->published_at = new \DateTime($cached['published_at_raw']);
        }
        
        // Reconstruct author
        if ($cached['author']) {
            $author = new \App\Models\User();
            $author->id = $cached['author']['id'];
            $author->name = $cached['author']['name'];
            $author->email = $cached['author']['email'];
            $author->bio = $cached['author']['bio'] ?? null;
            $author->avatar = $cached['author']['avatar'] ?? null;
            $post->setRelation('author', $author);
        }
        
        // Reconstruct category
        if ($cached['category']) {
            $category = new \App\Models\Category();
            $category->id = $cached['category']['id'];
            $category->name = $cached['category']['name'];
            $category->slug = $cached['category']['slug'];
            $category->description = $cached['category']['description'] ?? null;
            $post->setRelation('category', $category);
        }
        
    } else {
        // --- CACHE MISS - FETCH FROM DATABASE ---
        $post = Post::with(['author', 'category'])
            ->where('slug', $slug)
            ->first();

        if (is_null($post)) {
            abort(404);
        }

        // Drafts are only visible to their author (or an admin)
        if ($post->status !== 'published') {
            $user = Auth::user();
            if (!$user || ($post->author_id !== $user->id && !$user->isAdmin())) {
                abort(404);
            }
        }

        // Build and cache the full payload
        $cached = $postCache->buildPayload($post);
        $postCache->put($post->id, $cached);
    }

    // Increment views (via queue) - non-blocking
    $postCache->incrementViews($post->id);


    // Get search index for sidebar
    $allPosts = Cache::remember('search-index', 3600, function () {
        return Post::where('status', 'published')
            ->get()
            ->map(fn($p) => [
                'id' => $p->id,
                'title' => $p->title,
                'slug' => $p->slug,
                'excerpt' => $p->excerpt,
                'views' => $p->views,
            ])
            ->toArray();
    });

    return view('posts.show', compact('post', 'allPosts', 'cached'));
}
public function trackRead(Request $request, $id, PostCacheService $postCache)
{
    $validated = $request->validate([
        'duration' => 'required|integer|min:1|max:7200',
    ]);

    // Update database
    Post::whereKey($id)->increment('reading_time', $validated['duration']);
    
    // Update cache if it exists
    $data = $postCache->get($id);
    if ($data) {
        $data['reading_time'] = ($data['reading_time'] ?? 0) + $validated['duration'];
        $postCache->put($id, $data);
    }

    return response()->noContent();
}
    public function draft($slug)
    {
        $post = Post::with(['author', 'category'])
            ->where('slug', $slug)
            ->where('author_id', Auth::id())
            ->first();

        if (is_null($post)) {
            abort(404);
        }

        return view('posts.draft', compact('post'));
    }

    private function clearPostCache()
    {
        try {
            Cache::tags(['blog'])->flush();
        } catch (\Exception $e) {
            Cache::forget('posts_static');
            Cache::forget('author_count');
            Cache::forget('categories');
        }

        Cache::forget('search-index');
        Cache::forget('posts_static');
        Cache::forget('author_count');
        Cache::forget('categories');
    }

    public function edit($id)
    {
        $post = Post::where('id', $id)
            ->where('author_id', Auth::id())
            ->firstOrFail();

        $categories = Category::orderBy('name')->get();
        return view('posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, $id, PostCacheService $postCache)
    {
        $post = Post::where('id', $id)
            ->where('author_id', Auth::id())
            ->firstOrFail();

        $wasPublished = $post->status === 'published';

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:posts,slug,' . $id,
            'category_id' => 'required|exists:categories,id',
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        if ($request->hasFile('featured_image')) {
            if ($post->featured_image) {
                $oldPath = str_replace('storage/', 'public/', $post->featured_image);
                if (Storage::exists($oldPath)) {
                    Storage::delete($oldPath);
                }
            }

            $image = $request->file('featured_image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('public/featured_images', $imageName);
            $validated['featured_image'] = str_replace('public/', 'storage/', $imagePath);
        }

        $post->update($validated);

        $this->clearPostCache();
        $postCache->forget($post->id);

        // Only notify if this update just transitioned the post from draft -> published,
        // so re-saving an already-published post doesn't re-email everyone.
        if (!$wasPublished && $post->status === 'published') {
            NotifySubscribersOfPublishedPost::dispatch($post);
        }

        return redirect()->route('posts.show', $post->slug)
            ->with('success', 'Post updated successfully!');
    }

    public function destroy($id, PostCacheService $postCache)
    {
        $post = Post::where('id', $id)
            ->where('author_id', Auth::id())
            ->firstOrFail();

        if ($post->featured_image) {
            $oldPath = str_replace('storage/', 'public/', $post->featured_image);
            if (Storage::exists($oldPath)) {
                Storage::delete($oldPath);
            }
        }

        $postId = $post->id;
        $post->delete();

        $this->clearPostCache();
        $postCache->forget($postId);

        return redirect()->route('posts.index')
            ->with('success', 'Post deleted successfully!');
    }
}