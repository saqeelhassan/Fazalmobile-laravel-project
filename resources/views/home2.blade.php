@php
    use Illuminate\Support\Str;
    use Illuminate\Support\Facades\Storage;
    $pageTitle    = 'Fazal Mobile — Smart Watches, Games, Airbuds & More';
    $currentPage  = 'home';
    $headerClass  = 'header-v2';
    $extraCss     = [];
    $extraScripts = [];
@endphp
@extends('layouts.app')

@section('content')
@php
    $catIcons = [
        'Smart Watches' => 'img/category/1.png',
        'Games'         => 'img/category/4.png',
        'Airbuds'       => 'img/category/3.png',
        'Cables'        => 'img/category/2.png',
        'Projector'     => 'img/category/5.png',
        'Charger'       => 'img/category/6.png',
        'Cooling Fan'   => 'img/category/7.png',
    ];
@endphp
<style>
    /* ── Custom BOYA hero slide ── */
    .slide-boya {
        position: relative;
        min-height: 674px;
        display: flex !important;
        align-items: center;
        overflow: hidden;
        background:
            radial-gradient(circle at 80% 30%, rgba(249, 111, 93, 0.10), transparent 45%),
            radial-gradient(circle at 15% 85%, rgba(108, 99, 255, 0.08), transparent 50%),
            radial-gradient(circle at 60% 90%, rgba(0, 200, 255, 0.07), transparent 40%),
            linear-gradient(135deg, #ffffff 0%, #f4f6fb 55%, #eef0f8 100%);
    }
    .slide-boya-img::before,
    .slide-boya-img::after {
        content: "";
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
        left: 50%; top: 50%;
        transform: translate(-50%, -50%);
        z-index: -1;
    }
    .slide-boya-img::before {
        width: 560px; height: 560px;
        border: 1px solid rgba(108, 99, 255, 0.10);
        background: radial-gradient(circle, rgba(249, 111, 93, 0.07) 0%, rgba(249, 111, 93, 0.03) 55%, transparent 75%);
        box-shadow: 0 0 120px rgba(249, 111, 93, 0.08) inset;
    }
    .slide-boya-img::after {
        width: 680px; height: 680px;
        border: 1px dashed rgba(108, 99, 255, 0.08);
    }
    .slide-boya-inner {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        position: relative;
        z-index: 2;
    }
    .slide-boya-text { max-width: 52%; }
    .slide-boya-text .cate {
        color: #f96f5d;
        letter-spacing: 4px;
    }
    .slide-boya-text h3.v4 {
        color: #1c1c28;
        font-size: 46px;
        line-height: 1.18;
        margin: 12px 0 18px;
    }
    .slide-boya-desc {
        color: #6b6f7e;
        font-size: 16px;
        line-height: 1.75;
        max-width: 470px;
        margin-bottom: 22px;
    }
    .slide-boya-features {
        list-style: none;
        padding: 0;
        margin: 0 0 30px;
        display: flex;
        flex-wrap: wrap;
        max-width: 500px;
    }
    .slide-boya-features li {
        width: 50%;
        color: #3a3d4a;
        font-size: 14px;
        font-weight: 600;
        padding: 6px 0;
    }
    .slide-boya-features li i {
        color: #f96f5d;
        font-size: 18px;
        margin-right: 8px;
        vertical-align: -2px;
    }
    /* Match the theme's slide button (same rules as .slide-content .slide-btn) */
    .slide-boya .slide-btn {
        font-size: 16px;
        color: #fefefe;
        border-radius: 999px;
        display: inline-block;
        width: 177px;
        height: 50px;
        line-height: 50px;
        text-align: center;
        text-decoration: none;
    }
    .slide-boya .slide-btn i { margin-left: 15px; }
    @media (max-width: 479px) {
        .slide-boya .slide-btn {
            font-size: 14px;
            width: 100px;
            height: 30px;
            line-height: 30px;
        }
        .slide-boya .slide-btn i { margin-left: 5px; }
    }
    .slide-boya-img {
        position: relative;
        flex-shrink: 0;
        margin-right: 60px;
    }
    .slide-boya-img img {
        max-height: 500px;
        width: auto;
        filter: drop-shadow(0 30px 45px rgba(30, 30, 60, 0.22));
        animation: boyaFloat 4.5s ease-in-out infinite;
    }
    @keyframes boyaFloat {
        0%, 100% { transform: translateY(0); }
        50%      { transform: translateY(-16px); }
    }
    @media (max-width: 991px) {
        .slide-boya { min-height: 480px; }
        .slide-boya-img img { max-height: 340px; }
        .slide-boya-img { margin-right: 15px; }
        .slide-boya-img::before, .slide-boya-img::after { display: none; }
    }
    /* ── Sale ribbon badge: theme default hangs it partially outside the
       image box (top:-17px; right:-15px), but `.product-img` clips
       overflow (needed for the hover-zoom effect) — pull it fully inside
       so it isn't cut off. ── */
    .product-item .product-img .ribbon-price { top: 10px; right: 10px; }

    /* ── All Products slider — arrows styled to match the hero slider's
       (.slide-fullw .slick-arrow) white rounded-square buttons, positioned
       side-by-side at the left/right edges instead of stacked below.
       Note: Owl Carousel's default navElement is a <div>, not a <button> —
       must NOT restrict the selector to `button.owl-prev`/`button.owl-next`
       or it silently matches nothing and falls back to default styling. ── */
    .js-owl-allproducts { position: relative; }
    .js-owl-allproducts .owl-dots { display: none; }
    .js-owl-allproducts .owl-nav { margin: 0; }
    .js-owl-allproducts .owl-nav .owl-prev,
    .js-owl-allproducts .owl-nav .owl-next {
        position: absolute;
        top: 40%;
        transform: translateY(-50%);
        width: 44px;
        height: 44px;
        line-height: 44px;
        border-radius: 5px;
        background: #fff !important;
        box-shadow: 0 2px 12px rgba(0, 0, 0, .14);
        text-align: center;
        font-size: 20px;
        color: #333 !important;
        transition: all 0.3s ease;
        z-index: 3;
        margin: 0;
        padding: 0;
    }
    .js-owl-allproducts .owl-nav .owl-prev:hover,
    .js-owl-allproducts .owl-nav .owl-next:hover {
        background: rgba(255, 255, 255, 0.75) !important;
    }
    .js-owl-allproducts .owl-nav .owl-prev { left: -60px; }
    .js-owl-allproducts .owl-nav .owl-next { right: -60px; }
    @media (max-width: 1300px) {
        .js-owl-allproducts .owl-nav .owl-prev { left: -20px; }
        .js-owl-allproducts .owl-nav .owl-next { right: -20px; }
    }
    @media (max-width: 767px) {
        .js-owl-allproducts .owl-nav .owl-prev,
        .js-owl-allproducts .owl-nav .owl-next { width: 34px; height: 34px; line-height: 34px; font-size: 16px; }
        .js-owl-allproducts .owl-nav .owl-prev { left: -6px; }
        .js-owl-allproducts .owl-nav .owl-next { right: -6px; }
    }

    /* ── From Our Blog slider — same "arrow away from card border" spacing
       as the All Products slider above (theme default was only -20px). ── */
    @media (min-width: 1025px) {
        .our-blog .owl-nav > div.owl-prev { left: -60px; }
        .our-blog .owl-nav > div.owl-next { right: -60px; }
    }
    @media (max-width: 767px) {
        .slide-boya { min-height: auto; padding: 50px 0; }
        .slide-boya-inner { flex-direction: column-reverse; text-align: center; gap: 25px; }
        .slide-boya-text { max-width: 100%; }
        .slide-boya-text h3.v4 { font-size: 30px; }
        .slide-boya-desc { margin-left: auto; margin-right: auto; }
        .slide-boya-features { max-width: 320px; margin-left: auto; margin-right: auto; text-align: left; }
        .slide-boya-img { margin-right: 0; }
        .slide-boya-img img { max-height: 240px; }
    }
</style>
<!-- Slide -->
        <div class="slide-fullw">
            <div class="js-slider-home2">
                @forelse($featured->take(3) as $heroProduct)
                <div class="e-slide-img slide-boya">
                    <div class="container container-240">
                        <div class="slide-boya-inner">
                            <div class="slide-boya-text">
                                <p class="cate">{{ Str::upper($heroProduct->brand ?: $heroProduct->category) }}</p>
                                <h3 class="v4">{{ $heroProduct->name }}</h3>
                                <p class="slide-boya-desc">{{ Str::limit(trim(strip_tags($heroProduct->short_description ?: $heroProduct->description)), 160) }}</p>
                                <div class="product-price v2" style="margin-bottom:22px">
                                    @if($heroProduct->sale_price)
                                        <span class="red" style="font-size:22px;font-weight:700">Rs. {{ number_format($heroProduct->sale_price, 0) }}</span>
                                        <span class="old" style="margin-left:8px">Rs. {{ number_format($heroProduct->price, 0) }}</span>
                                    @else
                                        <span style="font-size:22px;font-weight:700">Rs. {{ number_format($heroProduct->price, 0) }}</span>
                                    @endif
                                </div>
                                <a href="{{ url('/product/' . $heroProduct->slug) }}" class="slide-btn e-pink-gradient" tabindex="0">Shop now<i class="ion-ios-arrow-forward"></i></a>
                            </div>
                            <div class="slide-boya-img">
                                <img src="{{ $heroProduct->original_image_url }}" alt="{{ $heroProduct->name }}">
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="e-slide-img slide-boya">
                    <div class="container container-240">
                        <div class="slide-boya-inner">
                            <div class="slide-boya-text">
                                <p class="cate">WELCOME TO FAZAL MOBILES</p>
                                <h3 class="v4">{{ SITE_TAGLINE }}</h3>
                                <p class="slide-boya-desc">Browse smart watches, airbuds, gaming gear and accessories. New products are added regularly — check back soon.</p>
                                <a href="{{ url('/shop') }}" class="slide-btn e-pink-gradient" tabindex="0">Shop now<i class="ion-ios-arrow-forward"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
        <!-- End Slide -->
        <!-- Shop by category -->
        <div class="homepage-banner spc2">
            <div class="container container-240">
                <div class="row">
                    @php
                        // Each banner image is a fixed marketing graphic for a specific
                        // category (cooling fan / smart watch / game controller) — the
                        // caption must match the image, not just "the first 3 categories".
                        $catBanners = [
                            ['img' => 'img/banner/h2_b1.jpg', 'cat' => 'Cooling Fan'],
                            ['img' => 'img/banner/h2_b2.jpg', 'cat' => 'Smart Watches'],
                            ['img' => 'img/banner/h2_b3.jpg', 'cat' => 'Games'],
                        ];
                    @endphp
                    @foreach($catBanners as $banner)
                    <div class="col-md-4 col-sm-4 col-xs-4">
                        <div class="banner-img effect-img3 plus-zoom" style="text-align:center;padding:40px 15px;border-radius:6px;overflow:hidden">
                            <a href="{{ url('/shop?category=' . urlencode($banner['cat'])) }}">
                                <img src="{{ asset($banner['img']) }}" alt="{{ $banner['cat'] }}" style="width:100%;height:auto;border-radius:6px;margin-bottom:12px">
                                <h3 style="font-size:18px;margin:0">{{ $banner['cat'] }}</h3>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- End Shop by category -->
        <!-- super deal -->
        @if($featured->count())
        <style>
            .super-deal .row { display: flex; flex-wrap: wrap; align-items: stretch; }
            .super-deal .col-md-4, .super-deal .col-md-8 { display: flex; }
            .super-deal .product-countd { width: 100%; }
            .super-deal .product-wrapper,
            .super-deal .product-img-slide,
            .super-deal .product-images.v2,
            .super-deal .main-img.v2,
            .super-deal .main-img.v2 a { width: 100%; height: 100%; }
            .super-deal .main-img.v2 img { width: 100%; height: 100%; object-fit: cover; display: block; }
        </style>
        <div class="super-deal v2">
            <div class="container container-240">
                <div class="owl-carousel owl-theme owl-cate js-oneitem2">
                    @foreach($featured->take(4) as $dealProduct)
                    <div class="row">
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <div class="product-countd pd-bd spc2 bg product-inner">
                                <div class="product-item-countd">
                                    <div class="product-info">
                                        <h1 class="deal-title text-center">Super Deals</h1>
                                        <h3 class="product-title text-center v4">
                                            <a href="{{ url('/product/' . $dealProduct->slug) }}">{{ $dealProduct->name }}</a>
                                        </h3>
                                        <div class="product-price thin-price v3 no-bg bd">
                                            @if($dealProduct->sale_price)
                                                <span class="red">Rs. {{ number_format($dealProduct->sale_price, 0) }}</span>
                                                <span class="old">Rs. {{ number_format($dealProduct->price, 0) }}</span>
                                            @else
                                                <span class="red">Rs. {{ number_format($dealProduct->price, 0) }}</span>
                                            @endif
                                        </div>
                                        <div class="deal-progress">
                                            <div class="deal-stock">
                                                <span class="stock-sold">{{ $dealProduct->category }}</span>
                                                @if($dealProduct->stock > 0)
                                                    <span class="stock-available">Stock: <strong>{{ $dealProduct->stock }}</strong></span>
                                                @else
                                                    <span class="stock-available">Out of stock</span>
                                                @endif
                                            </div>
                                            <div class="progress">
                                                @if($dealProduct->stock > 0)
                                                    <span class="progress-bar" style="width:{{ min(100, $dealProduct->stock * 5) }}%"></span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="time-cound">
                                            <p class="text-center">Deal ends in :</p>
                                            <div class="countdown countdown-time" data-countdown="countdown" data-date="12-31-2026-00-00-00"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 col-sm-12 col-xs-12">
                            <div class="product-wrapper">
                                <div class="flex product-img-slide" style="height:100%">
                                    <div class="product-images v2">
                                        <div class="main-img v2 js-product-slider">
                                            @if($dealProduct->image)
                                                <a href="{{ url('/product/' . $dealProduct->slug) }}" class="hover-images effect">
                                                    <img src="{{ Storage::url($dealProduct->image) }}" alt="{{ $dealProduct->name }}" class="img-reponsive">
                                                </a>
                                            @else
                                                <a href="{{ url('/product/' . $dealProduct->slug) }}" class="hover-images effect">
                                                    <img src="{{ asset('img/single/smartwatch1.jpg') }}" alt="{{ $dealProduct->name }}" class="img-reponsive">
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
        <!-- End super deal -->
        <!-- feature product -->
        <div class="feature-product spc2">
            <div class="container container-240">
                <div class="ecome-heading style2">
                    <h1>Featured Products</h1>
                    <a href="{{ url('/shop') }}" class="btn-show">Shop more<i class="ion-ios-arrow-forward"></i></a>
                </div>
                <p class="ecome-info spc2">Browse our range of quality products across all categories</p>

                @php
                    $firstCat = true;
                @endphp

                <div class="row">
                    <div class="col-md-3 col-sm-4 col-xs-12">
                        <ul class="tab-link">
                            @foreach($categories as $cat)
                            @php $tabId = 'cat-feat-' . Str::slug($cat); @endphp
                            <li class="{{ $firstCat ? 'active' : '' }}">
                                <a data-toggle="tab" href="#{{ $tabId }}">
                                    <div class="tab-link-info flex align-center">
                                        <img src="{{ asset($catIcons[$cat] ?? 'img/category/1.png') }}" alt="">
                                        <span>{{ $cat }}</span>
                                    </div>
                                </a>
                            </li>
                            @php $firstCat = false; @endphp
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-md-9 col-sm-8 col-xs-12">
                        <div class="tab-content">
                            @php $firstCat2 = true; @endphp
                            @foreach($categories as $cat)
                            @php $tabId = 'cat-feat-' . Str::slug($cat); @endphp
                            <div id="{{ $tabId }}" class="tab-pane fade {{ $firstCat2 ? 'in active' : '' }}">
                                <div class="row equal-cards">
                                    @if(isset($byCategory[$cat]) && $byCategory[$cat]->count())
                                        @foreach($byCategory[$cat] as $product)
                                        <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4 product-item">
                                            <div class="pd-bd product-inner">
                                                <div class="product-img">
                                                    <a href="{{ url('/product/' . $product->slug) }}" class="js-quickview"
                                                       data-id="{{ $product->id }}"
                                                       data-name="{{ $product->name }}"
                                                       data-cate="{{ $product->category }}"
                                                       data-brand="{{ $product->brand }}"
                                                       data-stock="{{ $product->stock }}"
                                                       data-price="Rs. {{ number_format($product->sale_price ?: $product->price, 0) }}"
                                                       data-price-raw="{{ $product->sale_price ?: $product->price }}"
                                                       data-oldprice="{{ $product->sale_price ? 'Rs. ' . number_format($product->price, 0) : '' }}"
                                                       data-desc="{{ Str::limit(trim(strip_tags(str_replace(['\r\n', '\n'], ' ', $product->short_description ?: $product->description))), 180) }}"
                                                       data-image="{{ $product->image ? Storage::url($product->image) : asset('img/product/pd1.jpg') }}"
                                                       data-url="{{ url('/product/' . $product->slug) }}">
                                                        @if($product->image)
                                                            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="img-reponsive" style="width:100%;height:220px;object-fit:cover">
                                                        @else
                                                            <img src="{{ asset('img/product/pd1.jpg') }}" alt="{{ $product->name }}" class="img-reponsive" style="width:100%;height:220px;object-fit:cover">
                                                        @endif
                                                    </a>
                                                    @if($product->stock == 0)
                                                        <span class="product-badge badge-out">Out of Stock</span>
                                                    @elseif($product->is_on_sale && $product->sale_price)
                                                        @php $disc = round((1 - $product->sale_price/$product->price)*100); @endphp
                                                        <span class="product-badge badge-sale">-{{ $disc }}% OFF</span>
                                                    @elseif($product->is_featured)
                                                        <span class="product-badge badge-new">Featured</span>
                                                    @endif
                                                    @include('layouts.partials.product-actions', ['product' => $product])
                                                </div>
                                                <div class="product-info">
                                                    <div class="element-list element-list-middle">
                                                        <p class="product-cate">{{ $product->category }}</p>
                                                        <h3 class="product-title"><a href="{{ url('/product/' . $product->slug) }}">{{ $product->name }}</a></h3>
                                                        <div class="product-bottom">
                                                            <div class="product-price">
                                                                @if($product->sale_price)
                                                                    <span class="red">Rs. {{ number_format($product->sale_price, 0) }}</span>
                                                                    <span class="old">Rs. {{ number_format($product->price, 0) }}</span>
                                                                @else
                                                                    <span>Rs. {{ number_format($product->price, 0) }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    @else
                                        <div class="col-xs-12" style="padding:40px;text-align:center;color:#999">
                                            <i class="fas fa-box-open" style="font-size:36px;margin-bottom:10px;display:block"></i>
                                            No products in <strong>{{ $cat }}</strong> yet.<br>
                                            <small>Add products from the <a href="{{ url('/admin') }}" style="color:#f96f5d">Admin Panel</a></small>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            @php $firstCat2 = false; @endphp
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End feature product -->
        <!-- Promo banner -->
        <div class="homepage-banner spc3">
            <div class="container container-240">
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <div class="banner-img effect-img3 plus-zoom" style="background:#f4f6fb url('{{ asset('img/banner/h2_b4.jpg') }}') center/cover no-repeat;border-radius:6px;aspect-ratio:1000/558;width:100%">
                            <a href="{{ url('/flash-deals') }}" style="display:block;width:100%;height:100%"></a>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <div class="banner-img effect-img3 plus-zoom" style="background:#f4f6fb url('{{ asset('img/banner/h2_b5.jpg') }}') center/cover no-repeat;border-radius:6px;aspect-ratio:1000/558;width:100%">
                            <a href="{{ url('/tech-discovery') }}" style="display:block;width:100%;height:100%"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Promo banner -->
        <!-- best seller -->
        <div class="feature-product spc3">
            <div class="container container-240">
                <div class="ecome-heading style2">
                    <h1>All Products</h1>
                    <a href="{{ url('/shop') }}" class="btn-show">Shop more<i class="ion-ios-arrow-forward"></i></a>
                </div>
                <p class="ecome-info spc3">Explore everything we carry in one place</p>

                @if($allProducts->count())
                <div class="owl-carousel owl-theme owl-cate v2 js-owl-allproducts">
                    @foreach($allProducts as $product)
                    <div class="product-item">
                        <div class="pd-bd product-inner">
                            <div class="product-img">
                                <a href="{{ url('/product/' . $product->slug) }}" class="js-quickview"
                                   data-id="{{ $product->id }}"
                                   data-name="{{ $product->name }}"
                                   data-cate="{{ $product->category }}"
                                   data-brand="{{ $product->brand }}"
                                   data-stock="{{ $product->stock }}"
                                   data-price="Rs. {{ number_format($product->sale_price ?: $product->price, 0) }}"
                                   data-price-raw="{{ $product->sale_price ?: $product->price }}"
                                   data-oldprice="{{ $product->sale_price ? 'Rs. ' . number_format($product->price, 0) : '' }}"
                                   data-desc="{{ Str::limit(trim(strip_tags(str_replace(['\r\n', '\n'], ' ', $product->short_description ?: $product->description))), 180) }}"
                                   data-image="{{ $product->image ? Storage::url($product->image) : asset('img/product/pd1.jpg') }}"
                                   data-url="{{ url('/product/' . $product->slug) }}">
                                    @if($product->image)
                                        <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="img-reponsive" style="width:100%;height:220px;object-fit:cover">
                                    @else
                                        <img src="{{ asset('img/product/pd1.jpg') }}" alt="{{ $product->name }}" class="img-reponsive" style="width:100%;height:220px;object-fit:cover">
                                    @endif
                                </a>
                                @if($product->is_on_sale && $product->sale_price)
                                    @php $disc = round((1 - $product->sale_price/$product->price)*100); @endphp
                                    <div class="ribbon-price red"><span>- {{ $disc }}%</span></div>
                                @endif
                                @include('layouts.partials.product-actions', ['product' => $product])
                            </div>
                            <div class="product-info">
                                <div class="element-list element-list-middle">
                                    <p class="product-cate">{{ $product->category }}</p>
                                    <h3 class="product-title"><a href="{{ url('/product/' . $product->slug) }}">{{ $product->name }}</a></h3>
                                    @if($product->short_description)
                                        <div class="element-list element-list-left">
                                            <p style="font-size:12px;color:#888;margin-bottom:6px">{{ Str::limit($product->short_description, 60) }}</p>
                                        </div>
                                    @endif
                                    <div class="product-bottom">
                                        <div class="product-price">
                                            @if($product->sale_price)
                                                <span class="red">Rs. {{ number_format($product->sale_price, 0) }}</span>
                                                <span class="old">Rs. {{ number_format($product->price, 0) }}</span>
                                            @else
                                                <span>Rs. {{ number_format($product->price, 0) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div style="padding:40px;text-align:center;color:#999">
                    <i class="fas fa-box-open" style="font-size:36px;margin-bottom:10px;display:block"></i>
                    No products yet.<br>
                    <small>Add products from the <a href="{{ url('/admin') }}" style="color:#f96f5d">Admin Panel</a></small>
                </div>
                @endif
            </div>
        </div>
        <!-- End best seller -->
        <!-- Our blog -->
        @php
            $latestBlogPosts = \App\Models\BlogPost::where('status', 'active')->latest('published_at')->take(8)->get();
        @endphp
        @if($latestBlogPosts->count())
        <div class="our-blog bg">
            <div class="container container-240">
                <div class="ecome-heading style2">
                    <h1 class="v2">From Our Blog</h1>
                    <a href="{{ url('/blog') }}" class="btn-show">View more<i class="ion-ios-arrow-forward"></i></a>
                </div>
                <p class="ecome-info spc2">Buying guides and tips on smart watches, gaming gear, airbuds and more</p>
                <div class="product-tab-pd owl-carousel owl-theme js-owl-blog owl-custom-dots v2">
                    @foreach($latestBlogPosts as $post)
                    <div class="blog-post-item v3">
                        <div class="blog-img" style="width:100%; max-width:440px; height:345px; overflow:hidden; border-radius:10px;">
                            <a href="{{ url('/blog/' . $post->slug) }}" class="hover-images" style="display:block; width:100%; height:100%;">
                                <img src="{{ $post->image ? \Illuminate\Support\Facades\Storage::url($post->image) : asset('img/blog/h2_blog1.jpg') }}" alt="{{ $post->title }}" width="440" height="345" style="width:100%; height:345px; object-fit:cover; border-radius:10px;" class="img-reponsive">
                            </a>
                        </div>
                        <div class="heading-blog flex align-center">
                            <div class="blog-post-date e-gradient">
                                <span class="b-date">{{ optional($post->published_at)->format('d') }}</span>
                                <span class="b-month">{{ optional($post->published_at)->format('M') }}</span>
                            </div>
                            <h3 class="blog-post-title"><a href="{{ url('/blog/' . $post->slug) }}">{{ $post->title }}</a></h3>
                        </div>
                        <p class="blog-post-desc">{{ $post->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($post->body), 120) }}</p>
                        <div class="blog-post-author">
                            <div class="author">Posted by <span class="c-black">{{ $post->author_name }}</span></div>
                            @if($post->category)<div class="blog-post-comment"><span class="c-black"></span>{{ $post->category }}</div>@endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
        <!-- End blog -->
        <!-- e-category  -->
        @php
            $eCatFeatured  = \App\Models\Product::where('status','active')->where('is_featured',true)->latest()->limit(3)->get();
            $eCatOnSale    = \App\Models\Product::where('status','active')->where('is_on_sale',true)->latest()->limit(3)->get();
            $eCatLatest    = \App\Models\Product::where('status','active')->latest()->limit(3)->get();
            $showECat      = $eCatFeatured->count() || $eCatOnSale->count() || $eCatLatest->count();
        @endphp
        @if($showECat)
        <div class="e-category">
            <div class="container container-240">
                <div class="row">

                    {{-- Column 1: Featured --}}
                    @if($eCatFeatured->count())
                    <div class="col-xs-12 col-sm-4 col-md-4">
                        <h1 class="cate-title">Featured Products</h1>
                        @foreach($eCatFeatured as $p)
                        <div class="cate-item">
                            <div class="product-img">
                                <a href="{{ url('/shop') }}">
                                    @if($p->image)
                                        <img src="{{ Storage::url($p->image) }}" alt="{{ $p->name }}" class="img-reponsive" style="width:80px;height:80px;object-fit:cover">
                                    @else
                                        <img src="{{ asset('img/product/pd1.jpg') }}" alt="{{ $p->name }}" class="img-reponsive">
                                    @endif
                                </a>
                            </div>
                            <div class="product-info">
                                <h3 class="product-title"><a href="{{ url('/shop') }}">{{ $p->name }}</a></h3>
                                <div class="product-price v2">
                                    @if($p->sale_price)
                                        <span class="red">Rs. {{ number_format($p->sale_price,0) }}</span>
                                        <span class="old" style="font-size:12px;text-decoration:line-through;color:#aaa">Rs. {{ number_format($p->price,0) }}</span>
                                    @else
                                        <span>Rs. {{ number_format($p->price,0) }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif

                    {{-- Column 2: On Sale --}}
                    @if($eCatOnSale->count())
                    <div class="col-xs-12 col-sm-4 col-md-4">
                        <h1 class="cate-title">On Sale Now</h1>
                        @foreach($eCatOnSale as $p)
                        <div class="cate-item">
                            <div class="product-img">
                                <a href="{{ url('/shop') }}">
                                    @if($p->image)
                                        <img src="{{ Storage::url($p->image) }}" alt="{{ $p->name }}" class="img-reponsive" style="width:80px;height:80px;object-fit:cover">
                                    @else
                                        <img src="{{ asset('img/product/pd1.jpg') }}" alt="{{ $p->name }}" class="img-reponsive">
                                    @endif
                                </a>
                            </div>
                            <div class="product-info">
                                <h3 class="product-title"><a href="{{ url('/shop') }}">{{ $p->name }}</a></h3>
                                <div class="product-price v2">
                                    @if($p->sale_price)
                                        <span class="red">Rs. {{ number_format($p->sale_price,0) }}</span>
                                        <span class="old" style="font-size:12px;text-decoration:line-through;color:#aaa">Rs. {{ number_format($p->price,0) }}</span>
                                    @else
                                        <span>Rs. {{ number_format($p->price,0) }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif

                    {{-- Column 3: Latest --}}
                    @if($eCatLatest->count())
                    <div class="col-xs-12 col-sm-4 col-md-4">
                        <h1 class="cate-title">New Arrivals</h1>
                        @foreach($eCatLatest as $p)
                        <div class="cate-item">
                            <div class="product-img">
                                <a href="{{ url('/shop') }}">
                                    @if($p->image)
                                        <img src="{{ Storage::url($p->image) }}" alt="{{ $p->name }}" class="img-reponsive" style="width:80px;height:80px;object-fit:cover">
                                    @else
                                        <img src="{{ asset('img/product/pd1.jpg') }}" alt="{{ $p->name }}" class="img-reponsive">
                                    @endif
                                </a>
                            </div>
                            <div class="product-info">
                                <h3 class="product-title"><a href="{{ url('/shop') }}">{{ $p->name }}</a></h3>
                                <div class="product-price v2">
                                    @if($p->sale_price)
                                        <span class="red">Rs. {{ number_format($p->sale_price,0) }}</span>
                                        <span class="old" style="font-size:12px;text-decoration:line-through;color:#aaa">Rs. {{ number_format($p->price,0) }}</span>
                                    @else
                                        <span>Rs. {{ number_format($p->price,0) }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif

                </div>
            </div>
        </div>
        @endif
<script>
document.addEventListener('DOMContentLoaded', function () {
    jQuery(function ($) {
        $('.js-owl-allproducts').owlCarousel({
            margin: 30,
            autoplay: true,
            autoplayTimeout: 3000,
            autoplayHoverPause: true,
            loop: true,
            dots: false,
            nav: true,
            navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
            responsive: {
                0:    { items: 1 },
                480:  { items: 2 },
                1024: { items: 3 },
                1200: { items: 3 },
                1600: { items: 3, margin: 40 }
            }
        });
    });
});
</script>
@endsection
