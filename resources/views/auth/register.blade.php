@extends('layouts.app')
@section('title', 'Register')
@section('content')

<div class="row justify-content-center align-items-center" style="min-height:70vh">
    <div class="col-md-6 col-lg-5">
        <div class="text-center mb-4">
            <h2 style="font-family:'Playfair Display',serif; color:var(--primary)">
                Create Account
            </h2>
            <p class="text-muted small">Join LensLink as a client or photographer</p>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-4">
                <form action="/register" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">
                            <i class="bi bi-person me-1"></i> Full name
                        </label>
                        <input type="text" name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name') }}"
                               placeholder="Your full name" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            <i class="bi bi-envelope me-1"></i> Email address
                        </label>
                        <input type="email" name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email') }}"
                               placeholder="you@example.com" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            <i class="bi bi-phone me-1"></i> Phone number
                        </label>
                        <input type="text" name="phone"
                               class="form-control"
                               value="{{ old('phone') }}"
                               placeholder="+94 71 234 5678">
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">
                                <i class="bi bi-lock me-1"></i> Password
                            </label>
                            <input type="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Min 6 characters" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">
                                <i class="bi bi-lock-fill me-1"></i> Confirm password
                            </label>
                            <input type="password" name="password_confirmation"
                                   class="form-control"
                                   placeholder="Repeat password" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">
                            <i class="bi bi-person-badge me-1"></i> I am a
                        </label>
                        <div class="row g-3">
                            <div class="col-6">
                                <input type="radio" class="btn-check" name="role"
                                       id="roleClient" value="client"
                                       {{ old('role') === 'client' ? 'checked' : '' }} required>
                                <label class="btn btn-outline-primary w-100 py-3" for="roleClient">
                                    <i class="bi bi-person-circle d-block fs-3 mb-1"></i>
                                    <span class="fw-bold">Client</span><br>
                                    <small class="text-muted">I want to hire</small>
                                </label>
                            </div>
                            <div class="col-6">
                                <input type="radio" class="btn-check" name="role"
                                       id="rolePhotographer" value="photographer"
                                       {{ old('role') === 'photographer' ? 'checked' : '' }}>
                                <label class="btn btn-outline-primary w-100 py-3"
                                       for="rolePhotographer">
                                    <i class="bi bi-camera2 d-block fs-3 mb-1"></i>
                                    <span class="fw-bold">Photographer</span><br>
                                    <small class="text-muted">I offer services</small>
                                </label>
                            </div>
                        </div>
                        @error('role')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-gold w-100 py-2">
                        <i class="bi bi-person-plus me-2"></i> Create Account
                    </button>
                </form>
            </div>
        </div>

        <p class="text-center mt-3 small text-muted">
            Already have an account?
            <a href="{{ route('login') }}" class="text-gold fw-bold text-decoration-none">
                Sign in
            </a>
        </p>
    </div>
</div>
@endsection