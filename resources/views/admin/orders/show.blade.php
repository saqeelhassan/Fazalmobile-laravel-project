@extends('admin.layout')
@section('title', 'Order '.$order->order_number)
@section('page-title', 'Order Details')

@section('content')
<div style="margin-bottom:18px;display:flex;gap:10px;align-items:center">
    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Back to Orders
    </a>
    <span style="font-size:16px;font-weight:700;color:#6c63ff">{{ $order->order_number }}</span>
</div>

<div style="display:grid;grid-template-columns:1fr 280px;gap:20px">

    {{-- Left --}}
    <div style="display:flex;flex-direction:column;gap:20px">

        <div class="card">
            <div class="card-body" style="padding:20px">
                <h3 style="font-size:14px;font-weight:700;margin-bottom:16px;color:#1f2937"><i class="fas fa-shopping-cart" style="color:#f59e0b"></i> Order Items</h3>
                <div style="overflow-x:auto">
                <table>
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th style="text-align:center">Qty</th>
                            <th style="text-align:right">Unit Price</th>
                            <th style="text-align:right">Unit Cost</th>
                            <th style="text-align:right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td><strong style="font-size:13px">{{ $item->product_name }}</strong></td>
                            <td style="text-align:center">{{ $item->quantity }}</td>
                            <td style="text-align:right">Rs. {{ number_format($item->unit_price,0) }}</td>
                            <td style="text-align:right;color:#9ca3af">Rs. {{ number_format($item->unit_cost,0) }}</td>
                            <td style="text-align:right;font-weight:700">Rs. {{ number_format($item->subtotal,0) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        @if($order->delivery_charge > 0)
                        <tr style="border-top:2px solid #e5e7eb">
                            <td colspan="4" style="text-align:right;color:#6b7280;padding:12px 16px">Delivery Charge:</td>
                            <td style="text-align:right;color:#6b7280;padding:12px 16px">Rs. {{ number_format($order->delivery_charge,0) }}</td>
                        </tr>
                        @endif
                        @if($order->discount_amount > 0)
                        <tr style="{{ $order->delivery_charge > 0 ? '' : 'border-top:2px solid #e5e7eb' }}">
                            <td colspan="4" style="text-align:right;color:#ef4444;padding:12px 16px">Discount:</td>
                            <td style="text-align:right;color:#ef4444;padding:12px 16px">- Rs. {{ number_format($order->discount_amount,0) }}</td>
                        </tr>
                        @endif
                        <tr style="{{ ($order->delivery_charge > 0 || $order->discount_amount > 0) ? '' : 'border-top:2px solid #e5e7eb' }}">
                            <td colspan="4" style="text-align:right;font-weight:700;padding:12px 16px">Total Revenue:</td>
                            <td style="text-align:right;font-weight:700;font-size:15px;color:#6c63ff;padding:12px 16px">Rs. {{ number_format($order->total_amount,0) }}</td>
                        </tr>
                        <tr>
                            <td colspan="4" style="text-align:right;color:#6b7280;padding:12px 16px">Total Cost:</td>
                            <td style="text-align:right;color:#6b7280;padding:12px 16px">Rs. {{ number_format($order->total_cost,0) }}</td>
                        </tr>
                        <tr>
                            <td colspan="4" style="text-align:right;font-weight:700;padding:12px 16px">Profit:</td>
                            <td style="text-align:right;font-weight:700;color:{{ $order->profit >= 0 ? '#10b981':'#ef4444' }};font-size:15px;padding:12px 16px">
                                Rs. {{ number_format($order->profit,0) }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
                </div>
            </div>
        </div>

        @if($order->notes)
        <div class="card">
            <div class="card-body" style="padding:20px">
                <strong><i class="fas fa-sticky-note"></i> Notes</strong>
                <p style="margin-top:8px;color:#6b7280;font-size:13px">{{ $order->notes }}</p>
            </div>
        </div>
        @endif

    </div>

    {{-- Right --}}
    <div style="display:flex;flex-direction:column;gap:16px">

        <div class="form-card">
            <h3 style="font-size:14px;font-weight:700;margin-bottom:16px;color:#1f2937"><i class="fas fa-user" style="color:#6c63ff"></i> Customer</h3>
            <p style="font-weight:600;margin-bottom:4px">{{ $order->customer_name }}</p>
            @if($order->customer_phone)
                <p style="font-size:13px;color:#6b7280"><i class="fas fa-phone"></i> {{ $order->customer_phone }}</p>
            @endif
            @if($order->customer_address)
                <p style="font-size:13px;color:#6b7280"><i class="fas fa-map-marker-alt"></i> {{ $order->customer_address }}</p>
            @endif
        </div>

        <div class="form-card">
            <h3 style="font-size:14px;font-weight:700;margin-bottom:16px;color:#1f2937"><i class="fas fa-info-circle" style="color:#10b981"></i> Order Info</h3>
            <table style="width:100%;font-size:13px">
                <tr><td style="color:#9ca3af;padding:4px 0">Date</td><td style="text-align:right">{{ $order->created_at->format('d M Y H:i') }}</td></tr>
                <tr><td style="color:#9ca3af;padding:4px 0">Payment</td><td style="text-align:right">{{ ucfirst(str_replace('_',' ',$order->payment_method)) }}</td></tr>
                <tr>
                    <td style="color:#9ca3af;padding:4px 0">Pay Status</td>
                    <td style="text-align:right">
                        <span style="background:{{ $order->payment_status==='paid'?'#d1fae5':'#fee2e2' }};color:{{ $order->payment_status==='paid'?'#065f46':'#991b1b' }};padding:2px 8px;border-radius:20px;font-size:10px;font-weight:600">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </td>
                </tr>
            </table>
        </div>

        <div class="form-card">
            <h3 style="font-size:14px;font-weight:700;margin-bottom:14px;color:#1f2937"><i class="fas fa-sync-alt" style="color:#f59e0b"></i> Update Status</h3>
            <form method="POST" action="{{ route('admin.orders.updateStatus', $order) }}">
                @csrf @method('PATCH')
                <select name="status" style="margin-bottom:10px">
                    <option value="pending"   {{ $order->status==='pending'   ? 'selected':'' }}>Pending</option>
                    <option value="confirmed" {{ $order->status==='confirmed' ? 'selected':'' }}>Confirmed</option>
                    <option value="delivered" {{ $order->status==='delivered' ? 'selected':'' }}>Delivered</option>
                    <option value="cancelled" {{ $order->status==='cancelled' ? 'selected':'' }}>Cancelled</option>
                    <option value="returned"  {{ $order->status==='returned'  ? 'selected':'' }}>Returned</option>
                </select>
                <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center">
                    <i class="fas fa-save"></i> Update
                </button>
            </form>
        </div>

    </div>
</div>
@endsection
