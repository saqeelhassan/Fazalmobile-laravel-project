<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Product;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    private function categoryCounts()
    {
        return BlogPost::where('status', 'active')
            ->selectRaw('category, count(*) as total')
            ->whereNotNull('category')
            ->groupBy('category')
            ->orderByDesc('total')
            ->get();
    }

    public function index(Request $request)
    {
        $query = BlogPost::where('status', 'active');

        if ($category = $request->get('category')) {
            $query->where('category', $category);
        }

        $posts          = $query->latest('published_at')->paginate(4)->withQueryString();
        $categoryCounts = $this->categoryCounts();
        $popularPosts   = BlogPost::where('status', 'active')->orderByDesc('views')->take(4)->get();

        return view('blog-standar', compact('posts', 'categoryCounts', 'popularPosts', 'category'));
    }

    public function grid(Request $request)
    {
        $query = BlogPost::where('status', 'active');

        if ($category = $request->get('category')) {
            $query->where('category', $category);
        }

        $posts          = $query->latest('published_at')->paginate(9)->withQueryString();
        $categoryCounts = $this->categoryCounts();

        return view('blog_grid', compact('posts', 'categoryCounts', 'category'));
    }

    public function show($slug)
    {
        $post = BlogPost::where('status', 'active')
            ->where(fn ($q) => $q->where('slug', $slug)->orWhere('id', $slug))
            ->firstOrFail();

        $post->increment('views');

        $categoryCounts = $this->categoryCounts();
        $popularPosts   = BlogPost::where('status', 'active')->where('id', '!=', $post->id)->orderByDesc('views')->take(4)->get();
        $relatedPosts   = BlogPost::where('status', 'active')
            ->where('id', '!=', $post->id)
            ->when($post->category, fn ($q) => $q->where('category', $post->category))
            ->latest('published_at')->take(3)->get();
        $relatedProducts = Product::where('status', 'active')
            ->when($post->category, fn ($q) => $q->where('category', $post->category))
            ->take(4)->get();

        $metaTitle       = $post->meta_title ?: $post->title . ' — Fazal Mobile Blog';
        $metaDescription = $post->meta_description ?: \Illuminate\Support\Str::limit(strip_tags($post->excerpt ?: $post->body), 160);

        return view('blog-single-post', compact('post', 'categoryCounts', 'popularPosts', 'relatedPosts', 'relatedProducts', 'metaTitle', 'metaDescription'));
    }
}
