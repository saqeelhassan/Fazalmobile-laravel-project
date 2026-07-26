{{-- Reusable product grid partial. Requires: $products (paginated), $sort, $perPage --}}
@once
<style>
    .js-wishlist-toggle.active .icon-love {
        opacity: 1 !important;
        filter: brightness(0) saturate(100%) invert(24%) sepia(85%) saturate(4500%) hue-rotate(340deg) brightness(1.05);
    }
    .js-add-to-cart.added { opacity: 1 !important; }
</style>
@endonce
<div class="product-collection-grid product-grid spc1">
    <div class="row equal-cards">
        @forelse($products as $product)
        <div class="col-xs-6 col-sm-6 col-md-4 col-lg-3 product-item">
            <div class="product-inner">
                <div class="product-img" style="position:relative;width:100%;height:220px;overflow:hidden;background:#f8f8f8">
                    @if($product->stock == 0)
                        <span class="product-badge badge-out">Out of Stock</span>
                    @elseif($product->is_on_sale)
                        <span class="product-badge badge-sale">Sale</span>
                    @elseif($product->is_featured)
                        <span class="product-badge badge-new">Featured</span>
                    @endif
                    <a href="{{ url('/product') }}">
                        @if($product->image)
                            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" style="width:100%;height:220px;object-fit:cover;object-position:center">
                        @else
                            <img src="{{ asset('img/product/img-1.jpg') }}" alt="{{ $product->name }}" style="width:100%;height:220px;object-fit:cover;object-position:center">
                        @endif
                    </a>
                    <div class="product-action">
                        <div class="action-love">
                            <a href="#" title="Wishlist" class="js-wishlist-toggle"
                               data-id="{{ $product->id }}"
                               data-name="{{ $product->name }}"
                               data-price="{{ $product->sale_price ?: $product->price }}"
                               data-image="{{ $product->image ? Storage::url($product->image) : asset('img/product/img-1.jpg') }}"
                               data-url="{{ url('/product') }}"><span class="icon-bg icon-love"></span></a>
                        </div>
                        <div class="action-center">
                            <a href="#" title="Add to Cart" class="btn btn-add-to-cart js-add-to-cart"
                               data-id="{{ $product->id }}"
                               data-name="{{ $product->name }}"
                               data-price="{{ $product->sale_price ?: $product->price }}"
                               data-image="{{ $product->image ? Storage::url($product->image) : asset('img/product/img-1.jpg') }}"
                               data-url="{{ url('/product') }}"
                               data-stock="{{ $product->stock }}">Add To Cart</a>
                            <a href="{{ url('/product') }}" class="btn btn-quick-view">Quick View</a>
                        </div>
                        <div class="action-compare">
                            <a href="#" title="Compare"><span class="icon-bg icon-compare"></span></a>
                        </div>
                    </div>
                </div>
                <div class="pd-bd">
                    <h3 class="pd-title"><a href="{{ url('/product') }}">{{ $product->name }}</a></h3>
                    @if($product->brand)
                        <p style="font-size:12px;color:#9ca3af;margin:2px 0 4px">{{ $product->brand }}</p>
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
