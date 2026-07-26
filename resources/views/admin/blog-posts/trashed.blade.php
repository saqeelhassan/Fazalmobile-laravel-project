@extends('admin.layout')
@section('title', 'Deleted Blog Posts')
@section('page-title', 'Deleted Blog Posts (Trash)')

@section('content')
<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px">
    <h2 style="font-size:18px;font-weight:700;color:#dc2626">
        <i class="fas fa-trash"></i> Trash — {{ $posts->total() }} deleted post(s)
    </h2>
    <a href="{{ route('admin.blog-posts.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Back to Blog Posts
    </a>
</div>

<div style="background:#fff8f8;border:1px solid #fecaca;border-radius:8px;padding:12px 16px;margin-bottom:20px;font-size:13px;color:#991b1b">
    <i class="fas fa-info-circle"></i>
    Deleted posts are hidden from the website. You can <strong>Restore</strong> them to bring them back, or <strong>Permanently Delete</strong> to remove them forever.
</div>

<div class="card">
    <div class="card-body">
        <table>
            <thead>
                <tr>
                    <th>Post</th>
                    <th>Category</th>
                    <th>Deleted At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($posts as $post)
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px">
                            @if($post->image)
                                <img src="{{ Storage::url($post->image) }}" class="product-thumb" alt="" style="opacity:.5">
                            @else
                                <div class="product-thumb" style="display:flex;align-items:center;justify-content:center;color:#d1d5db;opacity:.5"><i class="fas fa-newspaper"></i></div>
                            @endif
                            <strong style="font-size:13px;color:#6b7280">{{ $post->title }}</strong>
                        </div>
                    </td>
                    <td><span style="background:#f3f4f6;color:#6b7280;padding:3px 10px;border-radius:20px;font-size:11px">{{ $post->category ?: '—' }}</span></td>
                    <td style="font-size:12px;color:#9ca3af">{{ $post->deleted_at->format('d M Y H:i') }}</td>
                    <td>
                        <div class="action-btns">
                            <form method="POST" action="{{ route('admin.blog-posts.restore', $post->id) }}">
                                @csrf
                                <button type="submit" class="btn btn-secondary btn-sm" style="background:#d1fae5;color:#065f46" title="Restore">
                                    <i class="fas fa-trash-restore"></i> Restore
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.blog-posts.forceDelete', $post->id) }}"
                                onsubmit="return confirm('Permanently delete {{ addslashes($post->title) }}? This CANNOT be undone.')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" title="Delete Forever">
                                    <i class="fas fa-times"></i> Delete Forever
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="text-align:center;padding:40px;color:#9ca3af">
                        <i class="fas fa-check-circle" style="font-size:30px;display:block;margin-bottom:10px;color:#10b981"></i>
                        Trash is empty — no deleted blog posts.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
