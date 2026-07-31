<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\BlogPostController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\AuthController as CustomerAuthController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\NewsletterController;
use App\Models\Product;

require __DIR__ . '/install_r.php';

// ── Admin Panel ──────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {

    // Public: login
    Route::get('login',  [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->middleware('throttle:5,1');
    Route::post('logout',[AuthController::class, 'logout'])->name('logout');

    // Protected: requires admin auth
    Route::middleware('admin.auth')->group(function () {
        Route::get('/',         [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('products', ProductController::class)->except(['show']);
        Route::get('products-trash',              [ProductController::class, 'trashed'])->name('products.trashed');
        Route::post('products/{id}/restore',      [ProductController::class, 'restore'])->name('products.restore');
        Route::delete('products/{id}/force-delete',[ProductController::class, 'forceDelete'])->name('products.forceDelete');

        // Categories
        Route::resource('categories', CategoryController::class)->except(['show']);

        // Blog
        Route::resource('blog-posts', BlogPostController::class)->except(['show'])->parameters(['blog-posts' => 'blogPost']);
        Route::get('blog-posts-trash',              [BlogPostController::class, 'trashed'])->name('blog-posts.trashed');
        Route::post('blog-posts/{id}/restore',      [BlogPostController::class, 'restore'])->name('blog-posts.restore');
        Route::delete('blog-posts/{id}/force-delete',[BlogPostController::class, 'forceDelete'])->name('blog-posts.forceDelete');

        // Inventory
        Route::get('inventory',        [InventoryController::class, 'index'])->name('inventory.index');
        Route::get('inventory/add',    [InventoryController::class, 'create'])->name('inventory.create');
        Route::post('inventory',       [InventoryController::class, 'store'])->name('inventory.store');

        // Orders
        Route::get('orders',           [OrderController::class, 'index'])->name('orders.index');
        Route::get('orders/create',    [OrderController::class, 'create'])->name('orders.create');
        Route::post('orders',          [OrderController::class, 'store'])->name('orders.store');
        Route::get('orders/{order}',   [OrderController::class, 'show'])->name('orders.show');
        Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');

        // Reports
        Route::get('reports',          [ReportController::class, 'index'])->name('reports.index');

        // Customers
        Route::get('users',            [AdminUserController::class, 'index'])->name('users.index');
        Route::get('users/{user}',     [AdminUserController::class, 'show'])->name('users.show');
        Route::delete('users/{user}',  [AdminUserController::class, 'destroy'])->name('users.destroy');
    });
});

// ── Frontend ─────────────────────────────────────────────────────
// Homepages
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home2', [HomeController::class, 'index'])->name('home2');

// Core Pages
Route::get('/about', fn() => view('aboutus'))->name('about');
Route::get('/buyer-protection', fn() => view('buyer-protection'))->name('buyer-protection');
Route::get('/cart', fn() => view('cart'))->name('cart');
Route::get('/coming-soon', fn() => view('commingsoon'))->name('coming-soon');
Route::get('/checkout', fn() => view('checkout'))->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/checkout/success/{orderNumber}', [CheckoutController::class, 'success'])->name('checkout.success');
Route::get('/contact', fn() => view('contactus'))->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store')->middleware('throttle:5,1');
Route::post('/newsletter/subscribe', [NewsletterController::class, 'store'])->name('newsletter.subscribe')->middleware('throttle:5,1');
Route::get('/faq', fn() => view('faq'))->name('faq');
Route::get('/returns-exchange', fn() => view('returns-exchange'))->name('returns-exchange');
Route::get('/customer-service', fn() => view('customer-service'))->name('customer-service');
Route::get('/privacy-policy', fn() => view('privacy-policy'))->name('privacy-policy');
Route::get('/wishlist', fn() => view('wishlist'))->name('wishlist');
Route::get('/wishlist-empty', fn() => view('wishlist_empty'))->name('wishlist-empty');
Route::get('/my-account', [AccountController::class, 'index'])->name('my-account');
Route::get('/my-account/profile', [AccountController::class, 'profile'])->name('account.profile');
Route::get('/my-account/returns', [AccountController::class, 'returns'])->name('account.returns');
Route::get('/my-account/cancellations', [AccountController::class, 'cancellations'])->name('account.cancellations');
Route::post('/my-account/profile', [AccountController::class, 'updateProfile'])->name('my-account.profile');
Route::get('/my-account/address-book',  [AddressController::class, 'index'])->name('account.address-book');
Route::post('/my-account/address-book', [AddressController::class, 'store'])->name('account.address-book.store');
Route::post('/my-account/address-book/{address}',                  [AddressController::class, 'update'])->name('account.address-book.update');
Route::post('/my-account/address-book/{address}/delete',           [AddressController::class, 'destroy'])->name('account.address-book.destroy');
Route::post('/my-account/address-book/{address}/default-shipping', [AddressController::class, 'makeDefaultShipping'])->name('account.address-book.default-shipping');
Route::post('/my-account/address-book/{address}/default-billing',  [AddressController::class, 'makeDefaultBilling'])->name('account.address-book.default-billing');
Route::post('/register', [CustomerAuthController::class, 'register'])->name('register')->middleware('throttle:10,1');
Route::post('/login',    [CustomerAuthController::class, 'login'])->name('login')->middleware('throttle:10,1');
Route::post('/logout',   [CustomerAuthController::class, 'logout'])->name('logout');
Route::get('/auth/{provider}',          [SocialiteController::class, 'redirectToProvider'])
    ->whereIn('provider', ['google', 'facebook'])
    ->name('auth.social.redirect');
Route::get('/auth/{provider}/callback', [SocialiteController::class, 'handleProviderCallback'])
    ->whereIn('provider', ['google', 'facebook'])
    ->name('auth.social.callback');
Route::get('/track', fn() => view('track'))->name('track');
Route::get('/404', fn() => view('404'))->name('404');

// Blog Layouts
Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/blog-grid', [BlogController::class, 'grid'])->name('blog-grid');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.post');

// Shop Layouts
Route::get('/shop',                fn(Request $r) => (new ShopController)->index($r, 'shop_full'))->name('shop');
Route::get('/shop-grid-v1',        fn(Request $r) => (new ShopController)->index($r, 'shopgrid_v1'))->name('shop-grid-v1');
Route::get('/shop-grid-v2',        fn(Request $r) => (new ShopController)->index($r, 'shopgrid_v2'))->name('shop-grid-v2');
Route::get('/shop-list',           fn(Request $r) => (new ShopController)->index($r, 'shoplist'))->name('shop-list');
Route::get('/shop-left-sidebar',   fn(Request $r) => (new ShopController)->index($r, 'shopleft_sidebar'))->name('shop-left-sidebar');
Route::get('/shop-right-sidebar',  fn(Request $r) => (new ShopController)->index($r, 'shopright_sidebar'))->name('shop-right-sidebar');

// Promo nav collections
Route::get('/flash-deals',      fn(Request $r) => (new ShopController)->index($r->merge(['collection' => 'sale']), 'shop_full'))->name('flash-deals');
Route::get('/tech-discovery',   fn(Request $r) => (new ShopController)->index($r->merge(['collection' => 'new']), 'shop_full'))->name('tech-discovery');
Route::get('/trending-styles',  fn(Request $r) => (new ShopController)->index($r->merge(['collection' => 'featured']), 'shop_full'))->name('trending-styles');
Route::get('/gift-cards',       fn() => view('gift-cards'))->name('gift-cards');

// Category Layouts
Route::get('/category-fullwidth',       fn(Request $r) => (new ShopController)->index($r, 'cat_fullwidth'))->name('category-fullwidth');
Route::get('/category-left-sidebar',    fn(Request $r) => (new ShopController)->index($r, 'cat_left_sidebar'))->name('category-left-sidebar');
Route::get('/category-right-sidebar',   fn(Request $r) => (new ShopController)->index($r, 'cat_right_sidebar'))->name('category-right-sidebar');

// Product Pages
Route::get('/product/{slug}', function ($slug) {
    $product = Product::where('status', 'active')
        ->where(fn($q) => $q->where('slug', $slug)->orWhere('id', $slug))
        ->firstOrFail();
    $related = Product::where('status', 'active')
        ->where('category', $product->category)
        ->where('id', '!=', $product->id)
        ->take(4)->get();
    return view('product_detail', compact('product', 'related'));
})->name('product.show');

Route::get('/search', fn(Request $r) => (new ShopController)->index($r, 'shop_full'))->name('search');
