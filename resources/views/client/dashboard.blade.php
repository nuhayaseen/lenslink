@extends('layouts.app')
@section('title', 'Client Dashboard')
@section('content')

<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4><i class="bi bi-grid me-2 text-gold"></i>My Dashboard</h4>
        <p class="text-muted small mb-0">Welcome back, {{ auth()->user()->name }}</p>
    </div>
    <a href="{{ route('photographers.index') }}" class="btn btn-gold">
        <i class="bi bi-search me-2"></i> Book a Photographer
    </a>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stat-card stat-dark">
            <div class="stat-num">{{ $stats['total'] }}</div>
            <div class="stat-label"><i class="bi bi-calendar3 me-1"></i> Total Bookings</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card stat-gold">
            <div class="stat-num">{{ $stats['pending'] }}</div>
            <div class="stat-label"><i class="bi bi-hourglass-split me-1"></i> Pending</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card stat-green">
            <div class="stat-num">{{ $stats['accepted'] }}</div>
            <div class="stat-label"><i class="bi bi-check-circle me-1"></i> Accepted</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card stat-slate">
            <div class="stat-num">{{ $stats['completed'] }}</div>
            <div class="stat-label"><i class="bi bi-trophy me-1"></i> Completed</div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="bi bi-clock-history me-2 text-gold"></i>Recent Bookings</span>
        <a href="{{ route('client.bookings') }}" class="btn btn-sm btn-outline-primary">
            View all <i class="bi bi-arrow-right ms-1"></i>
        </a>
    </div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Photographer</th>
                    <th>Event</th>
                    <th>Date</th>
                    <th>Package</th>
                    <th>Budget</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recent as $booking)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="avatar-sm" style="width:36px;height:36px;font-size:14px">
                                {{ strtoupper(substr($booking->photographer->name, 0, 1)) }}
                            </div>
                            <span class="fw-500">{{ $booking->photographer->name }}</span>
                        </div>
                    </td>
                    <td>{{ $booking->event_type }}</td>
                    <td>
                        <i class="bi bi-calendar3 me-1 text-muted"></i>
                        {{ $booking->event_date->format('d M Y') }}
                    </td>
                    <td>
                        @if($booking->package)
                            <span class="tag">{{ $booking->package->name }}</span>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td class="fw-bold">LKR {{ number_format($booking->budget, 0) }}</td>
                    <td><span class="badge-{{ $booking->status }}">{{ ucfirst($booking->status) }}</span></td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">
                        <i class="bi bi-calendar-x d-block fs-2 mb-2"></i>
                        No bookings yet.
                        <a href="{{ route('photographers.index') }}" class="text-gold text-decoration-none fw-bold">
                            Browse photographers
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection