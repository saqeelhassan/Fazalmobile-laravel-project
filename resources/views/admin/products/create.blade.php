@extends('admin.layout')
@section('title', 'Add Product')
@section('page-title', 'Add New Product')

@section('content')
<div style="margin-bottom:18px">
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Back to Products
    </a>
</div>

<form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
    @csrf

    <div style="display:grid;grid-template-columns:1fr 340px;gap:20px">

        {{-- Left column --}}
        <div style="display:flex;flex-direction:column;gap:20px">

            {{-- Basic Info --}}
            <div class="form-card">
                <h3 style="font-size:14px;font-weight:700;margin-bottom:18px;color:#1f2937"><i class="fas fa-info-circle" style="color:#6c63ff"></i> Basic Information</h3>
                <div class="form-grid">
                    <div class="form-group full">
                        <label>Product Name <span class="req">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Apple Watch Series 9" class="{{ $errors->has('name') ? 'is-invalid' : '' }}">
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group full">
                        <label>Short Description</label>
                        <textarea name="short_description" rows="2" placeholder="Brief summary shown in product listing...">{{ old('short_description') }}</textarea>
                        @error('short_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group full">
                        <label>Full Description</label>
                        <textarea name="description" rows="5" placeholder="Detailed product description...">{{ old('description') }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            {{-- Pricing & Inventory --}}
            <div class="form-card">
                <h3 style="font-size:14px;font-weight:700;margin-bottom:18px;color:#1f2937"><i class="fas fa-rupee-sign" style="color:#10b981"></i> Pricing & Inventory (PKR)</h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Regular Price (Rs.) <span class="req">*</span></label>
                        <input type="number" name="price" value="{{ old('price') }}" placeholder="0.00" step="0.01" min="0" class="{{ $errors->has('price') ? 'is-invalid' : '' }}">
                        @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>Sale Price (Rs.)</label>
                        <input type="number" name="sale_price" value="{{ old('sale_price') }}" placeholder="0" step="1" min="0">
                        @error('sale_price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>Cost / Purchase Price (Rs.)</label>
                        <input type="number" name="cost_price" value="{{ old('cost_price') }}" placeholder="Your buying price" step="1" min="0">
                        <small style="color:#9ca3af;font-size:11px">Used for profit calculation in reports</small>
                        @error('cost_price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>SKU</label>
                        <input type="text" name="sku" value="{{ old('sku') }}" placeholder="e.g. SW-001" class="{{ $errors->has('sku') ? 'is-invalid' : '' }}">
                        @error('sku')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>Stock Quantity <span class="req">*</span></label>
                        <input type="number" name="stock" value="{{ old('stock', 0) }}" min="0" class="{{ $errors->has('stock') ? 'is-invalid' : '' }}">
                        @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            {{-- Images --}}
            <div class="form-card">
                <h3 style="font-size:14px;font-weight:700;margin-bottom:6px;color:#1f2937"><i class="fas fa-image" style="color:#f59e0b"></i> Product Images</h3>

                {{-- Image size guide --}}
                <div style="background:#fffbeb;border:1px solid #fde68a;border-radius:8px;padding:12px 14px;margin-bottom:18px;font-size:12.5px;color:#92400e;line-height:1.7">
                    <strong style="display:block;margin-bottom:4px"><i class="fas fa-lightbulb"></i> Recommended Image Sizes</strong>
                    <span style="display:inline-block;margin-right:16px">📐 <strong>Main Image:</strong> 800 × 800 px (square)</span>
                    <span style="display:inline-block">🖼 <strong>Gallery:</strong> 800 × 800 px or 1200 × 900 px</span><br>
                    <span style="display:inline-block;margin-right:16px">📁 <strong>Format:</strong> JPG or PNG</span>
                    <span style="display:inline-block;margin-right:16px">⚖️ <strong>Max size:</strong> 2 MB per image</span>
                    <span style="display:inline-block">🎨 <strong>Background:</strong> White preferred for best display</span>
                </div>

                <div class="form-group" style="margin-bottom:16px">
                    <label>Main Product Image</label>
                    <input type="file" name="image" id="mainImage" accept="image/jpeg,image/png,image/jpg,image/webp" onchange="previewImage(this,'mainPreview')" class="{{ $errors->has('image') ? 'is-invalid' : '' }}" style="padding:8px">
                    @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <img id="mainPreview" class="img-preview" src="" alt="" style="display:none">
                </div>
                <div class="form-group">
                    <label>Gallery Images <span style="color:#9ca3af;font-weight:400">(multiple allowed)</span></label>
                    <input type="file" name="gallery[]" accept="image/jpeg,image/png,image/jpg,image/webp" multiple style="padding:8px">
                    @error('gallery.*')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

        </div>

        {{-- Right column --}}
        <div style="display:flex;flex-direction:column;gap:20px">

            {{-- Publish --}}
            <div class="form-card">
                <h3 style="font-size:14px;font-weight:700;margin-bottom:18px;color:#1f2937"><i class="fas fa-toggle-on" style="color:#6c63ff"></i> Publish</h3>
                <div class="form-group" style="margin-bottom:16px">
                    <label>Status <span class="req">*</span></label>
                    <select name="status" class="{{ $errors->has('status') ? 'is-invalid' : '' }}">
                        <option value="active"       {{ old('status','active') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive"     {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive (Draft)</option>
                        <option value="out_of_stock" {{ old('status') === 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                    </select>
                </div>
                <label class="form-check" style="margin-bottom:12px">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                    <label style="font-weight:500;cursor:pointer">Mark as Featured</label>
                </label>
                <label class="form-check">
                    <input type="checkbox" name="is_on_sale" value="1" {{ old('is_on_sale') ? 'checked' : '' }}>
                    <label style="font-weight:500;cursor:pointer">Mark as On Sale</label>
                </label>
                <div style="margin-top:20px;display:flex;flex-direction:column;gap:10px">
                    <button type="submit" class="btn btn-primary" style="justify-content:center">
                        <i class="fas fa-save"></i> Save Product
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary" style="justify-content:center">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </div>

            {{-- Category & Brand --}}
            <div class="form-card">
                <h3 style="font-size:14px;font-weight:700;margin-bottom:18px;color:#1f2937"><i class="fas fa-tags" style="color:#f59e0b"></i> Category</h3>
                <div class="form-group" style="margin-bottom:14px">
                    <label>Category <span class="req">*</span></label>
                    <select name="category" class="{{ $errors->has('category') ? 'is-invalid' : '' }}">
                        <option value="">— Select Category —</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ old('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                    @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Brand</label>
                    <input type="text" name="brand" value="{{ old('brand') }}" placeholder="e.g. Apple, Samsung">
                    @error('brand')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
