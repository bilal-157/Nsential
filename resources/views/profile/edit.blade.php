<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile · MyBlog</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@500&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-base: #0a0a14;
            --card-bg: rgba(255, 255, 255, 0.04);
            --card-border: rgba(255, 255, 255, 0.09);
            --cyan: #22d3ee;
            --violet: #a78bfa;
            --text-muted: #9398ab;
        }

        html { scroll-behavior: smooth; }
        * { -webkit-font-smoothing: antialiased; }
        ::selection { background: rgba(34, 211, 238, 0.25); }

        body {
            background: var(--bg-base);
            font-family: 'Inter', system-ui, sans-serif;
            color: #f2f3f7;
            position: relative;
            overflow-x: hidden;
        }

        h1, h2, h3, .display { font-family: 'Space Grotesk', 'Inter', sans-serif; }
        .mono-label { font-family: 'JetBrains Mono', monospace; letter-spacing: 0.14em; }

        .thin-scroll::-webkit-scrollbar { width: 6px; height: 6px; }
        .thin-scroll::-webkit-scrollbar-track { background: transparent; }
        .thin-scroll::-webkit-scrollbar-thumb { background: rgba(34, 211, 238, 0.35); border-radius: 999px; }
        .thin-scroll { scrollbar-width: thin; scrollbar-color: rgba(34,211,238,0.35) transparent; }

        .hero-wash {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            background:
                radial-gradient(1100px 620px at 8% -10%, rgba(88, 28, 135, 0.38), transparent 60%),
                radial-gradient(900px 560px at 95% 10%, rgba(13, 148, 136, 0.30), transparent 60%),
                var(--bg-base);
        }
        .hero-wash::after {
            content: "";
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.025) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.025) 1px, transparent 1px);
            background-size: 34px 34px;
            mask-image: radial-gradient(circle at 30% 0%, black, transparent 70%);
        }

        .content-wrap { position: relative; z-index: 1; }

        .grad-text {
            background: linear-gradient(90deg, var(--cyan), var(--violet));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            backdrop-filter: blur(14px);
            transition: border-color 0.25s ease, transform 0.25s ease, box-shadow 0.25s ease;
        }
        .card:hover {
            border-color: rgba(255, 255, 255, 0.16);
            box-shadow: 0 12px 40px -18px rgba(0, 0, 0, 0.6);
        }

        .field {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.10);
            transition: border-color 0.2s ease, background 0.2s ease, box-shadow 0.2s ease;
        }
        .field:focus {
            outline: none;
            border-color: rgba(34, 211, 238, 0.6);
            background: rgba(255, 255, 255, 0.05);
            box-shadow: 0 0 0 4px rgba(34, 211, 238, 0.12);
        }

        .btn-primary {
            background: linear-gradient(90deg, #a5f3fc, #ddd6fe);
            color: #0a0b14;
            font-weight: 600;
            transition: transform 0.2s ease, box-shadow 0.2s ease, filter 0.2s ease;
        }
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 30px -10px rgba(167, 139, 250, 0.45);
            filter: brightness(1.04);
        }
        .btn-primary:active { transform: translateY(0); }

        .btn-ghost {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.14);
            color: #e5e7eb;
            transition: background 0.2s ease, border-color 0.2s ease;
        }
        .btn-ghost:hover {
            background: rgba(255, 255, 255, 0.06);
            border-color: rgba(255, 255, 255, 0.24);
        }

        .chip-btn {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.10);
            color: #cbd5e1;
            transition: background 0.18s ease, border-color 0.18s ease, transform 0.18s ease;
        }
        .chip-btn:hover {
            background: rgba(34, 211, 238, 0.08);
            border-color: rgba(34, 211, 238, 0.35);
            transform: translateY(-1px);
        }

        .float-overlay {
            position: fixed;
            inset: 0;
            z-index: 60;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            background: rgba(5, 5, 12, 0.65);
            backdrop-filter: blur(6px);
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.22s ease;
        }
        .float-overlay.active { opacity: 1; pointer-events: auto; }

        .float-box {
            width: 100%;
            max-width: 380px;
            max-height: 72vh;
            display: flex;
            flex-direction: column;
            background: #101019;
            border: 1px solid rgba(255, 255, 255, 0.10);
            border-radius: 20px;
            box-shadow: 0 25px 70px -20px rgba(0, 0, 0, 0.65), 0 0 0 1px rgba(34, 211, 238, 0.05);
            transform: scale(0.93) translateY(10px);
            transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .float-overlay.active .float-box { transform: scale(1) translateY(0); }

        .float-header {
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .star { color: rgba(255,255,255,0.15); }
        .star.filled { color: #facc15; }

        @keyframes rise {
            from { opacity: 0; transform: translateY(14px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .rise { animation: rise 0.6s cubic-bezier(0.16, 1, 0.3, 1) both; }
        .d1 { animation-delay: 0.02s; }
        .d2 { animation-delay: 0.08s; }
        .d3 { animation-delay: 0.14s; }
        .d4 { animation-delay: 0.20s; }
        .d5 { animation-delay: 0.26s; }

        @media (prefers-reduced-motion: reduce) {
            .rise { animation: none !important; }
            .card, .btn-primary, .btn-ghost, .field, .float-overlay, .float-box, .chip-btn { transition: none !important; }
        }

        /* Mobile tightening */
        @media (max-width: 480px) {
            .float-box { max-height: 80vh; border-radius: 16px; }
        }
        @media (max-width: 380px) {
            .btn-primary, .btn-ghost { width: 100%; text-align: center; }
        }
    </style>
</head>
<body>

    <div class="hero-wash"></div>

    <div class="content-wrap max-w-2xl mx-auto px-4 sm:px-6 py-8 sm:py-12">

        <!-- Header -->
        <div class="rise d1 mb-10">
            <div class="flex items-start justify-between gap-4 flex-wrap">
                <div>
                    <h1 class="text-3xl sm:text-4xl font-bold tracking-tight mb-2">
                        Edit your <span class="grad-text">profile.</span>
                    </h1>
                    <p class="text-gray-400 text-sm">Update your name, email, and bio.</p>
                </div>
                @if(in_array(auth()->user()->role, ['author', 'admin']))
                    <a href="/posts/create" class="btn-ghost text-sm px-5 py-2.5 rounded-full whitespace-nowrap transition-colors">
                        Write Post
                    </a>
                @endif
            </div>
        </div>

        @if (session('status') === 'profile-updated')
            <div class="rise d2 mb-6 rounded-xl bg-emerald-400/10 border border-emerald-400/25 text-emerald-300 text-sm px-4 py-3 flex items-center gap-2">
                <span aria-hidden="true">✓</span> Profile updated successfully.
            </div>
        @endif

        @if ($errors->any())
            <div class="rise d2 mb-6 rounded-xl bg-rose-400/10 border border-rose-400/25 text-rose-300 text-sm px-4 py-3">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" class="rise d2 card rounded-2xl p-5 sm:p-6 space-y-6">
            @csrf
            @method('PATCH')

            <div>
                <label for="name" class="mono-label block text-xs text-gray-400 uppercase mb-2">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                       class="field w-full rounded-lg px-3 py-2.5 text-sm text-gray-100 placeholder-gray-500">
            </div>

            <div>
                <label for="email" class="mono-label block text-xs text-gray-400 uppercase mb-2">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                       class="field w-full rounded-lg px-3 py-2.5 text-sm text-gray-100 placeholder-gray-500">
            </div>

            <div>
                <label for="bio" class="mono-label block text-xs text-gray-400 uppercase mb-2">Bio</label>
                <textarea name="bio" id="bio" rows="4"
                          class="field w-full rounded-lg px-3 py-2.5 text-sm text-gray-100 placeholder-gray-500 resize-none">{{ old('bio', $user->bio) }}</textarea>
                <p class="text-xs text-gray-500 mt-2">Max 1000 characters. Shown on your author profile.</p>
            </div>

            <div>
                <span class="mono-label block text-xs text-gray-400 uppercase mb-2">Role</span>
                <span class="inline-block px-3 py-1 text-xs font-semibold uppercase rounded-full bg-white/5 border border-white/10 text-gray-300">
                    {{ $user->role }}
                </span>
            </div>

            <div class="pt-2 flex items-center gap-3 flex-wrap">
                <button type="submit" class="btn-primary text-sm px-6 py-2.5 rounded-full">
                    Save Changes
                </button>
                <a href="/" class="btn-ghost text-sm px-6 py-2.5 rounded-full transition-colors">
                    Back to Posts
                </a>
            </div>
        </form>

        <!-- Your Posts -->
        <div class="mt-14">
            <div class="rise d3 flex items-end justify-between mb-6 flex-wrap gap-4">
                <div>
                    <p class="mono-label text-xs text-cyan-300 uppercase mb-2">— Your Library</p>
                    <h2 class="text-2xl font-bold">Your posts</h2>
                </div>
                @if($posts->isNotEmpty())
                <div class="flex gap-5 sm:gap-6">
                    <div>
                        <p class="text-xl font-bold">{{ $posts->count() }}</p>
                        <p class="mono-label text-[10px] text-gray-500 uppercase">Posts</p>
                    </div>
                    <div>
                        <p class="text-xl font-bold">{{ $posts->where('status', 'published')->count() }}</p>
                        <p class="mono-label text-[10px] text-gray-500 uppercase">Published</p>
                    </div>
                    <div>
                        <p class="text-xl font-bold">{{ number_format($posts->sum('views')) }}</p>
                        <p class="mono-label text-[10px] text-gray-500 uppercase">Views</p>
                    </div>
                </div>
                @endif
            </div>

            @if($posts->isEmpty())
                <div class="rise d4 card rounded-2xl p-8 sm:p-10 text-center">
                    <p class="text-gray-300 font-medium mb-1">No posts yet</p>
                    <p class="text-gray-500 text-sm mb-5">Your published and draft posts will show up here.</p>
                    @if(in_array(auth()->user()->role, ['author', 'admin']))
                        <a href="/posts/create" class="btn-primary inline-block text-sm px-6 py-2.5 rounded-full">
                            Write your first post
                        </a>
                    @endif
                </div>
            @else
                <!-- Views per post chart -->
                <div class="rise d4 card rounded-2xl p-4 sm:p-6 mb-6">
                    <h3 class="mono-label text-xs text-gray-400 uppercase mb-4">Views per Post</h3>
                    <div class="overflow-x-auto thin-scroll">
                        <canvas id="viewsChart" height="120"></canvas>
                    </div>
                </div>

                <!-- Posts list, styled as feature cards like the homepage's post card -->
                <div class="space-y-4">
                    @foreach($posts as $post)
                    @php
                        $comments = $post->comments ?? collect();
                        $reviews = $post->reviews ?? collect();
                        $avgRating = $reviews->count() ? round($reviews->avg('rating')) : 0;
                    @endphp
                    <div class="rise d5 card rounded-2xl p-4 sm:p-5">
                        <div class="flex items-start justify-between gap-3 mb-1">
                            <p class="mono-label text-[10px] text-cyan-300 uppercase">
                                {{ $post->category->name ?? 'Uncategorized' }}
                            </p>
                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold shrink-0
                                {{ $post->status === 'published' ? 'bg-emerald-400/10 text-emerald-300 border border-emerald-400/25' : 'bg-white/5 text-gray-400 border border-white/10' }}">
                                {{ $post->status }}
                            </span>
                        </div>

                        <a href="/{{ $post->slug }}" class="block text-base sm:text-lg font-bold text-gray-100 hover:text-cyan-300 transition-colors mb-3">
                            {{ $post->title }}
                        </a>

                        <div class="border-t border-white/8 pt-3 flex items-center justify-between flex-wrap gap-3">
                            <p class="text-xs text-gray-500">
                                {{ $post->published_at ? \Carbon\Carbon::parse($post->published_at)->format('M d, Y') : 'Unpublished' }}
                                &middot; {{ number_format($post->views) }} views
                            </p>

                            <div class="flex items-center gap-2">
                                <button type="button"
                                        class="chip-btn rounded-full px-3 py-1.5 text-xs font-medium flex items-center gap-1.5"
                                        onclick="openFloat('comments-{{ $post->id }}', '{{ addslashes($post->title) }}', 'Comments')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                                    {{ $comments->count() }}
                                </button>
                                <button type="button"
                                        class="chip-btn rounded-full px-3 py-1.5 text-xs font-medium flex items-center gap-1.5"
                                        onclick="openFloat('reviews-{{ $post->id }}', '{{ addslashes($post->title) }}', 'Reviews')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11.48 3.5a.56.56 0 0 1 1.04 0l2.34 5.06a.56.56 0 0 0 .42.31l5.6.7c.5.06.7.68.32 1.02l-4.13 3.73a.56.56 0 0 0-.17.53l1.2 5.4c.11.5-.42.9-.87.64l-4.9-2.87a.56.56 0 0 0-.57 0l-4.9 2.87c-.45.26-.98-.14-.87-.64l1.2-5.4a.56.56 0 0 0-.17-.53L2.9 10.6a.56.56 0 0 1 .32-1.02l5.6-.7a.56.56 0 0 0 .42-.31z"/></svg>
                                    {{ $reviews->count() }}
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden content, cloned into the floating window on click -->
                    <template id="comments-{{ $post->id }}">
                        @forelse($comments as $comment)
                            <div class="py-3 border-b border-white/6 last:border-0">
                                <div class="flex items-center justify-between mb-1">
                                    <p class="text-sm font-medium text-gray-200">{{ optional($comment->user)->name ?? $comment->author_name ?? 'Anonymous' }}</p>
                                    <p class="text-[11px] text-gray-500">{{ optional($comment->created_at)->diffForHumans() }}</p>
                                </div>
                                <p class="text-sm text-gray-400 leading-relaxed">{{ $comment->body }}</p>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 text-center py-6">No comments yet.</p>
                        @endforelse
                    </template>

                    <template id="reviews-{{ $post->id }}">
                        @forelse($reviews as $review)
                            <div class="py-3 border-b border-white/6 last:border-0">
                                <div class="flex items-center justify-between mb-1">
                                    <p class="text-sm font-medium text-gray-200">{{ optional($review->user)->name ?? $review->reviewer_name ?? 'Anonymous' }}</p>
                                    <p class="text-[11px] text-gray-500">{{ optional($review->created_at)->diffForHumans() }}</p>
                                </div>
                                <div class="flex gap-0.5 mb-1">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <span class="star {{ $i <= $review->rating ? 'filled' : '' }}">&#9733;</span>
                                    @endfor
                                </div>
                                <p class="text-sm text-gray-400 leading-relaxed">{{ $review->body ?? $review->comment }}</p>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 text-center py-6">No reviews yet.</p>
                        @endforelse
                    </template>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Floating window shell, shared by comments + reviews -->
    <div id="floatOverlay" class="float-overlay" onclick="if(event.target === this) closeFloat()">
        <div class="float-box thin-scroll">
            <div class="float-header px-5 py-4 flex items-start justify-between gap-3 shrink-0">
                <div>
                    <p id="floatKind" class="mono-label text-[10px] text-cyan-300 uppercase mb-1">Comments</p>
                    <p id="floatTitle" class="text-sm font-semibold text-gray-100 leading-snug"></p>
                </div>
                <button type="button" onclick="closeFloat()" class="shrink-0 w-7 h-7 rounded-full flex items-center justify-center text-gray-400 hover:text-white hover:bg-white/10 transition-colors" aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 6 6 18M6 6l12 12"/></svg>
                </button>
            </div>
            <div id="floatBody" class="thin-scroll px-5 py-1 overflow-y-auto"></div>
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

        const ctx = document.getElementById('viewsChart');
        const gradient = ctx.getContext('2d').createLinearGradient(0, 0, 0, 220);
        gradient.addColorStop(0, '#22d3ee');
        gradient.addColorStop(1, '#a78bfa');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Views',
                    data: chartData,
                    backgroundColor: gradient,
                    borderRadius: 6,
                    maxBarThickness: 46,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                animation: { duration: 900, easing: 'easeOutQuart' },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#12131d',
                        titleColor: '#f2f3f7',
                        bodyColor: '#9398ab',
                        borderColor: 'rgba(255,255,255,0.1)',
                        borderWidth: 1,
                        padding: 10,
                        cornerRadius: 8,
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
                        ticks: { precision: 0, color: '#6b7080' },
                        grid: { color: 'rgba(255,255,255,0.05)' }
                    },
                    x: {
                        ticks: {
                            maxRotation: 45,
                            minRotation: 45,
                            color: '#6b7080'
                        },
                        grid: { display: false }
                    }
                }
            }
        });
    </script>
    @endif

    <script>
        // Floating comments/reviews windows: clones a server-rendered <template>
        // into the shared overlay so no extra network request is needed.
        const floatOverlay = document.getElementById('floatOverlay');
        const floatBody = document.getElementById('floatBody');
        const floatTitle = document.getElementById('floatTitle');
        const floatKind = document.getElementById('floatKind');
        let lastFocused = null;

        function openFloat(templateId, postTitle, kind) {
            const tpl = document.getElementById(templateId);
            if (!tpl) return;
            floatBody.innerHTML = '';
            floatBody.appendChild(tpl.content.cloneNode(true));
            floatTitle.textContent = postTitle;
            floatKind.textContent = kind;
            lastFocused = document.activeElement;
            floatOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeFloat() {
            floatOverlay.classList.remove('active');
            document.body.style.overflow = '';
            if (lastFocused) lastFocused.focus();
        }

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && floatOverlay.classList.contains('active')) closeFloat();
        });
    </script>

</body>
</html>