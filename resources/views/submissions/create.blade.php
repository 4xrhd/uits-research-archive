@extends('layouts.app')

@section('content')
<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('dashboard') }}">
            <div class="bg-primary text-white rounded p-2 me-2">
                <i class="bi bi-book"></i>
            </div>
            <div>
                <div class="fw-bold">UITS Research Archive</div>
                <small class="text-muted" style="font-size: 0.7rem;">Submit Research</small>
            </div>
        </a>
    </div>
</nav>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow">
                <div class="card-header bg-white">
                    <h4 class="mb-1">Submit Research Work</h4>
                    <p class="text-muted small mb-0">Fill out the form below to submit your research paper, article, capstone project, or thesis</p>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('submissions.store') }}" method="POST">
                        @csrf

                        <!-- Archive Type & Author Role -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Archive Type *</label>
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
                                <label class="form-label fw-semibold">Author Role *</label>
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
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Department *</label>
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
                                <label class="form-label fw-semibold">Batch/Year</label>
                                <input type="text" class="form-control" name="batch" placeholder="e.g., Spring 2024" value="{{ old('batch') }}">
                            </div>
                        </div>

                        <!-- Academic Session -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Academic Session</label>
                            <input type="text" class="form-control" name="academic_session" placeholder="e.g., 2023-2024" value="{{ old('academic_session') }}">
                        </div>

                        <!-- Research Domains -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Research Domains (Select multiple)</label>
                            <div class="border rounded p-3" style="max-height: 300px; overflow-y: auto;">
                                <div class="row g-2">
                                    @foreach($domains as $domain)
                                    <div class="col-md-4">
                                        <div class="form-check">
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
                            <label class="form-label fw-semibold">Custom Domain (if not listed above)</label>
                            <input type="text" class="form-control" name="custom_domain" placeholder="Enter custom research domain" value="{{ old('custom_domain') }}">
                        </div>

                        <!-- Title -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Research Title *</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" 
                                   placeholder="Enter the title of your research" value="{{ old('title') }}" required>
                            @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Authors -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Authors *</label>
                            <div id="authorsContainer">
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" name="authors[]" placeholder="Author 1 name" value="{{ old('authors.0') }}" required>
                                </div>
                            </div>
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="addAuthor()">
                                <i class="bi bi-plus me-1"></i>Add Author
                            </button>
                        </div>

                        <!-- External Links -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">External Links (GitHub, Portfolio, etc.)</label>
                            <div id="linksContainer">
                                <input type="url" class="form-control mb-2" name="external_links[]" placeholder="https://..." value="{{ old('external_links.0') }}">
                            </div>
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="addExternalLink()">
                                <i class="bi bi-plus me-1"></i>Add Link
                            </button>
                        </div>

                        <!-- PDF URL -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">PDF URL or Google Drive Link</label>
                            <input type="url" class="form-control" name="pdf_url" placeholder="https://drive.google.com/... or direct PDF URL" value="{{ old('pdf_url') }}">
                            <small class="form-text text-muted">
                                <i class="bi bi-info-circle me-1"></i>
                                You can provide a Google Drive link or direct PDF URL. Files stay forever - no upload limits!
                            </small>
                        </div>

                        <!-- Additional Drive Links -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Additional Google Drive Links</label>
                            <div id="driveLinksContainer">
                                <input type="url" class="form-control mb-2" name="drive_links[]" placeholder="https://drive.google.com/..." value="{{ old('drive_links.0') }}">
                            </div>
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="addDriveLink()">
                                <i class="bi bi-plus me-1"></i>Add Drive Link
                            </button>
                        </div>

                        <!-- Abstract -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Abstract / Results Summary</label>
                            <textarea class="form-control" name="abstract" rows="5" placeholder="Provide a brief summary of your research and key findings">{{ old('abstract') }}</textarea>
                        </div>

                        <!-- Author Comments -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Author Comments (Optional)</label>
                            <textarea class="form-control" name="author_comments" rows="3" placeholder="Any additional comments or notes">{{ old('author_comments') }}</textarea>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex gap-3">
                            <button type="submit" class="btn btn-primary flex-fill">
                                <i class="bi bi-send me-2"></i>Submit Research
                            </button>
                            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">Cancel</a>
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
