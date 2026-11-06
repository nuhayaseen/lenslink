@extends('layouts.app')
@section('title', $photographer->name)
@section('content')

<div class="row g-4">
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-body p-4 text-center">
                @if($photographer->profile_photo)
                    <img src="{{ asset('storage/' . $photographer->profile_photo) }}"
                         class="rounded-circle mb-3"
                         width="120" height="120"
                         style="object-fit:cover;border:4px solid #f0ebe0"
                         onerror="this.onerror=null;this.style.display='none'">
                @else
                    <div class="avatar-lg mx-auto mb-3">
                        {{ strtoupper(substr($photographer->name, 0, 1)) }}
                    </div>
                @endif

                <h4 style="font-family:'Playfair Display',serif">{{ $photographer->name }}</h4>

                <div class="d-flex justify-content-center gap-2 flex-wrap mb-3">
                    <span class="tag"><i class="bi bi-geo-alt me-1"></i>{{ $photographer->photographerProfile->location ?? '—' }}</span>
                    <span class="tag"><i class="bi bi-camera me-1"></i>{{ $photographer->photographerProfile->specialization ?? '—' }}</span>
                    <span class="tag"><i class="bi bi-award me-1"></i>{{ $photographer->photographerProfile->years_of_experience ?? 0 }} yrs</span>
                </div>

                <div class="d-flex justify-content-center gap-4 mb-3">
                    <div class="text-center">
                        <div class="fw-bold fs-5" style="font-family:'Playfair Display',serif;color:var(--primary)">
                            LKR {{ number_format($photographer->photographerProfile->price_per_hour ?? 0) }}
                        </div>
                        <small class="text-muted">per hour</small>
                    </div>
                    <div class="text-center">
                        <div class="fw-bold fs-5 text-gold">
                            ⭐ {{ number_format($avgRating, 1) }}
                        </div>
                        <small class="text-muted">rating</small>
                    </div>
                </div>

                @if($photographer->photographerProfile->is_available)
                    <span class="badge bg-success rounded-pill mb-3">
                        <i class="bi bi-circle-fill me-1" style="font-size:8px"></i> Available
                    </span>
                @else
                    <span class="badge bg-secondary rounded-pill mb-3">Unavailable</span>
                @endif

                <p class="text-muted small">{{ $photographer->photographerProfile->bio }}</p>


            </div>
        </div>
    </div>

    <div class="col-md-8">

        {{-- Portfolio --}}
        @if($photographer->photographerProfile->portfolio)
        <div class="card mb-4">
            <div class="card-header">
                <i class="bi bi-images me-2 text-gold"></i>
                {{ $photographer->photographerProfile->portfolio->title }}
            </div>
            <div class="card-body p-4">
                <p class="text-muted small mb-3">
                    {{ $photographer->photographerProfile->portfolio->description }}
                </p>
                <div class="row g-2">
                    @forelse($photographer->photographerProfile->portfolio->images as $image)
                    <div class="col-4">
                        <img src="{{ asset('storage/' . $image->image_path) }}"
                             class="img-fluid rounded-3"
                             style="height:130px;width:100%;object-fit:cover;transition:transform 0.2s"
                             onmouseover="this.style.transform='scale(1.03)'"
                             onmouseout="this.style.transform='scale(1)'"
                             alt="{{ $image->caption }}">
                    </div>
                    @empty
                    <p class="text-muted small">No portfolio images uploaded yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
        @endif

        {{-- Packages --}}
        @if(isset($photographer->photographerProfile->activePackages) && $photographer->photographerProfile->activePackages->count())
        <div class="mb-4">
            <h5 style="font-family:'Playfair Display',serif" class="mb-3">
                <i class="bi bi-box me-2 text-gold"></i> Packages
            </h5>
            <div class="row g-3">
                @foreach($photographer->photographerProfile->activePackages as $package)
                <div class="col-md-4">
                    <div class="card package-card h-100">
                        <div class="package-header">{{ $package->name }}</div>
                        <div class="card-body text-center p-3">
                            <div class="package-price mb-2">
                                LKR {{ number_format($package->price, 0) }}
                            </div>
                            <p class="text-muted small mb-3">{{ $package->description }}</p>
                            <ul class="list-unstyled text-start small">
                                <li class="mb-1">
                                    <i class="bi bi-clock text-gold me-2"></i>
                                    {{ $package->duration_hours }} hours
                                </li>
                                <li class="mb-1">
                                    <i class="bi bi-images text-gold me-2"></i>
                                    {{ $package->edited_photos }} edited photos
                                </li>
                                @if($package->includes_raw)
                                <li class="mb-1">
                                    <i class="bi bi-check-circle text-gold me-2"></i> RAW files
                                </li>
                                @endif
                                @if($package->includes_album)
                                <li class="mb-1">
                                    <i class="bi bi-check-circle text-gold me-2"></i> Photo album
                                </li>
                                @endif
                                @if($package->includes_video)
                                <li class="mb-1">
                                    <i class="bi bi-check-circle text-gold me-2"></i> Video coverage
                                </li>
                                @endif
                            </ul>
                        </div>
                        @auth
                            @if(auth()->user()->isClient())
                            <div class="card-footer bg-white border-0 p-3 pt-0">
                                <a href="{{ route('client.bookings.create', [
                                            'photographer_id' => $photographer->id,
                                            'package_id'      => $package->id]) }}"
                                   class="btn btn-gold btn-sm w-100">
                                    Book This Package
                                </a>
                            </div>
                            @endif
                        @endauth
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Reviews --}}
        <div class="card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <span><i class="bi bi-star me-2 text-gold"></i> Reviews</span>
                <span class="badge bg-secondary">{{ $photographer->reviewsReceived->count() }}</span>
            </div>
            <div class="card-body p-4">
                @forelse($photographer->reviewsReceived as $review)
                <div class="d-flex gap-3 mb-4 pb-4 {{ !$loop->last ? 'border-bottom' : '' }}">
                    <div class="avatar-sm flex-shrink-0"
                         style="width:40px;height:40px;font-size:15px;
                                background:var(--primary);color:#fff;border-radius:50%;
                                display:flex;align-items:center;justify-content:center;font-weight:600">
                        {{ strtoupper(substr($review->client->name, 0, 1)) }}
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                            <strong>{{ $review->client->name }}</strong>
                            <span class="text-warning">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)
                                        ★
                                    @else
                                        <span class="text-muted">★</span>
                                    @endif
                                @endfor
                            </span>
                            <small class="text-muted ms-auto">{{ $review->created_at->diffForHumans() }}</small>
                        </div>
                        <p class="text-muted small mb-0">{{ $review->comment }}</p>
                    </div>
                </div>
                @empty
                <div class="text-center py-4">
                    <i class="bi bi-chat-square-text fs-2 text-muted opacity-50 d-block mb-2"></i>
                    <p class="text-muted small mb-0">No reviews yet for this photographer.</p>
                </div>
                @endforelse
            </div>
        </div>

    </div>
</div>

@endsection