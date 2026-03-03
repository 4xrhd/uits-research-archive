@extends('layouts.app')

@section('content')
<div class="container my-5 pt-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Navigation & Actions -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <a href="{{ route('admin.submissions') }}" class="btn btn-link text-decoration-none p-0 text-muted small fw-bold">
                    <i class="bi bi-arrow-left me-1"></i> Back to Submissions
                </a>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.submissions.edit', $submission->id) }}" class="btn btn-light btn-sm rounded-3 px-3 fw-bold">
                        <i class="bi bi-pencil me-1"></i> Edit
                    </a>
                    <form action="{{ route('admin.submissions.destroy', $submission->id) }}" method="POST" onsubmit="return confirm('Archive this submission permanently?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-light btn-sm rounded-3 px-3 text-danger fw-bold">
                            <i class="bi bi-trash"></i>
                        </button>
                    </form>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-8">
                    <!-- Main Content Card -->
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                        <div class="card-body p-4 p-md-5">
                            <div class="mb-4">
                                <span class="badge badge-{{ strtolower($submission->archive_type) }} mb-2">{{ $submission->archive_type }}</span>
                                <h2 class="fw-bold text-dark mb-3">{{ $submission->title }}</h2>
                                <div class="d-flex flex-wrap gap-3 text-muted small">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-person me-1"></i> {{ implode(', ', $submission->authors) }}
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-building me-1"></i> {{ $submission->department }}
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-calendar3 me-1"></i> {{ $submission->created_at->format('M d, Y') }}
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4 border-light">

                            <div class="mb-5">
                                <h6 class="fw-bold text-uppercase text-muted small mb-3">Abstract / Executive Summary</h6>
                                <div class="text-dark lh-base" style="white-space: pre-line;">
                                    {{ $submission->abstract ?: 'No abstract provided for this submission.' }}
                                </div>
                            </div>

                            @if(!empty($submission->research_domains))
                            <div class="mb-5">
                                <h6 class="fw-bold text-uppercase text-muted small mb-3">Research Domains</h6>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($submission->research_domains as $domain)
                                    <span class="badge bg-light text-dark border px-3 py-2 rounded-pill small">{{ $domain }}</span>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            @if($submission->author_comments)
                            <div class="mb-0">
                                <h6 class="fw-bold text-uppercase text-muted small mb-3">Author Observations</h6>
                                <div class="p-3 bg-light rounded-3 small text-muted italic">
                                    "{{ $submission->author_comments }}"
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Admin Feedback Card -->
                    <div class="card border-0 shadow-sm rounded-4 bg-primary text-white overflow-hidden">
                        <div class="card-body p-4 p-md-5">
                            <h6 class="fw-bold text-uppercase small mb-3 opacity-75">Administrative Decision</h6>
                            <div class="d-flex align-items-center mb-4">
                                <div class="bg-white text-primary rounded-circle p-2 me-3">
                                    @if($submission->status === 'Approved')
                                        <i class="bi bi-check-circle-fill fs-4"></i>
                                    @elseif($submission->status === 'Rejected')
                                        <i class="bi bi-x-circle-fill fs-4"></i>
                                    @else
                                        <i class="bi bi-clock-fill fs-4"></i>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="fw-bold mb-0">{{ $submission->status }}</h4>
                                    <small class="opacity-75">Platform Review Stage</small>
                                </div>
                            </div>
                            
                            @if($submission->admin_remarks)
                            <div class="p-3 bg-white bg-opacity-20 rounded-3 border border-white border-opacity-30">
                                <div class="fw-bold mb-1">Moderator Remarks:</div>
                                {{ $submission->admin_remarks }}
                            </div>
                            @else
                            <div class="text-center opacity-100 fw-medium small italic py-2">
                                No specific administrative remarks recorded.
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <!-- Metadata Sidebar -->
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-header bg-white border-bottom py-3 px-4">
                            <h6 class="fw-bold mb-0">Submitter Identity</h6>
                        </div>
                        <div class="card-body px-4 py-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-light text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold me-3" style="width: 48px; height: 48px; font-size: 1.2rem;">
                                    {{ strtoupper(substr($submission->user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">{{ $submission->user->name }}</div>
                                    <div class="text-muted small">{{ $submission->user->email }}</div>
                                </div>
                            </div>
                            <div class="pt-3 border-top">
                                <div class="row g-2 mb-2">
                                    <div class="col-5 text-dark fw-bold small">User Role:</div>
                                    <div class="col-7 text-dark small fw-semibold text-end">{{ ucfirst($submission->user->role) }}</div>
                                </div>
                                <div class="row g-2">
                                    <div class="col-5 text-dark fw-bold small">Academic Role:</div>
                                    <div class="col-7 text-dark small fw-semibold text-end">{{ $submission->author_role }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Resources Sidebar -->
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                        <div class="card-header bg-white border-bottom py-3 px-4">
                            <h6 class="fw-bold mb-0">Digital Assets</h6>
                        </div>
                        <div class="card-body p-4">
                            @if($submission->pdf_url)
                            <a href="{{ $submission->pdf_url }}" target="_blank" class="btn btn-primary w-100 py-2 rounded-3 fw-bold mb-3 d-flex align-items-center justify-content-center">
                                <i class="bi bi-file-earmark-pdf me-2"></i> View Primary PDF
                            </a>
                            @else
                            <div class="alert alert-warning py-2 small mb-3 text-center">
                                <i class="bi bi-exclamation-triangle me-1"></i> No PDF File Linked
                            </div>
                            @endif

                            @if(!empty($submission->drive_links))
                            <h6 class="fw-bold text-uppercase text-muted small mb-3">Additional Resources</h6>
                            <div class="d-grid gap-2">
                                @foreach($submission->drive_links as $link)
                                <a href="{{ $link }}" target="_blank" class="btn btn-light btn-sm text-start py-2 px-3 rounded-3 border-0 d-flex align-items-center">
                                    <i class="bi bi-cloud text-primary me-2"></i> {{ Str::limit($link, 30) }}
                                </a>
                                @endforeach
                            </div>
                            @elseif(!$submission->pdf_url)
                            <div class="text-center py-4 text-muted small">
                                <i class="bi bi-cloud-slash d-block fs-3 mb-2"></i>
                                No external resources available.
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection