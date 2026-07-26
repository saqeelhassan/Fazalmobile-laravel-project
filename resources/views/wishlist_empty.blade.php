@php
    $pageTitle    = 'My Wishlist — Fazal Mobiles';
    $currentPage  = 'shop';
    $headerClass  = 'header-v5';
    $extraCss     = [];
    $extraScripts = [];
@endphp
@extends('layouts.app')

@section('content')
<!--content-->
        <div class="container container-240">
            
            <div class="checkout wishlist">
                <ul class="breadcrumb v3">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li class="active">Wishlist</li>
                </ul>

                <div class="shopping-cart v2 bd-7">
                    <div class="cmt-title text-center abs">
                        <h1 class="page-title v4">Wishlist</h1>
                        <div class="w-empty">
                            <p>No products were added to the wishlist</p>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
@endsection
