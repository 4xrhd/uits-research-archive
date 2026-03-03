@extends('layouts.app')

@section('content')
<div class="container my-5 pt-4">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white py-4 px-4 border-bottom">
                    <h4 class="fw-bold mb-1">Submit Research Work</h4>
                    <p class="text-muted small mb-0">Share your research paper, article, capstone project, or thesis with the community.</p>
                </div>
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('submissions.store') }}" method="POST">
                        @csrf

                        <!-- Archive Type & Author Role -->
                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-uppercase text-muted">Archive Type *</label>
                                <select class="form-select @error('archive_type') is-invalid @enderror" name="archive_type" required>
                                    <option value="">Select type</option>
                                    <option value="Research" {{ old('archive_type') == 'Research' ? 'selected' : '' }}>Research Paper</option>
                                    <option value="Article" {{ old('archive_type') == 'Article' ? 'selected' : '' }}>Article</option>
                                    <option value="Capstone" {{ old('archive_type') == 'Capstone' ? 'selected' : '' }}>Capstone Project</option>
                                    <option value="Thesis" {{ old('archive_type') == 'Thesis' ? 'selected' : '' }}>Thesis</option>
                                </select>
                                @error('archive_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-uppercase text-muted">Author Role *</label>
                                <select class="form-select @error('author_role') is-invalid @enderror" name="author_role" required>
                                    <option value="">Select role</option>
                                    <option value="Student" {{ old('author_role') == 'Student' ? 'selected' : '' }}>Student</option>
                                    <option value="Faculty" {{ old('author_role') == 'Faculty' ? 'selected' : '' }}>Faculty</option>
                                </select>
                                @error('author_role')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Department & Batch -->
                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-uppercase text-muted">Department *</label>
                                <select class="form-select @error('department') is-invalid @enderror" name="department" required>
                                    <option value="">Select department</option>
                                    @foreach($departments as $dept)
                                    <option value="{{ $dept->name }}" {{ old('department') == $dept->name ? 'selected' : '' }}>
                                        {{ $dept->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('department')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-uppercase text-muted">Batch / Year</label>
                                <input type="text" class="form-control" name="batch" placeholder="e.g., Spring 2024" value="{{ old('batch') }}">
                            </div>
                        </div>

                        <!-- Academic Session -->
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase text-muted">Academic Session</label>
                            <input type="text" class="form-control" name="academic_session" placeholder="e.g., 2023-2024" value="{{ old('academic_session') }}">
                        </div>

                        <!-- Research Domains -->
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase text-muted">Research Domains</label>
                            <div class="bg-light rounded-4 p-4 border" style="max-height: 250px; overflow-y: auto;">
                                <div class="row g-3">
                                    @foreach($domains as $domain)
                                    <div class="col-md-4">
                                        <div class="form-check custom-check">
                                            <input class="form-check-input" type="checkbox" name="research_domains[]" 
                                                   value="{{ $domain->name }}" id="domain{{ $domain->id }}"
                                                   {{ in_array($domain->name, old('research_domains', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label small" for="domain{{ $domain->id }}">
                                                {{ $domain->name }}
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Custom Domain -->
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase text-muted">Custom Domain (if not listed)</label>
                            <input type="text" class="form-control" name="custom_domain" placeholder="Enter custom research domain" value="{{ old('custom_domain') }}">
                        </div>

                        <hr class="my-5 border-light">

                        <!-- Title -->
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase text-muted">Research Title *</label>
                            <input type="text" class="form-control form-control-lg fw-bold @error('title') is-invalid @enderror" name="title" 
                                   placeholder="Enter the title of your research" value="{{ old('title') }}" required>
                            @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Authors -->
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase text-muted">Authors *</label>
                            <div id="authorsContainer">
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" name="authors[]" placeholder="Primary author name" value="{{ old('authors.0') }}" required>
                                </div>
                            </div>
                            <button type="button" class="btn btn-link btn-sm text-decoration-none p-0 fw-bold" onclick="addAuthor()">
                                <i class="bi bi-plus-circle me-1"></i> Add Another Author
                            </button>
                        </div>

                        <!-- External Links -->
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase text-muted">External Links (GitHub, Portfolio, etc.)</label>
                            <div id="linksContainer">
                                <input type="url" class="form-control mb-2" name="external_links[]" placeholder="https://github.com/..." value="{{ old('external_links.0') }}">
                            </div>
                            <button type="button" class="btn btn-link btn-sm text-decoration-none p-0 fw-bold" onclick="addExternalLink()">
                                <i class="bi bi-plus-circle me-1"></i> Add External Link
                            </button>
                        </div>

                        <!-- PDF URL -->
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase text-muted">Main Project Link (PDF/Drive)</label>
                            <input type="url" class="form-control" name="pdf_url" placeholder="https://drive.google.com/..." value="{{ old('pdf_url') }}">
                            <div class="form-text small mt-2">
                                <i class="bi bi-info-circle me-1"></i>
                                Direct PDF link or public Google Drive link preferred.
                            </div>
                        </div>

                        <!-- Additional Drive Links -->
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase text-muted">Additional Resources (Drive Links)</label>
                            <div id="driveLinksContainer">
                                <input type="url" class="form-control mb-2" name="drive_links[]" placeholder="https://drive.google.com/..." value="{{ old('drive_links.0') }}">
                            </div>
                            <button type="button" class="btn btn-link btn-sm text-decoration-none p-0 fw-bold" onclick="addDriveLink()">
                                <i class="bi bi-plus-circle me-1"></i> Add Drive Link
                            </button>
                        </div>

                        <hr class="my-5 border-light">

                        <!-- Abstract -->
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase text-muted">Abstract / Results Summary</label>
                            <textarea class="form-control" name="abstract" rows="6" placeholder="Provide a brief summary of your research and key findings">{{ old('abstract') }}</textarea>
                        </div>

                        <!-- Author Comments -->
                        <div class="mb-5">
                            <label class="form-label fw-bold small text-uppercase text-muted">Personal Notes (Optional)</label>
                            <textarea class="form-control" name="author_comments" rows="3" placeholder="Any additional notes for the reviewer">{{ old('author_comments') }}</textarea>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-grid gap-3 d-md-flex justify-content-md-end">
                            <a href="{{ route('dashboard') }}" class="btn btn-light px-5 py-3 rounded-3 fw-bold order-2 order-md-1">Cancel</a>
                            <button type="submit" class="btn btn-primary px-5 py-3 rounded-3 fw-bold order-1 order-md-2">
                                <i class="bi bi-send-fill me-2"></i> Submit Research
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
            <input type="text" class="form-control" name="authors[]" placeholder="Additional author name">
            <button type="button" class="btn btn-light" onclick="this.parentElement.remove()">
                <i class="bi bi-x text-danger"></i>
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
