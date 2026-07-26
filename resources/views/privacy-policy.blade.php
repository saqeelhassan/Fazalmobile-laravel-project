@include('layouts.partials.config')
@php
    $pageTitle    = 'Privacy Policy — Fazal Mobiles';
    $currentPage  = 'pages';
    $headerClass  = 'header-v5';
    $extraCss     = [];
    $extraScripts = [];
@endphp
@extends('layouts.app')

@section('content')
<!--content-->
        <div class="container container-240">
            <div class="pd-banner v2">
               <a href="#" class="image-bd effect_img2"><img src="{{ asset('img/o-banner.jpg') }}" alt="" class="img-reponsive"></a>
            </div>
            <ul class="breadcrumb">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li class="active">Privacy Policy</li>
            </ul>
        </div>

        <div class="aboutus">
            <div class="about-content">
                <div class="container container-240">
                    <div class="entry-inside v4 text-center">
                        <h1 class="entry-title v2 spc">Privacy Policy</h1>
                        <p class="about-desc spc" style="max-width:720px;margin:0 auto">
                            This policy explains what information we collect on Fazal Mobiles, how we use it, and the choices you have.
                        </p>
                    </div>
                </div>

                <div class="container container-240" style="max-width:900px">
                    <div style="margin-bottom:30px">
                        <h3 class="about-title spc">Information We Collect</h3>
                        <p class="about-desc spc">When you place an order, create an account, or contact us, we collect information such as your name, phone number, email address, shipping address, and order details. When you browse our store, we may also collect basic technical information like your device type and IP address to keep the site working properly.</p>
                    </div>
                    <div style="margin-bottom:30px">
                        <h3 class="about-title spc">How We Use Your Information</h3>
                        <p class="about-desc spc">We use your information to process and deliver your orders, communicate with you about your purchase, provide customer support, and — if you've opted in — send you updates about promotions and new products. We do not sell your personal information to third parties.</p>
                    </div>
                    <div style="margin-bottom:30px">
                        <h3 class="about-title spc">Payment Information</h3>
                        <p class="about-desc spc">Online payments are processed through secure, encrypted payment gateways. We do not store your full card details on our servers.</p>
                    </div>
                    <div style="margin-bottom:30px">
                        <h3 class="about-title spc">Sharing Your Information</h3>
                        <p class="about-desc spc">We share your order details with our courier partners solely to deliver your purchase, and with payment providers to process transactions. We do not share your personal information with anyone else except where required by law.</p>
                    </div>
                    <div style="margin-bottom:30px">
                        <h3 class="about-title spc">Cookies</h3>
                        <p class="about-desc spc">Our website uses cookies to remember items in your cart, keep you signed in, and understand how visitors use our site so we can improve it. You can disable cookies in your browser settings, though some features may not work as expected.</p>
                    </div>
                    <div style="margin-bottom:30px">
                        <h3 class="about-title spc">Your Choices</h3>
                        <p class="about-desc spc">You can update your account details at any time from <a href="{{ url('/my-account') }}">My Account</a>, and you can unsubscribe from marketing emails using the link in any newsletter we send. To request access to or deletion of your personal data, contact us using the details below.</p>
                    </div>
                    <div style="margin-bottom:10px">
                        <h3 class="about-title spc">Contact Us</h3>
                        <p class="about-desc spc">If you have questions about this Privacy Policy or how your information is handled, reach out at {{ SITE_EMAIL }} or {{ SITE_PHONE }}.</p>
                    </div>
                </div>
            </div>
        </div>
@endsection
