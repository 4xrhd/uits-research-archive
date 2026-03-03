@extends('layouts.app')

@section('content')
<div class="container my-5 pt-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Back Button -->
            <div class="mb-4">
                <a href="{{ route('dashboard') }}" class="btn btn-link text-decoration-none p-0 text-muted small fw-bold">
                    <i class="bi bi-arrow-left me-1"></i> Back to Dashboard
                </a>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
                <div class="card-header bg-white py-4 px-4 border-bottom d-flex justify-content-between align-items-center">
                    <div>
                        <span class="badge badge-{{ strtolower($submission->archive_type) }} mb-2">{{ $submission->archive_type }}</span>
                        <h3 class="fw-bold mb-0">{{ $submission->title }}</h3>
                    </div>
                    <div>
                        <span class="badge badge-{{ strtolower($submission->status) }} fs-6 px-3 py-2">
                            {{ $submission->status }}
                        </span>
                    </div>
                </div>
                <div class="card-body p-4 p-md-5">
                    <!-- Basic Info Grid -->
                    <div class="row g-4 mb-5">
                        <div class="col-md-3">
                            <label class="form-label fw-bold small text-uppercase text-muted">Department</label>
                            <p class="mb-0 fw-semibold">{{ $submission->department }}</p>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold small text-uppercase text-muted">Batch / Year</label>
                            <p class="mb-0 fw-semibold">{{ $submission->batch ?: 'N/A' }}</p>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold small text-uppercase text-muted">Academic Session</label>
                            <p class="mb-0 fw-semibold">{{ $submission->academic_session ?: 'N/A' }}</p>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold small text-uppercase text-muted">Role</label>
                            <p class="mb-0 fw-semibold">{{ $submission->author_role }}</p>
                        </div>
                    </div>

                    <!-- Authors -->
                    <div class="mb-5">
                        <label class="form-label fw-bold small text-uppercase text-muted mb-3">Authors</label>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($submission->authors as $author)
                            <div class="bg-light rounded-3 px-3 py-2 d-flex align-items-center">
                                <i class="bi bi-person-circle me-2 text-primary"></i>
                                <span class="fw-semibold">{{ $author }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Abstract -->
                    <div class="mb-5">
                        <label class="form-label fw-bold small text-uppercase text-muted mb-3">Abstract / Summary</label>
                        <div class="bg-light rounded-4 p-4 lh-lg">
                            {!! nl2br(e($submission->abstract)) ?: '<p class="text-muted italic mb-0">No abstract provided.</p>' !!}
                        </div>
                    </div>

                    <!-- Domains -->
                    @if(!empty($submission->research_domains))
                    <div class="mb-5">
                        <label class="form-label fw-bold small text-uppercase text-muted mb-3">Research Domains</label>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($submission->research_domains as $domain)
                            <span class="badge bg-white border text-muted px-3 py-2 rounded-pill">{{ $domain }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <hr class="my-5 border-light">

                    <!-- Links & Resources -->
                    <div class="mb-5">
                        <label class="form-label fw-bold small text-uppercase text-muted mb-4">Resources & Links</label>
                        <div class="row g-3">
                            @if($submission->pdf_url)
                            <div class="col-md-6">
                                <a href="{{ $submission->pdf_url }}" target="_blank" class="btn btn-outline-primary w-100 py-3 d-flex align-items-center justify-content-center gap-2">
                                    <i class="bi bi-file-earmark-pdf fs-5"></i>
                                    <span>Primary Research Link</span>
                                </a>
                            </div>
                            @endif

                            @if(!empty($submission->drive_links))
                                @foreach($submission->drive_links as $link)
                                <div class="col-md-6">
                                    <a href="{{ $link }}" target="_blank" class="btn btn-light border w-100 py-3 d-flex align-items-center justify-content-center gap-2">
                                        <i class="bi bi-cloud-check fs-5"></i>
                                        <span>Drive Resource</span>
                                    </a>
                                </div>
                                @endforeach
                            @endif

                            @if(!empty($submission->external_links))
                                @foreach($submission->external_links as $link)
                                <div class="col-md-6">
                                    <a href="{{ $link }}" target="_blank" class="btn btn-light border w-100 py-3 d-flex align-items-center justify-content-center gap-2">
                                        <i class="bi bi-globe2 fs-5"></i>
                                        <span class="text-truncate" style="max-width: 200px;">External Link</span>
                                    </a>
                                </div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <!-- Admin Remarks -->
                    @if($submission->admin_remarks)
                    <div class="alert {{ $submission->status === 'Approved' ? 'alert-success' : 'alert-danger' }} border-0 rounded-4 p-4 mb-0 shadow-sm">
                        <h6 class="fw-bold mb-2"><i class="bi bi-chat-left-text me-2"></i> Reviewer Feedback</h6>
                        <p class="mb-0">{{ $submission->admin_remarks }}</p>
                    </div>
                    @endif
                </div>
                
                @if($submission->status === 'Pending')
                <div class="card-footer bg-light py-4 px-4 d-flex gap-3">
                    <a href="{{ route('submissions.edit', $submission->id) }}" class="btn btn-primary px-4">
                        <i class="bi bi-pencil me-2"></i> Edit Submission
                    </a>
                    <form action="{{ route('submissions.destroy', $submission->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this submission?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger px-4">
                            <i class="bi bi-trash me-2"></i> Delete
                        </button>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
