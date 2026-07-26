<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request, string $view = 'shop_full')
    {
        $query = Product::visible();

        $category = $request->get('category', '');
        if ($category) {
            $query->where('category', $category);
        }

        $collection = $request->get('collection', '');
        $collectionLabel = match ($collection) {
            'sale'     => 'Flash Deals',
            'featured' => 'Trending Styles',
            'new'      => 'Tech Discovery',
            default    => '',
        };
        match ($collection) {
            'sale'     => $query->where('is_on_sale', true),
            'featured' => $query->where('is_featured', true),
            default    => null,
        };

        $search = $request->get('q', '');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('brand', 'like', '%' . $search . '%');
            });
        }

        $minPrice = $request->get('min_price', '');
        if ($minPrice !== '') {
            $query->whereRaw('COALESCE(sale_price, price) >= ?', [(float) $minPrice]);
        }

        $maxPrice = $request->get('max_price', '');
        if ($maxPrice !== '') {
            $query->whereRaw('COALESCE(sale_price, price) <= ?', [(float) $maxPrice]);
        }

        $sort = $request->get('sort', 'default');
        match ($sort) {
            'price-asc'  => $query->orderBy('price'),
            'price-desc' => $query->orderByDesc('price'),
            'name-asc'   => $query->orderBy('name'),
            'name-desc'  => $query->orderByDesc('name'),
            'newest'     => $query->orderByDesc('created_at'),
            'oldest'     => $query->orderBy('created_at'),
            default      => $collection === 'new'
                ? $query->orderByDesc('created_at')
                : $query->orderByDesc('is_featured')->orderByDesc('created_at'),
        };

        $perPage  = (int) $request->get('per_page', 12);
        $perPage  = in_array($perPage, [12, 24, 36, 48]) ? $perPage : 12;
        $products = $query->paginate($perPage)->withQueryString();

        $categories   = Product::categories();
        $eCatFeatured = Product::visible()->where('is_featured', true)->latest()->take(3)->get();
        $eCatOnSale   = Product::visible()->where('is_on_sale', true)->latest()->take(3)->get();
        $eCatLatest   = Product::visible()->latest()->take(3)->get();

        $categoryImages = collect($categories)->mapWithKeys(function ($cat) {
            $image = Product::visible()
                ->where('category', $cat)
                ->whereNotNull('image')
                ->value('image');

            return [$cat => $image];
        });

        $priceFloor = (int) floor(Product::visible()->min('price') ?? 0);
        $priceCeil  = (int) ceil(Product::visible()->max('price') ?? 0);

        return view($view, compact(
            'products', 'categories', 'category', 'sort', 'perPage', 'search',
            'minPrice', 'maxPrice', 'priceFloor', 'priceCeil', 'categoryImages',
            'collection', 'collectionLabel',
            'eCatFeatured', 'eCatOnSale', 'eCatLatest'
        ));
    }
}
