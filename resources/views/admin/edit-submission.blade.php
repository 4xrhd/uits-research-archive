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
                <small class="text-muted" style="font-size: 0.7rem;">Edit Submission</small>
            </div>
        </a>
    </div>
</nav>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow">
                <div class="card-header bg-white">
                    <h4 class="mb-1">Edit Submission (Admin)</h4>
                    <p class="text-muted small mb-0">Update all fields including file links and status</p>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.submissions.update', $submission->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Submitter Info (Read-only) -->
                        <div class="alert alert-info mb-4">
                            <strong>Submitted by:</strong> {{ $submission->user->name }} ({{ $submission->user->email }})<br>
                            <strong>Submitted on:</strong> {{ $submission->created_at->format('F d, Y h:i A') }}
                        </div>

                        <!-- Status & Admin Remarks -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Status *</label>
                                <select class="form-select" name="status" required>
                                    <option value="Pending" {{ $submission->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="Approved" {{ $submission->status == 'Approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="Rejected" {{ $submission->status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Admin Remarks</label>
                            <textarea class="form-control" name="admin_remarks" rows="3" placeholder="Add feedback for the author">{{ $submission->admin_remarks }}</textarea>
                        </div>

                        <hr class="my-4">

                        <!-- Archive Type & Author Role -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Archive Type *</label>
                                <select class="form-select" name="archive_type" required>
                                    <option value="Research" {{ $submission->archive_type == 'Research' ? 'selected' : '' }}>Research Paper</option>
                                    <option value="Article" {{ $submission->archive_type == 'Article' ? 'selected' : '' }}>Article</option>
                                    <option value="Capstone" {{ $submission->archive_type == 'Capstone' ? 'selected' : '' }}>Capstone Project</option>
                                    <option value="Thesis" {{ $submission->archive_type == 'Thesis' ? 'selected' : '' }}>Thesis</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Author Role *</label>
                                <select class="form-select" name="author_role" required>
                                    <option value="Student" {{ $submission->author_role == 'Student' ? 'selected' : '' }}>Student</option>
                                    <option value="Faculty" {{ $submission->author_role == 'Faculty' ? 'selected' : '' }}>Faculty</option>
                                </select>
                            </div>
                        </div>

                        <!-- Title -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Research Title *</label>
                            <input type="text" class="form-control" name="title" value="{{ $submission->title }}" required>
                        </div>

                        <!-- Department & Batch -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Department *</label>
                                <select class="form-select" name="department" required>
                                    @foreach($departments as $dept)
                                    <option value="{{ $dept->name }}" {{ $submission->department == $dept->name ? 'selected' : '' }}>
                                        {{ $dept->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Batch/Year</label>
                                <input type="text" class="form-control" name="batch" value="{{ $submission->batch }}">
                            </div>
                        </div>

                        <!-- Academic Session -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Academic Session</label>
                            <input type="text" class="form-control" name="academic_session" value="{{ $submission->academic_session }}">
                        </div>

                        <!-- Authors -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Authors *</label>
                            <div id="authorsContainer">
                                @foreach($submission->authors as $index => $author)
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" name="authors[]" value="{{ $author }}" required>
                                    @if($index > 0)
                                    <button type="button" class="btn btn-outline-danger" onclick="this.parentElement.remove()">
                                        <i class="bi bi-x"></i>
                                    </button>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="addAuthor()">
                                <i class="bi bi-plus me-1"></i>Add Author
                            </button>
                        </div>

                        <!-- Research Domains -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Research Domains</label>
                            <div class="border rounded p-3" style="max-height: 200px; overflow-y: auto;">
                                <div class="row g-2">
                                    @foreach($domains as $domain)
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="research_domains[]" 
                                                   value="{{ $domain->name }}" id="domain{{ $domain->id }}"
                                                   {{ in_array($domain->name, $submission->research_domains ?? []) ? 'checked' : '' }}>
                                            <label class="form-check-label small" for="domain{{ $domain->id }}">
                                                {{ $domain->name }}
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- PDF URL (Admin can edit) -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-file-pdf me-1"></i>PDF URL or Google Drive Link
                            </label>
                            <input type="url" class="form-control" name="pdf_url" value="{{ $submission->pdf_url }}" 
                                   placeholder="https://drive.google.com/... or direct PDF URL">
                            <small class="form-text text-muted">
                                Admin can update file links at any time
                            </small>
                        </div>

                        <!-- Drive Links (Admin can edit) -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                <i class="bi bi-cloud me-1"></i>Additional Google Drive Links
                            </label>
                            <div id="driveLinksContainer">
                                @if(!empty($submission->drive_links))
                                    @foreach($submission->drive_links as $link)
                                    <div class="input-group mb-2">
                                        <input type="url" class="form-control" name="drive_links[]" value="{{ $link }}">
                                        <button type="button" class="btn btn-outline-danger" onclick="this.parentElement.remove()">
                                            <i class="bi bi-x"></i>
                                        </button>
                                    </div>
                                    @endforeach
                                @else
                                <input type="url" class="form-control mb-2" name="drive_links[]" placeholder="https://drive.google.com/...">
                                @endif
                            </div>
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="addDriveLink()">
                                <i class="bi bi-plus me-1"></i>Add Drive Link
                            </button>
                        </div>

                        <!-- External Links -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">External Links</label>
                            <div id="linksContainer">
                                @if(!empty($submission->external_links))
                                    @foreach($submission->external_links as $link)
                                    <div class="input-group mb-2">
                                        <input type="url" class="form-control" name="external_links[]" value="{{ $link }}">
                                        <button type="button" class="btn btn-outline-danger" onclick="this.parentElement.remove()">
                                            <i class="bi bi-x"></i>
                                        </button>
                                    </div>
                                    @endforeach
                                @else
                                <input type="url" class="form-control mb-2" name="external_links[]" placeholder="https://...">
                                @endif
                            </div>
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="addExternalLink()">
                                <i class="bi bi-plus me-1"></i>Add Link
                            </button>
                        </div>

                        <!-- Abstract -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Abstract / Results Summary</label>
                            <textarea class="form-control" name="abstract" rows="5">{{ $submission->abstract }}</textarea>
                        </div>

                        <!-- Author Comments -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Author Comments</label>
                            <textarea class="form-control" name="author_comments" rows="3">{{ $submission->author_comments }}</textarea>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex gap-3">
                            <button type="submit" class="btn btn-primary flex-fill">
                                <i class="bi bi-save me-2"></i>Save Changes
                            </button>
                            <a href="{{ route('admin.submissions') }}" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function addAuthor() {
        const container = document.getElementById('authorsContainer');
        const div = document.createElement('div');
        div.className = 'input-group mb-2';
        div.innerHTML = `
            <input type="text" class="form-control" name="authors[]" placeholder="Author name">
            <button type="button" class="btn btn-outline-danger" onclick="this.parentElement.remove()">
                <i class="bi bi-x"></i>
            </button>
        `;
        container.appendChild(div);
    }

    function addExternalLink() {
        const container = document.getElementById('linksContainer');
        const div = document.createElement('div');
        div.className = 'input-group mb-2';
        div.innerHTML = `
            <input type="url" class="form-control" name="external_links[]" placeholder="https://...">
            <button type="button" class="btn btn-outline-danger" onclick="this.parentElement.remove()">
                <i class="bi bi-x"></i>
            </button>
        `;
        container.appendChild(div);
    }

    function addDriveLink() {
        const container = document.getElementById('driveLinksContainer');
        const div = document.createElement('div');
        div.className = 'input-group mb-2';
        div.innerHTML = `
            <input type="url" class="form-control" name="drive_links[]" placeholder="https://drive.google.com/...">
            <button type="button" class="btn btn-outline-danger" onclick="this.parentElement.remove()">
                <i class="bi bi-x"></i>
            </button>
        `;
        container.appendChild(div);
    }
</script>
@endpush
@endsection
