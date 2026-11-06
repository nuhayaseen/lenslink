@extends('layouts.app')
@section('title', 'Payment Management')
@section('content')

<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4><i class="bi bi-cash-stack me-2 text-gold"></i>Payment Management</h4>
        <p class="text-muted small mb-0">Track and manage all platform payments</p>
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
                <i class="bi bi-check-circle me-1"></i> Paid
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
                LKR {{ number_format($stats['revenue'], 0) }}
            </div>
            <div class="stat-label">
                <i class="bi bi-cash me-1"></i> Total Revenue
            </div>
        </div>
    </div>
</div>

{{-- Pending Amount Alert --}}
@if($stats['pending_amount'] > 0)
<div class="alert alert-warning d-flex align-items-center gap-2 mb-4">
    <i class="bi bi-exclamation-triangle-fill fs-5"></i>
    <span>
        <strong>LKR {{ number_format($stats['pending_amount'], 0) }}</strong>
        in pending payments waiting to be collected.
    </span>
</div>
@endif

{{-- Filters --}}
<div class="card mb-4 p-3">
    <form class="row g-2 align-items-end" method="GET">
        <div class="col-md-4">
            <label class="form-label small">Search client or photographer</label>
            <input type="text" name="search" class="form-control"
                   placeholder="Name..." value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <label class="form-label small">Payment status</label>
            <select name="status" class="form-select">
                <option value="">All statuses</option>
                <option value="pending"
                    {{ request('status') === 'pending' ? 'selected' : '' }}>
                    Pending
                </option>
                <option value="paid"
                    {{ request('status') === 'paid' ? 'selected' : '' }}>
                    Paid
                </option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-gold w-100">
                <i class="bi bi-search me-1"></i> Filter
            </button>
        </div>
        <div class="col-md-1">
            <a href="{{ route('admin.payments.index') }}"
               class="btn btn-outline-secondary w-100">
                <i class="bi bi-x-lg"></i>
            </a>
        </div>
    </form>
</div>

{{-- Payments Table --}}
<div class="card">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Client</th>
                    <th>Photographer</th>
                    <th>Event</th>
                    <th>Package</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Note</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                <tr>
                    <td class="text-muted small">{{ $payment->id }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="avatar-sm"
                                 style="width:32px;height:32px;font-size:12px">
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
                        <div class="d-flex align-items-center gap-2">
                            <div class="avatar-sm"
                                 style="width:32px;height:32px;font-size:12px">
                                {{ strtoupper(substr($payment->booking->photographer->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="fw-bold small">
                                    {{ $payment->booking->photographer->name }}
                                </div>
                                <div class="text-muted" style="font-size:11px">
                                    {{ $payment->booking->photographer->email }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="fw-bold small">
                            {{ $payment->booking->event_type }}
                        </div>
                        <div class="text-muted" style="font-size:11px">
                            <i class="bi bi-calendar3 me-1"></i>
                            {{ $payment->booking->event_date->format('d M Y') }}
                        </div>
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
                             style="font-family:'Playfair Display',serif;font-size:16px;color:var(--primary)">
                            LKR {{ number_format($payment->amount, 0) }}
                        </div>
                    </td>
                    <td>
                        @if($payment->payment_status === 'paid')
                            <span class="badge-accepted">
                                <i class="bi bi-check-circle me-1"></i> Paid
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
                    <td>
                        <div class="d-flex gap-1 flex-wrap">
                            <a href="{{ route('admin.payments.show', $payment) }}"
                               class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i>
                            </a>

                            @if($payment->payment_status === 'pending')
                                <button class="btn btn-sm btn-success"
                                        data-bs-toggle="modal"
                                        data-bs-target="#paidModal{{ $payment->id }}">
                                    <i class="bi bi-check-lg me-1"></i> Mark Paid
                                </button>

                                {{-- Mark Paid Modal --}}
                                <div class="modal fade"
                                     id="paidModal{{ $payment->id }}"
                                     tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">
                                                    <i class="bi bi-cash me-2"></i>
                                                    Mark Payment as Paid
                                                </h5>
                                                <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('admin.payments.mark-paid', $payment) }}"
                                                  method="POST">
                                                @csrf @method('PATCH')
                                                <div class="modal-body p-4">
                                                    <div class="bg-soft rounded-3 p-3 mb-3">
                                                        <div class="row g-2 small">
                                                            <div class="col-6">
                                                                <div class="text-muted">Client</div>
                                                                <div class="fw-bold">
                                                                    {{ $payment->booking->client->name }}
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="text-muted">Photographer</div>
                                                                <div class="fw-bold">
                                                                    {{ $payment->booking->photographer->name }}
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="text-muted">Event</div>
                                                                <div class="fw-bold">
                                                                    {{ $payment->booking->event_type }}
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="text-muted">Amount</div>
                                                                <div class="fw-bold text-gold"
                                                                     style="font-family:'Playfair Display',serif">
                                                                    LKR {{ number_format($payment->amount, 0) }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">
                                                            <i class="bi bi-chat-text me-1"></i>
                                                            Payment note (optional)
                                                        </label>
                                                        <input type="text"
                                                               name="payment_note"
                                                               class="form-control"
                                                               placeholder="e.g. Cash received, Bank transfer...">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button"
                                                            class="btn btn-outline-secondary"
                                                            data-bs-dismiss="modal">
                                                        Cancel
                                                    </button>
                                                    <button type="submit"
                                                            class="btn btn-success">
                                                        <i class="bi bi-check-lg me-1"></i>
                                                        Confirm Payment
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            @else
                                <form action="{{ route('admin.payments.mark-pending', $payment) }}"
                                      method="POST"
                                      onsubmit="return confirm('Mark this payment as pending?')">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-sm btn-outline-warning">
                                        <i class="bi bi-arrow-counterclockwise me-1"></i>
                                        Revert
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-5 text-muted">
                        <i class="bi bi-cash d-block fs-2 mb-2"></i>
                        No payments found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $payments->links() }}</div>
@endsection