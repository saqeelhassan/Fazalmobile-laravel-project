@extends('admin.layout')
@section('title', 'Reports')
@section('page-title', 'Sales & Profit Reports')

@section('content')

{{-- Period Filter --}}
<div class="form-card" style="margin-bottom:20px">
    <form method="GET" style="display:flex;gap:12px;align-items:flex-end;flex-wrap:wrap">
        <div>
            <label style="font-size:12px;font-weight:600;display:block;margin-bottom:4px;color:#6b7280">Period</label>
            <select name="period" onchange="toggleCustom(this)" style="padding:8px 12px;border:1px solid #e5e7eb;border-radius:6px;font-size:13px">
                <option value="daily"   {{ $period==='daily'   ? 'selected':'' }}>Today</option>
                <option value="weekly"  {{ $period==='weekly'  ? 'selected':'' }}>This Week</option>
                <option value="monthly" {{ $period==='monthly' ? 'selected':'' }}>This Month</option>
                <option value="custom"  {{ $period==='custom'  ? 'selected':'' }}>Custom Range</option>
            </select>
        </div>
        <div id="customDates" style="display:{{ $period==='custom'?'flex':'none' }};gap:8px">
            <div>
                <label style="font-size:12px;font-weight:600;display:block;margin-bottom:4px;color:#6b7280">From</label>
                <input type="date" name="from" value="{{ $from }}" style="padding:8px 12px;border:1px solid #e5e7eb;border-radius:6px;font-size:13px">
            </div>
            <div>
                <label style="font-size:12px;font-weight:600;display:block;margin-bottom:4px;color:#6b7280">To</label>
                <input type="date" name="to" value="{{ $to }}" style="padding:8px 12px;border:1px solid #e5e7eb;border-radius:6px;font-size:13px">
            </div>
        </div>
        <button type="submit" class="btn btn-primary"><i class="fas fa-chart-bar"></i> Generate Report</button>
    </form>
</div>

{{-- Period Label --}}
<div style="margin-bottom:16px;font-size:13px;color:#9ca3af">
    <i class="fas fa-calendar"></i>
    Showing: <strong style="color:#1f2937">{{ \Carbon\Carbon::parse($from)->format('d M Y') }}</strong>
    @if($from !== $to) to <strong style="color:#1f2937">{{ \Carbon\Carbon::parse($to)->format('d M Y') }}</strong> @endif
</div>

