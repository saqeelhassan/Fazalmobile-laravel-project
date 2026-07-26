@php
    $pageTitle    = 'Shop — Fazal Mobile';
    $currentPage  = 'shop';
    $headerClass  = 'header-v5';
    $extraCss     = ['css/bootstrap-slider.css'];
    $extraScripts = ['js/bootstrap-slider.min.js'];
@endphp
@extends('layouts.app')

@section('content')
<!--content-->
        <div class="container container-240 shop-collection">
            <ul class="breadcrumb">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li class="active">Shop</li>
            </ul>
            <div class="filter-collection-left hidden-lg hidden-md">
              <a class="btn">Filter</a>
            </div>
            <div class="row shop-colect">

                {{-- Sidebar --}}
                @include('partials.shop_sidebar')

                {{-- Content Area --}}
                <div class="col-md-9 col-sm-12 col-xs-12 collection-list">
                    <div class="e-product">
                        <div class="pd-banner">
                           <a href="#" class="image-bd effect_img2"><img src="{{ asset('img/shop-banner_3.jpg') }}" alt="" class="img-reponsive"></a>
                        </div>
                        <div class="pd-top">
                            <h1 class="title">
                                {{ $category ?: ($search ? 'Search: ' . $search : 'Shop') }}
                            </h1>
                            <div class="show-element">
                                <span>Showing {{ $products->firstItem() }}–{{ $products->lastItem() }} of {{ $products->total() }} results</span>
                            </div>
                        </div>
                        <div class="pd-middle">
                            <div class="view-mode view-group">
                                <a class="grid-icon col active"><img src="{{ asset('img/grid.png') }}" alt=""></a>
                                <a class="grid-icon col2"><img src="{{ asset('img/grid2.png') }}" alt=""></a>
                                <a class="list-icon list"><img src="{{ asset('img/list.png') }}" alt=""></a>
                            </div>
                            <div class="pd-sort">
                                @php
                                    $sortLabels = [
                                        'default'    => 'Default sorting',
                                        'price-asc'  => 'Price: Low to High',
                                        'price-desc' => 'Price: High to Low',
                                        'name-asc'   => 'Name: A–Z',
                                        'name-desc'  => 'Name: Z–A',
                                        'newest'     => 'Newest First',
                                        'oldest'     => 'Oldest First',
                                    ];
                                @endphp
                                <div class="filter-sort">
                                    <div class="dropdown">
                                        <button class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                            <span class="dropdown-label">{{ $sortLabels[$sort] ?? 'Default sorting' }}</span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            @foreach($sortLabels as $key => $label)
                                                <li><a href="{{ url('/shop-grid-v1') }}?{{ http_build_query(array_merge(request()->query(), ['sort' => $key])) }}">{{ $label }}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <div class="filter-show">
                                    <div class="dropdown">
                                        <button class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                            Show <span class="dropdown-label">{{ $perPage }}</span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            @foreach([12, 24, 36, 48] as $n)
                                                <li><a href="{{ url('/shop-grid-v1') }}?{{ http_build_query(array_merge(request()->query(), ['per_page' => $n])) }}">{{ $n }}</a></li>
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
