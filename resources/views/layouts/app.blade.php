<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LensLink – @yield('title', 'Photography Marketplace')</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary:     #1a1a2e;
            --accent:      #c9a84c;
            --accent-light:#f0d080;
            --soft:        #f7f4ef;
            --card-bg:     #ffffff;
            --text-dark:   #1a1a2e;
            --text-muted:  #6c757d;
            --success:     #2d6a4f;
            --danger:      #c1121f;
            --warning:     #e9c46a;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--soft);
            color: var(--text-dark);
            min-height: 100vh;
        }

        h1, h2, h3, h4, h5 {
            font-family: 'Playfair Display', serif;
        }

        /* ── NAVBAR ── */
        .navbar {
            background: var(--primary) !important;
            padding: 14px 0;
            box-shadow: 0 2px 20px rgba(0,0,0,0.3);
        }

        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-size: 24px;
            font-weight: 700;
            color: var(--accent) !important;
            letter-spacing: 1px;
        }

        .navbar-brand span { color: #ffffff; }

        .nav-link {
            color: rgba(255,255,255,0.8) !important;
            font-size: 13px;
            font-weight: 500;
            letter-spacing: 0.5px;
            padding: 6px 14px !important;
            border-radius: 6px;
            transition: all 0.2s;
        }

        .nav-link:hover {
            color: var(--accent) !important;
            background: rgba(201,168,76,0.1);
        }

        .nav-link.active { color: var(--accent) !important; }

        .btn-nav-login {
            background: transparent;
            border: 1px solid rgba(201,168,76,0.5);
            color: var(--accent) !important;
            font-size: 13px;
            padding: 6px 18px;
            border-radius: 6px;
            transition: all 0.2s;
        }

        .btn-nav-login:hover { background: rgba(201,168,76,0.15); }

        .btn-nav-signup {
            background: var(--accent);
            border: none;
            color: var(--primary) !important;
            font-size: 13px;
            font-weight: 600;
            padding: 6px 18px;
            border-radius: 6px;
            transition: all 0.2s;
        }

        .btn-nav-signup:hover { background: var(--accent-light); }

        .user-badge {
            background: rgba(201,168,76,0.15);
            border: 1px solid rgba(201,168,76,0.3);
            color: var(--accent);
            font-size: 12px;
            padding: 4px 12px;
            border-radius: 20px;
        }

        /* ── PAGE WRAPPER ── */
        .page-wrapper {
            min-height: calc(100vh - 70px);
            padding: 32px 0 60px;
        }

        /* ── CARDS ── */
        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 2px 20px rgba(0,0,0,0.06);
            background: var(--card-bg);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card:hover { box-shadow: 0 8px 32px rgba(0,0,0,0.10); }

        .card-header {
            background: transparent;
            border-bottom: 1px solid #f0ebe0;
            padding: 18px 24px;
            font-family: 'Playfair Display', serif;
            font-size: 16px;
        }

        /* ── STAT CARDS ── */
        .stat-card {
            border-radius: 16px;
            padding: 24px;
            text-align: center;
            border: none;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: -20px; right: -20px;
            width: 80px; height: 80px;
            border-radius: 50%;
            background: rgba(255,255,255,0.15);
        }

        .stat-card .stat-num {
            font-family: 'Playfair Display', serif;
            font-size: 36px;
            font-weight: 700;
            line-height: 1;
            margin-bottom: 6px;
        }

        .stat-card .stat-label {
            font-size: 12px;
            font-weight: 500;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            opacity: 0.85;
        }

        .stat-gold  { background: linear-gradient(135deg, #c9a84c, #e9c46a); color: #1a1a2e; }
        .stat-dark  { background: linear-gradient(135deg, #1a1a2e, #2d2d4e); color: #ffffff; }
        .stat-green { background: linear-gradient(135deg, #2d6a4f, #40916c); color: #ffffff; }
        .stat-rose  { background: linear-gradient(135deg, #c1121f, #e63946); color: #ffffff; }
        .stat-slate { background: linear-gradient(135deg, #4a4e69, #6b6f8e); color: #ffffff; }
        .stat-warm  { background: linear-gradient(135deg, #b5838d, #c9a0ab); color: #ffffff; }

        /* ── BUTTONS ── */
        .btn-primary {
            background: var(--primary);
            border-color: var(--primary);
            color: #fff;
            font-weight: 500;
            border-radius: 8px;
            padding: 9px 22px;
            transition: all 0.2s;
        }

        .btn-primary:hover {
            background: #2d2d4e;
            border-color: #2d2d4e;
            transform: translateY(-1px);
        }

        .btn-gold {
            background: var(--accent);
            border: none;
            color: var(--primary);
            font-weight: 600;
            border-radius: 8px;
            padding: 9px 22px;
            transition: all 0.2s;
        }

        .btn-gold:hover {
            background: var(--accent-light);
            color: var(--primary);
            transform: translateY(-1px);
        }

        .btn-outline-primary {
            border-color: var(--primary);
            color: var(--primary);
            border-radius: 8px;
            font-weight: 500;
        }

        .btn-outline-primary:hover {
            background: var(--primary);
            color: #fff;
        }

        .btn-success {
            background: var(--success);
            border-color: var(--success);
            border-radius: 8px;
            font-weight: 500;
        }

        .btn-danger {
            background: var(--danger);
            border-color: var(--danger);
            border-radius: 8px;
            font-weight: 500;
        }

        /* ── TABLES ── */
        .table { border-collapse: separate; border-spacing: 0; }

        .table thead th {
            background: #f7f4ef;
            color: var(--text-dark);
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            padding: 14px 18px;
            border: none;
        }

        .table tbody td {
            padding: 14px 18px;
            vertical-align: middle;
            border-bottom: 1px solid #f0ebe0;
            font-size: 13px;
        }

        .table tbody tr:hover td { background: #fdfaf4; }
        .table tbody tr:last-child td { border-bottom: none; }

        /* ── STATUS BADGES ── */
        .badge-pending {
            background: #fff3cd;
            color: #856404;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        .badge-accepted {
            background: #d1e7dd;
            color: #0f5132;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        .badge-cancelled {
            background: #f8d7da;
            color: #842029;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        .badge-completed {
            background: #e8e0f5;
            color: #4a235a;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        /* ── FORMS ── */
        .form-control, .form-select {
            border: 1px solid #e0d8cc;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 14px;
            background: #fdfaf4;
            transition: all 0.2s;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(201,168,76,0.15);
            background: #fff;
        }

        .form-label {
            font-size: 13px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 6px;
        }

        /* ── ALERTS ── */
        .alert {
            border: none;
            border-radius: 12px;
            font-size: 14px;
        }

        .alert-success { background: #d1e7dd; color: #0f5132; }
        .alert-danger  { background: #f8d7da; color: #842029; }
        .alert-info    { background: #e8f0fe; color: #1a56db; }
        .alert-warning { background: #fff3cd; color: #856404; }

        /* ── PAGE HEADER ── */
        .page-header {
            margin-bottom: 28px;
            padding-bottom: 16px;
            border-bottom: 2px solid #f0ebe0;
        }

        .page-header h4 {
            font-size: 28px;
            color: var(--primary);
            margin: 0;
        }

        /* ── PHOTOGRAPHER CARD ── */
        .photographer-card {
            border-radius: 16px;
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
            cursor: pointer;
        }

        .photographer-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 40px rgba(0,0,0,0.12) !important;
        }

        /* ── PACKAGE CARD ── */
        .package-card {
            border-radius: 16px;
            overflow: hidden;
            transition: transform 0.2s;
        }

        .package-card:hover { transform: translateY(-3px); }

        .package-card .package-header {
            background: var(--primary);
            color: var(--accent);
            padding: 16px;
            text-align: center;
            font-family: 'Playfair Display', serif;
            font-size: 18px;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .package-card .package-price {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            font-weight: 700;
            color: var(--primary);
        }

        /* ── FOOTER ── */
        .site-footer {
            background: var(--primary);
            color: rgba(255,255,255,0.6);
            text-align: center;
            padding: 20px;
            font-size: 13px;
            margin-top: auto;
        }

        .site-footer span { color: var(--accent); }

        /* ── MODALS ── */
        .modal-content {
            border: none;
            border-radius: 16px;
            overflow: hidden;
        }

        .modal-header {
            background: var(--primary);
            color: #fff;
            border: none;
            padding: 20px 24px;
        }

        .modal-header .btn-close { filter: invert(1); }

        .modal-title {
            font-family: 'Playfair Display', serif;
            font-size: 18px;
        }

        /* ── PAGINATION ── */
        .pagination .page-link {
            border-radius: 8px;
            margin: 0 2px;
            color: var(--primary);
            border: 1px solid #e0d8cc;
        }

        .pagination .page-item.active .page-link {
            background: var(--primary);
            border-color: var(--primary);
        }

        /* ── MISC ── */
        .section-divider {
            border: none;
            border-top: 2px solid #f0ebe0;
            margin: 28px 0;
        }

        .text-gold { color: var(--accent); }
        .bg-soft   { background: var(--soft); }

        .avatar-lg {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), #4a4e69);
            color: var(--accent);
            font-family: 'Playfair Display', serif;
            font-size: 36px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .avatar-sm {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), #4a4e69);
            color: var(--accent);
            font-family: 'Playfair Display', serif;
            font-size: 18px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .pending-row { background: #fffdf0 !important; }

        .tag {
            display: inline-block;
            background: #f0ebe0;
            color: var(--text-dark);
            font-size: 11px;
            padding: 3px 10px;
            border-radius: 20px;
            font-weight: 500;
        }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f7f4ef; }
        ::-webkit-scrollbar-thumb { background: #c9a84c; border-radius: 3px; }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="/">
            <i class="bi bi-camera2"></i> Lens<span>Link</span>
        </a>
        <button class="navbar-toggler border-secondary" type="button"
                data-bs-toggle="collapse" data-bs-target="#nav">
            <i class="bi bi-list text-white fs-4"></i>
        </button>
        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav me-auto ms-4">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('photographers.index') }}">
                        <i class="bi bi-search me-1"></i> Browse
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto align-items-center gap-1">
                @guest
                    <li class="nav-item">
                        <a class="nav-link btn-nav-login" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-nav-signup ms-2" href="{{ route('register') }}">
                            Get Started
                        </a>
                    </li>
                @else
                    @if(auth()->user()->isClient())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('client.dashboard') }}">
                                <i class="bi bi-grid me-1"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('client.bookings') }}">
                                <i class="bi bi-calendar-check me-1"></i> My Bookings
                            </a>
                        </li>
                        <li class="nav-item">
    <a class="nav-link" href="{{ route('client.payments.index') }}">
        <i class="bi bi-cash-stack me-1"></i> Payments
    </a>
</li>

                    @elseif(auth()->user()->isPhotographer())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('photographer.dashboard') }}">
                                <i class="bi bi-grid me-1"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('photographer.profile.edit') }}">
                                <i class="bi bi-person me-1"></i> Profile
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('photographer.portfolio.index') }}">
                                <i class="bi bi-images me-1"></i> Portfolio
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('photographer.packages.index') }}">
                                <i class="bi bi-box me-1"></i> Packages
                            </a>
                        </li>
                        <li class="nav-item">
<a class="nav-link" href="{{ route('photographer.payments.index') }}">                 
    <i class="bi bi-cash-stack me-1"></i> Earnings
    </a>
</li>


                    @elseif(auth()->user()->isAdmin())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-speedometer2 me-1"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.users.index') }}">
                                <i class="bi bi-people me-1"></i> Users
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.bookings.index') }}">
                                <i class="bi bi-calendar3 me-1"></i> Bookings
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.payments.index') }}">
                                <i class="bi bi-cash-stack me-1"></i> Payments
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.packages.index') }}">
                                <i class="bi bi-box me-1"></i> Packages
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.photographers.index') }}">
                                <i class="bi bi-camera2 me-1"></i> Photographers
                            </a>
                        </li>
                    @endif

                    <li class="nav-item ms-2">
                        <span class="user-badge">
                            <i class="bi bi-person-circle me-1"></i>
                            {{ auth()->user()->name }}
                        </span>
                    </li>
                    <li class="nav-item ms-1">
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-sm btn-outline-danger border-0"
                                    style="font-size:12px;padding:5px 14px;border-radius:6px;">
                                <i class="bi bi-box-arrow-right me-1"></i> Logout
                            </button>
                        </form>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<!-- ALERTS -->
<div class="container mt-3">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2">
            <i class="bi bi-check-circle-fill fs-5"></i>
            <span>{{ session('success') }}</span>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2">
            <i class="bi bi-exclamation-triangle-fill fs-5"></i>
            <span>{{ session('error') }}</span>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    @endif
</div>

<!-- PAGE CONTENT -->
<div class="page-wrapper">
    <div class="container">
        @yield('content')
    </div>
</div>

<!-- FOOTER -->
<footer class="site-footer">
    © {{ date('Y') }} <span>LensLink</span> — Photography Marketplace.
    All rights reserved.
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>