@extends('admin.layout')
@section('title', 'Customers')
@section('page-title', 'Customers')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px">
    <h2 style="font-size:18px;font-weight:700">All Customers ({{ $users->total() }})</h2>
</div>

<form method="GET" class="filters" style="margin-bottom:18px">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Name, email, phone...">
    <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Filter</button>
    @if(request()->hasAny(['search']))
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-times"></i> Clear</a>
    @endif
</form>

<div class="card">
    <div class="card-body">
        <table>
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Contact</th>
                    <th style="text-align:center">Orders</th>
                    <th style="text-align:right">Total Spent</th>
                    <th>Joined</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px">
                            <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,#6c63ff,#a78bfa);display:flex;align-items:center;justify-content:center;color:#fff;font-size:13px;font-weight:700;flex-shrink:0">
                                {{ strtoupper(substr($user->name ?: 'U', 0, 1)) }}
                            </div>
                            <strong style="font-size:13.5px">{{ $user->name }}</strong>
                        </div>
                    </td>
                    <td>
                        <div style="font-size:12.5px;color:#374151">{{ $user->email }}</div>
                        @if($user->phone)
                            <div style="font-size:11px;color:#9ca3af"><i class="fas fa-phone"></i> {{ $user->phone }}</div>
                        @endif
                    </td>
                    <td style="text-align:center">
                        <span style="background:#ede9fe;color:#5b21b6;padding:3px 12px;border-radius:20px;font-size:12px;font-weight:700">
                            {{ $user->orders_count }}
                        </span>
                    </td>
                    <td style="text-align:right">
                        <strong style="color:#6c63ff">Rs. {{ number_format($user->total_spent ?? 0, 0) }}</strong>
                    </td>
                    <td style="font-size:12px;color:#9ca3af;white-space:nowrap">{{ $user->created_at->format('d M Y') }}</td>
                    <td>
                        <div class="action-btns">
                            <a href="{{ route('admin.users.show', $user) }}" class="btn btn-secondary btn-sm" title="View">
                                <i class="fas fa-eye"></i> View
                            </a>
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Delete {{ addslashes($user->name) }}? This cannot be undone.')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" title="Delete"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center;padding:40px;color:#9ca3af">
                        <i class="fas fa-users" style="font-size:30px;display:block;margin-bottom:10px"></i>
                        No registered customers yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($users->hasPages())
<div style="display:flex;align-items:center;justify-content:space-between;padding:16px 22px;background:#fff;border-top:1px solid #f3f4f6">
    <div style="font-size:13px;color:#6b7280">Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }}</div>
    <div style="display:flex;gap:4px">
        @if(!$users->onFirstPage())
            <a href="{{ $users->previousPageUrl() }}" style="padding:6px 12px;border:1px solid #e5e7eb;border-radius:6px;font-size:13px;color:#6b7280;text-decoration:none"><i class="fas fa-chevron-left"></i></a>
        @endif
        @foreach($users->getUrlRange(1,$users->lastPage()) as $page=>$url)
            @if($page==$users->currentPage())
                <span style="padding:6px 13px;border:1px solid #6c63ff;border-radius:6px;font-size:13px;background:#6c63ff;color:#fff;font-weight:600">{{ $page }}</span>
            @else
                <a href="{{ $url }}" style="padding:6px 13px;border:1px solid #e5e7eb;border-radius:6px;font-size:13px;color:#6b7280;text-decoration:none">{{ $page }}</a>
            @endif
        @endforeach
        @if($users->hasMorePages())
            <a href="{{ $users->nextPageUrl() }}" style="padding:6px 12px;border:1px solid #e5e7eb;border-radius:6px;font-size:13px;color:#6b7280;text-decoration:none"><i class="fas fa-chevron-right"></i></a>
        @endif
    </div>
</div>
@endif
@endsection
