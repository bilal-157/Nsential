@extends('admin.layout')
@section('title', 'Analytics')
@section('content')

<h1 class="text-2xl font-bold text-ivory mb-6">Analytics</h1>

{{-- KPI summary cards --}}
<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-7 gap-4 mb-8">
    <div class="bg-panel border border-hairline rounded-lg p-4 hover:border-cyan/40 transition-colors">
        <p class="text-xs text-mist">Total Posts</p>
        <p class="text-xl font-bold text-ivory mt-1">{{ $summary['total_posts'] }}</p>
    </div>
    <div class="bg-panel border border-hairline rounded-lg p-4 hover:border-cyan/40 transition-colors">
        <p class="text-xs text-mist">Total Views</p>
        <p class="text-xl font-bold text-ivory mt-1">{{ number_format($summary['total_views']) }}</p>
    </div>
    <div class="bg-panel border border-hairline rounded-lg p-4 hover:border-violet/40 transition-colors">
        <p class="text-xs text-mist">Total Comments</p>
        <p class="text-xl font-bold text-ivory mt-1">{{ number_format($summary['total_comments']) }}</p>
    </div>
    <div class="bg-panel border border-hairline rounded-lg p-4 hover:border-pink/40 transition-colors">
        <p class="text-xs text-mist">Total Likes</p>
        <p class="text-xl font-bold text-ivory mt-1">{{ number_format($summary['total_likes']) }}</p>
    </div>
    <div class="bg-panel border border-hairline rounded-lg p-4 hover:border-amber-400/40 transition-colors">
        <p class="text-xs text-mist">Total Reviews</p>
        <p class="text-xl font-bold text-ivory mt-1">{{ number_format($summary['total_reviews']) }}</p>
    </div>
    <div class="bg-panel border border-hairline rounded-lg p-4 hover:border-amber-400/40 transition-colors">
        <p class="text-xs text-mist">Avg Rating</p>
        <p class="text-xl font-bold text-ivory mt-1">{{ $summary['avg_rating'] }} <span class="text-amber-400">★</span></p>
    </div>
    <div class="bg-panel border border-hairline rounded-lg p-4 hover:border-cyan/40 transition-colors">
        <p class="text-xs text-mist">Avg Reading Time</p>
        <p class="text-xl font-bold text-ivory mt-1">{{ $summary['avg_reading_time'] }}s</p>
    </div>
</div>

{{-- Views trend chart --}}
<div class="bg-panel border border-hairline rounded-lg p-4 mb-6">
    <h2 class="font-semibold text-ivory mb-3">Views Trend (last 30 days)</h2>
    <canvas id="trendChart" height="80"></canvas>
</div>

<div class="grid grid-cols-1 gap-6 mb-6">
    {{-- Views by category --}}
    <div class="bg-panel border border-hairline rounded-lg p-4">
        <h2 class="font-semibold text-ivory mb-3">Views by Category</h2>
        <canvas id="categoryChart" height="150"></canvas>
    </div>
</div>

{{-- Reading time trend chart --}}
<div class="bg-panel border border-hairline rounded-lg p-4 mb-6">
    <h2 class="font-semibold text-ivory mb-3">Reading Time Trend (last 30 days)</h2>
    <canvas id="readingTimeTrendChart" height="80"></canvas>
</div>

<div class="grid grid-cols-1 gap-6 mb-6">
    {{-- Reading time by category --}}
    <div class="bg-panel border border-hairline rounded-lg p-4">
        <h2 class="font-semibold text-ivory mb-3">Reading Time by Category</h2>
        <canvas id="readingTimeCategoryChart" height="150"></canvas>
    </div>
</div>

