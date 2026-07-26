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
                                    <a href="{{ url('/') }}"><img src="{{ asset('img/logo.png') }}" alt="" class="img-reponsive"></a>
                                </div>
                                <ul class="footer-block-content">
                                    <li class="address">
                                        <span>45 Grand Central Terminal New York, NY 10017 United States USA</span>
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
                                    <a href="#" class="fa fa-twitter"></a>
                                    <a href="#" class="fa fa-dribbble"></a>
                                    <a href="#" class="fa fa-behance"></a>
                                    <a href="#" class="fa fa-instagram"></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                            <div class="footer-block">
                                <h3 class="footer-block-title">Quick Menu</h3>
                                <ul class="footer-block-content">
                                    <li><a href="{{ url('/shop') }}">Smart Watches</a></li>
                                    <li><a href="{{ url('/shop') }}">Games</a></li>
                                    <li><a href="{{ url('/shop') }}">Airbuds</a></li>
                                    <li><a href="{{ url('/shop') }}">Cables</a></li>
                                    <li><a href="{{ url('/shop') }}">Projector</a></li>
                                    <li><a href="{{ url('/shop') }}">Charger</a></li>
                                    <li><a href="{{ url('/shop') }}">Cooling Fan</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
                            <div class="footer-block">
                                <h3 class="footer-block-title">Customer Service</h3>
                                <ul class="footer-block-content">
                                    <li><a href="{{ url('/my-account') }}">My Account</a></li>
                                    <li><a href="{{ url('/track') }}">Track Your Order</a></li>
                                    <li><a href="{{ url('/contact') }}">Returns / Exchange</a></li>
                                    <li><a href="{{ url('/faq') }}">FAQs</a></li>
                                    <li><a href="{{ url('/contact') }}">Customer Service</a></li>
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
                                    <form class="form_newsletter" action="#" method="post">
                                        <input type="email" value="" placeholder="Enter your email address" name="EMAIL" id="mail" class="newsletter-input form-control">
                                        <button id="subscribe" class="button_mini btn btn-gradient" type="submit">Subscribe</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="f-bottom">
                <div class="container container-240">
                    <div class="row flex lr">
                        <div class="col-xs-6 f-copyright">
                            <span>&copy; {{ date('Y') }} {{ SITE_NAME }}. All rights reserved.</span>
                        </div>
                        <div class="col-xs-6 f-payment hidden-xs">
                            <a href="#"><img src="{{ asset('img/payment/mastercard.png') }}" alt="" class="img-reponsive"></a>
                            <a href="#"><img src="{{ asset('img/payment/paypal.png') }}" alt="" class="img-reponsive"></a>
                            <a href="#"><img src="{{ asset('img/payment/visa.png') }}" alt="" class="img-reponsive"></a>
                            <a href="#"><img src="{{ asset('img/payment/american-express.png') }}" alt="" class="img-reponsive"></a>
                            <a href="#"><img src="{{ asset('img/payment/western-union.png') }}" alt="" class="img-reponsive"></a>
                            <a href="#"><img src="{{ asset('img/payment/jcb.png') }}" alt="" class="img-reponsive"></a>
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

</body>
</html>
