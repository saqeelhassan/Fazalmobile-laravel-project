@php
    $pageTitle    = 'My Cancellations — Fazal Mobiles';
    $currentPage  = 'shop';
    $headerClass  = 'header-v5';
    $extraCss     = [];
    $extraScripts = [];
@endphp
@extends('layouts.app')

@section('content')
<!--content-->
        <div class="container container-240">

            <div class="myaccount">
                <ul class="breadcrumb v3">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="{{ url('/my-account') }}">My Account</a></li>
                    <li class="active">My Cancellations</li>
                </ul>

                @if(session('success'))
                <div class="alert alert-success" style="padding:14px 18px;border-radius:6px;background:#eafaf0;color:#1a7f4e;border:1px solid #b7ecd0;margin-bottom:25px">
                    {{ session('success') }}
                </div>
                @endif

                <div class="row" style="margin:0 -15px">
                    {{-- Sidebar --}}
                    <div class="col-md-3 col-sm-4 col-xs-12" style="padding:0 15px;margin-bottom:25px">
                        @include('layouts.partials.account_sidebar', ['u' => $u, 'active' => 'cancellations'])
                    </div>

                    {{-- Main content --}}
                    <div class="col-md-9 col-sm-8 col-xs-12" style="padding:0 15px">
                        <h1 style="font-size:24px;font-weight:600;margin:0 0 20px">My Cancellations</h1>

                        <div style="background:#fff;border:1px solid #eee;border-radius:8px;padding:22px">
                            @include('layouts.partials.orders_table', ['orders' => $orders, 'emptyMessage' => "You haven't cancelled any orders yet."])
                        </div>
                    </div>
                </div>
            </div>
        </div>
@include('layouts.partials.ecategory')
@endsection
