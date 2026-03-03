@extends('layouts.app')

@section('content')
<div class="container my-5 pt-4">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <!-- Back Button -->
            <div class="mb-4">
                <a href="{{ route('admin.submissions') }}" class="btn btn-link text-decoration-none p-0 text-muted small fw-bold">
                    <i class="bi bi-arrow-left me-1"></i> Back to All Submissions
                </a>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white py-4 px-4 border-bottom">
                    <h4 class="fw-bold mb-1">Administrative Oversight</h4>
                    <p class="text-muted small mb-0">Modify, review, and finalize archive data.</p>
                </div>
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('admin.submissions.update', $submission->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Submitter Context -->
                        <div class="bg-light rounded-4 p-4 mb-5 border">
                            <div class="row g-3">
                                <div class="col-md-6 text-center text-md-start">
                                    <div class="small fw-bold text-uppercase text-muted mb-1">Submission Origin</div>
                                    <div class="fw-bold text-primary">{{ $submission->user->name }}</div>
                                    <div class="small text-muted">{{ $submission->user->email }}</div>
                                </div>
                                <div class="col-md-6 text-center text-md-end border-md-start border-0">
                                    <div class="small fw-bold text-uppercase text-muted mb-1">Initial Timestamp</div>
                                    <div class="fw-bold text-dark">{{ $submission->created_at->format('M d, Y') }}</div>
                                    <div class="small text-muted">{{ $submission->created_at->format('h:i A') }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-uppercase text-muted">Platform Status *</label>
                                <select class="form-select @error('status') is-invalid @enderror" name="status" required>
                                    <option value="Pending" {{ old('status', $submission->status) == 'Pending' ? 'selected' : '' }}>Pending Review</option>
                                    <option value="Approved" {{ old('status', $submission->status) == 'Approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="Rejected" {{ old('status', $submission->status) == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-uppercase text-muted">Archive Type *</label>
                                <select class="form-select @error('archive_type') is-invalid @enderror" name="archive_type" required>
                                    <option value="Research" {{ old('archive_type', $submission->archive_type) == 'Research' ? 'selected' : '' }}>Research Paper</option>
                                    <option value="Article" {{ old('archive_type', $submission->archive_type) == 'Article' ? 'selected' : '' }}>Article</option>
                                    <option value="Capstone" {{ old('archive_type', $submission->archive_type) == 'Capstone' ? 'selected' : '' }}>Capstone Project</option>
                                    <option value="Thesis" {{ old('archive_type', $submission->archive_type) == 'Thesis' ? 'selected' : '' }}>Thesis</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase text-muted">Moderator Observations / Remarks</label>
                            <textarea class="form-control" name="admin_remarks" rows="3" placeholder="Will be visible to the author">{{ old('admin_remarks', $submission->admin_remarks) }}</textarea>
                        </div>

                        <hr class="my-5 border-light">

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase text-muted">Research Title *</label>
                            <input type="text" class="form-control form-control-lg fw-bold" name="title" value="{{ old('title', $submission->title) }}" required>
                        </div>

                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-uppercase text-muted">Academic Department *</label>
                                <select class="form-select" name="department" required>
                                    @foreach($departments as $dept)
                                    <option value="{{ $dept->name }}" {{ old('department', $submission->department) == $dept->name ? 'selected' : '' }}>
                                        {{ $dept->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-uppercase text-muted">Author Role *</label>
                                <select class="form-select" name="author_role" required>
                                    <option value="Student" {{ old('author_role', $submission->author_role) == 'Student' ? 'selected' : '' }}>Student</option>
                                    <option value="Faculty" {{ old('author_role', $submission->author_role) == 'Faculty' ? 'selected' : '' }}>Faculty Staff</option>
                                </select>
                            </div>
                        </div>

                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-uppercase text-muted">Batch / Graduation Year</label>
                                <input type="text" class="form-control" name="batch" value="{{ old('batch', $submission->batch) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-uppercase text-muted">Academic Cycle</label>
                                <input type="text" class="form-control" name="academic_session" value="{{ old('academic_session', $submission->academic_session) }}">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase text-muted">Primary Authors *</label>
                            <div id="authorsContainer">
                                @foreach(old('authors', $submission->authors) as $index => $author)
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" name="authors[]" value="{{ $author }}" required>
                                    @if($index > 0)
                                    <button type="button" class="btn btn-light" onclick="this.parentElement.remove()">
                                        <i class="bi bi-x text-danger"></i>
                                    </button>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn btn-link btn-sm text-decoration-none p-0 fw-bold" onclick="addAuthor()">
                                <i class="bi bi-plus-circle me-1"></i> Add Another Author
                            </button>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase text-muted">Research Domains</label>
                            <div class="bg-light rounded-4 p-4 border" style="max-height: 250px; overflow-y: auto;">
                                <div class="row g-3">
                                    @foreach($domains as $domain)
                                    <div class="col-md-4">
                                        <div class="form-check custom-check">
                                            <input class="form-check-input" type="checkbox" name="research_domains[]" 
                                                   value="{{ $domain->name }}" id="domain{{ $domain->id }}"
                                                   {{ in_array($domain->name, old('research_domains', $submission->research_domains ?? [])) ? 'checked' : '' }}>
                                            <label class="form-check-label small" for="domain{{ $domain->id }}">
                                                {{ $domain->name }}
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <hr class="my-5 border-light">

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase text-muted">PDF Access / Primary Link</label>
                            <input type="url" class="form-control" name="pdf_url" value="{{ old('pdf_url', $submission->pdf_url) }}">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase text-muted">Resource Ecosystem (Drive / External)</label>
                            <div id="driveLinksContainer">
                                @forelse(old('drive_links', $submission->drive_links ?? []) as $link)
                                <div class="input-group mb-2">
                                    <input type="url" class="form-control" name="drive_links[]" value="{{ $link }}">
                                    <button type="button" class="btn btn-light" onclick="this.parentElement.remove()">
                                        <i class="bi bi-x text-danger"></i>
                                    </button>
                                </div>
                                @empty
                                <input type="url" class="form-control mb-2" name="drive_links[]" placeholder="https://drive.google.com/...">
                                @endforelse
                            </div>
                            <button type="button" class="btn btn-link btn-sm text-decoration-none p-0 fw-bold" onclick="addDriveLink()">
                                <i class="bi bi-plus-circle me-1"></i> Add Resource Link
                            </button>
                        </div>

                        <hr class="my-5 border-light">

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase text-muted">Abstract Overview</label>
                            <textarea class="form-control" name="abstract" rows="6">{{ old('abstract', $submission->abstract) }}</textarea>
                        </div>

                        <div class="mb-5">
                            <label class="form-label fw-bold small text-uppercase text-muted">Original Author Metadata/Notes</label>
                            <div class="p-3 bg-light border-start border-4 rounded-3 small text-muted">
                                {{ $submission->author_comments ?: 'No original comments left by author.' }}
                                <input type="hidden" name="author_comments" value="{{ $submission->author_comments }}">
                            </div>
                        </div>

                        <!-- Final Actions -->
                        <div class="d-grid gap-3 d-md-flex justify-content-md-end pt-4 border-top">
                            <a href="{{ route('admin.submissions') }}" class="btn btn-light px-5 py-3 rounded-3 fw-bold order-2 order-md-1">Cancel Changes</a>
                            <button type="submit" class="btn btn-primary px-5 py-3 rounded-3 fw-bold order-1 order-md-2">
                                <i class="bi bi-shield-lock-fill me-2"></i> Commit Updates
                            </button>
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
            <button type="button" class="btn btn-light" onclick="this.parentElement.remove()">
                <i class="bi bi-x text-danger"></i>
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
            <button type="button" class="btn btn-light" onclick="this.parentElement.remove()">
                <i class="bi bi-x text-danger"></i>
            </button>
        `;
        container.appendChild(div);
    }
</script>
@endpush
@endsection
