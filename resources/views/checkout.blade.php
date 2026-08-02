@php
    $pageTitle    = 'Checkout | Fazal Mobile';
    $currentPage  = 'shop';
    $headerClass  = 'header-v5';
    $extraCss     = [];
    $extraScripts = [];
    $u = auth()->check() ? auth()->user() : null;
@endphp
@extends('layouts.app')

@section('content')
<style>
    /* Equal-height "Order Notes" box vs "Your order" box: the row is plain
       floated Bootstrap columns, so each column's height is independent —
       the left column (Billing details + Order Notes stacked) and right
       column (order summary) end at different points. Stretch the left
       column via flex and let "Order Notes" (not "Billing details") absorb
       the extra height so its bottom lines up with the order summary box. */
    /* Bootstrap's .row:before/:after clearfix pseudo-elements become extra
       (blockified) flex items once .row is display:flex, which throws off
       this row's stretch/height calc — strip them for this row. */
    .checkout-equal-row:before,
    .checkout-equal-row:after { content: none; display: none; }
    .checkout-equal-row { display: flex; flex-wrap: wrap; align-items: stretch; }
    .checkout-equal-row > .col-md-8 { display: flex; flex-direction: column; }
    .checkout-equal-row > .col-md-8 > .co-left.bd-7:last-child { flex: 1; display: flex; flex-direction: column; }
    .checkout-equal-row > .col-md-8 > .co-left.bd-7:last-child .form-customer.v2 { flex: 1; display: flex; flex-direction: column; }
    .checkout-equal-row > .col-md-8 > .co-left.bd-7:last-child .form-group { flex: 1; display: flex; flex-direction: column; }
    .checkout-equal-row > .col-md-8 > .co-left.bd-7:last-child textarea.form-note { flex: 1; height: auto; }
    @media (max-width: 991px) {
        .checkout-equal-row { display: block; }
        .checkout-equal-row > .col-md-8 { display: block; }
        .checkout-equal-row > .col-md-8 > .co-left.bd-7:last-child { display: block; }
    }
