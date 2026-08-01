@extends('admin.layout')
@section('title', 'My Profile')
@section('page-title', 'My Profile')

@section('content')
<div class="form-card" style="max-width:520px;margin-bottom:24px">
    <h3 style="font-size:14px;font-weight:700;margin-bottom:18px;color:#1f2937"><i class="fas fa-user" style="color:#6c63ff"></i> Account</h3>
    <div class="form-grid">
        <div class="form-group full">
            <label>Name</label>
            <input type="text" value="{{ Auth::guard('admin')->user()->name }}" disabled>
        </div>
        <div class="form-group full">
            <label>Email</label>
            <input type="text" value="{{ Auth::guard('admin')->user()->email }}" disabled>
        </div>
    </div>
</div>

<form method="POST" action="{{ route('admin.profile.password') }}" style="max-width:520px">
    @csrf
    @method('PUT')

    <div class="form-card">
        <h3 style="font-size:14px;font-weight:700;margin-bottom:18px;color:#1f2937"><i class="fas fa-key" style="color:#f59e0b"></i> Change Password</h3>
        <div class="form-grid">
            <div class="form-group full">
                <label>Current Password <span class="req">*</span></label>
                <input type="password" name="current_password" class="{{ $errors->has('current_password') ? 'is-invalid' : '' }}">
                @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group full">
                <label>New Password <span class="req">*</span></label>
                <input type="password" name="password" class="{{ $errors->has('password') ? 'is-invalid' : '' }}">
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group full">
                <label>Confirm New Password <span class="req">*</span></label>
                <input type="password" name="password_confirmation">
            </div>
        </div>
        <div style="margin-top:20px">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update Password
            </button>
        </div>
    </div>
</form>
@endsection
