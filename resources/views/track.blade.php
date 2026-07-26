@php
    use Illuminate\Support\Str;
    use Illuminate\Support\Facades\Storage;
    $pageTitle    = 'Track Your Order — Fazal Mobiles';
    $currentPage  = 'shop';
    $headerClass  = 'header-v5';
    $extraCss     = [];
    $extraScripts = [];
@endphp
@extends('layouts.app')

@section('content')
<!--content-->
        <div class="container container-240">
            
            <div class="myaccount trackorder">
                <ul class="breadcrumb v3">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li class="active">Track your oder</li>
                </ul>
                <div class="row flex pd">
                    <div class="account-element bd-7">
                        <div class="cmt-title text-center abs">
                            <h1 class="page-title v6">Track your Order</h1>
                        </div>
                        <div class="page-content">
                            <p>To track your order please enter your Order ID in the box below and press the "Track" button. This was given to you on your receipt and in the confirmation email you should have received.</p>
                            <form class="login-form" method="post" action="#"> 
                                  <div class="form-group">
                                    <label>Order ID</label>
                                      <input type="text" id="order" class="form-control bdr" name="comment[order]" value="" placeholder="Found in your order confirmation email.">
                                      <label>Billing email</label>
                                      <input type="email" id="email" class="form-control bdr" name="comment[email]" value="" placeholder="Email you used during checkout.">
                                  </div>
                                  <div class="flex justify-center">
                                      <button type="submit" class="btn btn-submit btn-gradient">
                                          Track
                                      </button>
                                        
                                  </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@include('layouts.partials.ecategory')
@endsection
