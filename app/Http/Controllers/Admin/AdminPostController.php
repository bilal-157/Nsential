<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use App\Models\Comment;
use App\Models\Review;
use App\Services\PostCacheService;
use App\Jobs\NotifySubscribersOfPublishedPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class AdminPostController extends Controller
{
    /**
     * Display a listing of posts in admin panel.
     */
    public function index(Request $request)
    {
        // Build the query - load all necessary relationships and ensure views is included
        $query = Post::with(['author', 'category']);
        
        // Apply search filter
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        
        // Apply status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Apply category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        
        // Get posts with pagination
        $posts = $query->latest()->paginate(15);
        
        // Eager load counts to avoid N+1 queries
        $posts->loadCount(['allComments', 'likes', 'reviews']);
        
        // Calculate statistics
        $stats = [
            'total_posts' => Post::count(),
            'published_posts' => Post::where('status', 'published')->count(),
            'draft_posts' => Post::where('status', 'draft')->count(),
            'total_users' => User::count(),
            'total_comments' => Comment::count(),
            'total_reviews' => Review::count(),
        ];
        
        $categories = Category::orderBy('name')->get();
        
        return view('admin.posts.index', compact('posts', 'stats', 'categories'));
    }

    /**
     * Show the form for creating a new post.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.posts.create', compact('categories'));
    }

    /**
     * Store a newly created post.
     */
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

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
            $count = Post::where('slug', $validated['slug'])->count();
            if ($count > 0) {
                $validated['slug'] = $validated['slug'] . '-' . ($count + 1);
            }
        }

        // Handle featured image upload
        $imagePath = null;
        if ($request->hasFile('featured_image')) {
            $image = $request->file('featured_image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            
            $path = $image->storeAs('featured_images', $imageName, 'public');
            $imagePath = $path;
            
            Log::info('Image stored at: ' . $imagePath);
        }

        // Create the post
        $post = Post::create([
            'title' => $validated['title'],
            'slug' => $validated['slug'],
            'content' => $validated['content'],
            'status' => $validated['status'],
            'published_at' => $validated['published_at'] ?? now(),
            'featured_image' => $imagePath,
            'author_id' => Auth::id(),
            'category_id' => $validated['category_id'],
            'views' => 0,
        ]);

        // Clear all caches
        $this->clearPostCache();

        // Notify all users if the admin published this post immediately
        if ($post->status === 'published') {
            NotifySubscribersOfPublishedPost::dispatch($post);
        }

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post created successfully!');
    }

    /**
     * Show the form for editing the specified post.
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $categories = Category::orderBy('name')->get();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified post.
     */
    public function update(Request $request, $id, PostCacheService $postCache)
    {
        $post = Post::findOrFail($id);

        $wasPublished = $post->status === 'published';

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:posts,slug,' . $id,
            'category_id' => 'required|exists:categories,id',
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
            $existing = Post::where('slug', $validated['slug'])
                ->where('id', '!=', $id)
                ->exists();
            if ($existing) {
                $validated['slug'] = $validated['slug'] . '-' . ($id + 1);
            }
        }

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
                Log::info('Deleted old image: ' . $post->featured_image);
            }

            $image = $request->file('featured_image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('featured_images', $imageName, 'public');
            $validated['featured_image'] = $path;
            
            Log::info('Updated with new image: ' . $path);
        }

        $post->update($validated);

        // Clear all caches
        $this->clearPostCache();
        $postCache->forget($post->id);

        // Only notify if this update just transitioned the post from draft -> published,
        // so re-saving an already-published post doesn't re-email everyone.
        if (!$wasPublished && $post->status === 'published') {
            NotifySubscribersOfPublishedPost::dispatch($post);
        }

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post updated successfully!');
    }

    /**
     * Remove the specified post.
     */
    public function destroy($id, PostCacheService $postCache)
    {
        $post = Post::findOrFail($id);

        // Delete featured image if exists
        if ($post->featured_image) {
            $deleted = false;
            $imagePath = $post->featured_image;
            
            Log::info('Attempting to delete image: ' . $imagePath);
            
            if (Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
                $deleted = true;
                Log::info('Image deleted using public disk: ' . $imagePath);
            }
            
            if (!$deleted) {
                $cleanPath = str_replace('storage/', '', $imagePath);
                if (Storage::disk('public')->exists($cleanPath)) {
                    Storage::disk('public')->delete($cleanPath);
                    $deleted = true;
                    Log::info('Image deleted using cleaned path: ' . $cleanPath);
                }
            }
            
            if (!$deleted && strpos($imagePath, 'storage/') !== 0) {
                $storagePath = 'storage/' . $imagePath;
                if (Storage::disk('public')->exists($storagePath)) {
                    Storage::disk('public')->delete($storagePath);
                    $deleted = true;
                    Log::info('Image deleted using storage/ prefix: ' . $storagePath);
                }
            }
            
            if (!$deleted) {
                $cleanPath = str_replace('storage/', '', $imagePath);
                $fullPath = storage_path('app/public/' . $cleanPath);
                if (file_exists($fullPath)) {
                    unlink($fullPath);
                    $deleted = true;
                    Log::info('Image deleted using full path: ' . $fullPath);
                }
            }
            
            if (!$deleted) {
                Log::warning('Could not delete image: ' . $imagePath);
            }
        }

        $postId = $post->id;
        $post->delete();

        // Clear all caches
        $this->clearPostCache();
        $postCache->forget($postId);

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post deleted successfully!');
    }

    /**
     * Display analytics for a specific post.
     */
    public function analytics($id)
    {
        $post = Post::with(['author', 'category'])->findOrFail($id);
        
        // Get view statistics
        $views = $post->views;
        
        // Get reading time stats (in minutes)
        $readingTime = $post->reading_time ?? 0;
        $readingTimeMinutes = round($readingTime / 60, 1);
        
        // Get comment count
        $commentCount = $post->comments()->count();
        
        // Get review stats
        $reviewStats = $post->reviews()
            ->selectRaw('AVG(rating) as avg_rating, COUNT(*) as total_reviews, MIN(rating) as min_rating, MAX(rating) as max_rating')
            ->first();
        
        // Get like count
        $likeCount = 0;
        if (Schema::hasTable('post_likes')) {
            $likeCount = DB::table('post_likes')
                ->where('post_id', $post->id)
                ->count();
        }
        
        // Get recent comments (last 5)
        $recentComments = $post->comments()
            ->with('user')
            ->latest()
            ->limit(5)
            ->get();
        
        // Get recent reviews (last 5)
        $recentReviews = $post->reviews()
            ->with('user')
            ->latest()
            ->limit(5)
            ->get();
        
        // Get rating distribution
        $ratingDistribution = $post->reviews()
            ->selectRaw('rating, COUNT(*) as count')
            ->groupBy('rating')
            ->orderBy('rating', 'desc')
            ->get()
            ->pluck('count', 'rating')
            ->toArray();
        
        // Fill missing ratings with 0
        for ($i = 1; $i <= 5; $i++) {
            if (!isset($ratingDistribution[$i])) {
                $ratingDistribution[$i] = 0;
            }
        }
        krsort($ratingDistribution);
        
        // Get post performance metrics
        $publishedDate = $post->published_at;
        $daysSincePublished = $publishedDate ? $publishedDate->diffInDays(now()) : 0;
        $avgViewsPerDay = $daysSincePublished > 0 ? round($views / $daysSincePublished, 1) : $views;
        
        return view('admin.posts.analytics', compact(
            'post',
            'views',
            'readingTime',
            'readingTimeMinutes',
            'commentCount',
            'reviewStats',
            'likeCount',
            'recentComments',
            'recentReviews',
            'ratingDistribution',
            'daysSincePublished',
            'avgViewsPerDay'
        ));
    }

    /**
     * Clear all post-related caches
     */
    private function clearPostCache()
    {
        // Clear tag-based cache
        try {
            Cache::tags(['blog'])->flush();
        } catch (\Exception $e) {
            // If tags not supported, clear individually
            Cache::forget('posts_static');
            Cache::forget('author_count');
            Cache::forget('categories');
        }

        // Clear individual cache keys
        Cache::forget('search-index');
        Cache::forget('posts_static');
        Cache::forget('author_count');
        Cache::forget('categories');
        
        // Clear home page cache
        Cache::forget('home_data');
    }

    /**
     * Clean orphaned images (admin tool)
     */
    public function cleanOrphanedImages()
    {
        $files = Storage::disk('public')->files('featured_images');
        
        $postImages = Post::whereNotNull('featured_image')
            ->get()
            ->map(function($post) {
                // Clean the path to match storage format
                $path = $post->featured_image;
                $path = str_replace('storage/', '', $path);
                $path = str_replace('public/', '', $path);
                return $path;
            })
            ->toArray();
        
        $orphaned = [];
        foreach ($files as $file) {
            if (!in_array($file, $postImages)) {
                $orphaned[] = $file;
            }
        }
        
        if (empty($orphaned)) {
            return redirect()->back()
                ->with('info', 'No orphaned images found.');
        }
        
        $deleted = 0;
        foreach ($orphaned as $file) {
            Storage::disk('public')->delete($file);
            $deleted++;
        }
        
        return redirect()->back()
            ->with('success', "Deleted {$deleted} orphaned images.");
    }

    /**
     * Show orphaned images for admin to review
     */
    public function showOrphanedImages()
    {
        $files = Storage::disk('public')->files('featured_images');
        
        $postImages = Post::whereNotNull('featured_image')
            ->get()
            ->map(function($post) {
                $path = $post->featured_image;
                $path = str_replace('storage/', '', $path);
                $path = str_replace('public/', '', $path);
                return $path;
            })
            ->toArray();
        
        $orphaned = [];
        foreach ($files as $file) {
            if (!in_array($file, $postImages)) {
                $orphaned[] = [
                    'name' => basename($file),
                    'path' => $file,
                    'size' => Storage::disk('public')->size($file),
                    'last_modified' => Storage::disk('public')->lastModified($file)
                ];
            }
        }
        
        return view('admin.images.orphaned', compact('orphaned'));
    }
}