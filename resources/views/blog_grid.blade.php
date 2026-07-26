@php
    $pageTitle       = 'Blog Grid — Fazal Mobile | Tech Tips, Guides & Product News';
    $metaDescription = 'Buying guides, comparisons and tips on smart watches, gaming controllers, airbuds, chargers, cables and cooling fans from the Fazal Mobile team.';
    $currentPage     = 'blog';
    $headerClass     = 'header-v5';
    $extraCss        = [];
    $extraScripts    = [];
@endphp
@extends('layouts.app')

@section('content')
<!--content-->
        <div class="container container-240">
            <div class="blog-banner pd-banner v2">
               <a href="{{ url('/shop') }}" class="effect_img2"><img src="{{ asset('img/blog/blog-banner.png') }}" alt="Fazal Mobile blog" class="img-reponsive"></a>
            </div>
            <div class="blog spc1">
                <ul class="breadcrumb">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li class="active">Blog</li>
                </ul>
                <div class="blog-grid">
                    <h1 class="blog-heading text-center">{{ $category ? $category . ' Articles' : 'Our Blog' }}</h1>
                    <div class="row">
                        @forelse($posts as $post)
                        <div class="col-md-4 col-sm-6 col-xs-12 blog-post-item">
                            <div class="blog-img">
                                <a href="{{ url('/blog/' . $post->slug) }}" class="hover-images">
                                    <img src="{{ $post->image ? \Illuminate\Support\Facades\Storage::url($post->image) : asset('img/blog/blog_1.jpg') }}" alt="{{ $post->title }}" class="img-reponsive">
                                </a>
                                <div class="blog-post-date e-gradient abs">
                                    <span class="b-date">{{ optional($post->published_at)->format('d') }}</span>
                                    <span class="b-month">{{ optional($post->published_at)->format('M') }}</span>
                                </div>
                            </div>
                            <div class="blog-info">
                                <h3 class="blog-post-title"><a href="{{ url('/blog/' . $post->slug) }}">{{ $post->title }}</a></h3>
                                <p class="blog-post-desc">{{ $post->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($post->body), 140) }}</p>
                                <div class="blog-post-author">
                                    <div class="author">Posted by <span class="c-black">{{ $post->author_name }}</span></div>
                                    @if($post->category)<div class="blog-post-comment"><a href="{{ url('/blog') }}?category={{ urlencode($post->category) }}" style="color:#6c63ff">{{ $post->category }}</a></div>@endif
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-xs-12" style="text-align:center;padding:60px 20px;color:#9ca3af">
                            <i class="fas fa-newspaper" style="font-size:40px;display:block;margin-bottom:12px"></i>
                            No blog posts yet. Check back soon!
                        </div>
                        @endforelse
                    </div>
                </div>
                @if($posts->hasPages())
                <ul class="pagination">
                    @if($posts->onFirstPage())
                        <li class="disabled"><span><i class="ion-ios-arrow-back"></i></span></li>
                    @else
                        <li><a href="{{ $posts->previousPageUrl() }}"><i class="ion-ios-arrow-back"></i></a></li>
                    @endif
                    @foreach($posts->getUrlRange(1, $posts->lastPage()) as $page => $url)
                        <li class="{{ $page == $posts->currentPage() ? 'active' : '' }}"><a href="{{ $url }}">{{ $page }}</a></li>
                    @endforeach
                    @if($posts->hasMorePages())
                        <li><a href="{{ $posts->nextPageUrl() }}"><i class="ion-ios-arrow-forward"></i></a></li>
                    @else
                        <li class="disabled"><span><i class="ion-ios-arrow-forward"></i></span></li>
                    @endif
                </ul>
                @endif
            </div>
        </div>
@include('layouts.partials.ecategory')
@endsection
