@extends('admin.layout')
@section('title', 'Posts Management')
@section('content')

<div class="flex flex-wrap justify-between items-center gap-3 mb-6">
    <h1 class="text-2xl sm:text-3xl font-bold text-ivory">Posts Management</h1>
    <a href="{{ route('admin.posts.create') }}"
       class="inline-flex items-center gap-2 text-void font-semibold px-4 py-2 rounded-md transition-opacity hover:opacity-90"
       style="background: linear-gradient(90deg, #3FD8E0, #9C8CFF);">
        <i class="fas fa-plus"></i> Create New Post
    </a>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="bg-panel border border-hairline rounded-lg p-5 transition-all hover:border-cyan/40">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-mist text-sm">Total Posts</p>
                <p class="text-2xl font-bold text-ivory mt-1">{{ $stats['total_posts'] ?? 0 }}</p>
            </div>
            <div class="bg-cyan/10 border border-cyan/20 p-3 rounded-full">
                <i class="fas fa-newspaper text-cyan text-lg"></i>
            </div>
        </div>
        <div class="mt-3 flex gap-3 text-xs">
            <span class="text-cyan">{{ $stats['published_posts'] ?? 0 }} published</span>
            <span class="text-mist">{{ $stats['draft_posts'] ?? 0 }} drafts</span>
        </div>
    </div>

    <div class="bg-panel border border-hairline rounded-lg p-5 transition-all hover:border-violet/40">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-mist text-sm">Total Users</p>
                <p class="text-2xl font-bold text-ivory mt-1">{{ $stats['total_users'] ?? 0 }}</p>
            </div>
            <div class="bg-violet/10 border border-violet/20 p-3 rounded-full">
                <i class="fas fa-users text-violet text-lg"></i>
            </div>
        </div>
    </div>

    <div class="bg-panel border border-hairline rounded-lg p-5 transition-all hover:border-pink/40">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-mist text-sm">Total Comments</p>
                <p class="text-2xl font-bold text-ivory mt-1">{{ $stats['total_comments'] ?? 0 }}</p>
            </div>
            <div class="bg-pink/10 border border-pink/20 p-3 rounded-full">
                <i class="fas fa-comments text-pink text-lg"></i>
            </div>
        </div>
    </div>

    <div class="bg-panel border border-hairline rounded-lg p-5 transition-all hover:border-amber-400/40">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-mist text-sm">Total Reviews</p>
                <p class="text-2xl font-bold text-ivory mt-1">{{ $stats['total_reviews'] ?? 0 }}</p>
            </div>
            <div class="bg-amber-400/10 border border-amber-400/20 p-3 rounded-full">
                <i class="fas fa-star text-amber-400 text-lg"></i>
            </div>
        </div>
    </div>
</div>

<!-- Search and Filter -->
<div class="bg-panel border border-hairline rounded-lg p-4 mb-6">
    <form method="GET" action="{{ route('admin.posts.index') }}" class="flex flex-wrap gap-3">
        <div class="flex-1 min-w-[200px]">
            <input type="text" name="search" placeholder="Search posts by title..."
                   class="w-full px-4 py-2 bg-card border border-hairline rounded-md text-ivory placeholder-mist/50 focus:outline-none focus:ring-2 focus:ring-cyan/40 focus:border-cyan transition-colors"
                   value="{{ request('search') }}">
        </div>
        <select name="status" class="px-4 py-2 bg-card border border-hairline rounded-md text-ivory focus:outline-none focus:ring-2 focus:ring-cyan/40 focus:border-cyan transition-colors">
            <option value="">All Status</option>
            <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
        </select>
        <select name="category" class="px-4 py-2 bg-card border border-hairline rounded-md text-ivory focus:outline-none focus:ring-2 focus:ring-cyan/40 focus:border-cyan transition-colors">
            <option value="">All Categories</option>
            @foreach($categories ?? [] as $category)
                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        <button type="submit"
                class="text-void font-semibold px-5 py-2 rounded-md transition-opacity hover:opacity-90"
                style="background: linear-gradient(90deg, #3FD8E0, #9C8CFF);">
            <i class="fas fa-search mr-1"></i> Filter
        </button>
        <a href="{{ route('admin.posts.index') }}"
           class="bg-card border border-hairline hover:border-hairline text-mist hover:text-ivory px-5 py-2 rounded-md transition-colors">
            <i class="fas fa-undo mr-1"></i> Reset
        </a>
    </form>
</div>

