@extends('layouts.app')
@section('title', 'Browse Photographers')
@section('content')

<div class="page-header">
    <h4><i class="bi bi-camera2 me-2 text-gold"></i>Browse Photographers</h4>
    <p class="text-muted small mb-0">Find the perfect photographer for your event</p>
</div>

<div class="card mb-4 p-3">
    <form class="row g-2 align-items-end" method="GET">
        <div class="col-md-3">
            <label class="form-label small">
                <i class="bi bi-geo-alt me-1"></i> Location
            </label>
            <input type="text" name="location" class="form-control"
                   placeholder="e.g. Kandy, Colombo"
                   value="{{ request('location') }}">
        </div>
        <div class="col-md-3">
            <label class="form-label small">
                <i class="bi bi-tag me-1"></i> Specialization
            </label>
            <input type="text" name="specialization" class="form-control"
                   placeholder="e.g. Wedding, Portrait"
                   value="{{ request('specialization') }}">
        </div>
        <div class="col-md-3">
            <label class="form-label small">
                <i class="bi bi-currency-dollar me-1"></i> Max price/hr (LKR)
            </label>
            <input type="number" name="max_price" class="form-control"
                   placeholder="e.g. 10000"
                   value="{{ request('max_price') }}">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-gold w-100">
                <i class="bi bi-search me-1"></i> Search
            </button>
        </div>
        <div class="col-md-1">
            <a href="{{ route('photographers.index') }}"
               class="btn btn-outline-secondary w-100">
                <i class="bi bi-x-lg"></i>
            </a>
        </div>
    </form>
</div>

<div class="row g-4">
    @forelse($photographers as $photographer)
    <div class="col-md-4">
        <div class="card photographer-card h-100">
            <div class="card-body p-4">
                <div class="d-flex align-items-center gap-3 mb-3">
                  @if($photographer->profile_photo)
    <img src="{{ asset('storage/' . $photographer->profile_photo) }}"
         class="rounded-circle me-3"
         width="64" height="64"
         style="object-fit:cover;border:3px solid #f0ebe0"
         onerror="this.onerror=null;this.style.display='none'">
@else
    <div class="avatar-sm" style="width:64px;height:64px;font-size:24px">
        {{ strtoupper(substr($photographer->name, 0, 1)) }}
    </div>
@endif
                    <div>
                        <h6 class="mb-0 fw-bold" style="font-family:'Playfair Display',serif">
                            {{ $photographer->name }}
                        </h6>
                        <small class="text-muted">
                            <i class="bi bi-geo-alt me-1"></i>
                            {{ $photographer->photographerProfile->location ?? '—' }}
                        </small>
                    </div>
                </div>

                <div class="mb-3">
                    <span class="tag me-1">
                        {{ $photographer->photographerProfile->specialization ?? 'General' }}
                    </span>
                    <span class="tag">
                        {{ $photographer->photographerProfile->years_of_experience ?? 0 }} yrs exp
                    </span>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <div class="fw-bold" style="font-size:18px;font-family:'Playfair Display',serif;color:var(--primary)">
                            LKR {{ number_format($photographer->photographerProfile->price_per_hour ?? 0) }}
                            <small class="text-muted fw-normal" style="font-size:12px;font-family:'Inter',sans-serif">/hr</small>
                        </div>
                    </div>
                    <div class="text-end">
                        <div class="text-gold fw-bold">
                            ⭐ {{ number_format($photographer->photographerProfile->averageRating(), 1) }}
                        </div>
                        <small class="text-muted">rating</small>
                    </div>
                </div>

                @if($photographer->photographerProfile->is_available)
                    <div class="d-flex align-items-center gap-1 mb-0">
                        <span class="badge bg-success rounded-pill">
                            <i class="bi bi-circle-fill me-1" style="font-size:8px"></i>
                            Available
                        </span>
                    </div>
                @else
                    <span class="badge bg-secondary rounded-pill">Unavailable</span>
                @endif
            </div>
            <div class="card-footer bg-white border-0 p-3 pt-0">
                <a href="{{ route('photographers.show', $photographer->id) }}"
                   class="btn btn-primary w-100">
                    View Profile <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="card p-5 text-center">
            <i class="bi bi-camera d-block fs-1 text-muted mb-3"></i>
            <h5>No photographers found</h5>
            <p class="text-muted">Try adjusting your search filters.</p>
            <a href="{{ route('photographers.index') }}" class="btn btn-gold mx-auto" style="width:fit-content">
                Clear filters
            </a>
        </div>
    </div>
    @endforelse
</div>

<div class="mt-4">{{ $photographers->links() }}</div>
@endsection