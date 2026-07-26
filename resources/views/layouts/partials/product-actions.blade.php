@once
<style>
    .pa-group {
        position: absolute;
        left: 50%;
        bottom: 14px;
        transform: translateX(-50%) translateY(12px);
        display: flex;
        gap: 8px;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
        z-index: 6;
    }
    .product-img:hover .pa-group {
        opacity: 1;
        visibility: visible;
        transform: translateX(-50%) translateY(0);
    }
    .pa-btn {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: #fff;
        color: #333 !important;
        font-size: 19px;
        line-height: 38px;
        text-align: center;
        display: inline-block;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.15);
        transition: all 0.25s ease;
        text-decoration: none !important;
    }
    .pa-btn:hover {
        color: #fff !important;
        background: #c26af5;
        background-image: linear-gradient(122deg, #c26af5, #54f0ff);
        box-shadow: 0 6px 18px rgba(108, 99, 255, 0.45);
        transform: translateY(-3px);
    }
    .pa-btn.js-wishlist-toggle.active { color: #fb2637 !important; }
    .pa-btn.js-wishlist-toggle.active:hover { color: #fff !important; }
    .pa-btn.js-add-to-cart.added { color: #16a34a !important; }
    /* Touch devices have no hover — keep the buttons visible */
    @media (hover: none), (max-width: 767px) {
        .pa-group {
            opacity: 1;
            visibility: visible;
            transform: translateX(-50%) translateY(0);
        }
        .pa-btn { width: 34px; height: 34px; line-height: 34px; font-size: 17px; }
    }
</style>
@endonce
@php
    $paDesc = \Illuminate\Support\Str::limit(trim(strip_tags(str_replace(['\r\n', '\n'], ' ', $product->short_description ?: $product->description))), 180);
    $paImg  = $product->image ? \Illuminate\Support\Facades\Storage::url($product->image) : asset('img/product/img-1.jpg');
    $paUrl  = url('/product/' . $product->slug);
@endphp
<div class="pa-group">
    <a href="#" class="pa-btn js-quickview" title="Quick View"
       data-name="{{ $product->name }}"
       data-cate="{{ $product->category }}"
       data-brand="{{ $product->brand }}"
       data-stock="{{ $product->stock }}"
       data-price="Rs. {{ number_format($product->sale_price ?: $product->price, 0) }}"
       data-oldprice="{{ $product->sale_price ? 'Rs. ' . number_format($product->price, 0) : '' }}"
       data-desc="{{ $paDesc }}"
       data-image="{{ $paImg }}"
       data-url="{{ $paUrl }}"><i class="ion-ios-eye-outline"></i></a>
    <a href="#" class="pa-btn js-wishlist-toggle" title="Add to Wishlist"
       data-id="{{ $product->id }}"
       data-name="{{ $product->name }}"
       data-price="{{ $product->sale_price ?: $product->price }}"
       data-image="{{ $paImg }}"
       data-url="{{ $paUrl }}"><i class="ion-ios-heart-outline"></i></a>
    <a href="#" class="pa-btn js-add-to-cart" title="Add to Cart"
       data-id="{{ $product->id }}"
       data-name="{{ $product->name }}"
       data-price="{{ $product->sale_price ?: $product->price }}"
       data-image="{{ $paImg }}"
       data-url="{{ $paUrl }}"
       data-stock="{{ $product->stock }}"><i class="ion-ios-cart-outline"></i></a>
</div>
