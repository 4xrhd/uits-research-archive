@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 6rem; margin-bottom: 5rem;">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-5">
                        <div class="bg-primary text-white d-inline-flex align-items-center justify-content-center rounded-4 p-3 mb-4" style="background-color: var(--accent-color) !important;">
                            <i class="bi bi-shield-lock-fill fs-2"></i>
                        </div>
                        <h3 class="fw-bold">Confirm Password</h3>
                        <p class="text-muted">This is a secure area of the application. Please confirm your password before continuing.</p>
                    </div>

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <!-- Password -->
                        <div class="mb-5">
                            <label for="password" class="form-label fw-semibold">Password</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="••••••••">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid mb-2">
                            <button type="submit" class="btn btn-primary btn-lg rounded-3 fw-bold">
                                Confirm Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
