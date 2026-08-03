{{-- Sidebar for the main /shop page. Requires: $categories, $category, $categoryImages, $minPrice, $maxPrice, $priceFloor, $priceCeil --}}
<div class="col-md-3 col-sm-3 col-xs-12 col-left collection-sidebar" id="filter-sidebar">
    <div class="close-sidebar-collection hidden-lg hidden-md">
        <span>filter</span><i class="icon_close ion-close"></i>
    </div>

    <div class="filter filter-cate shop-cate-list">
        <h1 class="widget-blog-title">Product Categories</h1>
        <ul class="cate-list-thumb">
            <li class="{{ !$category ? 'active' : '' }}">
                <a href="{{ url('/shop') }}?{{ http_build_query(request()->except(['category', 'page'])) }}">
                    <span class="cate-thumb-name">All Products</span>
                </a>
            </li>
            @foreach($categories as $cat)
            <li class="{{ $category === $cat ? 'active' : '' }}">
                <a href="{{ url('/shop') }}?{{ http_build_query(array_merge(request()->except('page'), ['category' => $cat])) }}">
                    <span class="cate-thumb-img">
                        @if(!empty($categoryImages[$cat]))
                            <img src="{{ Storage::url($categoryImages[$cat]) }}" alt="{{ $cat }}">
                        @else
                            <img src="{{ asset('img/product/img-1.jpg') }}" alt="{{ $cat }}">
                        @endif
                    </span>
                    <span class="cate-thumb-name">{{ $cat }}</span>
                    <span class="cate-thumb-arrow"></span>
                </a>
            </li>
            @endforeach
        </ul>
    </div>

    <div class="filter filter-price shop-price-filter">
        <h1 class="widget-blog-title">Filter by Price</h1>
        <form action="{{ url('/shop') }}" method="GET" id="price-filter-form">
            @foreach(request()->except(['min_price', 'max_price', 'page']) as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach
            <input type="hidden" name="min_price" id="min_price_input" value="{{ $minPrice !== '' ? $minPrice : $priceFloor }}">
            <input type="hidden" name="max_price" id="max_price_input" value="{{ $maxPrice !== '' ? $maxPrice : $priceCeil }}">

            <div id="price-range-slider"
                 data-slider-min="{{ $priceFloor }}"
                 data-slider-max="{{ $priceCeil }}"
                 data-slider-value="[{{ $minPrice !== '' ? $minPrice : $priceFloor }},{{ $maxPrice !== '' ? $maxPrice : $priceCeil }}]"
                 style="width:100%"></div>

            <div class="price-filter-bottom">
                <button type="submit" class="btn-filter-apply">Filter</button>
                <span class="price-range-label">Price: Rs {{ number_format($minPrice !== '' ? $minPrice : $priceFloor) }} — Rs {{ number_format($maxPrice !== '' ? $maxPrice : $priceCeil) }}</span>
            </div>
        </form>
    </div>
</div>

<style>
    /* Category list with thumbnail + gradient active row (theme's existing gradient) */
    .shop-cate-list .widget-blog-title { padding: 14px 14px 12px; margin: 0; }
    .shop-cate-list .cate-list-thumb { list-style: none; margin: 0; padding: 0; }
    .shop-cate-list .cate-list-thumb li { border-bottom: 1px solid #eee; }
    .shop-cate-list .cate-list-thumb li:last-child { border-bottom: none; }
    .shop-cate-list .cate-list-thumb li a {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 14px;
        position: relative;
        color: #333;
        text-decoration: none;
        transition: background .25s ease;
    }
    .shop-cate-list .cate-list-thumb li a:hover { background: #f7f7f9; }
    .shop-cate-list .cate-thumb-img {
        width: 44px; height: 44px; flex-shrink: 0;
        border-radius: 4px; overflow: hidden; background: #f5f5f5;
    }
    .shop-cate-list .cate-thumb-img img { width: 100%; height: 100%; object-fit: cover; }
    .shop-cate-list .cate-thumb-name { font-size: 14px; }
    .shop-cate-list .cate-list-thumb li.active a {
        background: #54f0ff;
        background-image: linear-gradient(122deg, #c26af5, #54f0ff);
        color: #fff;
    }
    .shop-cate-list .cate-list-thumb li.active a:hover { background-image: linear-gradient(122deg, #c26af5, #54f0ff); }
    .shop-cate-list .cate-thumb-arrow {
        position: absolute;
        right: -1px; top: 50%;
        transform: translateY(-50%);
        width: 0; height: 0;
        border-top: 14px solid transparent;
        border-bottom: 14px solid transparent;
        border-left: 12px solid #fff;
        opacity: 0;
    }
    .shop-cate-list .cate-list-thumb li.active .cate-thumb-arrow { opacity: 1; }

    /* Price range slider — themed with the site's signature purple/cyan gradient */
    .shop-price-filter { padding: 18px 14px 20px; }
    .shop-price-filter #price-range-slider-widget.slider { margin: 10px 10px 20px; width: calc(100% - 20px) !important; }
    .shop-price-filter #price-range-slider-widget .slider-track { background: #e9e9ee; box-shadow: none; height: 5px; }
    .shop-price-filter #price-range-slider-widget .slider-selection {
        background: #54f0ff;
        background-image: linear-gradient(122deg, #c26af5, #54f0ff);
        box-shadow: none;
    }
    .shop-price-filter #price-range-slider-widget .slider-handle {
        background: #fff;
        background-image: linear-gradient(122deg, #c26af5, #54f0ff);
        box-shadow: 0 0 0 3px #fff, 0 1px 4px rgba(0,0,0,.25);
        width: 18px; height: 18px; top: 1px;
    }
    .price-filter-bottom { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }
    .btn-filter-apply {
        border: none;
        padding: 8px 20px;
        border-radius: 30px;
        color: #fff;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        background: #54f0ff;
        background-image: linear-gradient(122deg, #c26af5, #54f0ff);
    }
    .price-range-label { font-size: 13px; color: #666; }
</style>

<script>
    function fmInitPriceSlider() {
        if (typeof jQuery === 'undefined') { return; }

        jQuery(function ($) {
            var $slider = $('#price-range-slider');
            if (!$slider.length || typeof $slider.slider !== 'function') { return; }
            // Already-initialized sliders carry this data key — skip re-init.
            if ($slider.data('slider')) { return; }

            var $min = $('#min_price_input');
            var $max = $('#max_price_input');
            var $label = $('.price-range-label');

            $slider.slider({ id: 'price-range-slider-widget' }).on('slide', function (e) {
                $min.val(e.value[0]);
                $max.val(e.value[1]);
                $label.text('Price: Rs ' + e.value[0].toLocaleString() + ' — Rs ' + e.value[1].toLocaleString());
            });
        });
    }
    document.addEventListener('DOMContentLoaded', fmInitPriceSlider);
    document.addEventListener('shopContentUpdated', fmInitPriceSlider);
</script>
