<!-- Navbar Component -->
<style>
    /* ================= NAVBAR STYLES ================= */
    :root{
        --ink:#050611;
        --panel:#0b0c1a;
        --violet:#7c3aed;
        --blue:#2f6fed;
        --cyan:#22d3ee;
        --paper:#f5f3ff;
        --mist:#94a3b8;
        --line: rgba(255,255,255,.10);
    }

    #navbar{
        border-bottom: 1px solid var(--line);
        background: linear-gradient(180deg, rgba(11,12,26,.86), rgba(11,12,26,.62));
    }
    #navbar::after{
        content:''; position:absolute; left:0; right:0; bottom:-1px; height:1px;
        background: linear-gradient(90deg, transparent, rgba(124,58,237,.55), rgba(34,211,238,.5), transparent);
        opacity:.7;
    }
    .nav-logo{
        display:flex; align-items:center; gap:.6rem;
        text-decoration:none;
    }
    .nav-logo-mark{
        display:flex; align-items:center; justify-content:center;
        width:2.25rem; height:2.25rem; border-radius:.7rem;
        background: linear-gradient(135deg, rgba(124,58,237,.35), rgba(34,211,238,.25));
        border:1px solid rgba(255,255,255,.14);
        transition: transform .3s ease, box-shadow .3s ease;
    }
    .nav-logo:hover .nav-logo-mark{
        transform: rotate(-6deg) scale(1.05);
        box-shadow: 0 8px 22px rgba(124,58,237,.35);
    }
    .nav-logo-text{
        font-family:'Space Grotesk',sans-serif; font-weight:700; font-size:1.05rem;
        letter-spacing:-.01em; color:var(--paper);
    }
    .nav-links{
        display:flex; align-items:center; gap:.2rem;
        padding:.3rem; border-radius:999px;
        background: rgba(255,255,255,.04);
        border:1px solid var(--line);
    }
    .nav-link{
        color: var(--mist);
        text-decoration: none;
        font-size: .85rem;
        font-weight: 500;
        transition: color .2s ease, background .2s ease, box-shadow .2s ease;
        padding: .5rem 1rem;
        border-radius: 999px;
        white-space:nowrap;
        cursor:pointer;
    }
    .nav-link:hover{
        color: var(--paper);
        background: rgba(255,255,255,.07);
    }
    .nav-link.active{
        color: #0a0a12;
        background: linear-gradient(100deg,#c4b5fd,#67e8f9);
        box-shadow: 0 6px 18px rgba(124,58,237,.3);
    }
    #userMenuBtn{
        box-shadow: 0 4px 16px rgba(124,58,237,.3);
        transition: transform .2s ease, box-shadow .2s ease;
    }
    #userMenuBtn:hover{ transform: scale(1.06); box-shadow: 0 6px 20px rgba(124,58,237,.45); }
    #userMenu{
        overflow:hidden;
        box-shadow: 0 24px 48px rgba(3,4,20,.55);
        transform-origin: top right;
    }
    #userMenu a, #userMenu button[type="submit"]{
        display:flex; align-items:center; gap:.55rem;
    }
    #userMenu a:hover, #userMenu button[type="submit"]:hover{
        background: rgba(255,255,255,.06);
        color: var(--cyan) !important;
    }
    #userMenu i{ width:1rem; text-align:center; color:var(--mist); font-size:.8rem; }

    .nav-toggle-btn{
        display:none;
        align-items:center; justify-content:center;
        width:2.5rem; height:2.5rem; border-radius:.7rem;
        border:1px solid var(--line); background:rgba(255,255,255,.04);
        color:var(--paper); cursor:pointer;
        transition: background .2s ease, border-color .2s ease;
        flex-shrink:0;
    }
    .nav-toggle-btn:hover{ background:rgba(255,255,255,.09); border-color:rgba(255,255,255,.3); }
    .nav-toggle-btn .icon-bars,
    .nav-toggle-btn .icon-close{ font-size:1.05rem; }
    .nav-toggle-btn .icon-close{ display:none; }
    .nav-toggle-btn[aria-expanded="true"] .icon-bars{ display:none; }
    .nav-toggle-btn[aria-expanded="true"] .icon-close{ display:inline-block; }

    #mobileNavPanel{
        display:none;
        flex-direction:column;
        gap:.25rem;
        padding: .75rem 0 1.1rem;
        border-top: 1px solid var(--line);
    }
    #mobileNavPanel.open{ display:flex; }
    #mobileNavPanel .nav-link{
        width:100%;
        padding:.85rem 1rem;
        border-radius:.75rem;
        text-align:left;
    }
    #mobileNavPanel .nav-link.active{
        box-shadow:none;
    }

    @media(max-width:767px){
        .nav-links{ display:none; }
        .nav-toggle-btn{ display:inline-flex; }
    }

    .glass{
        background: linear-gradient(155deg, rgba(255,255,255,.06), rgba(255,255,255,.02));
        border: 1px solid var(--line);
        backdrop-filter: blur(16px) saturate(140%);
        -webkit-backdrop-filter: blur(16px) saturate(140%);
    }
    .grad-btn{
        font-weight:600; color:#0a0a12;
        background:linear-gradient(100deg,#e9d5ff,#a5f3fc);
        box-shadow: 0 8px 30px rgba(124,58,237,.35);
        transition: transform .25s ease, box-shadow .25s ease;
        text-decoration:none;
        display:inline-block;
    }
    .grad-btn:hover{ transform:translateY(-2px); box-shadow:0 12px 36px rgba(124,58,237,.5); }

    .fixed{position:fixed}
    .top-0{top:0} .left-0{left:0} .right-0{right:0} .z-50{z-index:50}
    .hidden{display:none}
    .flex{display:flex} .items-center{align-items:center} .justify-between{justify-content:space-between}
    .h-16{height:4rem}
    .max-w-6xl{max-width:72rem}
    .mx-auto{margin-left:auto;margin-right:auto}
    .px-4{padding-left:1rem;padding-right:1rem}
    .rounded-lg{border-radius:0.75rem}
    .transition-colors{transition-property:color,background-color,border-color;transition-duration:0.15s}
    .gap-1{gap:0.25rem}
    .text-xs{font-size:0.75rem}
    .text-sm{font-size:0.875rem}
</style>

<nav id="navbar" class="glass fixed top-0 left-0 right-0 z-50 transition-transform duration-300" style="border-left:none;border-right:none;border-top:none;">
    <div class="max-w-6xl mx-auto px-4">
        <div class="flex items-center justify-between h-16">

            <!-- Left: Icon/Logo -->
            <div class="flex items-center flex-shrink-0" data-nav-el="logo">
                <a href="{{ route('home') }}" aria-label="Go to homepage" class="nav-logo">
                    <span class="nav-logo-mark">
                        <svg
                            class="w-5 h-5"
                            style="color:#67e8f9"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            aria-hidden="true"
                            focusable="false">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </span>
                    <span class="nav-logo-text hidden sm:inline">MyBlog</span>
                </a>
            </div>

            <!-- Center: Nav links -->
            <div class="hidden md:flex nav-links" data-nav-el="links">
                <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') || request()->routeIs('posts.*') ? 'active' : '' }}">Posts</a>
                <a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}">About</a>
                <a href="{{ route('contact') }}" class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a>
            </div>

            <!-- Right: Auth area + mobile toggle -->
            <div class="flex items-center gap-3 flex-shrink-0" data-nav-el="auth">
                @guest
                    <a href="{{ route('login') }}"
                       aria-label="Subscribe to the blog"
                       class="grad-btn text-sm px-4 py-2 rounded-full inline-block">
                        Subscribe
                    </a>
                @else
                    <button
                        id="userMenuBtn"
                        onclick="toggleUserMenu()"
                        aria-label="Open user account menu"
                        aria-haspopup="menu"
                        aria-expanded="false"
                        aria-controls="userMenu"
                        class="flex items-center justify-center w-9 h-9 rounded-full font-semibold text-sm transition-colors"
                        style="background:linear-gradient(135deg,#7c3aed,#22d3ee);color:#0a0a12">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </button>

                    <div id="userMenu" role="menu" aria-label="Account menu" class="glass hidden absolute right-0 mt-2 w-48 rounded-lg py-1 z-50" style="top:100%;">
                        <div class="px-4 py-2 text-sm border-b" style="color:var(--mist);border-color:var(--line)">
                            {{ auth()->user()->name }}
                        </div>
                        @if(in_array(auth()->user()->role, ['author']))
                            <a href="/profile"
                               class="px-4 py-2 text-sm transition-colors"
                               style="color:var(--paper)">
                                <i class="fas fa-user"></i> Profile
                            </a>
                        @endif
                        @if(auth()->user()->role === 'admin')
                            <a href="/admin"
                               class="px-4 py-2 text-sm transition-colors"
                               style="color:var(--paper)">
                                <i class="fas fa-gauge"></i> Admin Dashboard
                            </a>
                        @endif
                        <form method="POST" action="/logout">
                            @csrf
                            <button type="submit"
                                    class="w-full text-left px-4 py-2 text-sm transition-colors"
                                    style="color:var(--paper)">
                                <i class="fas fa-arrow-right-from-bracket"></i> Logout
                            </button>
                        </form>
                    </div>
                @endguest

                <button
                    type="button"
                    id="navToggleBtn"
                    class="nav-toggle-btn"
                    aria-label="Toggle navigation menu"
                    aria-haspopup="true"
                    aria-expanded="false"
                    aria-controls="mobileNavPanel"
                    onclick="toggleMobileNav()"
                >
                    <i class="fas fa-bars icon-bars" aria-hidden="true"></i>
                    <i class="fas fa-xmark icon-close" aria-hidden="true"></i>
                </button>
            </div>

        </div>

        <!-- Mobile nav panel -->
        <div id="mobileNavPanel" role="menu" aria-label="Mobile navigation">
            <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') || request()->routeIs('posts.*') ? 'active' : '' }}" role="menuitem" onclick="closeMobileNav()">Posts</a>
            <a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" role="menuitem" onclick="closeMobileNav()">About</a>
            <a href="{{ route('contact') }}" class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" role="menuitem" onclick="closeMobileNav()">Contact</a>
        </div>
    </div>
