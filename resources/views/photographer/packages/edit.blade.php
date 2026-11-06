@extends('layouts.app')
@section('title', 'Edit Package')
@section('content')

<div class="page-header">
    <h4><i class="bi bi-pencil me-2 text-gold"></i>Edit Package</h4>
    <p class="text-muted small mb-0">Update your service package details</p>
</div>

<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card">
            <div class="card-body p-4">
                <form action="{{ route('photographer.packages.update', $package) }}"
                      method="POST">
                    @csrf @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">
                            <i class="bi bi-tag me-1"></i> Package name
                        </label>
                        <input type="text" name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $package->name) }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            <i class="bi bi-chat-text me-1"></i> Description
                        </label>
                        <textarea name="description" rows="3"
                                  class="form-control @error('description') is-invalid @enderror">{{ old('description', $package->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label">
                                <i class="bi bi-cash me-1"></i> Price (LKR)
                            </label>
                            <input type="number" name="price"
                                   class="form-control @error('price') is-invalid @enderror"
                                   min="0" step="100"
                                   value="{{ old('price', $package->price) }}">
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">
                                <i class="bi bi-clock me-1"></i> Duration (hrs)
                            </label>
                            <input type="number" name="duration_hours"
                                   class="form-control @error('duration_hours') is-invalid @enderror"
                                   min="1"
                                   value="{{ old('duration_hours', $package->duration_hours) }}">
                            @error('duration_hours')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">
                                <i class="bi bi-images me-1"></i> Edited photos
                            </label>
                            <input type="number" name="edited_photos"
                                   class="form-control @error('edited_photos') is-invalid @enderror"
                                   min="0"
                                   value="{{ old('edited_photos', $package->edited_photos) }}">
                            @error('edited_photos')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4 p-3 bg-soft rounded-3">
                        <label class="form-label mb-3">
                            <i class="bi bi-plus-circle me-1"></i> Add-ons included
                        </label>
                        <div class="d-flex gap-4 flex-wrap">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox"
                                       name="includes_raw" id="raw" value="1"
                                       {{ old('includes_raw', $package->includes_raw) ? 'checked' : '' }}>
                                <label class="form-check-label" for="raw">
                                    <i class="bi bi-file-earmark-image me-1 text-gold"></i>
                                    RAW files
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox"
                                       name="includes_album" id="album" value="1"
                                       {{ old('includes_album', $package->includes_album) ? 'checked' : '' }}>
                                <label class="form-check-label" for="album">
                                    <i class="bi bi-book me-1 text-gold"></i>
                                    Photo album
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox"
                                       name="includes_video" id="video" value="1"
                                       {{ old('includes_video', $package->includes_video) ? 'checked' : '' }}>
                                <label class="form-check-label" for="video">
                                    <i class="bi bi-camera-video me-1 text-gold"></i>
                                    Video coverage
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-gold px-4">
                            <i class="bi bi-check2 me-2"></i> Update Package
                        </button>
                        <a href="{{ route('photographer.packages.index') }}"
                           class="btn btn-outline-secondary px-4">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection