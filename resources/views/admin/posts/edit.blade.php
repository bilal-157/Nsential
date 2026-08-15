@extends('admin.layout')
@section('title', isset($post) ? 'Edit Post' : 'New Post')
@section('content')

<div class="flex items-start justify-between mb-8 gap-4 flex-wrap">
    <div>
        <div class="flex items-center gap-3">
            <h1 class="text-2xl sm:text-3xl font-bold text-ivory">
                {{ isset($post) ? 'Edit Post' : 'Create New Post' }}
            </h1>
            <span class="text-xs text-mist bg-card border border-hairline px-2 py-0.5 rounded-full">
                {{ isset($post) ? 'Editing' : 'Creating' }}
            </span>
        </div>
        <p class="text-mist text-sm mt-1">
            {{ isset($post) ? 'Update your post content and settings.' : 'Fill in the details to publish a new post.' }}
        </p>
    </div>
    @if(isset($post) && $post->status === 'published')
        <a href="{{ route('posts.show', $post->slug) }}" target="_blank"
           class="px-4 py-2 rounded-full bg-card border border-hairline text-cyan text-sm font-medium hover:border-cyan/40 transition-colors">
            View Post →
        </a>
    @endif
</div>

@if ($errors->any())
    <div class="mb-6 px-5 py-4 rounded-lg bg-pink/10 border border-pink/20 text-pink">
        <p class="font-semibold text-sm mb-2">Please fix the following errors:</p>
        <ul class="list-disc list-inside space-y-1 text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session('success'))
    <div class="mb-6 px-5 py-4 rounded-lg bg-cyan/10 border border-cyan/20 text-cyan">
        <p class="text-sm font-medium">{{ session('success') }}</p>
    </div>
@endif

<form method="POST" action="{{ isset($post) ? route('admin.posts.update', $post) : route('admin.posts.store') }}"
      enctype="multipart/form-data" class="space-y-6 bg-panel p-6 sm:p-8 rounded-lg border border-hairline max-w-3xl">
    @csrf
    @if(isset($post)) @method('PUT') @endif

    <!-- Title -->
    <div>
        <label class="block text-sm font-medium mb-1.5 text-mist">Title <span class="text-pink">*</span></label>
        <input type="text" name="title" value="{{ old('title', $post->title ?? '') }}"
               class="w-full px-4 py-2.5 rounded-md bg-card border border-hairline text-ivory placeholder-mist/40 outline-none focus:border-cyan focus:ring-2 focus:ring-cyan/20 transition"
               placeholder="Enter post title" required />
        <p class="text-xs text-mist/70 mt-1.5">Slug will be auto-generated from the title.</p>
    </div>

    <!-- Category -->
    <div>
        <label class="block text-sm font-medium mb-1.5 text-mist">Category <span class="text-pink">*</span></label>
        <select name="category_id"
                class="w-full px-4 py-2.5 rounded-md bg-card border border-hairline text-ivory outline-none focus:border-cyan focus:ring-2 focus:ring-cyan/20 transition"
                required>
            <option value="" disabled @selected(!isset($post))>Select a category</option>
            @foreach($categories as $category)
            <option value="{{ $category->id }}" @selected(old('category_id', $post->category_id ?? null) == $category->id)>
                {{ $category->name }}
            </option>
            @endforeach
        </select>
    </div>

    <!-- Content -->
    <div>
        <label class="block text-sm font-medium mb-1.5 text-mist">Content <span class="text-pink">*</span></label>
        <textarea name="content" rows="10"
                  class="w-full px-4 py-2.5 rounded-md bg-card border border-hairline text-ivory placeholder-mist/40 outline-none focus:border-cyan focus:ring-2 focus:ring-cyan/20 transition resize-y"
                  placeholder="Write your post content here..." required>{{ old('content', $post->content ?? '') }}</textarea>
        <div class="flex justify-between items-center mt-1.5 flex-wrap gap-1">
            <p class="text-xs text-mist/70">Supports HTML formatting. Use proper paragraphs for better readability.</p>
            <p class="text-xs text-mist/70">
                <i class="fas fa-clock mr-1"></i> Reading time:
                <span id="readingTimePreview" class="text-cyan">{{ isset($post) ? ($post->reading_time ?? 1) : 1 }}</span> min read
            </p>
        </div>
    </div>

    <!-- Status + Publish Date -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
        <div>
            <label class="block text-sm font-medium mb-1.5 text-mist">Status</label>
            <select name="status"
                    class="w-full px-4 py-2.5 rounded-md bg-card border border-hairline text-ivory outline-none focus:border-cyan focus:ring-2 focus:ring-cyan/20 transition">
                <option value="draft" @selected(old('status', $post->status ?? 'draft') === 'draft')>📝 Draft</option>
                <option value="published" @selected(old('status', $post->status ?? '') === 'published')>🚀 Published</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1.5 text-mist">Publish Date</label>
            <input type="datetime-local" name="published_at"
                   value="{{ old('published_at', isset($post->published_at) ? $post->published_at->format('Y-m-d\TH:i') : '') }}"
                   class="w-full px-4 py-2.5 rounded-md bg-card border border-hairline text-ivory outline-none focus:border-cyan focus:ring-2 focus:ring-cyan/20 transition" />
            <p class="text-xs text-mist/70 mt-1.5">Leave blank to keep as draft with no date.</p>
        </div>
    </div>

    <!-- Featured Image - File Upload -->
    <div>
        <label class="block text-sm font-medium mb-1.5 text-mist">Featured Image</label>

        <!-- Current Image Display -->
        @if(isset($post) && $post->featured_image)
            <div class="mb-3 p-3 bg-card rounded-lg border border-hairline" id="current-image-container">
                <p class="text-xs text-mist/70 mb-2">Current Image:</p>
                <div class="relative inline-block">
                    <img src="{{ $post->featured_image_url }}" alt="Current featured image"
                         class="w-32 h-32 object-cover rounded-lg border-2 border-hairline" />
                    <button type="button" onclick="removeCurrentImage()"
                            class="absolute -top-2 -right-2 bg-pink text-void rounded-full w-6 h-6 flex items-center justify-center text-xs hover:opacity-80 transition shadow-md font-bold">
                        ×
                    </button>
                </div>
                <input type="hidden" name="remove_image" id="remove_image" value="0" />
            </div>
        @endif

        <!-- File Upload -->
        <div class="relative border-2 border-dashed border-hairline rounded-lg p-6 text-center hover:border-cyan/50 transition bg-card">
            <input type="file" name="featured_image" id="featured_image" accept="image/*"
                   class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
            <div class="space-y-2">
                <svg class="w-10 h-10 mx-auto text-mist/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <div class="text-sm">
                    <span class="font-medium text-cyan">Click to upload</span>
                    <span class="text-mist">or drag and drop</span>
                </div>
                <p class="text-xs text-mist/70">JPG, PNG, GIF, WEBP up to 2MB</p>
            </div>
        </div>

        <!-- Image Preview Container -->
        <div id="image-preview-container" class="mt-3"></div>
    </div>

    <!-- Form Actions -->
    <div class="flex flex-wrap items-center justify-between gap-3 pt-4 border-t border-hairline">
        <div class="flex items-center gap-3 flex-wrap">
            <button type="submit"
                    class="px-6 py-2.5 rounded-full text-void text-sm font-semibold transition-opacity hover:opacity-90 shadow-md flex items-center gap-2"
                    style="background: linear-gradient(90deg, #3FD8E0, #9C8CFF);">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                {{ isset($post) ? 'Save Changes' : 'Publish Post' }}
            </button>

            @if(isset($post) && $post->status === 'draft')
                <button type="submit" name="status" value="published"
                        class="px-6 py-2.5 rounded-full bg-cyan/10 border border-cyan/30 text-cyan text-sm font-semibold hover:bg-cyan/20 transition">
                    Publish Now
                </button>
            @endif
        </div>

        <a href="{{ route('admin.posts.index') }}"
           class="px-4 py-2 rounded-full border border-hairline text-mist text-sm font-medium hover:bg-card hover:text-ivory transition-colors">
            Cancel
        </a>
    </div>
