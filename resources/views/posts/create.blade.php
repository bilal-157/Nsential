<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Post · MyBlog</title>
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
        }

        h1, h2, h3, .display { font-family: 'Space Grotesk', 'Inter', sans-serif; }
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
            mask-image: radial-gradient(circle at 30% 0%, black, transparent 70%);
        }

        .content-wrap { position: relative; z-index: 1; }

        .grad-text {
            background: linear-gradient(90deg, var(--cyan), var(--violet));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            backdrop-filter: blur(14px);
            transition: border-color 0.25s ease, box-shadow 0.25s ease;
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
        select.field option { background: #12121e; color: #f2f3f7; }

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

        .btn-ghost {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.14);
            color: #e5e7eb;
            transition: background 0.2s ease, border-color 0.2s ease;
        }
        .btn-ghost:hover {
            background: rgba(255, 255, 255, 0.06);
            border-color: rgba(255, 255, 255, 0.24);
        }

        .back-link {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.09);
            color: #cbd5e1;
            transition: background 0.18s ease, border-color 0.18s ease, transform 0.18s ease, color 0.18s ease;
        }
        .back-link:hover {
            background: rgba(34, 211, 238, 0.08);
            border-color: rgba(34, 211, 238, 0.35);
            color: #e0fbff;
            transform: translateY(-1px);
        }

        .avatar-badge { background: linear-gradient(135deg, #818cf8, #22d3ee); }

        .drop-zone {
            background: rgba(255, 255, 255, 0.02);
            border: 2px dashed rgba(255, 255, 255, 0.14);
            transition: border-color 0.2s ease, background 0.2s ease;
        }
        .drop-zone:hover, .drop-zone.drag-active {
            border-color: rgba(34, 211, 238, 0.5);
            background: rgba(9, 11, 69, 0.05);
        }

        @keyframes rise {
            from { opacity: 0; transform: translateY(14px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .rise { animation: rise 0.6s cubic-bezier(0.16, 1, 0.3, 1) both; }
        .d1 { animation-delay: 0.02s; }
        .d2 { animation-delay: 0.08s; }
        .d3 { animation-delay: 0.14s; }

        @media (prefers-reduced-motion: reduce) {
            .rise { animation: none !important; }
            .card, .btn-primary, .btn-ghost, .field, .back-link, .drop-zone { transition: none !important; }
        }

        @media (max-width: 380px) {
            .btn-primary, .btn-ghost { width: 100%; text-align: center; }
        }
    </style>
</head>
<body>

    <div class="hero-wash"></div>

    <div class="content-wrap max-w-3xl mx-auto px-4 sm:px-6 py-8 sm:py-12">

        <!-- Back links, replaces the navbar -->
        <div class="rise d1 flex items-center gap-2 mb-8 flex-wrap">
            <a href="{{ route('profile.edit') }}" class="back-link inline-flex items-center gap-1.5 text-sm rounded-full px-4 py-2">
                <span aria-hidden="true">&larr;</span> Back to Profile
            </a>
            <a href="/" class="back-link inline-flex items-center gap-1.5 text-sm rounded-full px-4 py-2">
                <span aria-hidden="true">&larr;</span> Back to Posts
            </a>
        </div>

        <!-- Header -->
        <div class="rise d1 mb-8">
            <p class="mono-label text-xs text-cyan-300 uppercase mb-3">— New Post</p>
            <h1 class="text-3xl sm:text-4xl font-bold tracking-tight mb-2">
                Write something <span class="grad-text">worth reading.</span>
            </h1>
            <p class="text-gray-400 text-sm">Fill in the details below to publish a new blog post.</p>
        </div>

        @if ($errors->any())
        <div class="rise d2 mb-6 rounded-xl bg-rose-400/10 border border-rose-400/25 text-rose-300 text-sm px-4 py-3">
            <p class="font-semibold mb-1">Please fix the following:</p>
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Posting as (auto-filled from logged-in author's profile) -->
        <div class="rise d2 flex items-center gap-3 mb-6 p-4 card rounded-2xl">
            <div class="avatar-badge w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold text-[#0a0b14] flex-shrink-0">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div>
                <p class="mono-label text-[10px] text-gray-500 uppercase">Posting as</p>
                <p class="font-semibold text-gray-100 text-sm">{{ auth()->user()->name }}</p>
                @if(auth()->user()->bio)
                <p class="text-xs text-gray-500">{{ Str::limit(auth()->user()->bio, 100) }}</p>
                @endif
            </div>
        </div>

        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="rise d3 card rounded-2xl p-5 sm:p-6 space-y-6">
            @csrf

            <!-- Title -->
            <div>
                <label for="title" class="mono-label block text-xs text-gray-400 uppercase mb-2">Title</label>
                <input
                    type="text"
                    name="title"
                    id="title"
                    value="{{ old('title') }}"
                    class="field w-full rounded-lg px-3 py-2.5 text-sm text-gray-100 placeholder-gray-500"
                    placeholder="Enter post title"
                    required
                >
            </div>

            <!-- Category -->
            <div>
                <label for="category_id" class="mono-label block text-xs text-gray-400 uppercase mb-2">Category</label>
                <select
                    name="category_id"
                    id="category_id"
                    class="field w-full rounded-lg px-3 py-2.5 text-sm text-gray-100"
                    required
                >
                    <option value="" disabled selected>Select a category</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" @if((int) old('category_id') === $category->id) selected @endif>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Content -->
            <div>
                <label for="content" class="mono-label block text-xs text-gray-400 uppercase mb-2">Content</label>
                <textarea
                    name="content"
                    id="content"
                    rows="8"
                    class="field w-full rounded-lg px-3 py-2.5 text-sm text-gray-100 placeholder-gray-500 resize-none"
                    placeholder="Write your post content here..."
                    required
                >{{ old('content') }}</textarea>
            </div>

            <!-- Status + Publish Date -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="status" class="mono-label block text-xs text-gray-400 uppercase mb-2">Status</label>
                    <select
                        name="status"
                        id="status"
                        class="field w-full rounded-lg px-3 py-2.5 text-sm text-gray-100"
                    >
                        <option value="draft" @if(old('status') === 'draft') selected @endif>Draft</option>
                        <option value="published" @if(old('status') === 'published') selected @endif>Published</option>
                    </select>
                </div>

                <div>
                    <label for="published_at" class="mono-label block text-xs text-gray-400 uppercase mb-2">Publish Date</label>
                    <input
                        type="datetime-local"
                        name="published_at"
                        id="published_at"
                        value="{{ old('published_at') }}"
                        class="field w-full rounded-lg px-3 py-2.5 text-sm text-gray-100 [color-scheme:dark]"
                    >
                    <p class="text-xs text-gray-500 mt-2">Leave blank to keep as draft with no date.</p>
                </div>
            </div>

            <!-- Featured Image Upload -->
            <div>
                <label for="featured_image" class="mono-label block text-xs text-gray-400 uppercase mb-2">Featured Image</label>

                <div
                    id="drop-zone"
                    class="drop-zone relative flex flex-col items-center justify-center w-full rounded-xl px-4 py-8 text-center cursor-pointer"
                    onclick="document.getElementById('featured_image').click()"
                >
                    <input
                        type="file"
                        name="featured_image"
                        id="featured_image"
                        accept="image/png, image/jpeg, image/jpg, image/webp"
                        class="hidden"
                        onchange="handleImagePreview(event)"
                    >

                    <div id="upload-placeholder">
                        <svg class="w-10 h-10 mx-auto text-gray-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                        <p class="text-sm text-gray-300">
                            <span class="text-cyan-300 font-medium">Click to upload</span> or drag and drop
                        </p>
                        <p class="text-xs text-gray-500 mt-1">PNG, JPG or WEBP (max 4MB)</p>
                    </div>

                    <div id="image-preview-wrapper" class="hidden w-full">
                        <img id="image-preview" src="" alt="Preview" class="mx-auto max-h-48 rounded-lg object-cover shadow-sm">
                        <p id="image-filename" class="text-xs text-gray-500 mt-2 truncate"></p>
                        <button
                            type="button"
                            onclick="event.stopPropagation(); removeImage()"
                            class="mt-2 text-xs font-medium text-rose-400 hover:text-rose-300"
                        >
                            Remove image
                        </button>
                    </div>
                </div>

                <p class="text-xs text-gray-500 mt-2">Upload an image from your device to use as the featured image.</p>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-white/8 flex-wrap">
                <a href="/" class="btn-ghost text-sm px-6 py-2.5 rounded-full transition-colors">
                    Cancel
                </a>
                <button
                    type="submit"
                    class="btn-primary text-sm px-6 py-2.5 rounded-full"
                >
                    Publish Post
                </button>
            </div>
        </form>
    </div>

    <script>
        const dropZone = document.getElementById('drop-zone');
        const fileInput = document.getElementById('featured_image');

        function handleImagePreview(event) {
            const file = event.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('image-preview').src = e.target.result;
                document.getElementById('image-filename').textContent = file.name;
                document.getElementById('upload-placeholder').classList.add('hidden');
                document.getElementById('image-preview-wrapper').classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }

        function removeImage() {
            fileInput.value = '';
            document.getElementById('image-preview').src = '';
            document.getElementById('image-filename').textContent = '';
            document.getElementById('upload-placeholder').classList.remove('hidden');
            document.getElementById('image-preview-wrapper').classList.add('hidden');
        }

        // Drag & drop support
        ['dragenter', 'dragover'].forEach(evt => {
            dropZone.addEventListener(evt, (e) => {
                e.preventDefault();
                e.stopPropagation();
                dropZone.classList.add('drag-active');
            });
        });

        ['dragleave', 'drop'].forEach(evt => {
            dropZone.addEventListener(evt, (e) => {
                e.preventDefault();
                e.stopPropagation();
                dropZone.classList.remove('drag-active');
            });
        });

        dropZone.addEventListener('drop', (e) => {
            const file = e.dataTransfer.files[0];
            if (file) {
                fileInput.files = e.dataTransfer.files;
                handleImagePreview({ target: { files: [file] } });
            }
        });
    </script>

</body>
</html>