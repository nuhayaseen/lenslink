@extends('layouts.app')
@section('title', 'My Earnings')
@section('content')

<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4><i class="bi bi-cash-stack me-2 text-gold"></i>My Earnings</h4>
        <p class="text-muted small mb-0">Track all your booking payments and earnings</p>
    </div>
</div>

{{-- Stats --}}
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stat-card stat-dark">
            <div class="stat-num">{{ $stats['total'] }}</div>
            <div class="stat-label">
                <i class="bi bi-receipt me-1"></i> Total Payments
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card stat-green">
            <div class="stat-num">{{ $stats['paid'] }}</div>
            <div class="stat-label">
                <i class="bi bi-check-circle me-1"></i> Received
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card stat-gold">
            <div class="stat-num">{{ $stats['pending'] }}</div>
            <div class="stat-label">
                <i class="bi bi-hourglass me-1"></i> Pending
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card stat-green">
            <div class="stat-num" style="font-size:18px">
                LKR {{ number_format($stats['total_earned'], 0) }}
            </div>
            <div class="stat-label">
                <i class="bi bi-cash me-1"></i> Total Earned
            </div>
        </div>
    </div>
</div>

{{-- Pending Alert --}}
@if($stats['pending'] > 0)
<div class="alert alert-warning d-flex align-items-center gap-2 mb-4">
    <i class="bi bi-exclamation-triangle-fill fs-5"></i>
    <span>
        You have <strong>{{ $stats['pending'] }}</strong> pending
        payment{{ $stats['pending'] > 1 ? 's' : '' }}.
        Admin will mark them as paid after receiving payment.
    </span>
</div>
@endif

{{-- Payments Table --}}
<div class="card">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Client</th>
                    <th>Event</th>
                    <th>Date</th>
                    <th>Package</th>
                    <th>Amount</th>
                    <th>Booking Status</th>
                    <th>Payment Status</th>
                    <th>Note</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                <tr>
                    <td class="text-muted small">{{ $payment->id }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="avatar-sm"
                                 style="width:36px;height:36px;font-size:14px">
                                {{ strtoupper(substr($payment->booking->client->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="fw-bold small">
                                    {{ $payment->booking->client->name }}
                                </div>
                                <div class="text-muted" style="font-size:11px">
                                    {{ $payment->booking->client->phone }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="fw-bold small">{{ $payment->booking->event_type }}</div>
                        <div class="text-muted" style="font-size:11px">
                            <i class="bi bi-geo-alt me-1"></i>
                            {{ $payment->booking->event_location }}
                        </div>
                    </td>
                    <td>
                        <i class="bi bi-calendar3 me-1 text-muted"></i>
                        <small>{{ $payment->booking->event_date->format('d M Y') }}</small>
                    </td>
                    <td>
                        @if($payment->booking->package)
                            <span class="tag">{{ $payment->booking->package->name }}</span>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>
                        <div class="fw-bold"
                             style="font-family:'Playfair Display',serif;
                                    font-size:16px;color:var(--primary)">
                            LKR {{ number_format($payment->amount, 0) }}
                        </div>
                    </td>
                    <td>
                        <span class="badge-{{ $payment->booking->status }}">
                            {{ ucfirst($payment->booking->status) }}
                        </span>
                    </td>
                    <td>
                        @if($payment->payment_status === 'paid')
                            <span class="badge-accepted">
                                <i class="bi bi-check-circle me-1"></i> Received
                            </span>
                        @else
                            <span class="badge-pending">
                                <i class="bi bi-hourglass me-1"></i> Pending
                            </span>
                        @endif
                    </td>
                    <td>
                        <small class="text-muted">
                            {{ $payment->payment_note ?? '—' }}
                        </small>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-5 text-muted">
                        <i class="bi bi-cash d-block fs-2 mb-2"></i>
                        No payments yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $payments->links() }}</div>
@endsection