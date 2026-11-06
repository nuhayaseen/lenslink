@extends('layouts.app')
@section('title', 'Photographer Dashboard')
@section('content')
<meta http-equiv="refresh" content="60">

<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4><i class="bi bi-camera2 me-2 text-gold"></i>My Dashboard</h4>
        <p class="text-muted small mb-0">Welcome back, {{ auth()->user()->name }}</p>
    </div>
    <a href="{{ route('photographer.profile.edit') }}" class="btn btn-outline-primary btn-sm">
        <i class="bi bi-pencil me-1"></i> Edit Profile
    </a>
</div>

{{-- Stats --}}
<div class="row g-3 mb-4">
    <div class="col-md-2">
        <div class="stat-card stat-dark">
            <div class="stat-num">{{ $stats['total'] }}</div>
            <div class="stat-label"><i class="bi bi-calendar3 me-1"></i> Total</div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="stat-card stat-gold">
            <div class="stat-num">{{ $stats['pending'] }}</div>
            <div class="stat-label"><i class="bi bi-hourglass-split me-1"></i> Pending</div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="stat-card stat-green">
            <div class="stat-num">{{ $stats['accepted'] }}</div>
            <div class="stat-label"><i class="bi bi-check-circle me-1"></i> Accepted</div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="stat-card stat-slate">
            <div class="stat-num">{{ $stats['completed'] }}</div>
            <div class="stat-label"><i class="bi bi-trophy me-1"></i> Completed</div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="stat-card stat-green">
            <div class="stat-num" style="font-size:20px">
                LKR {{ number_format($stats['earnings'], 0) }}
            </div>
            <div class="stat-label"><i class="bi bi-cash-stack me-1"></i> Earnings</div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="stat-card stat-warm">
            <div class="stat-num">{{ number_format($stats['avg_rating'], 1) }}</div>
            <div class="stat-label"><i class="bi bi-star-fill me-1"></i> Avg Rating</div>
        </div>
    </div>
</div>

{{-- Booking Requests --}}
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>
            <i class="bi bi-calendar-event me-2 text-gold"></i>Booking Requests
        </span>
        @if($stats['pending'] > 0)
            <span class="badge-pending">
                <i class="bi bi-bell-fill me-1"></i>
                {{ $stats['pending'] }} new request{{ $stats['pending'] > 1 ? 's' : '' }}
            </span>
        @endif
    </div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Client</th>
                    <th>Event</th>
                    <th>Date</th>
                    <th>Location</th>
                    <th>Package</th>
                    <th>Budget</th>
                    <th>Guests</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                <tr class="{{ $booking->isPending() ? 'pending-row' : '' }}">
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="avatar-sm" style="width:36px;height:36px;font-size:14px">
                                {{ strtoupper(substr($booking->client->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="fw-bold small">{{ $booking->client->name }}</div>
                                <div class="text-muted" style="font-size:11px">
                                    {{ $booking->client->phone }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>{{ $booking->event_type }}</td>
                    <td>
                        <i class="bi bi-calendar3 me-1 text-muted"></i>
                        {{ $booking->event_date->format('d M Y') }}
                    </td>
                    <td>
                        <i class="bi bi-geo-alt me-1 text-muted"></i>
                        {{ $booking->event_location }}
                    </td>
                    <td>
                        @if($booking->package)
                            <span class="tag">{{ $booking->package->name }}</span>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td class="fw-bold">LKR {{ number_format($booking->budget, 0) }}</td>
                    <td>{{ $booking->guest_count ?? '—' }}</td>
                    <td>
                        <span class="badge-{{ $booking->status }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </td>
                    <td>
                        @if($booking->isPending())
                            <div class="d-flex gap-1 flex-wrap">
                                <form action="{{ route('photographer.bookings.accept', $booking) }}"
                                      method="POST"
                                      onsubmit="return confirm('Accept this booking from {{ $booking->client->name }}?')">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-success btn-sm">
                                        <i class="bi bi-check-lg me-1"></i> Accept
                                    </button>
                                </form>

                                <button class="btn btn-danger btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#cancelModal{{ $booking->id }}">
                                    <i class="bi bi-x-lg me-1"></i> Cancel
                                </button>
                            </div>

                            {{-- Cancel Modal --}}
                            <div class="modal fade" id="cancelModal{{ $booking->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">
                                                <i class="bi bi-x-circle me-2"></i>
                                                Cancel Booking
                                            </h5>
                                            <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="{{ route('photographer.bookings.cancel', $booking) }}"
                                              method="POST">
                                            @csrf @method('PATCH')
                                            <div class="modal-body p-4">
                                                <div class="bg-soft rounded-3 p-3 mb-3">
                                                    <div class="small text-muted mb-1">Booking details</div>
                                                    <div class="fw-bold">{{ $booking->client->name }}</div>
                                                    <div class="text-muted small">
                                                        {{ $booking->event_type }} ·
                                                        {{ $booking->event_date->format('d M Y') }}
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">
                                                        <i class="bi bi-chat-text me-1"></i>
                                                        Reason for cancellation
                                                    </label>
                                                    <textarea name="cancellation_reason"
                                                              class="form-control"
                                                              rows="3"
                                                              placeholder="Please provide a reason so the client is informed..."
                                                              required></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-outline-secondary"
                                                        data-bs-dismiss="modal">
                                                    <i class="bi bi-arrow-left me-1"></i> Go Back
                                                </button>
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="bi bi-x-circle me-1"></i> Confirm Cancel
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        @elseif($booking->isAccepted())
                            <form action="{{ route('photographer.bookings.complete', $booking) }}"
                                  method="POST"
                                  onsubmit="return confirm('Mark this booking as completed?')">
                                @csrf @method('PATCH')
                                <button class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-check2-all me-1"></i> Mark Complete
                                </button>
                            </form>
                        @else
                            <span class="badge-{{ $booking->status }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                        @endif
                    </td>
                </tr>

                @if($booking->additional_notes)
                <tr class="{{ $booking->isPending() ? 'pending-row' : '' }}">
                    <td colspan="9" class="py-1 ps-4">
                        <small class="text-muted">
                            <i class="bi bi-chat-quote me-1 text-gold"></i>
                            {{ $booking->additional_notes }}
                        </small>
                    </td>
                </tr>
                @endif

                @empty
                <tr>
                    <td colspan="9" class="text-center py-5 text-muted">
                        <i class="bi bi-calendar-x d-block fs-2 mb-2"></i>
                        No booking requests yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $bookings->links() }}</div>
@endsection