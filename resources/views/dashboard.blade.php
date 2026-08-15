<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <!-- Simple Navbar -->
    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="/" class="text-xl font-bold text-gray-800 hover:text-blue-600">
                        MyBlog
                    </a>
                </div>
                <div class="flex items-center gap-4">
                    <a href="/" class="text-gray-700 hover:text-blue-600">Home</a>

                    @if(in_array(auth()->user()->role, ['author', 'admin']))
                        <a href="/posts/create" class="text-gray-700 hover:text-blue-600">Write Post</a>
                    @endif

                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-blue-600">Admin Panel</a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
            <p class="text-gray-600 mt-2">Welcome, {{ auth()->user()->name ?? 'User' }}!</p>

            <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-blue-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-blue-800">Total Posts</h3>
                    <p class="text-2xl font-bold text-blue-600">{{ DB::table('posts')->count() }}</p>
                </div>
                <div class="bg-green-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-green-800">Published</h3>
                    <p class="text-2xl font-bold text-green-600">{{ DB::table('posts')->where('status', 'published')->count() }}</p>
                </div>
                <div class="bg-purple-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-purple-800">Total Views</h3>
                    <p class="text-2xl font-bold text-purple-600">{{ number_format(DB::table('posts')->sum('views')) }}</p>
                </div>
            </div>

            <div class="mt-6 flex gap-3">
                @if(in_array(auth()->user()->role, ['author', 'admin']))
                    <a href="/posts/create" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg inline-block">
                        + Write New Post
                    </a>
                @endif
                <a href="/" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg inline-block">
                    View Blog
                </a>
            </div>
        </div>
    </div>
</body>
</html>