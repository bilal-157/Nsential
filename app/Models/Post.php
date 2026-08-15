<?php
// app/Models/Post.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'featured_image',
        'status',
        'views',
        'reading_time',
        'published_at',
        'author_id',
        'category_id',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // Comments relationships
    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNull('parent_comment_id');
    }

    public function allComments()
    {
        return $this->hasMany(Comment::class);
    }

    public function getCommentsCountAttribute()
    {
        return $this->allComments()->count();
    }

    // Likes relationships
    public function likes()
    {
        return $this->hasMany(PostLike::class);
    }

    public function likedByUsers()
    {
        return $this->belongsToMany(User::class, 'post_likes', 'post_id', 'user_id')
                    ->withTimestamps();
    }

    public function getLikesCountAttribute()
    {
        return $this->likes()->count();
    }

    public function isLikedByUser($userId = null)
    {
        if (!$userId) {
            $userId = auth()->id();
        }
        
        if (!$userId) {
            return false;
        }

        return $this->likes()->where('user_id', $userId)->exists();
    }

    // Toggle like
    public function toggleLike($userId = null)
    {
        if (!$userId) {
            $userId = auth()->id();
        }

        if (!$userId) {
            return false;
        }

        $like = $this->likes()->where('user_id', $userId)->first();
        
        if ($like) {
            $like->delete();
            return false; // Unliked
        } else {
            $this->likes()->create(['user_id' => $userId]);
            return true; // Liked
        }
    }

    // Reading time calculation
    public function calculateReadingTime()
    {
        $words = str_word_count(strip_tags($this->content));
        $minutes = ceil($words / 200);
        return $minutes > 0 ? $minutes : 1;
    }

    // ===================== REVIEWS RELATIONSHIPS =====================
    
    /**
     * Get all reviews for this post
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get the average rating for this post
     */
    public function averageRating()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    /**
     * Get the total number of reviews for this post
     */
    public function reviewsCount()
    {
        return $this->reviews()->count();
    }

    /**
     * Get the review for the currently authenticated user
     */
    public function userReview()
    {
        return $this->hasOne(Review::class)->where('user_id', auth()->id());
    }

    /**
     * Get rating distribution for this post
     */
    public function getRatingDistribution()
    {
        $distribution = [];
        for ($i = 5; $i >= 1; $i--) {
            $distribution[$i] = $this->reviews()->where('rating', $i)->count();
        }
        return $distribution;
    }

    /**
     * Check if a user has reviewed this post
     */
    public function isReviewedByUser($userId = null)
    {
        if (!$userId) {
            $userId = auth()->id();
        }

        if (!$userId) {
            return false;
        }

        return $this->reviews()->where('user_id', $userId)->exists();
    }

    /**
     * Get the user's review for this post
     */
    public function getUserReview($userId = null)
    {
        if (!$userId) {
            $userId = auth()->id();
        }

        if (!$userId) {
            return null;
        }

        return $this->reviews()->where('user_id', $userId)->first();
    }
}