{{-- Summary Cards --}}
<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:24px">
    <div class="card" style="border-top:4px solid #6c63ff">
        <div class="card-body" style="padding:18px 20px">
            <div style="font-size:11px;color:#9ca3af;text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px">Total Orders</div>
            <div style="font-size:30px;font-weight:700;color:#1f2937">{{ $summary['total_orders'] }}</div>
            <div style="font-size:12px;color:#9ca3af">Excluding cancelled</div>
        </div>
    </div>
    <div class="card" style="border-top:4px solid #10b981">
        <div class="card-body" style="padding:18px 20px">
            <div style="font-size:11px;color:#9ca3af;text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px">Revenue</div>
            <div style="font-size:22px;font-weight:700;color:#10b981">Rs. {{ number_format($summary['total_revenue'],0) }}</div>
            <div style="font-size:12px;color:#9ca3af">Total sales amount</div>
        </div>
    </div>
    <div class="card" style="border-top:4px solid #f59e0b">
        <div class="card-body" style="padding:18px 20px">
            <div style="font-size:11px;color:#9ca3af;text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px">Total Cost</div>
            <div style="font-size:22px;font-weight:700;color:#f59e0b">Rs. {{ number_format($summary['total_cost'],0) }}</div>
            <div style="font-size:12px;color:#9ca3af">Product purchase cost</div>
        </div>
    </div>
    <div class="card" style="border-top:4px solid {{ $summary['total_profit'] >= 0 ? '#6c63ff':'#ef4444' }}">
        <div class="card-body" style="padding:18px 20px">
            <div style="font-size:11px;color:#9ca3af;text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px">Net Profit</div>
            <div style="font-size:22px;font-weight:700;color:{{ $summary['total_profit'] >= 0 ? '#6c63ff':'#ef4444' }}">
                Rs. {{ number_format($summary['total_profit'],0) }}
            </div>
            @php $margin = $summary['total_revenue'] > 0 ? round(($summary['total_profit']/$summary['total_revenue'])*100,1) : 0; @endphp
            <div style="font-size:12px;color:#9ca3af">Margin: {{ $margin }}%</div>
        </div>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px">

    {{-- Daily Breakdown --}}
    <div class="card">
        <div class="card-body" style="padding:20px">
            <h3 style="font-size:14px;font-weight:700;margin-bottom:16px;color:#1f2937">
                <i class="fas fa-calendar-day" style="color:#6c63ff"></i> Daily Breakdown
            </h3>
            @if($dailyData->isEmpty())
                <div style="text-align:center;padding:30px;color:#9ca3af">
                    <i class="fas fa-chart-line" style="font-size:28px;display:block;margin-bottom:8px"></i>
                    No sales in this period
                </div>
            @else
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th style="text-align:center">Orders</th>
                        <th style="text-align:right">Revenue (Rs.)</th>
                        <th style="text-align:right">Profit (Rs.)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dailyData as $day)
                    <tr>
                        <td style="font-size:13px">{{ \Carbon\Carbon::parse($day->date)->format('d M Y') }}</td>
                        <td style="text-align:center">{{ $day->orders }}</td>
                        <td style="text-align:right;font-weight:600">{{ number_format($day->revenue,0) }}</td>
                        <td style="text-align:right;color:{{ $day->profit >= 0 ? '#10b981':'#ef4444' }};font-weight:600">{{ number_format($day->profit,0) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr style="border-top:2px solid #e5e7eb;font-weight:700">
                        <td>Total</td>
                        <td style="text-align:center">{{ $summary['total_orders'] }}</td>
                        <td style="text-align:right">{{ number_format($summary['total_revenue'],0) }}</td>
                        <td style="text-align:right;color:{{ $summary['total_profit']>=0?'#10b981':'#ef4444' }}">{{ number_format($summary['total_profit'],0) }}</td>
                    </tr>
                </tfoot>
            </table>
            @endif
        </div>
    </div>

    {{-- Top Products --}}
    <div class="card">
        <div class="card-body" style="padding:20px">
            <h3 style="font-size:14px;font-weight:700;margin-bottom:16px;color:#1f2937">
                <i class="fas fa-trophy" style="color:#f59e0b"></i> Top Selling Products
            </h3>
            @if($topProducts->isEmpty())
                <div style="text-align:center;padding:30px;color:#9ca3af">
                    <i class="fas fa-box-open" style="font-size:28px;display:block;margin-bottom:8px"></i>
                    No sales data available
                </div>
            @else
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Product</th>
                        <th style="text-align:center">Units</th>
                        <th style="text-align:right">Revenue (Rs.)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topProducts as $i => $product)
                    <tr>
                        <td style="color:#9ca3af;font-weight:700">{{ $i+1 }}</td>
                        <td style="font-size:13px">{{ $product->product_name }}</td>
                        <td style="text-align:center;font-weight:700">{{ $product->total_qty }}</td>
                        <td style="text-align:right;font-weight:600">{{ number_format($product->total_revenue,0) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>

</div>

{{-- Low Stock Alert --}}
@if($lowStock->isNotEmpty())
<div class="card" style="margin-top:20px;border-left:4px solid #f59e0b">
    <div class="card-body" style="padding:20px">
        <h3 style="font-size:14px;font-weight:700;margin-bottom:16px;color:#92400e">
            <i class="fas fa-exclamation-triangle" style="color:#f59e0b"></i> Low Stock Alert
        </h3>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Category</th>
                    <th style="text-align:center">Stock Left</th>
                    <th>Cost Price (Rs.)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lowStock as $product)
                <tr>
                    <td><strong style="font-size:13px">{{ $product->name }}</strong></td>
                    <td><span style="background:#ede9fe;color:#5b21b6;padding:2px 8px;border-radius:20px;font-size:11px">{{ $product->category }}</span></td>
                    <td style="text-align:center">
                        <span style="font-weight:700;color:{{ $product->stock===0?'#ef4444':'#f59e0b' }}">{{ $product->stock }}</span>
                    </td>
                    <td>{{ $product->cost_price > 0 ? 'Rs. '.number_format($product->cost_price,0) : '—' }}</td>
                    <td>
                        <a href="{{ route('admin.inventory.create') }}?product_id={{ $product->id }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-plus"></i> Restock
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

{{-- Recent Orders --}}
@if($recentOrders->isNotEmpty())
<div class="card" style="margin-top:20px">
    <div class="card-body">
        <h3 style="font-size:14px;font-weight:700;margin-bottom:16px;color:#1f2937">
            <i class="fas fa-receipt" style="color:#6c63ff"></i> Orders in This Period
        </h3>
        <table>
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Customer</th>
                    <th>Status</th>
                    <th style="text-align:right">Amount (Rs.)</th>
                    <th style="text-align:right">Profit (Rs.)</th>
                    <th>Date</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentOrders as $order)
                @php $sc=['pending'=>'#fef3c7:#92400e','confirmed'=>'#dbeafe:#1e40af','delivered'=>'#d1fae5:#065f46','cancelled'=>'#fee2e2:#991b1b']; [$bg,$tc]=explode(':',$sc[$order->status]??'#f3f4f6:#374151'); @endphp
                <tr>
                    <td><strong style="font-size:12px;color:#6c63ff">{{ $order->order_number }}</strong></td>
                    <td style="font-size:13px">{{ $order->customer_name }}</td>
                    <td><span style="background:{{ $bg }};color:{{ $tc }};padding:2px 8px;border-radius:20px;font-size:11px;font-weight:600">{{ ucfirst($order->status) }}</span></td>
                    <td style="text-align:right;font-weight:600">{{ number_format($order->total_amount,0) }}</td>
                    <td style="text-align:right;color:{{ $order->profit>=0?'#10b981':'#ef4444' }};font-weight:600">{{ number_format($order->profit,0) }}</td>
                    <td style="font-size:12px;color:#9ca3af">{{ $order->created_at->format('d M H:i') }}</td>
                    <td><a href="{{ route('admin.orders.show', $order) }}" class="btn btn-secondary btn-sm"><i class="fas fa-eye"></i></a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

<script>
function toggleCustom(sel) {
    document.getElementById('customDates').style.display = sel.value === 'custom' ? 'flex' : 'none';
}
</script>
@endsection
