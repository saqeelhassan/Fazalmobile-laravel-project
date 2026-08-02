@extends('admin.layout')
@section('title', 'Newsletter Subscribers')
@section('page-title', 'Newsletter Subscribers')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px">
    <h2 style="font-size:18px;font-weight:700">Subscribers ({{ $subscribers->total() }})</h2>
</div>

<form method="GET" class="filters" style="margin-bottom:18px">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by email...">
    <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Filter</button>
    @if(request()->hasAny(['search']))
        <a href="{{ route('admin.subscribers.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-times"></i> Clear</a>
    @endif
</form>

<div class="card">
    <div class="card-body">
        <table>
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Subscribed</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($subscribers as $subscriber)
                <tr>
                    <td><strong style="font-size:13.5px">{{ $subscriber->email }}</strong></td>
                    <td style="font-size:12px;color:#9ca3af;white-space:nowrap">{{ $subscriber->created_at->format('d M Y, h:i A') }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.subscribers.destroy', $subscriber) }}" onsubmit="return confirm('Remove {{ addslashes($subscriber->email) }} from the subscriber list?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" title="Remove"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" style="text-align:center;padding:40px;color:#9ca3af">
                        <i class="fas fa-envelope-open" style="font-size:30px;display:block;margin-bottom:10px"></i>
                        No newsletter subscribers yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($subscribers->hasPages())
<div style="display:flex;align-items:center;justify-content:space-between;padding:16px 22px;background:#fff;border-top:1px solid #f3f4f6">
    <div style="font-size:13px;color:#6b7280">Showing {{ $subscribers->firstItem() }} to {{ $subscribers->lastItem() }} of {{ $subscribers->total() }}</div>
    <div style="display:flex;gap:4px">
        @if(!$subscribers->onFirstPage())
            <a href="{{ $subscribers->previousPageUrl() }}" style="padding:6px 12px;border:1px solid #e5e7eb;border-radius:6px;font-size:13px;color:#6b7280;text-decoration:none"><i class="fas fa-chevron-left"></i></a>
        @endif
        @foreach($subscribers->getUrlRange(1,$subscribers->lastPage()) as $page=>$url)
            @if($page==$subscribers->currentPage())
                <span style="padding:6px 13px;border:1px solid #6c63ff;border-radius:6px;font-size:13px;background:#6c63ff;color:#fff;font-weight:600">{{ $page }}</span>
            @else
                <a href="{{ $url }}" style="padding:6px 13px;border:1px solid #e5e7eb;border-radius:6px;font-size:13px;color:#6b7280;text-decoration:none">{{ $page }}</a>
            @endif
        @endforeach
        @if($subscribers->hasMorePages())
            <a href="{{ $subscribers->nextPageUrl() }}" style="padding:6px 12px;border:1px solid #e5e7eb;border-radius:6px;font-size:13px;color:#6b7280;text-decoration:none"><i class="fas fa-chevron-right"></i></a>
        @endif
    </div>
</div>
@endif
@endsection
