<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostManagementController;
use App\Http\Controllers\Auth\GoogleController;



Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('auth.google');
Route::get('/auth/google/callback', [GoogleController::class, 'callback']);

//profile edit


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Home route
Route::get('/', [PostController::class, 'index'])->name('home');

// Dashboard route
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// Post Management Routes
Route::get('/posts/create', [PostManagementController::class, 'create'])->name('posts.create');
Route::post('/posts', [PostManagementController::class, 'store'])->name('posts.store');
Route::get('/posts/{id}/edit', [PostManagementController::class, 'edit'])->name('posts.edit');
Route::put('/posts/{id}', [PostManagementController::class, 'update'])->name('posts.update');
Route::delete('/posts/{id}', [PostManagementController::class, 'destroy'])->name('posts.destroy');

// Post view route (this should be LAST)
Route::get('/posts/{slug}', [PostController::class, 'show'])->name('posts.show');

// IMPORTANT: Include Breeze Auth Routes - THIS MUST BE THE LAST LINE
require __DIR__.'/auth.php';
