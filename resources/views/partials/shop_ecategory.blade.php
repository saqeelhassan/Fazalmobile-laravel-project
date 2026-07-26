{{-- Reusable e-category bottom section. Requires: $eCatFeatured, $eCatOnSale, $eCatLatest --}}
<div class="e-category">
    <div class="container container-240">
        <div class="row">
            <div class="col-xs-12 col-sm-4 col-md-4">
                <h1 class="cate-title">Featured Products</h1>
                @forelse($eCatFeatured as $p)
                <div class="cate-item">
                    <div class="product-img" style="width:80px;height:70px;overflow:hidden;flex-shrink:0">
                        <a href="{{ url('/product') }}">
                            @if($p->image)
                                <img src="{{ Storage::url($p->image) }}" alt="{{ $p->name }}" style="width:80px;height:70px;object-fit:cover">
                            @else
                                <img src="{{ asset('img/product/img-1.jpg') }}" alt="{{ $p->name }}" style="width:80px;height:70px;object-fit:cover">
                            @endif
                        </a>
                    </div>
                    <div class="product-info">
                        <h3 class="product-title"><a href="{{ url('/product') }}">{{ Str::limit($p->name, 40) }}</a></h3>
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
                        <a href="{{ url('/product') }}">
                            @if($p->image)
                                <img src="{{ Storage::url($p->image) }}" alt="{{ $p->name }}" style="width:80px;height:70px;object-fit:cover">
                            @else
                                <img src="{{ asset('img/product/img-1.jpg') }}" alt="{{ $p->name }}" style="width:80px;height:70px;object-fit:cover">
                            @endif
                        </a>
                    </div>
                    <div class="product-info">
                        <h3 class="product-title"><a href="{{ url('/product') }}">{{ Str::limit($p->name, 40) }}</a></h3>
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
                        <a href="{{ url('/product') }}">
                            @if($p->image)
                                <img src="{{ Storage::url($p->image) }}" alt="{{ $p->name }}" style="width:80px;height:70px;object-fit:cover">
                            @else
                                <img src="{{ asset('img/product/img-1.jpg') }}" alt="{{ $p->name }}" style="width:80px;height:70px;object-fit:cover">
                            @endif
                        </a>
                    </div>
                    <div class="product-info">
                        <h3 class="product-title"><a href="{{ url('/product') }}">{{ Str::limit($p->name, 40) }}</a></h3>
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
