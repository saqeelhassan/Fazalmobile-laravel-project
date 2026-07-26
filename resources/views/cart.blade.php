@php
    $pageTitle    = 'Shopping Cart — Fazal Mobiles';
    $currentPage  = 'shop';
    $headerClass  = 'header-v5';
    $extraCss     = [];
    $extraScripts = [];
@endphp
@extends('layouts.app')

@section('content')
<!--content-->
        <div class="container container-240">
            
            <div class="checkout">
                <ul class="breadcrumb v3">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li class="active">Cart</li>
                </ul>
                <div class="row">
                    <div class="col-md-8 col-sm-12 col-xs-12">
                        <div class="shopping-cart bd-7">
                            <div class="cmt-title text-center abs">
                                <h1 class="page-title v2">Cart</h1>
                            </div>
                            <div id="fmCartEmpty" style="text-align:center;padding:50px 20px;color:#9ca3af;display:none">
                                <i class="ion-ios-cart-outline" style="font-size:52px;display:block;margin-bottom:15px;color:#d1d5db"></i>
                                <h3 style="font-size:20px;color:#3a3d4a;margin-bottom:8px">Your cart is empty</h3>
                                <a href="{{ url('/shop') }}" class="btn-gradient" style="display:inline-block;width:177px;height:50px;line-height:50px;font-size:16px;font-weight:600;text-align:center;border-radius:999px;color:#fff;text-decoration:none">Shop now</a>
                            </div>
                            <div class="table-responsive" id="fmCartTableWrap">
                                <table class="table cart-table">
                                    <tbody id="fmCartRows"></tbody>
                                </table>
                            </div>
                            <div class="table-cart-bottom">
                                
                                    <form class="form_coupon" action="#" method="post">
                                        <input type="email" value="" placeholder="Coupon code" name="EMAIL" id="mail" class="newsletter-input form-control">
                                        <div class="input-icon">
                                            <img src="{{ asset('img/coupon-icon.png') }}" alt="">
                                        </div>
                                        <button id="subscribe2" class="button_mini btn" type="submit">
                                            Apply coupon
                                        </button>
                                    </form>
                                
                                <a href="#" class="btn btn-update">Update cart</a> 
                            </div>
            
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 col-xs-12">
                        <div class="cart-total bd-7">
                            <div class="cmt-title text-center abs">
                                <h1 class="page-title v3">Cart totals</h1>
                            </div>
                            <div class="table-responsive">
                                <table class="shop_table">
                                    <tbody>
                                        <tr class="cart-subtotal">
                                            <th>Subtotal</th>
                                            <td id="fmCartSubtotal">Rs. 0</td>
                                        </tr>
                                        <tr class="order-total">
                                            <th>Total</th>
                                            <td id="fmCartTotal">Rs. 0</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="cart-total-bottom">
                                <a href="{{ url('/checkout') }}" class="btn-gradient btn-checkout">Proceed to checkout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<script>
document.addEventListener('DOMContentLoaded', function () {
jQuery(function ($) {
    function render() {
        var cart = (window.fmGetCart ? window.fmGetCart() : []);
        var $rows = $('#fmCartRows');
        if (!cart.length) {
            $('#fmCartTableWrap').hide();
            $('#fmCartEmpty').show();
            $('#fmCartSubtotal, #fmCartTotal').text('Rs. 0');
            return;
        }
        $('#fmCartEmpty').hide();
        $('#fmCartTableWrap').show();

        $rows.html(cart.map(function (i) {
            return '<tr class="item_cart" data-id="' + i.id + '">' +
                '<td class="product-name flex align-center">' +
                '<a href="#" class="btn-del js-remove-cart-item" data-id="' + i.id + '"><i class="ion-ios-close-empty"></i></a>' +
                '<div class="product-img"><img src="' + i.image + '" alt=""></div>' +
                '<div class="product-info"><a href="' + i.url + '">' + i.name + '</a></div>' +
                '</td>' +
                '<td class="bcart-quantity single-product-detail">' +
                '<div class="single-product-info"><div class="e-quantity">' +
                '<input type="number" step="1" min="1" max="999" value="' + (i.qty || 1) + '" title="Qty" class="qty input-text js-cart-qty" data-id="' + i.id + '" size="4">' +
                '</div></div>' +
                '</td>' +
                '<td class="total-price"><p class="price">Rs. ' + Number((i.qty || 1) * i.price).toLocaleString() + '</p></td>' +
                '</tr>';
        }).join(''));

        var subtotal = cart.reduce(function (n, i) { return n + (i.qty || 1) * (parseFloat(i.price) || 0); }, 0);
        $('#fmCartSubtotal, #fmCartTotal').text('Rs. ' + Number(subtotal).toLocaleString());
    }

    $(document).on('click', '.js-remove-cart-item, .btn-del', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        if (id === undefined) return;
        window.fmSaveCart(window.fmGetCart().filter(function (i) { return String(i.id) !== String(id); }));
        render();
    });

    $(document).on('change', '.js-cart-qty', function () {
        var id = $(this).data('id');
        var qty = Math.max(1, parseInt($(this).val(), 10) || 1);
        var cart = window.fmGetCart();
        var item = cart.find(function (i) { return String(i.id) === String(id); });
        if (item) { item.qty = qty; window.fmSaveCart(cart); render(); }
    });

    window.fmRenderCartPage = render;
    render();
});
});
</script>
@endsection
