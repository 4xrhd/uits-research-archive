@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 6rem; margin-bottom: 5rem;">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-5">
                        <div class="bg-primary text-white d-inline-flex align-items-center justify-content-center rounded-4 p-3 mb-4" style="background-color: var(--accent-color) !important;">
                            <i class="bi bi-shield-check fs-2"></i>
                        </div>
                        <h3 class="fw-bold">Reset Password</h3>
                        <p class="text-muted">Choose a new password for your account.</p>
                    </div>

                    <form method="POST" action="{{ route('password.store') }}">
                        @csrf

                        <!-- Password Reset Token -->
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <!-- Email Address -->
                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold">Email Address</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $request->email) }}" required autofocus placeholder="name@uits.edu.bd">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <label for="password" class="form-label fw-semibold">New Password</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required placeholder="Min. 8 characters">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-5">
                            <label for="password_confirmation" class="form-label fw-semibold">Confirm Password</label>
                            <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required placeholder="Repeat new password">
                        </div>

                        <div class="d-grid mb-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                Reset Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
