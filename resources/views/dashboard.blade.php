@extends('layouts.app')

@section('content')
<div class="container my-5 pt-4">
    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-3">
        <div>
            <h2 class="fw-bold mb-1">My Dashboard</h2>
            <p class="text-muted">Welcome back, {{ auth()->user()->name }} <span class="badge bg-light text-dark ms-2">{{ auth()->user()->role }}</span></p>
        </div>
        <a href="{{ route('submissions.create') }}" class="btn btn-primary d-inline-flex align-items-center justify-content-center">
            <i class="bi bi-plus-lg me-2"></i> New Submission
        </a>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 rounded-4 shadow-sm mb-4" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Stats Cards -->
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card stat-card border-0 bg-light">
                <div class="card-body p-4">
                    <h6 class="text-muted small fw-bold text-uppercase mb-2">Total</h6>
                    <h3 class="fw-bold mb-0">{{ $stats['total'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card stat-card-warning border-0" style="background-color: #fffbeb;">
                <div class="card-body p-4">
                    <h6 class="text-muted small fw-bold text-uppercase mb-2">Pending</h6>
                    <h3 class="fw-bold mb-0 text-warning">{{ $stats['pending'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card stat-card-success border-0" style="background-color: #f0fdf4;">
                <div class="card-body p-4">
                    <h6 class="text-muted small fw-bold text-uppercase mb-2">Approved</h6>
                    <h3 class="fw-bold mb-0 text-success">{{ $stats['approved'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card stat-card stat-card-danger border-0" style="background-color: #fef2f2;">
                <div class="card-body p-4">
                    <h6 class="text-muted small fw-bold text-uppercase mb-2">Rejected</h6>
                    <h3 class="fw-bold mb-0 text-danger">{{ $stats['rejected'] }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- My Submissions -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white py-4 px-4 border-bottom">
            <h5 class="fw-bold mb-0 text-dark">Recent Submissions</h5>
        </div>
        <div class="card-body p-0">
            @if($submissions->count() == 0)
            <div class="text-center py-5">
                <div class="bg-light d-inline-flex align-items-center justify-content-center rounded-circle p-4 mb-4">
                    <i class="bi bi-file-earmark-plus fs-1 text-muted"></i>
                </div>
                <h5 class="fw-bold">No submissions yet</h5>
                <p class="text-muted">Start sharing your research projects today.</p>
                <a href="{{ route('submissions.create') }}" class="btn btn-outline-primary mt-2">Create Submission</a>
            </div>
            @else
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3 border-0 small text-muted text-uppercase fw-bold">Title & Type</th>
                            <th class="py-3 border-0 small text-muted text-uppercase fw-bold">Status</th>
                            <th class="py-3 border-0 small text-muted text-uppercase fw-bold">Date Joined</th>
                            <th class="px-4 py-3 border-0 text-end"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($submissions as $submission)
                        <tr>
                            <td class="px-4 py-4">
                                <div class="fw-bold text-dark mb-1">{{ $submission->title }}</div>
                                <span class="badge badge-{{ strtolower($submission->archive_type) }} small">{{ $submission->archive_type }}</span>
                            </td>
                            <td>
                                <span class="badge badge-{{ strtolower($submission->status) }}">
                                    {{ $submission->status }}
                                </span>
                            </td>
                            <td class="text-muted small">
                                {{ $submission->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-4 text-end">
                                <div class="dropdown">
                                    <button class="btn btn-light btn-sm rounded-circle p-2" type="button" data-bs-toggle="dropdown">
                                        <i class="bi bi-three-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end border shadow-sm rounded-3">
                                        <li><a class="dropdown-item" href="{{ route('submissions.show', $submission->id) }}">View Details</a></li>
                                        @if($submission->status === 'Pending')
                                        <li><a class="dropdown-item" href="{{ route('submissions.edit', $submission->id) }}">Edit Submission</a></li>
                                        @endif
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
