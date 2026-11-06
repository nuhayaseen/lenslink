@extends('layouts.app')
@section('title', 'Payment Details')
@section('content')

<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4><i class="bi bi-receipt me-2 text-gold"></i>Payment Details</h4>
        <p class="text-muted small mb-0">Payment #{{ $payment->id }}</p>
    </div>
    <a href="{{ route('admin.payments.index') }}"
       class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Back
    </a>
</div>

<div class="row g-4">

    {{-- Payment Info --}}
    <div class="col-md-5">
        <div class="card mb-4">
            <div class="card-header">
                <i class="bi bi-cash me-2 text-gold"></i>Payment Info
            </div>
            <div class="card-body p-4">
                <div class="text-center mb-4 pb-4 border-bottom">
                    <div style="font-family:'Playfair Display',serif;font-size:36px;
                                font-weight:700;color:var(--primary)">
                        LKR {{ number_format($payment->amount, 0) }}
                    </div>
                    <div class="mt-2">
                        @if($payment->payment_status === 'paid')
                            <span class="badge-accepted fs-6">
                                <i class="bi bi-check-circle me-1"></i> Paid
                            </span>
                        @else
                            <span class="badge-pending fs-6">
                                <i class="bi bi-hourglass me-1"></i> Pending
                            </span>
                        @endif
                    </div>
                </div>

                <div class="row g-3 small">
                    <div class="col-6">
                        <div class="text-muted mb-1">Payment ID</div>
                        <div class="fw-bold">#{{ $payment->id }}</div>
                    </div>
                    <div class="col-6">
                        <div class="text-muted mb-1">Created</div>
                        <div class="fw-bold">
                            {{ $payment->created_at->format('d M Y') }}
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="text-muted mb-1">Payment note</div>
                        <div class="fw-bold">
                            {{ $payment->payment_note ?? '—' }}
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                {{-- Actions --}}
                @if($payment->payment_status === 'pending')
                <button class="btn btn-success w-100 mb-2"
                        data-bs-toggle="modal"
                        data-bs-target="#paidModalShow">
                    <i class="bi bi-check-lg me-2"></i> Mark as Paid
                </button>

                <div class="modal fade" id="paidModalShow" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Confirm Payment</h5>
                                <button type="button" class="btn-close"
                                        data-bs-dismiss="modal"></button>
                            </div>
                            <form action="{{ route('admin.payments.mark-paid', $payment) }}"
                                  method="POST">
                                @csrf @method('PATCH')
                                <div class="modal-body p-4">
                                    <div class="mb-3">
                                        <label class="form-label">Payment note</label>
                                        <input type="text" name="payment_note"
                                               class="form-control"
                                               placeholder="e.g. Cash received, Bank transfer...">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary"
                                            data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-success">
                                        <i class="bi bi-check-lg me-1"></i> Confirm
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @else
                <form action="{{ route('admin.payments.mark-pending', $payment) }}"
                      method="POST"
                      onsubmit="return confirm('Revert to pending?')">
                    @csrf @method('PATCH')
                    <button class="btn btn-outline-warning w-100">
                        <i class="bi bi-arrow-counterclockwise me-1"></i>
                        Revert to Pending
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>

    {{-- Booking Info --}}
    <div class="col-md-7">
        <div class="card mb-4">
            <div class="card-header">
                <i class="bi bi-calendar-event me-2 text-gold"></i>Booking Details
            </div>
            <div class="card-body p-4">
                <div class="row g-3 small">
                    <div class="col-md-6">
                        <div class="text-muted mb-1">Client</div>
                        <div class="d-flex align-items-center gap-2">
                            <div class="avatar-sm"
                                 style="width:32px;height:32px;font-size:12px">
                                {{ strtoupper(substr($payment->booking->client->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="fw-bold">
                                    {{ $payment->booking->client->name }}
                                </div>
                                <div class="text-muted" style="font-size:11px">
                                    {{ $payment->booking->client->email }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted mb-1">Photographer</div>
                        <div class="d-flex align-items-center gap-2">
                            <div class="avatar-sm"
                                 style="width:32px;height:32px;font-size:12px">
                                {{ strtoupper(substr($payment->booking->photographer->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="fw-bold">
                                    {{ $payment->booking->photographer->name }}
                                </div>
                                <div class="text-muted" style="font-size:11px">
                                    {{ $payment->booking->photographer->email }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted mb-1">Event type</div>
                        <div class="fw-bold">{{ $payment->booking->event_type }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted mb-1">Event date</div>
                        <div class="fw-bold">
                            {{ $payment->booking->event_date->format('d M Y') }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted mb-1">Location</div>
                        <div class="fw-bold">{{ $payment->booking->event_location }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted mb-1">Duration</div>
                        <div class="fw-bold">
                            {{ $payment->booking->duration_hours }} hours
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted mb-1">Package</div>
                        <div class="fw-bold">
                            @if($payment->booking->package)
                                <span class="tag">{{ $payment->booking->package->name }}</span>
                            @else
                                —
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted mb-1">Booking status</div>
                        <div>
                            <span class="badge-{{ $payment->booking->status }}">
                                {{ ucfirst($payment->booking->status) }}
                            </span>
                        </div>
                    </div>
                    @if($payment->booking->guest_count)
                    <div class="col-md-6">
                        <div class="text-muted mb-1">Guests</div>
                        <div class="fw-bold">{{ $payment->booking->guest_count }}</div>
                    </div>
                    @endif
                    @if($payment->booking->additional_notes)
                    <div class="col-12">
                        <div class="text-muted mb-1">Notes</div>
                        <div class="bg-soft rounded-3 p-3 small">
                            {{ $payment->booking->additional_notes }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>
@endsection