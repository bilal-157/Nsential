<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Review;
use App\Models\PostLike;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users'     => User::count(),
            'total_posts'     => Post::count(),
            'published_posts' => Post::where('status', 'published')->count(),
            'draft_posts'     => Post::where('status', 'draft')->count(),
            'total_comments'  => Comment::count(),
            'total_likes'     => PostLike::count(),
            'total_reviews'   => Review::count(),
            'total_views'     => Post::sum('views'),
        ];

        $recentComments = Comment::with(['user', 'post'])
            ->latest()
            ->limit(5)
            ->get();

        $recentReviews = Review::with(['user', 'post'])
            ->latest()
            ->limit(5)
            ->get();

        $topPosts = Post::where('status', 'published')
            ->orderBy('views', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentComments', 'recentReviews', 'topPosts'));
    }
}