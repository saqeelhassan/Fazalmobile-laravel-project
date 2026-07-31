<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Installer') — {{ config('app.name') }}</title>
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:'Segoe UI',sans-serif;background:#f0f2f5;color:#333;min-height:100vh;display:flex;align-items:flex-start;justify-content:center;padding:40px 16px}
        .wrap{width:100%;max-width:640px}
        .brand{text-align:center;margin-bottom:22px}
        .brand strong{font-size:20px;color:#1f2937}
        .brand span{display:block;font-size:12.5px;color:#888;margin-top:2px}
        .steps{display:flex;justify-content:center;gap:6px;margin-bottom:24px}
        .steps i{width:34px;height:4px;border-radius:2px;background:#e5e7eb}
        .steps i.active{background:#6c63ff}
        .card{background:#fff;border-radius:12px;box-shadow:0 1px 4px rgba(0,0,0,0.07);padding:32px}
        .card h1{font-size:19px;color:#111;margin-bottom:6px}
        .card p.lead{font-size:13.5px;color:#6b7280;margin-bottom:22px}
        .alert{padding:12px 16px;border-radius:8px;margin-bottom:20px;font-size:13.5px}
        .alert-success{background:#d1fae5;color:#065f46;border-left:4px solid #10b981}
        .alert-error{background:#fee2e2;color:#991b1b;border-left:4px solid #ef4444}
        .alert-info{background:#e0e7ff;color:#3730a3;border-left:4px solid #6c63ff}
        ul.errors{margin:0 0 16px 18px;color:#991b1b;font-size:13px}
        .check-list{list-style:none;margin-bottom:22px}
        .check-list li{display:flex;align-items:center;gap:10px;padding:9px 0;border-bottom:1px solid #f3f4f6;font-size:13.5px}
        .check-list li:last-child{border-bottom:none}
        .dot{width:9px;height:9px;border-radius:50%;flex-shrink:0}
        .dot.ok{background:#10b981}
        .dot.fail{background:#ef4444}
        .field{margin-bottom:16px}
        .field label{display:block;font-size:12.5px;font-weight:600;color:#374151;margin-bottom:6px}
        .field input{width:100%;padding:10px 12px;border:1px solid #d1d5db;border-radius:8px;font-size:13.5px}
        .field input:focus{outline:none;border-color:#6c63ff}
        .field small{display:block;color:#9ca3af;font-size:11.5px;margin-top:4px}
        .row2{display:grid;grid-template-columns:1fr 1fr;gap:14px}
        .section-title{font-size:12px;font-weight:700;letter-spacing:.5px;color:#9ca3af;text-transform:uppercase;margin:22px 0 12px}
        .section-title:first-child{margin-top:0}
        .actions{display:flex;justify-content:flex-end;gap:10px;margin-top:8px}
        .btn{display:inline-flex;align-items:center;gap:8px;padding:11px 22px;border-radius:8px;font-size:13.5px;font-weight:600;border:none;cursor:pointer;text-decoration:none}
        .btn-primary{background:#6c63ff;color:#fff}
        .btn-primary:hover{background:#5a52e0}
        .btn-outline{background:#fff;border:1px solid #d1d5db;color:#374151}
        textarea.env-box{width:100%;min-height:260px;font-family:Consolas,monospace;font-size:12.5px;padding:14px;border-radius:8px;border:1px solid #d1d5db;background:#0f172a;color:#e2e8f0}
        .footer-note{text-align:center;font-size:12px;color:#9ca3af;margin-top:18px}
    </style>
</head>
<body>
<div class="wrap">
    <div class="brand">
        <strong>{{ config('app.name', 'Fazal Mobiles') }}</strong>
        <span>Application Installer</span>
    </div>
    <div class="steps">
        <i class="{{ ($step ?? 0) >= 1 ? 'active' : '' }}"></i>
        <i class="{{ ($step ?? 0) >= 2 ? 'active' : '' }}"></i>
        <i class="{{ ($step ?? 0) >= 3 ? 'active' : '' }}"></i>
        <i class="{{ ($step ?? 0) >= 4 ? 'active' : '' }}"></i>
    </div>
    <div class="card">
        @if (session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif
        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        @if ($errors->any())
            <ul class="errors">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
        @yield('content')
    </div>
    <p class="footer-note">Step-by-step setup for a fresh installation.</p>
</div>
</body>
</html>
