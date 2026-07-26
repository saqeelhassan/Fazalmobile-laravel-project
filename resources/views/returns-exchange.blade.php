@include('layouts.partials.config')
@php
    $pageTitle    = 'Returns & Exchange — Fazal Mobiles';
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
                <li class="active">Returns / Exchange</li>
            </ul>
        </div>

        <div class="aboutus">
            <div class="about-content">
                <div class="container container-240">
                    <div class="entry-inside v4 text-center">
                        <h1 class="entry-title v2 spc">Returns &amp; Exchange</h1>
                        <p class="about-desc spc" style="max-width:720px;margin:0 auto">
                            Not happy with your order? Here's how returns and exchanges work at Fazal Mobiles.
                        </p>
                    </div>
                </div>

                <div class="container container-240">
                    <div class="row pd1">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <h3 class="about-title spc">Return Window</h3>
                            <p class="about-desc spc">You can request a return or exchange within 7 days of receiving your order. The product must be unused, in its original packaging, with all accessories, manuals and tags intact.</p>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <h3 class="about-title spc">Damaged or Wrong Item</h3>
                            <p class="about-desc spc">If your order arrives damaged, faulty, or different from what you ordered, contact us within 48 hours of delivery with photos of the item and packaging so we can arrange a free replacement or refund.</p>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <h3 class="about-title spc">How to Start a Return</h3>
                            <p class="about-desc spc">Call or message us with your order number and reason for return. Once approved, we'll arrange a pickup or share the return address. Please don't send items back before getting confirmation from our team.</p>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <h3 class="about-title spc">Refunds</h3>
                            <p class="about-desc spc">Once the returned item passes inspection, refunds are processed to your original payment method or as store credit, whichever you prefer. This usually takes 3–7 business days.</p>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <h3 class="about-title spc">Exchanges</h3>
                            <p class="about-desc spc">Prefer a different size, color or model instead of a refund? Let us know when you start your return — we'll ship the replacement as soon as the original item is received back.</p>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <h3 class="about-title spc">What Can't Be Returned</h3>
                            <p class="about-desc spc">For hygiene reasons, earbuds/earphones that have been used cannot be returned unless they're defective. Products with removed or damaged tags/seals are also not eligible for return.</p>
                        </div>
                    </div>
                </div>

                <div class="container container-240">
                    <div class="entry-inside v4 text-center" style="margin-top:10px">
                        <p class="about-desc">
                            Need help with a return? Call us at <strong>{{ SITE_PHONE }}</strong> or
                            <a href="{{ url('/contact') }}">contact our support team</a>.
                        </p>
                    </div>
                </div>
            </div>
        </div>
@endsection
