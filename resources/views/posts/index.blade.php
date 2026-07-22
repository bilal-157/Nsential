<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Posts</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

    <!-- Navbar -->
    <nav id="navbar" class="bg-white shadow-md fixed top-0 left-0 right-0 z-50 transition-transform duration-300">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex items-center justify-between h-16">

                <!-- Left: Icon/Logo -->
                <div class="flex items-center flex-shrink-0">
                    <a href="/" class="flex items-center gap-2">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        <span class="font-bold text-lg text-gray-800 hidden sm:inline">MyBlog</span>
                    </a>
                </div>

                <!-- Middle: Search bar -->
                <div class="flex-1 max-w-md mx-4">
                    <div class="relative">
                        <input
                            type="text"
                            id="searchInput"
                            placeholder="Search posts..."
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            oninput="filterPosts(this.value)"
                        >
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>

                <!-- Right: Auth area -->
                <div class="flex-shrink-0 relative">
                    @guest
                        <a href="/login"
                           class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-full transition-colors inline-block">
                            Subscribe
                        </a>
                    @else
                        <button id="userMenuBtn" onclick="toggleUserMenu()"
                                class="flex items-center justify-center w-9 h-9 rounded-full bg-gray-200 hover:bg-gray-300 transition-colors text-gray-700 font-semibold text-sm">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </button>

                        <div id="userMenu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-100 py-1 z-50">
    <div class="px-4 py-2 text-sm text-gray-500 border-b border-gray-100">
        {{ auth()->user()->name }}
    </div>
    @if(in_array(auth()->user()->role, ['admin', 'author']))
        <a href="/profile"
           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
            Profile
        </a>
    @endif
    <form method="POST" action="/logout">
        @csrf
        <button type="submit"
                class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
            Logout
        </button>
    </form>
