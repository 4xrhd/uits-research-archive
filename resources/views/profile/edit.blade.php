@extends('layouts.app')

@section('content')
<div class="container my-5 pt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex align-items-center mb-4 gap-3">
                <a href="{{ route('dashboard') }}" class="btn btn-light rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <h2 class="fw-bold mb-0">Profile Settings</h2>
            </div>

            <!-- Profile Information Card -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-bottom py-3 px-4">
                    <h5 class="fw-bold mb-0">Profile Information</h5>
                    <p class="text-muted small mb-0">Update your account's profile information and email address.</p>
                </div>
                <div class="card-body p-4 p-md-5">
                    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                        @csrf
                    </form>

                    <form method="post" action="{{ route('profile.update') }}">
                        @csrf
                        @method('patch')

                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-semibold">Name</label>
                                <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label fw-semibold">Email Directory</label>
                                <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required autocomplete="username">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                    <div class="mt-2 text-warning small">
                                        <i class="bi bi-exclamation-triangle me-1"></i> Your email address is unverified.
                                        <button form="send-verification" class="btn btn-link py-0 px-1 m-0 text-decoration-none small d-inline align-baseline">
                                            Click here to re-send the verification email.
                                        </button>
                                    </div>
                                    @if (session('status') === 'verification-link-sent')
                                        <div class="text-success small mt-1">
                                            <i class="bi bi-check-circle me-1"></i> A new verification link has been sent to your email address.
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-3">
                            <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                            @if (session('status') === 'profile-updated')
                                <span class="text-success small fw-semibold"><i class="bi bi-check-circle me-1"></i> Saved.</span>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Update Password Card -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-bottom py-3 px-4">
                    <h5 class="fw-bold mb-0">Update Password</h5>
                    <p class="text-muted small mb-0">Ensure your account is using a long, random password to stay secure.</p>
                </div>
                <div class="card-body p-4 p-md-5">
                    <form method="post" action="{{ route('password.update') }}">
                        @csrf
                        @method('put')

                        <div class="mb-4">
                            <label for="update_password_current_password" class="form-label fw-semibold">Current Password</label>
                            <input id="update_password_current_password" name="current_password" type="password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" autocomplete="current-password">
                            @error('current_password', 'updatePassword')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="update_password_password" class="form-label fw-semibold">New Password</label>
                            <input id="update_password_password" name="password" type="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror" autocomplete="new-password">
                            @error('password', 'updatePassword')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="update_password_password_confirmation" class="form-label fw-semibold">Confirm Password</label>
                            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror" autocomplete="new-password">
                            @error('password_confirmation', 'updatePassword')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex align-items-center gap-3">
                            <button type="submit" class="btn btn-primary px-4">Update Password</button>
                            @if (session('status') === 'password-updated')
                                <span class="text-success small fw-semibold"><i class="bi bi-check-circle me-1"></i> Saved.</span>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Delete Account Card -->
            <div class="card border-0 shadow-sm rounded-4 border-danger border-opacity-25">
                <div class="card-header bg-white border-bottom py-3 px-4 text-danger">
                    <h5 class="fw-bold mb-0"><i class="bi bi-exclamation-triangle-fill me-2"></i> Danger Zone</h5>
                </div>
                <div class="card-body p-4">
                    <p class="text-muted mb-4">Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.</p>
                    
                    <button type="button" class="btn btn-outline-danger px-4" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                        Delete Account
                    </button>
                </div>
            </div>

            <!-- Delete Account Modal -->
            <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form method="post" action="{{ route('profile.destroy') }}" class="modal-content border-0 shadow rounded-4 overflow-hidden">
                        @csrf
                        @method('delete')
                        
                        <div class="modal-header bg-danger text-white border-0 py-3 px-4">
                            <h5 class="modal-title fw-bold" id="deleteAccountModalLabel">Are you sure you want to delete your account?</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        
                        <div class="modal-body p-4">
                            <p class="text-muted mb-4">Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.</p>

                            <div class="mb-3">
                                <label for="password" class="form-label fw-semibold">Password</label>
                                <input id="password" name="password" type="password" class="form-control @error('password', 'userDeletion') is-invalid @enderror" placeholder="Enter your password to confirm">
                                @error('password', 'userDeletion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="modal-footer border-top bg-light p-3">
                            <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger px-4">Permanently Delete Account</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

@push('scripts')
@if($errors->userDeletion->isNotEmpty())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var myModal = new bootstrap.Modal(document.getElementById('deleteAccountModal'));
        myModal.show();
    });
</script>
@endif
@endpush
@endsection
