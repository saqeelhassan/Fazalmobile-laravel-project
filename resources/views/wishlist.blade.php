@php
    $pageTitle    = 'My Wishlist — Fazal Mobiles';
    $currentPage  = 'shop';
    $headerClass  = 'header-v5';
    $extraCss     = [];
    $extraScripts = [];
@endphp
@extends('layouts.app')

@section('content')
<!--content-->
        <div class="container container-240">
            
            <div class="checkout wishlist">
                <ul class="breadcrumb v3">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li class="active">Wishlist</li>
                </ul>

                <div class="shopping-cart v2 bd-7">
                    <div class="cmt-title text-center abs">
                        <h1 class="page-title v4">Wishlist</h1>
                    </div>
                    <div id="fmWishlistEmpty" style="text-align:center;padding:50px 20px 60px;color:#9ca3af;display:none">
                        <i class="ion-ios-heart-outline" style="font-size:52px;display:block;margin-bottom:15px;color:#d1d5db"></i>
                        <h3 style="font-size:20px;color:#3a3d4a;margin-bottom:8px">Your wishlist is empty</h3>
                        <p style="margin-bottom:22px">Browse the shop and tap the heart on products you love.</p>
                        <a href="{{ url('/shop') }}" class="btn-gradient" style="display:inline-block;width:177px;height:50px;line-height:50px;font-size:16px;font-weight:600;text-align:center;border-radius:999px;color:#fff;text-decoration:none">Shop now</a>
                    </div>
                    <div id="fmWishlistItems" style="padding:10px 0"></div>
                </div>
            </div>
        </div>
@include('layouts.partials.ecategory')
<script>
document.addEventListener('DOMContentLoaded', function () {
jQuery(function ($) {
    function render() {
        var list = (window.fmGetWishlist ? window.fmGetWishlist() : []);
        var $items = $('#fmWishlistItems');
        var $empty = $('#fmWishlistEmpty');
        if (!list.length) {
            $items.empty();
            $empty.show();
            return;
        }
        $empty.hide();
        $items.html(list.map(function (i) {
            return '<div class="item_cart" style="display:flex;align-items:center;padding:14px 10px;border-bottom:1px solid #f0f0f0;gap:14px">' +
                '<a href="#" class="js-remove-wishlist" data-id="' + i.id + '" title="Remove" style="color:#c0392b;font-size:20px;line-height:1"><i class="ion-ios-close-empty"></i></a>' +
                '<img src="' + i.image + '" alt="" style="width:64px;height:64px;object-fit:cover;border-radius:6px">' +
                '<div style="flex:1"><a href="' + i.url + '" style="color:#1c1c28;font-weight:600">' + i.name + '</a>' +
                '<div style="color:#6b6f7e;font-size:13px">Rs. ' + Number(i.price).toLocaleString() + '</div></div>' +
                '<a href="#" class="btn-gradient js-move-to-cart" data-id="' + i.id + '" style="display:inline-block;padding:0 18px;height:38px;line-height:38px;border-radius:999px;color:#fff;font-size:13px;font-weight:600;text-decoration:none">Add to Cart</a>' +
                '</div>';
        }).join(''));
    }

    $(document).on('click', '.js-remove-wishlist', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        var list = window.fmGetWishlist().filter(function (i) { return String(i.id) !== String(id); });
        window.fmSaveWishlist(list);
        render();
    });

    $(document).on('click', '.js-move-to-cart', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        var item = window.fmGetWishlist().find(function (i) { return String(i.id) === String(id); });
        if (!item) return;
        var cart = window.fmGetCart();
        var existing = cart.find(function (i) { return String(i.id) === String(item.id); });
        if (existing) { existing.qty = (existing.qty || 1) + 1; }
        else { item.qty = 1; cart.push(item); }
        window.fmSaveCart(cart);
        window.fmToast(item.name + ' added to cart.');
    });

    window.fmRenderWishlistPage = render;
    render();
});
});
</script>
@endsection
