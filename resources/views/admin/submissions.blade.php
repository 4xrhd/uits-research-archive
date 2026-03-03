@extends('layouts.app')

@section('content')
<div class="container my-5 pt-4">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-3">
        <div>
            <h2 class="fw-bold mb-1">Research Submissions</h2>
            <p class="text-muted">Review and manage the database of academic works</p>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 rounded-4 shadow-sm mb-4" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Filter Pills -->
    <div class="d-flex flex-wrap gap-2 mb-5">
        <a href="{{ route('admin.submissions', ['status' => 'pending']) }}" 
           class="btn {{ !request()->has('status') || request('status') == 'pending' ? 'btn-primary' : 'btn-light' }} rounded-pill px-4 fw-bold">
            Pending Approval
        </a>
        <a href="{{ route('admin.submissions', ['status' => 'Approved']) }}" 
           class="btn {{ request('status') == 'Approved' ? 'btn-primary' : 'btn-light' }} rounded-pill px-4 fw-bold">
            Approved
        </a>
        <a href="{{ route('admin.submissions', ['status' => 'Rejected']) }}" 
           class="btn {{ request('status') == 'Rejected' ? 'btn-primary' : 'btn-light' }} rounded-pill px-4 fw-bold">
            Rejected
        </a>
        <a href="{{ route('admin.submissions', ['status' => 'all']) }}" 
           class="btn {{ request('status') == 'all' ? 'btn-primary' : 'btn-light' }} rounded-pill px-4 fw-bold">
            View All
        </a>
    </div>

    <!-- Submissions List -->
    @if($submissions->count() == 0)
    <div class="card border-0 shadow-sm rounded-4 mb-5">
        <div class="card-body text-center py-5">
            <div class="bg-light d-inline-flex align-items-center justify-content-center rounded-circle p-4 mb-3">
                <i class="bi bi-inbox fs-1 text-muted"></i>
            </div>
            <h5 class="fw-bold">No submissions found</h5>
            <p class="text-muted mb-0">There are no items matching this criteria.</p>
        </div>
    </div>
    @else
    <div class="row g-4 mb-5">
        @foreach($submissions as $submission)
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-4 p-md-5">
                    <div class="row align-items-center">
                        <div class="col-lg-8 mb-4 mb-lg-0">
                            <!-- Badges -->
                            <div class="mb-3 d-flex flex-wrap gap-2">
                                <span class="badge badge-{{ strtolower($submission->archive_type) }}">
                                    {{ $submission->archive_type }}
                                </span>
                                <span class="badge badge-{{ strtolower($submission->status) }}">
                                    {{ $submission->status }}
                                </span>
                                @if($submission->reviewed_at)
                                <span class="badge bg-light text-dark small border">
                                    <i class="bi bi-person-check me-1"></i> Reviewed by Moderator
                                </span>
                                @endif
                            </div>

                            <!-- Title -->
                            <h4 class="fw-bold mb-3 text-dark">{{ $submission->title }}</h4>
                            
                            <!-- Detailed Info -->
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="small text-muted text-uppercase fw-bold mb-1">Authors</div>
                                    <div class="fw-semibold text-dark">{{ implode(', ', $submission->authors) }}</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="small text-muted text-uppercase fw-bold mb-1">Department</div>
                                    <div class="fw-semibold text-dark">{{ $submission->department }}</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="small text-muted text-uppercase fw-bold mb-1">Submitted By</div>
                                    <div class="fw-semibold text-dark">{{ $submission->user->name }}</div>
                                    <div class="small text-muted">{{ $submission->user->email }}</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="small text-muted text-uppercase fw-bold mb-1">Submission Date</div>
                                    <div class="fw-semibold text-dark">{{ $submission->created_at->format('M d, Y') }}</div>
                                </div>
                            </div>

                            <!-- Admin Remarks -->
                            @if($submission->admin_remarks)
                            <div class="mt-4 bg-light p-3 rounded-3 border-start border-4 {{ $submission->status === 'Approved' ? 'border-success' : 'border-danger' }}">
                                <div class="small fw-bold text-uppercase text-muted mb-1">Moderator Remark:</div>
                                <div class="small text-dark">{{ $submission->admin_remarks }}</div>
                            </div>
                            @endif
                        </div>

                        <div class="col-lg-4">
                            <div class="d-grid gap-2 ps-lg-4">
                                @if($submission->status === 'Pending')
                                <div class="bg-light p-4 rounded-4 border mb-2">
                                    <form action="{{ route('admin.submissions.review', $submission->id) }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label small fw-bold text-uppercase text-muted">Review Decision Feedback</label>
                                            <textarea class="form-control form-control-sm" name="remarks" rows="2" placeholder="Explain your decision..."></textarea>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <button type="submit" name="status" value="Approved" class="btn btn-success btn-sm flex-fill fw-bold py-2 rounded-3">Approve</button>
                                            <button type="submit" name="status" value="Rejected" class="btn btn-danger btn-sm flex-fill fw-bold py-2 rounded-3">Reject</button>
                                        </div>
                                    </form>
                                </div>
                                @endif

                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.submissions.show', $submission->id) }}" class="btn btn-primary btn-sm flex-fill fw-bold py-2 rounded-3">
                                        Details <i class="bi bi-chevron-right small ms-1"></i>
                                    </a>
                                    <div class="dropdown">
                                        <button class="btn btn-light btn-sm py-2 rounded-3 border" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></button>
                                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow rounded-4 mt-2">
                                            <li><a class="dropdown-item py-2" href="{{ route('admin.submissions.edit', $submission->id) }}"><i class="bi bi-pencil me-2"></i> Edit Data</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form action="{{ route('submissions.destroy', $submission->id) }}" method="POST" onsubmit="return confirm('Immediately delete this research from existence?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger py-2"><i class="bi bi-trash me-2"></i> Delete Permanently</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-4 mb-5 d-flex justify-content-center">
        {{ $submissions->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection
