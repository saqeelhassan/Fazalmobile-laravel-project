@php
    $pageTitle    = 'Shop — Fazal Mobile';
    $currentPage  = 'shop';
    $headerClass  = 'header-v5';
    $extraCss     = ['css/bootstrap-slider.css'];
    $extraScripts = ['js/bootstrap-slider.min.js'];
@endphp
@extends('layouts.app')

@section('content')
<!--content-->
        <div class="container container-240">
            <div class="e-product">
                <ul class="breadcrumb v4">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li class="active">{{ $collectionLabel ?: 'Shop' }}</li>
                </ul>
                <div class="pd-banner">
                   <a href="#" class="image-bd effect_img2"><img src="{{ asset('img/shop-banner.jpg') }}" alt="" class="img-reponsive"></a>
                </div>
                <div id="shop-content">
                <div class="pd-top">
                    <h1 class="title">
                        @if($search)
                            Search results for "{{ $search }}"
                        @elseif($collectionLabel)
                            {{ $collectionLabel }}
                        @elseif($category)
                            {{ $category }}
                        @else
                            Shop
                        @endif
                    </h1>
                    <div class="show-element">
                        <span>Showing {{ $products->firstItem() }}–{{ $products->lastItem() }} of {{ $products->total() }} results</span>
                    </div>
                </div>
                <div class="row">
                @include('partials.shop_full_sidebar')
                <div class="col-md-9 col-sm-9 col-xs-12 col-right">
                <div class="pd-middle">
                    <div class="view-mode view-group">
                        <a class="grid-icon col active"><img src="{{ asset('img/grid.png') }}" alt=""></a>
                        <a class="grid-icon col2"><img src="{{ asset('img/grid2.png') }}" alt=""></a>
                        <a class="list-icon list"><img src="{{ asset('img/list.png') }}" alt=""></a>
                    </div>

                    {{-- Category filter --}}
                    <div class="pd-sort">
                        <div class="filter-sort">
                            <div class="dropdown">
                                <button class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <span class="dropdown-label">{{ $category ?: 'All Categories' }}</span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a href="{{ url('/shop') }}?sort={{ $sort }}&per_page={{ $perPage }}">All Categories</a></li>
                                    @foreach($categories as $cat)
                                        <li><a href="{{ url('/shop') }}?category={{ urlencode($cat) }}&sort={{ $sort }}&per_page={{ $perPage }}">{{ $cat }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="filter-sort">
                            <div class="dropdown">
                                <button class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <span class="dropdown-label">
                                        @php
                                            $sortLabels = [
                                                'default'    => 'Default sorting',
                                                'price-asc'  => 'Price: Low to High',
                                                'price-desc' => 'Price: High to Low',
                                                'name-asc'   => 'Name: A–Z',
                                                'name-desc'  => 'Name: Z–A',
                                                'newest'     => 'Newest First',
                                                'oldest'     => 'Oldest First',
                                            ];
                                        @endphp
                                        {{ $sortLabels[$sort] ?? 'Default sorting' }}
                                    </span>
                                </button>
                                <ul class="dropdown-menu">
                                    @foreach($sortLabels as $key => $label)
                                        <li><a href="{{ url('/shop') }}?{{ http_build_query(array_merge(request()->query(), ['sort' => $key])) }}">{{ $label }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="filter-show">
                            <div class="dropdown">
                                <button class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    Show <span class="dropdown-label">{{ $perPage }}</span>
                                </button>
                                <ul class="dropdown-menu">
                                    @foreach([12, 24, 36, 48] as $n)
                                        <li><a href="{{ url('/shop') }}?{{ http_build_query(array_merge(request()->query(), ['per_page' => $n])) }}">{{ $n }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Product Grid --}}
                <div class="product-collection-grid product-grid spc1">
                    <div class="row equal-cards">
                        @forelse($products as $product)
                        <div class="col-xs-6 col-sm-4 col-md-4 col-lg-3 product-item">
                            <div class="product-inner">
                                <div class="product-img" style="position:relative;width:100%;height:220px;overflow:hidden;background:#f8f8f8">
                                    @if($product->stock == 0)
                                        <span class="product-badge badge-out">Out of Stock</span>
                                    @elseif($product->is_on_sale)
                                        <span class="product-badge badge-sale">Sale</span>
                                    @elseif($product->is_featured)
                                        <span class="product-badge badge-new">Featured</span>
                                    @endif
                                    <a href="{{ url('/product/' . $product->slug) }}" class="js-quickview"
                                       data-id="{{ $product->id }}"
                                       data-name="{{ $product->name }}"
                                       data-cate="{{ $product->category }}"
                                       data-brand="{{ $product->brand }}"
                                       data-stock="{{ $product->stock }}"
                                       data-price="Rs. {{ number_format($product->sale_price ?: $product->price, 0) }}"
                                       data-price-raw="{{ $product->sale_price ?: $product->price }}"
                                       data-oldprice="{{ $product->sale_price ? 'Rs. ' . number_format($product->price, 0) : '' }}"
                                       data-desc="{{ Str::limit(trim(strip_tags(str_replace(['\r\n', '\n'], ' ', $product->short_description ?: $product->description))), 180) }}"
                                       data-image="{{ $product->image ? Storage::url($product->image) : asset('img/product/img-1.jpg') }}"
                                       data-url="{{ url('/product/' . $product->slug) }}">
                                        @if($product->image)
                                            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" style="width:100%;height:220px;object-fit:cover;object-position:center">
                                        @else
                                            <img src="{{ asset('img/product/img-1.jpg') }}" alt="{{ $product->name }}" style="width:100%;height:220px;object-fit:cover;object-position:center">
                                        @endif
                                    </a>
                                    @include('layouts.partials.product-actions', ['product' => $product])
                                </div>
                                <div class="pd-bd" style="display:flex;flex-direction:column">
                                    <h3 class="pd-title">
                                        <a href="{{ url('/product/' . $product->slug) }}">{{ $product->name }}</a>
                                    </h3>
                                    @if($product->brand)
                                        <p class="pd-brand" style="font-size:12px;color:#9ca3af;margin:2px 0 4px">{{ $product->brand }}</p>
                                    @endif
                                    <div class="pd-price">
                                        @if($product->sale_price)
                                            <span>Rs. {{ number_format($product->sale_price, 0) }}</span>
                                            <del>Rs. {{ number_format($product->price, 0) }}</del>
                                        @else
                                            <span>Rs. {{ number_format($product->price, 0) }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-xs-12" style="text-align:center;padding:60px 20px;color:#9ca3af">
                            <i class="ion-android-sad" style="font-size:48px;display:block;margin-bottom:15px"></i>
                            <h3 style="font-size:20px;margin-bottom:8px">No products found</h3>
                            <p>Try a different category or search term.</p>
                            <a href="{{ url('/shop') }}" class="btn btn-primary" style="margin-top:15px">View All Products</a>
                        </div>
                        @endforelse
                    </div>
                </div>

                {{-- Pagination --}}
                @if($products->hasPages())
                <div class="pd-middle space-v1">
                    <ul class="pagination">
                        @if($products->onFirstPage())
                            <li class="disabled"><span><i class="ion-ios-arrow-back"></i></span></li>
                        @else
                            <li><a href="{{ $products->previousPageUrl() }}"><i class="ion-ios-arrow-back"></i></a></li>
                        @endif

                        @foreach($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                            <li class="{{ $page == $products->currentPage() ? 'active' : '' }}">
                                <a href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endforeach

                        @if($products->hasMorePages())
                            <li><a href="{{ $products->nextPageUrl() }}"><i class="ion-ios-arrow-forward"></i></a></li>
                        @else
                            <li class="disabled"><span><i class="ion-ios-arrow-forward"></i></span></li>
                        @endif
                    </ul>
                    <div class="pd-sort">
                        <div class="filter-show">
                            <div class="dropdown">
                                <button class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    Show <span class="dropdown-label">{{ $perPage }}</span>
                                </button>
                                <ul class="dropdown-menu">
                                    @foreach([12, 24, 36, 48] as $n)
                                        <li><a href="{{ url('/shop') }}?{{ http_build_query(array_merge(request()->query(), ['per_page' => $n])) }}">{{ $n }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                </div>
                </div>
                </div>

            </div>
        </div>

        {{-- E-Category Section --}}
        <div class="e-category">
            <div class="container container-240">
                <div class="row">
                    <div class="col-xs-12 col-sm-4 col-md-4">
                        <h1 class="cate-title">Featured Products</h1>
                        @forelse($eCatFeatured as $p)
                        <div class="cate-item">
                            <div class="product-img" style="width:80px;height:70px;overflow:hidden;flex-shrink:0">
                                <a href="{{ url('/product/' . $p->slug) }}">
                                    @if($p->image)
                                        <img src="{{ Storage::url($p->image) }}" alt="{{ $p->name }}" style="width:80px;height:70px;object-fit:cover">
                                    @else
                                        <img src="{{ asset('img/product/img-1.jpg') }}" alt="{{ $p->name }}" style="width:80px;height:70px;object-fit:cover">
                                    @endif
                                </a>
                            </div>
                            <div class="product-info">
                                <h3 class="product-title"><a href="{{ url('/product/' . $p->slug) }}">{{ Str::limit($p->name, 40) }}</a></h3>
                                <div class="product-price v2">
                                    @if($p->sale_price)
                                        <span>Rs. {{ number_format($p->sale_price, 0) }}</span>
                                        <del>Rs. {{ number_format($p->price, 0) }}</del>
                                    @else
                                        <span>Rs. {{ number_format($p->price, 0) }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @empty
                        <p style="color:#9ca3af;font-size:13px;padding:10px 0">No featured products yet.</p>
                        @endforelse
                    </div>

                    <div class="col-xs-12 col-sm-4 col-md-4">
                        <h1 class="cate-title">On Sale</h1>
                        @forelse($eCatOnSale as $p)
                        <div class="cate-item">
                            <div class="product-img" style="width:80px;height:70px;overflow:hidden;flex-shrink:0">
                                <a href="{{ url('/product/' . $p->slug) }}">
                                    @if($p->image)
                                        <img src="{{ Storage::url($p->image) }}" alt="{{ $p->name }}" style="width:80px;height:70px;object-fit:cover">
                                    @else
                                        <img src="{{ asset('img/product/img-1.jpg') }}" alt="{{ $p->name }}" style="width:80px;height:70px;object-fit:cover">
                                    @endif
                                </a>
                            </div>
                            <div class="product-info">
                                <h3 class="product-title"><a href="{{ url('/product/' . $p->slug) }}">{{ Str::limit($p->name, 40) }}</a></h3>
                                <div class="product-price v2">
                                    @if($p->sale_price)
                                        <span>Rs. {{ number_format($p->sale_price, 0) }}</span>
                                        <del>Rs. {{ number_format($p->price, 0) }}</del>
                                    @else
                                        <span>Rs. {{ number_format($p->price, 0) }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @empty
                        <p style="color:#9ca3af;font-size:13px;padding:10px 0">No sale products yet.</p>
                        @endforelse
                    </div>

                    <div class="col-xs-12 col-sm-4 col-md-4">
                        <h1 class="cate-title">Latest Products</h1>
                        @forelse($eCatLatest as $p)
                        <div class="cate-item">
                            <div class="product-img" style="width:80px;height:70px;overflow:hidden;flex-shrink:0">
                                <a href="{{ url('/product/' . $p->slug) }}">
                                    @if($p->image)
                                        <img src="{{ Storage::url($p->image) }}" alt="{{ $p->name }}" style="width:80px;height:70px;object-fit:cover">
                                    @else
                                        <img src="{{ asset('img/product/img-1.jpg') }}" alt="{{ $p->name }}" style="width:80px;height:70px;object-fit:cover">
                                    @endif
                                </a>
                            </div>
                            <div class="product-info">
                                <h3 class="product-title"><a href="{{ url('/product/' . $p->slug) }}">{{ Str::limit($p->name, 40) }}</a></h3>
                                <div class="product-price v2">
                                    @if($p->sale_price)
                                        <span>Rs. {{ number_format($p->sale_price, 0) }}</span>
                                        <del>Rs. {{ number_format($p->price, 0) }}</del>
                                    @else
                                        <span>Rs. {{ number_format($p->price, 0) }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @empty
                        <p style="color:#9ca3af;font-size:13px;padding:10px 0">No products yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var content = document.getElementById('shop-content');
    if (!content) return;

    function loadShopContent(url, push) {
        content.style.transition = 'opacity .15s ease';
        content.style.opacity = '0.4';

        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(function (r) { return r.text(); })
            .then(function (html) {
                var doc = new DOMParser().parseFromString(html, 'text/html');
                var fresh = doc.getElementById('shop-content');
                if (!fresh) { window.location.href = url; return; }

                content.innerHTML = fresh.innerHTML;
                content.style.opacity = '1';
                if (push) history.pushState({ fmShopUrl: url }, '', url);

                var newTitle = doc.querySelector('title');
                if (newTitle) document.title = newTitle.textContent;

                window.scrollTo({ top: content.getBoundingClientRect().top + window.scrollY - 100, behavior: 'smooth' });
                document.dispatchEvent(new CustomEvent('shopContentUpdated'));
            })
            .catch(function () { window.location.href = url; });
    }

    // Only the category sidebar switches without a full reload — sort,
    // per-page and pagination links are left as normal navigation.
    document.addEventListener('click', function (e) {
        var link = e.target.closest('#filter-sidebar .cate-list-thumb a');
        if (!link) return;
        e.preventDefault();
        loadShopContent(link.getAttribute('href'), true);
    });

    window.addEventListener('popstate', function () {
        loadShopContent(location.href, false);
    });
});
</script>
@endsection