</nav>

<!-- Spacer to offset fixed navbar height -->
<div class="h-16"></div>

<!-- Navbar JavaScript -->
<script>
    // ---------- User Menu Toggle ----------
    function toggleUserMenu() {
        const menu = document.getElementById('userMenu');
        const btn = document.getElementById('userMenuBtn');
        if (!menu || !btn) return;
        const willOpen = menu.classList.contains('hidden');
        menu.classList.toggle('hidden');
        btn.setAttribute('aria-expanded', String(willOpen));
        if (willOpen) {
            const firstItem = menu.querySelector('a, button');
            if (firstItem) firstItem.focus();
        }
    }

    // Close user menu on outside click
    document.addEventListener('click', function (e) {
        const menu = document.getElementById('userMenu');
        const btn = document.getElementById('userMenuBtn');
        if (!menu || !btn) return;
        if (!menu.contains(e.target) && !btn.contains(e.target)) {
            menu.classList.add('hidden');
            btn.setAttribute('aria-expanded', 'false');
        }
    });

    // Close user menu on Escape
    document.addEventListener('keydown', function (e) {
        if (e.key !== 'Escape') return;
        const menu = document.getElementById('userMenu');
        const btn = document.getElementById('userMenuBtn');
        if (!menu || menu.classList.contains('hidden')) return;
        menu.classList.add('hidden');
        btn.setAttribute('aria-expanded', 'false');
        btn.focus();
    });

    // ---------- Mobile Nav Toggle ----------
    function toggleMobileNav() {
        const panel = document.getElementById('mobileNavPanel');
        const btn = document.getElementById('navToggleBtn');
        if (!panel || !btn) return;
        const willOpen = !panel.classList.contains('open');
        panel.classList.toggle('open', willOpen);
        btn.setAttribute('aria-expanded', String(willOpen));
    }

    function closeMobileNav() {
        const panel = document.getElementById('mobileNavPanel');
        const btn = document.getElementById('navToggleBtn');
        if (!panel || !btn) return;
        panel.classList.remove('open');
        btn.setAttribute('aria-expanded', 'false');
    }

    // Close mobile menu on outside click
    document.addEventListener('click', function (e) {
        const panel = document.getElementById('mobileNavPanel');
        const btn = document.getElementById('navToggleBtn');
        if (!panel || !btn) return;
        if (!panel.classList.contains('open')) return;
        if (!panel.contains(e.target) && !btn.contains(e.target)) {
            closeMobileNav();
        }
    });

    // Close mobile menu on Escape
    document.addEventListener('keydown', function (e) {
        if (e.key !== 'Escape') return;
        const panel = document.getElementById('mobileNavPanel');
        const btn = document.getElementById('navToggleBtn');
        if (!panel || !panel.classList.contains('open')) return;
        closeMobileNav();
        btn.focus();
    });

    // Close mobile menu on resize to desktop
    window.addEventListener('resize', function () {
        if (window.innerWidth >= 768) closeMobileNav();
    });

    // ---------- Navbar hide/show on scroll ----------
    (function () {
        const navbar = document.getElementById('navbar');
        if (!navbar) return;
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
                    closeMobileNav();
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
</script>