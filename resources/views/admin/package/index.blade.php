@extends('layouts.app')
@section('title', 'Package Templates')
@section('content')

<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4><i class="bi bi-box me-2 text-gold"></i>Package Templates</h4>
        <p class="text-muted small mb-0">
            Create global package templates for photographers to use
        </p>
    </div>
    <a href="{{ route('admin.packages.create') }}" class="btn btn-gold">
        <i class="bi bi-plus-lg me-2"></i> New Template
    </a>
</div>

@forelse($templates as $template)
<div class="card mb-3 {{ !$template->is_active ? 'opacity-50' : '' }}">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-start">
            <div class="flex-grow-1">
                <div class="d-flex align-items-center gap-3 mb-2">
                    <h5 class="mb-0 fw-bold"
                        style="font-family:'Playfair Display',serif">
                        {{ $template->name }}
                    </h5>
                    <span class="fw-bold text-gold"
                          style="font-size:18px;font-family:'Playfair Display',serif">
                        LKR {{ number_format($template->base_price, 0) }}
                    </span>
                    @if($template->is_active)
                        <span class="badge bg-success rounded-pill">Active</span>
                    @else
                        <span class="badge bg-secondary rounded-pill">Inactive</span>
                    @endif
                    <span class="badge rounded-pill"
                          style="background:#f0ebe0;color:var(--primary)">
                        {{ $template->packages_count }} photographers using
                    </span>
                </div>
                <p class="text-muted small mb-3">{{ $template->description }}</p>
                <div class="d-flex flex-wrap gap-2">
                    <span class="tag">
                        <i class="bi bi-clock me-1"></i>
                        {{ $template->base_duration_hours }} hrs
                    </span>
                    <span class="tag">
                        <i class="bi bi-images me-1"></i>
                        {{ $template->base_edited_photos }} photos
                    </span>
                    @if($template->includes_raw)
                        <span class="tag">
                            <i class="bi bi-check-circle text-gold me-1"></i> RAW files
                        </span>
                    @endif
                    @if($template->includes_album)
                        <span class="tag">
                            <i class="bi bi-check-circle text-gold me-1"></i> Album
                        </span>
                    @endif
                    @if($template->includes_video)
                        <span class="tag">
                            <i class="bi bi-check-circle text-gold me-1"></i> Video
                        </span>
                    @endif
                </div>
            </div>
            <div class="d-flex gap-2 ms-3 flex-shrink-0">
                <a href="{{ route('admin.packages.edit', $template) }}"
                   class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-pencil"></i>
                </a>

                <form action="{{ route('admin.packages.toggle', $template) }}"
                      method="POST">
                    @csrf @method('PATCH')
                    <button class="btn btn-sm
                        {{ $template->is_active
                            ? 'btn-outline-warning'
                            : 'btn-outline-success' }}">
                        <i class="bi bi-{{ $template->is_active ? 'pause' : 'play' }}"></i>
                    </button>
                </form>

                <form action="{{ route('admin.packages.destroy', $template) }}"
                      method="POST"
                      onsubmit="return confirm('Delete this template?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger">
                        <i class="bi bi-trash3"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@empty
<div class="card p-5 text-center">
    <i class="bi bi-box d-block fs-1 text-muted mb-3" style="opacity:0.4"></i>
    <h5>No package templates yet</h5>
    <p class="text-muted small">
        Create templates that photographers can use as a base for their packages.
    </p>
    <a href="{{ route('admin.packages.create') }}"
       class="btn btn-gold mx-auto" style="width:fit-content">
        <i class="bi bi-plus-lg me-2"></i> Create First Template
    </a>
</div>
@endforelse
@endsection