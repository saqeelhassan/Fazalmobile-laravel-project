        <!-- Feature highlights bar -->
        <div class="feature">
            <div class="container container-240">
                <div class="feature-inside">
                    <div class="feature-block text-center">
                        <div class="feature-block-img"><img src="{{ asset('img/feature/truck.png') }}" alt="" class="img-reponsive"></div>
                        <div class="feature-info">
                            <h3>Worldwide Delivery</h3>
                            <p>With sites in 5 languages, we ship to over 200 countries &amp; regions.</p>
                        </div>
                    </div>
                    <div class="feature-block text-center">
                        <div class="feature-block-img"><img src="{{ asset('img/feature/credit-card.png') }}" alt="" class="img-reponsive"></div>
                        <div class="feature-info">
                            <h3>Safe Payment</h3>
                            <p>Pay with the world's most popular and secure payment methods.</p>
                        </div>
                    </div>
                    <div class="feature-block text-center">
                        <div class="feature-block-img"><img src="{{ asset('img/feature/safety.png') }}" alt="" class="img-reponsive"></div>
                        <div class="feature-info">
                            <h3>Shop with Confidence</h3>
                            <p>Our Buyer Protection covers your purchase from click to delivery.</p>
                        </div>
                    </div>
                    <div class="feature-block text-center">
                        <div class="feature-block-img"><img src="{{ asset('img/feature/telephone.png') }}" alt="" class="img-reponsive"></div>
                        <div class="feature-info">
                            <h3>24/7 Help Center</h3>
                            <p>Round-the-clock assistance for a smooth shopping experience.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer>
            <div class="f-top">
                <div class="container container-240">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                            <div class="footer-block footer-about">
                                <div class="f-logo">
                                    <a href="{{ url('/') }}"><img src="{{ asset('img/logo.png') }}" alt="" class="img-reponsive" style="width:220px;max-width:100%;aspect-ratio:1632/274;object-fit:cover;object-position:center;display:block"></a>
                                </div>
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
                                        <span>Mon–Sat 9:00am – 5:00pm &nbsp;&nbsp; Sun: Closed</span>
                                    </li>
                                </ul>
                                <div class="footer-social social">
                                    <h3 class="footer-block-title">Follow us</h3>
                                    <a href="https://web.facebook.com/profile.php?id=61574416134827" class="fa fa-facebook" target="_blank" rel="noopener" aria-label="Facebook"></a>
                                    <a href="https://www.instagram.com/fazalmobile" class="fa fa-instagram" target="_blank" rel="noopener" aria-label="Instagram"></a>
                                    <a href="https://www.tiktok.com/@fazalmobilebyrazahayder7" target="_blank" rel="noopener" aria-label="TikTok" style="display:inline-block;vertical-align:top"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" style="width:15px;height:15px;fill:#fff;vertical-align:middle"><path d="M448,209.91a210.06,210.06,0,0,1-122.77-39.25V349.38A162.55,162.55,0,1,1,185,188.31V278.2a74.62,74.62,0,1,0,52.23,71.18V0l88,0a121.18,121.18,0,0,0,1.86,22.17h0A122.18,122.18,0,0,0,381,102.39a121.43,121.43,0,0,0,67,20.14Z"/></svg></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                            <div class="footer-block">
                                <h3 class="footer-block-title">Quick Menu</h3>
                                <ul class="footer-block-content">
                                    <li><a href="{{ url('/shop') }}?category=Smart+Watches">Smart Watches</a></li>
                                    <li><a href="{{ url('/shop') }}?category=Games">Games</a></li>
                                    <li><a href="{{ url('/shop') }}?category=Airbuds">Airbuds</a></li>
                                    <li><a href="{{ url('/shop') }}?category=Cables">Cables</a></li>
                                    <li><a href="{{ url('/shop') }}?category=Projector">Projector</a></li>
                                    <li><a href="{{ url('/shop') }}?category=Charger">Charger</a></li>
                                    <li><a href="{{ url('/shop') }}?category=Cooling+Fan">Cooling Fan</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
                            <div class="footer-block">
                                <h3 class="footer-block-title">Customer Service</h3>
                                <ul class="footer-block-content">
                                    <li><a href="{{ url('/my-account') }}">My Account</a></li>
                                    <li><a href="{{ url('/track') }}">Track Your Order</a></li>
                                    <li><a href="{{ url('/returns-exchange') }}">Returns / Exchange</a></li>
                                    <li><a href="{{ url('/faq') }}">FAQs</a></li>
                                    <li><a href="{{ url('/customer-service') }}">Customer Service</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                            <div class="footer-block">
                                <div class="footer-block-phone">
                                    <h3 class="footer-block-title">Hot Line</h3>
                                    <p class="phone-desc">Call Us Toll Free</p>
                                    <p class="phone-light">{{ SITE_PHONE }}</p>
                                </div>
                                <div class="footer-block-newsletter">
                                    <h3 class="footer-block-title">Subscription</h3>
                                    <p>Register now to get updates on promotions and coupons.</p>
                                    @if(session('newsletter_success'))
                                        <p style="color:#3ddc97;font-size:13px;margin-bottom:10px">{{ session('newsletter_success') }}</p>
                                    @endif
                                    @error('newsletter_email', 'newsletter')
                                        <p style="color:#ff8a8a;font-size:13px;margin-bottom:10px">{{ $message }}</p>
                                    @enderror
                                    <form class="form_newsletter" action="{{ route('newsletter.subscribe') }}" method="post">
                                        @csrf
                                        <input type="email" value="{{ old('newsletter_email') }}" placeholder="Enter your email address" name="newsletter_email" id="mail" class="newsletter-input form-control" required>
                                        <button id="subscribe" class="button_mini btn btn-gradient" type="submit">Subscribe</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <style>
                .f-bottom-link { color: #bbbbbb; text-decoration: none; transition: all 0.3s ease; }
                .f-bottom-link:hover {
                    background-image: linear-gradient(122deg, #c26af5, #54f0ff);
                    -webkit-background-clip: text;
                    background-clip: text;
                    -webkit-text-fill-color: transparent;
                    color: transparent;
                }
            </style>
            <div class="f-bottom">
                <div class="container container-240">
                    <div class="row flex lr">
                        <div class="col-xs-6 f-copyright">
                            <span>&copy; {{ date('Y') }} {{ SITE_NAME }}. All rights reserved.</span>
                            <a href="{{ url('/privacy-policy') }}" class="f-bottom-link" style="margin-left:15px">Privacy Policy</a>
                            <span style="margin-left:15px;color:#bbbbbb">Crafted by <a href="https://deweboo.com/" target="_blank" rel="noopener" class="f-bottom-link">De-Weboo</a></span>
                        </div>
                        <div class="col-xs-6 f-payment hidden-xs">
                            <img src="{{ asset('img/payment/mastercard.png') }}" alt="Mastercard" class="img-reponsive">
                            <img src="{{ asset('img/payment/visa.png') }}" alt="Visa" class="img-reponsive">
                            <img src="{{ asset('img/payment/jcb.png') }}" alt="JCB" class="img-reponsive">
                        </div>
                    </div>
                </div>
            </div>
        </footer>

    </div><!-- /.wrappage -->

    <!-- Scroll-to-top button -->
    <a href="#" class="btn-gradient scroll_top"><i class="ion-ios-arrow-up"></i></a>

    <!-- Core scripts -->
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/slick.js') }}"></script>
    <script src="{{ asset('js/countdown.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>

    @foreach($extraScripts ?? [] as $script)
    <script src="{{ asset($script) }}"></script>
    @endforeach

    @include('layouts.partials.quickview')
    @include('layouts.partials.cart-wishlist')

    <!-- Page Loader JS -->
    <script>
        $(window).on('load', function () {
            $('#page-loader').addClass('loaded');
            setTimeout(function () {
                $('#page-loader').remove();
            }, 600);
        });
        // Fallback: force hide after 4s in case load never fires
        setTimeout(function () {
            $('#page-loader').addClass('loaded');
            setTimeout(function () { $('#page-loader').remove(); }, 600);
        }, 4000);
    </script>

</body>
</html>
