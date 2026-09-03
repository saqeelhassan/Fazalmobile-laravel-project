@include('layouts.partials.config')
@php
    $pageTitle    = 'Customer Service — Fazal Mobiles';
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
                <li class="active">Customer Service</li>
            </ul>
        </div>

        <div class="aboutus">
            <div class="about-content">
                <div class="container container-240">
                    <div class="entry-inside v4 text-center">
                        <h1 class="entry-title v2 spc">Customer Service</h1>
                        <p class="about-desc spc" style="max-width:720px;margin:0 auto">
                            We're here to help before and after your purchase. Reach us however's easiest for you.
                        </p>
                    </div>
                </div>

                <div class="container container-240">
                    <div class="row pd1">
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div style="text-align:center;margin-bottom:35px">
                                <h3 class="about-title" style="margin-bottom:8px">Call Us</h3>
                                <p class="about-desc">{{ SITE_PHONE }}<br>Mon–Sat, 9:00am – 5:00pm</p>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div style="text-align:center;margin-bottom:35px">
                                <h3 class="about-title" style="margin-bottom:8px">Email Us</h3>
                                <p class="about-desc">{{ SITE_EMAIL }}<br>We reply within 24 hours.</p>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div style="text-align:center;margin-bottom:35px">
                                <h3 class="about-title" style="margin-bottom:8px">Visit Us</h3>
                                <p class="about-desc">{{ SITE_ADDRESS }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container container-240">
                    <div class="row pd1">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <h3 class="about-title spc">Order Help</h3>
                            <p class="about-desc spc">Questions about an order you've already placed — payment, delivery time, or changing an address? <a href="{{ url('/track') }}">Track your order</a> or call us with your order number and we'll sort it out.</p>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <h3 class="about-title spc">Exchanges</h3>
                            <p class="about-desc spc">Need to swap your item for another one? See our <a href="{{ url('/returns-exchange') }}">Returns / Exchange policy</a> for the full process and timelines.</p>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <h3 class="about-title spc">Product Questions</h3>
                            <p class="about-desc spc">Not sure which model or size is right for you? Message or call us before you order — our team knows the full catalog and can point you to the right product.</p>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <h3 class="about-title spc">Common Questions</h3>
                            <p class="about-desc spc">For quick answers on delivery, payment methods, warranty and more, check our <a href="{{ url('/faq') }}">FAQs</a> page.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
