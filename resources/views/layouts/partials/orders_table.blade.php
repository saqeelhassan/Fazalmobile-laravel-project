{{-- Orders table. Requires: $orders (paginated Order collection). Optional: $emptyMessage --}}
@if($orders->count())
<div style="overflow-x:auto">
    <table class="table" style="width:100%;border-collapse:collapse">
        <thead>
            <tr style="border-bottom:2px solid #eee;text-align:left">
                <th style="padding:10px 12px">Order #</th>
                <th style="padding:10px 12px">Placed On</th>
                <th style="padding:10px 12px">Items</th>
                <th style="padding:10px 12px">Total</th>
                <th style="padding:10px 12px">Payment</th>
                <th style="padding:10px 12px">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr style="border-bottom:1px solid #f0f0f0">
                <td style="padding:12px">{{ $order->order_number }}</td>
                <td style="padding:12px">{{ $order->created_at->format('d/m/Y') }}</td>
                <td style="padding:12px">
                    @foreach($order->items as $item)
                        <div style="font-size:13px;color:#666">{{ $item->product_name }} &times; {{ $item->quantity }}</div>
                    @endforeach
                </td>
                <td style="padding:12px">Rs. {{ number_format($order->total_amount, 0) }}</td>
                <td style="padding:12px">
                    <span style="text-transform:capitalize">{{ str_replace('_', ' ', $order->payment_method) }}</span>
                    —
                    <span style="text-transform:capitalize;color:{{ $order->payment_status === 'paid' ? '#1a7f4e' : '#b45309' }}">{{ $order->payment_status }}</span>
                </td>
                <td style="padding:12px">
                    @php
                        $statusColors = [
                            'pending'   => ['#fef3c7', '#92400e'],
                            'confirmed' => ['#dbeafe', '#1e40af'],
                            'delivered' => ['#dcfce7', '#166534'],
                            'cancelled' => ['#fee2e2', '#991b1b'],
                            'returned'  => ['#ede9fe', '#5b21b6'],
                        ];
                        [$bg, $fg] = $statusColors[$order->status] ?? ['#f3f4f6', '#374151'];
                    @endphp
                    <span style="background:{{ $bg }};color:{{ $fg }};padding:4px 12px;border-radius:20px;font-size:12px;font-weight:600;text-transform:capitalize">{{ $order->status }}</span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div style="margin-top:20px">
    {{ $orders->links() }}
</div>
@else
<div style="text-align:center;padding:50px 20px;color:#9ca3af">
    <i class="ion-bag" style="font-size:44px;display:block;margin-bottom:15px"></i>
    <p>{{ $emptyMessage ?? "You haven't placed any orders yet." }}</p>
    <a href="{{ url('/shop') }}" class="btn btn-submit btn-gradient" style="margin-top:10px;display:inline-block">Start Shopping</a>
</div>
@endif
