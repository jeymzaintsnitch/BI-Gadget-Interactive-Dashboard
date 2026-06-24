<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Gadget Store') — GadgetBI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --primary-light: #eef2ff;
            --sidebar-w: 260px;
            --sidebar-bg: #1e1b4b;
            --sidebar-text: #c7d2fe;
            --sidebar-active: #6366f1;
            --header-h: 64px;
        }
        * { box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #f8fafc; margin: 0; }

        /* ── Sidebar ── */
        #sidebar {
            position: fixed; top: 0; left: 0; height: 100vh; width: var(--sidebar-w);
            background: var(--sidebar-bg); z-index: 1000; overflow-y: auto;
            transition: transform .3s ease;
        }
        .sidebar-brand {
            display: flex; align-items: center; gap: 10px;
            padding: 20px 20px 12px; color: #fff; font-size: 1.2rem; font-weight: 700;
            border-bottom: 1px solid rgba(255,255,255,.1); text-decoration: none;
        }
        .sidebar-brand .brand-icon {
            width: 36px; height: 36px; background: var(--primary);
            border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1rem;
        }
        .sidebar-section { padding: 16px 12px 4px; font-size: .7rem; font-weight: 600;
            color: rgba(199,210,254,.4); text-transform: uppercase; letter-spacing: .08em; }
        .sidebar-nav { list-style: none; padding: 0 8px; margin: 0; }
        .sidebar-nav a {
            display: flex; align-items: center; gap: 10px; padding: 9px 12px;
            color: var(--sidebar-text); text-decoration: none; border-radius: 8px;
            font-size: .875rem; font-weight: 500; transition: all .15s;
        }
        .sidebar-nav a:hover   { background: rgba(99,102,241,.25); color: #fff; }
        .sidebar-nav a.active  { background: var(--primary); color: #fff; }
        .sidebar-nav a i       { font-size: 1rem; width: 20px; text-align: center; }
        .sidebar-nav li        { margin-bottom: 2px; }

        /* ── Main ── */
        #main { margin-left: var(--sidebar-w); min-height: 100vh; }
        #topbar {
            position: sticky; top: 0; height: var(--header-h);
            background: #fff; border-bottom: 1px solid #e2e8f0;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 28px; z-index: 900;
        }
        .topbar-left   { display: flex; align-items: center; gap: 12px; }
        .topbar-title  { font-size: 1rem; font-weight: 600; color: #1e293b; }
        .topbar-right  { display: flex; align-items: center; gap: 12px; }
        .user-badge {
            display: flex; align-items: center; gap: 8px;
            padding: 6px 12px; background: var(--primary-light);
            border-radius: 20px; font-size: .8rem; font-weight: 600; color: var(--primary);
        }
        .role-chip {
            font-size: .65rem; padding: 2px 8px; border-radius: 20px; font-weight: 700;
            text-transform: uppercase; letter-spacing: .05em;
        }
        .role-admin   { background: #fee2e2; color: #dc2626; }
        .role-staff   { background: #e0e7ff; color: #6366f1; }

        #content { padding: 28px; }

        /* ── Cards ── */
        .kpi-card {
            background: #fff; border-radius: 16px; padding: 24px;
            border: 1px solid #e2e8f0; position: relative; overflow: hidden;
        }
        .kpi-card::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0;
            height: 4px; background: var(--accent, var(--primary));
        }
        .kpi-icon {
            width: 48px; height: 48px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center; font-size: 1.4rem;
            background: var(--accent-light, var(--primary-light)); color: var(--accent, var(--primary));
        }
        .kpi-value   { font-size: 1.75rem; font-weight: 700; color: #1e293b; line-height: 1; }
        .kpi-label   { font-size: .8rem; color: #64748b; font-weight: 500; margin-top: 4px; }

        /* ── Chart cards ── */
        .chart-card {
            background: #fff; border-radius: 16px; border: 1px solid #e2e8f0;
            padding: 24px; height: 100%;
        }
        .chart-card .card-header-custom {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 16px;
        }
        .chart-card .card-title { font-size: .95rem; font-weight: 700; color: #1e293b; margin: 0; }
        .chart-card .card-badge {
            font-size: .7rem; padding: 3px 10px; border-radius: 20px;
            background: var(--primary-light); color: var(--primary); font-weight: 600;
        }
        canvas { max-width: 100%; }

        /* ── Tables ── */
        .bi-table { border-radius: 12px; overflow: hidden; border: 1px solid #e2e8f0; }
        .bi-table table { margin: 0; }
        .bi-table thead th { background: #f8fafc; font-size: .75rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: .05em; color: #64748b; border: none; padding: 12px 16px; }
        .bi-table tbody td { padding: 12px 16px; font-size: .875rem; vertical-align: middle; border-color: #f1f5f9; }
        .bi-table tbody tr:hover { background: #f8fafc; }

        /* ── Rank badge ── */
        .rank-badge {
            width: 28px; height: 28px; border-radius: 50%;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: .75rem; font-weight: 700;
        }
        .rank-1 { background: #fef3c7; color: #d97706; }
        .rank-2 { background: #e5e7eb; color: #374151; }
        .rank-3 { background: #fee2e2; color: #dc2626; }
        .rank-n { background: #f1f5f9; color: #64748b; }

        /* ── Alerts ── */
        .flash-success { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; border-radius: 10px; padding: 12px 16px; }
        .flash-error   { background: #fee2e2; color: #7f1d1d; border: 1px solid #fca5a5; border-radius: 10px; padding: 12px 16px; }

        /* ── Section header ── */
        .page-header    { margin-bottom: 24px; }
        .page-header h1 { font-size: 1.4rem; font-weight: 700; color: #1e293b; margin: 0; }
        .page-header p  { font-size: .875rem; color: #64748b; margin: 4px 0 0; }

        /* ── Form ── */
        .form-card { background: #fff; border-radius: 16px; border: 1px solid #e2e8f0; padding: 28px; }
        .form-label { font-size: .8rem; font-weight: 600; color: #374151; }
        .form-control, .form-select {
            border-radius: 10px; border-color: #e2e8f0; font-size: .875rem;
            padding: 10px 14px;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--primary); box-shadow: 0 0 0 3px rgba(99,102,241,.15);
        }
        .btn-primary   { background: var(--primary); border-color: var(--primary); border-radius: 10px; font-weight: 600; }
        .btn-primary:hover { background: var(--primary-dark); border-color: var(--primary-dark); }
        .btn-outline-secondary { border-radius: 10px; font-weight: 600; }
        .btn-danger    { border-radius: 10px; font-weight: 600; }

        /* Status badges */
        .status-shipped    { background: #d1fae5; color: #065f46; }
        .status-cancelled  { background: #fee2e2; color: #7f1d1d; }
        .status-inprocess  { background: #dbeafe; color: #1e40af; }
        .status-onhold     { background: #fef3c7; color: #92400e; }
        .status-resolved   { background: #e5e7eb; color: #374151; }
        .status-badge { font-size: .7rem; font-weight: 700; padding: 3px 10px; border-radius: 20px; }

        @media (max-width: 768px) {
            #sidebar { transform: translateX(-100%); }
            #sidebar.show { transform: translateX(0); }
            #main { margin-left: 0; }
        }
    </style>
    @yield('head')
</head>
<body>
<!-- Sidebar -->
<nav id="sidebar">
    <a class="sidebar-brand" href="{{ route('dashboard') }}">
        <div class="brand-icon"><i class="bi bi-gear-wide-connected"></i></div>
        GadgetBI
    </a>

    <div class="sidebar-section">Main</div>
    <ul class="sidebar-nav">
        <li><a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a></li>
    </ul>

    <div class="sidebar-section">Catalog</div>
    <ul class="sidebar-nav">
        <li><a href="{{ route('products.index') }}" class="{{ request()->routeIs('products.*') ? 'active' : '' }}">
            <i class="bi bi-box-seam"></i> Products
        </a></li>
        <li><a href="{{ route('product-lines.index') }}" class="{{ request()->routeIs('product-lines.*') ? 'active' : '' }}">
            <i class="bi bi-tags"></i> Product Lines
        </a></li>
    </ul>

    <div class="sidebar-section">Sales</div>
    <ul class="sidebar-nav">
        <li><a href="{{ route('orders.index') }}" class="{{ request()->routeIs('orders.*') ? 'active' : '' }}">
            <i class="bi bi-cart3"></i> Orders
        </a></li>
        <li><a href="{{ route('customers.index') }}" class="{{ request()->routeIs('customers.*') ? 'active' : '' }}">
            <i class="bi bi-people"></i> Customers
        </a></li>
        <li><a href="{{ route('payments.index') }}" class="{{ request()->routeIs('payments.*') ? 'active' : '' }}">
            <i class="bi bi-credit-card"></i> Payments
        </a></li>
    </ul>

    <div class="sidebar-section">Organization</div>
    <ul class="sidebar-nav">
        <li><a href="{{ route('employees.index') }}" class="{{ request()->routeIs('employees.*') ? 'active' : '' }}">
            <i class="bi bi-person-badge"></i> Employees
        </a></li>
        <li><a href="{{ route('offices.index') }}" class="{{ request()->routeIs('offices.*') ? 'active' : '' }}">
            <i class="bi bi-building"></i> Offices
        </a></li>
    </ul>

    @if(session('user_role') === 'admin')
    <div class="sidebar-section">Admin</div>
    <ul class="sidebar-nav">
        <li><a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
            <i class="bi bi-shield-person"></i> Users
        </a></li>
        <li><a href="{{ route('roles.index') }}" class="{{ request()->routeIs('roles.*') ? 'active' : '' }}">
            <i class="bi bi-key"></i> Roles
        </a></li>
    </ul>
    @endif

    <div style="padding: 20px 8px 12px;">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-100 btn btn-sm"
                style="background:rgba(255,255,255,.08);color:#c7d2fe;border-radius:8px;border:none;">
                <i class="bi bi-box-arrow-left me-2"></i>Sign Out
            </button>
        </form>
    </div>
</nav>

<!-- Main Area -->
<div id="main">
    <div id="topbar">
        <div class="topbar-left">
            <button class="btn btn-sm d-md-none" onclick="document.getElementById('sidebar').classList.toggle('show')">
                <i class="bi bi-list fs-5"></i>
            </button>
            <span class="topbar-title">@yield('title', 'Dashboard')</span>
        </div>
        <div class="topbar-right">
            <div class="user-badge">
                <i class="bi bi-person-circle"></i>
                {{ session('user_name') }}
                @php $role = session('user_role', 'staff'); @endphp
                <span class="role-chip role-{{ $role }}">{{ $role }}</span>
            </div>
        </div>
    </div>

    <div id="content">
        @if(session('success'))
            <div class="flash-success mb-3 d-flex align-items-center gap-2">
                <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="flash-error mb-3 d-flex align-items-center gap-2">
                <i class="bi bi-exclamation-circle-fill"></i> {{ session('error') }}
            </div>
        @endif
        @if($errors->any())
            <div class="flash-error mb-3">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <strong>Please fix the following errors:</strong>
                <ul class="mb-0 mt-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
@yield('scripts')
</body>
</html>
