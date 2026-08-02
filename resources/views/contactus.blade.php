@include('layouts.partials.config')
@php
    use Illuminate\Support\Str;
    use Illuminate\Support\Facades\Storage;
    $pageTitle    = 'Contact Us — Fazal Mobiles';
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
               <a href="{{ url('/shop') }}" class="image-bd effect_img2"><img src="{{ asset('img/o-banner.jpg') }}" alt="" class="img-reponsive"></a>
            </div>
            <ul class="breadcrumb">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li class="active">Contact </li>
            </ul>
            <div class="e-contact">
                <div class="map" style="height:420px;border-radius:8px;overflow:hidden">
                    <iframe
                        src="https://www.google.com/maps?q={{ urlencode('Fazal Mobiles, Karkhana Bazar, Gulshan-e-Iqbal Colony B Block, Arifwala, 57450, Pakistan') }}&output=embed"
                        style="width:100%;height:100%;border:0"
                        allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                        title="Fazal Mobiles store location"></iframe>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-7">
                        <div class="contact-info">
                            <h1 class="contact-title spc">Contact Details</h1>
                            <p>Have a question about a product or your order? Reach out to us — our team is happy to help you by phone, email, or at our store.</p>
                        </div>
                        <div class="e-contact-address footer-about">
                            <h3 class="contact-title v2">Fazal Mobiles Store</h3>
                            <ul class="footer-block-content">
                                <li class="address">
                                    <span>{{ SITE_ADDRESS }}</span>
                                </li>
                                <li class="phone">
                                    <span>{{ SITE_PHONE }}</span>
                                </li>
                                <li class="email">
                                    <span>{{ SITE_EMAIL }}</span>
                                </li>
                                <li class="time">
                                    <span>Mon-Sat 9:00am - 5:00pm  &nbsp;&nbsp;&nbsp;  Sun : Closed</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-5 pdl">
                        <h1 class="contact-title spc">Leave a message</h1>

                        @if(session('contact_success'))
                        <div class="alert alert-success" style="padding:14px 18px;border-radius:6px;background:#eafaf0;color:#1a7f4e;border:1px solid #b7ecd0;margin-bottom:20px">
                            {{ session('contact_success') }}
                        </div>
                        @endif

                        @if($errors->contact->any())
                        <div style="background:#fee2e2;border:1px solid #fca5a5;border-radius:8px;padding:12px 16px;margin-bottom:20px;color:#991b1b">
                            <ul style="margin:0;padding-left:16px;font-size:13px">
                                @foreach($errors->contact->all() as $e)<li>{{ $e }}</li>@endforeach
                            </ul>
                        </div>
                        @endif

                        <form class="login-form" action="{{ route('contact.store') }}" method="post">
                            @csrf
                            <div class="form-group">
                                  <input type="text" id="author" class="form-control bdr" name="name" value="{{ old('name') }}" placeholder="Name *">
                                  <input type="email" id="email" class="form-control bdr" name="email" value="{{ old('email') }}" placeholder="Email *">
                                  <input type="text" id="phone" class="form-control bdr" name="phone" value="{{ old('phone') }}" placeholder="Phone Number">
                                  <textarea id="message" class="form-control bdr3" name="message" rows="10" placeholder="Your message here...">{{ old('message') }}</textarea>
                            </div>
                              <div class="form-group">
                                  <button type="submit" class="btn btn-submit btn-gradient">
                                      Send message
                                  </button>
                              </div>
                          </form>
                    </div>
                </div>
                <div class="banner-callus image-bd effect_img2" style="position:relative; overflow:hidden; border-radius:10px;">
                    <a href="{{ url('/shop') }}"><img src="{{ asset('img/banner/h1_b7.jpg') }}" alt="Fazal Mobiles Contact" class="img-responsive" style="width:100%; height:auto; display:block;"></a>
                    <div class="box-center v2" style="position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); width:90%; max-width:600px; text-align:center; display:flex; flex-direction:column; align-items:center; justify-content:center; padding:0 !important; margin:0; z-index:10;">
                        <span style="color:#ffffff; font-size:22px; font-weight:400; letter-spacing:1.5px; text-transform:uppercase; display:block; opacity:0.9; margin:0 0 4px 0;">Call us free</span>
                        <span style="color:#ffffff; font-size:40px; font-weight:700; display:block; line-height:1.2; letter-spacing:0.5px; margin:0 0 10px 0;">{{ SITE_PHONE }}</span>
                        <a href="{{ url('/shop') }}" class="btn-callus" style="font-size:16px; text-decoration:none; margin:0;">Shop now</a>
                    </div>
                </div>
            </div>
        </div>
@include('layouts.partials.ecategory')
@endsection
