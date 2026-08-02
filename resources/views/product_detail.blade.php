@php
    use Illuminate\Support\Str;
    use Illuminate\Support\Facades\Storage;
    $pageTitle    = $product->name . ' — Fazal Mobiles';
    $currentPage  = 'shop';
    $headerClass  = 'header-v2';
    $extraCss     = [];
    $extraScripts = [];

    $mainImg  = $product->image ? Storage::url($product->image) : asset('img/product/img-1.jpg');
    $gallery  = collect($product->gallery ?? [])->map(fn($g) => Storage::url($g))->prepend($mainImg)->unique()->values();
    $waNumber = '923095179899';
    $waText   = rawurlencode('Hello! I want to order: ' . $product->name . ' (' . url('/product/' . $product->slug) . ')');

    // Descriptions come from admin with HTML tags and literal "\n" sequences
    $cleanNl   = fn($t) => str_replace(['\r\n', '\n'], "\n", (string) $t);
    $shortDesc = $cleanNl($product->short_description);
    $longDesc  = $cleanNl($product->description);
@endphp
@extends('layouts.app')

@section('content')
<style>
    .pdp-wrap { padding: 30px 0 10px; }
    .pdp-main-img {
        width: 100%;
        height: 420px;
        background: #f8f8f8;
        border: 1px solid #eee;
        border-radius: 8px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .pdp-main-img img { width: 100%; height: 100%; object-fit: contain; }
    .pdp-thumbs { display: flex; gap: 10px; margin-top: 12px; flex-wrap: wrap; }
    .pdp-thumbs a {
        display: block;
        width: 72px; height: 72px;
        border: 2px solid #eee;
        border-radius: 6px;
        overflow: hidden;
        background: #f8f8f8;
    }
    .pdp-thumbs a.active { border-color: #f96f5d; }
    .pdp-thumbs img { width: 100%; height: 100%; object-fit: cover; }
    .pdp-cate { color: #f96f5d; font-size: 12px; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 8px; }
    .pdp-name { font-size: 28px; color: #1c1c28; line-height: 1.3; margin: 0 0 15px; font-weight: 700; }
    .pdp-price { font-size: 26px; font-weight: 700; color: #1c1c28; margin-bottom: 18px; }
    .pdp-price .old { font-size: 17px; color: #9ca3af; text-decoration: line-through; font-weight: 400; margin-left: 10px; }
    .pdp-price .save { font-size: 12px; background: #ef4444; color: #fff; border-radius: 20px; padding: 3px 10px; margin-left: 10px; vertical-align: 4px; }
    .pdp-short { color: #6b6f7e; font-size: 15px; line-height: 1.8; margin-bottom: 20px; }
    .pdp-meta { list-style: none; padding: 15px 0; margin: 0 0 22px; border-top: 1px solid #eee; border-bottom: 1px solid #eee; }
    .pdp-meta li { font-size: 14px; color: #3a3d4a; padding: 4px 0; }
    .pdp-meta li span { color: #9ca3af; display: inline-block; width: 110px; }
    .pdp-stock-in  { color: #16a34a; font-weight: 600; }
    .pdp-stock-out { color: #ef4444; font-weight: 600; }
    .pdp-btns { display: flex; gap: 12px; flex-wrap: wrap; }
    .pdp-btn {
        display: inline-block;
        border-radius: 999px;
        padding: 0 30px;
        height: 48px;
        line-height: 48px;
        font-size: 15px;
        font-weight: 600;
        color: #fff !important;
        text-decoration: none !important;
    }
    .pdp-btn-wa { background: #25d366; }
    .pdp-btn-wa:hover { box-shadow: 0 2px 18px rgba(37, 211, 102, 0.5); }
    .pdp-btn-call { background: #1c1c28; }
    .pdp-btn-call:hover { box-shadow: 0 2px 18px rgba(28, 28, 40, 0.4); }
    .pdp-btn-cart { background: #6c63ff; border: none; cursor: pointer; }
    .pdp-btn-cart:hover { box-shadow: 0 2px 18px rgba(108, 99, 255, 0.5); }
    .pdp-btn-cart:disabled { opacity: .5; cursor: not-allowed; box-shadow: none !important; }
    .pdp-btn-wish {
        width: 48px; height: 48px; border-radius: 50%;
        display: inline-flex; align-items: center; justify-content: center;
        background: #f3f4f6; color: #333 !important; font-size: 21px;
        text-decoration: none !important; flex-shrink: 0;
    }
    .pdp-btn-wish:hover { background: #fee2e2; }
    .pdp-btn-wish.active { color: #fb2637 !important; background: #fee2e2; }
    .pdp-btn-view-cart { background: #16a34a; display: none; }
    .pdp-btn-view-cart.show { display: inline-block; }
    .pdp-desc { margin: 40px 0 20px; }
    .pdp-desc h2 { font-size: 20px; font-weight: 700; color: #1c1c28; border-bottom: 2px solid #f96f5d; display: inline-block; padding-bottom: 8px; margin-bottom: 18px; }
    .pdp-desc-body { color: #555; font-size: 15px; line-height: 1.9; white-space: pre-line; }
    .pdp-related { margin: 30px 0 10px; }
    .pdp-related h2 { font-size: 20px; font-weight: 700; color: #1c1c28; margin-bottom: 20px; }
    @media (max-width: 767px) {
        .pdp-main-img { height: 300px; }
        .pdp-name { font-size: 22px; }
    }
</style>
<div class="container container-240 pdp-wrap">
    <ul class="breadcrumb">
        <li><a href="{{ url('/') }}">Home</a></li>
        <li><a href="{{ url('/shop') }}">Shop</a></li>
        <li class="active">{{ Str::limit($product->name, 40) }}</li>
    </ul>

    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-5">
            <div class="pdp-main-img">
                <img id="pdpMainImg" src="{{ $gallery->first() }}" alt="{{ $product->name }}">
            </div>
            @if($gallery->count() > 1)
            <div class="pdp-thumbs">
                @foreach($gallery as $i => $g)
                <a href="#" class="js-pdp-thumb {{ $i === 0 ? 'active' : '' }}" data-img="{{ $g }}">
                    <img src="{{ $g }}" alt="{{ $product->name }}">
                </a>
                @endforeach
            </div>
            @endif
        </div>

        <div class="col-xs-12 col-sm-6 col-md-7">
            <p class="pdp-cate">{{ $product->category }}</p>
            <h1 class="pdp-name">{{ $product->name }}</h1>
            <div class="pdp-price">
                @if($product->sale_price)
                    Rs. {{ number_format($product->sale_price, 0) }}
                    <span class="old">Rs. {{ number_format($product->price, 0) }}</span>
                    <span class="save">-{{ round((1 - $product->sale_price / $product->price) * 100) }}%</span>
                @else
                    Rs. {{ number_format($product->price, 0) }}
                @endif
            </div>

            @if($product->short_description)
                <div class="pdp-short" style="white-space:pre-line">{!! $shortDesc !!}</div>
            @endif

            <ul class="pdp-meta">
                <li>
                    <span>Availability:</span>
                    @if($product->stock > 0)
                        <em class="pdp-stock-in" style="font-style:normal">In Stock ({{ $product->stock }} available)</em>
                    @else
                        <em class="pdp-stock-out" style="font-style:normal">Out of Stock</em>
                    @endif
                </li>
                @if($product->sku)<li><span>SKU:</span> {{ $product->sku }}</li>@endif
                @if($product->brand)<li><span>Brand:</span> {{ $product->brand }}</li>@endif
                <li><span>Category:</span> <a href="{{ url('/shop') }}?category={{ urlencode($product->category) }}">{{ $product->category }}</a></li>
            </ul>

            <div class="pdp-btns">
                <button type="button" class="pdp-btn pdp-btn-cart js-add-to-cart" data-view-cart-target="#pdpViewCart"
                    data-id="{{ $product->id }}"
                    data-name="{{ $product->name }}"
                    data-price="{{ $product->sale_price ?: $product->price }}"
                    data-image="{{ $mainImg }}"
                    data-url="{{ url('/product/' . $product->slug) }}"
                    data-stock="{{ $product->stock }}"
                    {{ $product->stock == 0 ? 'disabled' : '' }}>
                    <i class="ion-ios-cart-outline"></i> &nbsp;{{ $product->stock > 0 ? 'Add to Cart' : 'Out of Stock' }}
                </button>
                <a href="#" class="pdp-btn-wish js-wishlist-toggle" title="Add to Wishlist"
                    data-id="{{ $product->id }}"
                    data-name="{{ $product->name }}"
                    data-price="{{ $product->sale_price ?: $product->price }}"
                    data-image="{{ $mainImg }}"
                    data-url="{{ url('/product/' . $product->slug) }}">
                    <i class="ion-ios-heart-outline"></i>
                </a>
                <a href="{{ url('/cart') }}" id="pdpViewCart" class="pdp-btn pdp-btn-view-cart">
                    <i class="ion-ios-checkmark-outline"></i> &nbsp;View Cart
                </a>
                <a href="https://wa.me/{{ $waNumber }}?text={{ $waText }}" target="_blank" rel="noopener" class="pdp-btn pdp-btn-wa">
                    <i class="fa fa-whatsapp"></i> &nbsp;Order on WhatsApp
                </a>
                <a href="tel:+{{ $waNumber }}" class="pdp-btn pdp-btn-call">
                    <i class="fa fa-phone"></i> &nbsp;Call to Order
                </a>
            </div>
        </div>
    </div>

    @if($product->description)
    <div class="pdp-desc">
        <h2>Description</h2>
        <div class="pdp-desc-body">{!! $longDesc !!}</div>
    </div>
    @endif

    @if($related->count())
    <div class="pdp-related">
        <h2>Related Products</h2>
        <div class="row equal-cards">
            @foreach($related as $rel)
            <div class="col-xs-6 col-sm-3 col-md-3 product-item">
                <div class="product-inner">
                    <div class="product-img" style="position:relative;width:100%;height:220px;overflow:hidden;background:#f8f8f8">
                        <a href="{{ url('/product/' . $rel->slug) }}">
                            @if($rel->image)
                                <img src="{{ Storage::url($rel->image) }}" alt="{{ $rel->name }}" style="width:100%;height:220px;object-fit:cover;object-position:center">
                            @else
                                <img src="{{ asset('img/product/img-1.jpg') }}" alt="{{ $rel->name }}" style="width:100%;height:220px;object-fit:cover;object-position:center">
                            @endif
                        </a>
                        @include('layouts.partials.product-actions', ['product' => $rel])
                    </div>
                    <div class="pd-bd">
                        <h3 class="pd-title"><a href="{{ url('/product/' . $rel->slug) }}">{{ $rel->name }}</a></h3>
                        <div class="pd-price">
                            @if($rel->sale_price)
                                <span>Rs. {{ number_format($rel->sale_price, 0) }}</span>
                                <del>Rs. {{ number_format($rel->price, 0) }}</del>
                            @else
                                <span>Rs. {{ number_format($rel->price, 0) }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
<script>
    document.addEventListener('click', function (e) {
        var thumb = e.target.closest('.js-pdp-thumb');
        if (!thumb) return;
        e.preventDefault();
        document.getElementById('pdpMainImg').src = thumb.getAttribute('data-img');
        document.querySelectorAll('.js-pdp-thumb').forEach(function (t) { t.classList.remove('active'); });
        thumb.classList.add('active');
    });
</script>
@endsection
