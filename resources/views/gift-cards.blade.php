@include('layouts.partials.config')
@php
    $pageTitle    = 'Gift Cards — Fazal Mobiles';
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
                <li class="active">Gift Cards</li>
            </ul>
        </div>

        <div class="aboutus">
            <div class="about-content">
                <div class="container container-240">
                    <div class="entry-inside v4 text-center">
                        <h1 class="entry-title v2 spc">Gift Cards</h1>
                        <p class="about-desc spc" style="max-width:720px;margin:0 auto">
                            Give the gift of choice. Fazal Mobiles gift cards can be redeemed against any smart watch, earbuds, gaming accessory or gadget in our store.
                        </p>
                    </div>
                </div>

                <div class="container container-240">
                    <div class="row pd1">
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div style="text-align:center;margin-bottom:35px">
                                <h3 class="about-title" style="margin-bottom:8px">Any Occasion</h3>
                                <p class="about-desc">Perfect for birthdays, Eid, weddings, or just because — let them pick exactly what they want.</p>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div style="text-align:center;margin-bottom:35px">
                                <h3 class="about-title" style="margin-bottom:8px">No Expiry</h3>
                                <p class="about-desc">Gift card balances never expire, so recipients can shop whenever they're ready.</p>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div style="text-align:center;margin-bottom:35px">
                                <h3 class="about-title" style="margin-bottom:8px">Easy to Redeem</h3>
                                <p class="about-desc">Applied instantly at checkout — no printing, no hassle.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container container-240">
                    <div class="entry-inside v4 text-center" style="margin-top:10px">
                        <p class="about-desc">
                            Gift cards are currently available in-store and over the phone.
                            Call us at <strong>{{ SITE_PHONE }}</strong> or
                            <a href="{{ url('/contact') }}">contact our team</a> to purchase one today.
                        </p>
                    </div>
                </div>
            </div>
        </div>
@endsection
