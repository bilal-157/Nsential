@php
    // Use the real first post as the featured card — falls back gracefully
    // if $posts is empty, so the section never breaks on an empty blog.
    $fp = $featuredPost
        ?? (isset($posts) && count($posts) ? $posts[0] : null)
        ?? (isset($popularPosts) && count($popularPosts) ? $popularPosts[0] : null);

    $fpReadTime = null;
    if ($fp) {
        $wordCount = str_word_count(strip_tags($fp['content'] ?? $fp['excerpt'] ?? ''));
        $fpReadTime = max(1, (int) ceil($wordCount / 200)) . ' min read';
    }

    $fpImageUrl = null;
    if ($fp && !empty($fp['image'])) {
        $fpImageUrl = Str::startsWith($fp['image'], ['http://', 'https://'])
            ? $fp['image']
            : asset('storage/' . $fp['image']);
    }
@endphp

<section class="hero-shelf" id="heroShelf">
    <div class="hero-grain" aria-hidden="true"></div>

    <div class="hero-inner">
        <!-- Left: content -->
        <div>

            <h1 class="hero-heading" data-hero-el="heading">
                Code, clarity, and<br>
                everything worth <span class="grad-text">writing down.</span>
            </h1>

            <p class="hero-sub" data-hero-el="sub">
                Deep dives on Laravel, JavaScript, and the craft of building for the
                web — collected, curated, and shelved for whenever you need them.
            </p>

            <div class="hero-ctas" data-hero-el="ctas">
                <a href="#postsGrid" class="btn-primary">
                    Start Reading
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M13 5l7 7-7 7"/></svg>
                </a>
                <a href="#categoryFilters" class="btn-secondary">Browse Categories</a>
            </div>

            <div class="hero-stats" data-hero-el="stats">
                @php
                    $heroStats = $heroStats ?? [
                        ['value' => number_format($postCount ?? 0), 'label' => 'Articles'],
                        ['value' => number_format(count($categories ?? [])), 'label' => 'Topics'],
                        ['value' => number_format($totalViews ?? 0), 'label' => 'Reads'],
                    ];
                @endphp
                @foreach($heroStats as $stat)
                    <div><b>{{ $stat['value'] }}</b><span>{{ $stat['label'] }}</span></div>
                @endforeach
            </div>
        </div>

        <!-- Right: animated dev scene -->
        <div class="hero-scene" id="heroScene">
            <div class="dev-scene" data-hero-el="card" aria-hidden="true">

                <div class="dev-float dev-float--chat" style="--x:6%; --y:14%; --dur:6.5s; --delay:-1s;">
                    <i class="fas fa-quote-right"></i>
                </div>
                <div class="dev-float dev-float--gear" style="--x:2%; --y:56%; --dur:7.5s; --delay:-3.2s;">
                    <i class="fas fa-gear"></i>
                </div>
                <div class="dev-float dev-float--check" style="--x:82%; --y:12%; --dur:6s; --delay:-2s;">
                    <i class="fas fa-check"></i>
                </div>
                <div class="dev-float dev-float--code" style="--x:84%; --y:58%; --dur:8s; --delay:-4.5s;">
                    <i class="fas fa-code"></i>
                </div>
                <div class="dev-float dev-float--binary" style="--x:88%; --y:34%; --dur:9s; --delay:-1.6s;">
                    <span>1010</span><span>0110</span><span>1101</span>
                </div>

                <svg class="dev-laptop-svg" viewBox="0 0 480 380" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <linearGradient id="devPanelGrad" x1="0" y1="0" x2="1" y2="1">
                            <stop offset="0%" stop-color="#f59e0b"/>
                            <stop offset="100%" stop-color="#7c3aed"/>
                        </linearGradient>
                        <linearGradient id="devScreenGrad" x1="0" y1="0" x2="1" y2="1">
                            <stop offset="0%" stop-color="#6d28d9"/>
                            <stop offset="100%" stop-color="#3730a3"/>
                        </linearGradient>
                        <linearGradient id="devBaseGrad" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="0%" stop-color="#4c1d95"/>
                            <stop offset="100%" stop-color="#2e1065"/>
                        </linearGradient>
                        <radialGradient id="devGlassGrad" cx="35%" cy="30%" r="75%">
                            <stop offset="0%" stop-color="#ffffff" stop-opacity=".9"/>
                            <stop offset="45%" stop-color="#cbd5e1" stop-opacity=".55"/>
                            <stop offset="100%" stop-color="#64748b" stop-opacity=".35"/>
                        </radialGradient>
                    </defs>

                    <!-- Side code panel peeking out behind the laptop -->
                    <rect x="205" y="26" width="235" height="220" rx="14" fill="url(#devPanelGrad)" opacity=".88"/>
                    <circle cx="345" cy="140" r="40" fill="none" stroke="rgba(255,255,255,.55)" stroke-width="5" stroke-dasharray="7 8"/>
                    <circle cx="345" cy="140" r="7" fill="rgba(255,255,255,.75)"/>
                    <rect x="228" y="48" width="120" height="6" rx="3" fill="rgba(255,255,255,.4)"/>
                    <rect x="228" y="64" width="80" height="6" rx="3" fill="rgba(255,255,255,.3)"/>
                    <rect x="405" y="58" width="4" height="6" fill="rgba(255,255,255,.4)"/>
                    <rect x="405" y="72" width="4" height="6" fill="rgba(255,255,255,.4)"/>
                    <rect x="405" y="86" width="4" height="6" fill="rgba(255,255,255,.3)"/>
                    <rect x="228" y="196" width="70" height="6" rx="3" fill="rgba(255,255,255,.35)"/>
                    <rect x="228" y="212" width="100" height="6" rx="3" fill="rgba(255,255,255,.3)"/>

                    <!-- Laptop screen -->
                    <rect x="34" y="48" width="238" height="196" rx="16" fill="url(#devScreenGrad)"/>

                    <!-- Browser card with code snippet -->
                    <rect x="54" y="30" width="168" height="120" rx="10" fill="#f5f3ff"/>
                    <circle cx="70" cy="45" r="4" fill="#f87171"/>
                    <circle cx="83" cy="45" r="4" fill="#fbbf24"/>
                    <circle cx="96" cy="45" r="4" fill="#34d399"/>
                    <rect x="68" y="60" width="140" height="8" rx="4" fill="#7c3aed"/>
                    <rect x="68" y="76" width="100" height="6" rx="3" fill="rgba(30,20,60,.35)"/>
                    <rect x="80" y="90" width="110" height="6" rx="3" fill="#22d3ee"/>
                    <rect x="80" y="104" width="80" height="6" rx="3" fill="rgba(30,20,60,.3)"/>
                    <rect x="68" y="118" width="60" height="6" rx="3" fill="#7c3aed"/>
                    <rect x="68" y="132" width="130" height="6" rx="3" fill="rgba(30,20,60,.25)"/>

                    <!-- Keyboard / base -->
                    <path d="M14 244 L292 244 L316 292 L-10 292 Z" fill="url(#devBaseGrad)"/>
                    <ellipse cx="153" cy="304" rx="60" ry="10" fill="rgba(3,4,20,.4)"/>

                    <!-- Magnifying glass — animated via GSAP -->
                    <g id="devMagnifier" transform="translate(210,232) rotate(18)">
                        <line x1="30" y1="30" x2="78" y2="78" stroke="#cbd5e1" stroke-width="14" stroke-linecap="round"/>
                        <circle r="46" fill="url(#devGlassGrad)" stroke="rgba(255,255,255,.55)" stroke-width="6"/>
                    </g>
                </svg>
            </div>
        </div>
    </div>
</section>