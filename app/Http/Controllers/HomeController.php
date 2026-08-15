<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Review;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index()
    {
        try {
            // Get cached data or generate it
            $cachedData = $this->getCachedHomeData();
            
            $postsArray = $cachedData['posts_array'];
            $posts = new LengthAwarePaginator(
                collect($postsArray['data']),
                $postsArray['total'],
                $postsArray['per_page'],
                $postsArray['current_page'],
                ['path' => request()->url(), 'pageName' => 'page']
            );
            
            if (!empty($postsArray['data'])) {
                $items = $posts->items();
                $items = array_map(function ($post) {
                    try {
                        $pendingViews = (int) Redis::get("views:{$post['id']}") ?? 0;
                        $post['views'] = ($post['views'] ?? 0) + $pendingViews;
                    } catch (\Exception $e) {
                        // Redis not available, use post views only
                    }
                    return $post;
                }, $items);
                $posts->setCollection(collect($items));
            }
            
            return view('posts.index', [
                'posts' => $posts,
                'categories' => $cachedData['categories'],
                'popularPosts' => $cachedData['popularPosts'],
                'allReviews' => $cachedData['allReviews'],
                'postCount' => $cachedData['postCount'],
                'totalViews' => $cachedData['totalViews'],
                'authorCount' => $cachedData['authorCount'],
                'featuredPost' => $cachedData['featuredPost'],
                'heroStats' => $cachedData['heroStats'],
            ]);
            
        } catch (\Exception $e) {
            Log::error('HomeController error: ' . $e->getMessage());
            // Fallback: return empty data
            return view('posts.index', [
                'posts' => new LengthAwarePaginator([], 0, 9, 1, ['path' => request()->url()]),
                'categories' => [],
                'popularPosts' => [],
                'allReviews' => [],
                'postCount' => 0,
                'totalViews' => 0,
                'authorCount' => 0,
                'featuredPost' => null,
                'heroStats' => [
                    ['value' => '0', 'label' => 'Articles'],
                    ['value' => '0', 'label' => 'Topics'],
                    ['value' => '0', 'label' => 'Reads'],
                ],
            ]);
        }
    }

    /**
     * Get cached home data or generate it
     */
    private function getCachedHomeData()
    {
        return Cache::remember('home_data', 3600, function () {
            Log::info('Cache miss - regenerating home_data');
            
            try {
                $posts = Post::with(['author', 'category'])
                    ->where('status', 'published')
                    ->latest('published_at')
                    ->paginate(9);
                
                $postsArray = [
                    'data' => $posts->items(),
                    'total' => $posts->total(),
                    'per_page' => $posts->perPage(),
                    'current_page' => $posts->currentPage(),
                    'last_page' => $posts->lastPage(),
                    'from' => $posts->firstItem(),
                    'to' => $posts->lastItem(),
                ];
                
                $postsArray['data'] = array_map(function ($post) {
                    $imageUrl = null;
                    if ($post->featured_image) {
                        $cleanPath = str_replace(['storage/', 'public/'], '', $post->featured_image);
                        $imageUrl = asset('storage/' . $cleanPath);
                    }
                    
                    return [
                        'id' => $post->id,
                        'title' => $post->title,
                        'slug' => $post->slug,
                        'excerpt' => $post->excerpt,
                        'content' => $post->content,
                        'image' => $imageUrl,
                        'published_at' => $post->published_at ? $post->published_at->format('M d, Y') : null,
                        'views' => $post->views,
                        'category' => $post->category ? [
                            'name' => $post->category->name,
                            'slug' => $post->category->slug,
                        ] : null,
                        'author' => $post->author ? [
                            'name' => $post->author->name,
                        ] : null,
                    ];
                }, $postsArray['data']);
                
                // Categories
                $categories = Category::orderBy('name')->get()->map(function ($cat) {
                    return ['name' => $cat->name, 'slug' => $cat->slug];
                })->toArray();
                
                // Popular posts
                $popularPosts = Post::with('category')
                    ->where('status', 'published')
                    ->orderBy('views', 'desc')
                    ->limit(5)
                    ->get()
                    ->map(function ($post) {
                        $imageUrl = null;
                        if ($post->featured_image) {
                            $cleanPath = str_replace(['storage/', 'public/'], '', $post->featured_image);
                            $imageUrl = asset('storage/' . $cleanPath);
                        }
                        
                        return [
                            'id' => $post->id,
                            'title' => $post->title,
                            'slug' => $post->slug,
                            'excerpt' => $post->excerpt,
                            'content' => $post->content,
                            'image' => $imageUrl,
                            'published_at' => $post->published_at ? $post->published_at->format('M d, Y') : null,
                            'views' => $post->views,
                            'category' => $post->category ? [
                                'name' => $post->category->name,
                                'slug' => $post->category->slug,
                            ] : null,
                        ];
                    })
                    ->toArray();
                
                // Reviews
                $allReviews = Review::with(['user', 'post'])
                    ->whereHas('post', function ($query) {
                        $query->where('status', 'published');
                    })
                    ->whereNotNull('review_text')
                    ->where('review_text', '!=', '')
                    ->latest()
                    ->limit(20)
                    ->get()
                    ->map(function ($review) {
                        return [
                            'rating' => $review->rating,
                            'review_text' => $review->review_text,
                            'created_at' => $review->created_at ? $review->created_at->diffForHumans() : null,
                            'user' => ['name' => $review->user?->name ?? 'Anonymous'],
                            'post' => [
                                'title' => $review->post?->title ?? '',
                                'slug' => $review->post?->slug ?? '',
                            ],
                        ];
                    })
                    ->toArray();
                
                // Featured post
                $featuredPost = Post::with('category')
                    ->where('status', 'published')
                    ->latest('published_at')
                    ->first();
                
                $featuredPostData = $featuredPost ? [
                    'id' => $featuredPost->id,
                    'title' => $featuredPost->title,
                    'slug' => $featuredPost->slug,
                    'excerpt' => $featuredPost->excerpt,
                    'content' => $featuredPost->content,
                    'image' => $featuredPost->featured_image ? asset('storage/' . str_replace(['storage/', 'public/'], '', $featuredPost->featured_image)) : null,
                    'published_at' => $featuredPost->published_at ? $featuredPost->published_at->format('M d, Y') : null,
                    'views' => $featuredPost->views,
                    'category' => $featuredPost->category ? [
                        'name' => $featuredPost->category->name,
                        'slug' => $featuredPost->category->slug,
                    ] : null,
                ] : null;
                
                $postCount = Post::where('status', 'published')->count();
                $totalViews = Post::sum('views');
                $authorCount = Post::where('status', 'published')
                    ->distinct('author_id')
                    ->count('author_id');
                
                $heroStats = [
                    ['value' => number_format($postCount), 'label' => 'Articles'],
                    ['value' => number_format(count($categories)), 'label' => 'Topics'],
                    ['value' => number_format($totalViews), 'label' => 'Reads'],
                ];
                
                $result = [
                    'posts_array' => $postsArray,
                    'categories' => $categories,
                    'popularPosts' => $popularPosts,
                    'allReviews' => $allReviews,
                    'postCount' => $postCount,
                    'totalViews' => $totalViews,
                    'authorCount' => $authorCount,
                    'featuredPost' => $featuredPostData,
                    'heroStats' => $heroStats,
                ];
                
                Log::info('Cache data generated successfully');
                return $result;
                
            } catch (\Exception $e) {
                Log::error('Error generating cache data: ' . $e->getMessage());
                return [
                    'posts_array' => ['data' => [], 'total' => 0, 'per_page' => 9, 'current_page' => 1, 'last_page' => 1, 'from' => null, 'to' => null],
                    'categories' => [],
                    'popularPosts' => [],
                    'allReviews' => [],
                    'postCount' => 0,
                    'totalViews' => 0,
                    'authorCount' => 0,
                    'featuredPost' => null,
                    'heroStats' => [
                        ['value' => '0', 'label' => 'Articles'],
                        ['value' => '0', 'label' => 'Topics'],
                        ['value' => '0', 'label' => 'Reads'],
                    ],
                ];
            }
        });
    }
    
    public static function clearCache()
    {
        Cache::forget('home_data');
        Cache::forget('popular_posts');
        Cache::forget('latest_posts');
        Cache::forget('categories');
        Cache::forget('home_reviews');
        Log::info('Cache cleared from HomeController');
    }
}