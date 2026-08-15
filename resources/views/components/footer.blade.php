<!-- Footer Component -->
<style>
    /* ================= FOOTER STYLES ================= */
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

    .site-footer{
        position:relative; z-index:1; margin-top:4rem;
        background: linear-gradient(180deg, rgba(11,12,26,0), rgba(11,12,26,.92) 25%, var(--panel));
        border-top:1px solid var(--line);
    }
    .footer-inner{ padding: 3.5rem 1rem 2rem; }
    .footer-grid{ display:grid; grid-template-columns:1fr; gap:2.5rem; }
    @media(min-width:768px){
        .footer-grid{ grid-template-columns: 1.4fr 1fr 1fr 1.3fr; gap:2rem; }
    }
    .footer-brand .footer-logo{ margin-bottom:1rem; }
    .footer-tagline{
        color:var(--mist); font-size:.9rem; line-height:1.65; max-width:22rem; margin-bottom:1.25rem;
    }
    .footer-social{ display:flex; gap:.65rem; }
    .footer-social a{
        width:2.25rem; height:2.25rem; border-radius:.6rem;
        display:flex; align-items:center; justify-content:center;
        border:1px solid var(--line); background:rgba(255,255,255,.03);
        color:var(--mist); text-decoration:none;
        transition: all .2s ease;
    }
    .footer-social a:hover{
        color:var(--cyan); border-color:rgba(255,255,255,.3);
        background:rgba(255,255,255,.07); transform:translateY(-2px);
    }
    .footer-col h5{
        font-family:'Space Grotesk',sans-serif; font-size:.95rem; font-weight:600;
        color:var(--paper); margin-bottom:1rem;
    }
    .footer-col ul{ list-style:none; display:flex; flex-direction:column; gap:.65rem; }
    .footer-col ul a{
        display:inline-flex; align-items:center; gap:.55rem;
        color:var(--mist); font-size:.88rem; text-decoration:none; transition:color .2s ease;
        background:none; border:none; padding:0; cursor:pointer; font-family:'Inter',sans-serif;
    }
    .footer-col ul a:hover{ color:var(--cyan); }
    .footer-col ul a i{ width:.9rem; text-align:center; font-size:.78rem; color:var(--mist); transition:color .2s ease; }
    .footer-col ul a:hover i{ color:var(--cyan); }
    .footer-newsletter p{ color:var(--mist); font-size:.85rem; line-height:1.55; margin-bottom:1rem; }
    .footer-form{ display:flex; gap:.5rem; }
    .footer-form button{
        padding:.65rem 1.1rem; border-radius:.7rem; font-size:.85rem; font-weight:600;
        color:#0a0a12; background:linear-gradient(100deg,#e9d5ff,#a5f3fc);
        border:none; cursor:pointer;
        transition: transform .2s ease, box-shadow .2s ease;
    }
    .footer-form button:hover{ transform:translateY(-2px); box-shadow:0 8px 22px rgba(124,58,237,.35); }

    .footer-account-card{
        display:flex; align-items:center; gap:.75rem;
        padding:.85rem .9rem; margin-bottom:1.1rem;
        border-radius:.9rem;
        background: linear-gradient(155deg, rgba(255,255,255,.06), rgba(255,255,255,.02));
        border:1px solid var(--line);
    }
    .footer-account-avatar{
        flex-shrink:0; width:2.5rem; height:2.5rem; border-radius:999px;
        display:flex; align-items:center; justify-content:center;
        font-family:'Space Grotesk',sans-serif; font-weight:700; font-size:.95rem;
        color:#0a0a12;
    }
    .footer-account-info{ min-width:0; }
    .footer-account-name{
        display:block; font-size:.88rem; font-weight:600; color:var(--paper);
        overflow:hidden; text-overflow:ellipsis; white-space:nowrap;
    }
    .footer-account-role{
        display:block; font-size:.72rem; color:var(--cyan);
        font-family:'JetBrains Mono',monospace; letter-spacing:.05em; text-transform:uppercase;
    }
    .footer-logout-form{ margin:0; }
    .footer-logout-form button{
        width:100%; text-align:left;
        display:inline-flex; align-items:center; gap:.55rem;
        background:none; border:none; padding:0; cursor:pointer;
        color:var(--mist); font-size:.88rem; font-family:'Inter',sans-serif;
        transition:color .2s ease;
    }
    .footer-logout-form button:hover{ color:var(--cyan); }
    .footer-logout-form button i{ width:.9rem; text-align:center; font-size:.78rem; }

    .footer-bottom{
        display:flex; flex-wrap:wrap; gap:1rem; align-items:center; justify-content:space-between;
        border-top:1px solid var(--line); margin-top:2.5rem; padding-top:1.5rem;
        font-size:.8rem; color:var(--mist);
    }
    .footer-bottom-links{ display:flex; gap:1.25rem; }
    .footer-bottom-links a{
        color:var(--mist); text-decoration:none; transition:color .2s ease;
        background:none; border:none; cursor:pointer; font-size:.8rem; font-family:'Inter',sans-serif; padding:0;
    }
    .footer-bottom-links a:hover{ color:var(--cyan); }

    .grad-btn{
        font-weight:600; color:#0a0a12;
        background:linear-gradient(100deg,#e9d5ff,#a5f3fc);
        box-shadow: 0 8px 30px rgba(124,58,237,.35);
        transition: transform .25s ease, box-shadow .25s ease;
        text-decoration:none;
        display:inline-block;
    }
    .grad-btn:hover{ transform:translateY(-2px); box-shadow:0 12px 36px rgba(124,58,237,.5); }

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

    .hidden{display:none}
    .flex{display:flex} .items-center{align-items:center}
    .max-w-6xl{max-width:72rem}
    .mx-auto{margin-left:auto;margin-right:auto}
    .px-4{padding-left:1rem;padding-right:1rem}
    .text-sm{font-size:0.875rem}

    @media (max-width: 767px){
        .footer-inner{ padding: 2.75rem 1rem 1.5rem; }
        .footer-grid{ gap:2rem; }
        .footer-bottom{ flex-direction:column; align-items:flex-start; gap:.85rem; }
        .footer-form{ flex-direction:column; }
        .footer-form button{ width:100%; }
    }
    @media (max-width: 420px){
        .footer-form{ flex-direction:column; }
        .footer-form button{ width:100%; }
    }
</style>

<footer class="site-footer">
    <div class="max-w-6xl mx-auto px-4 footer-inner">
        <div class="footer-grid">
            <div class="footer-brand">
                <a href="{{ route('home') }}" class="nav-logo footer-logo">
                    <span class="nav-logo-mark">
                        <svg class="w-5 h-5" style="color:#67e8f9" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </span>
                    <span class="nav-logo-text">MyBlog</span>
                </a>
                <p class="footer-tagline">
                    Deep dives on Laravel, JavaScript, and the craft of building for the
                    web — collected, curated, and shelved for whenever you need them.
                </p>
                <div class="footer-social">
                    <a href="mailto:rafiqueb087@gmail.com" aria-label="Email"><i class="fas fa-envelope"></i></a>
                    <a href="https://github.com/bilal-157/" target="_blank" rel="noopener noreferrer" aria-label="GitHub"><i class="fa-brands fa-github"></i></a>
                    <a href="https://www.linkedin.com/in/muhammadbilal711" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn"><i class="fa-brands fa-linkedin"></i></a>
                </div>
            </div>

            <div class="footer-col">
                <h5>Explore</h5>
                <ul>
                    <li><a href="#postsGrid">All Posts</a></li>
                    <li><a href="#categoryFilters">Categories</a></li>
                    <li><a href="{{ route('about') }}">About</a></li>
                    <li><a href="{{ route('contact') }}">Contact</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h5>Resources</h5>
                <ul>
                    <li><a href="javascript:void(0)" onclick="event.preventDefault(); if(typeof openLegalModal === 'function') openLegalModal('privacy')"><i class="fas fa-shield-halved"></i> Privacy Policy</a></li>
                    <li><a href="javascript:void(0)" onclick="event.preventDefault(); if(typeof openLegalModal === 'function') openLegalModal('terms')"><i class="fas fa-file-contract"></i> Terms of Service</a></li>
                    <li><a href="#"><i class="fas fa-rss"></i> RSS Feed</a></li>
                    <li><a href="#"><i class="fas fa-sitemap"></i> Sitemap</a></li>
                </ul>
            </div>

            @guest
            <div class="footer-col footer-newsletter">
                <h5>Stay in the loop</h5>
                <p>New articles, straight to your inbox. No spam, unsubscribe anytime.</p>
                <div class="footer-form">
                    <a href="{{ route('login') }}"
                       aria-label="Subscribe to the blog"
                       class="grad-btn text-sm px-4 py-2 rounded-xl inline-block">
                        Subscribe
                    </a>
                </div>
            </div>
            @else
            <div class="footer-col footer-account">
                <h5>Your Account</h5>
                <div class="footer-account-card">
                    <span class="footer-account-avatar" style="background:linear-gradient(135deg,#7c3aed,#22d3ee)">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </span>
                    <div class="footer-account-info">
                        <span class="footer-account-name">{{ auth()->user()->name }}</span>
                        <span class="footer-account-role">{{ ucfirst(auth()->user()->role) }}</span>
                    </div>
                </div>
                <ul>
                    @if(in_array(auth()->user()->role, ['author']))
                        <li><a href="/profile"><i class="fas fa-user"></i> Your Profile</a></li>
                    @endif
                    @if(auth()->user()->role === 'admin')
                        <li><a href="/admin"><i class="fas fa-gauge"></i> Admin Dashboard</a></li>
                    @endif
                    <li>
                        <form method="POST" action="/logout" class="footer-logout-form">
                            @csrf
                            <button type="submit"><i class="fas fa-arrow-right-from-bracket"></i> Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
            @endguest
        </div>

        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} MyBlog. All rights reserved.</p>
            <div class="footer-bottom-links">
                <a href="javascript:void(0)" onclick="event.preventDefault(); if(typeof openLegalModal === 'function') openLegalModal('privacy')">Privacy Policy</a>
                <a href="javascript:void(0)" onclick="event.preventDefault(); if(typeof openLegalModal === 'function') openLegalModal('terms')">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>