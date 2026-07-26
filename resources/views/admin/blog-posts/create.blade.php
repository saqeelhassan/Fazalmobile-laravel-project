@extends('admin.layout')
@section('title', 'Add Blog Post')
@section('page-title', 'Add New Blog Post')

@section('content')
<div style="margin-bottom:18px">
    <a href="{{ route('admin.blog-posts.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Back to Blog Posts
    </a>
</div>

<form method="POST" action="{{ route('admin.blog-posts.store') }}" enctype="multipart/form-data">
    @csrf

    <div style="display:grid;grid-template-columns:1fr 340px;gap:20px">

        {{-- Left column --}}
        <div style="display:flex;flex-direction:column;gap:20px">

            <div class="form-card">
                <h3 style="font-size:14px;font-weight:700;margin-bottom:18px;color:#1f2937"><i class="fas fa-info-circle" style="color:#6c63ff"></i> Post Content</h3>
                <div class="form-grid">
                    <div class="form-group full">
                        <label>Title <span class="req">*</span></label>
                        <input type="text" name="title" value="{{ old('title') }}" placeholder="e.g. How to Choose the Right Smart Watch in 2026" class="{{ $errors->has('title') ? 'is-invalid' : '' }}">
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group full">
                        <label>Excerpt <span style="color:#9ca3af;font-weight:400">(short summary shown in listings)</span></label>
                        <textarea name="excerpt" rows="2" placeholder="One or two sentences summarizing the post...">{{ old('excerpt') }}</textarea>
                        @error('excerpt')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group full">
                        <label>Body <span class="req">*</span></label>
                        <textarea name="body" rows="16" placeholder="Full post content. Plain text or basic HTML (e.g. <p>, <h2>, <ul>) is fine.">{{ old('body') }}</textarea>
                        <small style="color:#9ca3af;font-size:11px">Basic HTML tags are allowed and rendered as-is (e.g. &lt;h2&gt;, &lt;p&gt;, &lt;ul&gt;&lt;li&gt;, &lt;strong&gt;).</small>
                        @error('body')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="form-card">
                <h3 style="font-size:14px;font-weight:700;margin-bottom:6px;color:#1f2937"><i class="fas fa-search" style="color:#10b981"></i> SEO</h3>
                <div class="form-grid">
                    <div class="form-group full">
                        <label>Meta Title <span style="color:#9ca3af;font-weight:400">(defaults to Title if empty)</span></label>
                        <input type="text" name="meta_title" value="{{ old('meta_title') }}" placeholder="Shown in search engine results" maxlength="255">
                    </div>
                    <div class="form-group full">
                        <label>Meta Description</label>
                        <textarea name="meta_description" rows="2" maxlength="500" placeholder="150-160 characters recommended for search snippets">{{ old('meta_description') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="form-card">
                <h3 style="font-size:14px;font-weight:700;margin-bottom:6px;color:#1f2937"><i class="fas fa-image" style="color:#f59e0b"></i> Featured Image</h3>
                <div style="background:#fffbeb;border:1px solid #fde68a;border-radius:8px;padding:12px 14px;margin-bottom:18px;font-size:12.5px;color:#92400e;line-height:1.7">
                    📐 <strong>Recommended:</strong> 1200 × 700 px, JPG/PNG/WebP, max 2 MB.
                </div>
                <div class="form-group">
                    <input type="file" name="image" id="mainImage" accept="image/jpeg,image/png,image/jpg,image/webp" onchange="previewImage(this,'mainPreview')" class="{{ $errors->has('image') ? 'is-invalid' : '' }}" style="padding:8px">
                    @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <img id="mainPreview" class="img-preview" src="" alt="" style="display:none">
                </div>
            </div>

        </div>

        {{-- Right column --}}
        <div style="display:flex;flex-direction:column;gap:20px">

            <div class="form-card">
                <h3 style="font-size:14px;font-weight:700;margin-bottom:18px;color:#1f2937"><i class="fas fa-toggle-on" style="color:#6c63ff"></i> Publish</h3>
                <div class="form-group" style="margin-bottom:16px">
                    <label>Status <span class="req">*</span></label>
                    <select name="status" class="{{ $errors->has('status') ? 'is-invalid' : '' }}">
                        <option value="active"   {{ old('status','active') === 'active' ? 'selected' : '' }}>Active (Published)</option>
                        <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive (Draft)</option>
                    </select>
                </div>
                <div class="form-group" style="margin-bottom:16px">
                    <label>Published Date</label>
                    <input type="datetime-local" name="published_at" value="{{ old('published_at') }}">
                    <small style="color:#9ca3af;font-size:11px">Leave blank to use current date/time</small>
                </div>
                <label class="form-check" style="margin-bottom:12px">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                    <label style="font-weight:500;cursor:pointer">Mark as Featured</label>
                </label>
                <div style="margin-top:20px;display:flex;flex-direction:column;gap:10px">
                    <button type="submit" class="btn btn-primary" style="justify-content:center">
                        <i class="fas fa-save"></i> Save Post
                    </button>
                    <a href="{{ route('admin.blog-posts.index') }}" class="btn btn-secondary" style="justify-content:center">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </div>

            <div class="form-card">
                <h3 style="font-size:14px;font-weight:700;margin-bottom:18px;color:#1f2937"><i class="fas fa-tags" style="color:#f59e0b"></i> Category & Author</h3>
                <div class="form-group" style="margin-bottom:14px">
                    <label>Category</label>
                    <select name="category" class="{{ $errors->has('category') ? 'is-invalid' : '' }}">
                        <option value="">— Select Category —</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ old('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                    @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Author Name</label>
                    <input type="text" name="author_name" value="{{ old('author_name') }}" placeholder="Defaults to your admin name">
                </div>
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
