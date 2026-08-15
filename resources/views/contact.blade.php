<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Contact | NSential</title>

     <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='80'>🖊️</text></svg>">
    
    <meta
        name="description"
        content="Get in touch with NSential — story pitches, corrections, sponsorships, or just to say hi. We cover 8 expert niches including AI, Finance, Health, Career, Tech Reviews, Digital Marketing, Affiliate Products, and Global Local Information."
    >

    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="Contact | NSential">
    <meta property="og:description" content="Get in touch with NSential — story pitches, corrections, sponsorships, or just to say hi. We cover 8 expert niches including AI, Finance, Health, Career, Tech Reviews, Digital Marketing, Affiliate Products, and Global Local Information.">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="NSential">
    <meta property="og:locale" content="en_US">

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- GSAP + ScrollTrigger -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js" defer></script>

    <!-- Fonts used site-wide -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;600;700&family=Inter:wght@400;500;600&family=JetBrains+Mono:wght@500&display=swap" rel="stylesheet">

    <style>
        /* ============================================================
           DESIGN TOKENS — shared across the whole site
           ============================================================ */
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

        *{margin:0;padding:0;box-sizing:border-box}

        html{ scroll-behavior:smooth; scroll-padding-top:5.5rem; }

        body{
            background: var(--ink);
            color: var(--paper);
            font-family:'Inter',-apple-system,sans-serif;
            line-height:1.5;
            -webkit-font-smoothing:antialiased;
            text-rendering:optimizeLegibility;
            overflow-x:hidden;
            background-image:
                radial-gradient(50% 35% at 85% 0%, rgba(124,58,237,.12), transparent 70%),
                radial-gradient(45% 30% at 10% 40%, rgba(34,211,238,.08), transparent 70%);
            background-repeat:no-repeat;
        }
        h1,h2,h3,h4{ font-family:'Space Grotesk',sans-serif; letter-spacing:-.01em; }

        a:focus-visible, button:focus-visible, input:focus-visible, textarea:focus-visible, select:focus-visible{
            outline: 2px solid var(--cyan);
            outline-offset: 3px;
            border-radius: 4px;
        }

        @media (prefers-reduced-motion: reduce){ html{ scroll-behavior:auto; } }

        .fixed{position:fixed}
        .top-0{top:0} .left-0{left:0} .right-0{right:0} .z-50{z-index:50}
        .hidden{display:none}
        .flex{display:flex} .items-center{align-items:center} .justify-between{justify-content:space-between}
        .h-16{height:4rem}
        .max-w-6xl{max-width:72rem}
        .mx-auto{margin-left:auto;margin-right:auto}
        .px-4{padding-left:1rem;padding-right:1rem}
        .rounded-lg{border-radius:0.75rem}

        .glass{
            background: linear-gradient(155deg, rgba(255,255,255,.06), rgba(255,255,255,.02));
            border: 1px solid var(--line);
            backdrop-filter: blur(16px) saturate(140%);
            -webkit-backdrop-filter: blur(16px) saturate(140%);
        }
        .grad-text{
            background: linear-gradient(100deg, #a78bfa, #60a5fa 55%, #22d3ee);
            -webkit-background-clip:text; background-clip:text; color:transparent;
        }
        .grad-btn{
            font-weight:600; color:#0a0a12;
            background:linear-gradient(100deg,#e9d5ff,#a5f3fc);
            box-shadow: 0 8px 30px rgba(124,58,237,.35);
            transition: transform .25s ease, box-shadow .25s ease;
        }
        .grad-btn:hover{ transform:translateY(-2px); box-shadow:0 12px 36px rgba(124,58,237,.5); }

        .page-content{ position:relative; z-index:1; }
        .reveal-up{ opacity:0; transform:translateY(28px); }
        .reveal-item{ opacity:0; transform:translateY(18px); }

        /* ================= NAVBAR (shared) ================= */
        #navbar{
            border-bottom: 1px solid var(--line);
            background: linear-gradient(180deg, rgba(11,12,26,.86), rgba(11,12,26,.62));
        }
        #navbar::after{
            content:''; position:absolute; left:0; right:0; bottom:-1px; height:1px;
            background: linear-gradient(90deg, transparent, rgba(124,58,237,.55), rgba(34,211,238,.5), transparent);
            opacity:.7;
        }
        .nav-logo{ display:flex; align-items:center; gap:.6rem; text-decoration:none; }
        .nav-logo-mark{
            display:flex; align-items:center; justify-content:center;
            width:2.25rem; height:2.25rem; border-radius:.7rem;
            background: linear-gradient(135deg, rgba(124,58,237,.35), rgba(34,211,238,.25));
            border:1px solid rgba(255,255,255,.14);
            transition: transform .3s ease, box-shadow .3s ease;
        }
        .nav-logo:hover .nav-logo-mark{ transform: rotate(-6deg) scale(1.05); box-shadow: 0 8px 22px rgba(124,58,237,.35); }
        .nav-logo-text{ font-family:'Space Grotesk',sans-serif; font-weight:700; font-size:1.05rem; letter-spacing:-.01em; color:var(--paper); }
        .nav-links{
            display:flex; align-items:center; gap:.2rem;
            padding:.3rem; border-radius:999px;
            background: rgba(255,255,255,.04);
            border:1px solid var(--line);
        }
        .nav-link{
            color: var(--mist); text-decoration: none; font-size: .85rem; font-weight: 500;
            transition: color .2s ease, background .2s ease, box-shadow .2s ease;
            padding: .5rem 1rem; border-radius: 999px; white-space:nowrap;
        }
        .nav-link:hover{ color: var(--paper); background: rgba(255,255,255,.07); }
        .nav-link.active{
            color: #0a0a12;
            background: linear-gradient(100deg,#c4b5fd,#67e8f9);
            box-shadow: 0 6px 18px rgba(124,58,237,.3);
        }
        #userMenuBtn{ box-shadow: 0 4px 16px rgba(124,58,237,.3); transition: transform .2s ease, box-shadow .2s ease; }
        #userMenuBtn:hover{ transform: scale(1.06); box-shadow: 0 6px 20px rgba(124,58,237,.45); }
        #userMenu{ overflow:hidden; box-shadow: 0 24px 48px rgba(3,4,20,.55); transform-origin: top right; }
        #userMenu a, #userMenu button[type="submit"]{ display:flex; align-items:center; gap:.55rem; }
        #userMenu a:hover, #userMenu button[type="submit"]:hover{ background: rgba(255,255,255,.06); color: var(--cyan) !important; }
        #userMenu i{ width:1rem; text-align:center; color:var(--mist); font-size:.8rem; }

        .nav-toggle-btn{
            display:none; align-items:center; justify-content:center;
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
        #mobileNavPanel{ display:none; flex-direction:column; gap:.25rem; padding: .75rem 0 1.1rem; border-top: 1px solid var(--line); }
        #mobileNavPanel.open{ display:flex; }
        #mobileNavPanel .nav-link{ width:100%; padding:.85rem 1rem; border-radius:.75rem; text-align:left; }
        #mobileNavPanel .nav-link.active{ box-shadow:none; }
        @media(max-width:767px){ .nav-links{ display:none; } .nav-toggle-btn{ display:inline-flex; } }

        /* ================= CONTACT HERO ================= */
        .contact-hero{
            position:relative; overflow:hidden;
            background:
                radial-gradient(60% 50% at 85% 5%, rgba(124,58,237,.3), transparent 70%),
                radial-gradient(50% 45% at 10% 10%, rgba(34,211,238,.2), transparent 70%),
                var(--ink);
            padding: 7.5rem 1.5rem 3rem;
        }
        .contact-hero-inner{ max-width:52rem; margin:0 auto; }
        .eyebrow{
            font-family:'JetBrains Mono',monospace; font-size:.72rem; letter-spacing:.2em;
            text-transform:uppercase; color:var(--cyan); display:inline-flex; align-items:center; gap:.5rem;
            margin-bottom:1.25rem;
        }
        .eyebrow::before{ content:''; width:.4rem; height:.4rem; border-radius:999px; background:var(--cyan); box-shadow:0 0 10px var(--cyan); }
        .contact-heading{
            font-weight:700; line-height:1.06; letter-spacing:-.02em;
            font-size: clamp(2.1rem, 4.6vw, 3.2rem);
            margin-bottom: 1.2rem;
        }
        .contact-lede{ font-size: clamp(1rem,1.3vw,1.1rem); line-height:1.75; color:var(--mist); max-width:36rem; }

        /* ================= LAYOUT: TERMINAL + FORM ================= */
        .contact-layout{
            max-width:72rem; margin:0 auto; padding: 1rem 1.5rem 5rem;
            display:grid; grid-template-columns:1fr; gap:2rem;
        }
        @media(min-width:960px){ .contact-layout{ grid-template-columns: 0.85fr 1.15fr; gap:2.25rem; align-items:start; } }

        /* ---------- SIGNATURE: terminal-styled contact card ---------- */
        .terminal-card{
            border-radius:1.1rem; overflow:hidden;
            box-shadow: 0 25px 55px rgba(3,4,20,.5);
        }
        .terminal-bar{
            display:flex; align-items:center; gap:.5rem;
            padding:.75rem 1rem; border-bottom:1px solid var(--line);
            background: rgba(255,255,255,.03);
        }
        .terminal-dot{ width:.65rem; height:.65rem; border-radius:999px; }
        .terminal-bar .t-red{ background:#f87171; }
        .terminal-bar .t-yellow{ background:#fbbf24; }
        .terminal-bar .t-green{ background:#34d399; }
        .terminal-title{
            margin-left:.5rem; font-family:'JetBrains Mono',monospace; font-size:.72rem; color:var(--mist);
        }
        .terminal-body{ padding:1.5rem 1.4rem 1.6rem; font-family:'JetBrains Mono',monospace; font-size:.84rem; line-height:1.9; }
        .terminal-line{ color:var(--mist); }
        .terminal-prompt{ color:var(--cyan); }
        .terminal-key{ color:#c4b5fd; }
        .terminal-val{ color:var(--paper); }
        .terminal-comment{ color:rgba(148,163,184,.55); }
        .terminal-cursor{
            display:inline-block; width:.55rem; height:1.05rem; background:var(--cyan);
            margin-left:.15rem; vertical-align:middle; animation: blink 1s step-end infinite;
        }
        @keyframes blink{ 50%{ opacity:0; } }

        .terminal-divider{ height:1px; background:var(--line); margin:1.1rem 0; }

        .contact-channels{ display:flex; flex-direction:column; gap:.85rem; margin-top:.4rem; }
        .channel-row{
            display:flex; align-items:center; gap:.75rem;
            text-decoration:none; padding:.6rem .1rem; border-radius:.6rem;
            transition: background .2s ease;
        }
        .channel-row:hover{ background: rgba(255,255,255,.05); }
        .channel-icon{
            flex-shrink:0; width:2.2rem; height:2.2rem; border-radius:.65rem;
            display:flex; align-items:center; justify-content:center;
            background: linear-gradient(155deg, rgba(124,58,237,.28), rgba(34,211,238,.18));
            border:1px solid rgba(255,255,255,.14); color:var(--cyan); font-size:.85rem;
        }
        .channel-text{ min-width:0; }
        .channel-label{ font-family:'Inter',sans-serif; font-size:.82rem; font-weight:600; color:var(--paper); }
        .channel-value{ font-family:'JetBrains Mono',monospace; font-size:.76rem; color:var(--mist); }

        .status-badge{
            display:inline-flex; align-items:center; gap:.4rem;
            font-family:'JetBrains Mono',monospace; font-size:.72rem;
            color:#34d399; background:rgba(52,211,153,.1); border:1px solid rgba(52,211,153,.25);
            padding:.3rem .7rem; border-radius:999px; margin-top:1.2rem;
        }
        .status-badge::before{ content:''; width:.4rem; height:.4rem; border-radius:999px; background:#34d399; box-shadow:0 0 8px #34d399; }

        /* ---------- Contact form ---------- */
        .form-card{ border-radius:1.1rem; padding:1.9rem 1.8rem 2rem; }
        .form-card h2{ font-size:1.3rem; margin-bottom:.4rem; }
        .form-card .form-sub{ font-size:.85rem; color:var(--mist); margin-bottom:1.6rem; }

        .form-row{ display:grid; grid-template-columns:1fr; gap:1.1rem; margin-bottom:1.1rem; }
        @media(min-width:560px){ .form-row.two-col{ grid-template-columns:1fr 1fr; } }

        .form-field label{
            display:block; font-size:.78rem; font-weight:600; color:var(--paper);
            margin-bottom:.45rem; letter-spacing:.02em;
        }
        .form-field input,
        .form-field select,
        .form-field textarea{
            width:100%; padding:.75rem .95rem; border-radius:.7rem;
            border:1px solid var(--line); background:rgba(255,255,255,.04);
            color:var(--paper); font-size:.88rem; font-family:'Inter',sans-serif;
            transition: border-color .2s ease, background .2s ease, box-shadow .2s ease;
        }
        .form-field textarea{ resize:vertical; min-height:8.5rem; line-height:1.6; }
        .form-field input::placeholder, .form-field textarea::placeholder{ color:rgba(148,163,184,.55); }
        .form-field input:focus, .form-field select:focus, .form-field textarea:focus{
            outline:none; border-color: rgba(167,139,250,.55);
            background: rgba(255,255,255,.07); box-shadow: 0 0 0 3px rgba(124,58,237,.16);
        }
        .form-field select{ appearance:none; cursor:pointer;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%2394a3b8' stroke-width='1.6' fill='none' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
            background-repeat:no-repeat; background-position:right .95rem center; padding-right:2.4rem;
        }
        .form-field select option{ background:#14152a; color:var(--paper); }

        .form-error{
            color: #f87171;
            font-size: 0.75rem;
            margin-top: 0.3rem;
            display: block;
        }

        .alert-success{
            background: rgba(52, 211, 153, 0.1);
            border: 1px solid rgba(52, 211, 153, 0.25);
            color: #34d399;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .alert-error{
            background: rgba(248, 113, 113, 0.1);
            border: 1px solid rgba(248, 113, 113, 0.25);
            color: #f87171;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .form-submit{
            width:100%; margin-top:.4rem;
            font-weight:600; font-size:.92rem; color:#0a0a12;
            background:linear-gradient(100deg,#e9d5ff,#a5f3fc);
            padding:.9rem 1.6rem; border-radius:.8rem; border:none; cursor:pointer;
            box-shadow: 0 10px 30px rgba(124,58,237,.35);
            display:inline-flex; align-items:center; justify-content:center; gap:.55rem;
            transition: transform .25s ease, box-shadow .25s ease;
        }
        .form-submit:hover{ transform:translateY(-2px); box-shadow:0 14px 36px rgba(124,58,237,.5); }
        .form-note{ font-size:.75rem; color:var(--mist); text-align:center; margin-top:.9rem; }

        /* ================= FAQ ================= */
        .faq-section{ max-width:52rem; margin:0 auto; padding: 0 1.5rem 6rem; }
        .section-heading{ display:flex; align-items:center; gap:1rem; margin-bottom:1.75rem; }
        .section-chip{
            flex-shrink:0; width:2.75rem; height:2.75rem; border-radius:.9rem;
            display:flex; align-items:center; justify-content:center; font-size:1.05rem;
            background: linear-gradient(155deg, rgba(124,58,237,.28), rgba(34,211,238,.18));
            border:1px solid rgba(255,255,255,.14); color: var(--cyan);
            box-shadow: 0 10px 24px rgba(124,58,237,.2);
        }
        .section-title{ font-weight:700; font-size:1.4rem; color:var(--paper); line-height:1.2; }
        .section-sub{ font-family:'JetBrains Mono',monospace; font-size:.7rem; letter-spacing:.2em; text-transform:uppercase; color:var(--cyan); }

        .faq-item{ border-radius:1rem; margin-bottom:.75rem; overflow:hidden; }
        .faq-question{
            width:100%; display:flex; align-items:center; justify-content:space-between; gap:1rem;
            padding:1.1rem 1.3rem; background:none; border:none; cursor:pointer;
            color:var(--paper); font-size:.92rem; font-weight:600; text-align:left;
        }
        .faq-question i{ color:var(--cyan); transition: transform .25s ease; flex-shrink:0; }
        .faq-item.open .faq-question i{ transform: rotate(45deg); }
        .faq-answer{ max-height:0; overflow:hidden; transition: max-height .3s ease; }
        .faq-answer-inner{ padding: 0 1.3rem 1.1rem; font-size:.86rem; color:var(--mist); line-height:1.65; }

        /* ================= FOOTER (shared) ================= */
        .site-footer{
            position:relative; z-index:1; margin-top:0;
            background: linear-gradient(180deg, rgba(11,12,26,0), rgba(11,12,26,.92) 25%, var(--panel));
            border-top:1px solid var(--line);
        }
        .footer-inner{ padding: 3.5rem 1rem 2rem; }
        .footer-grid{ display:grid; grid-template-columns:1fr; gap:2.5rem; }
        @media(min-width:768px){ .footer-grid{ grid-template-columns: 1.4fr 1fr 1fr 1.3fr; gap:2rem; } }
        .footer-brand .footer-logo{ margin-bottom:1rem; }
        .footer-tagline{ color:var(--mist); font-size:.9rem; line-height:1.65; max-width:22rem; margin-bottom:1.25rem; }
        .footer-social{ display:flex; gap:.65rem; }
        .footer-social a{
            width:2.25rem; height:2.25rem; border-radius:.6rem;
            display:flex; align-items:center; justify-content:center;
            border:1px solid var(--line); background:rgba(255,255,255,.03);
            color:var(--mist); text-decoration:none; transition: all .2s ease;
        }
        .footer-social a:hover{ color:var(--cyan); border-color:rgba(255,255,255,.3); background:rgba(255,255,255,.07); transform:translateY(-2px); }
        .footer-col h5{ font-family:'Space Grotesk',sans-serif; font-size:.95rem; font-weight:600; color:var(--paper); margin-bottom:1rem; }
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
            border:none; cursor:pointer; transition: transform .2s ease, box-shadow .2s ease;
        }
        .footer-form button:hover{ transform:translateY(-2px); box-shadow:0 8px 22px rgba(124,58,237,.35); }

        /* ---------- "Your Account" footer column — fills the space the
           newsletter column would otherwise leave empty when logged in ---------- */
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
        .footer-bottom-links a{ color:var(--mist); text-decoration:none; transition:color .2s ease; background:none; border:none; cursor:pointer; font-size:.8rem; font-family:'Inter',sans-serif; padding:0; }
        .footer-bottom-links a:hover{ color:var(--cyan); }

        /* ================= LEGAL MODAL (Privacy Policy / Terms of Service) ================= */
        .legal-modal-overlay{
            position:fixed; inset:0; z-index:200;
            display:none;
            align-items:center; justify-content:center;
            padding:1.5rem;
            background: rgba(3,4,16,.72);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
        }
        .legal-modal-overlay.open{ display:flex; }
        .legal-modal{
            position:relative; width:100%; max-width:38rem; max-height:82vh;
            display:flex; flex-direction:column;
            background: linear-gradient(155deg, #14152a, #0b0c1a);
            border:1px solid rgba(255,255,255,.14);
            border-radius:1.25rem;
            box-shadow: 0 40px 80px rgba(3,4,20,.6);
            overflow:hidden;
            animation: legalModalIn .25s ease;
        }
        @keyframes legalModalIn{
            from{ opacity:0; transform: translateY(14px) scale(.98); }
            to{ opacity:1; transform: translateY(0) scale(1); }
        }
        .legal-modal-header{
            display:flex; align-items:center; justify-content:space-between;
            padding:1.25rem 1.5rem; flex-shrink:0;
            border-bottom:1px solid var(--line);
        }
        .legal-modal-header h3{
            font-size:1.1rem; font-weight:600; color:var(--paper);
            display:flex; align-items:center; gap:.65rem;
        }
        .legal-modal-header h3 i{ color:var(--cyan); font-size:.95rem; }
        .legal-modal-close{
            width:2.1rem; height:2.1rem; border-radius:.6rem; flex-shrink:0;
            display:flex; align-items:center; justify-content:center;
            border:1px solid var(--line); background:rgba(255,255,255,.04);
            color:var(--mist); cursor:pointer;
            transition: all .2s ease;
        }
        .legal-modal-close:hover{ color:var(--paper); background:rgba(255,255,255,.09); border-color:rgba(255,255,255,.3); }
        .legal-modal-body{
            padding:1.5rem; overflow-y:auto;
            font-size:.86rem; line-height:1.75; color:var(--mist);
            scrollbar-width: thin; scrollbar-color: rgba(167,139,250,.55) transparent;
        }
        .legal-modal-body::-webkit-scrollbar{ width:6px; }
        .legal-modal-body::-webkit-scrollbar-thumb{ background: rgba(255,255,255,.15); border-radius:999px; }
        .legal-modal-updated{
            display:inline-block; font-family:'JetBrains Mono',monospace; font-size:.68rem;
            letter-spacing:.08em; text-transform:uppercase; color:var(--cyan);
            background: rgba(34,211,238,.1); border:1px solid rgba(34,211,238,.25);
            padding:.3rem .6rem; border-radius:999px; margin-bottom:1.1rem;
        }
        .legal-modal-body h4{
            font-family:'Space Grotesk',sans-serif; font-size:.92rem; color:var(--paper);
            margin: 1.35rem 0 .5rem;
        }
        .legal-modal-body h4:first-of-type{ margin-top:0; }
        .legal-modal-body p{ margin-bottom:.85rem; }
        .legal-modal-body ul{ margin:0 0 .85rem 1.2rem; display:flex; flex-direction:column; gap:.4rem; }
        .legal-modal-footer{
            padding:1rem 1.5rem; border-top:1px solid var(--line); flex-shrink:0;
            display:flex; align-items:center; justify-content:space-between; gap:1rem;
        }
        .legal-modal-footer span{ font-size:.75rem; color:var(--mist); }
        .legal-modal-footer button{
            padding:.6rem 1.3rem; border-radius:999px; font-size:.85rem; font-weight:600;
            color:#0a0a12; background:linear-gradient(100deg,#e9d5ff,#a5f3fc);
            border:none; cursor:pointer;
            transition: transform .2s ease, box-shadow .2s ease;
        }
        .legal-modal-footer button:hover{ transform:translateY(-2px); box-shadow:0 8px 22px rgba(124,58,237,.35); }
        @media(max-width:640px){
            .legal-modal-footer{ flex-direction:column; align-items:stretch; }
            .legal-modal-footer button{ width:100%; }
        }

        @media (max-width:767px){
            .contact-hero{ padding: 6rem 1.25rem 2.5rem; }
            .form-card{ padding:1.6rem 1.3rem 1.8rem; }
            .footer-inner{ padding: 2.75rem 1rem 1.5rem; }
            .footer-grid{ gap:2rem; }
            .footer-bottom{ flex-direction:column; align-items:flex-start; gap:.85rem; }
            .legal-modal{ max-height:88vh; }
            .legal-modal-header{ padding:1.1rem 1.25rem; }
            .legal-modal-body{ padding:1.25rem; }
            .legal-modal-footer{ padding:.9rem 1.25rem; }
        }
    </style>
    <script src="https://cdn.tailwindcss.com" async></script>
</head>
<body>

    {{-- ============================= NAVBAR (shared, matches index.blade.php) ============================= --}}
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
                        <span class="nav-logo-text hidden sm:inline">NSential</span>
                    </a>
                </div>

                <!-- Center: Nav links (Posts, About, Contact) — desktop only -->
                <div class="hidden md:flex nav-links" data-nav-el="links">
                    <a href="{{ route('home') }}#postsGrid" class="nav-link">Posts</a>
                    <a href="{{ route('about') }}" class="nav-link">About</a>
                    <a href="{{ route('contact') }}" class="nav-link active">Contact</a>
                </div>

                <!-- Right: Auth area + mobile hamburger toggle -->
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

                    <!-- Mobile hamburger toggle: only visible under md breakpoint, controls #mobileNavPanel -->
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

            <!-- Mobile nav panel: same links as desktop, stacked, shown when hamburger is open -->
            <div id="mobileNavPanel" role="menu" aria-label="Mobile navigation">
                <a href="{{ route('home') }}#postsGrid" class="nav-link" role="menuitem" onclick="closeMobileNav()">Posts</a>
                <a href="{{ route('about') }}" class="nav-link" role="menuitem" onclick="closeMobileNav()">About</a>
                <a href="{{ route('contact') }}" class="nav-link active" role="menuitem" onclick="closeMobileNav()">Contact</a>
            </div>
        </div>
    </nav>

    <div class="h-16"></div>

    {{-- ============================= CONTACT HERO ============================= --}}
    <section class="contact-hero">
        <div class="contact-hero-inner" id="contactHeroContent">
            <span class="eyebrow">Get in Touch</span>
            <h1 class="contact-heading">
                Questions, pitches, or<br>
                just <span class="grad-text">say hello.</span>
            </h1>
            <p class="contact-lede">
                Whether it's a correction you spotted in an article, a topic you want covered in one of our 8 niches — Artificial Intelligence, Finance & Online Earning, Health & Fitness, Education & Career, Tech Reviews, Digital Marketing & SEO, Product Reviews (Affiliate), or Local Informational (World-based) — or a partnership idea, this goes straight to our expert team.
            </p>
        </div>
    </section>

    <div class="page-content">

        {{-- ============================= TERMINAL + FORM ============================= --}}
        <section class="contact-layout">

            {{-- ---------- SIGNATURE: terminal-styled contact card ---------- --}}
            <div class="glass terminal-card reveal-up">
                <div class="terminal-bar">
                    <span class="terminal-dot t-red"></span>
                    <span class="terminal-dot t-yellow"></span>
                    <span class="terminal-dot t-green"></span>
                    <span class="terminal-title">~/contact</span>
                </div>
                <div class="terminal-body">
                    <div class="terminal-line"><span class="terminal-comment"># reach our expert team</span></div>
                    <div class="terminal-line"><span class="terminal-prompt">$</span> whoami</div>
                    <div class="terminal-line"><span class="terminal-val">the-NSential-experts</span></div>
                    <div class="terminal-line">&nbsp;</div>
                    <div class="terminal-line"><span class="terminal-prompt">$</span> cat contact.json</div>
                    <div class="terminal-line">{</div>
                    <div class="terminal-line">&nbsp;&nbsp;<span class="terminal-key">"response_time"</span>: <span class="terminal-val">"~1 business day"</span>,</div>
                    <div class="terminal-line">&nbsp;&nbsp;<span class="terminal-key">"timezone"</span>: <span class="terminal-val">"PKT, UTC+5"</span></div>
                    <div class="terminal-line">}<span class="terminal-cursor" aria-hidden="true"></span></div>

                    <div class="terminal-divider"></div>

                    <div class="contact-channels">
                        <a href="mailto:hello@NSential.test" class="channel-row">
                            <span class="channel-icon"><i class="fas fa-envelope"></i></span>
                            <span class="channel-text">
                                <span class="channel-label" style="display:block;">Email</span>
                                <span class="channel-value">nsential0@gmail.com</span>
                            </span>
                        </a>
                        <a href="https://github.com/bilal-157/" class="channel-row" target="_blank" rel="noopener noreferrer">
                            <span class="channel-icon"><i class="fa-brands fa-github"></i></span>
                            <span class="channel-text">
                                <span class="channel-label" style="display:block;">GitHub</span>
                                <span class="channel-value">https://github.com/bilal-157/</span>
                            </span>
                        </a>

                    </div>

                    <span class="status-badge">accepting messages</span>
                </div>
            </div>

            {{-- ---------- Contact form ---------- --}}
            <div class="glass form-card reveal-up">
                <h2>Send a message</h2>
                <p class="form-sub">Fields marked with an asterisk are required.</p>

                @if(session('success'))
                    <div class="alert-success">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert-error">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('contact.submit') }}">
                    @csrf

                    <div class="form-row two-col">
                        <div class="form-field">
                            <label for="contactName">Name *</label>
                            <input type="text" id="contactName" name="name" placeholder="Your full name" value="{{ old('name') }}" required>
                            @error('name')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-field">
                            <label for="contactEmail">Email *</label>
                            <input type="email" id="contactEmail" name="email" placeholder="you@example.com" value="{{ old('email') }}" required>
                            @error('email')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-field">
                            <label for="contactTopic">What's this about? *</label>
                            <select id="contactTopic" name="topic" required>
                                <option value="" selected disabled>Choose a topic</option>
                                <option value="story-pitch" {{ old('topic') == 'story-pitch' ? 'selected' : '' }}>Story pitch for a niche</option>
                                <option value="correction" {{ old('topic') == 'correction' ? 'selected' : '' }}>Correction / update to an article</option>
                                <option value="sponsorship" {{ old('topic') == 'sponsorship' ? 'selected' : '' }}>Sponsorship or partnership</option>
                                <option value="expert-contribution" {{ old('topic') == 'expert-contribution' ? 'selected' : '' }}>Expert contribution / guest post</option>
                                <option value="general" {{ old('topic') == 'general' ? 'selected' : '' }}>General question</option>
                                <option value="other" {{ old('topic') == 'other' ? 'selected' : '' }}>Something else</option>
                            </select>
                            @error('topic')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-field">
                            <label for="contactMessage">Message *</label>
                            <textarea id="contactMessage" name="message" placeholder="Tell us what's on your mind — article idea, feedback, or collaboration..." required>{{ old('message') }}</textarea>
                            @error('message')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="form-submit">
                        Send Message
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M13 5l7 7-7 7"/></svg>
                    </button>
                    <p class="form-note">We typically reply within one business day.</p>
                </form>
            </div>
        </section>

        {{-- ============================= FAQ ============================= --}}
        <section class="faq-section">
            <div class="section-heading">
                <span class="section-chip"><i class="fas fa-circle-question"></i></span>
                <div>
                    <span class="section-sub">Before You Write In</span>
                    <h2 class="section-title">Common Questions</h2>
                </div>
            </div>

            <div class="faq-item glass" data-faq>
                <button type="button" class="faq-question" onclick="toggleFaq(this)">
                    <span>Do you accept guest posts from experts?</span>
                    <i class="fas fa-plus"></i>
                </button>
                <div class="faq-answer">
                    <div class="faq-answer-inner">
                        Yes — we welcome contributions from industry experts. Send a pitch with your topic idea and a brief outline. We look for practical, actionable insights that serve our readers across all 8 niches.
                    </div>
                </div>
            </div>

            <div class="faq-item glass" data-faq>
                <button type="button" class="faq-question" onclick="toggleFaq(this)">
                    <span>I found an error in an article. How do I report it?</span>
                    <i class="fas fa-plus"></i>
                </button>
                <div class="faq-answer">
                    <div class="faq-answer-inner">
                        Use the form above and select "Correction." Please include the article title and the specific detail that needs updating. We prioritize accuracy and fix confirmed issues quickly.
                    </div>
                </div>
            </div>

            <div class="faq-item glass" data-faq>
                <button type="button" class="faq-question" onclick="toggleFaq(this)">
                    <span>Do you offer sponsorships or partnerships?</span>
                    <i class="fas fa-plus"></i>
                </button>
                <div class="faq-answer">
                    <div class="faq-answer-inner">
                        We work with a select number of relevant sponsors and partners each quarter. Select "Sponsorship" above and tell us about your product, audience, and how you'd like to collaborate with our expert platform.
                    </div>
                </div>
            </div>
        </section>
    </div>

    {{-- ============================= FOOTER (shared, matches index.blade.php) ============================= --}}
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
                        <span class="nav-logo-text">NSential</span>
                    </a>
                    <p class="footer-tagline">
                        Expert insights across 8 niches — AI, Finance, Health, Career, Tech Reviews, Digital Marketing, Affiliate Products, and Global Local Information. Practical knowledge from industry professionals.
                    </p>
<div class="footer-social">
    <a href="mailto:nsential0@gmail.com" aria-label="Email"><i class="fas fa-envelope"></i></a>
    <a href="https://github.com/bilal-157/" target="_blank" rel="noopener noreferrer" aria-label="GitHub"><i class="fa-brands fa-github"></i></a>
    <a href="https://www.linkedin.com/in/muhammadbilal711" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn"><i class="fa-brands fa-linkedin"></i></a>
</div>
                </div>

                <div class="footer-col">
                    <h5>Explore</h5>
                    <ul>
                        <li><a href="{{ route('home') }}#postsGrid">All Posts</a></li>
                        <li><a href="{{ route('home') }}#categoryFilters">Categories</a></li>
                        <li><a href="{{ route('about') }}">About</a></li>
                        <li><a href="{{ route('contact') }}">Contact</a></li>
                    </ul>
                </div>

                {{-- ========== RESOURCES SECTION - always shown, keeps the grid balanced ========== --}}
                <div class="footer-col">
                    <h5>Resources</h5>
                    <ul>
                        <li><a href="{{ url('/') }}/#" onclick="event.preventDefault(); openLegalModal('privacy')"><i class="fas fa-shield-halved"></i> Privacy Policy</a></li>
                        <li><a href="{{ url('/') }}/#" onclick="event.preventDefault(); openLegalModal('terms')"><i class="fas fa-file-contract"></i> Terms of Service</a></li>
                        <li><a href="{{ url('/') }}/#"><i class="fas fa-rss"></i> RSS Feed</a></li>
                        <li><a href="{{ url('/') }}/#"><i class="fas fa-sitemap"></i> Sitemap</a></li>
                    </ul>
                </div>

                {{-- ========== 4TH COLUMN - Newsletter for guests, Account summary for logged-in users
                     so the footer stays visually balanced no matter who's viewing it ========== --}}
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
                {{-- ========== END 4TH COLUMN ========== --}}

            </div>

            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} NSential. All rights reserved.</p>
                <div class="footer-bottom-links">
                    <a href="{{ url('/') }}/#" onclick="event.preventDefault(); openLegalModal('privacy')">Privacy Policy</a>
                    <a href="{{ url('/') }}/#" onclick="event.preventDefault(); openLegalModal('terms')">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    {{-- ============================= LEGAL MODALS (Privacy Policy / Terms of Service) ============================= --}}
    <div class="legal-modal-overlay" id="privacyModalOverlay" role="dialog" aria-modal="true" aria-labelledby="privacyModalTitle">
        <div class="legal-modal">
            <div class="legal-modal-header">
                <h3 id="privacyModalTitle"><i class="fas fa-shield-halved"></i> Privacy Policy</h3>
                <button type="button" class="legal-modal-close" aria-label="Close privacy policy" onclick="closeLegalModal('privacy')">
                    <i class="fas fa-xmark"></i>
                </button>
            </div>
            <div class="legal-modal-body">
                <span class="legal-modal-updated">Last updated: {{ date('F Y') }}</span>
                <p>This is placeholder text describing how NSential handles your information. Replace this section with your actual privacy policy before launching to real users.</p>

                <h4>Information We Collect</h4>
                <p>When you create an account, subscribe to updates, or leave a review, we store the details you provide — such as your name, email address, and any content you submit. We also collect basic usage data like pages viewed and articles read, which helps us understand what content resonates with readers.</p>

                <h4>How We Use Your Data</h4>
                <ul>
                    <li>To create and maintain your account</li>
                    <li>To send you new articles and updates, only if you've subscribed</li>
                    <li>To display your reviews and comments alongside the posts they relate to</li>
                    <li>To improve the site based on aggregated, anonymized reading patterns</li>
                </ul>

                <h4>Cookies</h4>
                <p>We use a small number of cookies to keep you signed in and to remember your preferences, such as your last-viewed category filter. We don't use cookies for third-party advertising.</p>

                <h4>Your Rights</h4>
                <p>You can request a copy of your data, ask us to correct inaccuracies, or delete your account at any time by contacting us through the Contact page. Unsubscribing from emails takes effect immediately.</p>

                <h4>Contact</h4>
                <p>Questions about this placeholder policy can be directed to the site owner via the Contact page.</p>
            </div>
            <div class="legal-modal-footer">
                <span>This is dummy content for demonstration purposes.</span>
                <button type="button" onclick="closeLegalModal('privacy')">Close</button>
            </div>
        </div>
    </div>

    <div class="legal-modal-overlay" id="termsModalOverlay" role="dialog" aria-modal="true" aria-labelledby="termsModalTitle">
        <div class="legal-modal">
            <div class="legal-modal-header">
                <h3 id="termsModalTitle"><i class="fas fa-file-contract"></i> Terms of Service</h3>
                <button type="button" class="legal-modal-close" aria-label="Close terms of service" onclick="closeLegalModal('terms')">
                    <i class="fas fa-xmark"></i>
                </button>
            </div>
            <div class="legal-modal-body">
                <span class="legal-modal-updated">Last updated: {{ date('F Y') }}</span>
                <p>This is placeholder text outlining the terms for using NSential. Replace this section with your actual terms of service before launching to real users.</p>

                <h4>Acceptance of Terms</h4>
                <p>By creating an account or using this site, you agree to these terms. If you don't agree with any part of them, please don't use the site.</p>

                <h4>User Accounts</h4>
                <p>You're responsible for keeping your login credentials secure and for any activity that happens under your account. Let us know right away if you suspect unauthorized access.</p>

                <h4>Content Ownership</h4>
                <ul>
                    <li>Articles and site design remain the property of NSential</li>
                    <li>Reviews and comments you submit remain yours, but you grant us permission to display them alongside the related post</li>
                    <li>You may not republish full articles elsewhere without permission</li>
                </ul>

                <h4>Prohibited Uses</h4>
                <p>Please don't use the site to post spam, harassing content, or anything unlawful. We reserve the right to remove content or suspend accounts that violate these terms.</p>

                <h4>Termination</h4>
                <p>You may delete your account at any time. We may suspend accounts that repeatedly violate these terms after a warning.</p>

                <h4>Governing Law</h4>
                <p>These placeholder terms are provided as a starting template and don't constitute legal advice — consult a lawyer before publishing real terms of service.</p>
            </div>
            <div class="legal-modal-footer">
                <span>This is dummy content for demonstration purposes.</span>
                <button type="button" onclick="closeLegalModal('terms')">Close</button>
            </div>
        </div>
    </div>
    {{-- =========================== END LEGAL MODALS ============================ --}}

    <script>
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
        document.addEventListener('click', function (e) {
            const menu = document.getElementById('userMenu');
            const btn = document.getElementById('userMenuBtn');
            if (!menu || !btn) return;
            if (!menu.contains(e.target) && !btn.contains(e.target)) {
                menu.classList.add('hidden');
                btn.setAttribute('aria-expanded', 'false');
            }
        });

        function toggleMobileNav() {
            const panel = document.getElementById('mobileNavPanel');
            const btn = document.getElementById('navToggleBtn');
            const willOpen = !panel.classList.contains('open');
            panel.classList.toggle('open', willOpen);
            btn.setAttribute('aria-expanded', String(willOpen));
        }
        function closeMobileNav() {
            const panel = document.getElementById('mobileNavPanel');
            const btn = document.getElementById('navToggleBtn');
            panel.classList.remove('open');
            btn.setAttribute('aria-expanded', 'false');
        }
        document.addEventListener('click', function (e) {
            const panel = document.getElementById('mobileNavPanel');
            const btn = document.getElementById('navToggleBtn');
            if (!panel || !btn || !panel.classList.contains('open')) return;
            if (!panel.contains(e.target) && !btn.contains(e.target)) closeMobileNav();
        });
        window.addEventListener('resize', function () {
            if (window.innerWidth >= 768) closeMobileNav();
        });

        // ---------- FAQ accordion ----------
        function toggleFaq(btn) {
            const item = btn.closest('[data-faq]');
            const answer = item.querySelector('.faq-answer');
            const isOpen = item.classList.contains('open');

            document.querySelectorAll('[data-faq].open').forEach((openItem) => {
                if (openItem !== item) {
                    openItem.classList.remove('open');
                    openItem.querySelector('.faq-answer').style.maxHeight = null;
                }
            });

            if (isOpen) {
                item.classList.remove('open');
                answer.style.maxHeight = null;
            } else {
                item.classList.add('open');
                answer.style.maxHeight = answer.scrollHeight + 'px';
            }
        }

        document.addEventListener('keydown', function (e) {
            if (e.key !== 'Escape') return;
            closeMobileNav();
            const menu = document.getElementById('userMenu');
            const btn = document.getElementById('userMenuBtn');
            if (menu && !menu.classList.contains('hidden')) {
                menu.classList.add('hidden');
                btn.setAttribute('aria-expanded', 'false');
                btn.focus();
            }
            document.querySelectorAll('.legal-modal-overlay.open').forEach((overlay) => {
                overlay.classList.remove('open');
            });
            document.body.style.overflow = '';
        });

        // ---------- Legal modals (Privacy Policy / Terms of Service) ----------
        function getLegalModal(type) {
            return document.getElementById(type === 'privacy' ? 'privacyModalOverlay' : 'termsModalOverlay');
        }

        function openLegalModal(type) {
            const modal = getLegalModal(type);
            if (!modal) return;
            modal.classList.add('open');
            document.body.style.overflow = 'hidden';
            const closeBtn = modal.querySelector('.legal-modal-close');
            if (closeBtn) closeBtn.focus();
        }

        function closeLegalModal(type) {
            const modal = getLegalModal(type);
            if (!modal) return;
            modal.classList.remove('open');
            if (!document.querySelector('.legal-modal-overlay.open')) {
                document.body.style.overflow = '';
            }
        }

        document.querySelectorAll('.legal-modal-overlay').forEach((overlay) => {
            overlay.addEventListener('click', function (e) {
                if (e.target === overlay) {
                    overlay.classList.remove('open');
                    if (!document.querySelector('.legal-modal-overlay.open')) {
                        document.body.style.overflow = '';
                    }
                }
            });
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
                    navbar.style.transform = delta > 0 ? 'translateY(-100%)' : 'translateY(0)';
                    if (delta > 0) closeMobileNav();
                    lastScrollY = currentScrollY;
                }
                ticking = false;
            }
            window.addEventListener('scroll', function () {
                if (!ticking) { window.requestAnimationFrame(handleScroll); ticking = true; }
            }, { passive: true });
        })();

        document.addEventListener('DOMContentLoaded', function () {
            if (typeof gsap === 'undefined') return;
            gsap.registerPlugin(ScrollTrigger);
            const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

            gsap.timeline({ defaults: { ease: 'power3.out' } })
                .from('.eyebrow', { opacity: 0, y: 14, duration: .55 })
                .from('.contact-heading', { opacity: 0, y: 24, duration: .75 }, '-=.3')
                .from('.contact-lede', { opacity: 0, y: 18, duration: .65 }, '-=.45')
                .from('[data-nav-el]', { opacity: 0, y: -10, duration: .5, stagger: .1 }, '-=.9');

            if (!prefersReduced) {
                gsap.utils.toArray('.reveal-up').forEach((el) => {
                    gsap.to(el, { opacity: 1, y: 0, duration: .7, ease: 'power3.out',
                        scrollTrigger: { trigger: el, start: 'top 88%', once: true } });
                });
            } else {
                gsap.set('.reveal-up', { clearProps: 'opacity,transform' });
            }
        });
    </script>
</body>
</html>