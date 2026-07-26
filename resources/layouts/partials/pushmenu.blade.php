<!-- push menu (mobile sidebar nav) -->
<div class="pushmenu menu-home5">
    <div class="menu-push">
        <span class="close-left js-close"><i class="icon-close f-20"></i></span>
        <div class="clearfix"></div>
        <form role="search" method="get" id="searchform" class="searchform" action="{{ url('/search') }}">
            <div>
                <label class="screen-reader-text" for="q"></label>
                <input type="text" placeholder="Search for products" value="" name="q" id="q" autocomplete="off">
                <input type="hidden" name="type" value="product">
                <button type="submit" id="searchsubmit"><i class="ion-ios-search-strong"></i></button>
            </div>
        </form>
        <ul class="nav-home5 js-menubar">
            <li class="level1 dropdown{{ nav_active('home', $currentPage ?? '') }}">
                <a href="#">Home</a>
                <span class="icon-sub-menu"></span>
                <ul class="menu-level1 js-open-menu">
                    <li class="level2"><a href="{{ url('/') }}" title="">Demo 1</a></li>
                    <li class="level2"><a href="{{ url('/home2') }}" title="">Demo 2</a></li>
                    <li class="level2"><a href="{{ url('/home3') }}" title="">Demo 3</a></li>
                    <li class="level2"><a href="{{ url('/home4') }}" title="">Demo 4</a></li>
                    <li class="level2"><a href="{{ url('/home5') }}" title="">Demo 5</a></li>
                    <li class="level2"><a href="#" title="">Demo 6</a></li>
                </ul>
            </li>
            <li class="level1 dropdown{{ nav_active('shop', $currentPage ?? '') }}">
                <a href="#">Shop</a>
                <span class="icon-sub-menu"></span>
                <div class="menu-level1 js-open-menu">
                    <ul class="level1">
                        <li class="level2">
                            <a href="#">Shop Layout</a>
                            <ul class="menu-level-2">
                                <li class="level3"><a href="{{ url('/shop') }}" title="">Shop Full Width</a></li>
                                <li class="level3"><a href="{{ url('/shop-grid-v1') }}" title="">Shop Grid v.1</a></li>
                                <li class="level3"><a href="{{ url('/shop-grid-v2') }}" title="">Shop Grid v.2</a></li>
                                <li class="level3"><a href="{{ url('/shop-list') }}" title="">Shop List</a></li>
                                <li class="level3"><a href="{{ url('/shop-left-sidebar') }}" title="">Shop Left Sidebar</a></li>
                                <li class="level3"><a href="{{ url('/shop-right-sidebar') }}" title="">Shop Right Sidebar</a></li>
                            </ul>
                        </li>
                        <li class="level2">
                            <a href="#">Categories</a>
                            <ul class="menu-level-2">
                                <li class="level3"><a href="{{ url('/shop') }}">Smart Watches</a></li>
                                <li class="level3"><a href="{{ url('/shop') }}">Games</a></li>
                                <li class="level3"><a href="{{ url('/shop') }}">Airbuds</a></li>
                                <li class="level3"><a href="{{ url('/shop') }}">Cables</a></li>
                                <li class="level3"><a href="{{ url('/shop') }}">Projector</a></li>
                                <li class="level3"><a href="{{ url('/shop') }}">Charger</a></li>
                                <li class="level3"><a href="{{ url('/shop') }}">Cooling Fan</a></li>
                            </ul>
                        </li>
                        <li class="level2">
                            <a href="#">Single Product Type</a>
                            <ul class="menu-level-2">
                                <li class="level3"><a href="{{ url('/bundle-product') }}" title="">Bundle</a></li>
                                <li class="level3"><a href="{{ url('/pin-product') }}" title="">Pin Product</a></li>
                                <li class="level3"><a href="{{ url('/360-degree') }}" title="">360 Degree</a></li>
                                <li class="level3"><a href="{{ url('/feature-video') }}" title="">Featured Video</a></li>
                                <li class="level3"><a href="{{ url('/simple') }}">Simple</a></li>
                                <li class="level3"><a href="{{ url('/variable') }}">Variable</a></li>
                                <li class="level3"><a href="{{ url('/affiliate') }}">External / Affiliate</a></li>
                                <li class="level3"><a href="{{ url('/grouped') }}">Grouped</a></li>
                                <li class="level3"><a href="{{ url('/out-of-stock') }}">Out of Stock</a></li>
                                <li class="level3"><a href="{{ url('/on-sale') }}">On Sale</a></li>
                            </ul>
                        </li>
                        <li class="level2">
                            <a href="#">Single Product Layout</a>
                            <ul class="menu-level-2">
                                <li class="level3"><a href="{{ url('/product-extended') }}" title="">Product Extended</a></li>
                                <li class="level3"><a href="{{ url('/product') }}" title="">Product Left Sidebar</a></li>
                                <li class="level3"><a href="{{ url('/product-right-sidebar') }}" title="">Product Right Sidebar</a></li>
                            </ul>
                        </li>
                        <li class="level2">
                            <a href="#">Other Pages</a>
                            <ul class="menu-level-2">
                                <li class="level3"><a href="{{ url('/shop') }}" title="">Shop</a></li>
                                <li class="level3"><a href="{{ url('/cart') }}" title="">Cart</a></li>
                                <li class="level3"><a href="{{ url('/wishlist') }}" title="">My Wishlist</a></li>
                                <li class="level3"><a href="{{ url('/checkout') }}" title="">Checkout</a></li>
                                <li class="level3"><a href="{{ url('/my-account') }}" title="">My Account</a></li>
                                <li class="level3"><a href="{{ url('/track') }}" title="">Track Your Order</a></li>
                                <li class="level3"><a href="{{ url('/quick-view') }}" title="">Quick View</a></li>
                            </ul>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
            </li>
            <li class="level1{{ nav_active('mega', $currentPage ?? '') }}"><a href="#">Mega Menu</a></li>
            <li class="level1{{ nav_active('pages', $currentPage ?? '') }}">
                <a href="#">Pages</a>
                <span class="icon-sub-menu"></span>
                <ul class="menu-level1 js-open-menu">
                    <li class="level2"><a href="{{ url('/about') }}" title="About Us">About Us</a></li>
                    <li class="level2"><a href="{{ url('/contact') }}" title="Contact">Contact</a></li>
                    <li class="level2"><a href="{{ url('/faq') }}" title="FAQs">FAQs</a></li>
                    <li class="level2"><a href="{{ url('/404') }}" title="404">404</a></li>
                    <li class="level2"><a href="{{ url('/coming-soon') }}" title="Coming Soon">Coming Soon</a></li>
                </ul>
            </li>
            <li class="level1{{ nav_active('blog', $currentPage ?? '') }}">
                <a href="#">Blog</a>
                <span class="icon-sub-menu"></span>
                <ul class="menu-level1 js-open-menu">
                    <li class="level2"><a href="{{ url('/blog') }}" title="Blog Standard">Blog Standard</a></li>
                    <li class="level2"><a href="{{ url('/blog-grid') }}" title="Blog Grid">Blog Grid</a></li>
                    <li class="level2"><a href="{{ url('/blog') }}" title="Blog Sidebar">Blog Sidebar</a></li>
                    <li class="level2"><a href="{{ url('/blog/post') }}" title="Blog Single Post">Blog Single Post</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>
<!-- end push menu -->
