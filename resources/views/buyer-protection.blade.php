@php
    $pageTitle    = 'Buyer Protection — Fazal Mobiles';
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
                <li class="active">Buyer Protection</li>
            </ul>
        </div>

        <div class="aboutus">
            <div class="about-content">
                <div class="container container-240">
                    <div class="entry-inside v4 text-center">
                        <h1 class="entry-title v2 spc">Buyer Protection</h1>
                        <p class="about-desc spc" style="max-width:720px;margin:0 auto">
                            Every order placed on Fazal Mobiles is covered from click to delivery. Here's exactly what that means for you.
                        </p>
                    </div>
                </div>

                <div class="container container-240">
                    <div class="row pd1">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div style="display:flex;gap:18px;align-items:flex-start;margin-bottom:35px">
                                <img src="{{ asset('img/feature/safety.png') }}" alt="" style="width:48px;flex-shrink:0">
                                <div>
                                    <h3 class="about-title" style="margin-bottom:8px">Genuine Products Guarantee</h3>
                                    <p class="about-desc">Every product listed on our store is 100% genuine and sourced directly from authorized suppliers. If an item is found to be inauthentic, you're entitled to a full refund.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div style="display:flex;gap:18px;align-items:flex-start;margin-bottom:35px">
                                <img src="{{ asset('img/feature/credit-card.png') }}" alt="" style="width:48px;flex-shrink:0">
                                <div>
                                    <h3 class="about-title" style="margin-bottom:8px">Secure Payments</h3>
                                    <p class="about-desc">All payments are processed through secure, encrypted channels. We never store your card details, and every transaction is monitored for fraud protection.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div style="display:flex;gap:18px;align-items:flex-start;margin-bottom:35px">
                                <img src="{{ asset('img/feature/truck.png') }}" alt="" style="width:48px;flex-shrink:0">
                                <div>
                                    <h3 class="about-title" style="margin-bottom:8px">On-Time Delivery Guarantee</h3>
                                    <p class="about-desc">We work with trusted courier partners to ensure your order arrives within the estimated delivery window. Delayed or lost shipments are eligible for a refund or replacement.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div style="display:flex;gap:18px;align-items:flex-start;margin-bottom:35px">
                                <img src="{{ asset('img/feature/telephone.png') }}" alt="" style="width:48px;flex-shrink:0">
                                <div>
                                    <h3 class="about-title" style="margin-bottom:8px">Easy Exchange</h3>
                                    <p class="about-desc">Not satisfied with your purchase? Items in original condition can be exchanged within 24 hours after the customer receives the product.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container container-240">
                    <div class="entry-inside v4 text-center" style="margin-top:10px">
                        <p class="about-desc">Have a question about an order? <a href="{{ url('/contact') }}">Contact our support team</a> and we'll help you sort it out.</p>
                    </div>
                </div>
            </div>
        </div>
@endsection
