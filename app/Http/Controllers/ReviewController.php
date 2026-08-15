<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Review;
use App\Http\Controllers\HomeController;
use App\Services\PostCacheService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    public function store(Request $request, Post $post, PostCacheService $postCache)
    {
        $validator = Validator::make($request->all(), [
            'rating' => 'required|integer|min:1|max:5',
            'review_text' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Check if user already reviewed this post
        $existingReview = Review::where('post_id', $post->id)
            ->where('user_id', auth()->id())
            ->first();

        if ($existingReview) {
            // Update existing review
            $existingReview->update([
                'rating' => $request->rating,
                'review_text' => $request->review_text,
            ]);
            $review = $existingReview;
            $message = 'Review updated successfully!';
        } else {
            // Create new review
            $review = Review::create([
                'post_id' => $post->id,
                'user_id' => auth()->id(),
                'rating' => $request->rating,
                'review_text' => $request->review_text,
            ]);
            $message = 'Review posted successfully!';
        }

        // ✅ Clear ALL home page caches (including reviews)
        HomeController::clearCache();

        // Calculate average rating and ensure it's a float
        $averageRating = (float) $post->reviews()->avg('rating') ?? 0.0;
        $totalReviews = (int) $post->reviews()->count();
        $ratingDistribution = $this->getRatingDistribution($post);

        $reviewPayload = [
            'id' => $review->id,
            'rating' => (int) $review->rating,
            'review_text' => $review->review_text,
            'user' => [
                'id' => (int) auth()->id(),
                'name' => auth()->user()->name,
                'avatar' => auth()->user()->avatar,
            ],
            'created_at' => $review->created_at->diffForHumans(),
        ];

        // ---------------------------------------------------------------
        // Keep the Redis per-post cache in sync: upsert this review (new
        // or edited) and refresh the derived numbers (average, count,
        // distribution). No-op if the post isn't currently cached.
        // ---------------------------------------------------------------
        $postCache->upsertReview(
            $post->id,
            $reviewPayload,
            $averageRating,
            $totalReviews,
            $ratingDistribution
        );

        return response()->json([
            'message' => $message,
            'review' => $reviewPayload,
            'average_rating' => $averageRating,
            'total_reviews' => $totalReviews,
            'rating_distribution' => $ratingDistribution,
        ]);
    }

    public function destroy(Review $review, PostCacheService $postCache)
    {
        if ($review->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $post = $review->post;
        $reviewId = $review->id;
        $review->delete();

        // ✅ Clear ALL home page caches (including reviews)
        HomeController::clearCache();

        $averageRating = (float) $post->reviews()->avg('rating') ?? 0.0;
        $totalReviews = (int) $post->reviews()->count();
        $ratingDistribution = $this->getRatingDistribution($post);

        // ---- keep Redis cache in sync ----
        $postCache->deleteReview(
            $post->id,
            $reviewId,
            $averageRating,
            $totalReviews,
            $ratingDistribution
        );

        return response()->json([
            'message' => 'Review deleted successfully!',
            'average_rating' => $averageRating,
            'total_reviews' => $totalReviews,
            'rating_distribution' => $ratingDistribution,
        ]);
    }

    private function getRatingDistribution($post)
    {
        $distribution = [];
        for ($i = 5; $i >= 1; $i--) {
            $distribution[$i] = (int) $post->reviews()->where('rating', $i)->count();
        }
        return $distribution;
    }
}