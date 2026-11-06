@extends('layouts.app')
@section('title', 'Manage Bookings')
@section('content')

<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4><i class="bi bi-calendar3 me-2 text-gold"></i>All Bookings</h4>
        <p class="text-muted small mb-0">Monitor and review all platform bookings</p>
    </div>
    <form method="GET" class="d-flex align-items-center gap-2">
        <label class="form-label mb-0 small text-muted">Filter:</label>
        <select name="status" class="form-select form-select-sm"
                style="width:160px" onchange="this.form.submit()">
            <option value="">All statuses</option>
            @foreach(['pending','accepted','cancelled','completed'] as $s)
                <option value="{{ $s }}"
                    {{ request('status') === $s ? 'selected' : '' }}>
                    {{ ucfirst($s) }}
                </option>
            @endforeach
        </select>
    </form>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Client</th>
                    <th>Photographer</th>
                    <th>Event</th>
                    <th>Date</th>
                    <th>Package</th>
                    <th>Budget</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                <tr>
                    <td class="text-muted small">{{ $booking->id }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="avatar-sm" style="width:32px;height:32px;font-size:12px">
                                {{ strtoupper(substr($booking->client->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="fw-bold small">{{ $booking->client->name }}</div>
                                <div class="text-muted" style="font-size:11px">
                                    {{ $booking->client->email }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="avatar-sm" style="width:32px;height:32px;font-size:12px">
                                {{ strtoupper(substr($booking->photographer->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="fw-bold small">{{ $booking->photographer->name }}</div>
                                <div class="text-muted" style="font-size:11px">
                                    {{ $booking->photographer->email }}
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="fw-bold small">{{ $booking->event_type }}</div>
                        <div class="text-muted" style="font-size:11px">
                            <i class="bi bi-geo-alt me-1"></i>{{ $booking->event_location }}
                        </div>
                    </td>
                    <td class="small">
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
                    <td class="fw-bold small">
                        LKR {{ number_format($booking->budget, 0) }}
                    </td>
                    <td>
                        <span class="badge-{{ $booking->status }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                        @if($booking->cancellation_reason)
                            <br>
                            <small class="text-muted" style="font-size:11px">
                                {{ Str::limit($booking->cancellation_reason, 30) }}
                            </small>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5 text-muted">
                        <i class="bi bi-calendar-x d-block fs-2 mb-2"></i>
                        No bookings found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $bookings->links() }}</div>
@endsection