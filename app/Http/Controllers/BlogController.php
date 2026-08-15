<?php
// app/Http/Controllers/BlogController.php

use Illuminate\Support\Facades\Cache;

class BlogController extends Controller
{
public function index()
{
    $page = request('page', 1);

    $posts = Cache::tags(['blog'])->remember("posts_page_{$page}", 120, function () {
        return Post::with('category')
            ->where('status', 'published')
            ->latest('published_at')
            ->paginate(9);
    });

    $categories = Cache::tags(['blog'])->remember('categories', 3600, function () {
        return Category::all();
    });

    $popularPosts = Cache::tags(['blog'])->remember('popular_posts', 600, function () {
        return Post::orderBy('views', 'desc')->limit(5)->get();
    });

    $postCount = Cache::tags(['blog'])->remember('post_count', 3600, function () {
        return Post::where('status', 'published')->count();
    });

    $totalViews = Cache::tags(['blog'])->remember('total_views', 600, function () {
        return Post::sum('views');
    });

    return view('blog.index', compact('posts', 'categories', 'popularPosts', 'postCount', 'totalViews'));
}
}