<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
</head>
<body class="bg-gray-50">

    <div class="max-w-2xl mx-auto px-4 py-12">
        <a href="/" class="text-sm text-blue-600 hover:text-blue-800">&larr; Back to posts</a>

        <h1 class="text-3xl font-bold text-gray-800 mt-4 mb-2">Edit Profile</h1>
        <p class="text-gray-600 mb-8">Update your name, email, and bio.</p>

        @if (session('status') === 'profile-updated')
            <div class="mb-6 rounded-md bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3">
                Profile updated successfully.
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 rounded-md bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" class="bg-white rounded-lg shadow-md p-6 space-y-6">
            @csrf
            @method('PATCH')

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                       class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                       class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>

            <div>
                <label for="bio" class="block text-sm font-medium text-gray-700 mb-1">Bio</label>
                <textarea name="bio" id="bio" rows="4"
                          class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('bio', $user->bio) }}</textarea>
                <p class="text-xs text-gray-400 mt-1">Max 1000 characters. Shown on your author profile.</p>
            </div>

            <div>
                <span class="block text-sm font-medium text-gray-700 mb-1">Role</span>
                <span class="inline-block px-3 py-1 text-xs font-semibold uppercase rounded-full bg-gray-100 text-gray-600">
                    {{ $user->role }}
                </span>
            </div>

            <div class="pt-2">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-5 py-2 rounded-full transition-colors">
                    Save Changes
                </button>
            </div>
        </form>

        <!-- Your Posts -->
        <div class="mt-10">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Your Posts</h2>

            @if($posts->isEmpty())
                <div class="bg-white rounded-lg shadow-md p-6 text-center text-gray-500 text-sm">
                    You haven't written any posts yet.
                </div>
            @else
                <!-- Views per post chart -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h3 class="text-sm font-semibold text-gray-700 mb-4">Views per Post</h3>
                    <canvas id="viewsChart" height="120"></canvas>
                </div>

                <!-- Posts table -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                            <tr>
                                <th class="text-left px-4 py-3">Title</th>
                                <th class="text-left px-4 py-3">Category</th>
                                <th class="text-left px-4 py-3">Status</th>
                                <th class="text-left px-4 py-3">Published</th>
                                <th class="text-right px-4 py-3">Views</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($posts as $post)
                            <tr>
                                <td class="px-4 py-3">
                                    <a href="/posts/{{ $post->slug }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                        {{ $post->title }}
                                    </a>
                                </td>
                                <td class="px-4 py-3 text-gray-500">{{ $post->category->name ?? '—' }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold
                                        {{ $post->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                        {{ $post->status }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-gray-500">
                                    {{ $post->published_at ? \Carbon\Carbon::parse($post->published_at)->format('M d, Y') : '—' }}
                                </td>
                                <td class="px-4 py-3 text-right font-medium text-gray-700">
                                    {{ number_format($post->views) }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    @if($posts->isNotEmpty())
    <script>
        const chartLabels = {!! $posts->map(function ($post) {
            return \Illuminate\Support\Str::limit($post->title, 25);
        })->toJson() !!};

        const chartDates = {!! $posts->map(function ($post) {
            return $post->published_at
                ? \Carbon\Carbon::parse($post->published_at)->format('M d, Y')
                : 'Unpublished';
        })->toJson() !!};

        const chartData = {!! $posts->pluck('views')->toJson() !!};

        new Chart(document.getElementById('viewsChart'), {
            type: 'bar',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Views',
                    data: chartData,
                    backgroundColor: '#2563eb',
                    borderRadius: 4,
                    maxBarThickness: 50,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            title: function (items) {
                                const i = items[0].dataIndex;
                                return chartDates[i];
                            },
                            label: function (item) {
                                return `Views: ${item.formattedValue}`;
                            },
                            afterTitle: function (items) {
                                const i = items[0].dataIndex;
                                return chartLabels[i];
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { precision: 0 }
                    },
                    x: {
                        ticks: {
                            maxRotation: 45,
                            minRotation: 45
                        }
                    }
                }
            }
        });
    </script>
    @endif

</body>
</html>