@php
    $pageTitle    = 'My Profile — Fazal Mobiles';
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
                    <li class="active">My Profile</li>
                </ul>

                @if(session('success'))
                <div class="alert alert-success" style="padding:14px 18px;border-radius:6px;background:#eafaf0;color:#1a7f4e;border:1px solid #b7ecd0;margin-bottom:25px">
                    {{ session('success') }}
                </div>
                @endif

                <div class="row" style="margin:0 -15px">
                    {{-- Sidebar --}}
                    <div class="col-md-3 col-sm-4 col-xs-12" style="padding:0 15px;margin-bottom:25px">
                        @include('layouts.partials.account_sidebar', ['u' => $u, 'active' => 'profile'])
                    </div>

                    {{-- Main content --}}
                    <div class="col-md-9 col-sm-8 col-xs-12" style="padding:0 15px">
                        <h1 style="font-size:24px;font-weight:600;margin:0 0 20px">My Profile</h1>

                        <div style="background:#fff;border:1px solid #eee;border-radius:8px;padding:30px;max-width:520px">
                            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px">
                                <h3 style="margin:0;font-size:16px;font-weight:700">Personal Profile</h3>
                                <button type="button" data-toggle="modal" data-target="#profileModal" style="border:none;background:none;color:#7c3aed;font-size:13px;font-weight:600;cursor:pointer">EDIT</button>
                            </div>

                            <div style="margin-bottom:20px">
                                <p style="margin:0 0 4px;color:#9ca3af;font-size:12px;text-transform:uppercase;letter-spacing:.5px">Full name</p>
                                <p style="margin:0;font-weight:600;font-size:15px">{{ $u->name }}</p>
                            </div>

                            <div style="margin-bottom:20px">
                                <p style="margin:0 0 4px;color:#9ca3af;font-size:12px;text-transform:uppercase;letter-spacing:.5px">Email address</p>
                                <p style="margin:0;font-size:15px">{{ $u->email }}</p>
                            </div>

                            <div style="margin-bottom:8px">
                                <p style="margin:0 0 10px;color:#9ca3af;font-size:12px;text-transform:uppercase;letter-spacing:.5px">Marketing preferences</p>
                                <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px;color:{{ $u->receive_marketing_sms ? '#166534' : '#9ca3af' }}">
                                    <span>{{ $u->receive_marketing_sms ? '✓' : '✕' }}</span> Receive marketing SMS
                                </div>
                                <div style="display:flex;align-items:center;gap:8px;color:{{ $u->receive_marketing_emails ? '#166534' : '#9ca3af' }}">
                                    <span>{{ $u->receive_marketing_emails ? '✓' : '✕' }}</span> Receive marketing emails
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @include('layouts.partials.account_profile_modal', ['u' => $u])
            </div>
        </div>
@include('layouts.partials.ecategory')
@endsection
