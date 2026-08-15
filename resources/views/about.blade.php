<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>About | NSential</title>

     <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='80'>🖊️</text></svg>">

    <meta
    name="description"
    content="Why NSential exists — expert insights across 8 niches including AI, Finance, Health, Career, Tech Reviews, Digital Marketing, Affiliate Products, and global local information."    >

    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="About | NSential">
<meta property="og:description"
      content="Why NSential exists — expert insights across 8 niches including AI, Finance, Health, Career, Tech Reviews, Digital Marketing, Affiliate Products, and global local information.">

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

        a:focus-visible, button:focus-visible, input:focus-visible, textarea:focus-visible{
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
        .transition-colors{transition-property:color,background-color,border-color;transition-duration:0.15s}

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

        /* ================= ABOUT HERO ================= */
        .about-hero{
            position:relative; overflow:hidden;
            background:
                radial-gradient(60% 50% at 15% 5%, rgba(124,58,237,.32), transparent 70%),
                radial-gradient(50% 45% at 90% 10%, rgba(34,211,238,.2), transparent 70%),
                var(--ink);
            padding: 7.5rem 1.5rem 5rem;
        }
        .about-hero-inner{ max-width:52rem; margin:0 auto; position:relative; z-index:2; }
        .eyebrow{
            font-family:'JetBrains Mono',monospace; font-size:.72rem; letter-spacing:.2em;
            text-transform:uppercase; color:var(--cyan); display:inline-flex; align-items:center; gap:.5rem;
            margin-bottom:1.25rem;
        }
        .eyebrow::before{ content:''; width:.4rem; height:.4rem; border-radius:999px; background:var(--cyan); box-shadow:0 0 10px var(--cyan); }
        .about-heading{
            font-weight:700; line-height:1.06; letter-spacing:-.02em;
            font-size: clamp(2.1rem, 4.6vw, 3.4rem);
            margin-bottom: 1.4rem;
        }
        .about-lede{ font-size: clamp(1rem,1.3vw,1.15rem); line-height:1.75; color:var(--mist); max-width:38rem; }

        /* ================= VALUES GRID ================= */
        .values-section{ max-width:72rem; margin:0 auto; padding: 1rem 1.5rem 5rem; }
        .values-grid{ display:grid; grid-template-columns:1fr; gap:1rem; }
        @media(min-width:768px){ .values-grid{ grid-template-columns:repeat(3,1fr); } }
        .value-card{
            border-radius:1.1rem; padding:1.6rem 1.5rem;
            transition: transform .3s ease, border-color .3s ease, box-shadow .3s ease;
        }
        .value-card:hover{ transform:translateY(-4px); border-color:rgba(255,255,255,.22); box-shadow:0 20px 45px rgba(3,4,20,.45); }
        .value-icon{
            width:2.75rem; height:2.75rem; border-radius:.85rem;
            display:flex; align-items:center; justify-content:center;
            background: linear-gradient(155deg, rgba(124,58,237,.28), rgba(34,211,238,.18));
            border:1px solid rgba(255,255,255,.14);
            color: var(--cyan); font-size:1.05rem; margin-bottom:1rem;
        }
        .value-card h2{ font-size:1.05rem; margin-bottom:.55rem; }
        .value-card p{ font-size:.88rem; color:var(--mist); line-height:1.6; }

        /* ================= SIGNATURE: COMMIT-LOG TIMELINE ================= */
        .log-section{ max-width:52rem; margin:0 auto; padding: 1rem 1.5rem 5rem; }
        .section-heading{ display:flex; align-items:center; gap:1rem; margin-bottom:2rem; }
        .section-chip{
            flex-shrink:0; width:2.75rem; height:2.75rem; border-radius:.9rem;
            display:flex; align-items:center; justify-content:center; font-size:1.05rem;
            background: linear-gradient(155deg, rgba(124,58,237,.28), rgba(34,211,238,.18));
            border:1px solid rgba(255,255,255,.14); color: var(--cyan);
            box-shadow: 0 10px 24px rgba(124,58,237,.2);
        }
        .section-title{ font-weight:700; font-size:1.5rem; color:var(--paper); line-height:1.2; }
        .section-sub{ font-family:'JetBrains Mono',monospace; font-size:.7rem; letter-spacing:.2em; text-transform:uppercase; color:var(--cyan); }

        .commit-log{ position:relative; padding-left:2.1rem; }
        .commit-log::before{
            content:''; position:absolute; left:.6rem; top:.5rem; bottom:.5rem; width:2px;
            background: linear-gradient(180deg, rgba(124,58,237,.6), rgba(34,211,238,.4));
        }
        .commit{ position:relative; padding-bottom:2.1rem; }
        .commit:last-child{ padding-bottom:0; }
        .commit::before{
            content:''; position:absolute; left:-2.1rem; top:.3rem;
            width:.85rem; height:.85rem; border-radius:999px;
            background: var(--ink); border:2px solid var(--cyan);
            box-shadow: 0 0 0 4px rgba(34,211,238,.12);
        }
        .commit-hash{
            font-family:'JetBrains Mono',monospace; font-size:.72rem; color:var(--cyan);
            background: rgba(34,211,238,.1); border:1px solid rgba(34,211,238,.25);
            padding:.15rem .5rem; border-radius:.4rem; display:inline-block; margin-bottom:.5rem;
        }
        .commit h3{ font-size:1.02rem; margin-bottom:.35rem; }
        .commit p{ font-size:.86rem; color:var(--mist); line-height:1.6; }
        .commit-date{ font-size:.72rem; color:var(--mist); font-family:'JetBrains Mono',monospace; margin-left:.6rem; }

        /* ================= TEAM ================= */
        .team-section{ max-width:72rem; margin:0 auto; padding: 1rem 1.5rem 5rem; }
        .team-grid{ display:grid; grid-template-columns:1fr; gap:1rem; }
        @media(min-width:640px){ .team-grid{ grid-template-columns:repeat(2,1fr); } }
        @media(min-width:1024px){ .team-grid{ grid-template-columns:repeat(3,1fr); } }
        .team-card{
            border-radius:1.1rem; padding:1.5rem; text-align:left;
            display:flex; align-items:center; gap:1rem;
            transition: transform .3s ease, border-color .3s ease, box-shadow .3s ease;
        }
        .team-card:hover{ transform:translateY(-4px); border-color:rgba(255,255,255,.22); box-shadow:0 20px 45px rgba(3,4,20,.45); }
        .team-avatar{
            flex-shrink:0; width:3.2rem; height:3.2rem; border-radius:999px;
            display:flex; align-items:center; justify-content:center;
            font-family:'Space Grotesk',sans-serif; font-weight:700; font-size:1.1rem; color:#0a0a12;
        }
        .team-name{ font-weight:600; font-size:.98rem; color:var(--paper); }
        .team-role{ font-size:.78rem; color:var(--cyan); font-family:'JetBrains Mono',monospace; margin-top:.2rem; }

        /* ================= CTA STRIP ================= */
        .cta-strip{ max-width:72rem; margin:0 auto 6rem; padding: 0 1.5rem; }
        .cta-card{
            border-radius:1.4rem; padding: 2.75rem 2rem; text-align:center;
            background:
                radial-gradient(60% 90% at 20% 0%, rgba(124,58,237,.28), transparent 70%),
                radial-gradient(50% 80% at 90% 100%, rgba(34,211,238,.2), transparent 70%);
        }
        .cta-card h2{ font-size:clamp(1.4rem,2.6vw,1.9rem); margin-bottom:.75rem; }
        .cta-card p{ color:var(--mist); max-width:32rem; margin:0 auto 1.75rem; line-height:1.65; }
        .cta-btns{ display:flex; flex-wrap:wrap; gap:.85rem; justify-content:center; }
        .btn-primary{
            font-weight:600; font-size:.95rem; color:#0a0a12;
            background:linear-gradient(100deg,#e9d5ff,#a5f3fc);
            padding:.85rem 1.6rem; border-radius:999px;
            box-shadow: 0 8px 30px rgba(124,58,237,.35);
            display:inline-flex; align-items:center; gap:.5rem; text-decoration:none;
            transition: transform .25s ease, box-shadow .25s ease;
        }
        .btn-primary:hover{ transform:translateY(-2px); box-shadow:0 12px 36px rgba(124,58,237,.5); }
        .btn-secondary{
            font-weight:600; font-size:.95rem; color: var(--paper);
            padding:.85rem 1.5rem; border-radius:999px;
            border:1px solid rgba(255,255,255,.18); background: rgba(255,255,255,.04);
            text-decoration:none; transition: border-color .25s ease, background .25s ease, transform .25s ease;
        }
        .btn-secondary:hover{ border-color:rgba(255,255,255,.4); background:rgba(255,255,255,.08); transform:translateY(-2px); }

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
        .legal-modal-body h3{
            font-family:'Space Grotesk',sans-serif; font-size:.92rem; color:var(--paper);
            margin: 1.35rem 0 .5rem;
        }
        .legal-modal-body h3:first-of-type{ margin-top:0; }
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
            .about-hero{ padding: 6rem 1.25rem 3.5rem; }
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
                    <a href="{{ route('about') }}" class="nav-link active">About</a>
                    <a href="{{ route('contact') }}" class="nav-link">Contact</a>
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
                <a href="{{ route('about') }}" class="nav-link active" role="menuitem" onclick="closeMobileNav()">About</a>
                <a href="{{ route('contact') }}" class="nav-link" role="menuitem" onclick="closeMobileNav()">Contact</a>
            </div>
        </div>
    </nav>

    <div class="h-16"></div>

    {{-- ============================= ABOUT HERO ============================= --}}
    <section class="about-hero">
        <div class="about-hero-inner" id="aboutHeroContent">
            <span class="eyebrow">About NSential</span>
            <h1 class="about-heading">
                Expert insights across<br>
                <span class="grad-text">8 powerful niches.</span>
            </h1>
            <p class="about-lede">
                NSential is a multi-niche blog where industry experts share practical, actionable knowledge. From Artificial Intelligence to Health & Fitness, Finance to Digital Marketing — we bring you real-world concepts, proven strategies, and honest advice from professionals who live and breathe their fields. No fluff, just value.
            </p>
        </div>
    </section>

    <div class="page-content">

        {{-- ============================= VALUES ============================= --}}
        <section class="values-section">
            <div class="values-grid">
<div class="glass value-card reveal-item">
    <div class="value-icon"><i class="fas fa-users"></i></div>
    <h2>Experts in every niche</h2> 
    <p>Every article is written by someone with real experience...</p>
</div>
                <div class="glass value-card reveal-item">
                    <div class="value-icon"><i class="fas fa-lightbulb"></i></div>
                    <h2>Practical, not theoretical</h2>
                    <p>We skip the fluff. Every piece delivers actionable concepts you can apply today — whether it's AI, finance, health, or career growth.</p>
                </div>
                <div class="glass value-card reveal-item">
                    <div class="value-icon"><i class="fas fa-globe"></i></div>
                    <h2>Diverse perspectives</h2>
                    <p>From tech reviews to local global insights, we cover what matters. Our diverse team ensures every niche gets the depth it deserves.</p>
                </div>
            </div>
        </section>

        {{-- ============================= SIGNATURE: COMMIT LOG ============================= --}}
        <section class="log-section">
            <div class="section-heading">
                <span class="section-chip"><i class="fas fa-code-branch"></i></span>
                <div>
                    <span class="section-sub">Our Journey</span>
                    <h2 class="section-title">Building NSential</h2>
                </div>
            </div>

            <div class="commit-log">
                <div class="commit reveal-item">
                    <span class="commit-hash">v1.0</span><span class="commit-date">2021</span>
                    <h3>The vision took shape</h3>
                    <p>Started as a small blog with a big idea — to create a platform where experts across multiple domains could share practical knowledge.</p>
                </div>
                <div class="commit reveal-item">
                    <span class="commit-hash">v2.0</span><span class="commit-date">2022</span>
                    <h3>Expanded to 8 niches</h3>
                    <p>Grew beyond tech to cover AI, Finance, Health, Career, Digital Marketing, Tech Reviews, Affiliate Products, and Global Local Information.</p>
                </div>
                <div class="commit reveal-item">
                    <span class="commit-hash">v3.0</span><span class="commit-date">2023</span>
                    <h3>Welcomed niche experts</h3>
                    <p>Brought on specialized writers — finance analysts, fitness coaches, AI researchers, and marketing strategists who know their fields inside out.</p>
                </div>
                <div class="commit reveal-item">
                    <span class="commit-hash">v4.0</span><span class="commit-date">2024</span>
                    <h3>Added community reviews</h3>
                    <p>Launched reader ratings and feedback to ensure every article meets our quality bar and serves real-world needs.</p>
                </div>
                <div class="commit reveal-item">
                    <span class="commit-hash">HEAD</span><span class="commit-date">Today</span>
                    <h3>Still growing strong</h3>
                    <p>New expert articles weekly. Every piece is reviewed by someone who's actually applied the concepts in their professional life.</p>
                </div>
            </div>
        </section>

        {{-- ============================= TEAM ============================= --}}
        <section class="team-section">
            <div class="section-heading">
                <span class="section-chip"><i class="fas fa-user-group"></i></span>
                <div>
                    <span class="section-sub">Our Experts</span>
                    <h2 class="section-title">Who Writes This</h2>
                </div>
            </div>
            <div class="team-grid">
                <div class="glass team-card reveal-item">
                    <span class="team-avatar" style="background:linear-gradient(135deg,#7c3aed,#a78bfa)">A</span>
                    <div>
                        <div class="team-name">Dr. Aisha Khan</div>
                        <div class="team-role">AI &amp; Technology Expert</div>
                    </div>
                </div>
                <div class="glass team-card reveal-item">
                    <span class="team-avatar" style="background:linear-gradient(135deg,#2563eb,#60a5fa)">R</span>
                    <div>
                        <div class="team-name">Rahul Sharma</div>
                        <div class="team-role">Finance &amp; Online Earning</div>
                    </div>
                </div>
                <div class="glass team-card reveal-item">
                    <span class="team-avatar" style="background:linear-gradient(135deg,#0891b2,#22d3ee)">S</span>
                    <div>
                        <div class="team-name">Sarah Thompson</div>
                        <div class="team-role">Health &amp; Fitness Specialist</div>
                    </div>
                </div>
                <div class="glass team-card reveal-item">
                    <span class="team-avatar" style="background:linear-gradient(135deg,#059669,#34d399)">M</span>
                    <div>
                        <div class="team-name">Michael Chen</div>
                        <div class="team-role">Education &amp; Career Coach</div>
                    </div>
                </div>
                <div class="glass team-card reveal-item">
                    <span class="team-avatar" style="background:linear-gradient(135deg,#dc2626,#f87171)">J</span>
                    <div>
                        <div class="team-name">Jessica Rodriguez</div>
                        <div class="team-role">Digital Marketing &amp; SEO</div>
                    </div>
                </div>
                <div class="glass team-card reveal-item">
                    <span class="team-avatar" style="background:linear-gradient(135deg,#d97706,#fbbf24)">D</span>
                    <div>
                        <div class="team-name">David Patel</div>
                        <div class="team-role">Product &amp; Tech Reviews</div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ============================= CTA ============================= --}}
        <section class="cta-strip">
            <div class="glass cta-card reveal-up">
                <h2>Want to contribute or suggest a topic?</h2>
                <p>We're always looking for expert voices and fresh perspectives. Share your idea or feedback — we'd love to hear from you.</p>
                <div class="cta-btns">
                    <a href="{{ route('contact') }}" class="btn-primary">
                        Get in Touch
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M13 5l7 7-7 7"/></svg>
                    </a>
                    <a href="{{ route('home') }}#postsGrid" class="btn-secondary">Browse Articles</a>
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

                <h3>Information We Collect</h3>
                <p>When you create an account, subscribe to updates, or leave a review, we store the details you provide — such as your name, email address, and any content you submit. We also collect basic usage data like pages viewed and articles read, which helps us understand what content resonates with readers.</p>

                <h3>How We Use Your Data</h3>
                <ul>
                    <li>To create and maintain your account</li>
                    <li>To send you new articles and updates, only if you've subscribed</li>
                    <li>To display your reviews and comments alongside the posts they relate to</li>
                    <li>To improve the site based on aggregated, anonymized reading patterns</li>
                </ul>

                <h3>Cookies</h3>
                <p>We use a small number of cookies to keep you signed in and to remember your preferences, such as your last-viewed category filter. We don't use cookies for third-party advertising.</p>

                <h3>Your Rights</h3>
                <p>You can request a copy of your data, ask us to correct inaccuracies, or delete your account at any time by contacting us through the Contact page. Unsubscribing from emails takes effect immediately.</p>

                <h3>Contact</h3>
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

                <h3>Acceptance of Terms</h3>
                <p>By creating an account or using this site, you agree to these terms. If you don't agree with any part of them, please don't use the site.</p>

                <h3>User Accounts</h3>
                <p>You're responsible for keeping your login credentials secure and for any activity that happens under your account. Let us know right away if you suspect unauthorized access.</p>

                <h3>Content Ownership</h3>
                <ul>
                    <li>Articles and site design remain the property of NSential</li>
                    <li>Reviews and comments you submit remain yours, but you grant us permission to display them alongside the related post</li>
                    <li>You may not republish full articles elsewhere without permission</li>
                </ul>

                <h3>Prohibited Uses</h3>
                <p>Please don't use the site to post spam, harassing content, or anything unlawful. We reserve the right to remove content or suspend accounts that violate these terms.</p>

                <h3>Termination</h3>
                <p>You may delete your account at any time. We may suspend accounts that repeatedly violate these terms after a warning.</p>

                <h3>Governing Law</h3>
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
        window.addEventListener('resize', function () {
            if (window.innerWidth >= 768) closeMobileNav();
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
                .from('.about-heading', { opacity: 0, y: 24, duration: .75 }, '-=.3')
                .from('.about-lede', { opacity: 0, y: 18, duration: .65 }, '-=.45')
                .from('[data-nav-el]', { opacity: 0, y: -10, duration: .5, stagger: .1 }, '-=.9');

            if (!prefersReduced) {
                gsap.utils.toArray('.reveal-up').forEach((el) => {
                    gsap.to(el, { opacity: 1, y: 0, duration: .7, ease: 'power3.out',
                        scrollTrigger: { trigger: el, start: 'top 88%', once: true } });
                });
                ScrollTrigger.batch('.reveal-item', {
                    start: 'top 90%', once: true,
                    onEnter: (els) => gsap.to(els, { opacity: 1, y: 0, duration: .6, stagger: .08, ease: 'power3.out' }),
                });
            } else {
                gsap.set('.reveal-up, .reveal-item', { clearProps: 'opacity,transform' });
            }
        });
    </script>
</body>
</html>