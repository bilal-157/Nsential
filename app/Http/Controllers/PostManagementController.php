<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Jobs\NotifySubscribersOfPublishedPost;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Carbon\Carbon;

class PostManagementController extends Controller
{
    /**
     * Show the form for creating a new post (for authors)
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('posts.create', compact('categories'));
    }

    /**
     * Store a newly created post (for authors)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
            'featured_image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:4096',
            'published_at' => 'nullable|date',
        ]);

        $slug = Str::slug($validated['title']);

        if (Post::where('slug', $slug)->exists()) {
            $slug = $slug . '-' . uniqid();
        }

        // Handle featured image upload - FIXED to match admin format
        $imagePath = null;
        if ($request->hasFile('featured_image')) {
            $image = $request->file('featured_image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('featured_images', $imageName, 'public');
            $imagePath = $path;
            
            Log::info('Author uploaded image: ' . $imagePath);
        }

        // Calculate reading time from content
        $readingTime = $this->calculateReadingTime($validated['content']);

        $post = Post::create([
            'author_id' => auth()->id(),
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'slug' => $slug,
            'content' => $validated['content'],
            'status' => $validated['status'],
            'featured_image' => $imagePath,
            'views' => 0,
            'reading_time' => $readingTime,
            'published_at' => $validated['status'] === 'published'
                ? ($validated['published_at'] ?? Carbon::now())
                : null,
        ]);

        // Clear ALL caches
        $this->clearAllCaches();

        if ($validated['status'] === 'published') {
            // Notify all users that a new post has gone live
            NotifySubscribersOfPublishedPost::dispatch($post);

            return redirect()->route('posts.show', $post->slug)
                ->with('success', 'Post published successfully!');
        }

        return redirect()->route('posts.show', $post->slug)
            ->with('success', 'Post saved as draft!');
    }

    /**
     * Show the form for editing the specified post
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        
        // Check if the user owns this post
        if ($post->author_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }
        
        $categories = Category::orderBy('name')->get();
        return view('posts.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified post
     */
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        
        // Check if the user owns this post
        if ($post->author_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        $wasPublished = $post->status === 'published';

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
            'featured_image' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:4096',
            'remove_featured_image' => 'nullable|boolean',
            'published_at' => 'nullable|date',
        ]);

        $imagePath = $post->featured_image;

        if ($request->hasFile('featured_image')) {
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
            }
            $image = $request->file('featured_image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('featured_images', $imageName, 'public');
            $imagePath = $path;
        } elseif ($request->boolean('remove_featured_image')) {
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
            }
            $imagePath = null;
        }

        // Recalculate reading time if content changed
        $readingTime = $post->reading_time;
        if ($post->content !== $validated['content']) {
            $readingTime = $this->calculateReadingTime($validated['content']);
        }

        $post->update([
            'title' => $validated['title'],
            'category_id' => $validated['category_id'],
            'content' => $validated['content'],
            'status' => $validated['status'],
            'featured_image' => $imagePath,
            'reading_time' => $readingTime,
            'published_at' => $validated['status'] === 'published'
                ? ($validated['published_at'] ?? Carbon::now())
                : null,
        ]);

        // Clear ALL caches
        $this->clearAllCaches();

        // Only notify if this update just transitioned the post from draft -> published,
        // so re-saving an already-published post doesn't re-email everyone.
        if (!$wasPublished && $post->status === 'published') {
            NotifySubscribersOfPublishedPost::dispatch($post);
        }

        return redirect()->route('posts.show', $post->slug)
            ->with('success', 'Post updated successfully!');
    }

    /**
     * Remove the specified post (authors can delete their own posts)
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        
        // Check if the user owns this post
        if ($post->author_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }

        // Delete featured image if exists
        if ($post->featured_image) {
            $deleted = false;
            
            // Try multiple approaches to delete the image
            if (Storage::disk('public')->exists($post->featured_image)) {
                Storage::disk('public')->delete($post->featured_image);
                $deleted = true;
            } elseif (Storage::disk('public')->exists(str_replace('storage/', '', $post->featured_image))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $post->featured_image));
                $deleted = true;
            } elseif (Storage::exists(str_replace('storage/', 'public/', $post->featured_image))) {
                Storage::delete(str_replace('storage/', 'public/', $post->featured_image));
                $deleted = true;
            }
            
            if (!$deleted) {
                Log::warning('Could not delete image for post: ' . $post->id);
            }
        }

        // Delete related data
        $post->allComments()->delete();
        $post->likes()->delete();
        $post->reviews()->delete();

        // Clean up Redis counters
        try {
            Redis::del("views:{$post->id}");
            Redis::del("likes:{$post->id}");
        } catch (\Exception $e) {
            Log::warning('Redis cleanup failed: ' . $e->getMessage());
        }

        $post->delete();

        // Clear ALL caches
        $this->clearAllCaches();

        return redirect()->route('home')
            ->with('success', 'Post deleted successfully!');
    }

    /**
     * Calculate reading time from content
     */
    private function calculateReadingTime($content)
    {
        $wordCount = str_word_count(strip_tags($content));
        $minutes = ceil($wordCount / 200);
        return max(1, $minutes);
    }

    /**
     * Clear ALL application caches
     */
    private function clearAllCaches()
    {
        // Clear home page cache
        try {
            \App\Http\Controllers\HomeController::clearCache();
        } catch (\Exception $e) {
            Log::warning('Home cache clear failed: ' . $e->getMessage());
        }
        
        // Clear blog listing caches
        Cache::forget('posts_static');
        Cache::forget('search-index');
        Cache::forget('author_count');
        Cache::forget('categories');
        Cache::forget('popular_posts');
        Cache::forget('latest_posts');
        Cache::forget('home_reviews');
        
        // Clear tag-based caches
        try {
            Cache::tags(['blog'])->flush();
        } catch (\Exception $e) {
            // Tags not supported - already cleared individual keys
        }
        
        // Clear Redis keys
        try {
            $keys = Redis::keys('post:*');
            foreach ($keys as $key) {
                Cache::forget($key);
            }
        } catch (\Exception $e) {
            // Redis not available or pattern not supported
        }
    }

    /**
     * Track reading time for a post (AJAX endpoint)
     */
    public function trackRead(Request $request, $id)
    {
        $validated = $request->validate([
            'duration' => 'required|integer|min:1|max:7200',
        ]);

        $post = Post::find($id);
        if (!$post) {
            return response()->json(['error' => 'Post not found'], 404);
        }

        // Increment reading time
        $post->increment('reading_time', $validated['duration']);

        return response()->json([
            'success' => true,
            'message' => 'Reading time tracked successfully',
            'new_value' => $post->fresh()->reading_time
        ]);
    }
}