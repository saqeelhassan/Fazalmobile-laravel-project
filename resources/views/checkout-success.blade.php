@php
    $pageTitle    = 'Order Received | Fazal Mobile';
    $currentPage  = 'shop';
    $headerClass  = 'header-v5';
    $extraCss     = [];
    $extraScripts = [];
@endphp
@extends('layouts.app')

@section('content')
<div class="main-content space1">
    <div class="container container-240">
        <div style="max-width:720px;margin:0 auto;text-align:center;background:#fff;border-radius:14px;box-shadow:0 4px 24px rgba(0,0,0,.06);padding:50px 40px">
            <div style="width:76px;height:76px;border-radius:50%;background:linear-gradient(135deg,#c26af5,#54f0ff);display:flex;align-items:center;justify-content:center;margin:0 auto 22px">
                <i class="ion-checkmark" style="font-size:38px;color:#fff"></i>
            </div>
            <h1 style="font-size:24px;font-weight:700;color:#1f2937;margin-bottom:10px">Thank you, {{ $order->customer_name }}!</h1>
            <p style="color:#6b7280;font-size:14.5px;line-height:1.7;margin-bottom:26px">
                Your order has been received and is now <strong>pending review</strong>.
                Our team will confirm it shortly — you'll get an email at
                <strong>{{ $order->customer_email }}</strong> as soon as it's confirmed.
            </p>

            <div style="background:#f9fafb;border:1px solid #e5e7eb;border-radius:10px;padding:20px 24px;text-align:left;margin-bottom:26px">
                <div style="display:flex;justify-content:space-between;margin-bottom:14px;flex-wrap:wrap;gap:6px">
                    <span style="font-size:13px;color:#6b7280">Order Number</span>
                    <strong style="color:#6c63ff">{{ $order->order_number }}</strong>
                </div>
                <div style="display:flex;justify-content:space-between;margin-bottom:14px">
                    <span style="font-size:13px;color:#6b7280">Status</span>
                    <span style="background:#fef3c7;color:#92400e;padding:2px 12px;border-radius:20px;font-size:12px;font-weight:600">Pending Confirmation</span>
                </div>
                <div style="border-top:1px solid #e5e7eb;margin:14px 0"></div>
                @foreach($order->items as $item)
                <div style="display:flex;justify-content:space-between;font-size:13.5px;color:#374151;padding:5px 0">
                    <span>{{ $item->product_name }} &times; {{ $item->quantity }}</span>
                    <span>Rs. {{ number_format($item->subtotal, 0) }}</span>
                </div>
                @endforeach
                <div style="border-top:1px solid #e5e7eb;margin:14px 0"></div>
                <div style="display:flex;justify-content:space-between">
                    <strong style="font-size:15px">Total</strong>
                    <strong style="font-size:15px;color:#6c63ff">Rs. {{ number_format($order->total_amount, 0) }}</strong>
                </div>
            </div>

            <a href="{{ url('/shop') }}" class="btn-gradient" style="display:inline-block;padding:0 34px;height:50px;line-height:50px;border-radius:999px;color:#fff;text-decoration:none;font-weight:600">Continue Shopping</a>
        </div>
    </div>
</div>
<script>
    try { localStorage.setItem('fm_cart', '[]'); } catch (e) {}
    document.addEventListener('DOMContentLoaded', function () {
        if (window.jQuery) { jQuery('.cart-count').text('0'); }
    });
</script>
@endsection
