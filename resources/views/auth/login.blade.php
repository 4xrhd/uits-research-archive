@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 8rem; margin-bottom: 5rem;">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-5">
                        <div class="bg-primary text-white d-inline-flex align-items-center justify-content-center rounded-4 p-3 mb-4" style="background-color: var(--accent-color) !important;">
                            <i class="bi bi-shield-lock fs-2"></i>
                        </div>
                        <h3 class="fw-bold">Sign In</h3>
                        <p class="text-muted">Access the UITS Research Archive</p>
                    </div>

                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="alert alert-success mb-4" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email Address -->
                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold">Email Address</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus placeholder="name@uits.edu.bd">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label for="password" class="form-label fw-semibold mb-0">Password</label>
                                @if (Route::has('password.request'))
                                    <a class="text-decoration-none small" href="{{ route('password.request') }}">
                                        Forgot?
                                    </a>
                                @endif
                            </div>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required placeholder="••••••••">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Remember Me -->
                        <div class="mb-5 form-check small">
                            <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                            <label class="form-check-label text-muted" for="remember_me">
                                Stay signed in
                            </label>
                        </div>

                        <div class="d-grid mb-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                Sign In
                            </button>
                        </div>
                        
                        <div class="text-center small">
                            <p class="text-muted">Need an account? <a href="{{ route('register') }}" class="text-primary text-decoration-none fw-bold">Sign up</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
