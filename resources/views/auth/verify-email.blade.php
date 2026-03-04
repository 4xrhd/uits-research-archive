@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 6rem; margin-bottom: 5rem;">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-5">
                        <div class="bg-primary text-white d-inline-flex align-items-center justify-content-center rounded-4 p-3 mb-4" style="background-color: var(--accent-color) !important;">
                            <i class="bi bi-envelope-check fs-2"></i>
                        </div>
                        <h3 class="fw-bold">Verify Email</h3>
                        <p class="text-muted">Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn't receive the email, we will gladly send you another.</p>
                    </div>

                    @if (session('status') == 'verification-link-sent')
                        <div class="alert alert-success mb-4" role="alert">
                            <i class="bi bi-check-circle me-1"></i> A new verification link has been sent to the email address you provided during registration.
                        </div>
                    @endif

                    <div class="d-flex flex-column flex-md-row gap-3 justify-content-center align-items-center mt-4">
                        <form method="POST" action="{{ route('verification.send') }}" class="w-100">
                            @csrf
                            <button type="submit" class="btn btn-primary w-100 py-3 fw-bold rounded-3">
                                Resend Verification Email
                            </button>
                        </form>

                        <form method="POST" action="{{ route('logout') }}" class="w-100">
                            @csrf
                            <button type="submit" class="btn btn-light border w-100 py-3 fw-bold rounded-3">
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
