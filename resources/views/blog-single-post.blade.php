@php
    $pageTitle       = $metaTitle;
    $currentPage     = 'blog';
    $headerClass     = 'header-v5';
    $extraCss        = [];
    $extraScripts    = [];
    $canonicalUrl    = url('/blog/' . $post->slug);
@endphp
@extends('layouts.app')

@section('content')
<!--content-->
        <div class="container container-240">
            <div class="blog spc1">
                <ul class="breadcrumb">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="{{ url('/blog') }}">Blog</a></li>
                    <li class="active">{{ \Illuminate\Support\Str::limit($post->title, 60) }}</li>
                </ul>
                <div class="blog-single-post">
                    <div class="row">
                        <div class="blog-content  col-md-9  col-xs-12">
                            <div class="blog-post-item v2">
                                <div class="blog-img">
                                    <img src="{{ $post->image ? \Illuminate\Support\Facades\Storage::url($post->image) : asset('img/blog/single-post.jpg') }}" alt="{{ $post->title }}" class="img-reponsive">
                                    <div class="blog-post-date e-gradient abs v2">
                                        <span class="b-date">{{ optional($post->published_at)->format('d') }}</span>
                                        <span class="b-month">{{ optional($post->published_at)->format('M') }}</span>
                                    </div>
                                </div>
                                <div class="blog-info-bd">
                                    <div class="blog-info">
                                        <h1 class="blog-post-title v2" style="font-size:26px">{{ $post->title }}</h1>
                                        <div class="blog-post-desc">
                                            {!! $post->body !!}
                                        </div>
                                    </div>
                                    <div class="blog-post-author v2">
                                        <div class="blog-post-tags">
                                            <span style="color:#9ca3af">Posted by {{ $post->author_name }} on {{ optional($post->published_at)->format('M d, Y') }}</span>
                                            @if($post->category)
                                                &nbsp;·&nbsp;<a href="{{ url('/blog') }}?category={{ urlencode($post->category) }}">{{ $post->category }}</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if($relatedProducts->count())
                            <div class="blog-comment">
                                <div class="cmt-title text-center abs"><h1 class="oval-bd">Related Products</h1></div>
                                <div class="row equal-cards" style="margin-top:20px">
                                    @foreach($relatedProducts as $p)
                                    <div class="col-xs-6 col-sm-6 col-md-3 product-item">
                                        <div class="product-inner">
                                            <div class="product-img">
                                                <a href="{{ url('/product/' . $p->slug) }}">
                                                    <img src="{{ $p->image ? \Illuminate\Support\Facades\Storage::url($p->image) : asset('img/product/img-1.jpg') }}" alt="{{ $p->name }}">
                                                </a>
                                            </div>
                                            <div class="pd-bd">
                                                <h3 class="pd-title"><a href="{{ url('/product/' . $p->slug) }}">{{ $p->name }}</a></h3>
                                                <div class="pd-price">
                                                    @if($p->sale_price)
                                                        <span>Rs. {{ number_format($p->sale_price, 0) }}</span>
                                                        <del>Rs. {{ number_format($p->price, 0) }}</del>
                                                    @else
                                                        <span>Rs. {{ number_format($p->price, 0) }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            @if($relatedPosts->count())
                            <div class="blog-comment">
                                <div class="cmt-title text-center abs"><h1 class="oval-bd">You May Also Like</h1></div>
                                <div class="row" style="margin-top:20px">
                                    @foreach($relatedPosts as $rp)
                                    <div class="col-md-4 col-xs-12">
                                        <div class="blog-post-item v3" style="margin-bottom:20px">
                                            <div class="blog-img">
                                                <a href="{{ url('/blog/' . $rp->slug) }}"><img src="{{ $rp->image ? \Illuminate\Support\Facades\Storage::url($rp->image) : asset('img/blog/post1.jpg') }}" alt="{{ $rp->title }}" class="img-reponsive"></a>
                                            </div>
                                            <h3 class="blog-post-title" style="font-size:15px;margin-top:10px"><a href="{{ url('/blog/' . $rp->slug) }}">{{ $rp->title }}</a></h3>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
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
