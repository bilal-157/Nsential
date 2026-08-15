<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;

class PostCacheService
{
    protected const PREFIX     = 'post_detail:';
    protected const LRU_KEY    = 'post_detail:lru_index';
    protected const MAX_CACHED = 50;
    protected const TTL        = 21600; // 6 hours
    
    // View counter constants
    protected const VIEWS_PREFIX = 'post_views:';
    protected const VIEWS_SYNC_INTERVAL = 600; // 10 minutes
    protected const VIEWS_SYNC_BATCH = 10; // Sync every 10 views

    public function get(int $postId): ?array
    {
        $data = Cache::get(self::PREFIX . $postId);
        if (!$data) {
            return null;
        }
        $this->touch($postId);
        return $data;
    }

    public function put(int $postId, array $data): void
    {
        Cache::put(self::PREFIX . $postId, $data, self::TTL);
        $this->touch($postId);
        $this->evictIfNeeded();
    }

    public function forget(int $postId): void
    {
        Cache::forget(self::PREFIX . $postId);
        $this->removeFromLRU($postId);
    }

    protected function touch(int $postId): void
    {
        $lruKey = config('cache.prefix') . '_' . self::LRU_KEY;
        Redis::connection()->zadd($lruKey, now()->timestamp, $postId);
    }

    protected function evictIfNeeded(): void
    {
        $lruKey = config('cache.prefix') . '_' . self::LRU_KEY;
        $redis = Redis::connection();
        $count = $redis->zcard($lruKey);
        
        if ($count > self::MAX_CACHED) {
            $excess = $count - self::MAX_CACHED;
            $oldest = $redis->zrange($lruKey, 0, $excess - 1);
            foreach ($oldest as $id) {
                Cache::forget(self::PREFIX . $id);
                $redis->zrem($lruKey, $id);
            }
        }
    }

    protected function removeFromLRU(int $postId): void
    {
        $lruKey = config('cache.prefix') . '_' . self::LRU_KEY;
        Redis::connection()->zrem($lruKey, $postId);
    }

    /**
     * Build the full cache payload for a post including ALL data:
     * - Post content (title, body, excerpt, etc.)
     * - Author information (name, bio, avatar, etc.)
     * - Category information (name, slug, description, etc.)
     * - Comments with user data
     * - Reviews with user data
     * - Likes, ratings, and all metadata
     */
    public function buildPayload(Post $post): array
    {
        $comments = $post->comments()
            ->whereNull('parent_comment_id')
            ->with(['user', 'replies.user'])
            ->orderBy('created_at', 'desc')
            ->get();

        $reviews = $post->reviews()->with('user')->latest()->get();

        // Get current view count from Redis (if available)
// Get current view count from Redis, or seed from database if empty
$viewKey = self::VIEWS_PREFIX . $post->id;
$redis = Redis::connection();
$views = $redis->get($viewKey);

if ($views === null) {
    // Redis is empty - seed it from database
    $views = $post->views;
    $redis->set($viewKey, $views);
    
    \Illuminate\Support\Facades\Log::info('Seeded Redis views for post ' . $post->id . ' with ' . $views);
}

        return [
            // === POST DATA ===
            'id' => $post->id,
            'title' => $post->title,
            'slug' => $post->slug,
            'content' => $post->content,
            'excerpt' => $post->excerpt,
            'status' => $post->status,
            'views' => (int) $views,
            'featured_image' => $post->featured_image ? asset('storage/' . str_replace(['storage/', 'public/'], '', $post->featured_image)) : null,
            'featured_image_raw' => $post->featured_image,
            'published_at' => $post->published_at ? $post->published_at->format('M d, Y') : null,
            'published_at_raw' => $post->published_at ? $post->published_at->toDateTimeString() : null,
            'created_at' => $post->created_at ? $post->created_at->toDateTimeString() : null,
            'updated_at' => $post->updated_at ? $post->updated_at->toDateTimeString() : null,
            'reading_time' => $post->reading_time ?? 0,
            
            // === AUTHOR DATA ===
            'author' => $post->author ? [
                'id' => $post->author->id,
                'name' => $post->author->name,
                'email' => $post->author->email,
                'bio' => $post->author->bio ?? null,
                'avatar' => $post->author->avatar ?? null,
                'website' => $post->author->website ?? null,
                'twitter' => $post->author->twitter ?? null,
                'github' => $post->author->github ?? null,
                'created_at' => $post->author->created_at ? $post->author->created_at->toDateTimeString() : null,
            ] : null,
            
            // === CATEGORY DATA ===
            'category' => $post->category ? [
                'id' => $post->category->id,
                'name' => $post->category->name,
                'slug' => $post->category->slug,
                'description' => $post->category->description ?? null,
                'color' => $post->category->color ?? null,
                'icon' => $post->category->icon ?? null,
            ] : null,
            
            // === META DATA (Interactive Elements) ===
            'likes_count' => $post->likes_count,
            'comments_count' => $post->comments_count,
            'comments' => $comments->toArray(),
            'reviews' => $reviews->toArray(),
            'average_rating' => (float) $post->averageRating(),
            'reviews_count' => (int) $post->reviewsCount(),
            'rating_distribution' => $post->getRatingDistribution(),
            
            // === CACHE METADATA ===
            'is_full_cache' => true,
            'cached_at' => now()->toDateTimeString(),
            'cache_version' => '1.0',
        ];
    }

