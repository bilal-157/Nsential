<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostManagementController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminPostController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ContactController;

// =============================================
// RATE LIMITING (Laravel-level - fine-tuning)
// Note: Nginx handles global rate limiting
// =============================================
RateLimiter::for('api', function ($job) {
    return Limit::perMinute(60)->by($job->user()?->id ?: $job->ip());
});

RateLimiter::for('auth', function ($job) {
    return Limit::perMinute(5)->by($job->ip());
});

// =============================================
// GOOGLE AUTH ROUTES
// =============================================
Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleController::class, 'callback']);

// =============================================
// PROFILE ROUTES
// =============================================
Route::middleware(['auth', 'verified', 'author'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// =============================================
// PUBLIC ROUTES
// =============================================
Route::view('/about', 'about')->name('about');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.submit');

// Home route with cache
Route::get('/', [HomeController::class, 'index'])
    ->middleware('cache.headers:public;max_age=3600;etag')
    ->name('home');

// =============================================
// DASHBOARD ROUTE
// =============================================
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// =============================================
// POST MANAGEMENT ROUTES (Author only)
// =============================================
Route::middleware(['auth', 'verified', 'author'])->prefix('posts')->name('posts.')->group(function () {
    Route::get('/create', [PostManagementController::class, 'create'])->name('create');
    Route::post('/', [PostManagementController::class, 'store'])->name('store');
    Route::get('/draft/{slug}', [PostController::class, 'draft'])->name('draft');
    Route::get('/{post}/edit', [PostManagementController::class, 'edit'])->name('edit');
    Route::put('/{post}', [PostManagementController::class, 'update'])->name('update');
    Route::delete('/{post}', [PostManagementController::class, 'destroy'])->name('destroy');
});

// =============================================
// COMMENT ROUTES
// =============================================
Route::get('/posts/{post}/comments', [CommentController::class, 'index'])->name('comments.index');

Route::post('/posts/{post}/comments', [CommentController::class, 'store'])
    ->middleware(['auth', 'verified'])
    ->name('comments.store');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

// =============================================
// LIKE ROUTES
// =============================================
Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/posts/{post}/like', [LikeController::class, 'toggle'])->name('posts.like');
    Route::get('/posts/{post}/likes', [LikeController::class, 'getLikes'])->name('posts.likes');
});

// =============================================
// REVIEW ROUTES
// =============================================
Route::get('/posts/{post}/reviews', [ReviewController::class, 'index'])->name('reviews.index');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/posts/{post}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});

// =============================================
// POST READ-TIME TRACKING
// =============================================
Route::post('/posts/{id}/track-read', [PostManagementController::class, 'trackRead'])->name('posts.track-read');

// =============================================
// ADMIN ROUTES
// =============================================
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // User Management
    Route::resource('users', UserController::class)->except(['show']);
    
    // Post Management
    Route::get('/posts', [AdminPostController::class, 'index'])->name('posts.index');
    Route::get('/posts/create', [AdminPostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [AdminPostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}/edit', [AdminPostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [AdminPostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [AdminPostController::class, 'destroy'])->name('posts.destroy');
    
    // Analytics
    Route::get('/analytics', [AnalyticsController::class, 'index'])->name('analytics.index');
    Route::get('/posts/{post}/analytics', [AdminPostController::class, 'analytics'])->name('posts.analytics');
    
    // Bulk action
    Route::post('/posts/bulk', [AdminPostController::class, 'bulkAction'])->name('posts.bulk');
    
    // Comment Management
    Route::get('/comments', [CommentController::class, 'adminIndex'])->name('comments.index');
    Route::post('/comments/{comment}/toggle-approval', [CommentController::class, 'adminToggleApproval'])->name('comments.toggle-approval');
});

// =============================================
// BREEZE AUTH ROUTES
// =============================================
require __DIR__.'/auth.php';

// =============================================
// FRONTEND POST VIEW ROUTE (MUST BE LAST!)
// =============================================
Route::get('/{slug}', [PostController::class, 'show'])
    ->middleware('cache.headers:public;max_age=3600;etag')
    ->name('posts.show');