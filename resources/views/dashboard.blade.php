@extends('layouts.app')

@section('content')
<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('dashboard') }}">
            <div class="bg-primary text-white rounded p-2 me-2">
                <i class="bi bi-book"></i>
            </div>
            <div>
                <div class="fw-bold">UITS Research Archive</div>
                <small class="text-muted" style="font-size: 0.7rem;">Logged in as {{ auth()->user()->role }}</small>
            </div>
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('archive') ? 'active' : '' }}" href="{{ route('archive') }}">
                        Public Archive
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        My Dashboard
                    </a>
                </li>
                @if(auth()->user()->role === 'admin')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        Admin Panel
                    </a>
                </li>
                @endif
                <li class="nav-item ms-3">
                    <div class="text-end d-none d-md-block me-3">
                        <div class="small fw-semibold">{{ auth()->user()->name }}</div>
                        <div class="small text-muted">{{ auth()->user()->email }}</div>
                    </div>
                </li>
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-box-arrow-right me-1"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container my-5">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">My Dashboard</h2>
            <p class="text-muted">Welcome back, {{ auth()->user()->name }} ({{ auth()->user()->role }})</p>
        </div>
        <a href="{{ route('submissions.create') }}" class="btn btn-primary btn-lg">
            <i class="bi bi-plus-lg me-2"></i>New Submission
        </a>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Stats Cards -->
    <div class="row g-3 mb-5">
        <div class="col-md-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted small mb-1">Total Submissions</h6>
                            <h3 class="mb-0">{{ $stats['total'] }}</h3>
                        </div>
                        <i class="bi bi-file-text text-primary" style="font-size: 2rem; opacity: 0.5;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card-warning">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted small mb-1">Pending Review</h6>
                            <h3 class="mb-0 text-warning">{{ $stats['pending'] }}</h3>
                        </div>
                        <i class="bi bi-clock text-warning" style="font-size: 2rem; opacity: 0.5;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card-success">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted small mb-1">Approved</h6>
                            <h3 class="mb-0 text-success">{{ $stats['approved'] }}</h3>
                        </div>
                        <i class="bi bi-check-circle text-success" style="font-size: 2rem; opacity: 0.5;"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card-danger">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted small mb-1">Rejected</h6>
                            <h3 class="mb-0 text-danger">{{ $stats['rejected'] }}</h3>
                        </div>
                        <i class="bi bi-x-circle text-danger" style="font-size: 2rem; opacity: 0.5;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- My Submissions -->
    <div class="card">
        <div class="card-header bg-white">
            <h5 class="mb-0">My Submissions</h5>
            <small class="text-muted">Track the status of your research submissions</small>
        </div>
        <div class="card-body">
            @if($submissions->count() == 0)
            <div class="text-center py-5">
                <i class="bi bi-file-text text-muted" style="font-size: 4rem;"></i>
                <h5 class="mt-4 text-muted">You haven't submitted any research yet</h5>
                <a href="{{ route('submissions.create') }}" class="btn btn-primary mt-3">
                    <i class="bi bi-plus-lg me-2"></i>Create Your First Submission
                </a>
            </div>
            @else
            <div class="list-group list-group-flush">
                @foreach($submissions as $submission)
                <div class="list-group-item px-0">
                    <div class="row">
                        <div class="col-md-9">
                            <!-- Badges -->
                            <div class="mb-2">
                                <span class="badge badge-{{ strtolower($submission->archive_type) }} me-2">
                                    {{ $submission->archive_type }}
                                </span>
                                <span class="badge badge-{{ strtolower($submission->status) }}">
                                    <i class="bi bi-{{ $submission->status === 'Approved' ? 'check-circle' : ($submission->status === 'Pending' ? 'clock' : 'x-circle') }}"></i>
                                    {{ $submission->status }}
                                </span>
                            </div>

                            <!-- Title -->
                            <h5 class="mb-2">{{ $submission->title }}</h5>
                            <p class="text-muted small mb-2">{{ implode(', ', $submission->authors) }}</p>

                            <!-- Metadata -->
                            <div class="d-flex gap-3 text-muted small mb-2">
                                <span>
                                    <i class="bi bi-calendar3"></i>
                                    Submitted {{ $submission->created_at->format('M d, Y') }}
                                </span>
                                @if($submission->reviewed_at)
                                <span>
                                    <i class="bi bi-person"></i>
                                    Reviewed by {{ $submission->reviewed_by }}
                                </span>
                                @endif
                            </div>

                            <!-- Admin Remarks -->
                            @if($submission->admin_remarks)
                            <div class="alert alert-{{ $submission->status === 'Approved' ? 'success' : 'danger' }} small mt-3">
                                <strong>Admin Feedback:</strong><br>
                                {{ $submission->admin_remarks }}
                            </div>
                            @endif

                            <!-- Domains -->
                            <div class="d-flex flex-wrap gap-1 mt-2">
                                @foreach(array_slice($submission->research_domains ?? [], 0, 4) as $domain)
                                <span class="badge bg-light text-dark small">{{ $domain }}</span>
                                @endforeach
                                @if(count($submission->research_domains ?? []) > 4)
                                <span class="badge bg-light text-dark small">+{{ count($submission->research_domains) - 4 }} more</span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-3 text-end">
                            <a href="{{ route('submissions.show', $submission->id) }}" class="btn btn-outline-primary btn-sm w-100 mb-2">
                                <i class="bi bi-eye me-1"></i>View Details
                            </a>
                            @if($submission->status === 'Pending')
                            <a href="{{ route('submissions.edit', $submission->id) }}" class="btn btn-outline-secondary btn-sm w-100 mb-2">
                                <i class="bi bi-pencil me-1"></i>Edit
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="py-4">
    <div class="container text-center">
        <p class="text-muted mb-1">&copy; 2025 UITS Research Archive System. All rights reserved.</p>
        <p class="text-muted small">University of Information Technology & Sciences - Academic Excellence</p>
    </div>
</footer>
@endsection
