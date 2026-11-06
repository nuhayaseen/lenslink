@extends('layouts.app')
@section('title', 'My Portfolio')
@section('content')

<div class="page-header">
    <h4><i class="bi bi-images me-2 text-gold"></i>My Portfolio</h4>
    <p class="text-muted small mb-0">Showcase your best work to attract clients</p>
</div>

@if(!$portfolio)
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-plus-circle me-2 text-gold"></i>Create Your Portfolio
            </div>
            <div class="card-body p-4">
                <p class="text-muted small mb-4">
                    You do not have a portfolio yet. Create one to showcase your work.
                </p>
                <form action="{{ route('photographer.portfolio.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="bi bi-type me-1"></i> Portfolio title
                        </label>
                        <input type="text" name="title"
                               class="form-control @error('title') is-invalid @enderror"
                               value="{{ old('title') }}"
                               placeholder="e.g. My Wedding Photography">
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label class="form-label">
                            <i class="bi bi-chat-text me-1"></i> Description
                        </label>
                        <textarea name="description" class="form-control" rows="3"
                                  placeholder="Brief description of your photography style...">{{ old('description') }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-gold w-100">
                        <i class="bi bi-plus-lg me-2"></i> Create Portfolio
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@else

<div class="row g-4">
    <div class="col-md-4">

        {{-- Portfolio Info --}}
        <div class="card mb-4">
            <div class="card-header">
                <i class="bi bi-info-circle me-2 text-gold"></i>Portfolio Info
            </div>
            <div class="card-body p-4">
                <form action="{{ route('photographer.portfolio.update') }}" method="POST">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control"
                               value="{{ $portfolio->title }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control"
                                  rows="3">{{ $portfolio->description }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-outline-primary w-100">
                        <i class="bi bi-check2 me-1"></i> Update Info
                    </button>
                </form>
            </div>
        </div>

        {{-- Upload Images --}}
        <div class="card">
            <div class="card-header">
                <i class="bi bi-cloud-upload me-2 text-gold"></i>Upload Images
            </div>
            <div class="card-body p-4">
                <form action="{{ route('photographer.portfolio.images.upload') }}"
                      method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <div class="border rounded-3 p-4 text-center bg-soft"
                             style="border:2px dashed #c9a84c !important;cursor:pointer"
                             onclick="document.getElementById('imageInput').click()">
                            <i class="bi bi-cloud-upload d-block fs-2 text-gold mb-2"></i>
                            <div class="fw-bold small">Click to select images</div>
                            <div class="text-muted" style="font-size:11px">
                                JPEG, PNG, WEBP · Max 2MB each · Up to 10
                            </div>
                        </div>
                        <input type="file" id="imageInput" name="images[]"
                               class="d-none" multiple accept="image/*"
                               onchange="updateFileCount(this)">
                        <div id="fileCount" class="text-muted small mt-2 text-center"></div>
                    </div>
                    <button type="submit" class="btn btn-gold w-100">
                        <i class="bi bi-upload me-2"></i> Upload Images
                    </button>
                </form>
            </div>
        </div>

    </div>

    {{-- Image Gallery --}}
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-grid me-2 text-gold"></i>Portfolio Images</span>
                <span class="tag">{{ $portfolio->images->count() }} photos</span>
            </div>
            <div class="card-body p-4">
                @if($portfolio->images->count())
                <div class="row g-3">
                    @foreach($portfolio->images as $image)
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm overflow-hidden"
                             style="border-radius:12px">
                            <div style="overflow:hidden;height:160px;background:#f7f4ef">
                                <img src="{{ asset('storage/' . $image->image_path) }}"
                                     style="height:160px;width:100%;object-fit:cover;transition:transform 0.3s"
                                     onmouseover="this.style.transform='scale(1.05)'"
                                     onmouseout="this.style.transform='scale(1)'"
                                     alt="portfolio image">
                            </div>
                            <div class="p-2 d-flex justify-content-between align-items-center">
                                <small class="text-muted text-truncate" style="max-width:100px">
                                    {{ $image->caption ?? 'No caption' }}
                                </small>
                                <form action="{{ route('photographer.portfolio.images.delete', $image) }}"
                                      method="POST"
                                      onsubmit="return confirm('Delete this image?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger" style="padding:2px 8px">
                                        <i class="bi bi-trash3"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-images d-block fs-1 mb-3 text-gold" style="opacity:0.4"></i>
                    <h6>No images yet</h6>
                    <p class="small">Upload your best work to attract clients.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endif

@endsection

@section('scripts')
<script>
function updateFileCount(input) {
    const count = input.files.length;
    document.getElementById('fileCount').textContent =
        count > 0 ? count + ' file(s) selected' : '';
}
</script>
@endsection