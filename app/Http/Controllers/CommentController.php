<?php
// app/Http/Controllers/CommentController.php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Services\PostCacheService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function index(Post $post)
    {
        $comments = Comment::forPost($post->id)
                          ->topLevel()
                          ->with(['user', 'replies.user'])
                          ->orderBy('created_at', 'desc')
                          ->get();

        return response()->json([
            'comments' => $comments,
            'total' => $post->comments_count,
        ]);
    }

    public function store(Request $request, Post $post, PostCacheService $postCache)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required|string|min:2|max:1000',
            'parent_comment_id' => 'nullable|exists:comments,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $comment = new Comment();
        $comment->post_id = $post->id;
        $comment->user_id = Auth::id();
        $comment->content = $request->content;

        if ($request->has('parent_comment_id')) {
            $comment->parent_comment_id = $request->parent_comment_id;
        }

        $comment->save();

        // Load user relationship for response
        $comment->load('user');

        // ---------------------------------------------------------------
        // Keep the Redis per-post cache in sync: insert this comment (or
        // reply) into the cached tree and bump comments_count. If the post
        // isn't currently cached this is a safe no-op — it'll be rebuilt
        // fresh from the DB next time someone opens the post.
        // ---------------------------------------------------------------
        $postCache->addComment(
            $post->id,
            $comment->toArray(),
            $request->parent_comment_id
        );

        return response()->json([
            'success' => true,
            'message' => 'Comment posted successfully!',
            'comment' => $comment
        ], 201);
    }

    public function update(Request $request, Comment $comment, PostCacheService $postCache)
    {
        // Check if user owns the comment
        if (Auth::id() !== $comment->user_id) {
            return response()->json([
                'error' => 'Unauthorized to edit this comment'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'content' => 'required|string|min:2|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $comment->update([
            'content' => $request->content
        ]);

        // ---- keep Redis cache in sync ----
        $postCache->updateComment($comment->post_id, $comment->id, $comment->content);

        return response()->json([
            'success' => true,
            'message' => 'Comment updated successfully!',
            'comment' => $comment
        ]);
    }

    public function destroy(Comment $comment, PostCacheService $postCache)
    {
        // Check if user owns the comment
        if (Auth::id() !== $comment->user_id) {
            return response()->json([
                'error' => 'Unauthorized to delete this comment'
            ], 403);
        }

        // Capture these before the model is deleted
        $postId = $comment->post_id;
        $commentId = $comment->id;

        // Delete all replies first
        $comment->replies()->delete();
        $comment->delete();

        // ---- keep Redis cache in sync (removes comment + its replies,
        // adjusts comments_count accordingly) ----
        $postCache->deleteComment($postId, $commentId);

        return response()->json([
            'success' => true,
            'message' => 'Comment deleted successfully!'
        ]);
    }
}