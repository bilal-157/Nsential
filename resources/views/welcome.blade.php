<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>Blog Posts</title>
    <script src=\"https://cdn.tailwindcss.com\"></script>
</head>
<body class=\"bg-gray-50\">
    <div class=\"max-w-6xl mx-auto px-4 py-8\">
        <h1 class=\"text-4xl font-bold text-gray-800 mb-2\">Blog Posts</h1>
        <p class=\"text-gray-600 mb-8\">Showing {{ $postCount }} published posts</p>
        
        <div class=\"grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6\">
            @forelse($posts as $post)
            <div class=\"bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300\">
                <div class=\"p-6\">
                    <div class=\"flex items-center justify-between mb-2\">
                        <span class=\"text-xs font-semibold text-gray-500 uppercase\">{{ $post->status }}</span>
                        <span class=\"text-xs text-gray-400\">{{ number_format($post->views) }} views</span>
                    </div>
                    <h2 class=\"text-xl font-semibold text-gray-800 mb-2 hover:text-blue-600 transition-colors\">
                        <a href=\"/posts/{{ $post->slug }}\">{{ $post->title }}</a>
                    </h2>
                    <p class=\"text-gray-600 text-sm mb-4 line-clamp-3\">{{ Str::limit($post->content, 120) }}</p>
                    <div class=\"flex justify-between items-center text-sm text-gray-500\">
                        <span>{{ $post->published_at ? \\Carbon\\Carbon::parse($post->published_at)->format('M d, Y') : 'Draft' }}</span>
                        <a href=\"/posts/{{ $post->slug }}\" class=\"text-blue-600 hover:text-blue-800 font-medium\">
                            Read More →
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class=\"col-span-full text-center py-12\">
                <p class=\"text-gray-500 text-lg\">No published posts found.</p>
            </div>
            @endforelse
        </div>

        @if($popularPosts->count() > 0)
        <div class=\"mt-12\">
            <h3 class=\"text-2xl font-bold text-gray-800 mb-4\">🔥 Popular Posts</h3>
            <div class=\"bg-white rounded-lg shadow-md p-6\">
                <ul class=\"space-y-3\">
                    @foreach($popularPosts as $post)
                    <li class=\"flex items-center justify-between border-b border-gray-100 pb-3 last:border-0 last:pb-0\">
                        <a href=\"/posts/{{ $post->slug }}\" class=\"text-gray-700 hover:text-blue-600 transition-colors\">
                            {{ $post->title }}
                        </a>
                        <span class=\"text-sm text-gray-500\">{{ number_format($post->views) }} views</span>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        <div class=\"mt-8 text-center text-sm text-gray-500\">
            <p>Total Posts: {{ $postCount }} | Total Views: {{ number_format($totalViews) }}</p>
        </div>
    </div>
</body>
</html>
