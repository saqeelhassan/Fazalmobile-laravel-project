@php
    $pageTitle    = 'Page Not Found — Fazal Mobiles';
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
            <ul class="breadcrumb v2">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li class="active">Eror 404</li>
            </ul>
            <div class="error-page bd-7 text-center">
                <div class="error-img">
                    <img src="{{ asset('img/404.png') }}" alt="">
                </div>
                <h3 class="error-title">We are sory, the page you’ve requested is not available</h3>
                <form method="get" class="searchform full" action="/search" role="search">
                    <input type="hidden" name="type" value="product">
                    <input type="text" name="q" class="form-control" placeholder="Type to search...">
                    <span class="input-group-btn">
                          <button type="submit" class="button_search"><i class="ion-ios-search-strong"></i></button>
                    </span>
                </form>
                <div class="vertical-divider">
                    <div class="center-element">or</div>
                </div>
                <a href="#" class="btn-back btn-gradient">Back to hompage<i class="ion-ios-arrow-forward"></i></a>
            </div>
        </div>
@endsection
