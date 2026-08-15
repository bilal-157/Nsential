<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — @yield('title')</title>
     <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='80'>🖊️</text></svg>">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        void: '#0B0A18',
                        panel: '#120F26',
                        card: '#171332',
                        ivory: '#F4F2FA',
                        mist: '#9993B8',
                        cyan: '#3FD8E0',
                        violet: '#9C8CFF',
                        pink: '#F17BC4',
                        hairline: '#2A2650',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-void">
<div class="flex min-h-screen">

    {{-- ===================== MOBILE TOP BAR ===================== --}}
    <div class="lg:hidden fixed top-0 inset-x-0 z-40 flex items-center justify-between bg-panel border-b border-hairline px-4 py-3">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 font-bold text-ivory">
            <span class="w-2 h-2 rounded-full bg-cyan"></span>
            Admin Panel
        </a>
        <button id="sidebarToggleBtn" class="text-ivory p-2 -mr-2" aria-label="Toggle menu">
            <svg id="menuIcon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
            <svg id="closeIcon" class="w-6 h-6 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    {{-- ===================== SIDEBAR OVERLAY (mobile only) ===================== --}}
    <div id="sidebarOverlay" class="hidden lg:hidden fixed inset-0 bg-black/60 z-30"></div>

    {{-- ===================== SIDEBAR ===================== --}}
    <aside id="sidebar"
           class="w-64 lg:w-56 bg-panel border-r border-hairline text-ivory flex-shrink-0 p-4
                  fixed lg:static inset-y-0 left-0 z-40 overflow-y-auto
                  transform -translate-x-full lg:translate-x-0 transition-transform duration-300
                  pt-4 lg:pt-4 mt-14 lg:mt-0 h-[calc(100%-3.5rem)] lg:h-auto">
        <a href="{{ route('admin.dashboard') }}" class="hidden lg:flex items-center gap-2 font-bold text-lg mb-6">
            <span class="w-2 h-2 rounded-full bg-cyan"></span>
            Admin Panel
        </a>

        <nav class="space-y-1 text-sm">
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center px-3 py-2 rounded-md transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-card text-cyan border border-cyan/20' : 'text-mist hover:bg-card hover:text-ivory' }}">
                <i class="fas fa-chart-pie mr-2 w-4"></i> Dashboard
            </a>

            <p class="px-3 pt-4 pb-1 text-[11px] uppercase tracking-wider text-mist/70 font-mono">Manage</p>
            <a href="{{ route('admin.users.index') }}"
               class="flex items-center px-3 py-2 rounded-md transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-card text-violet border border-violet/20' : 'text-mist hover:bg-card hover:text-ivory' }}">
                <i class="fas fa-users mr-2 w-4"></i> Users
            </a>
            <a href="{{ route('admin.posts.index') }}"
               class="flex items-center px-3 py-2 rounded-md transition-colors {{ request()->routeIs('admin.posts.*') ? 'bg-card text-violet border border-violet/20' : 'text-mist hover:bg-card hover:text-ivory' }}">
                <i class="fas fa-newspaper mr-2 w-4"></i>
                <span>Posts</span>
                <span class="text-mist/60 text-[11px] ml-1">(likes, comments, reviews)</span>
            </a>

            <p class="px-3 pt-4 pb-1 text-[11px] uppercase tracking-wider text-mist/70 font-mono">Insights</p>
            <a href="{{ route('admin.analytics.index') }}"
               class="flex items-center px-3 py-2 rounded-md transition-colors {{ request()->routeIs('admin.analytics.*') ? 'bg-card text-pink border border-pink/20' : 'text-mist hover:bg-card hover:text-ivory' }}">
                <i class="fas fa-chart-line mr-2 w-4"></i> Analytics
            </a>

            <a href="/" class="flex items-center px-3 py-2 rounded-md text-mist hover:bg-card hover:text-ivory transition-colors mt-4 border-t border-hairline pt-4">
                <i class="fas fa-arrow-left mr-2 w-4"></i> Back to site
            </a>
        </nav>
    </aside>

    <main class="flex-1 p-4 sm:p-8 overflow-y-auto bg-void mt-14 lg:mt-0 min-w-0">
        @if(session('success'))
            <div class="bg-cyan/10 text-cyan px-4 py-3 rounded-lg mb-4 border border-cyan/20">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-pink/10 text-pink px-4 py-3 rounded-lg mb-4 border border-pink/20">
                <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
            </div>
        @endif
        @yield('content')
    </main>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const toggleBtn = document.getElementById('sidebarToggleBtn');
        const menuIcon = document.getElementById('menuIcon');
        const closeIcon = document.getElementById('closeIcon');

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
            menuIcon.classList.add('hidden');
            closeIcon.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
            menuIcon.classList.remove('hidden');
            closeIcon.classList.add('hidden');
            document.body.style.overflow = '';
        }

        toggleBtn.addEventListener('click', function () {
            if (sidebar.classList.contains('-translate-x-full')) {
                openSidebar();
            } else {
                closeSidebar();
            }
        });

        overlay.addEventListener('click', closeSidebar);

        // Close the sidebar automatically if the viewport is resized up to desktop
        window.addEventListener('resize', function () {
            if (window.innerWidth >= 1024) {
                closeSidebar();
            }
        });
    });
</script>
</body>
</html>