<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogPostController extends Controller
{
    private function rules(int $id = 0): array
    {
        return [
            'title'             => ['required', 'string', 'max:255'],
            'meta_title'        => ['nullable', 'string', 'max:255'],
            'meta_description'  => ['nullable', 'string', 'max:500'],
            'excerpt'           => ['nullable', 'string', 'max:500'],
            'body'              => ['nullable', 'string'],
            'category'          => ['nullable', 'string', 'in:' . implode(',', BlogPost::categories())],
            'author_name'       => ['nullable', 'string', 'max:100'],
            'status'            => ['required', 'in:active,inactive'],
            'is_featured'       => ['boolean'],
            'image'             => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'published_at'      => ['nullable', 'date'],
        ];
    }

    public function index(Request $request)
    {
        $query = BlogPost::query();

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('author_name', 'like', '%' . $search . '%');
            });
        }

        if ($category = $request->get('category')) {
            $query->where('category', $category);
        }

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        $posts        = $query->latest('published_at')->paginate(15)->withQueryString();
        $trashedCount = BlogPost::onlyTrashed()->count();

        return view('admin.blog-posts.index', compact('posts', 'trashedCount'));
    }

    public function create()
    {
        $categories = BlogPost::categories();
        return view('admin.blog-posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['created_by']  = Auth::guard('admin')->id();
        $validated['slug']        = Str::slug($validated['title']);

        // Ensure unique slug
        $slug  = $validated['slug'];
        $count = 1;
        while (BlogPost::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $slug . '-' . $count++;
        }

        if (empty($validated['author_name'])) {
            $validated['author_name'] = Auth::guard('admin')->user()->name ?? 'Admin';
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('blog', 'public');
        }

        BlogPost::create($validated);

        return redirect()->route('admin.blog-posts.index')
            ->with('success', 'Blog post "' . $validated['title'] . '" created successfully.');
    }

    public function edit(BlogPost $blogPost)
    {
        $categories = BlogPost::categories();
        return view('admin.blog-posts.edit', ['post' => $blogPost, 'categories' => $categories]);
    }

    public function update(Request $request, BlogPost $blogPost)
    {
        $validated = $request->validate($this->rules($blogPost->id));

        $validated['is_featured'] = $request->boolean('is_featured');

        if ($request->hasFile('image')) {
            if ($blogPost->image) {
                Storage::disk('public')->delete($blogPost->image);
            }
            $validated['image'] = $request->file('image')->store('blog', 'public');
        }

        $blogPost->update($validated);

        return redirect()->route('admin.blog-posts.index')
            ->with('success', 'Blog post updated successfully.');
    }

    public function destroy(BlogPost $blogPost)
    {
        $blogPost->delete();
        return back()->with('success', 'Blog post deleted successfully.');
    }

    public function trashed()
    {
        $posts = BlogPost::onlyTrashed()->latest()->paginate(20);
        return view('admin.blog-posts.trashed', compact('posts'));
    }

    public function restore(int $id)
    {
        BlogPost::onlyTrashed()->findOrFail($id)->restore();
        return back()->with('success', 'Blog post restored successfully.');
    }

    public function forceDelete(int $id)
    {
        $post = BlogPost::onlyTrashed()->findOrFail($id);
        if ($post->image) Storage::disk('public')->delete($post->image);
        $post->forceDelete();
        return back()->with('success', 'Blog post permanently deleted.');
    }
}
