@extends('layouts.app')
@section('title', 'Book a Photographer')
@section('content')

<div class="page-header">
    <h4><i class="bi bi-calendar-plus me-2 text-gold"></i>Send a Booking Request</h4>
    <p class="text-muted small mb-0">Fill in your event details below</p>
</div>

<div class="row g-4">
    <div class="col-md-7">
        <div class="card">
            <div class="card-body p-4">
                <form action="{{ route('client.bookings.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="photographer_id" value="{{ $photographer->id }}">
                    <input type="hidden" name="package_id" value="{{ $selectedPackage->id ?? '' }}">

                    <div class="mb-3">
                        <label class="form-label">
                            <i class="bi bi-tag me-1"></i> Event Type
                        </label>
                        <select name="event_type"
                                class="form-select @error('event_type') is-invalid @enderror">
                            <option value="">-- Select event type --</option>
                            @foreach(['Wedding','Birthday Party','Corporate Event',
                                      'Portrait Session','Graduation','Anniversary','Other'] as $type)
                                <option value="{{ $type }}"
                                    {{ old('event_type') === $type ? 'selected' : '' }}>
                                    {{ $type }}
                                </option>
                            @endforeach
                        </select>
                        @error('event_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">
                                <i class="bi bi-calendar3 me-1"></i> Event Date
                            </label>
                            <input type="date" name="event_date"
                                   class="form-control @error('event_date') is-invalid @enderror"
                                   min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                   value="{{ old('event_date') }}" required>
                            @error('event_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">
                                <i class="bi bi-clock me-1"></i> Duration (hours)
                            </label>
                            <input type="number" name="duration_hours"
                                   class="form-control @error('duration_hours') is-invalid @enderror"
                                   min="1"
                                   value="{{ old('duration_hours', $selectedPackage->duration_hours ?? '') }}"
                                   required>
                            @error('duration_hours')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            <i class="bi bi-geo-alt me-1"></i> Event Location
                        </label>
                        <input type="text" name="event_location"
                               class="form-control @error('event_location') is-invalid @enderror"
                               value="{{ old('event_location') }}"
                               placeholder="Venue name or full address" required>
                        @error('event_location')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">
                                <i class="bi bi-cash me-1"></i> Budget (LKR)
                            </label>
                            <input type="number" name="budget"
                                   class="form-control @error('budget') is-invalid @enderror"
                                   min="1" step="100"
                                   value="{{ old('budget', $selectedPackage->price ?? '') }}"
                                   placeholder="e.g. 25000" required>
                            @error('budget')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">
                                <i class="bi bi-people me-1"></i> Guest Count
                            </label>
                            <input type="number" name="guest_count"
                                   class="form-control @error('guest_count') is-invalid @enderror"
                                   min="1"
                                   value="{{ old('guest_count') }}"
                                   placeholder="e.g. 100">
                            @error('guest_count')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">
                            <i class="bi bi-chat-left-text me-1"></i> Additional Notes
                            <span class="text-muted small">(optional)</span>
                        </label>
                        <textarea name="additional_notes" rows="4"
                                  class="form-control @error('additional_notes') is-invalid @enderror"
                                  placeholder="Any special requests, theme, style preferences...">{{ old('additional_notes') }}</textarea>
                        @error('additional_notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Global error (e.g. date conflict) --}}
                    @if(session('error'))
                        <div class="alert alert-danger py-2 small mb-3">
                            <i class="bi bi-exclamation-triangle me-1"></i>
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-gold flex-grow-1">
                            <i class="bi bi-send me-2"></i> Send Booking Request
                        </button>
                        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-1"></i> Back
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Photographer Summary Sidebar --}}
    <div class="col-md-5">
        <div class="card mb-3">
            <div class="card-header">
                <i class="bi bi-person-circle me-2 text-gold"></i> Photographer
            </div>

            
            <div class="card-body p-4 text-center">
                @if($photographer->profile_photo)
                    <img src="{{ asset('storage/' . $photographer->profile_photo) }}"
                         class="rounded-circle mb-3"
                         width="80" height="80"
                         style="object-fit:cover;border:3px solid #f0ebe0"
                         onerror="this.onerror=null;this.style.display='none'">
                @else
                    <div class="mx-auto mb-3"
                         style="width:80px;height:80px;border-radius:50%;
                                background:var(--primary);color:#fff;
                                display:flex;align-items:center;justify-content:center;
                                font-size:28px;font-weight:700">
                        {{ strtoupper(substr($photographer->name, 0, 1)) }}
                    </div>
                @endif

                <h6 class="fw-bold mb-1" style="font-family:'Playfair Display',serif">
                    {{ $photographer->name }}
                </h6>

                <div class="d-flex justify-content-center gap-2 flex-wrap mb-3">
                    <span class="badge bg-light text-dark border">
                        <i class="bi bi-geo-alt me-1"></i>
                        {{ $photographer->photographerProfile->location ?? '—' }}
                    </span>
                    <span class="badge bg-light text-dark border">
                        <i class="bi bi-camera me-1"></i>
                        {{ $photographer->photographerProfile->specialization ?? '—' }}
                    </span>
                </div>

                <div class="d-flex justify-content-center gap-4 mb-2">
                    <div class="text-center">
                        <div class="fw-bold" style="color:var(--primary)">
                            LKR {{ number_format($photographer->photographerProfile->price_per_hour ?? 0) }}
                        </div>
                        <small class="text-muted">per hour</small>
                    </div>
                    <div class="text-center">
                        <div class="fw-bold text-warning">
                            ⭐ {{ number_format($photographer->reviewsReceived()->avg('rating') ?? 0, 1) }}
                        </div>
                        <small class="text-muted">rating</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Selected Package Summary --}}
        @if(isset($selectedPackage))
        <div class="card">
            <div class="card-header">
                <i class="bi bi-box me-2 text-gold"></i> Selected Package
            </div>
            <div class="card-body p-3">
                <h6 class="fw-bold mb-1">{{ $selectedPackage->name }}</h6>
                <p class="text-muted small mb-2">{{ $selectedPackage->description }}</p>
                <ul class="list-unstyled small mb-0">
                    <li class="mb-1">
                        <i class="bi bi-cash text-gold me-2"></i>
                        LKR {{ number_format($selectedPackage->price, 0) }}
                    </li>
                    <li class="mb-1">
                        <i class="bi bi-clock text-gold me-2"></i>
                        {{ $selectedPackage->duration_hours }} hours
                    </li>
                    <li class="mb-1">
                        <i class="bi bi-images text-gold me-2"></i>
                        {{ $selectedPackage->edited_photos }} edited photos
                    </li>
                    @if($selectedPackage->includes_raw)
                    <li class="mb-1">
                        <i class="bi bi-check-circle text-success me-2"></i> RAW files included
                    </li>
                    @endif
                    @if($selectedPackage->includes_album)
                    <li class="mb-1">
                        <i class="bi bi-check-circle text-success me-2"></i> Photo album included
                    </li>
                    @endif
                    @if($selectedPackage->includes_video)
                    <li class="mb-1">
                        <i class="bi bi-check-circle text-success me-2"></i> Video coverage included
                    </li>
                    @endif
                </ul>
            </div>
        </div>
        @endif

        {{-- Info Note --}}
        <div class="alert alert-info mt-3 small">
            <i class="bi bi-info-circle me-1"></i>
            Your request will be sent to the photographer. They will accept or decline within 24 hours.
        </div>
    </div>
</div>

@endsection