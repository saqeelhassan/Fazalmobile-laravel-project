@php
    $pageTitle       = 'Blog — Fazal Mobile | Tech Tips, Guides & Product News';
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
            <div class="blog">
                <ul class="breadcrumb">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li class="active">Blog</li>
                </ul>
                <div class="blog-single-post blog-standar">
                    <h1 class="blog-heading text-center">{{ $category ? $category . ' Articles' : 'Our Blog' }}</h1>
                    <div class="row">
                        <div class="blog-content  col-md-9  col-xs-12">
                            @forelse($posts as $post)
                            <div class="blog-post-item v2">
                                <div class="blog-img">
                                    <a href="{{ url('/blog/' . $post->slug) }}" class="hover-images">
                                        <img src="{{ $post->image ? \Illuminate\Support\Facades\Storage::url($post->image) : asset('img/blog/single-post.jpg') }}" alt="{{ $post->title }}" class="img-reponsive">
                                    </a>
                                    <div class="blog-post-date e-gradient abs v2">
                                        <span class="b-date">{{ optional($post->published_at)->format('d') }}</span>
                                        <span class="b-month">{{ optional($post->published_at)->format('M') }}</span>
                                    </div>
                                </div>
                                <div class="blog-info-bd">
                                    <div class="blog-info">
                                        <h3 class="blog-post-title v2"><a href="{{ url('/blog/' . $post->slug) }}">{{ $post->title }}</a></h3>
                                        <div class="blog-post-desc">
                                            {{ $post->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($post->body), 220) }}
                                        </div>
                                    </div>
                                    <div class="blog-post-author v2">
                                        <div class="blog-post-tags v2">
                                            <div class="author">Posted by <span class="c-black">{{ $post->author_name }}</span></div>
                                            @if($post->category)
                                            <div class="blog-tag">
                                                <a href="{{ url('/blog') }}?category={{ urlencode($post->category) }}">{{ $post->category }}</a>
                                            </div>
                                            @endif
                                        </div>
                                        <a href="{{ url('/blog/' . $post->slug) }}" class="btn-author" style="text-decoration:none">Read more <i class="ion-ios-arrow-forward"></i></a>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div style="text-align:center;padding:60px 20px;color:#9ca3af">
                                <i class="fas fa-newspaper" style="font-size:40px;display:block;margin-bottom:12px"></i>
                                No blog posts yet. Check back soon!
                            </div>
                            @endforelse

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
                        <div class="blog-sidebar col-md-3 col-xs-12">
                            <div class="blog-widget blog-widget-category">
                                <h1 class="widget-blog-title">Categories</h1>
                                <ul class="wiget-content">
                                    @forelse($categoryCounts as $c)
                                        <li><a href="{{ url('/blog') }}?category={{ urlencode($c->category) }}">{{ $c->category }} <span class="number">({{ $c->total }})</span></a></li>
                                    @empty
                                        <li style="color:#9ca3af">No categories yet.</li>
                                    @endforelse
                                </ul>
                            </div>
                            <div class="blog-widget blog-widget-popular">
                                <h1 class="widget-blog-title">Popular post</h1>
                                <div class="owl-carousel owl-theme js-owl-post">
                                    <div class="item">
                                        @forelse($popularPosts as $p)
                                        <div class="post-item">
                                            <div class="post-img">
                                                <img src="{{ $p->image ? \Illuminate\Support\Facades\Storage::url($p->image) : asset('img/blog/post1.jpg') }}" alt="{{ $p->title }}">
                                            </div>
                                            <div class="post-info">
                                                <h3><a href="{{ url('/blog/' . $p->slug) }}">{{ \Illuminate\Support\Str::limit($p->title, 45) }}</a></h3>
                                                <p>{{ optional($p->published_at)->format('M d, Y') }}</p>
                                            </div>
                                        </div>
                                        @empty
                                        <p style="color:#9ca3af;padding:10px">No posts yet.</p>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                            <div class="blog-widget-banner">
                                <a href="{{ url('/shop') }}" class=""><img src="{{ asset('img/blog/ads.png') }}" alt="Shop Fazal Mobile" class="img-reponsive"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@include('layouts.partials.ecategory')
@endsection
