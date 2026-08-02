@include('layouts.partials.config')
@php
    $pageTitle    = 'Help Center — Fazal Mobiles';
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
                <li class="active">Help</li>
            </ul>
        </div>

        <div class="aboutus">
            <div class="about-content">
                <div class="container container-240">
                    <div class="entry-inside v4 text-center">
                        <h1 class="entry-title v2 spc">Help Center</h1>
                        <p class="about-desc spc" style="max-width:720px;margin:0 auto">
                            Everything you need in one place — quick answers, order help, and how to reach us.
                        </p>
                    </div>
                </div>

                <div class="container container-240">
                    <div class="row pd1">
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <a href="{{ url('/faq') }}" style="display:block;text-align:center;margin-bottom:35px;text-decoration:none">
                                <h3 class="about-title" style="margin-bottom:8px">FAQs</h3>
                                <p class="about-desc">Quick answers on delivery, payment, and warranty.</p>
                            </a>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <a href="{{ url('/track') }}" style="display:block;text-align:center;margin-bottom:35px;text-decoration:none">
                                <h3 class="about-title" style="margin-bottom:8px">Track Your Order</h3>
                                <p class="about-desc">Check the status of an order you've already placed.</p>
                            </a>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <a href="{{ url('/returns-exchange') }}" style="display:block;text-align:center;margin-bottom:35px;text-decoration:none">
                                <h3 class="about-title" style="margin-bottom:8px">Returns &amp; Exchange</h3>
                                <p class="about-desc">How to send something back or swap it for another item.</p>
                            </a>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <a href="{{ url('/buyer-protection') }}" style="display:block;text-align:center;margin-bottom:35px;text-decoration:none">
                                <h3 class="about-title" style="margin-bottom:8px">Buyer Protection</h3>
                                <p class="about-desc">What's covered from the moment you order to delivery.</p>
                            </a>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <a href="{{ url('/customer-service') }}" style="display:block;text-align:center;margin-bottom:35px;text-decoration:none">
                                <h3 class="about-title" style="margin-bottom:8px">Customer Service</h3>
                                <p class="about-desc">Full contact details and how our support works.</p>
                            </a>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <a href="{{ url('/contact') }}" style="display:block;text-align:center;margin-bottom:35px;text-decoration:none">
                                <h3 class="about-title" style="margin-bottom:8px">Contact Us</h3>
                                <p class="about-desc">Still stuck? Send us a message and we'll get back to you.</p>
                            </a>
                        </div>
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
            </div>
        </div>
@endsection
