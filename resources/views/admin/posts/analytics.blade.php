@extends('admin.layout')
@section('title', 'Post Analytics - ' . ($post->title ?? 'Unknown'))
@php use Illuminate\Support\Str; @endphp

@section('content')

<div class="flex flex-wrap justify-between items-center gap-3 mb-6">
    <div>
        <h1 class="text-2xl sm:text-3xl font-bold text-ivory">Post Analytics</h1>
        <p class="text-mist mt-1">{{ $post->title ?? 'Unknown' }}</p>
    </div>
    <div class="flex gap-3">
        <a href="{{ route('admin.posts.edit', $post->id ?? 0) }}"
           class="text-void font-semibold px-4 py-2 rounded-md transition-opacity hover:opacity-90"
           style="background: linear-gradient(90deg, #3FD8E0, #9C8CFF);">
            <i class="fas fa-edit mr-2"></i>Edit Post
        </a>
        <a href="{{ route('admin.posts.index') }}"
           class="bg-card border border-hairline text-mist hover:text-ivory hover:border-hairline px-4 py-2 rounded-md transition-colors">
            <i class="fas fa-arrow-left mr-2"></i>Back to Posts
        </a>
    </div>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="bg-panel border border-hairline rounded-lg p-5 hover:border-cyan/40 transition-colors">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-mist text-sm">Total Views</p>
                <p class="text-2xl font-bold text-ivory mt-1">{{ number_format($post->views ?? 0) }}</p>
            </div>
            <div class="bg-cyan/10 border border-cyan/20 p-3 rounded-full">
                <i class="fas fa-eye text-cyan text-lg"></i>
            </div>
        </div>
    </div>

    <div class="bg-panel border border-hairline rounded-lg p-5 hover:border-pink/40 transition-colors">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-mist text-sm">Total Likes</p>
                <p class="text-2xl font-bold text-ivory mt-1">{{ $post->likes_count ?? 0 }}</p>
            </div>
            <div class="bg-pink/10 border border-pink/20 p-3 rounded-full">
                <i class="fas fa-heart text-pink text-lg"></i>
            </div>
        </div>
    </div>

    <div class="bg-panel border border-hairline rounded-lg p-5 hover:border-violet/40 transition-colors">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-mist text-sm">Total Comments</p>
                <p class="text-2xl font-bold text-ivory mt-1">{{ $post->allComments()->count() ?? 0 }}</p>
            </div>
            <div class="bg-violet/10 border border-violet/20 p-3 rounded-full">
                <i class="fas fa-comments text-violet text-lg"></i>
            </div>
        </div>
    </div>

    <div class="bg-panel border border-hairline rounded-lg p-5 hover:border-amber-400/40 transition-colors">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-mist text-sm">Average Rating</p>
                <p class="text-2xl font-bold text-ivory mt-1">{{ number_format((float) ($post->averageRating() ?? 0), 1) }}</p>
            </div>
            <div class="bg-amber-400/10 border border-amber-400/20 p-3 rounded-full">
                <i class="fas fa-star text-amber-400 text-lg"></i>
            </div>
        </div>
    </div>
</div>

<!-- Post Info -->
<div class="bg-panel border border-hairline rounded-lg p-6 mb-6">
    <h2 class="text-base font-bold text-ivory mb-4">Post Details</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-2 text-sm">
        <div class="space-y-2">
            <p><span class="text-mist">Title:</span> <span class="text-ivory">{{ $post->title }}</span></p>
            <p><span class="text-mist">Author:</span> <span class="text-ivory">{{ $post->author->name ?? 'Unknown' }}</span></p>
            <p><span class="text-mist">Category:</span> <span class="text-ivory">{{ $post->category->name ?? 'Uncategorized' }}</span></p>
            <p class="flex items-center gap-2">
                <span class="text-mist">Status:</span>
                <span class="px-2 py-0.5 rounded-full text-xs {{ $post->status === 'published' ? 'bg-cyan/10 text-cyan border border-cyan/20' : 'bg-amber-400/10 text-amber-400 border border-amber-400/20' }}">
                    {{ ucfirst($post->status) }}
                </span>
            </p>
        </div>
        <div class="space-y-2">
            @php
                $readingTimeSeconds = $post->reading_time ?? 0;
                $minutes = $readingTimeSeconds > 0 ? ceil($readingTimeSeconds / 60) : 0;
            @endphp
            <p><span class="text-mist">Reading Time:</span> <span class="text-ivory">{{ $minutes > 0 ? $minutes . ' min read' : 'Not calculated' }}</span></p>
            <p><span class="text-mist">Created:</span> <span class="text-ivory">{{ $post->created_at->format('M d, Y H:i') }}</span></p>
            @if($post->published_at)
                <p><span class="text-mist">Published:</span> <span class="text-ivory">{{ $post->published_at->format('M d, Y H:i') }}</span></p>
            @endif
            <p><span class="text-mist">Last Updated:</span> <span class="text-ivory">{{ $post->updated_at->format('M d, Y H:i') }}</span></p>
        </div>
    </div>
</div>

<!-- Recent Comments -->
<div class="bg-panel border border-hairline rounded-lg p-6 mb-6">
    <h2 class="text-base font-bold text-ivory mb-4 flex items-center gap-2">
        <i class="fas fa-comments text-violet"></i> Recent Comments
        <span class="text-mist font-normal text-sm">({{ $post->comments->count() }})</span>
    </h2>
    @if($post->comments->count() > 0)
        <div class="divide-y divide-hairline">
            @foreach($post->comments->take(5) as $comment)
                <div class="flex items-start gap-3 py-3 first:pt-0 last:pb-0">
                    <div class="w-8 h-8 flex-shrink-0 rounded-full bg-violet/15 flex items-center justify-center">
                        <span class="text-xs font-bold text-violet">{{ strtoupper(substr($comment->user->name ?? 'A', 0, 1)) }}</span>
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-ivory">{{ $comment->user->name ?? 'Anonymous' }}</p>
                        <p class="text-sm text-mist">{{ Str::limit($comment->content, 100) }}</p>
                        <p class="text-xs text-mist/60 mt-0.5">{{ $comment->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-mist text-sm">No comments yet.</p>
    @endif
</div>

<!-- Recent Reviews -->
<div class="bg-panel border border-hairline rounded-lg p-6">
    <h2 class="text-base font-bold text-ivory mb-4 flex items-center gap-2">
        <i class="fas fa-star text-amber-400"></i> Recent Reviews
        <span class="text-mist font-normal text-sm">({{ $post->reviews->count() }})</span>
    </h2>
    @if($post->reviews->count() > 0)
        <div class="divide-y divide-hairline">
            @foreach($post->reviews->take(5) as $review)
                <div class="flex items-start gap-3 py-3 first:pt-0 last:pb-0">
                    <div class="w-8 h-8 flex-shrink-0 rounded-full bg-amber-400/15 flex items-center justify-center">
                        <span class="text-xs font-bold text-amber-400">{{ strtoupper(substr($review->user->name ?? 'A', 0, 1)) }}</span>
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-ivory">{{ $review->user->name ?? 'Anonymous' }}</p>
                        <div class="flex items-center gap-0.5 mt-0.5">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star text-xs {{ $i <= $review->rating ? 'text-amber-400' : 'text-mist/30' }}"></i>
                            @endfor
                        </div>
                        @if($review->review_text)
                            <p class="text-sm text-mist mt-1">{{ Str::limit($review->review_text, 100) }}</p>
                        @endif
                        <p class="text-xs text-mist/60 mt-0.5">{{ $review->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-mist text-sm">No reviews yet.</p>
    @endif
</div>

@endsection