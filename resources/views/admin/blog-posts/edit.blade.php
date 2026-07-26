@extends('admin.layout')
@section('title', 'Edit Blog Post')
@section('page-title', 'Edit Blog Post')

@section('content')
<div style="margin-bottom:18px">
    <a href="{{ route('admin.blog-posts.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Back to Blog Posts
    </a>
</div>

<form method="POST" action="{{ route('admin.blog-posts.update', $post) }}" enctype="multipart/form-data">
    @csrf @method('PUT')

    <div style="display:grid;grid-template-columns:1fr 340px;gap:20px">

        {{-- Left column --}}
        <div style="display:flex;flex-direction:column;gap:20px">

            <div class="form-card">
                <h3 style="font-size:14px;font-weight:700;margin-bottom:18px;color:#1f2937"><i class="fas fa-info-circle" style="color:#6c63ff"></i> Post Content</h3>
                <div class="form-grid">
                    <div class="form-group full">
                        <label>Title <span class="req">*</span></label>
                        <input type="text" name="title" value="{{ old('title', $post->title) }}" class="{{ $errors->has('title') ? 'is-invalid' : '' }}">
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group full">
                        <label>Excerpt</label>
                        <textarea name="excerpt" rows="2">{{ old('excerpt', $post->excerpt) }}</textarea>
                    </div>
                    <div class="form-group full">
                        <label>Body <span class="req">*</span></label>
                        <textarea name="body" rows="16">{{ old('body', $post->body) }}</textarea>
                        <small style="color:#9ca3af;font-size:11px">Basic HTML tags are allowed and rendered as-is (e.g. &lt;h2&gt;, &lt;p&gt;, &lt;ul&gt;&lt;li&gt;, &lt;strong&gt;).</small>
                        @error('body')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="form-card">
                <h3 style="font-size:14px;font-weight:700;margin-bottom:6px;color:#1f2937"><i class="fas fa-search" style="color:#10b981"></i> SEO</h3>
                <div class="form-grid">
                    <div class="form-group full">
                        <label>Meta Title</label>
                        <input type="text" name="meta_title" value="{{ old('meta_title', $post->meta_title) }}" maxlength="255">
                    </div>
                    <div class="form-group full">
                        <label>Meta Description</label>
                        <textarea name="meta_description" rows="2" maxlength="500">{{ old('meta_description', $post->meta_description) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="form-card">
                <h3 style="font-size:14px;font-weight:700;margin-bottom:6px;color:#1f2937"><i class="fas fa-image" style="color:#f59e0b"></i> Featured Image</h3>
                @if($post->image)
                    <div style="margin-bottom:14px">
                        <label style="font-size:12px;color:#9ca3af;display:block;margin-bottom:6px">Current Image</label>
                        <img src="{{ Storage::url($post->image) }}" style="width:160px;height:100px;object-fit:cover;border-radius:8px;border:2px solid #e5e7eb">
                    </div>
                @endif
                <div class="form-group">
                    <label>Replace Image</label>
                    <input type="file" name="image" accept="image/jpeg,image/png,image/jpg,image/webp" onchange="previewImage(this,'mainPreview')" style="padding:8px">
                    <img id="mainPreview" class="img-preview" style="display:none">
                </div>
            </div>

        </div>

        {{-- Right column --}}
        <div style="display:flex;flex-direction:column;gap:20px">

            <div class="form-card">
                <h3 style="font-size:14px;font-weight:700;margin-bottom:18px;color:#1f2937"><i class="fas fa-toggle-on" style="color:#6c63ff"></i> Publish</h3>
                <div class="form-group" style="margin-bottom:16px">
                    <label>Status <span class="req">*</span></label>
                    <select name="status">
                        <option value="active"   {{ old('status',$post->status) === 'active' ? 'selected' : '' }}>Active (Published)</option>
                        <option value="inactive" {{ old('status',$post->status) === 'inactive' ? 'selected' : '' }}>Inactive (Draft)</option>
                    </select>
                </div>
                <div class="form-group" style="margin-bottom:16px">
                    <label>Published Date</label>
                    <input type="datetime-local" name="published_at" value="{{ old('published_at', optional($post->published_at)->format('Y-m-d\TH:i')) }}">
                </div>
                <label class="form-check" style="margin-bottom:12px">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $post->is_featured) ? 'checked' : '' }}>
                    <label style="font-weight:500;cursor:pointer">Mark as Featured</label>
                </label>
                <div style="margin-top:20px;display:flex;flex-direction:column;gap:10px">
                    <button type="submit" class="btn btn-primary" style="justify-content:center">
                        <i class="fas fa-save"></i> Update Post
                    </button>
                    <a href="{{ route('admin.blog-posts.index') }}" class="btn btn-secondary" style="justify-content:center">Cancel</a>
                </div>
            </div>

            <div class="form-card">
                <h3 style="font-size:14px;font-weight:700;margin-bottom:18px;color:#1f2937"><i class="fas fa-tags" style="color:#f59e0b"></i> Category & Author</h3>
                <div class="form-group" style="margin-bottom:14px">
                    <label>Category</label>
                    <select name="category">
                        <option value="">— Select Category —</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ old('category',$post->category) === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Author Name</label>
                    <input type="text" name="author_name" value="{{ old('author_name', $post->author_name) }}">
                </div>
            </div>

            <div class="form-card" style="border:1px solid #fee2e2">
                <h3 style="font-size:14px;font-weight:700;margin-bottom:14px;color:#dc2626"><i class="fas fa-exclamation-triangle"></i> Danger Zone</h3>
                <p style="font-size:12px;color:#9ca3af;margin-bottom:14px">This will move the post to trash.</p>
                <form method="POST" action="{{ route('admin.blog-posts.destroy', $post) }}" onsubmit="return confirm('Delete {{ addslashes($post->title) }}?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger" style="width:100%;justify-content:center">
                        <i class="fas fa-trash"></i> Delete Post
                    </button>
                </form>
            </div>

        </div>
    </div>
</form>

@push('scripts')
<script>
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => { preview.src = e.target.result; preview.style.display = 'block'; };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
@endsection
