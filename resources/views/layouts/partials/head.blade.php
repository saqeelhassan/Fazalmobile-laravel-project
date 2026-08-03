<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>{{ $pageTitle ?? 'Fazal Mobiles' }}</title>
    <meta name="description" content="{{ $metaDescription ?? 'Fazal Mobile — shop smart watches, gaming controllers, airbuds, cables, projectors, chargers and cooling fans. Fast delivery across Pakistan.' }}">
    @if(!empty($canonicalUrl))
    <link rel="canonical" href="{{ $canonicalUrl }}">
    @endif

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
    <link rel="shortcut icon" href="{{ asset('img/favicon.png') }}" type="image/png">
    <link rel="stylesheet" href="{{ asset('css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('css/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ionicons.min.css') }}">

    @foreach($extraCss ?? [] as $css)
    <link rel="stylesheet" href="{{ asset($css) }}">
    @endforeach

    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">

    <!-- Uniform Product Card CSS -->
    <style>
        /* ── Equal-height cards in a row ── */
        .row.equal-cards { display: flex; flex-wrap: wrap; }
        .product-item {
            display: flex;
            flex-direction: column;
        }
        .product-item .pd-bd,
        .product-item .product-inner {
            display: flex;
            flex-direction: column;
            flex: 1;
            height: 100%;
        }

        /* ── One uniform outer border per card (was only wrapping the
           text block before, so card boxes lined up unevenly). Scoped to
           `.product-inner` elements that WRAP a separate `.pd-bd` child
           (the shop grid markup) — leaves carousel cards using a single
           combined `.pd-bd.product-inner` element untouched. ── */
        .product-item > .product-inner:not(.pd-bd) {
            border: 1px solid #f0f0f0;
            border-radius: 10px;
            overflow: hidden;
        }
        .product-item > .product-inner:not(.pd-bd) > .pd-bd {
            border: 0;
            border-radius: 0;
        }

        /* ── Fixed image box — all same size ── */
        .product-item .product-img,
        .product-inner .product-img {
            width: 100%;
            height: 220px;
            overflow: hidden;
            background: #f8f8f8;
            position: relative;
            flex-shrink: 0;
        }
        .product-item .product-img img,
        .product-inner .product-img img {
            width: 100% !important;
            height: 220px !important;
            object-fit: cover !important;
            object-position: center !important;
            transition: transform 0.35s ease;
            display: block;
        }
        .product-item .product-img:hover img,
        .product-inner .product-img:hover img {
            transform: scale(1.06);
        }

        /* ── Kill the theme's decorative 3D lift-shadow pseudo-element on
           product cards: its `transform: rotateX()` on an absolutely
           positioned :after breaks mouse hover hit-testing for everything
           nested inside .product-inner (e.g. the quick-view/wishlist/cart
           icon overlay), so hovering never reveals them. ── */
        .product-item .product-inner:after,
        .product-item .pd-bd.product-inner:after {
            display: none !important;
            content: none !important;
        }

        /* ── Product card heading: `.pd-title` (shop/category grids) has no
           font-size of its own, so it falls back to the theme's default
           `h3 { font-size: 24px }` — way too large for a card. Match the
           homepage's `.product-title` (14px) so headings look consistent
           site-wide. ── */
        .product-item .pd-title {
            font-size: 14px;
            font-weight: 600;
            color: #1c1c28;
            text-transform: capitalize;
            line-height: 1.4;
            margin: 0 0 6px;
            min-height: 0;
            max-height: none;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .product-item .pd-title a { color: inherit; }

        /* ── Uniform homepage promo-banner row — equal size regardless of
           each source image's native aspect ratio (h2_b1/b2/b3 differ
           slightly, e.g. 1000x701 vs 1051x701) ── */
        .homepage-banner.spc2 .banner-img {
            overflow: hidden;
        }
        .homepage-banner.spc2 .banner-img img {
            width: 100%;
            aspect-ratio: 1000 / 701;
            object-fit: cover;
            object-position: center;
            display: block;
        }

        /* ── Out of Stock / Sale badge — inside image, fully visible ── */
        .product-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            color: #fff;
            z-index: 5;
            letter-spacing: .3px;
        }
        .product-badge.badge-out   { background: #6b7280; }
        .product-badge.badge-sale  { background: #ef4444; }
        .product-badge.badge-new   { background: #6c63ff; }

        /* ── e-category small thumbnails ── */
        .cate-item .product-img {
            width: 80px;
            height: 80px;
            flex-shrink: 0;
            overflow: hidden;
            background: #f5f5f5;
            border-radius: 4px;
        }
        .cate-item .product-img img {
            width: 80px !important;
            height: 80px !important;
            object-fit: cover !important;
            object-position: center !important;
        }

        /* ── Blog post date badge: a flex sibling of the (often long) post
           title inside a flex row — without flex-shrink:0 the flex layout
           squishes its width to make room for the title, turning the
           circle into an oval. ── */
        .blog-post-date {
            flex-shrink: 0;
        }
    </style>

    <!-- Page Loader CSS -->
    <style>
        #page-loader {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: #ffffff;
            z-index: 99999;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: opacity 0.5s ease, visibility 0.5s ease;
        }
        #page-loader.loaded {
            opacity: 0;
            visibility: hidden;
        }
        .loader-inner {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 28px;
        }
        .loader-logo img {
            max-width: 160px;
            animation: loaderPulse 1.6s ease-in-out infinite;
        }
        @keyframes loaderPulse {
            0%, 100% { opacity: 1; transform: scale(1); }
            50%       { opacity: 0.7; transform: scale(0.95); }
        }
        .loader-spinner {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        .loader-spinner span {
            display: inline-block;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: linear-gradient(135deg, #f96f5d, #f9b234);
            animation: loaderBounce 1.2s ease-in-out infinite;
        }
        .loader-spinner span:nth-child(1) { animation-delay: 0s;    background: #f96f5d; }
        .loader-spinner span:nth-child(2) { animation-delay: 0.2s;  background: #f9b234; }
        .loader-spinner span:nth-child(3) { animation-delay: 0.4s;  background: #6c63ff; }
        .loader-spinner span:nth-child(4) { animation-delay: 0.6s;  background: #00c8ff; }
        @keyframes loaderBounce {
            0%, 80%, 100% { transform: scale(0.6); opacity: 0.4; }
            40%            { transform: scale(1);   opacity: 1;   }
        }
    </style>
</head>
