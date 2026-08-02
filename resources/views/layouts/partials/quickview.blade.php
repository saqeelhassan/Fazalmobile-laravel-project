<style>
    #productQuickView .modal-dialog { width: 820px; max-width: 95%; }
    #productQuickView .modal-content { border-radius: 10px; overflow: hidden; border: none; }
    #productQuickView .qv-close {
        position: absolute; top: 12px; right: 16px;
        font-size: 26px; color: #999; cursor: pointer; z-index: 5;
        background: none; border: none; line-height: 1;
    }
    #productQuickView .qv-close:hover { color: #333; }
    #productQuickView .qv-body { display: flex; }
    #productQuickView .qv-img {
        width: 46%; flex-shrink: 0;
        background: #f8f8f8;
        display: flex; align-items: center; justify-content: center;
        min-height: 380px;
    }
    #productQuickView .qv-img img { width: 100%; height: 380px; object-fit: contain; }
    #productQuickView .qv-info { padding: 32px 30px; flex: 1; }
    #productQuickView .qv-cate { color: #f96f5d; font-size: 11px; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 6px; }
    #productQuickView .qv-name { font-size: 21px; font-weight: 700; color: #1c1c28; line-height: 1.35; margin: 0 0 12px; }
    #productQuickView .qv-price { font-size: 22px; font-weight: 700; color: #1c1c28; margin-bottom: 14px; }
    #productQuickView .qv-price .old { font-size: 15px; color: #9ca3af; text-decoration: line-through; font-weight: 400; margin-left: 8px; }
    #productQuickView .qv-desc { color: #6b6f7e; font-size: 13.5px; line-height: 1.75; margin-bottom: 14px; max-height: 110px; overflow: hidden; }
    #productQuickView .qv-meta { font-size: 13px; color: #3a3d4a; margin-bottom: 18px; }
    #productQuickView .qv-meta div { padding: 2px 0; }
    #productQuickView .qv-meta span { color: #9ca3af; display: inline-block; width: 90px; }
    #productQuickView .qv-stock-in  { color: #16a34a; font-weight: 600; }
    #productQuickView .qv-stock-out { color: #ef4444; font-weight: 600; }
    #productQuickView .qv-btn {
        display: inline-block;
        border-radius: 999px;
        padding: 0 26px;
        height: 44px; line-height: 44px;
        font-size: 14px; font-weight: 600;
        color: #fff !important; text-decoration: none !important;
    }
    #productQuickView .qv-btns { display: flex; gap: 10px; flex-wrap: wrap; }
    #productQuickView .qv-btn-cart { background: #1c1c28; border: none; cursor: pointer; }
    #productQuickView .qv-btn-cart:disabled { opacity: .5; cursor: not-allowed; }
    #productQuickView .qv-btn-wish {
        width: 44px; height: 44px; border-radius: 50%;
        display: inline-flex; align-items: center; justify-content: center;
        background: #f3f4f6; color: #333 !important; font-size: 19px;
        text-decoration: none !important; flex-shrink: 0;
    }
    #productQuickView .qv-btn-wish.active { color: #fb2637 !important; }
    #productQuickView .qv-btn-view-cart {
        background: #16a34a;
        display: none;
        align-items: center;
        gap: 6px;
    }
    #productQuickView .qv-btn-view-cart.show { display: inline-flex; }
    #productQuickView .qv-btn-link {
        display: inline-block;
        margin-top: 12px;
        font-size: 13.5px;
        font-weight: 600;
        color: #6c63ff !important;
        text-decoration: none !important;
    }
    #productQuickView .qv-btn-link:hover { text-decoration: underline !important; }
    @media (max-width: 767px) {
        #productQuickView .qv-body { flex-direction: column; }
        #productQuickView .qv-img { width: 100%; min-height: 240px; }
        #productQuickView .qv-img img { height: 240px; }
    }
</style>
<div class="modal fade" id="productQuickView" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="position:relative">
            <button type="button" class="qv-close" data-dismiss="modal" aria-label="Close">&times;</button>
            <div class="qv-body">
                <div class="qv-img"><img id="qvImage" src="" alt=""></div>
                <div class="qv-info">
                    <p class="qv-cate" id="qvCate"></p>
                    <h3 class="qv-name" id="qvName"></h3>
                    <div class="qv-price">
                        <span id="qvPrice"></span>
                        <span class="old" id="qvOldPrice" style="display:none"></span>
                    </div>
                    <p class="qv-desc" id="qvDesc" style="display:none"></p>
                    <div class="qv-meta">
                        <div><span>Availability:</span> <em id="qvStock" style="font-style:normal"></em></div>
                        <div id="qvBrandRow" style="display:none"><span>Brand:</span> <em id="qvBrand" style="font-style:normal"></em></div>
                    </div>
                    <div class="qv-btns">
                        <button type="button" id="qvAddToCart" class="qv-btn qv-btn-cart js-add-to-cart" data-view-cart-target="#qvViewCart">
                            <i class="ion-ios-cart-outline"></i> Add to Cart
                        </button>
                        <a href="#" id="qvWishlist" class="qv-btn-wish js-wishlist-toggle" title="Add to Wishlist">
                            <i class="ion-ios-heart-outline"></i>
                        </a>
                        <a href="{{ url('/cart') }}" id="qvViewCart" class="qv-btn qv-btn-view-cart">
                            <i class="ion-ios-checkmark-outline"></i> View Cart
                        </a>
                    </div>
                    <a href="#" id="qvViewFull" class="qv-btn-link">View Full Details &rarr;</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    jQuery(function ($) {
        $(document).on('click', '.js-quickview', function (e) {
            e.preventDefault();
            var d = $(this).data();

            $('#qvImage').attr('src', d.image).attr('alt', d.name);
            $('#qvCate').text(d.cate || '');
            $('#qvName').text(d.name || '');
            $('#qvPrice').text(d.price || '');
            $('#qvOldPrice').toggle(!!d.oldprice).text(d.oldprice || '');
            $('#qvDesc').toggle(!!d.desc).text(d.desc || '');
            $('#qvBrandRow').toggle(!!d.brand);
            $('#qvBrand').text(d.brand || '');

            var inStock = parseInt(d.stock, 10) > 0;
            $('#qvStock')
                .text(inStock ? 'In Stock' : 'Out of Stock')
                .attr('class', inStock ? 'qv-stock-in' : 'qv-stock-out');

            $('#qvViewFull').attr('href', d.url);

            $('#qvAddToCart, #qvWishlist').each(function () {
                $(this).data({ id: d.id, name: d.name, price: d.priceRaw, image: d.image, url: d.url });
            });
            $('#qvAddToCart')
                .data('stock', d.stock)
                .prop('disabled', !inStock)
                .html(inStock
                    ? '<i class="ion-ios-cart-outline"></i> Add to Cart'
                    : '<i class="ion-ios-cart-outline"></i> Out of Stock');

            var inWishlist = window.fmGetWishlist
                ? window.fmGetWishlist().some(function (i) { return String(i.id) === String(d.id); })
                : false;
            $('#qvWishlist')
                .toggleClass('active', inWishlist)
                .find('i').attr('class', inWishlist ? 'ion-ios-heart' : 'ion-ios-heart-outline');

            $('#qvViewCart').removeClass('show');

            $('#productQuickView').modal('show');
        });
    });
</script>
