{{-- Reusable shop sidebar. Requires: $categories, $category, $eCatLatest --}}
<div class="col-md-3 col-sm-3 col-xs-12 col-left collection-sidebar" id="filter-sidebar">
    <div class="close-sidebar-collection hidden-lg hidden-md">
        <span>filter</span><i class="icon_close ion-close"></i>
    </div>
    <div class="filter filter-cate">
        <ul class="wiget-content v2">
            <li class="{{ !$category ? 'active' : '' }}">
                <a href="{{ url('/shop') }}">All Products</a>
            </li>
            @foreach($categories as $cat)
            <li class="{{ $category === $cat ? 'active' : '' }}">
                <a href="{{ url('/shop') }}?category={{ urlencode($cat) }}">{{ $cat }}</a>
            </li>
            @endforeach
        </ul>
    </div>
    <div class="filter filter-product e-category">
        <h1 class="widget-blog-title">Top Products</h1>
        @forelse($eCatLatest->take(5) as $p)
        <div class="cate-item">
            <div class="product-img" style="width:70px;height:60px;overflow:hidden;flex-shrink:0">
                <a href="{{ url('/product') }}">
                    @if($p->image)
                        <img src="{{ Storage::url($p->image) }}" alt="{{ $p->name }}" style="width:70px;height:60px;object-fit:cover">
                    @else
                        <img src="{{ asset('img/product/img-1.jpg') }}" alt="{{ $p->name }}" style="width:70px;height:60px;object-fit:cover">
                    @endif
                </a>
            </div>
            <div class="product-info">
                <h3 class="product-title"><a href="{{ url('/product') }}">{{ Str::limit($p->name, 35) }}</a></h3>
                <div class="product-price v2">
                    @if($p->sale_price)
                        <span>Rs. {{ number_format($p->sale_price, 0) }}</span>
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
    <div class="banner">
        <a class="image-bd hover-images" href=""><img src="{{ asset('img/o-banner3.jpg') }}" alt="" class="img-reponsive"></a>
    </div>
</div>
