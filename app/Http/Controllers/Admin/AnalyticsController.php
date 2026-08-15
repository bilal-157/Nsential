<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;

class AnalyticsController extends Controller
{
    public function index()
    {
        // Overall summary numbers
        $summary = [
            'total_posts'       => Post::count(),
            'total_views'       => Post::sum('views'),
            'total_comments'    => Post::withCount('allComments')->get()->sum('all_comments_count'),
            'total_likes'       => Post::withCount('likes')->get()->sum('likes_count'),
            'total_reviews'     => Post::withCount('reviews')->get()->sum('reviews_count'),
            'avg_rating'        => round(\App\Models\Review::avg('rating') ?? 0, 2),
            'avg_reading_time'  => round(Post::avg('reading_time') ?? 0),
        ];

        // Views trend, last 30 days (for a line chart)
        $viewsTrend = Post::selectRaw('DATE(created_at) as date, SUM(views) as total_views, COUNT(*) as post_count')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Reading time trend, last 30 days (for a line chart)
        $readingTimeTrend = Post::selectRaw('DATE(created_at) as date, AVG(reading_time) as avg_reading_time')
            ->where('created_at', '>=', now()->subDays(30))
            ->whereNotNull('reading_time')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Full data table: every post with all its metrics, sorted by views
        $allPosts = Post::withCount(['allComments', 'likes', 'reviews'])
            ->withAvg('reviews', 'rating')
            ->with('category')
            ->orderByDesc('views')
            ->get();

        // Performance by category (views)
        $categoryPerformance = Category::withCount('posts')
            ->get()
            ->map(function ($category) {
                $category->total_views = Post::where('category_id', $category->id)->sum('views');
                return $category;
            })
            ->sortByDesc('total_views')
            ->values();

        // Reading time by category
        $readingTimeByCategory = Category::withCount('posts')
            ->get()
            ->map(function ($category) {
                $category->avg_reading_time = round(
                    Post::where('category_id', $category->id)->avg('reading_time') ?? 0
                );
                return $category;
            })
            ->sortByDesc('avg_reading_time')
            ->values();

        return view('admin.analytics.index', compact(
            'summary',
            'viewsTrend',
            'readingTimeTrend',
            'allPosts',
            'categoryPerformance',
            'readingTimeByCategory'
        ));
    }
}