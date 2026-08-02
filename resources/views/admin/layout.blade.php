<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') — {{ config('app.name') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:'Segoe UI',sans-serif;background:#f0f2f5;color:#333;display:flex;min-height:100vh}
        a{text-decoration:none;color:inherit}

        /* Sidebar */
        .sidebar{width:250px;background:linear-gradient(180deg,#1e1e2d,#2b2b3f);color:#c8c9ca;flex-shrink:0;display:flex;flex-direction:column;min-height:100vh;position:fixed;top:0;left:0;z-index:100}
        .sidebar-brand{padding:22px 20px;display:flex;align-items:center;gap:10px;border-bottom:1px solid rgba(255,255,255,0.08)}
        .sidebar-brand span{font-size:18px;font-weight:700;color:#fff}
        .sidebar-brand small{font-size:11px;color:#888;display:block}
        .sidebar-nav{flex:1;padding:16px 0}
        .nav-section{font-size:10px;font-weight:700;letter-spacing:1px;color:#555;padding:10px 20px 6px;text-transform:uppercase}
        .nav-item{display:flex;align-items:center;gap:12px;padding:11px 20px;color:#9a9ab0;font-size:13.5px;border-left:3px solid transparent;transition:all .2s}
        .nav-item:hover,.nav-item.active{background:rgba(255,255,255,0.06);color:#fff;border-left-color:#6c63ff}
        .nav-item i{width:18px;text-align:center;font-size:14px}
        .nav-badge{margin-left:auto;background:#ef4444;color:#fff;font-size:10.5px;font-weight:700;line-height:1;padding:3px 6px;border-radius:10px}
        .sidebar-footer{padding:16px 20px;border-top:1px solid rgba(255,255,255,0.08);font-size:12px;color:#666}
        .sidebar-footer strong{color:#aaa;display:block;margin-bottom:4px}

        /* Main */
        .main{margin-left:250px;flex:1;display:flex;flex-direction:column;min-height:100vh}
        .topbar{background:#fff;padding:0 28px;height:60px;display:flex;align-items:center;justify-content:space-between;border-bottom:1px solid #e5e7eb;position:sticky;top:0;z-index:50}
        .topbar-title{font-size:16px;font-weight:600;color:#1f2937}
        .topbar-right{display:flex;align-items:center;gap:16px}
        .topbar-admin{display:flex;align-items:center;gap:8px;font-size:13px;color:#555}
        .avatar{width:34px;height:34px;background:linear-gradient(135deg,#6c63ff,#00c8ff);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:13px;font-weight:700}
        .btn-logout{background:none;border:1px solid #e5e7eb;padding:6px 14px;border-radius:6px;font-size:12px;cursor:pointer;color:#666;transition:all .2s}
        .btn-logout:hover{background:#fee2e2;border-color:#fca5a5;color:#dc2626}
        .content{padding:28px;flex:1}

        /* Alert */
        .alert{padding:12px 16px;border-radius:8px;margin-bottom:20px;font-size:13.5px;display:flex;align-items:center;gap:10px}
        .alert-success{background:#d1fae5;color:#065f46;border-left:4px solid #10b981}
        .alert-error{background:#fee2e2;color:#991b1b;border-left:4px solid #ef4444}
        .alert-warning{background:#fef3c7;color:#92400e;border-left:4px solid #f59e0b}

        /* Cards */
        .stat-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:18px;margin-bottom:28px}
        .stat-card{background:#fff;border-radius:12px;padding:20px;display:flex;align-items:center;gap:16px;box-shadow:0 1px 4px rgba(0,0,0,0.07)}
        .stat-icon{width:52px;height:52px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:20px;color:#fff;flex-shrink:0}
        .si-purple{background:linear-gradient(135deg,#6c63ff,#a78bfa)}
        .si-green{background:linear-gradient(135deg,#10b981,#34d399)}
        .si-orange{background:linear-gradient(135deg,#f59e0b,#fbbf24)}
        .si-red{background:linear-gradient(135deg,#ef4444,#f87171)}
        .stat-info p{font-size:12px;color:#9ca3af;margin-bottom:4px}
        .stat-info h3{font-size:26px;font-weight:700;color:#1f2937}

        /* Table */
        .card{background:#fff;border-radius:12px;box-shadow:0 1px 4px rgba(0,0,0,0.07);overflow:hidden}
        .card-header{padding:18px 22px;border-bottom:1px solid #f3f4f6;display:flex;align-items:center;justify-content:space-between}
        .card-header h2{font-size:15px;font-weight:600;color:#111}
        .card-body{padding:0}
        table{width:100%;border-collapse:collapse;font-size:13.5px}
        thead th{padding:12px 16px;background:#f9fafb;font-weight:600;color:#6b7280;font-size:12px;text-transform:uppercase;letter-spacing:.5px;text-align:left;border-bottom:1px solid #e5e7eb}
        tbody td{padding:12px 16px;border-bottom:1px solid #f3f4f6;vertical-align:middle;color:#374151}
        tbody tr:last-child td{border-bottom:none}
        tbody tr:hover{background:#fafafa}
        .product-thumb{width:44px;height:44px;border-radius:6px;object-fit:cover;background:#f3f4f6}
        .badge{display:inline-flex;align-items:center;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600}
        .badge-active{background:#d1fae5;color:#065f46}
        .badge-inactive{background:#f3f4f6;color:#6b7280}
        .badge-out{background:#fee2e2;color:#991b1b}
        .badge-featured{background:#ede9fe;color:#5b21b6}

        /* Form */
        .form-card{background:#fff;border-radius:12px;box-shadow:0 1px 4px rgba(0,0,0,0.07);padding:28px}
        .form-grid{display:grid;grid-template-columns:1fr 1fr;gap:20px}
        .form-group{display:flex;flex-direction:column;gap:6px}
        .form-group.full{grid-column:1/-1}
        label{font-size:13px;font-weight:600;color:#374151}
        .req{color:#ef4444}
        input[type=text],input[type=number],input[type=email],input[type=password],select,textarea{
            width:100%;padding:10px 14px;border:1px solid #d1d5db;border-radius:8px;font-size:13.5px;
            color:#111;outline:none;transition:border .2s;background:#fff;font-family:inherit}
        input:focus,select:focus,textarea:focus{border-color:#6c63ff;box-shadow:0 0 0 3px rgba(108,99,255,0.12)}
        textarea{resize:vertical;min-height:90px}
        .invalid-feedback{font-size:12px;color:#ef4444;margin-top:2px}
        .is-invalid{border-color:#ef4444!important}
        .form-check{display:flex;align-items:center;gap:8px;cursor:pointer}
        .form-check input{width:16px;height:16px;accent-color:#6c63ff}
        .form-check label{font-weight:500;cursor:pointer;margin:0}

        /* Buttons */
        .btn{display:inline-flex;align-items:center;gap:7px;padding:9px 18px;border-radius:8px;font-size:13.5px;font-weight:600;cursor:pointer;border:none;transition:all .2s}
        .btn-primary{background:linear-gradient(135deg,#6c63ff,#8b5cf6);color:#fff}
        .btn-primary:hover{opacity:.88;transform:translateY(-1px)}
        .btn-secondary{background:#f3f4f6;color:#374151}
        .btn-secondary:hover{background:#e5e7eb}
        .btn-danger{background:#fee2e2;color:#dc2626}
        .btn-danger:hover{background:#fecaca}
        .btn-sm{padding:6px 12px;font-size:12px}
        .action-btns{display:flex;gap:6px}

        /* Filters */
        .filters{display:flex;gap:12px;align-items:center;flex-wrap:wrap;margin-bottom:20px}
        .filters input,.filters select{padding:8px 12px;border:1px solid #d1d5db;border-radius:8px;font-size:13px;outline:none;min-width:180px}
        .filters input:focus,.filters select:focus{border-color:#6c63ff}
        .pagination{display:flex;gap:4px;padding:16px;justify-content:center}
        .pagination a,.pagination span{padding:6px 12px;border:1px solid #e5e7eb;border-radius:6px;font-size:13px;color:#6b7280}
        .pagination .active span{background:#6c63ff;color:#fff;border-color:#6c63ff}

        /* Image preview */
        .img-preview{width:80px;height:80px;object-fit:cover;border-radius:8px;margin-top:8px;border:2px solid #e5e7eb}
        .upload-area{border:2px dashed #d1d5db;border-radius:8px;padding:20px;text-align:center;cursor:pointer;color:#9ca3af;font-size:13px;transition:border .2s}
        .upload-area:hover{border-color:#6c63ff;color:#6c63ff}

        /* Print: hide chrome, let printable content fill the page */
        .print-only { display: none; }
        @media print {
            .sidebar, .topbar, .no-print { display: none !important; }
            .main { margin-left: 0 !important; }
            .content { padding: 0 !important; }
            body { background: #fff !important; }
            .card { box-shadow: none !important; border: 1px solid #e5e7eb !important; break-inside: avoid; }
            .print-only { display: block !important; }
        }
    </style>
    @stack('styles')
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-brand">
        <div class="avatar" style="width:40px;height:40px;font-size:16px;">
            {{ strtoupper(substr(Auth::guard('admin')->user()->name ?? 'A', 0, 1)) }}
        </div>
        <div>
            <span>Admin Panel</span>
            <small>{{ config('app.name') }}</small>
        </div>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-section">Main</div>
        <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-chart-pie"></i> Dashboard
        </a>
        <div class="nav-section">Catalog</div>
        <a href="{{ route('admin.products.index') }}" class="nav-item {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
            <i class="fas fa-box"></i> Products
        </a>
        <a href="{{ route('admin.products.create') }}" class="nav-item {{ request()->routeIs('admin.products.create') ? 'active' : '' }}">
            <i class="fas fa-plus-circle"></i> Add Product
        </a>
        <a href="{{ route('admin.categories.index') }}" class="nav-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
            <i class="fas fa-tags"></i> Categories
        </a>
        <div class="nav-section">Content</div>
        <a href="{{ route('admin.blog-posts.index') }}" class="nav-item {{ request()->routeIs('admin.blog-posts.*') ? 'active' : '' }}">
            <i class="fas fa-newspaper"></i> Blog Posts
        </a>
        <a href="{{ route('admin.blog-posts.create') }}" class="nav-item {{ request()->routeIs('admin.blog-posts.create') ? 'active' : '' }}">
            <i class="fas fa-plus-circle"></i> Add Blog Post
        </a>
        <div class="nav-section">Inventory</div>
        <a href="{{ route('admin.inventory.index') }}" class="nav-item {{ request()->routeIs('admin.inventory.*') ? 'active' : '' }}">
            <i class="fas fa-warehouse"></i> Inventory
        </a>
        <a href="{{ route('admin.inventory.create') }}" class="nav-item {{ request()->routeIs('admin.inventory.create') ? 'active' : '' }}">
            <i class="fas fa-truck-loading"></i> Add Stock
        </a>
        <div class="nav-section">Orders</div>
        @php $__pendingOrdersCount = \App\Models\Order::where('status', 'pending')->count(); @endphp
        <a href="{{ route('admin.orders.index') }}" class="nav-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
            <i class="fas fa-receipt"></i> Orders
            @if($__pendingOrdersCount > 0)
                <span class="nav-badge">{{ $__pendingOrdersCount }}</span>
            @endif
        </a>
        <a href="{{ route('admin.orders.create') }}" class="nav-item">
            <i class="fas fa-plus"></i> New Order
        </a>
        <a href="{{ route('admin.users.index') }}" class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <i class="fas fa-users"></i> Customers
        </a>
        <a href="{{ route('admin.subscribers.index') }}" class="nav-item {{ request()->routeIs('admin.subscribers.*') ? 'active' : '' }}">
            <i class="fas fa-envelope"></i> Subscribers
        </a>
        <div class="nav-section">Analytics</div>
        <a href="{{ route('admin.reports.index') }}" class="nav-item {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
            <i class="fas fa-chart-bar"></i> Reports
        </a>
        <div class="nav-section">Site</div>
        <a href="{{ url('/') }}" target="_blank" class="nav-item">
            <i class="fas fa-external-link-alt"></i> View Website
        </a>
    </nav>
    <div class="sidebar-footer">
        <strong>{{ Auth::guard('admin')->user()->name ?? '' }}</strong>
        {{ Auth::guard('admin')->user()->email ?? '' }}
    </div>
</aside>

<div class="main">
    <header class="topbar">
        <div class="topbar-title">@yield('page-title', 'Dashboard')</div>
        <div class="topbar-right">
            <a href="{{ route('admin.profile.edit') }}" class="topbar-admin" style="{{ request()->routeIs('admin.profile.*') ? 'color:#6c63ff' : '' }}">
                <div class="avatar">{{ strtoupper(substr(Auth::guard('admin')->user()->name ?? 'A', 0, 1)) }}</div>
                <span>{{ Auth::guard('admin')->user()->name }}</span>
            </a>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Logout</button>
            </form>
        </div>
    </header>

    <main class="content">
        @if(session('success'))
            <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
        @endif
        @yield('content')
    </main>
</div>

@stack('scripts')
</body>
</html>
