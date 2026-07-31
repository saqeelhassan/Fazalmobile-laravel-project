@extends('admin.layout')
@section('title', 'Products')
@section('page-title', 'Products')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px">
    <h2 style="font-size:18px;font-weight:700">All Products ({{ $products->total() }})</h2>
    <div style="display:flex;gap:10px">
        @if($trashedCount > 0)
        <a href="{{ route('admin.products.trashed') }}" class="btn btn-secondary btn-sm" style="background:#fee2e2;color:#dc2626">
            <i class="fas fa-trash-restore"></i> Trash ({{ $trashedCount }})
        </a>
        @endif
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Product
        </a>
    </div>
</div>

<form method="GET" class="filters">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name, SKU, brand...">
    <select name="category">
        <option value="">All Categories</option>
        @foreach(\App\Models\Category::orderBy('name')->pluck('name') as $cat)
            <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
        @endforeach
    </select>
    <select name="status">
        <option value="">All Statuses</option>
        <option value="active"       {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
        <option value="inactive"     {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
        <option value="out_of_stock" {{ request('status') === 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
    </select>
    <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Filter</button>
    @if(request()->hasAny(['search','category','status']))
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-times"></i> Clear</a>
    @endif
</form>

<div class="card">
    <div class="card-body">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td style="color:#9ca3af">{{ $product->id }}</td>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px">
                            @if($product->image)
                                <img src="{{ Storage::url($product->image) }}" class="product-thumb" alt="">
                            @else
                                <div class="product-thumb" style="display:flex;align-items:center;justify-content:center;color:#d1d5db;font-size:18px"><i class="fas fa-image"></i></div>
                            @endif
                            <div>
                                <strong style="font-size:13.5px">{{ $product->name }}</strong>
                                @if($product->brand)<div style="font-size:11px;color:#9ca3af">{{ $product->brand }}</div>@endif
                                @if($product->sku)<div style="font-size:11px;color:#9ca3af">SKU: {{ $product->sku }}</div>@endif
                            </div>
                        </div>
                    </td>
                    <td><span style="background:#ede9fe;color:#5b21b6;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600">{{ $product->category }}</span></td>
                    <td>
                        <strong>Rs. {{ number_format($product->price, 0) }}</strong>
                        @if($product->sale_price)
                            <br><span style="color:#ef4444;font-size:12px">Rs. {{ number_format($product->sale_price, 0) }} sale</span>
                        @endif
                    </td>
                    <td>
                        <span style="color: {{ $product->stock === 0 ? '#ef4444' : ($product->stock < 5 ? '#f59e0b' : '#10b981') }}; font-weight:600">
                            {{ $product->stock }}
                        </span>
                    </td>
                    <td>
                        <span class="badge {{ $product->status === 'active' ? 'badge-active' : ($product->status === 'out_of_stock' ? 'badge-out' : 'badge-inactive') }}">
                            {{ ucwords(str_replace('_',' ',$product->status)) }}
                        </span>
                        @if($product->is_featured) <span class="badge badge-featured">★ Featured</span> @endif
                        @if($product->is_on_sale) <span class="badge" style="background:#fef3c7;color:#92400e">Sale</span> @endif
                    </td>
                    <td style="font-size:12px;color:#9ca3af">{{ $product->created_at->format('M d, Y') }}</td>
                    <td>
                        <div class="action-btns" style="gap:14px">
                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-secondary btn-sm" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('This will move \'{{ addslashes($product->name) }}\' to Trash. Continue?')" style="margin-left:6px">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" title="Move to Trash"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center;padding:40px;color:#9ca3af">
                        <i class="fas fa-box-open" style="font-size:30px;display:block;margin-bottom:10px"></i>
                        No products found.
                        <a href="{{ route('admin.products.create') }}" style="color:#6c63ff;font-weight:600">Add your first product</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

{{-- Pagination --}}
@if($products->hasPages())
<div style="display:flex;align-items:center;justify-content:space-between;padding:16px 22px;border-top:1px solid #f3f4f6;background:#fff;margin-top:0">
    <div style="font-size:13px;color:#6b7280">
        Showing <strong>{{ $products->firstItem() }}</strong> to <strong>{{ $products->lastItem() }}</strong> of <strong>{{ $products->total() }}</strong> results
    </div>
    <div style="display:flex;gap:4px;align-items:center">
        {{-- Previous --}}
        @if($products->onFirstPage())
            <span style="padding:6px 12px;border:1px solid #e5e7eb;border-radius:6px;font-size:13px;color:#d1d5db;cursor:not-allowed">
                <i class="fas fa-chevron-left"></i>
            </span>
        @else
            <a href="{{ $products->previousPageUrl() }}" style="padding:6px 12px;border:1px solid #e5e7eb;border-radius:6px;font-size:13px;color:#6b7280;text-decoration:none;transition:all .2s" onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='transparent'">
                <i class="fas fa-chevron-left"></i>
            </a>
        @endif

        {{-- Page numbers --}}
        @foreach($products->getUrlRange(1, $products->lastPage()) as $page => $url)
            @if($page == $products->currentPage())
                <span style="padding:6px 13px;border:1px solid #6c63ff;border-radius:6px;font-size:13px;background:#6c63ff;color:#fff;font-weight:600">{{ $page }}</span>
            @else
                <a href="{{ $url }}" style="padding:6px 13px;border:1px solid #e5e7eb;border-radius:6px;font-size:13px;color:#6b7280;text-decoration:none;transition:all .2s" onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='transparent'">{{ $page }}</a>
            @endif
        @endforeach

        {{-- Next --}}
        @if($products->hasMorePages())
            <a href="{{ $products->nextPageUrl() }}" style="padding:6px 12px;border:1px solid #e5e7eb;border-radius:6px;font-size:13px;color:#6b7280;text-decoration:none;transition:all .2s" onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='transparent'">
                <i class="fas fa-chevron-right"></i>
            </a>
        @else
            <span style="padding:6px 12px;border:1px solid #e5e7eb;border-radius:6px;font-size:13px;color:#d1d5db;cursor:not-allowed">
                <i class="fas fa-chevron-right"></i>
            </span>
        @endif
    </div>
</div>
@endif
@endsection