{{-- Full data table --}}
<div class="bg-panel border border-hairline rounded-lg p-4 overflow-x-auto">
    <h2 class="font-semibold text-ivory mb-3">All Posts — Full Breakdown</h2>
    <table class="w-full text-sm">
        <thead>
            <tr class="text-left border-b border-hairline text-mist">
                <th class="p-2">Title</th>
                <th class="p-2">Category</th>
                <th class="p-2">Views</th>
                <th class="p-2">Comments</th>
                <th class="p-2">Likes</th>
                <th class="p-2">Reviews</th>
                <th class="p-2">Avg Rating</th>
                <th class="p-2">Reading Time</th>
                <th class="p-2">Published</th>
            </tr>
        </thead>
        <tbody>
            @foreach($allPosts as $post)
            <tr class="border-b border-hairline hover:bg-card/50 transition-colors">
                <td class="p-2">
                    <a href="{{ route('admin.posts.edit', $post) }}" class="text-cyan hover:text-violet transition-colors">
                        {{ \Illuminate\Support\Str::limit($post->title, 40) }}
                    </a>
                </td>
                <td class="p-2 text-mist">{{ $post->category->name ?? '—' }}</td>
                <td class="p-2 text-ivory">{{ number_format($post->views) }}</td>
                <td class="p-2 text-ivory">{{ $post->all_comments_count }}</td>
                <td class="p-2 text-ivory">{{ $post->likes_count }}</td>
                <td class="p-2 text-ivory">{{ $post->reviews_count }}</td>
                <td class="p-2 text-ivory">
                    @if($post->reviews_avg_rating)
                        {{ round($post->reviews_avg_rating, 1) }} <span class="text-amber-400">★</span>
                    @else
                        <span class="text-mist">—</span>
                    @endif
                </td>
                <td class="p-2 text-mist">{{ $post->reading_time ?? 0 }}s</td>
                <td class="p-2 text-mist">{{ $post->created_at->format('M j, Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Shared dark-theme defaults so text/gridlines are visible on a dark background
    Chart.defaults.color = '#9993B8';       // mist
    Chart.defaults.borderColor = '#2A2650'; // hairline
    Chart.defaults.font.family = 'Inter, sans-serif';

    // Get data from PHP
    const viewsDates = {!! json_encode($viewsTrend->pluck('date')->toArray()) !!};
    const viewsData = {!! json_encode($viewsTrend->pluck('total_views')->toArray()) !!};
    const readingDates = {!! json_encode($readingTimeTrend->pluck('date')->toArray()) !!};
    const readingData = {!! json_encode($readingTimeTrend->pluck('avg_reading_time')->toArray()) !!};
    const categoryNames = {!! json_encode($categoryPerformance->pluck('name')->toArray()) !!};
    const categoryViews = {!! json_encode($categoryPerformance->pluck('total_views')->toArray()) !!};
    const readingCategoryNames = {!! json_encode($readingTimeByCategory->pluck('name')->toArray()) !!};
    const readingCategoryData = {!! json_encode($readingTimeByCategory->pluck('avg_reading_time')->toArray()) !!};

    // Views trend line chart
    const ctx1 = document.getElementById('trendChart').getContext('2d');
    new Chart(ctx1, {
        type: 'line',
        data: {
            labels: viewsDates,
            datasets: [{
                label: 'Views',
                data: viewsData,
                borderColor: '#3FD8E0',
                backgroundColor: 'rgba(63,216,224,0.1)',
                borderWidth: 2,
                pointBackgroundColor: '#3FD8E0',
                pointBorderColor: '#3FD8E0',
                pointRadius: 4,
                pointHoverRadius: 6,
                fill: true,
                tension: 0.4,
                showLine: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: { 
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Views: ' + context.parsed.y.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                x: { 
                    grid: { color: '#2A2650', drawBorder: false },
                    ticks: { maxTicksLimit: 15 }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: '#2A2650', drawBorder: false },
                    ticks: { 
                        stepSize: 100,
                        callback: function(value) {
                            return value.toLocaleString();
                        }
                    }
                }
            },
            elements: {
                line: {
                    borderJoinStyle: 'round'
                }
            }
        }
    });

    // Views by category bar chart
    const ctx2 = document.getElementById('categoryChart').getContext('2d');
    new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: categoryNames,
            datasets: [{
                label: 'Views',
                data: categoryViews,
                backgroundColor: 'rgba(156, 140, 255, 0.8)',
                borderColor: '#9C8CFF',
                borderWidth: 1,
                borderRadius: 4
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: true,
            plugins: { 
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Views: ' + context.parsed.x.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                x: { 
                    grid: { color: '#2A2650', drawBorder: false },
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString();
                        }
                    }
                },
                y: { grid: { color: '#2A2650', drawBorder: false } }
            }
        }
    });

    // Reading time trend line chart
    const ctx3 = document.getElementById('readingTimeTrendChart').getContext('2d');
    new Chart(ctx3, {
        type: 'line',
        data: {
            labels: readingDates,
            datasets: [{
                label: 'Reading Time (s)',
                data: readingData,
                borderColor: '#F17BC4',
                backgroundColor: 'rgba(241,123,196,0.1)',
                borderWidth: 2,
                pointBackgroundColor: '#F17BC4',
                pointBorderColor: '#F17BC4',
                pointRadius: 4,
                pointHoverRadius: 6,
                fill: true,
                tension: 0.4,
                showLine: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: { 
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Reading Time: ' + context.parsed.y.toFixed(1) + 's';
                        }
                    }
                }
            },
            scales: {
                x: { 
                    grid: { color: '#2A2650', drawBorder: false },
                    ticks: { maxTicksLimit: 15 }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: '#2A2650', drawBorder: false },
                    ticks: { 
                        callback: function(value) {
                            return value.toFixed(1) + 's';
                        }
                    }
                }
            },
            elements: {
                line: {
                    borderJoinStyle: 'round'
                }
            }
        }
    });

    // Reading time by category bar chart
    const ctx4 = document.getElementById('readingTimeCategoryChart').getContext('2d');
    new Chart(ctx4, {
        type: 'bar',
        data: {
            labels: readingCategoryNames,
            datasets: [{
                label: 'Reading Time (s)',
                data: readingCategoryData,
                backgroundColor: 'rgba(251, 191, 36, 0.8)',
                borderColor: '#FBBF24',
                borderWidth: 1,
                borderRadius: 4
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: true,
            plugins: { 
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Reading Time: ' + context.parsed.x.toFixed(1) + 's';
                        }
                    }
                }
            },
            scales: {
                x: { 
                    grid: { color: '#2A2650', drawBorder: false },
                    ticks: { 
                        callback: function(value) {
                            return value.toFixed(1) + 's';
                        }
                    }
                },
                y: { grid: { color: '#2A2650', drawBorder: false } }
            }
        }
    });
});
</script>

@endsection