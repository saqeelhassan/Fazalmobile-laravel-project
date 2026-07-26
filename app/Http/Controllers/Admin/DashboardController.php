<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_products'    => Product::count(),
            'active_products'   => Product::where('status', 'active')->count(),
            'featured_products' => Product::where('is_featured', true)->count(),
            'out_of_stock'      => Product::where('stock', 0)->count(),
        ];

        $orderStats = [
            'pending_orders' => Order::where('status', 'pending')->count(),
            'today_orders'   => Order::whereDate('created_at', today())->where('status','!=','cancelled')->count(),
            'today_revenue'  => Order::whereDate('created_at', today())->where('status','!=','cancelled')->sum('total_amount'),
            'today_profit'   => Order::whereDate('created_at', today())->where('status','!=','cancelled')->sum('profit'),
            'month_revenue'  => Order::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->where('status','!=','cancelled')->sum('total_amount'),
        ];

        $recent       = Product::latest()->limit(5)->get();
        $recentOrders = Order::with('items')->latest()->limit(5)->get();
        $lowStock     = Product::where('stock', '<=', 3)->orderBy('stock')->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'orderStats', 'recent', 'recentOrders', 'lowStock'));
    }
}
