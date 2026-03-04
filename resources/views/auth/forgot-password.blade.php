@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 8rem; margin-bottom: 5rem;">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-5">
                        <div class="bg-primary text-white d-inline-flex align-items-center justify-content-center rounded-4 p-3 mb-4" style="background-color: var(--accent-color) !important;">
                            <i class="bi bi-key fs-2"></i>
                        </div>
                        <h3 class="fw-bold">Forgot Password</h3>
                        <p class="text-muted">No problem. Just let us know your email address and we will email you a password reset link.</p>
                    </div>

                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="alert alert-success mb-4" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <!-- Email Address -->
                        <div class="mb-5">
                            <label for="email" class="form-label fw-semibold">Email Address</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus placeholder="name@uits.edu.bd">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid mb-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                Email Password Reset Link
                            </button>
                        </div>
                        
                        <div class="text-center small">
                            <a href="{{ route('login') }}" class="text-muted text-decoration-none fw-bold"><i class="bi bi-arrow-left me-1"></i> Back to sign in</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
