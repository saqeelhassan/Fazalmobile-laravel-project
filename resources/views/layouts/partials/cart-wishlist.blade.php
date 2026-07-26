<style>
    .fm-toast {
        position: fixed;
        top: 90px;
        right: 20px;
        z-index: 99999;
        background: #1c1c28;
        color: #fff;
        padding: 12px 20px;
        border-radius: 8px;
        font-size: 13.5px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.25);
        opacity: 0;
        transform: translateY(-8px);
        transition: all 0.25s ease;
        pointer-events: none;
    }
    .fm-toast.show { opacity: 1; transform: translateY(0); }
    .fm-toast.error { background: #c0392b; }
</style>
<div class="fm-toast" id="fmToast"></div>
<script>
jQuery(function ($) {
    var CART_KEY = 'fm_cart';
    var WISHLIST_KEY = 'fm_wishlist';

    function readStore(key) {
        try {
            var raw = localStorage.getItem(key);
            return raw ? JSON.parse(raw) : [];
        } catch (e) {
            return [];
        }
    }
    function writeStore(key, data) {
        try {
            localStorage.setItem(key, JSON.stringify(data));
        } catch (e) {}
    }
    function getCart() { return readStore(CART_KEY); }
    function saveCart(cart) { writeStore(CART_KEY, cart); updateCartUI(); }
    function getWishlist() { return readStore(WISHLIST_KEY); }
    function saveWishlist(list) { writeStore(WISHLIST_KEY, list); updateWishlistUI(); }

    var toastTimer = null;
    function toast(msg, isError) {
        var $t = $('#fmToast');
        $t.text(msg).toggleClass('error', !!isError).addClass('show');
        clearTimeout(toastTimer);
        toastTimer = setTimeout(function () { $t.removeClass('show'); }, 1800);
    }

    function updateCartUI() {
        var cart = getCart();
        var totalQty = cart.reduce(function (n, i) { return n + (i.qty || 1); }, 0);
        $('.cart-count').text(totalQty);

        var $menu = $('.dropdown-cart');
        if (!$menu.length) return;
        if (!cart.length) {
            $menu.html('<p style="padding:30px 15px;margin:0;text-align:center;color:#888">Your cart is empty.</p>' +
                '<div class="bottom-cart"><div class="button-cart">' +
                '<a href="{{ url('/shop') }}" class="cart-btn e-checkout btn-gradient">Shop now</a></div></div>');
            return;
        }
        var subtotal = cart.reduce(function (n, i) { return n + (parseFloat(i.price) || 0) * (i.qty || 1); }, 0);
        var rows = cart.map(function (i) {
            return '<div class="item-cart-mini" style="display:flex;align-items:center;padding:10px 15px;border-bottom:1px solid #f0f0f0">' +
                '<img src="' + i.image + '" alt="" style="width:44px;height:44px;object-fit:cover;border-radius:4px;margin-right:10px">' +
                '<div style="flex:1;font-size:12.5px;color:#333">' + i.name + '<br><span style="color:#888">Qty: ' + (i.qty || 1) + ' × Rs. ' + Number(i.price).toLocaleString() + '</span></div>' +
                '<a href="#" class="js-remove-cart" data-id="' + i.id + '" style="color:#c0392b;font-size:16px;line-height:1">&times;</a>' +
                '</div>';
        }).join('');
        $menu.html(rows +
            '<div style="padding:12px 15px;font-weight:600;display:flex;justify-content:space-between">' +
            '<span>Subtotal</span><span>Rs. ' + Number(subtotal).toLocaleString() + '</span></div>' +
            '<div class="bottom-cart"><div class="button-cart">' +
            '<a href="{{ url('/cart') }}" class="cart-btn e-checkout btn-gradient">View Cart</a></div></div>');
    }

    function updateWishlistUI() {
        var list = getWishlist();
        $('.wishlist-count').text(list.length);
        var ids = list.map(function (i) { return String(i.id); });
        $('.js-wishlist-toggle').each(function () {
            var $btn = $(this);
            var active = ids.indexOf(String($btn.data('id'))) !== -1;
            $btn.toggleClass('active', active);
            $btn.find('i').attr('class', active ? 'ion-ios-heart' : 'ion-ios-heart-outline');
        });
    }

    function readProductFromBtn($btn) {
        return {
            id: $btn.data('id'),
            name: $btn.data('name'),
            price: $btn.data('price'),
            image: $btn.data('image'),
            url: $btn.data('url')
        };
    }

    // Add to cart
    $(document).on('click', '.js-add-to-cart', function (e) {
        e.preventDefault();
        var $btn = $(this);
        if (parseInt($btn.data('stock'), 10) === 0) {
            toast('This product is out of stock.', true);
            return;
        }
        var product = readProductFromBtn($btn);
        var cart = getCart();
        var existing = cart.find(function (i) { return String(i.id) === String(product.id); });
        if (existing) {
            existing.qty = (existing.qty || 1) + 1;
        } else {
            product.qty = 1;
            cart.push(product);
        }
        saveCart(cart);
        toast(product.name + ' added to cart.');

        $btn.addClass('added');
        setTimeout(function () { $btn.removeClass('added'); }, 900);
    });

    // Remove from cart (mini cart dropdown)
    $(document).on('click', '.js-remove-cart', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        var cart = getCart().filter(function (i) { return String(i.id) !== String(id); });
        saveCart(cart);
        if (typeof window.fmRenderCartPage === 'function') window.fmRenderCartPage();
    });

    // Toggle wishlist
    $(document).on('click', '.js-wishlist-toggle', function (e) {
        e.preventDefault();
        var $btn = $(this);
        var product = readProductFromBtn($btn);
        var list = getWishlist();
        var idx = list.findIndex(function (i) { return String(i.id) === String(product.id); });
        if (idx === -1) {
            list.push(product);
            toast(product.name + ' added to wishlist.');
        } else {
            list.splice(idx, 1);
            toast(product.name + ' removed from wishlist.');
        }
        saveWishlist(list);
        if (typeof window.fmRenderWishlistPage === 'function') window.fmRenderWishlistPage();
    });

    window.fmGetCart = getCart;
    window.fmSaveCart = saveCart;
    window.fmGetWishlist = getWishlist;
    window.fmSaveWishlist = saveWishlist;
    window.fmToast = toast;

    updateCartUI();
    updateWishlistUI();
});
</script>
