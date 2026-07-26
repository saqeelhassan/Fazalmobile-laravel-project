<?php

namespace App\Http\Controllers;

use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Product::categories();

        // Products grouped by category (max 6 each), only active
        $byCategory = [];
        foreach ($categories as $cat) {
            $byCategory[$cat] = Product::where('category', $cat)
                ->visible()
                ->orderByDesc('is_featured')
                ->limit(6)
                ->get();
        }

        // Featured products (any category)
        $featured = Product::where('is_featured', true)
            ->visible()
            ->limit(8)
            ->get();

        // Latest active products
        $latest = Product::visible()
            ->latest()
            ->limit(6)
            ->get();

        return view('home2', compact('byCategory', 'featured', 'latest', 'categories'));
    }
}