</div>
                    @endguest
                </div>

            </div>
        </div>
    </nav>

    <div class="h-16"></div> <!-- spacer to offset fixed navbar height -->

    <div class="max-w-6xl mx-auto px-4 py-8">
        <h1 class="text-4xl font-bold text-gray-800 mb-2">Blog Posts</h1>
        <p class="text-gray-600 mb-6">Showing {{ $postCount }} published posts</p>

        <!-- Category filter bar -->
        <div class="flex flex-wrap gap-2 mb-8" id="categoryFilters">
            <button
                type="button"
                class="category-btn px-4 py-1.5 rounded-full text-sm font-medium border border-blue-600 bg-blue-600 text-white transition-colors"
                data-category="all"
                onclick="filterByCategory('all', this)"
            >
                All
            </button>
            @foreach($categories as $category)
            <button
                type="button"
                class="category-btn px-4 py-1.5 rounded-full text-sm font-medium border border-gray-300 text-gray-600 hover:bg-gray-100 transition-colors"
                data-category="{{ $category->slug }}"
                onclick="filterByCategory('{{ $category->slug }}', this)"
            >
                {{ $category->name }}
            </button>
            @endforeach
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="postsGrid">
            @forelse($posts as $post)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300 post-card"
                 data-title="{{ strtolower($post->title) }}"
                 data-content="{{ strtolower($post->content) }}"
                 data-category="{{ $post->category->slug ?? '' }}">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-semibold text-blue-600 uppercase">{{ $post->category->name ?? 'Uncategorized' }}</span>
                        <span class="text-xs text-gray-400">{{ number_format($post->views) }} views</span>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-2 hover:text-blue-600 transition-colors">
                        <a href="/posts/{{ $post->slug }}">{{ $post->title }}</a>
                    </h2>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ Str::limit($post->excerpt, 120) }}</p>
                    <div class="flex justify-between items-center text-sm text-gray-500">
                        <span>{{ $post->published_at ? \Carbon\Carbon::parse($post->published_at)->format('M d, Y') : 'Draft' }}</span>
                        <a href="/posts/{{ $post->slug }}" class="text-blue-600 hover:text-blue-800 font-medium">
                            Read More →
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500 text-lg">No published posts found.</p>
            </div>
            @endforelse
        </div>

        <p id="noResults" class="hidden text-center text-gray-500 text-lg py-12">
            No posts match your search.
        </p>

        <!-- Pagination controls -->
        <div id="paginationControls" class="flex items-center justify-center gap-4 mt-10">
            <button
                id="prevBtn"
                onclick="changePage(-1)"
                class="px-4 py-2 rounded-full border border-gray-300 text-sm font-medium text-gray-600 hover:bg-gray-100 disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:bg-transparent transition-colors"
            >
                ← Previous
            </button>
            <span id="pageIndicator" class="text-sm text-gray-500 font-medium"></span>
            <button
                id="nextBtn"
                onclick="changePage(1)"
                class="px-4 py-2 rounded-full border border-gray-300 text-sm font-medium text-gray-600 hover:bg-gray-100 disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:bg-transparent transition-colors"
            >
                Next →
            </button>
        </div>

        @if($popularPosts->count() > 0)
        <div class="mt-12">
            <h3 class="text-2xl font-bold text-gray-800 mb-4">🔥 Popular Posts</h3>
            <div class="bg-white rounded-lg shadow-md p-6">
                <ul class="space-y-3">
                    @foreach($popularPosts as $post)
                    <li class="flex items-center justify-between border-b border-gray-100 pb-3 last:border-0 last:pb-0">
                        <a href="/posts/{{ $post->slug }}" class="text-gray-700 hover:text-blue-600 transition-colors">
                            {{ $post->title }}
                        </a>
                        <span class="text-sm text-gray-500">{{ number_format($post->views) }} views</span>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        <div class="mt-8 text-center text-sm text-gray-500">
            <p>Total Posts: {{ $postCount }} | Total Views: {{ number_format($totalViews) }}</p>
        </div>
    </div>

    <script>
        const POSTS_PER_PAGE = 9;
        let currentPage = 1;
        let isSearching = false;
        let activeCategory = 'all';

        function getAllCards() {
            return Array.from(document.querySelectorAll('.post-card'));
        }

        function getCategoryFilteredCards() {
            const cards = getAllCards();
            if (activeCategory === 'all') return cards;
            return cards.filter(card => card.dataset.category === activeCategory);
        }

        function renderPage() {
            // Only paginate within the active category
            const allCards = getAllCards();
            const categoryCards = getCategoryFilteredCards();

            allCards.forEach(card => card.style.display = 'none');

            const totalPages = Math.max(1, Math.ceil(categoryCards.length / POSTS_PER_PAGE));
            if (currentPage > totalPages) currentPage = totalPages;
            if (currentPage < 1) currentPage = 1;

            const start = (currentPage - 1) * POSTS_PER_PAGE;
            const end = start + POSTS_PER_PAGE;

            categoryCards.forEach((card, index) => {
                card.style.display = (index >= start && index < end) ? '' : 'none';
            });

            document.getElementById('pageIndicator').textContent = `Page ${currentPage} of ${totalPages}`;
            document.getElementById('prevBtn').disabled = currentPage === 1;
            document.getElementById('nextBtn').disabled = currentPage === totalPages;
            document.getElementById('paginationControls').classList.toggle('hidden', categoryCards.length === 0);
            document.getElementById('noResults').classList.toggle('hidden', categoryCards.length !== 0);
        }

        function changePage(direction) {
            currentPage += direction;
            renderPage();
            document.getElementById('navbar').style.transform = 'translateY(0)';
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function filterByCategory(category, btnEl) {
            activeCategory = category;
            currentPage = 1;

            // Reset search when switching category
            document.getElementById('searchInput').value = '';
            isSearching = false;

            // Update active button styles
            document.querySelectorAll('.category-btn').forEach(btn => {
                btn.classList.remove('bg-blue-600', 'text-white', 'border-blue-600');
                btn.classList.add('border-gray-300', 'text-gray-600');
            });
            btnEl.classList.remove('border-gray-300', 'text-gray-600');
            btnEl.classList.add('bg-blue-600', 'text-white', 'border-blue-600');

            renderPage();
        }

        function filterPosts(query) {
            const term = query.trim().toLowerCase();
            const cards = getCategoryFilteredCards();
            isSearching = term.length > 0;

            let visibleCount = 0;

            if (isSearching) {
                // While searching: show all matches within active category, ignore pagination
                getAllCards().forEach(card => card.style.display = 'none');
                cards.forEach(card => {
                    const title = card.dataset.title || '';
                    const content = card.dataset.content || '';
                    const matches = title.includes(term) || content.includes(term);
                    card.style.display = matches ? '' : 'none';
                    if (matches) visibleCount++;
                });
                document.getElementById('paginationControls').classList.add('hidden');
                document.getElementById('noResults').classList.toggle('hidden', visibleCount !== 0);
            } else {
                document.getElementById('noResults').classList.add('hidden');
                currentPage = 1;
                renderPage();
            }
        }

        function toggleUserMenu() {
            document.getElementById('userMenu').classList.toggle('hidden');
        }

        document.addEventListener('click', function (e) {
            const menu = document.getElementById('userMenu');
            const btn = document.getElementById('userMenuBtn');
            if (!menu || !btn) return;
            if (!menu.contains(e.target) && !btn.contains(e.target)) {
                menu.classList.add('hidden');
            }
        });

        (function () {
            const navbar = document.getElementById('navbar');
            let lastScrollY = window.scrollY;
            let ticking = false;
            const threshold = 10;

            function handleScroll() {
                const currentScrollY = window.scrollY;
                const delta = currentScrollY - lastScrollY;

                if (currentScrollY <= 50) {
                    navbar.style.transform = 'translateY(0)';
                } else if (Math.abs(delta) > threshold) {
                    if (delta > 0) {
                        navbar.style.transform = 'translateY(-100%)';
                    } else {
                        navbar.style.transform = 'translateY(0)';
                    }
                    lastScrollY = currentScrollY;
                }

                ticking = false;
            }

            window.addEventListener('scroll', function () {
                if (!ticking) {
                    window.requestAnimationFrame(handleScroll);
                    ticking = true;
                }
            }, { passive: true });
        })();

        renderPage();
    </script>

</body>
</html>