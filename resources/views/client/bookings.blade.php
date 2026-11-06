@extends('layouts.app')
@section('title', 'My Bookings')
@section('content')

<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4><i class="bi bi-calendar-check me-2 text-gold"></i>My Bookings</h4>
        <p class="text-muted small mb-0">All your photography booking requests</p>
    </div>
    <a href="{{ route('photographers.index') }}" class="btn btn-gold">
        <i class="bi bi-plus-lg me-2"></i> New Booking
    </a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Photographer</th>
                    <th>Event</th>
                    <th>Date</th>
                    <th>Location</th>
                    <th>Package</th>
                    <th>Budget</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="avatar-sm" style="width:36px;height:36px;font-size:14px">
                                {{ strtoupper(substr($booking->photographer->name, 0, 1)) }}
                            </div>
                            <span class="fw-bold">{{ $booking->photographer->name }}</span>
                        </div>
                    </td>
                    <td>{{ $booking->event_type }}</td>
                    <td><i class="bi bi-calendar3 me-1 text-muted"></i>{{ $booking->event_date->format('d M Y') }}</td>
                    <td><i class="bi bi-geo-alt me-1 text-muted"></i>{{ $booking->event_location }}</td>
                    <td>
                        @if($booking->package)
                            <span class="tag">{{ $booking->package->name }}</span>
                        @else —
                        @endif
                    </td>
                    <td class="fw-bold">LKR {{ number_format($booking->budget, 0) }}</td>
                    <td>
                        <span class="badge-{{ $booking->status }}">{{ ucfirst($booking->status) }}</span>
                        @if($booking->isCancelled() && $booking->cancellation_reason)
                            <br><small class="text-muted">{{ $booking->cancellation_reason }}</small>
                        @endif
                    </td>
                    <td>
                        @if($booking->isPending())
                            <form action="{{ route('client.bookings.cancel', $booking) }}"
                                  method="POST"
                                  onsubmit="return confirm('Cancel this booking?')">
                                @csrf @method('PATCH')
                                <button class="btn btn-sm btn-danger">
                                    <i class="bi bi-x-circle me-1"></i> Cancel
                                </button>
                            </form>
                        @endif

                        @if($booking->isCompleted() && !$booking->review)
                            <button class="btn btn-sm btn-gold"
                                    data-bs-toggle="modal"
                                    data-bs-target="#reviewModal{{ $booking->id }}">
                                <i class="bi bi-star me-1"></i> Review
                            </button>

                            <div class="modal fade" id="reviewModal{{ $booking->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">
                                                <i class="bi bi-star me-2"></i>
                                                Review {{ $booking->photographer->name }}
                                            </h5>
                                            <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal"></button>
                                        </div>
                                        <form action="{{ route('client.bookings.review', $booking) }}"
                                              method="POST">
                                            @csrf
                                            <div class="modal-body p-4">
                                                <div class="mb-3">
                                                    <label class="form-label">Rating</label>
                                                    <select name="rating" class="form-select" required>
                                                        <option value="5">⭐⭐⭐⭐⭐ Excellent</option>
                                                        <option value="4">⭐⭐⭐⭐ Good</option>
                                                        <option value="3">⭐⭐⭐ Average</option>
                                                        <option value="2">⭐⭐ Below average</option>
                                                        <option value="1">⭐ Poor</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Comment</label>
                                                    <textarea name="comment" class="form-control"
                                                              rows="3"
                                                              placeholder="Share your experience..."></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-gold">
                                                    <i class="bi bi-send me-1"></i> Submit Review
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @elseif($booking->isCompleted() && $booking->review)
                            <span class="badge-completed">
                                ⭐ {{ $booking->review->rating }} Reviewed
                            </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5 text-muted">
                        <i class="bi bi-calendar-x d-block fs-2 mb-2"></i>
                        No bookings yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $bookings->links() }}</div>
@endsection