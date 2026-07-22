<!DOCTYPE html>
<html lang="en" x-data="admin()" x-init="init()" :class="{ 'dark': dark }">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Admin — Posts | The Daily Byte</title>

<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    darkMode: 'class',
    theme: {
      extend: {
        fontFamily: {
          serif: ['"Fraunces"', 'ui-serif', 'Georgia', 'serif'],
          sans: ['"Inter"', 'ui-sans-serif', 'system-ui'],
        },
        colors: {
          cream:  '#FBEFEF',
          blush:  '#FFE2E2',
          rose:   '#F5CBCB',
          lilac:  '#C5B3D3',
          plum:   '#5B3A5F',
          night:   { DEFAULT:'#1B1023', card:'#241531', line:'#3A2447' },
          coral:   '#FF6B8B',
          violet:  '#B983FF',
        }
      }
    }
  }
</script>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,600;9..144,800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<style>
  html { scroll-behavior:smooth; }
  body { font-family:'Inter', system-ui, sans-serif; }
  .font-display { font-family:'Fraunces', serif; letter-spacing:-0.02em; }
  .glass { backdrop-filter: saturate(160%) blur(14px); -webkit-backdrop-filter: saturate(160%) blur(14px); }
  .link-underline { background-image: linear-gradient(currentColor, currentColor); background-position: 0 100%; background-repeat:no-repeat; background-size: 0 1.5px; transition: background-size .3s ease; }
  .link-underline:hover { background-size: 100% 1.5px; }
  .pill-active { background:#5B3A5F; color:#FFF3F3; }
  .dark .pill-active { background:#FF6B8B; color:#1B1023; }
  [x-cloak] { display:none !important; }
  ::selection { background:#C5B3D3; color:#2A1633; }
  .row-hover { transition: background-color .2s ease; }
</style>
</head>

<body class="bg-cream dark:bg-night text-plum dark:text-rose antialiased min-h-screen">

<!-- ============ NAV ============ -->
<header class="sticky top-0 z-40 glass bg-cream/80 dark:bg-night/80 border-b border-rose/60 dark:border-night-line/60">
  <nav class="max-w-6xl mx-auto px-5 sm:px-8 h-16 flex items-center justify-between gap-4">
    <a href="/admin/posts" class="flex items-center gap-2 group shrink-0">
      <span class="w-8 h-8 rounded-lg bg-plum dark:bg-coral grid place-items-center text-cream dark:text-night font-display font-bold">D</span>
      <span class="font-display text-lg font-semibold tracking-tight">The Daily Byte</span>
      <span class="ml-2 px-2.5 py-0.5 rounded-full text-[11px] font-semibold uppercase tracking-wider bg-rose/70 dark:bg-night-card text-plum dark:text-coral">Admin</span>
    </a>

    <div class="flex items-center gap-3 shrink-0">
      <span class="text-sm text-plum/60 dark:text-rose/60 hidden sm:inline">{{ auth()->user()->name }}</span>
      <button @click="toggleTheme()" aria-label="Toggle theme" class="w-9 h-9 grid place-items-center rounded-full hover:bg-blush dark:hover:bg-night-card transition">
        <svg x-show="!dark" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"/></svg>
        <svg x-show="dark" x-cloak width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
      </button>
    </div>
  </nav>
</header>

<!-- ============ MAIN ============ -->
<main class="max-w-6xl mx-auto px-5 sm:px-8 py-10">

  @if (session('success'))
    <div class="mb-6 px-4 py-3 rounded-xl bg-lilac/40 dark:bg-violet/20 text-plum dark:text-violet text-sm font-medium">
      {{ session('success') }}
    </div>
  @endif

  <!-- header row -->
  <div class="flex items-center justify-between mb-8 flex-wrap gap-4">
    <div>
      <h1 class="font-display text-2xl sm:text-3xl font-semibold">All Posts</h1>
      <p class="text-sm text-plum/60 dark:text-rose/60 mt-1">{{ $posts->count() }} total</p>
    </div>
    <a href="/admin/posts/create"
      class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-plum dark:bg-coral text-cream dark:text-night text-sm font-medium hover:brightness-105 active:scale-95 transition">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>
      New Post
    </a>
  </div>

  <!-- table -->
  <div class="bg-cream dark:bg-night-card border border-rose/60 dark:border-night-line rounded-2xl overflow-hidden">
    <table class="w-full text-sm">
      <thead>
        <tr class="border-b border-rose/60 dark:border-night-line text-left text-xs uppercase tracking-wider text-plum/60 dark:text-rose/60">
          <th class="px-5 py-3">Title</th>
          <th class="px-5 py-3 hidden sm:table-cell">Status</th>
          <th class="px-5 py-3 hidden sm:table-cell">Date</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($posts as $post)
        <tr class="row-hover border-b border-rose/40 dark:border-night-line/60 hover:bg-blush/40 dark:hover:bg-night/40">
          <td class="px-5 py-4 font-medium max-w-xs truncate">{{ $post->title }}</td>
          <td class="px-5 py-4 hidden sm:table-cell">
            <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold uppercase tracking-wider
              {{ $post->status === 'published' ? 'bg-lilac/40 dark:bg-violet/20 text-plum dark:text-violet' : 'bg-rose/40 dark:bg-night text-plum/70 dark:text-rose/50' }}">
              {{ $post->status }}
            </span>
          </td>
          <td class="px-5 py-4 hidden sm:table-cell text-plum/60 dark:text-rose/60">{{ $post->created_at->format('M j, Y') }}</td>
        </tr>
        @empty
        <tr>
          <td colspan="3" class="px-5 py-10 text-center text-plum/50 dark:text-rose/50">No posts yet — create your first one.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</main>

<script>
function admin() {
  return {
    dark: false,
    toggleTheme() {
      this.dark = !this.dark;
      document.cookie = `theme=${this.dark?'dark':'light'};path=/;max-age=31536000`;
    },
    init() {
      const m = document.cookie.match(/theme=(dark|light)/);
      this.dark = m ? m[1]==='dark' : window.matchMedia('(prefers-color-scheme: dark)').matches;
    }
  }
}
</script>
</body>
</html>