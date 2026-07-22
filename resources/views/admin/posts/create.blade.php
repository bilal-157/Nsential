<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>New Post — Admin</title>
<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: { extend: {
      fontFamily: { serif: ['"Fraunces"', 'serif'], sans: ['"Inter"', 'sans-serif'] },
      colors: {
        cream:'#FBEFEF', blush:'#FFE2E2', rose:'#F5CBCB', lilac:'#C5B3D3', plum:'#5B3A5F',
      }
    }}
  }
</script>
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,600;9..144,800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
  body { font-family:'Inter', sans-serif; }
  .font-display { font-family:'Fraunces', serif; letter-spacing:-0.02em; }
</style>
</head>
<body class="bg-cream text-plum antialiased min-h-screen">

<header class="sticky top-0 bg-cream/90 backdrop-blur border-b border-rose/60">
  <nav class="max-w-3xl mx-auto px-5 sm:px-8 h-16 flex items-center justify-between">
    <a href="/admin/posts" class="font-display text-lg font-semibold">← Back to Posts</a>
  </nav>
</header>

<main class="max-w-3xl mx-auto px-5 sm:px-8 py-10">
  <h1 class="font-display text-2xl sm:text-3xl font-semibold mb-8">New Post</h1>

  @if ($errors->any())
    <div class="mb-6 px-4 py-3 rounded-xl bg-rose/50 text-plum text-sm">
      <ul class="list-disc list-inside space-y-1">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="/admin/posts" class="space-y-5">
    @csrf

    <div>
      <label class="block text-sm font-medium mb-1.5">Title</label>
      <input type="text" name="title" value="{{ old('title') }}"
        class="w-full px-4 py-2.5 rounded-xl bg-blush/50 border border-rose/60 outline-none focus:border-lilac transition" />
    </div>

    <div>
      <label class="block text-sm font-medium mb-1.5">Content</label>
      <textarea name="content" rows="10"
        class="w-full px-4 py-2.5 rounded-xl bg-blush/50 border border-rose/60 outline-none focus:border-lilac transition">{{ old('content') }}</textarea>
    </div>

    <button type="submit" class="px-6 py-3 rounded-full bg-plum text-cream text-sm font-semibold hover:brightness-105 transition">
      Create Post
    </button>
  </form>
</main>

</body>
</html>