    /**
     * Get a post from cache by slug
     * This checks if the post is cached and returns the full data
     */
    public function getBySlug(string $slug): ?array
    {
        $post = \App\Models\Post::where('slug', $slug)->first(['id']);
        if (!$post) {
            return null;
        }
        return $this->get($post->id);
    }

    /**
     * Check if a post is cached
     */
    public function isCached(int $postId): bool
    {
        return Cache::has(self::PREFIX . $postId);
    }

    /**
     * Get cached post data for view (returns full array or null)
     */
    public function getForView(int $postId): ?array
    {
        $data = $this->get($postId);
        if (!$data) {
            return null;
        }
        
        $defaults = [
            'title' => 'Untitled',
            'content' => '',
            'excerpt' => '',
            'status' => 'draft',
            'views' => 0,
            'author' => null,
            'category' => null,
            'featured_image' => null,
        ];
        
        return array_merge($defaults, $data);
    }

    /**
     * Increment views using Redis atomic counter
     * This is much faster than database updates
     */
    /**
 * Increment views using Redis atomic counter
 * Always seeds from database if Redis counter is missing
 */
public function incrementViews(int $postId): void
{
    $viewKey = self::VIEWS_PREFIX . $postId;
    $redis = Redis::connection();
    
    // Check if Redis counter exists
    if (!$redis->exists($viewKey)) {
        // Seed from database to prevent resetting to 0
        $dbViews = Post::where('id', $postId)->value('views') ?? 0;
        $redis->set($viewKey, $dbViews);
        $views = $dbViews;
        
        \Illuminate\Support\Facades\Log::info('Seeded Redis counter for post ' . $postId . ' with ' . $views . ' views from database');
    } else {
        // Increment existing counter
        $views = $redis->incr($viewKey);
    }
    
    // Update cache immediately
    $data = $this->get($postId);
    if ($data) {
        $data['views'] = $views;
        $this->put($postId, $data);
    }
    
    // Sync to database every 10 views or 10 minutes
    $lastSyncKey = self::VIEWS_PREFIX . 'last_sync:' . $postId;
    $lastSync = $redis->get($lastSyncKey) ?? 0;
    $now = time();
    
    $shouldSync = ($views % self::VIEWS_SYNC_BATCH === 0) || 
                  ($now - $lastSync > self::VIEWS_SYNC_INTERVAL) ||
                  ($lastSync == 0 && $views > 0);
    
    if ($shouldSync) {
        Post::where('id', $postId)->update(['views' => $views]);
        $redis->set($lastSyncKey, $now);
        
        \Illuminate\Support\Facades\Log::info('Synced views for post ' . $postId . ' to database: ' . $views);
    }
}

