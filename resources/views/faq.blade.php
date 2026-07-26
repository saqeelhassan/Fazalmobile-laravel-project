@include('layouts.partials.config')
@php
    $pageTitle    = 'FAQs — Fazal Mobiles';
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
                <li class="active">FAQs</li>
            </ul>
            <div class="e-qa v2">
                <div class="cmt-title v3 text-center abs"><h1 class="oval-bd btn-gradient">FAQs</h1></div>
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="qa-element">
                            <div class="qa-quest">
                                <span class="qa-icon">Q</span>
                                <h3>Are the products on Fazal Mobiles genuine?</h3>
                            </div>
                            <div class="qa-answer">
                                <span class="qa-icon">A</span>
                                <p>Yes. Every product we list is sourced from authorized suppliers and checked before it ships. If an item ever turns out to be inauthentic, you're entitled to a full refund — see our <a href="{{ url('/buyer-protection') }}">Buyer Protection</a> page.</p>
                            </div>
                        </div>

                        <div class="qa-element">
                            <div class="qa-quest">
                                <span class="qa-icon">Q</span>
                                <h3>How long does delivery take?</h3>
                            </div>
                            <div class="qa-answer">
                                <span class="qa-icon">A</span>
                                <p>Most orders within Pakistan are delivered within 2–5 business days, depending on your city. You'll get a tracking number by SMS or email once your order ships — you can also check status on our <a href="{{ url('/track') }}">Track Your Order</a> page.</p>
                            </div>
                        </div>

                        <div class="qa-element">
                            <div class="qa-quest">
                                <span class="qa-icon">Q</span>
                                <h3>What payment methods do you accept?</h3>
                            </div>
                            <div class="qa-answer">
                                <span class="qa-icon">A</span>
                                <p>We accept cash on delivery as well as secure online payments by debit/credit card. All online transactions are processed through encrypted, secure channels — we never store your card details.</p>
                            </div>
                        </div>

                        <div class="qa-element">
                            <div class="qa-quest">
                                <span class="qa-icon">Q</span>
                                <h3>Can I change or cancel my order after placing it?</h3>
                            </div>
                            <div class="qa-answer">
                                <span class="qa-icon">A</span>
                                <p>Yes, as long as the order hasn't been shipped yet. Call us at {{ SITE_PHONE }} as soon as possible with your order number and we'll update or cancel it for you.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6">
                        <div class="qa-element">
                            <div class="qa-quest">
                                <span class="qa-icon">Q</span>
                                <h3>What is your return and exchange policy?</h3>
                            </div>
                            <div class="qa-answer">
                                <span class="qa-icon">A</span>
                                <p>You can request a return or exchange within 7 days of delivery, as long as the item is unused and in its original packaging. Full details are on our <a href="{{ url('/returns-exchange') }}">Returns / Exchange</a> page.</p>
                            </div>
                        </div>

                        <div class="qa-element">
                            <div class="qa-quest">
                                <span class="qa-icon">Q</span>
                                <h3>Do your products come with a warranty?</h3>
                            </div>
                            <div class="qa-answer">
                                <span class="qa-icon">A</span>
                                <p>Most electronics we sell include a seller warranty covering manufacturing defects. Warranty length varies by product and is listed on the individual product page — contact us if you're unsure before ordering.</p>
                            </div>
                        </div>

                        <div class="qa-element">
                            <div class="qa-quest">
                                <span class="qa-icon">Q</span>
                                <h3>What if my order arrives damaged or wrong?</h3>
                            </div>
                            <div class="qa-answer">
                                <span class="qa-icon">A</span>
                                <p>Contact us within 48 hours of delivery with photos of the item and packaging, and we'll arrange a free replacement or refund — no need to worry about return shipping costs in that case.</p>
                            </div>
                        </div>

                        <div class="qa-element">
                            <div class="qa-quest">
                                <span class="qa-icon">Q</span>
                                <h3>How can I contact customer support?</h3>
                            </div>
                            <div class="qa-answer">
                                <span class="qa-icon">A</span>
                                <p>Call or message us at {{ SITE_PHONE }}, email {{ SITE_EMAIL }}, or visit our <a href="{{ url('/customer-service') }}">Customer Service</a> page for more ways to reach our team, Mon–Sat 9:00am–5:00pm.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
@include('layouts.partials.ecategory')
@endsection
