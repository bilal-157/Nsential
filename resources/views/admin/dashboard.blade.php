@extends('admin.layout')
@section('title', 'Dashboard')
@section('content')

<h1 class="text-2xl font-bold text-ivory mb-6">Dashboard</h1>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">

    <div class="bg-panel border border-hairline p-6 rounded-lg transition-all duration-200 hover:border-cyan/40 hover:shadow-[0_0_24px_-8px_rgba(63,216,224,0.35)]">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-mist font-medium">Total Users</a></p>
                <p class="text-3xl font-bold text-ivory mt-1">{{ $stats['total_users'] }}</p>
            </div>
            <div class="bg-cyan/10 border border-cyan/20 p-3 rounded-full">
                <i class="fas fa-users text-cyan text-xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-panel border border-hairline p-6 rounded-lg transition-all duration-200 hover:border-violet/40 hover:shadow-[0_0_24px_-8px_rgba(156,140,255,0.35)]">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-mist font-medium">Total Posts</p>
                <p class="text-3xl font-bold text-ivory mt-1">{{ $stats['total_posts'] }}</p>
            </div>
            <div class="bg-violet/10 border border-violet/20 p-3 rounded-full">
                <i class="fas fa-newspaper text-violet text-xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-panel border border-hairline p-6 rounded-lg transition-all duration-200 hover:border-pink/40 hover:shadow-[0_0_24px_-8px_rgba(241,123,196,0.35)]">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-mist font-medium">Total Comments</p>
                <p class="text-3xl font-bold text-ivory mt-1">{{ $stats['total_comments'] }}</p>
            </div>
            <div class="bg-pink/10 border border-pink/20 p-3 rounded-full">
                <i class="fas fa-comments text-pink text-xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-panel border border-hairline p-6 rounded-lg transition-all duration-200 hover:border-rose-400/40 hover:shadow-[0_0_24px_-8px_rgba(251,113,133,0.35)]">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-mist font-medium">Total Likes</p>
                <p class="text-3xl font-bold text-ivory mt-1">{{ $stats['total_likes'] }}</p>
            </div>
            <div class="bg-rose-400/10 border border-rose-400/20 p-3 rounded-full">
                <i class="fas fa-heart text-rose-400 text-xl"></i>
            </div>
        </div>
    </div>

    <div class="bg-panel border border-hairline p-6 rounded-lg transition-all duration-200 hover:border-amber-400/40 hover:shadow-[0_0_24px_-8px_rgba(251,191,36,0.35)]">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-mist font-medium">Total Reviews</p>
                <p class="text-3xl font-bold text-ivory mt-1">{{ $stats['total_reviews'] }}</p>
            </div>
            <div class="bg-amber-400/10 border border-amber-400/20 p-3 rounded-full">
                <i class="fas fa-star text-amber-400 text-xl"></i>
            </div>
        </div>
    </div>

</div>

@endsection