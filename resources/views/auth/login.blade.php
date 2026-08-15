<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in</title>
    
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='80'>🖊️</text></svg>">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600&family=Inter:wght@400;500;600&family=IBM+Plex+Mono:wght@500&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
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
                    },
                    fontFamily: {
                        display: ['Fraunces', 'serif'],
                        sans: ['Inter', 'sans-serif'],
                        mono: ['IBM Plex Mono', 'monospace'],
                    },
                }
            }
        }
    </script>
</head>
<body class="bg-void font-sans">
    <div class="min-h-screen grid lg:grid-cols-2">

        <!-- Left panel: brand -->
        <div class="hidden lg:flex flex-col justify-between bg-panel text-ivory px-14 py-12 relative overflow-hidden">
            <div class="absolute inset-0 opacity-[0.08]"
                 style="background-image: repeating-linear-gradient(0deg, #9C8CFF 0px, #9C8CFF 1px, transparent 1px, transparent 32px), repeating-linear-gradient(90deg, #9C8CFF 0px, #9C8CFF 1px, transparent 1px, transparent 32px);">
            </div>
            <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full opacity-20 blur-3xl" style="background: radial-gradient(circle, #3FD8E0, transparent 70%);"></div>
            <div class="absolute -bottom-32 -left-16 w-96 h-96 rounded-full opacity-20 blur-3xl" style="background: radial-gradient(circle, #F17BC4, transparent 70%);"></div>

            <div class="relative z-10">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full border border-cyan flex items-center justify-center">
                        <div class="w-2 h-2 rounded-full bg-cyan"></div>
                    </div>
                    <span class="font-mono text-xs tracking-[0.25em] uppercase text-cyan">Access</span>
                </div>
            </div>

            <div class="relative z-10 max-w-sm">
                <p class="font-display text-4xl leading-tight text-ivory">
                    Welcome back.<br>Your work is right where you left it.
                </p>
                <p class="mt-6 text-sm text-mist leading-relaxed">
                    Sign in with the credentials tied to your account, or continue with a connected provider.
                </p>
            </div>

            <div class="relative z-10 flex items-center gap-3 text-xs text-mist font-mono">
                <span class="w-6 border-t border-hairline"></span>
                <span>secure session</span>
            </div>
        </div>

        <!-- Right panel: form -->
        <div class="flex items-center justify-center px-6 py-16 sm:px-10 bg-void">
            <div class="w-full max-w-sm">

                <div class="lg:hidden flex items-center gap-3 mb-10">
                    <div class="w-8 h-8 rounded-full border border-violet flex items-center justify-center">
                        <div class="w-2 h-2 rounded-full bg-violet"></div>
                    </div>
                    <span class="font-mono text-xs tracking-[0.25em] uppercase text-violet">Access</span>
                </div>

                <h1 class="font-display text-3xl text-ivory">Sign in</h1>
                <p class="mt-2 text-sm text-mist">
                    New here?
                    <a href="/register" class="text-cyan font-medium hover:text-violet underline underline-offset-2">Create an account</a>
                </p>

                @if(session('error'))
                <div class="mt-6 bg-pink/10 border border-pink/30 text-pink text-sm px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
                @endif

                @if(session('success'))
                <div class="mt-6 bg-cyan/10 border border-cyan/30 text-cyan text-sm px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
                @endif

                <form class="mt-8 space-y-5" method="POST" action="/login">
                    @csrf

                    <div>
                        <label for="email" class="block font-mono text-[11px] tracking-[0.15em] uppercase text-mist mb-2">
                            Email address
                        </label>
                        <input id="email" name="email" type="email" required autofocus
                            value="{{ old('email') }}"
                            placeholder="name@company.com"
                            class="w-full px-4 py-2.5 bg-card border border-hairline rounded-md text-ivory placeholder-mist/50 focus:outline-none focus:ring-2 focus:ring-cyan/40 focus:border-cyan transition-colors">
                        @error('email')
                        <p class="mt-1.5 text-xs text-pink">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label for="password" class="block font-mono text-[11px] tracking-[0.15em] uppercase text-mist">
                                Password
                            </label>
                            <a href="/forgot-password" class="text-xs text-cyan hover:text-violet">Forgot password?</a>
                        </div>
                        <input id="password" name="password" type="password" required
                            placeholder="••••••••"
                            class="w-full px-4 py-2.5 bg-card border border-hairline rounded-md text-ivory placeholder-mist/50 focus:outline-none focus:ring-2 focus:ring-cyan/40 focus:border-cyan transition-colors">
                        @error('password')
                        <p class="mt-1.5 text-xs text-pink">{{ $message }}</p>
                        @enderror
                    </div>

                    <label class="flex items-center gap-2.5 pt-1">
                        <input id="remember_me" name="remember" type="checkbox"
                            class="h-4 w-4 rounded border-hairline bg-card text-cyan focus:ring-cyan/40">
                        <span class="text-sm text-mist">Remember me</span>
                    </label>

                    <button type="submit"
                        class="w-full py-2.5 rounded-md text-void text-sm font-semibold transition-opacity hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-void focus:ring-cyan"
                        style="background: linear-gradient(90deg, #3FD8E0, #9C8CFF);">
                        Sign in
                    </button>
                </form>

                <!-- Divider -->
                <div class="mt-8 flex items-center gap-3">
                    <span class="flex-1 border-t border-dashed border-hairline"></span>
                    <span class="text-xs font-mono uppercase tracking-wider text-mist">Or continue with</span>
                    <span class="flex-1 border-t border-dashed border-hairline"></span>
                </div>

                <div class="mt-6 grid grid-cols-2 gap-3">
                    <a href="{{ route('auth.google') }}"
                       class="inline-flex items-center justify-center gap-2 py-2.5 px-4 border border-hairline rounded-md bg-card text-sm font-medium text-ivory hover:border-cyan/50 transition-colors">
                        <svg class="w-4 h-4" viewBox="0 0 48 48">
                            <path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"/>
                            <path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"/>
                            <path fill="#4CAF50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"/>
                            <path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"/>
                        </svg>
                        Google
                    </a>
                    <button class="inline-flex items-center justify-center gap-2 py-2.5 px-4 border border-hairline rounded-md bg-card text-sm font-medium text-ivory hover:border-violet/50 transition-colors">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"/>
                        </svg>
                        GitHub
                    </button>
                </div>

            </div>
        </div>
    </div>
</body>
</html>