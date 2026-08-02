@extends('admin.layout')
@section('title', 'Inventory')
@section('page-title', 'Inventory Management')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px">
    <h2 style="font-size:18px;font-weight:700">Stock Transactions</h2>
    <a href="{{ route('admin.inventory.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add Stock (Purchase)
    </a>
</div>

{{-- Stock Level Cards --}}
@php
    $lowStock   = \App\Models\Product::where('stock','<=',5)->where('stock','>',0)->count();
    $outOfStock = \App\Models\Product::where('stock',0)->count();
    $inStock    = \App\Models\Product::where('stock','>',5)->count();
@endphp
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:24px">
    <div class="card" style="border-left:4px solid #10b981">
        <div class="card-body" style="padding:16px 20px">
            <div style="font-size:11px;color:#9ca3af;text-transform:uppercase;letter-spacing:.5px">In Stock</div>
            <div style="font-size:28px;font-weight:700;color:#10b981">{{ $inStock }}</div>
            <div style="font-size:12px;color:#9ca3af">Products with stock &gt; 5</div>
        </div>
    </div>
    <div class="card" style="border-left:4px solid #f59e0b">
        <div class="card-body" style="padding:16px 20px">
            <div style="font-size:11px;color:#9ca3af;text-transform:uppercase;letter-spacing:.5px">Low Stock</div>
            <div style="font-size:28px;font-weight:700;color:#f59e0b">{{ $lowStock }}</div>
            <div style="font-size:12px;color:#9ca3af">Products with 1–5 units left</div>
        </div>
    </div>
    <div class="card" style="border-left:4px solid #ef4444">
        <div class="card-body" style="padding:16px 20px">
            <div style="font-size:11px;color:#9ca3af;text-transform:uppercase;letter-spacing:.5px">Out of Stock</div>
            <div style="font-size:28px;font-weight:700;color:#ef4444">{{ $outOfStock }}</div>
            <div style="font-size:12px;color:#9ca3af">Products with 0 units</div>
        </div>
    </div>
</div>

{{-- Filters --}}
<form method="GET" class="filters" style="margin-bottom:18px">
    <select name="type">
        <option value="">All Types</option>
        <option value="purchase"   {{ request('type')==='purchase'   ? 'selected':'' }}>Purchase (Stock In)</option>
        <option value="sale"       {{ request('type')==='sale'       ? 'selected':'' }}>Sale (Stock Out)</option>
        <option value="adjustment" {{ request('type')==='adjustment' ? 'selected':'' }}>Adjustment</option>
        <option value="return"     {{ request('type')==='return'     ? 'selected':'' }}>Return</option>
    </select>
    <select name="product_id">
        <option value="">All Products</option>
        @foreach($products as $p)
            <option value="{{ $p->id }}" {{ request('product_id')==$p->id ? 'selected':'' }}>{{ $p->name }}</option>
        @endforeach
    </select>
    <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Filter</button>
    @if(request()->hasAny(['type','product_id']))
        <a href="{{ route('admin.inventory.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-times"></i> Clear</a>
    @endif
</form>

<div class="card">
    <div class="card-body">
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Product</th>
                    <th>Type</th>
                    <th>Qty</th>
                    <th>Unit Cost (Rs.)</th>
                    <th>Reference</th>
                    <th>Notes</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $tx)
                <tr>
                    <td style="font-size:12px;color:#9ca3af;white-space:nowrap">{{ $tx->created_at->format('d M Y H:i') }}</td>
                    <td>
                        <strong style="font-size:13px">{{ $tx->product->name ?? 'Deleted' }}</strong>
                        @if($tx->product)
                            <div style="font-size:11px;color:#9ca3af">Stock now: {{ $tx->product->stock }}</div>
                        @endif
                    </td>
                    <td>
                        @php
                            $typeColors = ['purchase'=>'#d1fae5:#065f46','sale'=>'#fee2e2:#991b1b','adjustment'=>'#dbeafe:#1e40af','return'=>'#fef3c7:#92400e'];
                            [$bg,$text] = explode(':', $typeColors[$tx->type] ?? '#f3f4f6:#374151');
                        @endphp
                        <span style="background:{{ $bg }};color:{{ $text }};padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;text-transform:capitalize">
                            {{ $tx->type }}
                        </span>
                    </td>
                    <td>
                        <span style="font-weight:700;color:{{ $tx->quantity > 0 ? '#10b981' : '#ef4444' }}">
                            {{ $tx->quantity > 0 ? '+' : '' }}{{ $tx->quantity }}
                        </span>
                    </td>
                    <td>{{ $tx->unit_cost > 0 ? 'Rs. '.number_format($tx->unit_cost,0) : '—' }}</td>
                    <td style="font-size:12px">{{ $tx->reference_number ?? '—' }}</td>
                    <td style="font-size:12px;color:#6b7280">{{ $tx->notes ?? '—' }}</td>
                    <td>
                        @if($tx->type === 'sale')
                            <span style="font-size:11px;color:#9ca3af" title="Tied to an order — cannot be edited or deleted here">Order sale</span>
                        @else
                            <div class="action-btns">
                                <a href="{{ route('admin.inventory.edit', $tx) }}" class="btn btn-secondary btn-sm" title="Edit"><i class="fas fa-pen"></i></a>
                                <form method="POST" action="{{ route('admin.inventory.destroy', $tx) }}" onsubmit="return confirm('Delete this stock transaction? This will reverse its effect on {{ addslashes($tx->product->name ?? 'the product') }}\'s stock.')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Delete"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center;padding:40px;color:#9ca3af">
                        <i class="fas fa-boxes" style="font-size:30px;display:block;margin-bottom:10px"></i>
                        No transactions yet. <a href="{{ route('admin.inventory.create') }}" style="color:#6c63ff">Add stock</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($transactions->hasPages())
<div style="display:flex;align-items:center;justify-content:space-between;padding:16px 22px;background:#fff;border-top:1px solid #f3f4f6">
    <div style="font-size:13px;color:#6b7280">Showing {{ $transactions->firstItem() }} to {{ $transactions->lastItem() }} of {{ $transactions->total() }}</div>
    <div style="display:flex;gap:4px">
        @if(!$transactions->onFirstPage())
            <a href="{{ $transactions->previousPageUrl() }}" style="padding:6px 12px;border:1px solid #e5e7eb;border-radius:6px;font-size:13px;color:#6b7280;text-decoration:none"><i class="fas fa-chevron-left"></i></a>
        @endif
        @foreach($transactions->getUrlRange(1,$transactions->lastPage()) as $page=>$url)
            @if($page==$transactions->currentPage())
                <span style="padding:6px 13px;border:1px solid #6c63ff;border-radius:6px;font-size:13px;background:#6c63ff;color:#fff;font-weight:600">{{ $page }}</span>
            @else
                <a href="{{ $url }}" style="padding:6px 13px;border:1px solid #e5e7eb;border-radius:6px;font-size:13px;color:#6b7280;text-decoration:none">{{ $page }}</a>
            @endif
        @endforeach
        @if($transactions->hasMorePages())
            <a href="{{ $transactions->nextPageUrl() }}" style="padding:6px 12px;border:1px solid #e5e7eb;border-radius:6px;font-size:13px;color:#6b7280;text-decoration:none"><i class="fas fa-chevron-right"></i></a>
        @endif
    </div>
</div>
@endif
@endsection