    /**
     * Sync views to database only when needed (reduces DB writes)
     */
    protected function maybeSyncViews(int $postId, int $views): void
    {
        $lastSyncKey = self::VIEWS_PREFIX . 'last_sync:' . $postId;
        $lastSync = Redis::connection()->get($lastSyncKey) ?? 0;
        $now = time();
        
        // Sync if:
        // 1. Every 100 views
        // 2. Every 10 minutes
        // 3. If views > 0 and never synced
        $shouldSync = ($views % self::VIEWS_SYNC_BATCH === 0) || 
                      ($now - $lastSync > self::VIEWS_SYNC_INTERVAL) ||
                      ($lastSync == 0 && $views > 0);
        
        if ($shouldSync) {
            Post::where('id', $postId)->update(['views' => $views]);
            Redis::connection()->set($lastSyncKey, $now);
        }
    }

    /**
     * Get current view count from Redis or database
     */
    public function getViews(int $postId): int
    {
        $viewKey = self::VIEWS_PREFIX . $postId;
        $views = Redis::connection()->get($viewKey);
        
        if ($views !== null) {
            return (int) $views;
        }
        
        // Fallback to database
        $post = Post::find($postId);
        return $post ? $post->views : 0;
    }

    // ------------------------------------------------------------------
    // Targeted patches — called right after each write in the relevant
    // controller so the cache is kept in sync without a full rebuild.
    // Each one is a no-op if the post isn't currently cached (cache miss
    // will just rebuild fresh from the DB on the next `show`).
    // ------------------------------------------------------------------

    public function setLikes(int $postId, int $likesCount): void
    {
        $this->patch($postId, ['likes_count' => $likesCount]);
    }

    public function addComment(int $postId, array $comment, ?int $parentId = null): void
    {
        $data = $this->get($postId);
        if (!$data) return;

        if ($parentId) {
            foreach ($data['comments'] as &$c) {
                if ($c['id'] == $parentId) {
                    $c['replies'][] = $comment;
                    break;
                }
            }
        } else {
            array_unshift($data['comments'], $comment);
        }

        $data['comments_count'] = ($data['comments_count'] ?? 0) + 1;
        $this->put($postId, $data);
    }

    public function updateComment(int $postId, int $commentId, string $content): void
    {
        $data = $this->get($postId);
        if (!$data) return;

        $this->walkComments($data['comments'], function (&$c) use ($commentId, $content) {
            if ($c['id'] == $commentId) $c['content'] = $content;
        });

        $this->put($postId, $data);
    }

    public function deleteComment(int $postId, int $commentId): void
    {
        $data = $this->get($postId);
        if (!$data) return;

        $removed = 0;
        $data['comments'] = $this->removeComment($data['comments'], $commentId, $removed);
        $data['comments_count'] = max(0, ($data['comments_count'] ?? 0) - $removed);
        $this->put($postId, $data);
    }

    public function upsertReview(int $postId, array $review, float $avg, int $count, array $dist): void
    {
        $data = $this->get($postId);
        if (!$data) return;

        $found = false;
        foreach ($data['reviews'] as &$r) {
            if ($r['id'] == $review['id']) { $r = $review; $found = true; break; }
        }
        if (!$found) array_unshift($data['reviews'], $review);

        $data['average_rating'] = $avg;
        $data['reviews_count'] = $count;
        $data['rating_distribution'] = $dist;
        $this->put($postId, $data);
    }

    public function deleteReview(int $postId, int $reviewId, float $avg, int $count, array $dist): void
    {
        $data = $this->get($postId);
        if (!$data) return;

        $data['reviews'] = array_values(array_filter($data['reviews'], fn($r) => $r['id'] != $reviewId));
        $data['average_rating'] = $avg;
        $data['reviews_count'] = $count;
        $data['rating_distribution'] = $dist;
        $this->put($postId, $data);
    }

    protected function patch(int $postId, array $fields): void
    {
        $data = $this->get($postId);
        if (!$data) return;
        $this->put($postId, array_merge($data, $fields));
    }

    protected function walkComments(array &$comments, callable $fn): void
    {
        foreach ($comments as &$c) {
            $fn($c);
            if (!empty($c['replies'])) $this->walkComments($c['replies'], $fn);
        }
    }

    protected function removeComment(array $comments, int $id, int &$removed): array
    {
        $out = [];
        foreach ($comments as $c) {
            if ($c['id'] == $id) {
                $removed += 1 + count($c['replies'] ?? []);
                continue;
            }
            if (!empty($c['replies'])) {
                $c['replies'] = $this->removeComment($c['replies'], $id, $removed);
            }
            $out[] = $c;
        }
        return $out;
    }
}