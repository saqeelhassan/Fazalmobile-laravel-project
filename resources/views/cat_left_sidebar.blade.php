@php
    $pageTitle    = 'Category — Fazal Mobile';
    $currentPage  = 'shop';
    $headerClass  = 'header-v5';
    $extraCss     = ['css/bootstrap-slider.css'];
    $extraScripts = ['js/bootstrap-slider.min.js'];
@endphp
@extends('layouts.app')

@section('content')
<!--content-->
        <div class="container container-240 shop-collection catleft">
            <ul class="breadcrumb">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li class="active">{{ $category ?: 'All Products' }}</li>
            </ul>
            <div class="filter-collection-left hidden-lg hidden-md">
              <a class="btn">Filter</a>
            </div>
            <div class="row shop-colect">

                {{-- Sidebar --}}
                @include('partials.shop_sidebar')

                {{-- Content Area --}}
                <div class="col-md-9 col-sm-12 col-xs-12 collection-list">

                    {{-- Bestseller Products Carousel --}}
                    <div class="bestseller">
                        <div class="ecome-heading style3v2 spc3">
                            <h1>Bestseller Products</h1>
                            <a href="{{ url('/shop') }}" class="btn-show">Shop more<i class="ion-ios-arrow-forward"></i></a>
                        </div>
                        <div class="owl-carousel owl-theme owl-cate v2 js-owl-cate2">
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
                    <div class="e-product" style="margin-top:20px">
                        <div class="pd-top">
                            <h1 class="title">{{ $category ?: 'All Products' }}</h1>
                            <div class="show-element">
                                <span>Showing {{ $products->firstItem() }}–{{ $products->lastItem() }} of {{ $products->total() }} results</span>
                            </div>
                        </div>
                        <div class="pd-middle">
                            <div class="pd-sort">
                                @php
                                    $sortLabels = [
                                        'default'    => 'Default sorting',
                                        'price-asc'  => 'Price: Low to High',
                                        'price-desc' => 'Price: High to Low',
                                        'name-asc'   => 'Name: A–Z',
                                        'newest'     => 'Newest First',
                                    ];
                                @endphp
                                <div class="filter-sort">
                                    <div class="dropdown">
                                        <button class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                            <span class="dropdown-label">{{ $sortLabels[$sort] ?? 'Default sorting' }}</span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            @foreach($sortLabels as $key => $label)
                                                <li><a href="{{ url('/category-left-sidebar') }}?{{ http_build_query(array_merge(request()->query(), ['sort' => $key])) }}">{{ $label }}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @include('partials.shop_product_grid')
                    </div>
                </div>
            </div>
        </div>

        @include('partials.shop_ecategory')
@endsection
