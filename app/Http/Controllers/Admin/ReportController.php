<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->get('period', 'daily');
        $from   = $request->get('from');
        $to     = $request->get('to');

        // Only honor explicit from/to when the "Custom Range" period is
        // selected — otherwise the hidden (but still-submitted) date inputs
        // from a previous render would silently override the chosen period.
        if ($period !== 'custom') {
            $from = $to = null;
        }

        // Set default date ranges
        if (!$from || !$to) {
            switch ($period) {
                case 'daily':
                    $from = $to = now()->toDateString();
                    break;
                case 'weekly':
                    $from = now()->startOfWeek()->toDateString();
                    $to   = now()->endOfWeek()->toDateString();
                    break;
                case 'monthly':
                    $from = now()->startOfMonth()->toDateString();
                    $to   = now()->endOfMonth()->toDateString();
                    break;
                default:
                    $from = $to = now()->toDateString();
            }
        }

        $ordersQuery = Order::whereBetween(DB::raw('DATE(created_at)'), [$from, $to])
            ->where('status', '!=', 'cancelled');

        $summary = [
            'total_orders'  => (clone $ordersQuery)->count(),
            'total_revenue' => (clone $ordersQuery)->sum('total_amount'),
            'total_cost'    => (clone $ordersQuery)->sum('total_cost'),
            'total_profit'  => (clone $ordersQuery)->sum('profit'),
            'paid_orders'   => (clone $ordersQuery)->where('payment_status', 'paid')->count(),
        ];

        // Orders by day for chart
        $dailyData = (clone $ordersQuery)
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_amount) as revenue'), DB::raw('SUM(profit) as profit'), DB::raw('COUNT(*) as orders'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Top selling products in range
        $topProducts = OrderItem::whereHas('order', function ($q) use ($from, $to) {
                $q->whereBetween(DB::raw('DATE(created_at)'), [$from, $to])
                  ->where('status', '!=', 'cancelled');
            })
            ->select('product_name', DB::raw('SUM(quantity) as total_qty'), DB::raw('SUM(subtotal) as total_revenue'))
            ->groupBy('product_name')
            ->orderByDesc('total_qty')
            ->limit(10)
            ->get();

        // Profit by product in range — cost, revenue, and profit per product,
        // ranked by profit (not just units sold) so low-margin bestsellers
        // don't hide which products actually make money.
        $productProfit = OrderItem::whereHas('order', function ($q) use ($from, $to) {
                $q->whereBetween(DB::raw('DATE(created_at)'), [$from, $to])
                  ->where('status', '!=', 'cancelled');
            })
            ->select(
                'product_name',
                DB::raw('SUM(quantity) as total_qty'),
                DB::raw('SUM(subtotal) as total_revenue'),
                DB::raw('SUM(quantity * unit_cost) as total_cost'),
                DB::raw('SUM(subtotal) - SUM(quantity * unit_cost) as total_profit')
            )
            ->groupBy('product_name')
            ->orderByDesc('total_profit')
            ->limit(15)
            ->get();

        // Recent orders
        $recentOrders = Order::whereBetween(DB::raw('DATE(created_at)'), [$from, $to])
            ->latest()
            ->limit(10)
            ->get();

        // Low stock products
        $lowStock = Product::where('stock', '<=', 5)->orderBy('stock')->limit(10)->get();

        // Cash on Delivery vs Bank Transfer breakdown
        $byPaymentMethod = (clone $ordersQuery)
            ->select('payment_method',
                DB::raw('COUNT(*) as orders'),
                DB::raw('SUM(total_amount) as revenue'),
                DB::raw('SUM(profit) as profit'))
            ->groupBy('payment_method')
            ->get()
            ->keyBy('payment_method');

        $codReport  = $byPaymentMethod->get('cash');
        $bankReport = $byPaymentMethod->get('bank_transfer');

        return view('admin.reports.index', compact(
            'period', 'from', 'to', 'summary', 'dailyData', 'topProducts', 'productProfit', 'recentOrders', 'lowStock',
            'codReport', 'bankReport'
        ));
    }
}
