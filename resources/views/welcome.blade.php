<!DOCTYPE html>
<html lang="en" x-data="site()" x-init="init()" :class="{ 'dark': dark }">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>The Daily Byte — Stories on Engineering, Design & Product</title>
<meta name="description" content="Thoughtful, well-crafted stories on engineering, design and product from The Daily Byte." />

<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    darkMode: 'class',
    theme: {
      extend: {
        screens: { xs: '400px' },
        fontFamily: {
          serif: ['"Fraunces"', 'ui-serif', 'Georgia', 'serif'],
          sans: ['"Inter"', 'ui-sans-serif', 'system-ui'],
        },
        colors: {
          /* ===== Light palette (colorhunt.co/fbefef-ffe2e2-f5cbcb-c5b3d3) ===== */
          cream:  '#FBEFEF',
          blush:  '#FFE2E2',
          rose:   '#F5CBCB',
          lilac:  '#C5B3D3',
          plum:   '#5B3A5F',
          /* ===== Dark palette — deep aubergine + neon coral/violet ===== */
          night:   { DEFAULT:'#1B1023', card:'#241531', line:'#3A2447' },
          coral:   '#FF6B8B',
          violet:  '#B983FF',
        },
        keyframes: {
          floaty: { '0%,100%':{ transform:'translateY(0)' }, '50%':{ transform:'translateY(-8px)' } },
          shimmer: { '0%':{ backgroundPosition:'-200% 0' }, '100%':{ backgroundPosition:'200% 0' } },
          fadeUp: { '0%':{ opacity:0, transform:'translateY(20px)' }, '100%':{ opacity:1, transform:'translateY(0)' } },
          gradientShift: { '0%,100%':{ backgroundPosition:'0% 50%' }, '50%':{ backgroundPosition:'100% 50%' } },
          blink: { '0%,100%':{ opacity:1 }, '50%':{ opacity:.3 } },
        },
        animation: {
          floaty: 'floaty 7s ease-in-out infinite',
          shimmer: 'shimmer 2.5s linear infinite',
          fadeUp: '.6s cubic-bezier(.2,.7,.2,1) both',
          gradientShift: 'gradientShift 8s ease infinite',
          blink: 'blink 1.6s ease-in-out infinite',
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

  /* ===== Section-by-section scroll ===== */
  @media (min-width: 768px) {
    .snap-scroll { scroll-snap-type: y proximity; }
    .snap-section { scroll-snap-align: start; scroll-snap-stop: normal; }
  }

  /* ===== Gentle scroll reveal (kept minimal & purposeful) ===== */
  .reveal {
    opacity: 0;
    transform: translateY(22px);
    transition: opacity .7s ease, transform .7s cubic-bezier(.2,.7,.2,1);
  }
  .reveal.in { opacity:1; transform: translate(0,0); }
  .stagger > * {
    opacity: 0;
    transform: translateY(18px);
    transition: opacity .6s ease, transform .6s cubic-bezier(.2,.7,.2,1);
  }
  .stagger.in > * { opacity:1; transform: translateY(0); }
  .stagger.in > *:nth-child(1){transition-delay:0ms}
  .stagger.in > *:nth-child(2){transition-delay:70ms}
  .stagger.in > *:nth-child(3){transition-delay:140ms}
  .stagger.in > *:nth-child(4){transition-delay:210ms}
  .stagger.in > *:nth-child(5){transition-delay:280ms}
  .stagger.in > *:nth-child(6){transition-delay:350ms}

  @media (prefers-reduced-motion: reduce) {
    .reveal, .stagger > * { opacity:1 !important; transform:none !important; transition:none !important; }
    .animate-floaty, .animate-shimmer, .animate-gradientShift, .animate-blink { animation: none !important; }
  }

  /* ===== Scroll progress bar ===== */
  #progress {
    position: fixed; top: 0; left: 0; height: 3px; width: 0%;
    background: linear-gradient(90deg, #C5B3D3, #F5CBCB);
    z-index: 60; transition: width .1s linear;
  }
  .dark #progress { background: linear-gradient(90deg, #FF6B8B, #B983FF); }

  .img-ph { background: linear-gradient(110deg, rgba(0,0,0,.05) 8%, rgba(0,0,0,.10) 18%, rgba(0,0,0,.05) 33%); background-size: 200% 100%; animation: shimmer 2.5s linear infinite; }
  .dark .img-ph { background: linear-gradient(110deg, rgba(255,255,255,.04) 8%, rgba(255,255,255,.09) 18%, rgba(255,255,255,.04) 33%); background-size:200% 100%; }

  .glass { backdrop-filter: saturate(160%) blur(14px); -webkit-backdrop-filter: saturate(160%) blur(14px); }

  .card-hover { transition: transform .35s ease, box-shadow .35s ease, border-color .35s ease; }
  .card-hover:hover { transform: translateY(-4px); }

  .link-underline { background-image: linear-gradient(currentColor, currentColor); background-position: 0 100%; background-repeat:no-repeat; background-size: 0 1.5px; transition: background-size .3s ease; }
  .link-underline:hover { background-size: 100% 1.5px; }

  .pill-active { background:#5B3A5F; color:#FFF3F3; }
  .dark .pill-active { background:#FF6B8B; color:#1B1023; }

  [x-cloak] { display:none !important; }
  ::selection { background:#C5B3D3; color:#2A1633; }

  .text-gradient {
    background: linear-gradient(120deg, #8a5f95, #C5B3D3, #8a5f95);
    background-size: 200% auto;
    -webkit-background-clip: text; background-clip: text;
    -webkit-text-fill-color: transparent;
    animation: gradientShift 6s ease infinite;
  }
  .dark .text-gradient {
    background: linear-gradient(120deg, #FF6B8B, #B983FF, #FF6B8B);
    background-size: 200% auto;
    -webkit-background-clip: text; background-clip: text;
    -webkit-text-fill-color: transparent;
  }

  .nav-scrolled { box-shadow: 0 8px 24px -14px rgba(91,58,95,.25); }
  .dark .nav-scrolled { box-shadow: 0 8px 24px -14px rgba(0,0,0,.5); }

  .counter { font-variant-numeric: tabular-nums; }

  /* focus visibility */
  a:focus-visible, button:focus-visible, input:focus-visible {
    outline: 2px solid #8a5f95; outline-offset: 2px;
  }
  .dark a:focus-visible, .dark button:focus-visible, .dark input:focus-visible {
    outline-color: #FF6B8B;
  }
</style>
</head>

<body class="bg-cream dark:bg-night text-plum dark:text-rose antialiased snap-scroll">

<div id="progress"></div>

<!-- ============ NAV ============ -->
<header id="nav" class="sticky top-0 z-40 glass bg-cream/80 dark:bg-night/80 border-b border-rose/60 dark:border-night-line/60 transition-shadow duration-300">
  <nav class="max-w-6xl mx-auto px-5 sm:px-8 h-16 flex items-center justify-between gap-4">
    <a href="#hero" class="flex items-center gap-2 group shrink-0">
      <span class="w-8 h-8 rounded-lg bg-plum dark:bg-coral grid place-items-center text-cream dark:text-night font-display font-bold transition-transform duration-500 group-hover:rotate-12">D</span>
      <span class="font-display text-lg font-semibold tracking-tight hidden xs:inline">The Daily Byte</span>
    </a>

    <!-- live search bar -->
    <div class="flex-1 max-w-sm relative hidden sm:block">
      <svg class="absolute left-3 top-1/2 -translate-y-1/2 text-plum/50 dark:text-rose/50" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
      <input type="text" x-model="query" @focus="active='All posts'" placeholder="Search stories…"
        class="w-full pl-9 pr-3 py-2 rounded-full bg-blush/70 dark:bg-night-card text-sm placeholder:text-plum/40 dark:placeholder:text-rose/40 outline-none border border-transparent focus:border-lilac dark:focus:border-violet transition" />
    </div>

    <ul class="hidden lg:flex items-center gap-6 text-sm font-medium shrink-0">
      <li><a href="#topics" class="link-underline">Topics</a></li>
      <li><a href="#voices" class="link-underline">Voices</a></li>
      <li><a href="#subscribe" class="link-underline">Subscribe</a></li>
    </ul>

    <div class="flex items-center gap-1 shrink-0">
      <button @click="searchOpen = true" aria-label="Search" class="sm:hidden w-9 h-9 grid place-items-center rounded-full hover:bg-blush dark:hover:bg-night-card transition">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
      </button>
      <button @click="toggleTheme()" aria-label="Toggle theme" class="w-9 h-9 grid place-items-center rounded-full hover:bg-blush dark:hover:bg-night-card transition">
        <svg x-show="!dark" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"/></svg>
        <svg x-show="dark" x-cloak width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
      </button>
      <button @click="menuOpen = !menuOpen" aria-label="Menu" class="lg:hidden w-9 h-9 grid place-items-center rounded-full hover:bg-blush dark:hover:bg-night-card transition">
        <svg x-show="!menuOpen" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M3 12h18M3 6h18M3 18h18"/></svg>
        <svg x-show="menuOpen" x-cloak width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M18 6L6 18M6 6l12 12"/></svg>
      </button>
    </div>
  </nav>

  <div x-show="menuOpen" x-cloak x-transition.opacity class="lg:hidden glass bg-cream/95 dark:bg-night/95 border-b border-rose/60 dark:border-night-line/60">
    <div class="px-5 py-3 sm:hidden">
      <div class="relative">
        <svg class="absolute left-3 top-1/2 -translate-y-1/2 text-plum/50 dark:text-rose/50" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
        <input type="text" x-model="query" placeholder="Search stories…" class="w-full pl-9 pr-3 py-2 rounded-full bg-blush/70 dark:bg-night-card text-sm outline-none" />
      </div>
    </div>
    <ul class="px-5 py-3 space-y-3 text-sm font-medium">
      <li><a href="#topics" @click="menuOpen=false" class="block py-1.5 link-underline">Topics</a></li>
      <li><a href="#voices" @click="menuOpen=false" class="block py-1.5 link-underline">Voices</a></li>
      <li><a href="#subscribe" @click="menuOpen=false" class="block py-1.5 link-underline">Subscribe</a></li>
    </ul>
  </div>
</header>

<!-- ============ SEARCH OVERLAY (mobile) ============ -->
<div x-show="searchOpen" x-cloak x-transition.opacity
     class="fixed inset-0 z-50 bg-plum/40 dark:bg-black/60 backdrop-blur-sm grid place-items-start pt-24 px-4"
     @click.self="searchOpen=false" @keydown.escape.window="searchOpen=false">
  <div class="w-full max-w-xl bg-cream dark:bg-night-card rounded-2xl shadow-2xl overflow-hidden animate-fadeUp">
    <div class="flex items-center gap-3 px-5 py-4 border-b border-rose/60 dark:border-night-line">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
      <input autofocus type="text" x-model="query" placeholder="Search stories, topics, authors…"
        class="flex-1 bg-transparent outline-none text-base placeholder:text-plum/40 dark:placeholder:text-rose/40" />
      <kbd class="text-xs px-2 py-1 rounded bg-blush dark:bg-night text-plum/70 dark:text-rose/70">esc</kbd>
    </div>
    <div class="px-5 py-4 text-sm max-h-72 overflow-y-auto">
      <p class="uppercase tracking-wider text-xs mb-2 text-plum/50 dark:text-rose/50" x-show="query">Results</p>
      <ul class="space-y-2">
        <template x-for="p in filteredPosts()" :key="p.title">
          <li @click="searchOpen=false" class="flex items-center gap-2 hover:text-plum dark:hover:text-coral cursor-pointer transition">
            <span>→</span> <span x-text="p.title"></span>
          </li>
        </template>
        <li x-show="query && filteredPosts().length===0" class="text-plum/50 dark:text-rose/50">No stories match “<span x-text="query"></span>”.</li>
      </ul>
    </div>
  </div>
</div>

<!-- ============ HERO ============ -->
<section id="hero" class="snap-section min-h-[calc(100vh-4rem)] flex items-center max-w-6xl mx-auto px-5 sm:px-8 py-10">
  <div class="grid md:grid-cols-2 gap-8 md:gap-10 items-center w-full">
    <div class="reveal stagger">
      <span class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-wider bg-rose/70 dark:bg-night-card text-plum dark:text-coral px-3 py-1 rounded-full">
        <span class="w-1.5 h-1.5 rounded-full bg-plum dark:bg-coral"></span> Engineering
      </span>
      <h1 class="font-display text-3xl xs:text-4xl sm:text-5xl md:text-6xl font-semibold leading-[1.08] mt-5">
        The quiet architecture behind fast&#8209;feeling apps.
      </h1>
      <p class="mt-5 text-base sm:text-lg text-plum/70 dark:text-rose/70 max-w-lg">
        Speed isn't just optimization — it's a design decision. A look at how the best teams shape latency, motion, and expectation.
      </p>
      <div class="mt-6 flex flex-wrap items-center gap-3 sm:gap-5 text-sm text-plum/60 dark:text-rose/60">
        <span>8 min read</span>
        <span class="w-1 h-1 rounded-full bg-lilac dark:bg-violet"></span>
        <span>Jul 12, 2026</span>
        <span class="w-1 h-1 rounded-full bg-lilac dark:bg-violet"></span>
        <span class="flex items-center gap-1">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8S1 12 1 12z"/><circle cx="12" cy="12" r="3"/></svg>
          12.4k views
        </span>
      </div>
      <a href="#topics" class="group inline-flex items-center gap-2 mt-8 px-5 py-3 rounded-full bg-plum dark:bg-coral text-cream dark:text-night font-medium transition-all hover:gap-3 hover:shadow-lg">
        Read the story
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" class="transition-transform group-hover:translate-x-1"><path d="M5 12h14M13 5l7 7-7 7"/></svg>
      </a>
    </div>

    <div class="reveal relative mt-6 md:mt-0">
      <div class="aspect-[5/4] rounded-3xl img-ph shadow-xl relative overflow-hidden bg-blush dark:bg-night-card">
        <div class="absolute inset-0 bg-gradient-to-tr from-lilac/40 via-transparent to-rose/50 dark:from-violet/25 dark:to-coral/20"></div>
        <div class="absolute top-5 right-5 px-3 py-1.5 rounded-full bg-cream/85 dark:bg-night/85 glass text-[11px] font-semibold flex items-center gap-1.5 animate-floaty">
          <span class="w-2 h-2 rounded-full bg-emerald-500 animate-blink"></span> Live
        </div>
        <div class="absolute bottom-5 left-5 right-5 flex items-center gap-3 bg-cream/85 dark:bg-night/85 glass rounded-2xl p-3">
          <div class="w-10 h-10 rounded-full bg-gradient-to-br from-lilac to-rose dark:from-violet dark:to-coral"></div>
          <div class="text-sm">
            <p class="font-medium">Maya Rehan</p>
            <p class="text-plum/60 dark:text-rose/60 text-xs">Principal Engineer, Nordic Labs</p>
          </div>
        </div>
      </div>
      <div class="absolute -bottom-5 -left-5 w-20 h-20 rounded-2xl bg-plum dark:bg-coral shadow-lg hidden sm:grid place-items-center text-cream dark:text-night animate-floaty">
        <span class="font-display text-2xl font-bold">8</span>
      </div>
    </div>
  </div>
</section>

<!-- ============ STATS ============ -->
<section class="snap-section max-w-6xl mx-auto px-5 sm:px-8 py-10 flex items-center min-h-[40vh] md:min-h-0">
  <div class="reveal stagger grid grid-cols-2 md:grid-cols-4 gap-3 sm:gap-4 w-full">
    <div class="text-center p-4 sm:p-5 rounded-2xl bg-blush/60 dark:bg-night-card border border-rose/60 dark:border-night-line">
      <p class="counter font-display text-2xl sm:text-3xl md:text-4xl font-semibold text-gradient" data-count="240">0</p>
      <p class="text-[10px] sm:text-xs uppercase tracking-wider text-plum/60 dark:text-rose/60 mt-1">Stories published</p>
    </div>
    <div class="text-center p-4 sm:p-5 rounded-2xl bg-blush/60 dark:bg-night-card border border-rose/60 dark:border-night-line">
      <p class="counter font-display text-2xl sm:text-3xl md:text-4xl font-semibold text-gradient" data-count="48">0</p>
      <p class="text-[10px] sm:text-xs uppercase tracking-wider text-plum/60 dark:text-rose/60 mt-1">Authors</p>
    </div>
    <div class="text-center p-4 sm:p-5 rounded-2xl bg-blush/60 dark:bg-night-card border border-rose/60 dark:border-night-line">
      <p class="counter font-display text-2xl sm:text-3xl md:text-4xl font-semibold text-gradient" data-count="92" data-suffix="k">0</p>
      <p class="text-[10px] sm:text-xs uppercase tracking-wider text-plum/60 dark:text-rose/60 mt-1">Monthly readers</p>
    </div>
    <div class="text-center p-4 sm:p-5 rounded-2xl bg-blush/60 dark:bg-night-card border border-rose/60 dark:border-night-line">
      <p class="counter font-display text-2xl sm:text-3xl md:text-4xl font-semibold text-gradient" data-count="7" data-suffix="yr">0</p>
      <p class="text-[10px] sm:text-xs uppercase tracking-wider text-plum/60 dark:text-rose/60 mt-1">Years writing</p>
    </div>
  </div>
</section>

<!-- ============ TOPICS + POSTS ============ -->
<section id="topics" class="snap-section min-h-screen flex flex-col justify-center max-w-6xl mx-auto px-5 sm:px-8 py-12">
  <div class="reveal flex items-center justify-between mb-5 flex-wrap gap-3">
    <h2 class="font-display text-2xl font-semibold">Recent stories</h2>
    <a href="#" class="text-sm text-plum/60 dark:text-rose/60 hover:text-plum dark:hover:text-coral link-underline">View archive →</a>
  </div>
  <div class="reveal stagger flex flex-wrap gap-2 mb-8">
    <template x-for="cat in categories" :key="cat">
      <button @click="active = cat"
        :class="active === cat ? 'pill-active' : 'bg-cream dark:bg-night-card text-plum/70 dark:text-rose/70 hover:bg-blush dark:hover:bg-night-line'"
        class="px-4 py-2 rounded-full text-sm font-medium border border-rose/60 dark:border-night-line transition-colors duration-300"
        x-text="cat"></button>
    </template>
  </div>

  <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6">
    <template x-for="(p, i) in filteredPosts()" :key="p.title">
      <article class="reveal card-hover bg-cream dark:bg-night-card rounded-2xl overflow-hidden border border-rose/60 dark:border-night-line group"
               :style="`transition-delay:${i*60}ms`">
        <div class="aspect-[16/10] img-ph relative overflow-hidden">
          <div class="absolute inset-0 bg-gradient-to-br opacity-80" :class="p.color"></div>
          <div class="absolute top-3 left-3 px-2.5 py-1 rounded-full bg-cream/85 dark:bg-night/85 glass text-[11px] font-semibold uppercase tracking-wider" :class="p.textColor" x-text="p.cat"></div>
        </div>
        <div class="p-5">
          <h3 class="font-display text-lg font-semibold leading-snug group-hover:text-plum dark:group-hover:text-coral transition-colors" x-text="p.title"></h3>
          <div class="mt-4 flex items-center gap-3 text-xs text-plum/60 dark:text-rose/60">
            <span x-text="p.read + ' min read'"></span>
            <span class="w-1 h-1 rounded-full bg-lilac dark:bg-violet"></span>
            <span x-text="p.date"></span>
          </div>
        </div>
      </article>
    </template>
    <p x-show="filteredPosts().length===0" class="text-plum/50 dark:text-rose/50 col-span-full text-center py-10">No stories match your filters yet.</p>
  </div>
</section>

<!-- ============ POPULAR ============ -->
<section class="snap-section min-h-screen flex items-center max-w-6xl mx-auto px-5 sm:px-8 py-12">
  <div class="grid md:grid-cols-2 gap-8 w-full">
    <div class="reveal bg-blush/60 dark:bg-night-card border border-rose/60 dark:border-night-line rounded-2xl p-6">
      <div class="flex items-center gap-2 mb-4">
        <span class="w-2.5 h-2.5 rounded-full bg-plum dark:bg-coral"></span>
        <h3 class="font-display text-lg font-semibold">Popular this week</h3>
      </div>
      <ol class="reveal stagger space-y-4">
        <template x-for="(p, i) in popular" :key="p">
          <li class="flex gap-3 group cursor-pointer">
            <span class="font-display text-2xl font-semibold text-lilac dark:text-violet/70 group-hover:text-plum dark:group-hover:text-coral transition-colors w-6" x-text="String(i+1).padStart(2,'0')"></span>
            <div>
              <p class="text-sm font-medium leading-snug group-hover:text-plum dark:group-hover:text-coral transition-colors" x-text="p"></p>
              <p class="text-xs text-plum/50 dark:text-rose/50 mt-1">4 min · 3.2k views</p>
            </div>
          </li>
        </template>
      </ol>
    </div>

    <div class="reveal relative overflow-hidden rounded-2xl p-6 bg-plum dark:bg-night-card text-cream dark:text-rose flex flex-col justify-center border border-transparent dark:border-night-line">
      <div class="absolute -top-10 -right-10 w-40 h-40 bg-lilac dark:bg-violet rounded-full blur-3xl opacity-40"></div>
      <div class="relative">
        <h3 class="font-display text-xl font-semibold">On writing internal memos nobody skips.</h3>
        <p class="text-sm opacity-75 mt-2">Culture · 4 min read</p>
        <a href="#" class="inline-flex items-center gap-2 mt-5 text-sm font-medium text-cream dark:text-coral link-underline">
          Read the essay →
        </a>
      </div>
    </div>
  </div>
</section>

<!-- ============ VOICES ============ -->
<section id="voices" class="snap-section min-h-screen flex flex-col justify-center max-w-6xl mx-auto px-5 sm:px-8 py-12">
  <div class="reveal text-center mb-8 sm:mb-10">
    <span class="text-xs font-semibold uppercase tracking-wider text-plum/60 dark:text-coral">Voices</span>
    <h2 class="font-display text-2xl sm:text-3xl md:text-4xl font-semibold mt-2">What readers say</h2>
  </div>
  <div class="reveal stagger grid sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6">
    <template x-for="t in testimonials" :key="t.name">
      <figure class="relative p-6 rounded-2xl bg-cream dark:bg-night-card border border-rose/60 dark:border-night-line">
        <div class="flex gap-0.5 text-plum dark:text-coral mb-3">
          <template x-for="n in 5" :key="n"><svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3 7 7 .8-5.3 4.8L18 22l-6-3.5L6 22l1.3-7.4L2 9.8 9 9z"/></svg></template>
        </div>
        <blockquote class="text-sm leading-relaxed text-plum/80 dark:text-rose/80" x-text="'“' + t.quote + '”'"></blockquote>
        <figcaption class="mt-5 flex items-center gap-3">
          <div class="w-10 h-10 rounded-full" :class="t.avatar"></div>
          <div>
            <p class="text-sm font-medium" x-text="t.name"></p>
            <p class="text-xs text-plum/50 dark:text-rose/50" x-text="t.role"></p>
          </div>
        </figcaption>
      </figure>
    </template>
  </div>
</section>

<!-- ============ SUBSCRIBE ============ -->
<section id="subscribe" class="snap-section min-h-screen flex items-center max-w-6xl mx-auto px-5 sm:px-8 py-12">
  <div class="reveal w-full relative overflow-hidden rounded-3xl p-8 sm:p-14 bg-plum dark:bg-gradient-to-br dark:from-night-card dark:to-night text-cream dark:text-rose text-center">
    <div class="absolute -top-16 -left-16 w-56 h-56 bg-lilac dark:bg-violet rounded-full blur-3xl opacity-30"></div>
    <div class="absolute -bottom-16 -right-16 w-56 h-56 bg-rose dark:bg-coral rounded-full blur-3xl opacity-25"></div>
    <div class="relative max-w-xl mx-auto">
      <span class="inline-block text-xs font-semibold uppercase tracking-wider bg-cream/15 dark:bg-white/10 px-3 py-1 rounded-full mb-4">Weekly essay</span>
      <h2 class="font-display text-2xl sm:text-3xl md:text-4xl font-semibold">A quiet weekly read.</h2>
      <p class="text-sm sm:text-base opacity-75 mt-3">One thoughtful essay every Sunday. No noise, no algorithm — just writing worth your time.</p>

      <form class="mt-7 flex flex-col sm:flex-row gap-3 max-w-md mx-auto" @submit.prevent="subscribed=true">
        <input required type="email" x-model="email" placeholder="you@domain.com"
          class="flex-1 px-4 py-3 rounded-full bg-cream/10 dark:bg-white/5 border border-cream/25 dark:border-white/15 placeholder:text-cream/50 dark:placeholder:text-rose/40 outline-none focus:ring-2 focus:ring-lilac dark:focus:ring-coral text-sm transition" />
        <button class="px-6 py-3 rounded-full bg-rose text-plum dark:bg-coral dark:text-night text-sm font-semibold hover:brightness-105 active:scale-95 transition shrink-0">Subscribe</button>
      </form>
      <p x-show="subscribed" x-transition x-cloak class="text-sm text-rose dark:text-coral mt-4 font-medium">You're in — see you Sunday →</p>
      <p class="text-[11px] opacity-60 mt-4">No spam. Unsubscribe anytime, one click.</p>

      <div class="flex items-center justify-center gap-6 mt-8 text-xs opacity-70">
        <span>18,400+ subscribers</span>
        <span class="w-1 h-1 rounded-full bg-cream/40 dark:bg-rose/40"></span>
        <span>4.9★ average rating</span>
      </div>
    </div>
  </div>
</section>

<!-- ============ FOOTER ============ -->
<footer id="about" class="snap-section border-t border-rose/60 dark:border-night-line py-10">
  <div class="max-w-6xl mx-auto px-5 sm:px-8 flex flex-col sm:flex-row justify-between gap-4 text-sm">
    <div>
      <p class="font-display text-lg font-semibold">The Daily Byte</p>
      <p class="text-plum/60 dark:text-rose/60 text-xs mt-1">© 2026 The Daily Byte. Crafted slowly.</p>
    </div>
    <div class="flex gap-5 text-plum/70 dark:text-rose/70">
      <a href="#" class="hover:text-plum dark:hover:text-coral transition">Twitter</a>
      <a href="#" class="hover:text-plum dark:hover:text-coral transition">RSS</a>
      <a href="#" class="hover:text-plum dark:hover:text-coral transition">Contact</a>
    </div>
  </div>
</footer>

<!-- back to top -->
<button id="toTop" aria-label="Back to top"
  class="fixed bottom-5 right-5 sm:bottom-6 sm:right-6 z-40 w-10 h-10 sm:w-11 sm:h-11 rounded-full bg-plum dark:bg-coral text-cream dark:text-night grid place-items-center shadow-lg opacity-0 translate-y-4 pointer-events-none transition-all hover:scale-105 active:scale-95">
  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"><path d="M12 19V5M5 12l7-7 7 7"/></svg>
</button>

<script>
function site() {
  return {
    dark: false,
    searchOpen: false,
    menuOpen: false,
    subscribed: false,
    email: '',
    query: '',
    active: 'All posts',
    categories: ['All posts','Engineering','Design','Product','Culture'],
    popular: [
      'Designing systems that scale with your team',
      'Why product roadmaps quietly fail',
      'The unreasonable joy of small tools',
      'Reading code like literature',
    ],
    testimonials: [
      { name:'Lena Ortiz', role:'Staff Engineer, Vela', quote:'The one newsletter I actually finish. Every essay earns its place in my inbox.', avatar:'bg-gradient-to-br from-lilac to-rose dark:from-violet dark:to-coral' },
      { name:'Theo Park', role:'Product Lead, Monzo', quote:'It reads like a magazine, not a feed. Calm, sharp, and surprisingly practical.', avatar:'bg-gradient-to-br from-rose to-lilac dark:from-coral dark:to-violet' },
      { name:'Aisha Khan', role:'Design Director, Folio', quote:'I keep coming back for the writing. Few places treat craft this seriously.', avatar:'bg-gradient-to-br from-lilac to-plum dark:from-violet dark:to-night-card' },
    ],
    posts: [
      { cat:'Design', title:'Whitespace is a feature, not a bug.', read:5, date:'Jul 10, 2026', color:'from-lilac/50 to-rose/50 dark:from-violet/40 dark:to-coral/30', textColor:'text-plum dark:text-coral' },
      { cat:'Product', title:'The roadmap trap: shipping without direction.', read:7, date:'Jul 8, 2026', color:'from-rose/50 to-blush dark:from-coral/40 dark:to-violet/20', textColor:'text-plum dark:text-coral' },
      { cat:'Engineering', title:'Async at scale: patterns from four teams.', read:9, date:'Jul 5, 2026', color:'from-lilac/50 to-blush dark:from-violet/40 dark:to-night-card', textColor:'text-plum dark:text-coral' },
      { cat:'Culture', title:'On writing internal memos nobody skips.', read:4, date:'Jul 2, 2026', color:'from-rose/50 to-lilac/40 dark:from-coral/30 dark:to-violet/30', textColor:'text-plum dark:text-coral' },
      { cat:'Engineering', title:'Reading code like literature.', read:6, date:'Jun 28, 2026', color:'from-blush to-lilac/40 dark:from-night-card dark:to-violet/30', textColor:'text-plum dark:text-coral' },
      { cat:'Design', title:'The texture of good defaults.', read:5, date:'Jun 24, 2026', color:'from-rose/50 to-rose dark:from-coral/30 dark:to-coral/10', textColor:'text-plum dark:text-coral' },
    ],
    filteredPosts() {
      let list = this.active === 'All posts' ? this.posts : this.posts.filter(p => p.cat === this.active);
      if (this.query.trim()) {
        const q = this.query.trim().toLowerCase();
        list = list.filter(p => p.title.toLowerCase().includes(q) || p.cat.toLowerCase().includes(q));
      }
      return list;
    },
    toggleTheme() {
      this.dark = !this.dark;
      document.cookie = `theme=${this.dark?'dark':'light'};path=/;max-age=31536000`;
    },
    init() {
      const m = document.cookie.match(/theme=(dark|light)/);
      this.dark = m ? m[1]==='dark' : window.matchMedia('(prefers-color-scheme: dark)').matches;

      const io = new IntersectionObserver((entries)=>{
        entries.forEach(e => {
          if (e.isIntersecting) {
            e.target.classList.add('in');
            if (e.target.querySelectorAll) e.target.querySelectorAll('.counter').forEach(animateCounter);
            io.unobserve(e.target);
          }
        });
      }, { threshold: 0.12, rootMargin: '0px 0px -8% 0px' });

      const observe = () => document.querySelectorAll('.reveal, .stagger').forEach(el => io.observe(el));
      requestAnimationFrame(observe);
      setTimeout(observe, 50);
      setTimeout(observe, 250);

      const progress = document.getElementById('progress');
      const nav = document.getElementById('nav');
      const toTop = document.getElementById('toTop');
      const onScroll = () => {
        const h = document.documentElement;
        const scrolled = h.scrollTop / (h.scrollHeight - h.clientHeight);
        progress.style.width = (scrolled * 100) + '%';
        nav.classList.toggle('nav-scrolled', h.scrollTop > 10);
        if (h.scrollTop > 400) { toTop.classList.remove('opacity-0','translate-y-4','pointer-events-none'); toTop.classList.add('opacity-100','translate-y-0'); }
        else { toTop.classList.add('opacity-0','translate-y-4','pointer-events-none'); toTop.classList.remove('opacity-100','translate-y-0'); }
      };
      window.addEventListener('scroll', onScroll, { passive: true });
      onScroll();
      toTop.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

      window.addEventListener('keydown', (e)=>{
        if ((e.metaKey||e.ctrlKey) && e.key.toLowerCase()==='k') { e.preventDefault(); this.searchOpen = true; }
      });
    }
  }
}

function animateCounter(el) {
  if (el.dataset.done) return;
  el.dataset.done = '1';
  const target = parseFloat(el.dataset.count || '0');
  const suffix = el.dataset.suffix || '';
  const dur = 1200;
  const start = performance.now();
  const step = (now) => {
    const t = Math.min(1, (now - start) / dur);
    const eased = 1 - Math.pow(1 - t, 3);
    const val = Math.round(target * eased);
    el.textContent = val + suffix;
    if (t < 1) requestAnimationFrame(step);
  };
  requestAnimationFrame(step);
}
</script>
</body>
</html>