@extends('admin.layout')
@section('title', isset($post) ? 'Edit Post' : 'New Post')
@section('content')

<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-ivory">{{ isset($post) ? 'Edit Post' : 'New Post' }}</h1>

</div>

@if ($errors->any())
    <div class="mb-6 px-4 py-3 rounded-lg bg-pink/10 border border-pink/20 text-pink text-sm">
        <ul class="list-disc list-inside space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ isset($post) ? route('admin.posts.update', $post) : route('admin.posts.store') }}"
      enctype="multipart/form-data" class="bg-panel border border-hairline rounded-lg p-6 max-w-3xl space-y-5">
    @csrf
    @if(isset($post)) @method('PUT') @endif

    <div>
        <label class="block text-sm font-medium text-mist mb-1.5">Title</label>
        <input type="text" name="title" value="{{ old('title', $post->title ?? '') }}"
               class="w-full px-4 py-2.5 rounded-md bg-card border border-hairline text-ivory outline-none focus:ring-2 focus:ring-cyan/40 focus:border-cyan transition-colors" />
    </div>

    <div>
        <label class="block text-sm font-medium text-mist mb-1.5">Category</label>
        <select name="category_id"
                class="w-full px-4 py-2.5 rounded-md bg-card border border-hairline text-ivory outline-none focus:ring-2 focus:ring-cyan/40 focus:border-cyan transition-colors">
            <option value="" disabled @selected(!isset($post))>Select a category</option>
            @foreach($categories as $category)
            <option value="{{ $category->id }}" @selected(old('category_id', $post->category_id ?? null) == $category->id)>
                {{ $category->name }}
            </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium text-mist mb-1.5">Content</label>
        <textarea name="content" rows="10"
                  class="w-full px-4 py-2.5 rounded-md bg-card border border-hairline text-ivory outline-none focus:ring-2 focus:ring-cyan/40 focus:border-cyan transition-colors">{{ old('content', $post->content ?? '') }}</textarea>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
        <div>
            <label class="block text-sm font-medium text-mist mb-1.5">Status</label>
            <select name="status"
                    class="w-full px-4 py-2.5 rounded-md bg-card border border-hairline text-ivory outline-none focus:ring-2 focus:ring-cyan/40 focus:border-cyan transition-colors">
                <option value="draft" @selected(old('status', $post->status ?? 'draft') === 'draft')>Draft</option>
                <option value="published" @selected(old('status', $post->status ?? '') === 'published')>Published</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-mist mb-1.5">Publish Date</label>
            <input type="datetime-local" name="published_at"
                   value="{{ old('published_at', isset($post->published_at) ? $post->published_at->format('Y-m-d\TH:i') : '') }}"
                   class="w-full px-4 py-2.5 rounded-md bg-card border border-hairline text-ivory outline-none focus:ring-2 focus:ring-cyan/40 focus:border-cyan transition-colors" />
            <p class="text-xs text-mist/70 mt-1">Leave blank to keep as draft with no date.</p>
        </div>
    </div>

    <!-- Featured Image Upload -->
    <div>
        <label class="block text-sm font-medium text-mist mb-1.5">Featured Image</label>

        <div
            id="drop-zone"
            class="relative flex flex-col items-center justify-center w-full border-2 border-dashed border-hairline rounded-lg px-4 py-8 text-center cursor-pointer hover:border-cyan/50 hover:bg-card/50 transition-colors"
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

            <div id="upload-placeholder" class="{{ isset($post) && $post->featured_image ? 'hidden' : '' }}">
                <svg class="w-10 h-10 mx-auto text-mist/40 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                </svg>
                <p class="text-sm text-mist">
                    <span class="text-cyan font-medium underline">Click to upload</span> or drag and drop
                </p>
                <p class="text-xs text-mist/60 mt-1">PNG, JPG or WEBP (max 4MB)</p>
            </div>

            <div id="image-preview-wrapper" class="w-full {{ isset($post) && $post->featured_image ? '' : 'hidden' }}">
                <img
                    id="image-preview"
                    src="{{ isset($post) && $post->featured_image ? asset('storage/' . $post->featured_image) : '' }}"
                    alt="Preview"
                    class="mx-auto max-h-48 rounded-lg object-cover border border-hairline"
                >
                <p id="image-filename" class="text-xs text-mist mt-2 truncate">
                    {{ isset($post) && $post->featured_image ? 'Current featured image' : '' }}
                </p>
                <button
                    type="button"
                    onclick="event.stopPropagation(); removeImage()"
                    class="mt-2 text-xs font-medium text-pink hover:opacity-80"
                >
                    Remove image
                </button>
            </div>
        </div>

        <!-- Signals explicit removal to the controller when no new file is chosen -->
        <input type="hidden" name="remove_featured_image" id="remove_featured_image" value="0">

        <p class="text-xs text-mist/60 mt-1">Upload an image from your device to use as the featured image.</p>
    </div>

    <button type="submit"
            class="px-6 py-3 rounded-full text-void text-sm font-semibold transition-opacity hover:opacity-90"
            style="background: linear-gradient(90deg, #3FD8E0, #9C8CFF);">
        {{ isset($post) ? 'Save Changes' : 'Create Post' }}
    </button>
</form>

<script>
    const dropZone = document.getElementById('drop-zone');
    const fileInput = document.getElementById('featured_image');
    const removeFlag = document.getElementById('remove_featured_image');

    function handleImagePreview(event) {
        const file = event.target.files[0];
        if (!file) return;

        removeFlag.value = '0';

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
        removeFlag.value = '1';
        document.getElementById('image-preview').src = '';
        document.getElementById('image-filename').textContent = '';
        document.getElementById('upload-placeholder').classList.remove('hidden');
        document.getElementById('image-preview-wrapper').classList.add('hidden');
    }

    ['dragenter', 'dragover'].forEach(evt => {
        dropZone.addEventListener(evt, (e) => {
            e.preventDefault();
            e.stopPropagation();
            dropZone.classList.add('border-cyan/50', 'bg-card/50');
        });
    });

    ['dragleave', 'drop'].forEach(evt => {
        dropZone.addEventListener(evt, (e) => {
            e.preventDefault();
            e.stopPropagation();
            dropZone.classList.remove('border-cyan/50', 'bg-card/50');
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

@endsection