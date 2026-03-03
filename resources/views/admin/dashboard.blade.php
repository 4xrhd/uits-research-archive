@extends('layouts.app')

@section('content')
<div class="container my-5 pt-4">
    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-5 gap-3">
        <div>
            <h2 class="fw-bold mb-1">Administrative Overview</h2>
            <p class="text-muted mb-0">Monitor platform activity and manage research publications.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.submissions') }}" class="btn btn-primary px-4 py-2 rounded-3 fw-bold">
                <i class="bi bi-list-check me-2"></i> Manage Submissions
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 text-center p-3 h-100">
                <div class="card-body">
                    <div class="bg-light d-inline-flex align-items-center justify-content-center rounded-circle p-3 mb-3" style="width: 60px; height: 60px;">
                        <i class="bi bi-files fs-4 text-primary"></i>
                    </div>
                    <h6 class="text-muted small text-uppercase fw-bold mb-2">Total Works</h6>
                    <h2 class="fw-bold mb-0">{{ $stats['total'] }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 text-center p-3 h-100">
                <div class="card-body">
                    <div class="bg-light d-inline-flex align-items-center justify-content-center rounded-circle p-3 mb-3" style="width: 60px; height: 60px;">
                        <i class="bi bi-clock-history fs-4 text-warning"></i>
                    </div>
                    <h6 class="text-muted small text-uppercase fw-bold mb-2">Pending Review</h6>
                    <h2 class="fw-bold mb-0">{{ $stats['pending'] }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 text-center p-3 h-100">
                <div class="card-body">
                    <div class="bg-light d-inline-flex align-items-center justify-content-center rounded-circle p-3 mb-3" style="width: 60px; height: 60px;">
                        <i class="bi bi-check2-all fs-4 text-success"></i>
                    </div>
                    <h6 class="text-muted small text-uppercase fw-bold mb-2">Approved</h6>
                    <h2 class="fw-bold mb-0">{{ $stats['approved'] }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 text-center p-3 h-100">
                <div class="card-body">
                    <div class="bg-light d-inline-flex align-items-center justify-content-center rounded-circle p-3 mb-3" style="width: 60px; height: 60px;">
                        <i class="bi bi-x-circle fs-4 text-danger"></i>
                    </div>
                    <h6 class="text-muted small text-uppercase fw-bold mb-2">Rejected</h6>
                    <h2 class="fw-bold mb-0">{{ $stats['rejected'] }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity Section -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white py-4 px-4 border-bottom d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="fw-bold mb-0">Recent Submissions</h5>
                        <p class="text-muted small mb-0">Lastest works awaiting your attention</p>
                    </div>
                    <a href="{{ route('admin.submissions', ['status' => 'pending']) }}" class="btn btn-link text-decoration-none fw-bold small">Review All <i class="bi bi-arrow-right ms-1"></i></a>
                </div>
                <div class="card-body p-0">
                    @if($recentSubmissions->count() == 0)
                    <div class="text-center py-5">
                        <i class="bi bi-inbox text-muted fs-1"></i>
                        <h5 class="mt-3 text-muted">Awaiting new submissions</h5>
                    </div>
                    @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="px-4 py-3 border-0 small text-uppercase text-muted fw-bold">Submission</th>
                                    <th class="py-3 border-0 small text-uppercase text-muted fw-bold">Authors / User</th>
                                    <th class="py-3 border-0 small text-uppercase text-muted fw-bold">Department</th>
                                    <th class="py-3 border-0 small text-uppercase text-muted fw-bold text-end px-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentSubmissions as $submission)
                                <tr>
                                    <td class="px-4 py-4">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-light rounded p-2 me-3 d-none d-md-block">
                                                <i class="bi bi-journal-bookmark text-primary"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark">{{ Str::limit($submission->title, 60) }}</div>
                                                <div class="badge badge-{{ strtolower($submission->archive_type) }} mt-1">
                                                    {{ $submission->archive_type }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-semibold">{{ implode(', ', $submission->authors) }}</div>
                                        <div class="small text-muted">{{ $submission->user->email }}</div>
                                    </td>
                                    <td>{{ $submission->department }}</td>
                                    <td class="text-end px-4">
                                        <div class="d-flex justify-content-end gap-2">
                                            <button type="button" class="btn btn-light btn-sm rounded-3 px-3 fw-bold" 
                                                    data-bs-toggle="modal" data-bs-target="#viewModal{{ $submission->id }}">
                                                View
                                            </button>
                                            @if($submission->status === 'Pending')
                                            <button type="button" class="btn btn-success btn-sm rounded-3 px-3 fw-bold" 
                                                    data-bs-toggle="modal" data-bs-target="#reviewModal{{ $submission->id }}" 
                                                    onclick="prepareReview('{{ $submission->id }}', 'Approved')">
                                                Approve
                                            </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>

                                <!-- Simple Review Modal (Hidden) -->
                                <div class="modal fade" id="reviewModal{{ $submission->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 shadow-lg rounded-4">
                                            <form action="{{ route('admin.submissions.review', $submission->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-header border-bottom py-4 px-4">
                                                    <h5 class="fw-bold mb-0">Decide Submission</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body p-4">
                                                    <input type="hidden" name="status" id="reviewStatus{{ $submission->id }}">
                                                    <div class="mb-3">
                                                        <label class="form-label fw-bold small text-uppercase text-muted">Feedback Remarks (Optional)</label>
                                                        <textarea class="form-control" name="remarks" rows="4" 
                                                                  placeholder="Add any comments for the author..."></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-top p-3 d-flex gap-2">
                                                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary px-4 fw-bold flex-fill">Confirm Decision</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function prepareReview(submissionId, status) {
        const input = document.getElementById('reviewStatus' + submissionId);
        if (input) input.value = status;
    }
</script>
@endpush
@endsection
