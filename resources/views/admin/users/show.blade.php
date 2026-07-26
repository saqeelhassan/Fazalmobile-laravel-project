@extends('admin.layout')
@section('title', $user->name)
@section('page-title', 'Customer Details')

@section('content')
<div style="margin-bottom:18px;display:flex;gap:10px;align-items:center;justify-content:space-between">
    <div style="display:flex;gap:10px;align-items:center">
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Back to Customers
        </a>
        <span style="font-size:16px;font-weight:700;color:#6c63ff">{{ $user->name }}</span>
    </div>
    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Delete {{ addslashes($user->name) }}? This cannot be undone.')">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete Customer</button>
    </form>
</div>

@php
    $totalSpent = $orders->sum('total_amount');
@endphp

<div class="stat-grid" style="grid-template-columns:repeat(3,1fr)">
    <div class="stat-card">
        <div class="stat-icon si-purple"><i class="fas fa-receipt"></i></div>
        <div class="stat-info">
            <p>Total Orders</p>
            <h3>{{ $user->orders_count }}</h3>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon si-green"><i class="fas fa-wallet"></i></div>
        <div class="stat-info">
            <p>Total Spent</p>
            <h3 style="font-size:20px">Rs. {{ number_format($orders->sum('total_amount'), 0) }}</h3>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon si-orange"><i class="fas fa-calendar-check"></i></div>
        <div class="stat-info">
            <p>Customer Since</p>
            <h3 style="font-size:16px">{{ $user->created_at->format('d M Y') }}</h3>
        </div>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 280px;gap:20px">

    {{-- Left: Orders --}}
    <div style="display:flex;flex-direction:column;gap:20px">
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-receipt"></i> Order History</h2>
            </div>
            <div class="card-body">
                <table>
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Items</th>
                            <th style="text-align:right">Total</th>
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
                            <td style="color:#6b7280;font-size:13px">{{ $order->items->count() }} item(s)</td>
                            <td style="text-align:right"><strong>Rs. {{ number_format($order->total_amount, 0) }}</strong></td>
                            <td>
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
                                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-secondary btn-sm" title="View"><i class="fas fa-eye"></i></a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" style="text-align:center;padding:40px;color:#9ca3af">
                                <i class="fas fa-inbox" style="font-size:28px;display:block;margin-bottom:8px"></i>
                                This customer hasn't placed any orders yet.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($orders->hasPages())
        <div style="display:flex;align-items:center;justify-content:space-between;padding:16px 22px;background:#fff;border-radius:12px;box-shadow:0 1px 4px rgba(0,0,0,0.07)">
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
    </div>

    {{-- Right: Profile --}}
    <div style="display:flex;flex-direction:column;gap:16px">
        <div class="form-card" style="text-align:center">
            <div style="width:70px;height:70px;border-radius:50%;background:linear-gradient(135deg,#6c63ff,#a78bfa);display:flex;align-items:center;justify-content:center;color:#fff;font-size:26px;font-weight:700;margin:0 auto 14px">
                {{ strtoupper(substr($user->name ?: 'U', 0, 1)) }}
            </div>
            <h3 style="font-size:15px;font-weight:700;margin-bottom:4px">{{ $user->name }}</h3>
            <p style="font-size:12.5px;color:#9ca3af">Customer #{{ $user->id }}</p>
        </div>

        <div class="form-card">
            <h3 style="font-size:14px;font-weight:700;margin-bottom:16px;color:#1f2937"><i class="fas fa-address-card" style="color:#6c63ff"></i> Contact Info</h3>
            <div style="display:flex;flex-direction:column;gap:12px;font-size:13px">
                <div>
                    <span style="color:#9ca3af;display:block;font-size:11px;margin-bottom:2px">Email</span>
                    <span style="color:#374151;word-break:break-all">{{ $user->email }}</span>
                </div>
                @if($user->phone)
                <div>
                    <span style="color:#9ca3af;display:block;font-size:11px;margin-bottom:2px">Phone</span>
                    <span style="color:#374151"><i class="fas fa-phone"></i> {{ $user->phone }}</span>
                </div>
                @endif
                @if($user->address || $user->city)
                <div>
                    <span style="color:#9ca3af;display:block;font-size:11px;margin-bottom:2px">Address</span>
                    <span style="color:#374151">{{ trim(($user->address ?? '').' '.($user->city ?? '')) }}</span>
                </div>
                @endif
                <div>
                    <span style="color:#9ca3af;display:block;font-size:11px;margin-bottom:2px">Joined</span>
                    <span style="color:#374151">{{ $user->created_at->format('d M Y, h:i A') }}</span>
                </div>
            </div>
        </div>

        <div class="form-card">
            <h3 style="font-size:14px;font-weight:700;margin-bottom:14px;color:#1f2937"><i class="fas fa-bell" style="color:#f59e0b"></i> Marketing Preferences</h3>
            <div style="display:flex;flex-direction:column;gap:10px;font-size:12.5px">
                <div style="display:flex;justify-content:space-between;align-items:center">
                    <span style="color:#6b7280">Email marketing</span>
                    @if($user->receive_marketing_emails)
                        <span style="background:#d1fae5;color:#065f46;padding:2px 10px;border-radius:20px;font-size:11px;font-weight:600">Subscribed</span>
                    @else
                        <span style="background:#f3f4f6;color:#6b7280;padding:2px 10px;border-radius:20px;font-size:11px;font-weight:600">Not subscribed</span>
                    @endif
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center">
                    <span style="color:#6b7280">SMS marketing</span>
                    @if($user->receive_marketing_sms)
                        <span style="background:#d1fae5;color:#065f46;padding:2px 10px;border-radius:20px;font-size:11px;font-weight:600">Subscribed</span>
                    @else
                        <span style="background:#f3f4f6;color:#6b7280;padding:2px 10px;border-radius:20px;font-size:11px;font-weight:600">Not subscribed</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
