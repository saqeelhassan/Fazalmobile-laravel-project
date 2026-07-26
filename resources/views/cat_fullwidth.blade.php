@php
    $pageTitle    = 'Category — Fazal Mobile';
    $currentPage  = 'shop';
    $headerClass  = 'header-v5';
    $extraCss     = [];
    $extraScripts = [];
@endphp
@extends('layouts.app')

@section('content')
<!--content-->
        <div class="container container-240">
            <div class="e-cat">
                <div class="banner">
                    <a href="#" class="image-bd effect_img2"><img src="{{ asset('img/o-banner.jpg') }}" alt="" class="img-reponsive"></a>
                </div>
                <ul class="breadcrumb">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li class="active">{{ $category ?: 'All Products' }}</li>
                </ul>
                <div class="section-cate">
                    <h1 class="e-title text-center">{{ $category ?: 'All Products' }}</h1>
                    <div class="owl-carousel owl-theme owl-cate js-owl-cate">
                        <div class="item item-pd">
                            <div class="product-img">
                                <a href="{{ url('/shop') }}?category={{ urlencode('Mobile Phones') }}"><img src="{{ asset('img/product/pd1.jpg') }}" alt="" class="img-reponsive"></a>
                            </div>
                            <h3>Mobile Phones</h3>
                        </div>
                        <div class="item item-pd">
                            <div class="product-img">
                                <a href="{{ url('/shop') }}?category={{ urlencode('Accessories') }}"><img src="{{ asset('img/product/samsung3.jpg') }}" alt="" class="img-reponsive"></a>
                            </div>
                            <h3>Accessories</h3>
                        </div>
                        <div class="item item-pd">
                            <div class="product-img">
                                <a href="{{ url('/shop') }}?category={{ urlencode('Tablets') }}"><img src="{{ asset('img/product/pd3.jpg') }}" alt="" class="img-reponsive"></a>
                            </div>
                            <h3>Tablets</h3>
                        </div>
                        <div class="item item-pd">
                            <div class="product-img">
                                <a href="{{ url('/shop') }}?category={{ urlencode('Cases & Covers') }}"><img src="{{ asset('img/product/phonecase.jpg') }}" alt="" class="img-reponsive"></a>
                            </div>
                            <h3>Cases & Covers</h3>
                        </div>
                        <div class="item item-pd">
                            <div class="product-img">
                                <a href="{{ url('/shop') }}?category={{ urlencode('Chargers & Cables') }}"><img src="{{ asset('img/product/samsung2.jpg') }}" alt="" class="img-reponsive"></a>
                            </div>
                            <h3>Chargers & Cables</h3>
                        </div>
                        <div class="item item-pd">
                            <div class="product-img">
                                <a href="{{ url('/shop') }}?category={{ urlencode('Laptops & Computers') }}"><img src="{{ asset('img/product/samsung.jpg') }}" alt="" class="img-reponsive"></a>
                            </div>
                            <h3>Laptops & Computers</h3>
                        </div>
                    </div>
                </div>

                {{-- Bestseller Products --}}
                <div class="bestseller">
                    <div class="ecome-heading style3 spc3">
                        <h1>Bestseller Products</h1>
                        <a href="{{ url('/shop') }}" class="btn-show">Shop more<i class="ion-ios-arrow-forward"></i></a>
                    </div>
                    <div class="owl-carousel owl-theme owl-cate v2 js-owl-cate">
                        @forelse($eCatFeatured->merge($eCatLatest)->unique('id')->take(10) as $p)
                        <div class="product-item">
                            <div class="pd-bd product-inner">
                                <div class="product-img" style="width:100%;height:200px;overflow:hidden">
                                    <a href="{{ url('/product') }}">
                                        @if($p->image)
                                            <img src="{{ Storage::url($p->image) }}" alt="{{ $p->name }}" style="width:100%;height:200px;object-fit:cover">
                                        @else
                                            <img src="{{ asset('img/product/img-1.jpg') }}" alt="{{ $p->name }}" style="width:100%;height:200px;object-fit:cover">
                                        @endif
                                    </a>
                                </div>
                                <div class="product-info">
                                    <div class="element-list element-list-middle">
                                        <p class="product-cate">{{ $p->category }}</p>
                                        <h3 class="product-title"><a href="{{ url('/product') }}">{{ Str::limit($p->name, 50) }}</a></h3>
                                        <div class="product-bottom">
                                            <div class="product-price">
                                                @if($p->sale_price)
                                                    <span>Rs. {{ number_format($p->sale_price, 0) }}</span>
                                                    <del style="font-size:12px;color:#9ca3af">Rs. {{ number_format($p->price, 0) }}</del>
                                                @else
                                                    <span>Rs. {{ number_format($p->price, 0) }}</span>
                                                @endif
                                            </div>
                                            <a href="{{ url('/product') }}" class="btn-icon btn-view">
                                                <span class="icon-bg icon-view"></span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="product-button-group">
                                        <a href="#" class="btn-icon"><span class="icon-bg icon-cart"></span></a>
                                        <a href="#" class="btn-icon"><span class="icon-bg icon-wishlist"></span></a>
                                        <a href="#" class="btn-icon"><span class="icon-bg icon-compare"></span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <p style="color:#9ca3af;padding:20px">No products yet.</p>
                        @endforelse
                    </div>
                </div>

                {{-- Main Product Grid --}}
                <div class="pd-top" style="margin-top:30px">
                    <h1 class="title">All Products</h1>
                    <div class="show-element">
                        <span>Showing {{ $products->firstItem() }}–{{ $products->lastItem() }} of {{ $products->total() }} results</span>
                    </div>
                </div>

                @include('partials.shop_product_grid')

            </div>
        </div>

        @include('partials.shop_ecategory')
@endsection
