@extends('admin.layout')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
@if($orderStats['pending_orders'] > 0)
<div class="alert" style="background:#fef3c7;color:#92400e;border-left:4px solid #f59e0b;justify-content:space-between">
    <span><i class="fas fa-exclamation-triangle"></i>
        {{ $orderStats['pending_orders'] }} {{ Str::plural('order', $orderStats['pending_orders']) }} awaiting approval.
    </span>
    <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="btn btn-primary btn-sm">Review Now</a>
</div>
@endif
{{-- Top Stats --}}
<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-icon si-purple"><i class="fas fa-box"></i></div>
        <div class="stat-info"><p>Total Products</p><h3>{{ $stats['total_products'] }}</h3></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon si-green"><i class="fas fa-check-circle"></i></div>
        <div class="stat-info"><p>Active Products</p><h3>{{ $stats['active_products'] }}</h3></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon si-orange"><i class="fas fa-star"></i></div>
        <div class="stat-info"><p>Featured</p><h3>{{ $stats['featured_products'] }}</h3></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon si-red"><i class="fas fa-exclamation-circle"></i></div>
        <div class="stat-info"><p>Out of Stock</p><h3>{{ $stats['out_of_stock'] }}</h3></div>
    </div>
</div>

{{-- Today's Sales --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:18px;margin-bottom:28px">
    <div class="stat-card" style="border-left:4px solid #6c63ff">
        <div class="stat-icon" style="background:linear-gradient(135deg,#6c63ff,#8b5cf6)"><i class="fas fa-receipt"></i></div>
        <div class="stat-info"><p>Today's Orders</p><h3>{{ $orderStats['today_orders'] }}</h3></div>
    </div>
    <div class="stat-card" style="border-left:4px solid #10b981">
        <div class="stat-icon si-green"><i class="fas fa-money-bill-wave"></i></div>
        <div class="stat-info"><p>Today Revenue</p><h3 style="font-size:18px">Rs.{{ number_format($orderStats['today_revenue'],0) }}</h3></div>
    </div>
    <div class="stat-card" style="border-left:4px solid #f59e0b">
        <div class="stat-icon si-orange"><i class="fas fa-chart-line"></i></div>
        <div class="stat-info"><p>Today Profit</p><h3 style="font-size:18px">Rs.{{ number_format($orderStats['today_profit'],0) }}</h3></div>
    </div>
    <div class="stat-card" style="border-left:4px solid #6c63ff">
        <div class="stat-icon" style="background:linear-gradient(135deg,#06b6d4,#0891b2)"><i class="fas fa-calendar-alt"></i></div>
        <div class="stat-info"><p>Month Revenue</p><h3 style="font-size:18px">Rs.{{ number_format($orderStats['month_revenue'],0) }}</h3></div>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px">

    {{-- Recent Orders --}}
    <div class="card">
        <div class="card-header">
            <h2><i class="fas fa-receipt"></i> Recent Orders</h2>
            <a href="{{ route('admin.orders.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> New Order</a>
        </div>
        <div class="card-body">
            <table>
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Customer</th>
                        <th style="text-align:right">Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders as $order)
                    @php $sc=['pending'=>'#fef3c7:#92400e','confirmed'=>'#dbeafe:#1e40af','delivered'=>'#d1fae5:#065f46','cancelled'=>'#fee2e2:#991b1b']; [$bg,$tc]=explode(':',$sc[$order->status]??'#f3f4f6:#374151'); @endphp
                    <tr>
                        <td><a href="{{ route('admin.orders.show',$order) }}" style="color:#6c63ff;font-size:12px;font-weight:600">{{ $order->order_number }}</a></td>
                        <td style="font-size:13px">{{ $order->customer_name }}</td>
                        <td style="text-align:right;font-weight:600">Rs.{{ number_format($order->total_amount,0) }}</td>
                        <td><span style="background:{{ $bg }};color:{{ $tc }};padding:2px 8px;border-radius:20px;font-size:10px;font-weight:600">{{ ucfirst($order->status) }}</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="4" style="text-align:center;padding:20px;color:#9ca3af">No orders yet</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Low Stock --}}
    <div class="card">
        <div class="card-header">
            <h2><i class="fas fa-exclamation-triangle" style="color:#f59e0b"></i> Low Stock Alert</h2>
            <a href="{{ route('admin.inventory.create') }}" class="btn btn-secondary btn-sm"><i class="fas fa-truck-loading"></i> Restock</a>
        </div>
        <div class="card-body">
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th style="text-align:center">Stock</th>
                        <th>Category</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($lowStock as $product)
                    <tr>
                        <td style="font-size:13px"><strong>{{ $product->name }}</strong></td>
                        <td style="text-align:center;font-weight:700;color:{{ $product->stock===0?'#ef4444':'#f59e0b' }}">{{ $product->stock }}</td>
                        <td><span style="background:#ede9fe;color:#5b21b6;padding:2px 8px;border-radius:20px;font-size:10px">{{ $product->category }}</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="3" style="text-align:center;padding:20px;color:#10b981"><i class="fas fa-check-circle"></i> All products well stocked!</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- Recent Products --}}
<div class="card">
    <div class="card-header">
        <h2><i class="fas fa-clock"></i> Recent Products</h2>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add Product</a>
    </div>
    <div class="card-body">
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Price (Rs.)</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recent as $product)
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px">
                            @if($product->image)
                                <img src="{{ Storage::url($product->image) }}" class="product-thumb" alt="">
                            @else
                                <div class="product-thumb" style="display:flex;align-items:center;justify-content:center;color:#d1d5db"><i class="fas fa-image"></i></div>
                            @endif
                            <div>
                                <strong>{{ $product->name }}</strong>
                                @if($product->sku)<div style="font-size:11px;color:#9ca3af">SKU: {{ $product->sku }}</div>@endif
                            </div>
                        </div>
                    </td>
                    <td>{{ $product->category }}</td>
                    <td>
                        Rs. {{ number_format($product->price, 0) }}
                        @if($product->sale_price)
                            <br><span style="color:#ef4444;font-size:12px">Rs. {{ number_format($product->sale_price, 0) }} sale</span>
                        @endif
                    </td>
                    <td>{{ $product->stock }}</td>
                    <td>
                        <span class="badge {{ $product->status === 'active' ? 'badge-active' : ($product->status === 'out_of_stock' ? 'badge-out' : 'badge-inactive') }}">
                            {{ ucwords(str_replace('_', ' ', $product->status)) }}
                        </span>
                        @if($product->is_featured) <span class="badge badge-featured">Featured</span> @endif
                    </td>
                    <td>
                        <div class="action-btns">
                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-secondary btn-sm"><i class="fas fa-edit"></i></a>
                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Delete this product?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" style="text-align:center;padding:30px;color:#9ca3af">No products yet. <a href="{{ route('admin.products.create') }}" style="color:#6c63ff">Add your first product</a></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
