@extends('admin.layout')
@section('title', 'Categories')
@section('page-title', 'Categories')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px">
    <h2 style="font-size:18px;font-weight:700">All Categories ({{ $categories->total() }})</h2>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add Category
    </a>
</div>

<form method="GET" class="filters">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search category name...">
    <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Filter</button>
    @if(request()->hasAny(['search']))
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-times"></i> Clear</a>
    @endif
</form>

<div class="card">
    <div class="card-body">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr>
                    <td style="color:#9ca3af">{{ $category->id }}</td>
                    <td><strong style="font-size:13.5px">{{ $category->name }}</strong></td>
                    <td style="color:#9ca3af;font-size:12px">{{ $category->slug }}</td>
                    <td>
                        <span class="badge {{ $category->status === 'active' ? 'badge-active' : 'badge-inactive' }}">
                            {{ ucfirst($category->status) }}
                        </span>
                    </td>
                    <td style="font-size:12px;color:#9ca3af">{{ $category->created_at->format('M d, Y') }}</td>
                    <td>
                        <div class="action-btns">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-secondary btn-sm" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Delete {{ addslashes($category->name) }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" title="Delete"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center;padding:40px;color:#9ca3af">
                        <i class="fas fa-tags" style="font-size:30px;display:block;margin-bottom:10px"></i>
                        No categories found.
                        <a href="{{ route('admin.categories.create') }}" style="color:#6c63ff;font-weight:600">Add your first category</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($categories->hasPages())
<div style="display:flex;align-items:center;justify-content:space-between;padding:16px 22px;border-top:1px solid #f3f4f6;background:#fff;margin-top:0">
    <div style="font-size:13px;color:#6b7280">
        Showing <strong>{{ $categories->firstItem() }}</strong> to <strong>{{ $categories->lastItem() }}</strong> of <strong>{{ $categories->total() }}</strong> results
    </div>
    <div style="display:flex;gap:4px;align-items:center">
        @if($categories->onFirstPage())
            <span style="padding:6px 12px;border:1px solid #e5e7eb;border-radius:6px;font-size:13px;color:#d1d5db;cursor:not-allowed">
                <i class="fas fa-chevron-left"></i>
            </span>
        @else
            <a href="{{ $categories->previousPageUrl() }}" style="padding:6px 12px;border:1px solid #e5e7eb;border-radius:6px;font-size:13px;color:#6b7280;text-decoration:none">
                <i class="fas fa-chevron-left"></i>
            </a>
        @endif

        @foreach($categories->getUrlRange(1, $categories->lastPage()) as $page => $url)
            @if($page == $categories->currentPage())
                <span style="padding:6px 13px;border:1px solid #6c63ff;border-radius:6px;font-size:13px;background:#6c63ff;color:#fff;font-weight:600">{{ $page }}</span>
            @else
                <a href="{{ $url }}" style="padding:6px 13px;border:1px solid #e5e7eb;border-radius:6px;font-size:13px;color:#6b7280;text-decoration:none">{{ $page }}</a>
            @endif
        @endforeach

        @if($categories->hasMorePages())
            <a href="{{ $categories->nextPageUrl() }}" style="padding:6px 12px;border:1px solid #e5e7eb;border-radius:6px;font-size:13px;color:#6b7280;text-decoration:none">
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
