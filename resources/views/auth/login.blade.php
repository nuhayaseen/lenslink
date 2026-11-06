@extends('layouts.app')
@section('title', 'Login')
@section('content')

<div class="row justify-content-center align-items-center" style="min-height:70vh">
    <div class="col-md-5 col-lg-4">
        <div class="text-center mb-4">
            <h2 style="font-family:'Playfair Display',serif; color:var(--primary)">
                Welcome Back
            </h2>
            <p class="text-muted small">Sign in to your LensLink account</p>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-4">
                <form action="/login" method="POST">
                    @csrf
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
                            <i class="bi bi-lock me-1"></i> Password
                        </label>
                        <input type="password" name="password"
                               class="form-control"
                               placeholder="••••••••" required>
                    </div>

                    <div class="mb-4 form-check">
                        <input type="checkbox" name="remember"
                               class="form-check-input" id="remember">
                        <label class="form-check-label small" for="remember">
                            Remember me
                        </label>
                    </div>

                    <button type="submit" class="btn btn-gold w-100 py-2">
                        <i class="bi bi-box-arrow-in-right me-2"></i> Sign In
                    </button>
                </form>

                <hr class="section-divider">

                <div class="bg-soft rounded-3 p-3 small">
                    <p class="fw-bold mb-2 text-muted">
                        <i class="bi bi-info-circle me-1"></i> Demo Accounts
                    </p>
                    <div class="mb-1">
                        <span class="tag">Admin</span>
                        <span class="ms-2 text-muted">admin@lenslink.com</span>
                    </div>
                    <div class="mb-1">
                        <span class="tag">Photographer</span>
                        <span class="ms-2 text-muted">amara@lenslink.com</span>
                    </div>
                    <div>
                        <span class="tag">Client</span>
                        <span class="ms-2 text-muted">kamal@lenslink.com</span>
                    </div>
                    <p class="text-muted mt-2 mb-0">
                        Password: <strong>password</strong>
                    </p>
                </div>
            </div>
        </div>

        <p class="text-center mt-3 small text-muted">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-gold fw-bold text-decoration-none">
                Register here
            </a>
        </p>
    </div>
</div>
@endsection