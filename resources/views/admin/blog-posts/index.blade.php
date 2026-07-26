@extends('admin.layout')
@section('title', 'Blog Posts')
@section('page-title', 'Blog Posts')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px">
    <h2 style="font-size:18px;font-weight:700">All Blog Posts ({{ $posts->total() }})</h2>
    <div style="display:flex;gap:10px">
        @if($trashedCount > 0)
        <a href="{{ route('admin.blog-posts.trashed') }}" class="btn btn-secondary btn-sm" style="background:#fee2e2;color:#dc2626">
            <i class="fas fa-trash-restore"></i> Trash ({{ $trashedCount }})
        </a>
        @endif
        <a href="{{ route('admin.blog-posts.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Blog Post
        </a>
    </div>
</div>

<form method="GET" class="filters">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search title, author...">
    <select name="category">
        <option value="">All Categories</option>
        @foreach(\App\Models\BlogPost::categories() as $cat)
            <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
        @endforeach
    </select>
    <select name="status">
        <option value="">All Statuses</option>
        <option value="active"   {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive (Draft)</option>
    </select>
    <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Filter</button>
    @if(request()->hasAny(['search','category','status']))
        <a href="{{ route('admin.blog-posts.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-times"></i> Clear</a>
    @endif
</form>

<div class="card">
    <div class="card-body">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Post</th>
                    <th>Category</th>
                    <th>Author</th>
                    <th>Status</th>
                    <th>Published</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($posts as $post)
                <tr>
                    <td style="color:#9ca3af">{{ $post->id }}</td>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px">
                            @if($post->image)
                                <img src="{{ Storage::url($post->image) }}" class="product-thumb" alt="">
                            @else
                                <div class="product-thumb" style="display:flex;align-items:center;justify-content:center;color:#d1d5db;font-size:18px"><i class="fas fa-newspaper"></i></div>
                            @endif
                            <div>
                                <strong style="font-size:13.5px">{{ $post->title }}</strong>
                                <div style="font-size:11px;color:#9ca3af">/blog/{{ $post->slug }}</div>
                            </div>
                        </div>
                    </td>
                    <td>@if($post->category)<span style="background:#ede9fe;color:#5b21b6;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600">{{ $post->category }}</span>@endif</td>
                    <td style="font-size:12.5px">{{ $post->author_name }}</td>
                    <td>
                        <span class="badge {{ $post->status === 'active' ? 'badge-active' : 'badge-inactive' }}">
                            {{ ucfirst($post->status) }}
                        </span>
                        @if($post->is_featured) <span class="badge badge-featured">★ Featured</span> @endif
                    </td>
                    <td style="font-size:12px;color:#9ca3af">{{ optional($post->published_at)->format('M d, Y') }}</td>
                    <td>
                        <div class="action-btns">
                            <a href="{{ url('/blog/' . $post->slug) }}" target="_blank" class="btn btn-secondary btn-sm" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.blog-posts.edit', $post) }}" class="btn btn-secondary btn-sm" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.blog-posts.destroy', $post) }}" onsubmit="return confirm('Delete {{ addslashes($post->title) }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" title="Delete"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center;padding:40px;color:#9ca3af">
                        <i class="fas fa-newspaper" style="font-size:30px;display:block;margin-bottom:10px"></i>
                        No blog posts found.
                        <a href="{{ route('admin.blog-posts.create') }}" style="color:#6c63ff;font-weight:600">Write your first post</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($posts->hasPages())
<div style="display:flex;align-items:center;justify-content:space-between;padding:16px 22px;border-top:1px solid #f3f4f6;background:#fff;margin-top:0">
    <div style="font-size:13px;color:#6b7280">
        Showing <strong>{{ $posts->firstItem() }}</strong> to <strong>{{ $posts->lastItem() }}</strong> of <strong>{{ $posts->total() }}</strong> results
    </div>
    <div style="display:flex;gap:4px;align-items:center">
        @if($posts->onFirstPage())
            <span style="padding:6px 12px;border:1px solid #e5e7eb;border-radius:6px;font-size:13px;color:#d1d5db;cursor:not-allowed">
                <i class="fas fa-chevron-left"></i>
            </span>
        @else
            <a href="{{ $posts->previousPageUrl() }}" style="padding:6px 12px;border:1px solid #e5e7eb;border-radius:6px;font-size:13px;color:#6b7280;text-decoration:none">
                <i class="fas fa-chevron-left"></i>
            </a>
        @endif

        @foreach($posts->getUrlRange(1, $posts->lastPage()) as $page => $url)
            @if($page == $posts->currentPage())
                <span style="padding:6px 13px;border:1px solid #6c63ff;border-radius:6px;font-size:13px;background:#6c63ff;color:#fff;font-weight:600">{{ $page }}</span>
            @else
                <a href="{{ $url }}" style="padding:6px 13px;border:1px solid #e5e7eb;border-radius:6px;font-size:13px;color:#6b7280;text-decoration:none">{{ $page }}</a>
            @endif
        @endforeach

        @if($posts->hasMorePages())
            <a href="{{ $posts->nextPageUrl() }}" style="padding:6px 12px;border:1px solid #e5e7eb;border-radius:6px;font-size:13px;color:#6b7280;text-decoration:none">
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