<!-- Posts List -->
<div class="space-y-4">
    @forelse($posts ?? [] as $post)
        <div class="bg-panel border border-hairline rounded-lg overflow-hidden hover:border-cyan/30 transition-colors">

            <!-- Post Header -->
            <div class="p-4 flex justify-between items-start gap-3">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 flex-wrap">
                        <h3 class="text-base font-semibold text-ivory truncate">
                            <a href="{{ route('admin.posts.edit', $post->id) }}" class="hover:text-cyan transition-colors">
                                {{ $post->title }}
                            </a>
                        </h3>
                        <span class="px-2 py-0.5 rounded-full text-[11px] flex-shrink-0 {{ $post->status === 'published' ? 'bg-cyan/10 text-cyan border border-cyan/20' : 'bg-amber-400/10 text-amber-400 border border-amber-400/20' }}">
                            {{ ucfirst($post->status) }}
                        </span>
                    </div>
                    <div class="mt-1 text-xs text-mist flex flex-wrap gap-x-3 gap-y-1">
                        <span><i class="fas fa-user mr-1"></i>{{ $post->author->name ?? 'Unknown' }}</span>
                        <span><i class="fas fa-folder mr-1"></i>{{ $post->category->name ?? 'Uncategorized' }}</span>
                        <span><i class="fas fa-clock mr-1"></i>{{ $post->reading_time ?? '1 min read' }}</span>
                    </div>
                </div>
                <div class="flex gap-1 flex-shrink-0">
                    <a href="{{ route('admin.posts.edit', $post->id) }}"
                       class="w-8 h-8 flex items-center justify-center text-cyan hover:bg-cyan/10 rounded-md transition-colors" title="Edit">
                        <i class="fas fa-edit text-sm"></i>
                    </a>
                    <a href="{{ route('admin.posts.analytics', $post->id) }}"
                       class="w-8 h-8 flex items-center justify-center text-violet hover:bg-violet/10 rounded-md transition-colors" title="Analytics">
                        <i class="fas fa-chart-bar text-sm"></i>
                    </a>
                    <form action="{{ route('admin.posts.destroy', $post->id) }}"
                          method="POST"
                          onsubmit="return confirm('Are you sure you want to delete this post? This action cannot be undone.');"
                          class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="w-8 h-8 flex items-center justify-center text-pink hover:bg-pink/10 rounded-md transition-colors" title="Delete">
                            <i class="fas fa-trash text-sm"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Compact Stat Row -->
            <div class="px-4 pb-4">
                <div class="flex items-center gap-5 bg-card border border-hairline rounded-md px-4 py-2.5 text-sm">
                    <span class="flex items-center gap-1.5 text-ivory"><i class="fas fa-eye text-cyan text-xs"></i>{{ number_format($post->views ?? 0) }}</span>
                    <span class="flex items-center gap-1.5 text-ivory"><i class="fas fa-heart text-pink text-xs"></i>{{ $post->likes_count ?? 0 }}</span>
                    <span class="flex items-center gap-1.5 text-ivory"><i class="fas fa-comment text-violet text-xs"></i>{{ $post->allComments()->count() ?? 0 }}</span>
                    <span class="flex items-center gap-1.5 text-ivory"><i class="fas fa-star text-amber-400 text-xs"></i>{{ number_format((float) ($post->averageRating() ?? 0), 1) }}</span>
                </div>

                {{-- Recent activity: comments + reviews combined into one compact, muted list --}}
                @php
                    $recentComments = $post->allComments()->take(2);
                    $recentReviews = $post->reviews->take(2);
                @endphp
                @if($recentComments->count() > 0 || $recentReviews->count() > 0)
                    <div class="mt-3 divide-y divide-hairline">
                        @foreach($recentComments as $comment)
                            <div class="flex items-start gap-2 py-2 text-xs">
                                <span class="w-5 h-5 flex-shrink-0 rounded-full bg-violet/15 text-violet flex items-center justify-center font-semibold text-[10px]">
                                    {{ strtoupper(substr($comment->user->name ?? 'A', 0, 1)) }}
                                </span>
                                <p class="flex-1 min-w-0 text-mist truncate">
                                    <span class="text-ivory font-medium">{{ $comment->user->name ?? 'Anonymous' }}</span>
                                    · {{ Str::limit($comment->content, 70) }}
                                    <span class="text-mist/60">· {{ $comment->created_at->diffForHumans() }}</span>
                                </p>
                            </div>
                        @endforeach
                        @foreach($recentReviews as $review)
                            <div class="flex items-start gap-2 py-2 text-xs">
                                <span class="w-5 h-5 flex-shrink-0 rounded-full bg-amber-400/15 text-amber-400 flex items-center justify-center font-semibold text-[10px]">
                                    {{ strtoupper(substr($review->user->name ?? 'A', 0, 1)) }}
                                </span>
                                <p class="flex-1 min-w-0 text-mist truncate">
                                    <span class="text-ivory font-medium">{{ $review->user->name ?? 'Anonymous' }}</span>
                                    <span class="text-amber-400">{{ str_repeat('★', $review->rating) }}<span class="text-mist/30">{{ str_repeat('★', 5 - $review->rating) }}</span></span>
                                    @if($review->review_text)
                                        · {{ Str::limit($review->review_text, 50) }}
                                    @endif
                                    <span class="text-mist/60">· {{ $review->created_at->diffForHumans() }}</span>
                                </p>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Post Meta Footer -->
                <div class="mt-3 pt-3 border-t border-hairline flex items-center justify-between text-[11px] text-mist">
                    <div>
                        <i class="fas fa-calendar-alt mr-1"></i>{{ $post->created_at->format('M d, Y') }}
                        @if($post->published_at)
                            <span class="ml-2 text-cyan"><i class="fas fa-check-circle mr-1"></i>Published {{ $post->published_at->diffForHumans() }}</span>
                        @endif
                    </div>
                    <a href="{{ route('posts.show', $post->slug ?? '#') }}" class="text-cyan hover:text-violet transition-colors" target="_blank">
                        <i class="fas fa-external-link-alt mr-1"></i>View Post
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="bg-panel border border-hairline rounded-lg p-10 text-center">
            <i class="fas fa-newspaper text-4xl text-hairline mb-4"></i>
            <p class="text-mist text-lg">No posts found</p>
            <a href="{{ route('admin.posts.create') }}" class="text-cyan hover:text-violet transition-colors mt-2 inline-block">
                Create your first post
            </a>
        </div>
    @endforelse
</div>

<!-- Pagination -->
<div class="mt-6 text-mist [&_a]:text-cyan [&_a:hover]:text-violet">
    {{ $posts->links() ?? '' }}
</div>

@endsection