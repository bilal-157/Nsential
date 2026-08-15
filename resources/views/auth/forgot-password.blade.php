<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password · MyBlog</title>
     <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='80'>🖊️</text></svg>">
    
    <script src="https://cdn.tailwindcss.com"></script>
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
            min-height: 100vh;
        }

        h1, .display { font-family: 'Space Grotesk', 'Inter', sans-serif; }
        .mono-label { font-family: 'JetBrains Mono', monospace; letter-spacing: 0.14em; }

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
            mask-image: radial-gradient(circle at 50% 0%, black, transparent 70%);
        }

        .content-wrap { position: relative; z-index: 1; }

        .grad-text {
            background: linear-gradient(90deg, var(--cyan), var(--violet));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .logo-badge { background: linear-gradient(135deg, var(--violet), var(--cyan)); }

        .card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            backdrop-filter: blur(14px);
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
        .field.has-error {
            border-color: rgba(244, 63, 94, 0.5);
        }
        .field.has-error:focus {
            box-shadow: 0 0 0 4px rgba(244, 63, 94, 0.12);
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

        @keyframes rise {
            from { opacity: 0; transform: translateY(14px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .rise { animation: rise 0.6s cubic-bezier(0.16, 1, 0.3, 1) both; }
        .d1 { animation-delay: 0.02s; }
        .d2 { animation-delay: 0.10s; }

        @media (prefers-reduced-motion: reduce) {
            .rise { animation: none !important; }
            .card, .btn-primary, .field { transition: none !important; }
        }
    </style>
</head>
<body>

    <div class="hero-wash"></div>

    <div class="content-wrap min-h-screen flex flex-col items-center justify-center px-4 py-10 sm:py-14">

        <!-- Logo, doubles as back-to-home -->

        <div class="rise d2 w-full max-w-md">
            <div class="text-center mb-6">
                <h1 class="text-3xl font-bold tracking-tight mb-2">
                    Reset your <span class="grad-text">password.</span>
                </h1>
                <p class="text-gray-400 text-sm leading-relaxed">
                    {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                </p>
            </div>

            <div class="card rounded-2xl p-6 sm:p-7">

                @if (session('status'))
                    <div class="mb-5 rounded-xl bg-emerald-400/10 border border-emerald-400/25 text-emerald-300 text-sm px-4 py-3 flex items-center gap-2">
                        <span aria-hidden="true">✓</span> {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="mono-label block text-xs text-gray-400 uppercase mb-2">{{ __('Email') }}</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                               class="field w-full rounded-lg px-3 py-2.5 text-sm text-gray-100 placeholder-gray-500 @error('email') has-error @enderror">
                        @error('email')
                            <p class="mt-1.5 text-xs text-rose-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-end pt-2">
                        <button type="submit" class="btn-primary text-sm px-6 py-2.5 rounded-full">
                            {{ __('Email Password Reset Link') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>