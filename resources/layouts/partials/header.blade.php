<header id="header" class="{{ $headerClass ?? 'header-v1' }}">

    <!-- Top promotional banner -->
    <div class="header-top-banner">
        <a href="#"><img src="{{ asset('img/banner-top.jpg') }}" alt="" class="img-reponsive"></a>
    </div>

    <!-- Top utility bar: store location, tracking, language, currency -->
    <div class="topbar">
        <div class="container container-240">
            <div class="row flex">
                <div class="col-md-6 col-sm-6 col-xs-4 flex-left">
                    <div class="topbar-left">
                        <div class="element element-store hidden-xs hidden-sm">
                            <a href="https://maps.app.goo.gl/cEkdCy61UiMw8TK48" target="_blank" rel="noopener">
                                <img src="{{ asset('img/icon-map.png') }}" alt="">
                                <span>Store Location</span>
                            </a>
                        </div>
                        <div class="element hidden-xs hidden-sm">
                            <a href="{{ url('/track') }}"><img src="{{ asset('img/icon-track.png') }}" alt=""><span>Track Your Order</span></a>
                        </div>
                        <div class="element element-account hidden-md hidden-lg">
                            <a href="{{ url('/my-account') }}">My Account</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-8 flex-right">
                    <div class="topbar-right">
                        <div class="element hidden-xs hidden-sm">
                            <a href="#">Buyer Protection</a>
                        </div>
                        <div class="element hidden-xs hidden-sm">
                            <a href="#">Help</a>
                        </div>
                        <div class="element element-leaguage">
                            <a id="label2" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <img src="{{ asset('img/icon-l.png') }}" alt="">
                                <span>English</span>
                                <span class="ion-ios-arrow-down f-10 e-arrow"></span>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="label2">
                                <li><a href="#">EN</a></li>
                                <li><a href="#">UR</a></li>
                            </ul>
                        </div>
                        <div class="element element-currency">
                            <a id="label3" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <span>USD</span>
                                <span class="ion-ios-arrow-down f-10 e-arrow"></span>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="label3">
                                <li><a href="#">USD</a></li>
                                <li><a href="#">AUD</a></li>
                                <li><a href="#">EUR</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Logo, search bar, cart icons -->
    <div class="header-center">
        <div class="container container-240">
            <div class="row flex">
                <div class="col-lg-2 col-md-2 col-sm-6 col-xs-6 v-center header-logo">
                    <a href="{{ url('/') }}"><img src="{{ asset('img/logo.png') }}" alt="Fazal Mobiles" class="img-reponsive" style="width:min(230px, 45vw);max-width:none;height:auto"></a>
                </div>
                <div class="col-lg-7 col-md-7 v-center header-search hidden-xs hidden-sm">
                    <form method="get" class="searchform ajax-search" action="{{ url('/search') }}" role="search">
                        <input type="hidden" name="type" value="product">
                        <input type="text" name="q" class="form-control" placeholder="i'm shopping for...">
                        <ul class="list-product-search hidden-xs hidden-sm">
                            <li>
                                <a class="flex align-center" href="">
                                    <div class="product-img"><img src="{{ asset('img/product/iphonex.jpg') }}" alt=""></div>
                                    <h3 class="product-title">Notebook Black Spire Smartphone Black 2.0</h3>
                                </a>
                            </li>
                            <li>
                                <a class="flex align-center" href="">
                                    <div class="product-img"><img src="{{ asset('img/product/sound.jpg') }}" alt=""></div>
                                    <h3 class="product-title">Smartphone 6S 64GB LTE</h3>
                                </a>
                            </li>
                            <li>
                                <a class="flex align-center" href="">
                                    <div class="product-img"><img src="{{ asset('img/product/phone4.jpg') }}" alt=""></div>
                                    <h3 class="product-title">Notebook Black Spire Smartphone Black 2.0</h3>
                                </a>
                            </li>
                            <li>
                                <a class="flex align-center" href="">
                                    <div class="product-img"><img src="{{ asset('img/product/phone5.jpg') }}" alt=""></div>
                                    <h3 class="product-title">Smartphone 6S 64GB LTE</h3>
                                </a>
                            </li>
                            <li>
                                <a class="flex align-center" href="">
                                    <div class="product-img"><img src="{{ asset('img/product/phone1.jpg') }}" alt=""></div>
                                    <h3 class="product-title">Notebook Black Spire Smartphone Black 2.0</h3>
                                </a>
                            </li>
                        </ul>
                        <div class="search-panel">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">All categories <span class="fa fa-caret-down"></span></a>
                            <ul id="category" class="dropdown-menu dropdown-category">
                                <li><a href="{{ url('/shop') }}">Smart Watches</a></li>
                                <li><a href="{{ url('/shop') }}">Games</a></li>
                                <li><a href="{{ url('/shop') }}">Airbuds</a></li>
                                <li><a href="{{ url('/shop') }}">Cables</a></li>
                                <li><a href="{{ url('/shop') }}">Projector</a></li>
                                <li><a href="{{ url('/shop') }}">Charger</a></li>
                                <li><a href="{{ url('/shop') }}">Cooling Fan</a></li>
                            </ul>
                        </div>
                        <span class="input-group-btn">
                            <button class="button_search" type="button"><i class="ion-ios-search-strong"></i></button>
                        </span>
                    </form>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6 v-center header-sub">
                    <div class="right-panel">
                        <div class="header-sub-element hidden-xs hidden-sm">
                            <div class="sub-left">
                                <img src="{{ asset('img/icon-call.png') }}" alt="">
                            </div>
                            <div class="sub-right">
                                <span>Call Us Free</span>
                                <div class="phone">{{ SITE_PHONE }}</div>
                            </div>
                        </div>
                        <div class="header-sub-element row">
                            <a class="hidden-xs hidden-sm" href="{{ url('/my-account') }}"><img src="{{ asset('img/icon-user.png') }}" alt=""></a>
                            <a href="{{ url('/wishlist') }}"><img src="{{ asset('img/icon-heart.png') }}" alt=""></a>
                            <div class="cart">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" id="label5">
                                    <img src="{{ asset('img/icon-cart.png') }}" alt="">
                                    <span class="count cart-count">0</span>
                                </a>
                                <div class="dropdown-menu dropdown-cart">
                                    <p style="padding:30px 15px;margin:0;text-align:center;color:#888">Your cart is empty.</p>
                                    <div class="bottom-cart">
                                        <div class="button-cart">
                                            <a href="{{ url('/shop') }}" class="cart-btn e-checkout btn-gradient">Shop now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a href="#" class="hidden-md hidden-lg icon-pushmenu js-push-menu">
                                <i class="fa fa-bars f-15"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Desktop navigation bar: full-width horizontal menu -->
    <style>
        /* Shop dropdown opens on hover; the link itself stays clickable */
        .hb-menu-left li.dropdown:hover > .dropdown-menu { display: block; }
    </style>
    <div class="header-bottom hidden-xs hidden-sm" style="padding:0;width:100%;">
        <div class="hb-fullwidth" style="display:flex;align-items:stretch;width:100%;">

            <!-- Left: category links — fills remaining space, items spread evenly -->
            <nav class="hb-nav-left" style="flex:1;min-width:0;display:flex;align-items:center;background:#fff;border-top:1px solid #eee;overflow:visible;">
                <ul class="nav navbar-nav hb-menu-left" style="display:flex;align-items:center;justify-content:space-around;width:100%;margin:0;padding:0 16px;flex-wrap:nowrap;list-style:none;">
                    <li class="level1" style="flex:1;text-align:center;">
                        <a href="{{ url('/') }}" style="padding:22px 10px;display:block;color:#333;font-size:14px;font-weight:700;white-space:nowrap;">Home</a>
                    </li>
                    <!-- Shop — with category dropdown -->
                    <li class="level1 dropdown" style="flex:1;text-align:center;">
                        <a href="{{ url('/shop') }}" style="padding:22px 10px;display:block;color:#333;font-size:14px;font-weight:700;white-space:nowrap;">
                            Shop <span class="caret" style="margin-left:3px;"></span>
                        </a>
                        <ul class="dropdown-menu hb-shop-dropdown" style="min-width:600px;left:50%;transform:translateX(-50%);padding:14px 20px;border:none;box-shadow:0 4px 18px rgba(0,0,0,0.12);border-radius:4px;margin-top:0;">
                            <li style="display:inline-block;padding:6px 14px;">
                                <a href="{{ url('/shop') }}" style="color:#00a0a0;font-size:12px;font-weight:700;text-transform:uppercase;white-space:nowrap;text-decoration:none;">Smart Watches</a>
                            </li>
                            <li style="display:inline-block;padding:6px 14px;">
                                <a href="{{ url('/shop') }}" style="color:#ff6b35;font-size:12px;font-weight:700;text-transform:uppercase;white-space:nowrap;text-decoration:none;">Games</a>
                            </li>
                            <li style="display:inline-block;padding:6px 14px;">
                                <a href="{{ url('/shop') }}" style="color:#00a0a0;font-size:12px;font-weight:700;text-transform:uppercase;white-space:nowrap;text-decoration:none;">Airbuds</a>
                            </li>
                            <li style="display:inline-block;padding:6px 14px;">
                                <a href="{{ url('/shop') }}" style="color:#ff6b35;font-size:12px;font-weight:700;text-transform:uppercase;white-space:nowrap;text-decoration:none;">Cables</a>
                            </li>
                            <li style="display:inline-block;padding:6px 14px;">
                                <a href="{{ url('/shop') }}" style="color:#00a0a0;font-size:12px;font-weight:700;text-transform:uppercase;white-space:nowrap;text-decoration:none;">Projector</a>
                            </li>
                            <li style="display:inline-block;padding:6px 14px;">
                                <a href="{{ url('/shop') }}" style="color:#ff6b35;font-size:12px;font-weight:700;text-transform:uppercase;white-space:nowrap;text-decoration:none;">Charger</a>
                            </li>
                            <li style="display:inline-block;padding:6px 14px;">
                                <a href="{{ url('/shop') }}" style="color:#00a0a0;font-size:12px;font-weight:700;text-transform:uppercase;white-space:nowrap;text-decoration:none;">Cooling Fan</a>
                            </li>
                        </ul>
                    </li>
                    <li class="level1" style="flex:1;text-align:center;">
                        <a href="{{ url('/about') }}" style="padding:22px 10px;display:block;color:#333;font-size:14px;font-weight:700;white-space:nowrap;">About</a>
                    </li>
                    <li class="level1" style="flex:1;text-align:center;position:relative;">
                        <a href="{{ url('/contact') }}" style="padding:22px 10px;display:block;color:#333;font-size:14px;font-weight:700;white-space:nowrap;">
                            Contact Us
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- Right: gradient promo links (parallelogram shape via skew) -->
            <nav class="hb-nav-right" style="display:flex;align-items:stretch;background:linear-gradient(to right,#a855f7,#06b6d4);flex-shrink:0;transform:skewX(-12deg);transform-origin:bottom left;margin-left:-18px;">
                <ul class="nav navbar-nav hb-menu-right" style="display:flex;align-items:stretch;margin:0;padding:0;flex-wrap:nowrap;list-style:none;transform:skewX(12deg);">
                    <li class="level1" style="display:flex;align-items:center;border-right:1px solid rgba(255,255,255,0.35);">
                        <a href="#" style="padding:22px 22px;display:flex;align-items:center;color:#fff;font-size:14px;font-weight:600;white-space:nowrap;text-decoration:none;">Flash Deals</a>
                    </li>
                    <li class="level1" style="display:flex;align-items:center;border-right:1px solid rgba(255,255,255,0.35);position:relative;">
                        <a href="#" style="padding:22px 22px;display:flex;align-items:center;color:#fff;font-size:14px;font-weight:600;white-space:nowrap;text-decoration:none;">Tech Discovery</a>
                        <span style="position:absolute;top:8px;left:50%;transform:translateX(-50%);background:#22c55e;color:#fff;font-size:9px;font-weight:700;padding:2px 7px;border-radius:20px;text-transform:uppercase;letter-spacing:0.5px;white-space:nowrap;">New</span>
                    </li>
                    <li class="level1" style="display:flex;align-items:center;border-right:1px solid rgba(255,255,255,0.35);">
                        <a href="#" style="padding:22px 22px;display:flex;align-items:center;color:#fff;font-size:14px;font-weight:600;white-space:nowrap;text-decoration:none;">Trending Styles</a>
                    </li>
                    <li class="level1" style="display:flex;align-items:center;">
                        <a href="#" style="padding:22px 22px;display:flex;align-items:center;color:#fff;font-size:14px;font-weight:600;white-space:nowrap;text-decoration:none;">Gift Cards</a>
                    </li>
                </ul>
            </nav>

        </div>
    </div>

</header>
<!-- /header -->
