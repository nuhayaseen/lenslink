@extends('layouts.app')
@section('title', 'Edit Package Template')
@section('content')

<div class="page-header">
    <h4><i class="bi bi-pencil me-2 text-gold"></i>Edit Package Template</h4>
    <p class="text-muted small mb-0">Update this template — changes won't affect existing photographer packages</p>
</div>

<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card">
            <div class="card-body p-4">
                <form action="{{ route('admin.packages.update', $template) }}"
                      method="POST">
                    @csrf @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">
                            <i class="bi bi-tag me-1"></i> Template name
                        </label>
                        <input type="text" name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $template->name) }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            <i class="bi bi-chat-text me-1"></i> Description
                        </label>
                        <textarea name="description" rows="3"
                                  class="form-control">{{ old('description', $template->description) }}</textarea>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label class="form-label">
                                <i class="bi bi-cash me-1"></i> Base price (LKR)
                            </label>
                            <input type="number" name="base_price"
                                   class="form-control @error('base_price') is-invalid @enderror"
                                   min="0" step="100"
                                   value="{{ old('base_price', $template->base_price) }}">
                            @error('base_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">
                                <i class="bi bi-clock me-1"></i> Base duration (hrs)
                            </label>
                            <input type="number" name="base_duration_hours"
                                   class="form-control @error('base_duration_hours') is-invalid @enderror"
                                   min="1"
                                   value="{{ old('base_duration_hours', $template->base_duration_hours) }}">
                            @error('base_duration_hours')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">
                                <i class="bi bi-images me-1"></i> Base edited photos
                            </label>
                            <input type="number" name="base_edited_photos"
                                   class="form-control @error('base_edited_photos') is-invalid @enderror"
                                   min="0"
                                   value="{{ old('base_edited_photos', $template->base_edited_photos) }}">
                            @error('base_edited_photos')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4 p-3 bg-soft rounded-3">
                        <label class="form-label mb-3">
                            <i class="bi bi-plus-circle me-1"></i> Default add-ons
                        </label>
                        <div class="d-flex gap-4 flex-wrap">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox"
                                       name="includes_raw" id="raw" value="1"
                                       {{ old('includes_raw', $template->includes_raw) ? 'checked' : '' }}>
                                <label class="form-check-label" for="raw">
                                    <i class="bi bi-file-earmark-image me-1 text-gold"></i>
                                    RAW files
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox"
                                       name="includes_album" id="album" value="1"
                                       {{ old('includes_album', $template->includes_album) ? 'checked' : '' }}>
                                <label class="form-check-label" for="album">
                                    <i class="bi bi-book me-1 text-gold"></i>
                                    Photo album
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox"
                                       name="includes_video" id="video" value="1"
                                       {{ old('includes_video', $template->includes_video) ? 'checked' : '' }}>
                                <label class="form-check-label" for="video">
                                    <i class="bi bi-camera-video me-1 text-gold"></i>
                                    Video coverage
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-gold px-4">
                            <i class="bi bi-check2 me-2"></i> Update Template
                        </button>
                        <a href="{{ route('admin.packages.index') }}"
                           class="btn btn-outline-secondary px-4">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection