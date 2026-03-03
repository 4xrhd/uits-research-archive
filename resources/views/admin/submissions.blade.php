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
                <small class="text-muted" style="font-size: 0.7rem;">All Submissions</small>
            </div>
        </a>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('archive') }}">Public Archive</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">All Submissions</h2>
            <p class="text-muted">Review and manage research submissions</p>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Filter Tabs -->
    <ul class="nav nav-pills mb-4">
        <li class="nav-item">
            <a class="nav-link {{ !request()->has('status') || request('status') == 'pending' ? 'active' : '' }}" 
               href="{{ route('admin.submissions', ['status' => 'pending']) }}">
                <i class="bi bi-clock me-1"></i>Pending
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request('status') == 'all' ? 'active' : '' }}" 
               href="{{ route('admin.submissions', ['status' => 'all']) }}">
                <i class="bi bi-list me-1"></i>All
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request('status') == 'Approved' ? 'active' : '' }}" 
               href="{{ route('admin.submissions', ['status' => 'Approved']) }}">
                <i class="bi bi-check-circle me-1"></i>Approved
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request('status') == 'Rejected' ? 'active' : '' }}" 
               href="{{ route('admin.submissions', ['status' => 'Rejected']) }}">
                <i class="bi bi-x-circle me-1"></i>Rejected
            </a>
        </li>
    </ul>

    <!-- Submissions List -->
    @if($submissions->count() == 0)
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="bi bi-inbox text-muted" style="font-size: 4rem;"></i>
            <h5 class="mt-4 text-muted">No submissions found</h5>
        </div>
    </div>
    @else
    <div class="row g-4">
        @foreach($submissions as $submission)
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <!-- Badges -->
                            <div class="mb-3">
                                <span class="badge badge-{{ strtolower($submission->archive_type) }} me-2">
                                    {{ $submission->archive_type }}
                                </span>
                                <span class="badge badge-{{ strtolower($submission->status) }}">
                                    <i class="bi bi-{{ $submission->status === 'Approved' ? 'check-circle' : ($submission->status === 'Pending' ? 'clock' : 'x-circle') }} me-1"></i>
                                    {{ $submission->status }}
                                </span>
                            </div>

                            <!-- Title -->
                            <h5 class="mb-2">{{ $submission->title }}</h5>
                            
                            <!-- Author Info -->
                            <p class="small text-muted mb-2">
                                <i class="bi bi-person me-1"></i>
                                By {{ implode(', ', $submission->authors) }}
                            </p>
                            <p class="small text-muted mb-2">
                                <i class="bi bi-envelope me-1"></i>
                                {{ $submission->user->email }} ({{ $submission->user->name }})
                            </p>
                            <p class="small text-muted mb-3">
                                <i class="bi bi-building me-1"></i>
                                {{ $submission->department }} • 
                                <i class="bi bi-calendar3 ms-2 me-1"></i>
                                Submitted {{ $submission->created_at->format('M d, Y') }}
                            </p>

                            <!-- Review Info -->
                            @if($submission->reviewed_at)
                            <p class="small text-muted mb-2">
                                <i class="bi bi-check2-square me-1"></i>
                                Reviewed by {{ $submission->reviewed_by }} on {{ $submission->reviewed_at->format('M d, Y') }}
                            </p>
                            @endif

                            <!-- Admin Remarks -->
                            @if($submission->admin_remarks)
                            <div class="alert alert-{{ $submission->status === 'Approved' ? 'success' : 'warning' }} small mb-3">
                                <strong>Admin Remarks:</strong><br>
                                {{ $submission->admin_remarks }}
                            </div>
                            @endif

                            <!-- Domains -->
                            @if(!empty($submission->research_domains))
                            <div class="d-flex flex-wrap gap-1">
                                @foreach(array_slice($submission->research_domains, 0, 5) as $domain)
                                <span class="badge bg-light text-dark small">{{ $domain }}</span>
                                @endforeach
                                @if(count($submission->research_domains) > 5)
                                <span class="badge bg-light text-dark small">+{{ count($submission->research_domains) - 5 }}</span>
                                @endif
                            </div>
                            @endif
                        </div>

                        <div class="col-md-4">
                            <div class="d-grid gap-2">
                                <button type="button" class="btn btn-outline-primary btn-sm" 
                                        data-bs-toggle="modal" data-bs-target="#viewModal{{ $submission->id }}">
                                    <i class="bi bi-eye me-1"></i>View Details
                                </button>
                                
                                @if($submission->status === 'Pending')
                                <form action="{{ route('admin.submissions.review', $submission->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="status" value="Approved">
                                    <button type="submit" class="btn btn-success btn-sm w-100">
                                        <i class="bi bi-check-circle me-1"></i>Approve
                                    </button>
                                </form>
                                <form action="{{ route('admin.submissions.review', $submission->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="status" value="Rejected">
                                    <button type="submit" class="btn btn-danger btn-sm w-100">
                                        <i class="bi bi-x-circle me-1"></i>Reject
                                    </button>
                                </form>
                                @endif

                                <a href="{{ route('admin.submissions.edit', $submission->id) }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-pencil me-1"></i>Edit All Fields
                                </a>

                                <form action="{{ route('submissions.destroy', $submission->id) }}" method="POST" 
                                      onsubmit="return confirm('Are you sure you want to delete this submission?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                        <i class="bi bi-trash me-1"></i>Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- View Modal -->
        <div class="modal fade" id="viewModal{{ $submission->id }}" tabindex="-1">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <div>
                            <h5 class="modal-title">{{ $submission->title }}</h5>
                            <div class="mt-2">
                                <span class="badge badge-{{ strtolower($submission->archive_type) }}">{{ $submission->archive_type }}</span>
                                <span class="badge badge-{{ strtolower($submission->status) }} ms-1">{{ $submission->status }}</span>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Full Details -->
                        <div class="mb-3">
                            <h6 class="fw-semibold">Authors</h6>
                            <p>{{ implode(', ', $submission->authors) }}</p>
                        </div>

                        <div class="mb-3">
                            <h6 class="fw-semibold">Submitted By</h6>
                            <p>{{ $submission->user->name }} ({{ $submission->user->email }})</p>
                        </div>

                        @if($submission->abstract)
                        <div class="mb-3">
                            <h6 class="fw-semibold">Abstract</h6>
                            <p style="white-space: pre-wrap;">{{ $submission->abstract }}</p>
                        </div>
                        @endif

                        @if($submission->pdf_url)
                        <div class="mb-3">
                            <h6 class="fw-semibold">PDF Link</h6>
                            <a href="{{ $submission->pdf_url }}" target="_blank" class="btn btn-primary w-100">
                                <i class="bi bi-file-pdf me-2"></i>View PDF
                            </a>
                        </div>
                        @endif

                        @if(!empty($submission->drive_links))
                        <div class="mb-3">
                            <h6 class="fw-semibold">Drive Links</h6>
                            @foreach($submission->drive_links as $link)
                            @if($link)
                            <a href="{{ $link }}" target="_blank" class="btn btn-outline-primary w-100 mb-2">
                                <i class="bi bi-cloud me-2"></i>Drive Link
                            </a>
                            @endif
                            @endforeach
                        </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <a href="{{ route('admin.submissions.edit', $submission->id) }}" class="btn btn-primary">
                            Edit Submission
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $submissions->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection
