@extends('layouts.app')
@section('title', 'Manage Photographers')
@section('content')

<div class="page-header">
    <h4><i class="bi bi-camera2 me-2 text-gold"></i>Photographers</h4>
    <p class="text-muted small mb-0">All registered photographers on the platform</p>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Photographer</th>
                    <th>Location</th>
                    <th>Specialization</th>
                    <th>Price/hr</th>
                    <th>Experience</th>
                    <th>Bookings</th>
                    <th>Portfolio</th>
                    <th>Available</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($photographers as $photographer)
                <tr>
                    <td>
    <div class="d-flex align-items-center gap-2">
        @if($photographer->profile_photo)
            <img src="{{ asset('storage/' . $photographer->profile_photo) }}"
                 class="rounded-circle"
                 width="36" height="36"
                 style="object-fit:cover;border:2px solid #f0ebe0"
                 onerror="this.onerror=null;this.src='';this.style.display='none';this.nextElementSibling.style.display='flex'">
            <div class="avatar-sm"
                 style="width:36px;height:36px;font-size:14px;display:none">
                {{ strtoupper(substr($photographer->name, 0, 1)) }}
            </div>
        @else
            <div class="avatar-sm" style="width:36px;height:36px;font-size:14px">
                {{ strtoupper(substr($photographer->name, 0, 1)) }}
            </div>
        @endif
        <div>
            <div class="fw-bold small">{{ $photographer->name }}</div>
            <div class="text-muted" style="font-size:11px">
                {{ $photographer->email }}
            </div>
        </div>
    </div>
</td>
                    <td class="small">
                        <i class="bi bi-geo-alt me-1 text-muted"></i>
                        {{ $photographer->photographerProfile->location ?? '—' }}
                    </td>
                    <td>
                        @if($photographer->photographerProfile->specialization)
                            <span class="tag">
                                {{ $photographer->photographerProfile->specialization }}
                            </span>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td class="fw-bold small">
                        LKR {{ number_format($photographer->photographerProfile->price_per_hour ?? 0, 0) }}
                    </td>
                    <td class="small">
                        <i class="bi bi-award me-1 text-gold"></i>
                        {{ $photographer->photographerProfile->years_of_experience ?? 0 }} yrs
                    </td>
                    <td>
                        <span class="badge rounded-pill"
                              style="background:#f0ebe0;color:var(--primary)">
                            {{ $photographer->bookings_as_photographer_count }}
                        </span>
                    </td>
                    <td>
                        @if($photographer->photographerProfile->portfolio)
                            <span class="badge bg-success rounded-pill">
                                <i class="bi bi-check me-1"></i>Yes
                            </span>
                        @else
                            <span class="badge bg-warning text-dark rounded-pill">
                                <i class="bi bi-x me-1"></i>None
                            </span>
                        @endif
                    </td>
                    <td>
                        @if($photographer->photographerProfile->is_available)
                            <span class="badge bg-success rounded-pill">
                                <i class="bi bi-circle-fill me-1" style="font-size:8px"></i>Yes
                            </span>
                        @else
                            <span class="badge bg-secondary rounded-pill">No</span>
                        @endif
                    </td>
                    <td>
                        @if($photographer->is_active)
                            <span class="badge bg-success rounded-pill">Active</span>
                        @else
                            <span class="badge bg-danger rounded-pill">Inactive</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center py-5 text-muted">
                        <i class="bi bi-camera d-block fs-2 mb-2"></i>
                        No photographers found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div class="mt-3">{{ $photographers->links() }}</div>
@endsection