</form>

<style>
    .spinner {
        border: 3px solid rgba(244, 242, 250, 0.15);
        border-top: 3px solid #F4F2FA;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        animation: spin 1s linear infinite;
    }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    .image-preview {
        transition: all 0.3s ease;
    }
    .image-preview:hover {
        transform: scale(1.02);
    }
</style>

<script>
// Image preview functionality
document.getElementById('featured_image').addEventListener('change', function(e) {
    const container = document.getElementById('image-preview-container');
    const file = e.target.files[0];

    if (file) {
        // Check file size (2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert('Image size must be less than 2MB. Please choose a smaller image.');
            this.value = '';
            return;
        }

        // Check file type
        const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!validTypes.includes(file.type)) {
            alert('Please upload a valid image file (JPG, PNG, GIF, or WEBP).');
            this.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            container.innerHTML = `
                <div class="relative inline-block image-preview">
                    <img src="${e.target.result}" alt="Preview"
                         class="w-40 h-40 object-cover rounded-xl border-2 border-violet shadow-md" />
                    <button type="button" onclick="removePreview()"
                            class="absolute -top-2 -right-2 bg-pink text-void rounded-full w-6 h-6 flex items-center justify-center text-xs hover:opacity-80 transition shadow-md font-bold">
                        ×
                    </button>
                </div>
            `;
        };
        reader.readAsDataURL(file);
    } else {
        container.innerHTML = '';
    }
});

function removePreview() {
    document.getElementById('featured_image').value = '';
    document.getElementById('image-preview-container').innerHTML = '';
}

function removeCurrentImage() {
    if (confirm('Remove the current featured image?')) {
        document.getElementById('remove_image').value = '1';
        const currentImage = document.getElementById('current-image-container');
        if (currentImage) {
            currentImage.style.display = 'none';
        }
    }
}

// Live reading time preview
document.querySelector('textarea[name="content"]')?.addEventListener('input', function() {
    const text = this.value;
    const words = text.replace(/<[^>]*>/g, '').split(/\s+/).filter(word => word.length > 0).length;
    const minutes = Math.max(1, Math.ceil(words / 200));
    document.getElementById('readingTimePreview').textContent = minutes;
});

// Confirm before leaving with unsaved changes
let formChanged = false;
document.querySelectorAll('input, textarea, select').forEach(element => {
    element.addEventListener('change', () => { formChanged = true; });
    element.addEventListener('input', () => { formChanged = true; });
});

window.addEventListener('beforeunload', (e) => {
    if (formChanged) {
        e.preventDefault();
        e.returnValue = 'You have unsaved changes. Are you sure you want to leave?';
    }
});

// Form submission tracking
document.querySelector('form')?.addEventListener('submit', function() {
    formChanged = false;
    // Show loading state
    const submitBtn = this.querySelector('button[type="submit"]');
    if (submitBtn) {
        submitBtn.innerHTML = `
            <div class="spinner w-4 h-4 border-2 border-void/30 border-t-void rounded-full animate-spin"></div>
            ${submitBtn.textContent}
        `;
        submitBtn.disabled = true;
    }
});
</script>

@endsection