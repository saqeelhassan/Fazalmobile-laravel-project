@php
    $pageTitle    = 'About Us — Fazal Mobiles';
    $currentPage  = 'pages';
    $headerClass  = 'header-v5';
    $extraCss     = ['css/jquery.fancybox.min.css'];
    $extraScripts = ['js/jquery.fancybox.min.js'];
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
                <li class="active">About us</li>
            </ul>
        </div>
        <div class="aboutus">
            <div class="container container-240">
                <div class="about-img spc2">
                    <img src="{{ asset('img/about/about_1.jpg') }}" alt="" class="img-responsive">
                </div>
            </div>

            <div class="about-content">
                <div class="container container-240">
                    <div class="entry-inside v4 text-center">
                        <h1 class="entry-title v2 spc">About Fazal Mobiles</h1>
                    </div>
                </div>
                <div class="container container-240">
                    <div class="row pd1" style="display:flex;flex-wrap:wrap">
                        <div class="col-md-6 col-sm-6 col-xs-12" style="display:flex;flex-direction:column">
                            <h3 class="about-title spc">Who we are</h3>
                            <p class="about-desc spc" style="flex:1">Fazal Mobiles is an online electronics store based in Gulshan-e-Iqbal Colony, Ārifwāla, bringing quality smart watches, gaming accessories, audio gear, cables, chargers and other everyday gadgets to customers across Pakistan at honest prices.</p>
                            <div class="about-img">
                                <img src="{{ asset('img/about/about_2.jpg') }}" alt="" class="img-responsive" style="width:100%">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12" style="display:flex;flex-direction:column">
                            <h3 class="about-title spc">What we promise</h3>
                            <p class="about-desc spc" style="flex:1">Every product we sell is genuine and checked before it ships. We keep our range practical and up to date, offer secure payment options, and back every order with real customer support — not just a chatbot.</p>
                            <div class="about-img">
                                <img src="{{ asset('img/about/about_3.jpg') }}" alt="" class="img-responsive" style="width:100%">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient">
                    <div class="container container-240">
                        <div class="row pd2">
                            <div class="col-xs-12 col-sm-4 col-md-4">
                                <div class="about-element text-center">
                                    <img src="{{ asset('img/about/icon1.png') }}" alt="">
                                    <h3 class="about-title v2">Genuine Products</h3>
                                    <p class="about-desc">Every item is sourced from authorized suppliers and checked before dispatch.</p>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-4">
                                <div class="about-element text-center">
                                    <img src="{{ asset('img/about/icon2.png') }}" alt="">
                                    <h3 class="about-title v2">Nationwide Delivery</h3>
                                    <p class="about-desc">We ship orders across Pakistan with reliable, trackable courier service.</p>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-4">
                                <div class="about-element text-center">
                                    <img src="{{ asset('img/about/icon3.png') }}" alt="">
                                    <h3 class="about-title v2">Real Support</h3>
                                    <p class="about-desc">Reach us by phone or email — a real person helps with every question or order.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@include('layouts.partials.ecategory')
@endsection
