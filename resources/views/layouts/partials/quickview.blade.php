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
                    <a href="#" id="qvViewFull" class="qv-btn btn-gradient">View Full Details</a>
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
            $('#productQuickView').modal('show');
        });
    });
</script>
