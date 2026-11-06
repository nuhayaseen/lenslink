@extends('layouts.app')
@section('title', 'Admin Dashboard')
@section('content')

<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4><i class="bi bi-speedometer2 me-2 text-gold"></i>Admin Dashboard</h4>
        <p class="text-muted small mb-0">Platform overview and management</p>
    </div>
    <span class="tag">
        <i class="bi bi-shield-check me-1 text-gold"></i> Administrator
    </span>
</div>

{{-- Stats --}}
<div class="row g-3 mb-4">
    <div class="col-md-2">
        <div class="stat-card stat-dark">
            <div class="stat-num">{{ $stats['total_users'] }}</div>
            <div class="stat-label"><i class="bi bi-people me-1"></i> Total Users</div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="stat-card stat-gold">
            <div class="stat-num">{{ $stats['photographers'] }}</div>
            <div class="stat-label"><i class="bi bi-camera2 me-1"></i> Photographers</div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="stat-card stat-slate">
            <div class="stat-num">{{ $stats['clients'] }}</div>
            <div class="stat-label"><i class="bi bi-person me-1"></i> Clients</div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="stat-card stat-dark">
            <div class="stat-num">{{ $stats['total_bookings'] }}</div>
            <div class="stat-label"><i class="bi bi-calendar3 me-1"></i> Bookings</div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="stat-card stat-warm">
            <div class="stat-num">{{ $stats['pending_bookings'] }}</div>
            <div class="stat-label"><i class="bi bi-hourglass me-1"></i> Pending</div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="stat-card stat-green">
            <div class="stat-num" style="font-size:18px">
                LKR {{ number_format($stats['revenue'], 0) }}
            </div>
            <div class="stat-label"><i class="bi bi-cash-stack me-1"></i> Revenue</div>
        </div>
    </div>
</div>

{{-- Quick Actions --}}
<div class="row g-3">
    <div class="col-md-4">
        <a href="{{ route('admin.users.index') }}"
           class="card text-decoration-none h-100"
           style="transition:transform 0.2s"
           onmouseover="this.style.transform='translateY(-4px)'"
           onmouseout="this.style.transform='translateY(0)'">
            <div class="card-body p-4 text-center">
                <div class="mb-3" style="font-size:48px">👥</div>
                <h5 style="font-family:'Playfair Display',serif;color:var(--primary)">
                    Manage Users
                </h5>
                <p class="text-muted small mb-3">
                    View, activate or deactivate user accounts
                </p>
                <div class="d-flex justify-content-center gap-3">
                    <div class="text-center">
                        <div class="fw-bold text-gold">{{ $stats['photographers'] }}</div>
                        <small class="text-muted">Photographers</small>
                    </div>
                    <div class="text-center">
                        <div class="fw-bold text-gold">{{ $stats['clients'] }}</div>
                        <small class="text-muted">Clients</small>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white border-0 text-center pb-4">
                <span class="btn btn-outline-primary btn-sm px-4">
                    Go to Users <i class="bi bi-arrow-right ms-1"></i>
                </span>
            </div>
        </a>
    </div>

    <div class="col-md-4">
        <a href="{{ route('admin.photographers.index') }}"
           class="card text-decoration-none h-100"
           style="transition:transform 0.2s"
           onmouseover="this.style.transform='translateY(-4px)'"
           onmouseout="this.style.transform='translateY(0)'">
            <div class="card-body p-4 text-center">
                <div class="mb-3" style="font-size:48px">📷</div>
                <h5 style="font-family:'Playfair Display',serif;color:var(--primary)">
                    Manage Photographers
                </h5>
                <p class="text-muted small mb-3">
                    View photographer profiles, portfolios and bookings
                </p>
                <div class="d-flex justify-content-center gap-3">
                    <div class="text-center">
                        <div class="fw-bold text-gold">{{ $stats['photographers'] }}</div>
                        <small class="text-muted">Total</small>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white border-0 text-center pb-4">
                <span class="btn btn-outline-primary btn-sm px-4">
                    Go to Photographers <i class="bi bi-arrow-right ms-1"></i>
                </span>
            </div>
        </a>
    </div>

    <div class="col-md-4">
        <a href="{{ route('admin.bookings.index') }}"
           class="card text-decoration-none h-100"
           style="transition:transform 0.2s"
           onmouseover="this.style.transform='translateY(-4px)'"
           onmouseout="this.style.transform='translateY(0)'">
            <div class="card-body p-4 text-center">
                <div class="mb-3" style="font-size:48px">📅</div>
                <h5 style="font-family:'Playfair Display',serif;color:var(--primary)">
                    Manage Bookings
                </h5>
                <p class="text-muted small mb-3">
                    Monitor all bookings, statuses and payments
                </p>
                <div class="d-flex justify-content-center gap-3">
                    <div class="text-center">
                        <div class="fw-bold text-gold">{{ $stats['total_bookings'] }}</div>
                        <small class="text-muted">Total</small>
                    </div>
                    <div class="text-center">
                        <div class="fw-bold text-gold">{{ $stats['pending_bookings'] }}</div>
                        <small class="text-muted">Pending</small>
                    </div>
                    <div class="text-center">
                        <div class="fw-bold text-gold">{{ $stats['completed_bookings'] }}</div>
                        <small class="text-muted">Done</small>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white border-0 text-center pb-4">
                <span class="btn btn-outline-primary btn-sm px-4">
                    Go to Bookings <i class="bi bi-arrow-right ms-1"></i>
                </span>
            </div>
        </a>
    </div>
</div>
@endsection