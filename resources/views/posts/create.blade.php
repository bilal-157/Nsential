<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Post</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

    <!-- Navbar -->
    <nav class="bg-white shadow-md">
        <div class="max-w-3xl mx-auto px-4">
            <div class="flex items-center justify-between h-16">
                <a href="/" class="flex items-center gap-2">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    <span class="font-bold text-lg text-gray-800">MyBlog</span>
                </a>
                <a href="/" class="text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors">
                    &larr; Back to Posts
                </a>
            </div>
        </div>
    </nav>

    <div class="max-w-3xl mx-auto px-4 py-10">
        <h1 class="text-3xl font-bold text-gray-800 mb-1">Create New Post</h1>
        <p class="text-gray-600 mb-8">Fill in the details below to publish a new blog post.</p>

        @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 rounded-lg p-4 mb-6">
            <p class="font-semibold mb-1">Please fix the following:</p>
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Posting as (auto-filled from logged-in author's profile) -->
        <div class="flex items-center gap-3 mb-6 p-4 bg-white rounded-lg shadow-sm border border-gray-100">
            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-semibold flex-shrink-0">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div>
                <p class="text-xs text-gray-400">Posting as</p>
                <p class="font-semibold text-gray-800 text-sm">{{ auth()->user()->name }}</p>
                @if(auth()->user()->bio)
                <p class="text-xs text-gray-500">{{ Str::limit(auth()->user()->bio, 100) }}</p>
                @endif
            </div>
        </div>

        <form action="{{ route('posts.store') }}" method="POST" class="bg-white rounded-lg shadow-md p-6 space-y-5">
            @csrf

            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                <input
                    type="text"
                    name="title"
                    id="title"
                    value="{{ old('title') }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Enter post title"
                    required
                >
            </div>

            <!-- Category -->
            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                <select
                    name="category_id"
                    id="category_id"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    required
                >
                    <option value="" disabled selected>Select a category</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" @if((int) old('category_id') === $category->id) selected @endif>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Content -->
            <div>
                <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Content</label>
                <textarea
                    name="content"
                    id="content"
                    rows="8"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Write your post content here..."
                    required
                >{{ old('content') }}</textarea>
            </div>

            <!-- Status + Publish Date -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select
                        name="status"
                        id="status"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                        <option value="draft" @if(old('status') === 'draft') selected @endif>Draft</option>
                        <option value="published" @if(old('status') === 'published') selected @endif>Published</option>
                    </select>
                </div>

                <div>
                    <label for="published_at" class="block text-sm font-medium text-gray-700 mb-1">Publish Date</label>
                    <input
                        type="datetime-local"
                        name="published_at"
                        id="published_at"
                        value="{{ old('published_at') }}"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                    <p class="text-xs text-gray-400 mt-1">Leave blank to keep as draft with no date.</p>
                </div>
            </div>


            <!-- Featured Image -->
            <div>
                <label for="featured_image" class="block text-sm font-medium text-gray-700 mb-1">Featured Image URL</label>
                <input
                    type="url"
                    name="featured_image"
                    id="featured_image"
                    value="{{ old('featured_image') }}"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="https://example.com/image.jpg"
                >
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="/" class="px-4 py-2 rounded-full border border-gray-300 text-sm font-medium text-gray-600 hover:bg-gray-100 transition-colors">
                    Cancel
                </a>
                <button
                    type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-6 py-2 rounded-full transition-colors"
                >
                    Publish Post
                </button>
            </div>
        </form>
    </div>

</body>
</html>