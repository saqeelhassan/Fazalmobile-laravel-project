@extends('admin.layout')
@section('title', 'Orders')
@section('page-title', 'Orders')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px">
    <h2 style="font-size:18px;font-weight:700">All Orders ({{ $orders->total() }})</h2>
    <a href="{{ route('admin.orders.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> New Order
    </a>
</div>

<form method="GET" class="filters" style="margin-bottom:18px">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Order #, customer name, phone...">
    <select name="status">
        <option value="">All Statuses</option>
        <option value="pending"   {{ request('status')==='pending'   ? 'selected':'' }}>Pending</option>
        <option value="confirmed" {{ request('status')==='confirmed' ? 'selected':'' }}>Confirmed</option>
        <option value="delivered" {{ request('status')==='delivered' ? 'selected':'' }}>Delivered</option>
        <option value="cancelled" {{ request('status')==='cancelled' ? 'selected':'' }}>Cancelled</option>
        <option value="returned"  {{ request('status')==='returned'  ? 'selected':'' }}>Returned</option>
    </select>
    <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Filter</button>
    @if(request()->hasAny(['search','status']))
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-times"></i> Clear</a>
    @endif
</form>

<div class="card">
    <div class="card-body">
        <table>
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Customer</th>
                    <th>Items</th>
                    <th>Total (Rs.)</th>
                    <th>Profit (Rs.)</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td><strong style="font-size:12px;color:#6c63ff">{{ $order->order_number }}</strong></td>
                    <td>
                        <strong style="font-size:13px">{{ $order->customer_name }}</strong>
                        @if($order->customer_phone)
                            <div style="font-size:11px;color:#9ca3af"><i class="fas fa-phone"></i> {{ $order->customer_phone }}</div>
                        @endif
                    </td>
                    <td style="color:#6b7280;font-size:13px">{{ $order->items->count() }} item(s)</td>
                    <td><strong>Rs. {{ number_format($order->total_amount, 0) }}</strong></td>
                    <td>
                        <span style="color:{{ $order->profit >= 0 ? '#10b981':'#ef4444' }};font-weight:600">
                            Rs. {{ number_format($order->profit, 0) }}
                        </span>
                    </td>
                    <td>
                        <span style="font-size:11px">{{ ucfirst(str_replace('_',' ',$order->payment_method)) }}</span>
                        <br>
                        <span style="background:{{ $order->payment_status==='paid' ? '#d1fae5':'#fee2e2' }};color:{{ $order->payment_status==='paid' ? '#065f46':'#991b1b' }};padding:2px 8px;border-radius:20px;font-size:10px;font-weight:600">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </td>
                    <td>
                        @php
                            $sc=['pending'=>'#fef3c7:#92400e','confirmed'=>'#dbeafe:#1e40af','delivered'=>'#d1fae5:#065f46','cancelled'=>'#fee2e2:#991b1b','returned'=>'#ede9fe:#5b21b6'];
                            [$bg,$tc]=explode(':',$sc[$order->status]??'#f3f4f6:#374151');
                        @endphp
                        <span style="background:{{ $bg }};color:{{ $tc }};padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td style="font-size:12px;color:#9ca3af;white-space:nowrap">{{ $order->created_at->format('d M Y') }}</td>
                    <td>
                        <div class="action-btns">
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-secondary btn-sm" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" style="text-align:center;padding:40px;color:#9ca3af">
                        <i class="fas fa-receipt" style="font-size:30px;display:block;margin-bottom:10px"></i>
                        No orders yet. <a href="{{ route('admin.orders.create') }}" style="color:#6c63ff">Create first order</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($orders->hasPages())
<div style="display:flex;align-items:center;justify-content:space-between;padding:16px 22px;background:#fff;border-top:1px solid #f3f4f6">
    <div style="font-size:13px;color:#6b7280">Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of {{ $orders->total() }}</div>
    <div style="display:flex;gap:4px">
        @if(!$orders->onFirstPage())
            <a href="{{ $orders->previousPageUrl() }}" style="padding:6px 12px;border:1px solid #e5e7eb;border-radius:6px;font-size:13px;color:#6b7280;text-decoration:none"><i class="fas fa-chevron-left"></i></a>
        @endif
        @foreach($orders->getUrlRange(1,$orders->lastPage()) as $page=>$url)
            @if($page==$orders->currentPage())
                <span style="padding:6px 13px;border:1px solid #6c63ff;border-radius:6px;font-size:13px;background:#6c63ff;color:#fff;font-weight:600">{{ $page }}</span>
            @else
                <a href="{{ $url }}" style="padding:6px 13px;border:1px solid #e5e7eb;border-radius:6px;font-size:13px;color:#6b7280;text-decoration:none">{{ $page }}</a>
            @endif
        @endforeach
        @if($orders->hasMorePages())
            <a href="{{ $orders->nextPageUrl() }}" style="padding:6px 12px;border:1px solid #e5e7eb;border-radius:6px;font-size:13px;color:#6b7280;text-decoration:none"><i class="fas fa-chevron-right"></i></a>
        @endif
    </div>
</div>
@endif
@endsection
