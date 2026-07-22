<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PostManagementController extends Controller
{
    // Show the create post form
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('posts.create', compact('categories'));
    }

    // Store a new post
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
            'featured_image' => 'nullable|url|max:255',
            'published_at' => 'nullable|date',
        ]);

        // Generate slug from title
        $slug = Str::slug($validated['title']);

        // Check if slug already exists
        if (Post::where('slug', $slug)->exists()) {
            $slug = $slug . '-' . uniqid();
        }

        $post = Post::create([
            'author_id' => auth()->id(),
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'slug' => $slug,
            'content' => $validated['content'],
            'status' => $validated['status'],
            'featured_image' => $validated['featured_image'] ?? null,
            'views' => 0,
            'published_at' => $validated['status'] === 'published'
                ? ($validated['published_at'] ?? Carbon::now())
                : null,
        ]);

        return redirect()->route('posts.show', $post->slug)
            ->with('success', 'Post created successfully!');
    }

    // Show edit form
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $categories = Category::orderBy('name')->get();

        return view('posts.edit', compact('post', 'categories'));
    }

    // Update a post
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
            'featured_image' => 'nullable|url|max:255',
            'published_at' => 'nullable|date',
        ]);

        $post->update([
            'title' => $validated['title'],
            'category_id' => $validated['category_id'],
            'content' => $validated['content'],
            'status' => $validated['status'],
            'featured_image' => $validated['featured_image'] ?? null,
            'published_at' => $validated['status'] === 'published'
                ? ($validated['published_at'] ?? Carbon::now())
                : null,
        ]);

        return redirect()->route('posts.show', $post->slug)
            ->with('success', 'Post updated successfully!');
    }

    // Delete a post
    public function destroy($id)
    {
        Post::findOrFail($id)->delete();

        return redirect()->route('home')
            ->with('success', 'Post deleted successfully!');
    }
}