@extends('admin.layout')
@section('title', 'Add Category')
@section('page-title', 'Add New Category')

@section('content')
<div style="margin-bottom:18px">
    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Back to Categories
    </a>
</div>

<form method="POST" action="{{ route('admin.categories.store') }}" style="max-width:520px">
    @csrf

    <div class="form-card">
        <h3 style="font-size:14px;font-weight:700;margin-bottom:18px;color:#1f2937"><i class="fas fa-tags" style="color:#f59e0b"></i> Category Details</h3>
        <div class="form-grid">
            <div class="form-group full">
                <label>Category Name <span class="req">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Smart Watches" class="{{ $errors->has('name') ? 'is-invalid' : '' }}">
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group full">
                <label>Status <span class="req">*</span></label>
                <select name="status" class="{{ $errors->has('status') ? 'is-invalid' : '' }}">
                    <option value="active"   {{ old('status','active') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <div style="margin-top:20px;display:flex;gap:10px">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Save Category
            </button>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> Cancel
            </a>
        </div>
    </div>
</form>
@endsection
