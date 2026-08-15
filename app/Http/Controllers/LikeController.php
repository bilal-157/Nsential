<?php
// app/Http/Controllers/LikeController.php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Services\PostCacheService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggle(Post $post, PostCacheService $postCache)
    {
        if (!Auth::check()) {
            return response()->json([
                'error' => 'You must be logged in to like a post'
            ], 401);
        }

        $isLiked = $post->toggleLike(Auth::id());

        // Refresh from DB rather than trusting an in-memory counter — this
        // guards against races where `$post->likes_count` on the loaded
        // model is stale relative to what toggleLike() just wrote.
        $likesCount = $post->fresh()->likes_count;

        // ---- keep Redis cache in sync ----
        $postCache->setLikes($post->id, $likesCount);

        return response()->json([
            'success' => true,
            'liked' => $isLiked,
            'likes_count' => $likesCount
        ]);
    }

    public function getLikes(Post $post)
    {
        return response()->json([
            'likes_count' => $post->likes_count,
            'is_liked' => $post->isLikedByUser(Auth::id())
        ]);
    }
}