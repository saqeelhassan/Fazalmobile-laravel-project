@php
    $pageTitle    = 'My Account — Fazal Mobiles';
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
                    <li class="active">My Account</li>
                </ul>

                @if(session('success'))
                <div class="alert alert-success" style="padding:14px 18px;border-radius:6px;background:#eafaf0;color:#1a7f4e;border:1px solid #b7ecd0;margin-bottom:25px">
                    {{ session('success') }}
                </div>
                @endif

                @auth
                @php $u = auth()->user(); @endphp
                {{-- ── Customer dashboard ───────────────────────────────────── --}}
                <div class="row" style="margin:0 -15px">
                    {{-- Sidebar --}}
                    <div class="col-md-3 col-sm-4 col-xs-12" style="padding:0 15px;margin-bottom:25px">
                        @include('layouts.partials.account_sidebar', ['u' => $u])
                    </div>

                    {{-- Main content --}}
                    <div class="col-md-9 col-sm-8 col-xs-12" style="padding:0 15px">
                        <h1 id="manage-account" style="font-size:24px;font-weight:600;margin:0 0 20px">Manage My Account</h1>

                        <div class="row" style="margin:0 -10px">
                            {{-- Personal Profile --}}
                            <div class="col-md-6 col-xs-12" style="padding:0 10px;margin-bottom:20px">
                                <div id="profile" style="background:#fff;border:1px solid #eee;border-radius:8px;padding:22px;height:100%">
                                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px">
                                        <h3 style="margin:0;font-size:16px;font-weight:700">Personal Profile</h3>
                                        <button type="button" data-toggle="modal" data-target="#profileModal" style="border:none;background:none;color:#7c3aed;font-size:13px;font-weight:600;cursor:pointer">EDIT</button>
                                    </div>
                                    <p style="margin:0 0 6px;font-weight:600">{{ $u->name }}</p>
                                    <p style="margin:0 0 14px;color:#666">{{ $u->email }}</p>
                                    <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px;color:{{ $u->receive_marketing_sms ? '#166534' : '#9ca3af' }}">
                                        <span>{{ $u->receive_marketing_sms ? '✓' : '✕' }}</span> Receive marketing SMS
                                    </div>
                                    <div style="display:flex;align-items:center;gap:8px;color:{{ $u->receive_marketing_emails ? '#166534' : '#9ca3af' }}">
                                        <span>{{ $u->receive_marketing_emails ? '✓' : '✕' }}</span> Receive marketing emails
                                    </div>
                                </div>
                            </div>

                            {{-- Address Book --}}
                            <div class="col-md-6 col-xs-12" style="padding:0 10px;margin-bottom:20px">
                                <div id="address" style="background:#fff;border:1px solid #eee;border-radius:8px;padding:22px;height:100%">
                                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px">
                                        <h3 style="margin:0;font-size:16px;font-weight:700">Address Book</h3>
                                        <a href="{{ route('account.address-book') }}" style="color:#7c3aed;font-size:13px;font-weight:600;text-decoration:none">{{ $u->addresses->count() ? 'MANAGE' : 'ADD' }}</a>
                                    </div>
                                    @php $defaultAddress = $u->addresses->firstWhere('is_default_shipping', true) ?? $u->addresses->first(); @endphp
                                    @if($defaultAddress)
                                        <p style="margin:0 0 6px;font-weight:600">{{ $defaultAddress->full_name }}</p>
                                        <p style="margin:0 0 4px;color:#666">{{ $defaultAddress->address_line }}</p>
                                        @if($defaultAddress->city)<p style="margin:0 0 4px;color:#666">{{ $defaultAddress->city }}</p>@endif
                                        <p style="margin:0;color:#666">{{ $defaultAddress->phone }}</p>
                                        @if($u->addresses->count() > 1)
                                            <p style="margin:10px 0 0;color:#9ca3af;font-size:12px">+{{ $u->addresses->count() - 1 }} more saved address(es)</p>
                                        @endif
                                    @else
                                        <p style="margin:0;color:#9ca3af">No address saved yet.</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div id="orders" style="background:#fff;border:1px solid #eee;border-radius:8px;padding:22px">
                            <h3 style="margin:0 0 16px;font-size:16px;font-weight:700">Recent Orders</h3>
                            @include('layouts.partials.orders_table', ['orders' => $orders])
                        </div>
                    </div>
                </div>

                @include('layouts.partials.account_profile_modal', ['u' => $u])

                @else
                {{-- ── Guest: login ──────────────────────────────────────────── --}}
                <div class="row flex pd">
                    <div class="account-element bd-7">
                        <div class="cmt-title text-center abs">
                            <h1 class="page-title v1">Login</h1>
                        </div>
                        <div class="page-content">
                            <p>Sign in to your account</p>
                            <form class="login-form" method="post" action="{{ route('login') }}">
                                @csrf
                                <div class="form-group" style="margin-bottom:18px">
                                    <label style="display:block;margin-bottom:8px">Email address <span class="f-red">*</span></label>
                                    <input type="email" class="form-control bdr" name="email" value="{{ old('email') }}" style="width:100%;box-sizing:border-box;margin-bottom:0">
                                    @error('email', 'login')<span class="f-red" style="display:block;font-size:12px;margin-top:4px">{{ $message }}</span>@enderror
                                </div>
                                <div class="form-group" style="margin-bottom:18px">
                                    <label style="display:block;margin-bottom:8px">Password <span class="f-red">*</span></label>
                                    <input type="password" class="form-control bdr" name="password" style="width:100%;box-sizing:border-box;margin-bottom:0">
                                    @error('password', 'login')<span class="f-red" style="display:block;font-size:12px;margin-top:4px">{{ $message }}</span>@enderror
                                </div>
                                <div class="flex lr" style="align-items:center">
                                    <div style="display:flex;align-items:center;gap:12px">
                                        <button type="submit" class="btn btn-submit btn-gradient">
                                            Login
                                        </button>
                                        <button type="button" class="btn btn-submit btn-gradient" data-toggle="modal" data-target="#registerModal">
                                            Register
                                        </button>
                                    </div>
                                    <div class="checkbox checkbox-default" style="display:flex;align-items:center;gap:6px">
                                        <input id="remember" name="remember" type="checkbox" value="1">
                                        <label for="remember" style="display:flex;align-items:center;gap:6px;margin:0"><span class="chk-span" tabindex="2"></span>Remember me</label>
                                    </div>
                                </div>
                            </form>

                            <div style="display:flex;align-items:center;gap:12px;margin:22px 0">
                                <span style="flex:1;height:1px;background:#eee"></span>
                                <span style="color:#9ca3af;font-size:12px">OR</span>
                                <span style="flex:1;height:1px;background:#eee"></span>
                            </div>

                            <div style="display:flex;flex-direction:column;gap:10px">
                                <a href="{{ route('auth.social.redirect', ['provider' => 'google']) }}"
                                   style="display:flex;align-items:center;justify-content:center;gap:10px;width:100%;padding:11px 18px;border:1px solid #e5e5e5;border-radius:30px;background:#fff;color:#333;font-size:14px;font-weight:600;text-decoration:none">
                                    <svg width="18" height="18" viewBox="0 0 48 48">
                                        <path fill="#FFC107" d="M43.6 20.5H42V20H24v8h11.3C33.7 32.7 29.3 36 24 36c-6.6 0-12-5.4-12-12s5.4-12 12-12c3.1 0 5.9 1.2 8 3.1l5.7-5.7C34.5 6.1 29.5 4 24 4 12.9 4 4 12.9 4 24s8.9 20 20 20 20-8.9 20-20c0-1.3-.1-2.7-.4-3.5z"/>
                                        <path fill="#FF3D00" d="M6.3 14.7l6.6 4.8C14.7 15.9 18.9 13 24 13c3.1 0 5.9 1.2 8 3.1l5.7-5.7C34.5 7.1 29.5 5 24 5 16.3 5 9.7 9.3 6.3 14.7z"/>
                                        <path fill="#4CAF50" d="M24 44c5.2 0 10-2 13.6-5.2l-6.3-5.3C29.4 35.4 26.8 36 24 36c-5.3 0-9.7-3.3-11.3-8l-6.6 5.1C9.6 39.6 16.2 44 24 44z"/>
                                        <path fill="#1976D2" d="M43.6 20.5H42V20H24v8h11.3c-.8 2.3-2.3 4.2-4.2 5.6l6.3 5.3C40.9 36.5 44 30.8 44 24c0-1.3-.1-2.7-.4-3.5z"/>
                                    </svg>
                                    Continue with Google
                                </a>
                                <a href="{{ route('auth.social.redirect', ['provider' => 'facebook']) }}"
                                   style="display:flex;align-items:center;justify-content:center;gap:10px;width:100%;padding:11px 18px;border:1px solid #1877f2;border-radius:30px;background:#1877f2;color:#fff;font-size:14px;font-weight:600;text-decoration:none">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="#fff">
                                        <path d="M22 12.06C22 6.5 17.52 2 12 2S2 6.5 2 12.06c0 5 3.66 9.15 8.44 9.94v-7.03H7.9v-2.91h2.54V9.85c0-2.5 1.49-3.89 3.77-3.89 1.09 0 2.24.2 2.24.2v2.46h-1.26c-1.24 0-1.63.77-1.63 1.56v1.88h2.78l-.44 2.91h-2.34V22c4.78-.79 8.44-4.94 8.44-9.94z"/>
                                    </svg>
                                    Continue with Facebook
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="account-element bd-7 e-left" style="display:flex;align-items:center;justify-content:center;background:linear-gradient(122deg,#c26af5,#54f0ff);border-radius:8px;overflow:hidden;min-height:400px;padding:40px">
                        <div style="text-align:center">
                            <div style="display:inline-block;background:#fff;padding:20px 24px;border-radius:12px">
                                <img src="{{ asset('img/logo.png') }}" alt="Fazal Mobiles" style="width:220px;max-width:100%;aspect-ratio:1632/274;object-fit:cover;object-position:center;display:block">
                            </div>
                            <p style="color:#fff;font-size:15px;margin-top:25px;max-width:320px;margin-left:auto;margin-right:auto">
                                Sign in to track your orders, save your details, and check out faster next time.
                            </p>
                        </div>
                    </div>
                </div>
                {{-- ── Register modal ───────────────────────────────────────── --}}
                <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document" style="max-width:520px;margin:30px auto">
                        <div class="modal-content" style="border-radius:10px;border:none;overflow:hidden">
                            <div class="modal-body" style="padding:30px">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position:absolute;top:14px;right:18px;background:none;border:none;font-size:24px;line-height:1;color:#9ca3af">&times;</button>
                                <div class="cmt-title text-center abs" style="top:0;margin-bottom:10px">
                                    <h1 class="page-title v1">Register</h1>
                                </div>
                                <p style="text-align:center">Create your very own account</p>
                                <form class="login-form" method="post" action="{{ route('register') }}">
                                    @csrf
                                    <div class="form-group" style="margin-bottom:18px">
                                        <label style="display:block;margin-bottom:8px">Full name <span class="f-red">*</span></label>
                                        <input type="text" class="form-control bdr" name="name" value="{{ old('name') }}" style="width:100%;box-sizing:border-box;margin-bottom:0">
                                        @error('name', 'register')<span class="f-red" style="display:block;font-size:12px;margin-top:4px">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="form-group" style="margin-bottom:18px">
                                        <label style="display:block;margin-bottom:8px">Email address <span class="f-red">*</span></label>
                                        <input type="email" class="form-control bdr" name="email" value="{{ old('email') }}" style="width:100%;box-sizing:border-box;margin-bottom:0">
                                        @error('email', 'register')<span class="f-red" style="display:block;font-size:12px;margin-top:4px">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="form-group" style="margin-bottom:18px">
                                        <label style="display:block;margin-bottom:8px">Password <span class="f-red">*</span></label>
                                        <input type="password" class="form-control bdr" name="password" style="width:100%;box-sizing:border-box;margin-bottom:0">
                                        @error('password', 'register')<span class="f-red" style="display:block;font-size:12px;margin-top:4px">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="form-group" style="margin-bottom:18px">
                                        <label style="display:block;margin-bottom:8px">Confirm password <span class="f-red">*</span></label>
                                        <input type="password" class="form-control bdr" name="password_confirmation" style="width:100%;box-sizing:border-box;margin-bottom:0">
                                    </div>
                                    <div class="flex lr" style="margin-top:20px">
                                        <button type="submit" class="btn btn-submit btn-gradient" style="width:100%">
                                            Register
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                @if($errors->register->any() ?? false)
                <script>
                    jQuery(function ($) {
                        $('#registerModal').modal('show');
                    });
                </script>
                @endif
                @endauth
            </div>
        </div>
@include('layouts.partials.ecategory')
@endsection
