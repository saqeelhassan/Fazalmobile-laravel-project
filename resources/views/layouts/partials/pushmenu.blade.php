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
            <li class="level1{{ nav_active('home', $currentPage ?? '') }}">
                <a href="{{ url('/') }}" title="">Home</a>
            </li>
            <li class="level1 dropdown{{ nav_active('shop', $currentPage ?? '') }}">
                <a href="{{ url('/shop') }}">Shop</a>
                <span class="icon-sub-menu"></span>
                <ul class="menu-level1 js-open-menu">
                    <li class="level2"><a href="{{ url('/shop') }}?category=Smart+Watches" title="">Smart Watches</a></li>
                    <li class="level2"><a href="{{ url('/shop') }}?category=Games" title="">Games</a></li>
                    <li class="level2"><a href="{{ url('/shop') }}?category=Airbuds" title="">Airbuds</a></li>
                    <li class="level2"><a href="{{ url('/shop') }}?category=Cables" title="">Cables</a></li>
                    <li class="level2"><a href="{{ url('/shop') }}?category=Projector" title="">Projector</a></li>
                    <li class="level2"><a href="{{ url('/shop') }}?category=Charger" title="">Charger</a></li>
                    <li class="level2"><a href="{{ url('/shop') }}?category=Cooling+Fan" title="">Cooling Fan</a></li>
                </ul>
            </li>
            <li class="level1{{ nav_active('pages', $currentPage ?? '') }}">
                <a href="{{ url('/about') }}" title="">About</a>
            </li>
            <li class="level1{{ nav_active('pages', $currentPage ?? '') }}">
                <a href="{{ url('/contact') }}" title="">Contact Us</a>
            </li>
            <li class="level1{{ nav_active('shop', $currentPage ?? '') }}">
                <a href="{{ url('/flash-deals') }}" title="">Flash Deals</a>
            </li>
            <li class="level1{{ nav_active('shop', $currentPage ?? '') }}">
                <a href="{{ url('/tech-discovery') }}" title="">Tech Discovery</a>
            </li>
            <li class="level1{{ nav_active('shop', $currentPage ?? '') }}">
                <a href="{{ url('/trending-styles') }}" title="">Trending Styles</a>
            </li>
            <li class="level1{{ nav_active('pages', $currentPage ?? '') }}">
                <a href="{{ url('/gift-cards') }}" title="">Gift Cards</a>
            </li>
        </ul>
    </div>
</div>
<!-- end push menu -->
