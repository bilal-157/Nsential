<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $post->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 py-8">
        <a href="/" class="text-blue-600 hover:text-blue-800 mb-4 inline-block">← Back to all posts</a>
        
        <article class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-8">
                <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                    <div class="flex items-center gap-2">
                        <span class="bg-gray-100 px-3 py-1 rounded-full">{{ $post->status }}</span>
                        @if($post->category)
                        <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full">{{ $post->category->name }}</span>
                        @endif
                    </div>
                    <span>{{ number_format($post->views) }} views</span>
                </div>
                
                <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">{{ $post->title }}</h1>
                
                <div class="flex items-center gap-4 text-sm text-gray-500 mb-6">
                    <span>Published: {{ $post->published_at ? \Carbon\Carbon::parse($post->published_at)->format('F d, Y') : 'Not published' }}</span>
                </div>

                @if($post->author)
                <div class="flex items-center gap-3 mb-6 p-4 bg-gray-50 rounded-lg">
                    @if($post->author->avatar ?? false)
                    <img src="{{ $post->author->avatar }}" alt="{{ $post->author->name }}" class="w-12 h-12 rounded-full object-cover">
                    @else
                    <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-semibold">
                        {{ strtoupper(substr($post->author->name, 0, 1)) }}
                    </div>
                    @endif
                    <div>
                        <p class="font-semibold text-gray-800">{{ $post->author->name }}</p>
                        @if($post->author->bio)
                        <p class="text-sm text-gray-500">{{ $post->author->bio }}</p>
                        @endif
                    </div>
                </div>
                @endif
                
                <div class="prose max-w-none">
                    <p class="text-gray-700 leading-relaxed whitespace-pre-wrap">{{ $post->content }}</p>
                </div>
                
                @if($post->featured_image)
                <div class="mt-6">
                    <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" class="w-full rounded-lg">
                </div>
                @endif
            </div>
        </article>
        
        <div class="mt-6 text-center text-sm text-gray-500">
            <a href="/" class="text-blue-600 hover:text-blue-800">← Back to all posts</a>
        </div>
    </div>
</body>
</html>