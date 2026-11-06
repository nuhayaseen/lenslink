@extends('layouts.app')
@section('title', 'Edit Profile')
@section('content')

<div class="page-header">
    <h4><i class="bi bi-person-circle me-2 text-gold"></i>Edit Profile</h4>
    <p class="text-muted small mb-0">Update your photographer profile information</p>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body p-4">
                <form action="{{ route('photographer.profile.update') }}"
                      method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')

                    {{-- Profile Photo --}}
                    <div class="text-center mb-4 pb-4 border-bottom">
    @if(auth()->user()->profile_photo)
        @php
            $photoPath = auth()->user()->profile_photo;
            $photoUrl  = asset('storage/' . $photoPath);
        @endphp
        <img src="{{ $photoUrl }}"
             class="rounded-circle mb-3"
             width="100" height="100"
             style="object-fit:cover;border:4px solid #f0ebe0"
             onerror="this.style.display='none';document.getElementById('avatarFallback').style.display='flex'">
        <div id="avatarFallback"
             class="avatar-lg mx-auto mb-3"
             style="display:none">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>
    @else
        <div class="avatar-lg mx-auto mb-3">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>
    @endif
    <div style="max-width:320px;margin:0 auto">
        <label class="form-label">
            <i class="bi bi-camera me-1"></i> Profile Photo
        </label>
        <input type="file" name="profile_photo"
               class="form-control" accept="image/*">
        <small class="text-muted">Max 2MB · JPEG, PNG, WEBP</small>
    </div>
</div>


                    <div class="mb-3">
                        <label class="form-label">
                            <i class="bi bi-file-text me-1"></i> Bio
                        </label>
                        <textarea name="bio" class="form-control" rows="3"
                                  placeholder="Tell clients about yourself, your style and experience...">{{ old('bio', $profile->bio) }}</textarea>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">
                                <i class="bi bi-geo-alt me-1"></i> Location
                            </label>
                            <input type="text" name="location" class="form-control"
                                   value="{{ old('location', $profile->location) }}"
                                   placeholder="e.g. Kandy, Sri Lanka">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">
                                <i class="bi bi-camera me-1"></i> Specialization
                            </label>
                            <input type="text" name="specialization" class="form-control"
                                   value="{{ old('specialization', $profile->specialization) }}"
                                   placeholder="e.g. Wedding, Portrait, Fashion">
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">
                                <i class="bi bi-cash me-1"></i> Price per hour (LKR)
                            </label>
                            <input type="number" name="price_per_hour" class="form-control"
                                   min="0" step="100"
                                   value="{{ old('price_per_hour', $profile->price_per_hour) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">
                                <i class="bi bi-award me-1"></i> Years of experience
                            </label>
                            <input type="number" name="years_of_experience" class="form-control"
                                   min="0"
                                   value="{{ old('years_of_experience', $profile->years_of_experience) }}">
                        </div>
                    </div>

                    <div class="mb-4 p-3 bg-soft rounded-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox"
                                   name="is_available" id="is_available"
                                   style="width:44px;height:22px"
                                   {{ $profile->is_available ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold ms-2" for="is_available">
                                <i class="bi bi-circle-fill me-1 text-success" style="font-size:10px"></i>
                                Available for bookings
                            </label>
                        </div>
                        <small class="text-muted ms-5">
                            Toggle off when you are fully booked or on vacation
                        </small>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-gold px-4">
                            <i class="bi bi-check2 me-2"></i> Save Changes
                        </button>
                        <a href="{{ route('photographer.dashboard') }}"
                           class="btn btn-outline-secondary px-4">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection