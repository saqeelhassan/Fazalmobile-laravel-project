<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — {{ config('app.name') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:'Segoe UI',sans-serif;background:linear-gradient(135deg,#1e1e2d 0%,#2b2b3f 50%,#1a1a2e 100%);min-height:100vh;display:flex;align-items:center;justify-content:center}
        .login-wrap{width:100%;max-width:420px;padding:20px}
        .login-card{background:#fff;border-radius:16px;padding:40px 36px;box-shadow:0 20px 60px rgba(0,0,0,0.4)}
        .login-logo{text-align:center;margin-bottom:28px}
        .login-logo .icon{width:64px;height:64px;background:linear-gradient(135deg,#6c63ff,#00c8ff);border-radius:16px;display:inline-flex;align-items:center;justify-content:center;font-size:26px;color:#fff;margin-bottom:12px}
        .login-logo h1{font-size:22px;font-weight:700;color:#111}
        .login-logo p{font-size:13px;color:#9ca3af;margin-top:4px}
        .form-group{margin-bottom:18px}
        label{display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px}
        .input-wrap{position:relative}
        .input-wrap i{position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#9ca3af;font-size:14px}
        input{width:100%;padding:11px 14px 11px 40px;border:1.5px solid #e5e7eb;border-radius:9px;font-size:14px;outline:none;transition:border .2s;color:#111}
        input:focus{border-color:#6c63ff;box-shadow:0 0 0 3px rgba(108,99,255,0.15)}
        .is-invalid{border-color:#ef4444!important}
        .invalid-feedback{font-size:12px;color:#ef4444;margin-top:5px}
        .remember{display:flex;align-items:center;gap:8px;font-size:13px;color:#6b7280;cursor:pointer;margin-bottom:22px}
        .remember input{width:auto;padding:0;accent-color:#6c63ff}
        .btn-login{width:100%;padding:12px;background:linear-gradient(135deg,#6c63ff,#8b5cf6);color:#fff;border:none;border-radius:9px;font-size:15px;font-weight:600;cursor:pointer;transition:all .2s;display:flex;align-items:center;justify-content:center;gap:8px}
        .btn-login:hover{opacity:.9;transform:translateY(-1px)}
        .alert{padding:11px 14px;border-radius:8px;font-size:13px;margin-bottom:18px;display:flex;align-items:center;gap:8px}
        .alert-success{background:#d1fae5;color:#065f46;border-left:4px solid #10b981}
        .alert-error{background:#fee2e2;color:#991b1b;border-left:4px solid #ef4444}
        .login-footer{text-align:center;margin-top:22px;font-size:12px;color:#9ca3af}
    </style>
</head>
<body>
<div class="login-wrap">
    <div class="login-card">
        <div class="login-logo">
            <img src="{{ asset('img/logo.png') }}" alt="{{ config('app.name') }}" style="max-width:180px;height:auto;margin-bottom:16px">
            <h1>Admin Login</h1>
            <p>Sign in to manage your store</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('admin.login') }}" autocomplete="off">
            @csrf

            <div class="form-group">
                <label for="email">Email Address</label>
                <div class="input-wrap">
                    <i class="fas fa-envelope"></i>
                    <input type="email" id="email" name="email"
                           value="{{ old('email') }}"
                           placeholder="admin@example.com"
                           class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                           required autofocus>
                </div>
                @error('email')
                    <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrap">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password" name="password"
                           placeholder="••••••••"
                           class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
                           required>
                </div>
                @error('password')
                    <div class="invalid-feedback"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                @enderror
            </div>

            <label class="remember">
                <input type="checkbox" name="remember"> Remember me
            </label>

            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt"></i> Sign In
            </button>
        </form>

        <div class="login-footer">
            Protected area — Unauthorised access is prohibited
        </div>
    </div>
</div>
</body>
</html>