</style>
<!--content-->
        <div class="main-content space1">
            <div class="container container-240">
                <ul class="breadcrumb">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li class="active">Checkout</li>
                </ul>

                @if(!$u)
                <div class="co-coupon">
                    <div class="row">
                        <div class="checkout-login col-xs-12 col-sm-12">
                            <div class="box-toggle box-login" style="display:flex;align-items:center;gap:10px">
                                <img src="{{ asset('img/co-login.png') }}" alt="">
                                Have an account? <a href="{{ url('/my-account') }}" style="color:#6c63ff;font-weight:600">Sign in for faster checkout</a> — or continue below as a guest.
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger" style="background:#fee2e2;color:#991b1b;padding:14px 18px;border-radius:8px;margin-bottom:18px">{{ session('error') }}</div>
                @endif
                <div id="fmCheckoutEmptyNotice" style="display:none;background:#fef3c7;color:#92400e;padding:14px 18px;border-radius:8px;margin-bottom:18px">
                    Your cart is empty. <a href="{{ url('/shop') }}" style="color:#92400e;font-weight:700;text-decoration:underline">Go shopping</a>
                </div>

                <form name="checkout" method="post" class="co" action="{{ route('checkout.store') }}" id="fmCheckoutForm">
                    @csrf
                    <input type="hidden" name="cart" id="fmCheckoutCartData" value="">
                    <div class="cart-box-container-ver2">
                        <div class="row checkout-equal-row">
                            <div class="col-md-8">
                                <div class="co-left bd-7">
                                    <div class="cmt-title text-center abs">
                                        <h1 class="page-title v1">Billing details</h1>
                                    </div>
                                    <div class="row form-customer">
                                        <div class="form-group col-md-12">
                                            <label class="control-label">Full Name <span class="f-red">*</span></label>
                                            <input type="text" name="customer_name" required maxlength="200"
                                                value="{{ old('customer_name', $u->name ?? '') }}"
                                                class="form-control form-account @error('customer_name') is-invalid @enderror">
                                            @error('customer_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="control-label">Phone <span class="f-red">*</span></label>
                                            <input type="text" name="customer_phone" required maxlength="30"
                                                value="{{ old('customer_phone', $u->phone ?? '') }}"
                                                class="form-control form-account @error('customer_phone') is-invalid @enderror">
                                            @error('customer_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="control-label">Email Address <span class="f-red">*</span></label>
                                            <input type="email" name="customer_email" required maxlength="200"
                                                value="{{ old('customer_email', $u->email ?? '') }}"
                                                class="form-control form-account @error('customer_email') is-invalid @enderror">
                                            @error('customer_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label class="control-label">Delivery Address <span class="f-red">*</span></label>
                                            <textarea name="customer_address" rows="3" required maxlength="500"
                                                placeholder="House / Street, Area, City"
                                                class="form-control form-account @error('customer_address') is-invalid @enderror">{{ old('customer_address', trim(($u->address ?? '').' '.($u->city ?? ''))) }}</textarea>
                                            @error('customer_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="co-left bd-7">
                                    <div class="cmt-title text-center abs">
                                        <h1 class="page-title v5">Order Notes</h1>
                                    </div>
                                    <div class="row form-customer v2">
                                        <div class="form-group col-md-12">
                                            <textarea name="notes" rows="6" id="message" maxlength="1000" class="form-control form-note" placeholder="Notes about your order, e.g. special notes for delivery.">{{ old('notes') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End contact-form -->
                            <div class="col-md-4">
                                <div class="cart-total bd-7">
                                    <div class="cmt-title text-center abs">
                                        <h1 class="page-title v3">Your order</h1>
                                    </div>
                                    <div class="table-responsive">
                                        <div class="co-pd">
                                            <p class="co-title">
                                                Product<span>Total</span>
                                            </p>
                                            <ul class="co-pd-list" id="fmCheckoutItems">
                                            </ul>
                                        </div>
                                        <table class="shop_table">
                                            <tbody>
                                                <tr class="cart-subtotal">
                                                    <th>Subtotal</th>
                                                    <td id="fmCheckoutSubtotal">Rs. 0</td>
                                                </tr>
                                                <tr class="cart-subtotal" id="fmCheckoutDeliveryRow">
                                                    <th>Delivery Charge (COD)</th>
                                                    <td id="fmCheckoutDelivery">Rs. 300</td>
                                                </tr>
                                                <tr class="order-total v2">
                                                    <th>Total</th>
                                                    <td id="fmCheckoutTotal">Rs. 0</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <ul class="payment">
                                        <li>
                                            <input type="radio" name="payment_method" value="cash" id="radio5" checked>
                                            <label for="radio5">Cash on delivery</label>
                                        </li>
                                        <li>
                                            <input type="radio" name="payment_method" value="bank_transfer" id="radio3">
                                            <label for="radio3">Direct bank transfer</label>
                                        </li>
                                    </ul>

                                    <div class="form-check">
                                        <label class="form-check-label ver2">
                                            <input type="checkbox" class="form-check-input" id="fmAcceptTerms" required>
                                            <span>I've read and accept the <a href="{{ route('privacy-policy') }}" class="term" target="_blank">terms & conditions *</a></span>
                                        </label>
                                    </div>
                                    <div class="cart-total-bottom v2">
                                        <button type="submit" class="btn-gradient btn-checkout btn-co-order" id="fmPlaceOrderBtn" style="border:none;cursor:pointer">Place order</button>
                                    </div>
                                    <p style="font-size:11.5px;color:#9ca3af;margin-top:10px;padding:0 20px 30px;text-align:center">
                                        Your order will be reviewed and confirmed by our team. You'll receive an email once it's confirmed.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

<script>
document.addEventListener('DOMContentLoaded', function () {
jQuery(function ($) {
    var DELIVERY_CHARGE = 300;

    function isCod() {
        return $('input[name="payment_method"]:checked').val() === 'cash';
    }

    function renderSummary() {
        var cart = (window.fmGetCart ? window.fmGetCart() : []);
        var $list = $('#fmCheckoutItems');

        if (!cart.length) {
            $('#fmCheckoutEmptyNotice').show();
            $('#fmPlaceOrderBtn').prop('disabled', true).css({opacity: .5, cursor: 'not-allowed'});
        } else {
            $('#fmCheckoutEmptyNotice').hide();
            $('#fmPlaceOrderBtn').prop('disabled', false).css({opacity: 1, cursor: 'pointer'});
        }

        $list.html(cart.map(function (i) {
            return '<li class="clearfix"><div class="co-name">' + i.name + ' &times; ' + (i.qty || 1) +
                '</div><div class="co-price">Rs. ' + Number((i.qty || 1) * i.price).toLocaleString() + '</div></li>';
        }).join(''));

        var subtotal = cart.reduce(function (n, i) { return n + (i.qty || 1) * (parseFloat(i.price) || 0); }, 0);
        var delivery = isCod() ? DELIVERY_CHARGE : 0;

        $('#fmCheckoutDeliveryRow').toggle(isCod());
        $('#fmCheckoutSubtotal').text('Rs. ' + Number(subtotal).toLocaleString());
        $('#fmCheckoutTotal').text('Rs. ' + Number(subtotal + delivery).toLocaleString());
    }

    $('input[name="payment_method"]').on('change', renderSummary);

    $('#fmCheckoutForm').on('submit', function (e) {
        var cart = (window.fmGetCart ? window.fmGetCart() : []);
        if (!cart.length) {
            e.preventDefault();
            if (window.fmToast) window.fmToast('Your cart is empty.', true);
            return;
        }
        $('#fmCheckoutCartData').val(JSON.stringify(cart.map(function (i) {
            return { id: i.id, qty: i.qty || 1 };
        })));
    });

    renderSummary();
});
});
</script>
@endsection
