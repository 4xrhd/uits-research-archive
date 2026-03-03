@extends('layouts.app')

@section('content')
<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('admin.dashboard') }}">
            <div class="bg-primary text-white rounded p-2 me-2">
                <i class="bi bi-shield-check"></i>
            </div>
            <div>
                <div class="fw-bold">Admin Panel</div>
                <small class="text-muted" style="font-size: 0.7rem;">UITS Research Archive</small>
            </div>
        </a>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard') }}">My Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('archive') }}">Public Archive</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.users') }}">User Management</a>
                </li>
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-secondary btn-sm ms-2">
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
    <div class="mb-4">
        <h2 class="fw-bold mb-1">Admin Dashboard</h2>
        <p class="text-muted">Review and manage research submissions</p>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
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
                            <h2 class="mb-0">{{ $stats['total'] }}</h2>
                        </div>
                        <i class="bi bi-file-text" style="font-size: 2rem; opacity: 0.3;"></i>
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
                            <h2 class="mb-0 text-warning">{{ $stats['pending'] }}</h2>
                        </div>
                        <i class="bi bi-clock text-warning" style="font-size: 2rem; opacity: 0.3;"></i>
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
                            <h2 class="mb-0 text-success">{{ $stats['approved'] }}</h2>
                        </div>
                        <i class="bi bi-check-circle text-success" style="font-size: 2rem; opacity: 0.3;"></i>
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
                            <h2 class="mb-0 text-danger">{{ $stats['rejected'] }}</h2>
                        </div>
                        <i class="bi bi-x-circle text-danger" style="font-size: 2rem; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Submissions Table -->
    <div class="card">
        <div class="card-header bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">Submission Review</h5>
                    <small class="text-muted">Review, approve, or reject research submissions</small>
                </div>
                <a href="{{ route('admin.submissions') }}" class="btn btn-primary btn-sm">
                    View All Submissions
                </a>
            </div>
        </div>
        <div class="card-body">
            <!-- Filter Tabs -->
            <ul class="nav nav-pills mb-4">
                <li class="nav-item">
                    <a class="nav-link {{ request('status', 'pending') == 'pending' ? 'active' : '' }}" 
                       href="{{ route('admin.submissions', ['status' => 'pending']) }}">
                        Pending ({{ $stats['pending'] }})
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') == 'all' ? 'active' : '' }}" 
                       href="{{ route('admin.submissions', ['status' => 'all']) }}">
                        All ({{ $stats['total'] }})
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') == 'Approved' ? 'active' : '' }}" 
                       href="{{ route('admin.submissions', ['status' => 'Approved']) }}">
                        Approved ({{ $stats['approved'] }})
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') == 'Rejected' ? 'active' : '' }}" 
                       href="{{ route('admin.submissions', ['status' => 'Rejected']) }}">
                        Rejected ({{ $stats['rejected'] }})
                    </a>
                </li>
            </ul>

            <!-- Recent Submissions -->
            @if($recentSubmissions->count() == 0)
            <div class="text-center py-5">
                <i class="bi bi-inbox text-muted" style="font-size: 4rem;"></i>
                <h5 class="mt-4 text-muted">No pending submissions</h5>
            </div>
            @else
            <div class="list-group">
                @foreach($recentSubmissions as $submission)
                <div class="list-group-item">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <!-- Badges -->
                            <div class="mb-2">
                                <span class="badge badge-{{ strtolower($submission->archive_type) }} me-2">
                                    {{ $submission->archive_type }}
                                </span>
                                <span class="badge badge-{{ strtolower($submission->status) }}">
                                    {{ $submission->status }}
                                </span>
                            </div>

                            <!-- Title & Info -->
                            <h6 class="mb-2">{{ $submission->title }}</h6>
                            <p class="small text-muted mb-2">
                                By {{ implode(', ', $submission->authors) }} ({{ $submission->user->email }})
                            </p>
                            <p class="small text-muted mb-2">
                                {{ $submission->department }} • Submitted {{ $submission->created_at->format('M d, Y') }}
                            </p>

                            <!-- Domains -->
                            @if(!empty($submission->research_domains))
                            <div class="d-flex flex-wrap gap-1">
                                @foreach(array_slice($submission->research_domains, 0, 4) as $domain)
                                <span class="badge bg-light text-dark small">{{ $domain }}</span>
                                @endforeach
                                @if(count($submission->research_domains) > 4)
                                <span class="badge bg-light text-dark small">+{{ count($submission->research_domains) - 4 }}</span>
                                @endif
                            </div>
                            @endif
                        </div>

                        <div class="col-md-4 text-end">
                            <div class="d-grid gap-2">
                                <button type="button" class="btn btn-outline-primary btn-sm" 
                                        data-bs-toggle="modal" data-bs-target="#viewModal{{ $submission->id }}">
                                    <i class="bi bi-eye me-1"></i>View
                                </button>
                                @if($submission->status === 'Pending')
                                <button type="button" class="btn btn-success btn-sm" 
                                        data-bs-toggle="modal" data-bs-target="#reviewModal{{ $submission->id }}" 
                                        data-action="Approved">
                                    <i class="bi bi-check-circle me-1"></i>Approve
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" 
                                        data-bs-toggle="modal" data-bs-target="#reviewModal{{ $submission->id }}" 
                                        data-action="Rejected">
                                    <i class="bi bi-x-circle me-1"></i>Reject
                                </button>
                                @endif
                                <a href="{{ route('admin.submissions.edit', $submission->id) }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-pencil me-1"></i>Edit
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Review Modal -->
                <div class="modal fade" id="reviewModal{{ $submission->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('admin.submissions.review', $submission->id) }}" method="POST">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title">Review Submission</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <h6 class="mb-2">{{ $submission->title }}</h6>
                                    <p class="small text-muted mb-4">By {{ implode(', ', $submission->authors) }}</p>

                                    <input type="hidden" name="status" id="reviewStatus{{ $submission->id }}">

                                    <div class="mb-3">
                                        <label class="form-label">Remarks (Optional)</label>
                                        <textarea class="form-control" name="remarks" rows="4" 
                                                  placeholder="Add any comments or feedback for the author..."></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn btn-success" onclick="submitReview({{ $submission->id }}, 'Approved')">
                                        Approve Submission
                                    </button>
                                    <button type="button" class="btn btn-danger" onclick="submitReview({{ $submission->id }}, 'Rejected')">
                                        Reject Submission
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    function submitReview(submissionId, action) {
        document.getElementById('reviewStatus' + submissionId).value = action;
        document.querySelector('#reviewModal' + submissionId + ' form').submit();
    }
</script>
@endpush
@endsection
