<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function index()
    {
        // Fetch all published posts
        $posts = Post::with(['author', 'category'])
            ->where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->get();

        // Fetch popular posts (by views)
        $popularPosts = Post::where('status', 'published')
            ->orderBy('views', 'desc')
            ->limit(4)
            ->get();

        // Get post count
        $postCount = Post::where('status', 'published')->count();

        // Get total views
        $totalViews = Post::sum('views');

        // Get author count
        $authorCount = DB::table('users')->count();

        // Get all categories for the filter bar
        $categories = Category::orderBy('name')->get();

        // Get all posts for search (pass as JSON to Alpine)
        $allPosts = $posts->map(function ($post) {
            return [
                'id' => $post->id,
                'title' => $post->title,
                'slug' => $post->slug,
                'excerpt' => $post->excerpt,
                'views' => $post->views,
            ];
        });

        return view('posts.index', compact('posts', 'popularPosts', 'postCount', 'totalViews', 'authorCount', 'allPosts', 'categories'));
    }

    public function show($slug)
    {
        $post = Post::with(['author', 'category'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->first();

        if (is_null($post)) {
            abort(404);
        }

        // Increment views
        $post->increment('views');

        // Get all posts for search
        $allPosts = Post::where('status', 'published')
            ->get()
            ->map(function ($p) {
                return [
                    'id' => $p->id,
                    'title' => $p->title,
                    'slug' => $p->slug,
                    'excerpt' => $p->excerpt,
                    'views' => $p->views,
                ];
            });

        return view('posts.show', compact('post', 'allPosts'));
    }
}