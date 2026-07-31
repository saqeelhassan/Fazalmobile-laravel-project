@extends('admin.layout')
@section('title', 'Edit Category')
@section('page-title', 'Edit Category')

@section('content')
<div style="margin-bottom:18px">
    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Back to Categories
    </a>
</div>

<form method="POST" action="{{ route('admin.categories.update', $category) }}" style="max-width:520px">
    @csrf @method('PUT')

    <div class="form-card">
        <h3 style="font-size:14px;font-weight:700;margin-bottom:18px;color:#1f2937"><i class="fas fa-tags" style="color:#f59e0b"></i> Category Details</h3>
        <div class="form-grid">
            <div class="form-group full">
                <label>Category Name <span class="req">*</span></label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" class="{{ $errors->has('name') ? 'is-invalid' : '' }}">
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group full">
                <label>Status <span class="req">*</span></label>
                <select name="status" class="{{ $errors->has('status') ? 'is-invalid' : '' }}">
                    <option value="active"   {{ old('status',$category->status) === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status',$category->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <div style="margin-top:20px;display:flex;gap:10px">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update Category
            </button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> Cancel
            </a>
        </div>
    </div>
</form>

<div class="form-card" style="max-width:520px;margin-top:20px;border:1px solid #fee2e2">
    <h3 style="font-size:14px;font-weight:700;margin-bottom:14px;color:#dc2626"><i class="fas fa-exclamation-triangle"></i> Danger Zone</h3>
    <p style="font-size:12px;color:#9ca3af;margin-bottom:14px">This will delete the category. Products already using it will keep the old category name.</p>
    <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Delete {{ addslashes($category->name) }}?')">
        @csrf @method('DELETE')
        <button type="submit" class="btn btn-danger">
            <i class="fas fa-trash"></i> Delete Category
        </button>
    </form>
</div>
@endsection
