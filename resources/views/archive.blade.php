<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Archive - {{ config('app.name', 'UITS Research Archive') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        :root {
            --primary-color: #0f172a;
            --accent-color: #2563eb;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --bg-body: #ffffff;
            --bg-alt: #f8fafc;
            --border-color: #e2e8f0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
            padding-top: 80px; 
        }

        h1, h2, h3, h4, h5, h6, .navbar-brand {
            font-family: 'Outfit', sans-serif;
            color: var(--primary-color);
        }

        /* Clean Navbar */
        .navbar {
            background: rgba(255, 255, 255, 0.8) !important;
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 0;
            transition: all 0.3s ease;
        }
        
        .nav-link {
            color: var(--text-main) !important;
            font-weight: 500;
            transition: all 0.2s;
        }
        
        .nav-link:hover {
            color: var(--accent-color) !important;
        }

        /* Hero Text */
        .page-title {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 0.5rem;
            color: var(--primary-color);
            letter-spacing: -0.02em;
        }

        /* Form Controls */
        .search-container {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05);
        }

        .form-control, .form-select, .input-group-text {
            background-color: var(--bg-alt) !important;
            border: 1px solid var(--border-color) !important;
            color: var(--text-main) !important;
            border-radius: 10px;
        }

        .form-control::placeholder {
            color: var(--text-muted);
        }

        .form-control:focus, .form-select:focus {
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1) !important;
            border-color: var(--accent-color) !important;
        }

        .form-label {
            color: var(--text-muted);
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
        }

        /* Buttons */
        .btn-premium {
            background-color: var(--accent-color);
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            padding: 0.75rem 2rem;
            transition: all 0.2s;
        }
        .btn-premium:hover {
            background-color: #1d4ed8;
            transform: translateY(-2px);
            color: white;
        }
        
        .btn-outline-premium {
            background: white;
            color: var(--text-main);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            font-weight: 600;
            padding: 0.75rem 2rem;
            transition: all 0.2s;
        }
        .btn-outline-premium:hover {
            background: var(--bg-alt);
            border-color: #cbd5e1;
        }

        /* Archive Cards */
        .archive-card {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 20px;
            transition: all 0.3s ease;
            height: 100%;
            cursor: pointer;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        .archive-card:hover {
            transform: translateY(-8px);
            border-color: var(--accent-color);
            box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);
        }

        .card-title {
            color: var(--primary-color);
            font-weight: 700;
            font-size: 1.25rem;
            line-height: 1.4;
            margin-bottom: 1rem;
        }

        .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }

        /* Specific Badges */
        .type-badge {
            font-weight: 600;
            padding: 0.4rem 0.8rem;
            border-radius: 8px;
            font-size: 0.75rem;
            text-transform: uppercase;
        }
        
        .badge-research { background: #eff6ff; color: #1e40af; }
        .badge-article { background: #faf5ff; color: #6b21a8; }
        .badge-capstone { background: #fffaf5; color: #9a3412; }
        .badge-thesis { background: #f5f3ff; color: #3730a3; }
        
        .tag-badge {
            background: var(--bg-alt);
            color: var(--text-muted);
            border: 1px solid var(--border-color);
            padding: 0.25rem 0.75rem;
            border-radius: 50px;
            font-size: 0.8rem;
        }

        /* Modals */
        .modal-content {
            background-color: white;
            border: 1px solid var(--border-color);
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
        }
        .modal-header { border-bottom: 1px solid var(--border-color); padding: 2rem; }
        .modal-footer { border-top: 1px solid var(--border-color); padding: 2rem; }
        
        .modal-body .bg-light {
            background-color: var(--bg-alt) !important;
            border: 1px solid var(--border-color);
            border-radius: 16px;
        }
        
        /* Pagination */
        .pagination {
            --bs-pagination-bg: white;
            --bs-pagination-border-color: var(--border-color);
            --bs-pagination-color: var(--text-main);
            --bs-pagination-active-bg: var(--accent-color);
            --bs-pagination-active-border-color: var(--accent-color);
        }
        .page-link { border-radius: 10px !important; margin: 0 4px; }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <x-nav-brand />
            
            <button class="navbar-toggler border-0 px-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <i class="bi bi-list fs-1 text-dark"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center gap-2">
                    <li class="nav-item">
                        <a class="nav-link px-3 active fw-bold" href="{{ route('archive') }}">Explore Archive</a>
                    </li>
                    
                    @if (Route::has('login'))
                        @auth
                            <li class="nav-item ms-lg-2">
                                <a href="{{ url('/dashboard') }}" class="btn btn-outline-premium btn-sm py-2 px-4 shadow-none border-0">
                                    <i class="bi bi-speedometer2"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item ms-lg-2">
                                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm py-2 px-4" style="border-radius: 50px; background: rgba(220, 53, 69, 0.1); color: #fca5a5; border: 1px solid rgba(220, 53, 69, 0.2);">
                                        <i class="bi bi-box-arrow-right"></i> Logout
                                    </button>
                                </form>
                            </li>
                        @else
                            <li class="nav-item ms-lg-2">
                                <a href="{{ route('login') }}" class="nav-link px-3">Log in</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item ms-lg-2">
                                    <a href="{{ route('register') }}" class="btn btn-premium btn-sm py-2 px-4 shadow-none">
                                        Sign up free
                                    </a>
                                </li>
                            @endif
                        @endauth
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <div class="container py-5 mt-4">
        <!-- Hero Title -->
        <div class="text-center mb-5">
            <h1 class="page-title">Explore Research.</h1>
            <p class="fs-5 text-muted">Discover thousands of thesis papers, articles, and capstone projects.</p>
        </div>

        <!-- Search Box -->
        <div class="search-container">
            <form action="{{ route('archive') }}" method="GET">
                <div class="mb-4">
                    <div class="input-group input-group-lg" style="border-radius: 12px; overflow: hidden;">
                        <span class="input-group-text border-end-0"><i class="bi bi-search text-secondary"></i></span>
                        <input type="text" 
                               class="form-control border-start-0 ps-0 shadow-none" 
                               name="search" 
                               placeholder="Search by title, author, domain, keywords..."
                               value="{{ request('search') }}">
                    </div>
                </div>

                <div class="row g-4">
                    <!-- Type Filter -->
                    <div class="col-md-3">
                        <label class="form-label"><i class="bi bi-file-earmark-text me-1"></i> Document Type</label>
                        <select class="form-select shadow-none" name="type">
                            <option value="all">All Types</option>
                            <option value="Research" {{ request('type') == 'Research' ? 'selected' : '' }}>Research</option>
                            <option value="Article" {{ request('type') == 'Article' ? 'selected' : '' }}>Article</option>
                            <option value="Capstone" {{ request('type') == 'Capstone' ? 'selected' : '' }}>Capstone</option>
                            <option value="Thesis" {{ request('type') == 'Thesis' ? 'selected' : '' }}>Thesis</option>
                        </select>
                    </div>

                    <!-- Department Filter -->
                    <div class="col-md-3">
                        <label class="form-label"><i class="bi bi-building me-1"></i> Department</label>
                        <select class="form-select shadow-none" name="department">
                            <option value="all">All Departments</option>
                            @foreach($departments as $dept)
                            <option value="{{ $dept->name }}" {{ request('department') == $dept->name ? 'selected' : '' }}>
                                {{ $dept->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Domain Filter -->
                    <div class="col-md-3">
                        <label class="form-label"><i class="bi bi-tag me-1"></i> Domain</label>
                        <select class="form-select shadow-none" name="domain">
                            <option value="all">All Domains</option>
                            @foreach($domains as $domain)
                            <option value="{{ $domain->name }}" {{ request('domain') == $domain->name ? 'selected' : '' }}>
                                {{ $domain->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Session Filter -->
                    <div class="col-md-3">
                        <label class="form-label"><i class="bi bi-calendar3 me-1"></i> Session</label>
                        <select class="form-select shadow-none" name="session">
                            <option value="all">All Sessions</option>
                            @foreach($sessions as $session)
                            <option value="{{ $session }}" {{ request('session') == $session ? 'selected' : '' }}>
                                {{ $session }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Submit / Settings -->
                <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                    <span class="text-muted small">
                        Showing <strong class="text-dark">{{ $submissions->count() }}</strong> of <strong class="text-dark">{{ $submissions->total() }}</strong> results
                    </span>
                    <div class="d-flex gap-2">
                        @if(request()->hasAny(['search', 'type', 'department', 'domain', 'session']))
                        <a href="{{ route('archive') }}" class="btn btn-outline-premium py-2 px-3">
                            Clear Filters
                        </a>
                        @endif
                        <button type="submit" class="btn btn-premium py-2 px-4 shadow-none">
                            Update Results
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Archive Grid -->
        @if($submissions->count() == 0)
        <div class="text-center py-5 my-5">
            <div style="font-size: 5rem; color: rgba(255, 255, 255, 0.05); margin-bottom: 1rem;">
                <i class="bi bi-search"></i>
            </div>
            <h3 class="mb-3">No matching research found</h3>
            <p class="text-secondary max-w-md mx-auto">
                @if(request()->hasAny(['search', 'type', 'department', 'domain', 'session']))
                    Try resetting your filters or adjusting your search terms to find what you're looking for.
                @else
                    There are no approved research items published in the archive yet.
                @endif
            </p>
        </div>
        @else
        <div class="row g-4 mb-5">
            @foreach($submissions as $submission)
            <div class="col-md-6 col-lg-4">
                <div class="archive-card" data-bs-toggle="modal" data-bs-target="#submissionModal{{ $submission->id }}">
                    <!-- Header Badges -->
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <span class="type-badge badge-{{ strtolower($submission->archive_type) }}">
                            {{ $submission->archive_type }}
                        </span>
                        <small class="text-muted" style="font-size: 0.8rem;">
                            {{ $submission->created_at->format('M Y') }}
                        </small>
                    </div>

                    <!-- Title -->
                    <h5 class="card-title line-clamp-2">{{ $submission->title }}</h5>

                    <!-- Meta Data -->
                    <div class="d-flex flex-column gap-2 mb-3 mt-auto">
                        <div class="d-flex align-items-center text-muted small">
                            <i class="bi bi-person me-2"></i>
                            <span class="line-clamp-1">{{ implode(', ', $submission->authors) }}</span>
                        </div>
                        <div class="d-flex align-items-center text-muted small">
                            <i class="bi bi-building me-2"></i>
                            <span>{{ $submission->department }}</span>
                        </div>
                        @if($submission->academic_session)
                        <div class="d-flex align-items-center text-muted small">
                            <i class="bi bi-calendar3 me-2"></i>
                            <span>{{ $submission->academic_session }}</span>
                        </div>
                        @endif
                    </div>

                    <!-- Domains -->
                    <div class="d-flex flex-wrap gap-2 mt-2">
                        @foreach(array_slice($submission->research_domains ?? [], 0, 3) as $domain)
                        <span class="tag-badge">{{ $domain }}</span>
                        @endforeach
                        @if(count($submission->research_domains ?? []) > 3)
                        <span class="tag-badge border-0" style="background: rgba(255,255,255,0.1);">+{{ count($submission->research_domains) - 3 }}</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Detail Modal -->
            <div class="modal fade" id="submissionModal{{ $submission->id }}" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="w-100 pe-4">
                                <div class="mb-3 d-flex gap-2">
                                    <span class="type-badge badge-{{ strtolower($submission->archive_type) }}">
                                        {{ $submission->archive_type }}
                                    </span>
                                    @if($submission->academic_session)
                                    <span class="tag-badge">
                                        <i class="bi bi-calendar3 me-1"></i> {{ $submission->academic_session }}
                                    </span>
                                    @endif
                                </div>
                                <h3 class="modal-title fs-4 fw-bold lh-base">{{ $submission->title }}</h3>
                                <p class="text-muted mb-0 mt-3 d-flex align-items-center gap-2">
                                    <i class="bi bi-person-circle fs-5"></i>
                                    {{ implode(', ', $submission->authors) }}
                                </p>
                            </div>
                            <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-4">
                            <!-- Details Grid -->
                            <div class="row g-3 bg-light p-3 mb-4">
                                <div class="col-md-6">
                                    <label class="text-secondary small text-uppercase fw-semibold mb-1">Department</label>
                                    <div class="fw-medium">{{ $submission->department }}</div>
                                </div>
                                @if($submission->batch)
                                <div class="col-md-6">
                                    <label class="text-secondary small text-uppercase fw-semibold mb-1">Batch</label>
                                    <div class="fw-medium">{{ $submission->batch }}</div>
                                </div>
                                @endif
                                <div class="col-md-6">
                                    <label class="text-secondary small text-uppercase fw-semibold mb-1">Author Role</label>
                                    <div class="fw-medium">{{ $submission->author_role }}</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-secondary small text-uppercase fw-semibold mb-1">Published</label>
                                    <div class="fw-medium">{{ $submission->created_at->format('F d, Y') }}</div>
                                </div>
                            </div>

                            <!-- Domains -->
                            @if(!empty($submission->research_domains))
                            <div class="mb-4">
                                <h6 class="fw-bold mb-3 d-flex align-items-center gap-2">
                                    <i class="bi bi-tags text-primary"></i> Research Domains
                                </h6>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($submission->research_domains as $domain)
                                    <span class="tag-badge">{{ $domain }}</span>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            <!-- Abstract -->
                            @if($submission->abstract)
                            <div class="mb-4">
                                <h6 class="fw-bold mb-3 d-flex align-items-center gap-2">
                                    <i class="bi bi-file-text text-primary"></i> Abstract
                                </h6>
                                <p class="text-muted lh-lg mb-0" style="font-size: 0.95rem; white-space: pre-wrap;">{{ $submission->abstract }}</p>
                            </div>
                            @endif

                            <hr class="border-secondary opacity-25 my-4">

                            <!-- Links -->
                            <div class="mb-1">
                                <h6 class="fw-bold mb-3 d-flex align-items-center gap-2">
                                    <i class="bi bi-link-45deg text-primary"></i> Resources & Links
                                </h6>
                                <div class="d-flex flex-column gap-2">
                                    @if($submission->pdf_url)
                                    <a href="{{ $submission->pdf_url }}" target="_blank" class="btn btn-premium w-100 d-flex justify-content-between align-items-center py-3">
                                        <span><i class="bi bi-file-earmark-pdf me-2"></i> View Full Paper</span>
                                        <i class="bi bi-box-arrow-up-right"></i>
                                    </a>
                                    @endif

                                    @if(!empty($submission->drive_links))
                                        @foreach($submission->drive_links as $index => $link)
                                            @if($link)
                                            <a href="{{ $link }}" target="_blank" class="btn btn-outline-premium w-100 d-flex justify-content-between align-items-center py-2 text-start">
                                                <span><i class="bi bi-cloud-check me-2 text-info"></i> Project Drive Link {{ count($submission->drive_links) > 1 ? ($index + 1) : '' }}</span>
                                                <i class="bi bi-arrow-right"></i>
                                            </a>
                                            @endif
                                        @endforeach
                                    @endif

                                    @if(!empty($submission->external_links))
                                        @foreach($submission->external_links as $link)
                                            @if($link)
                                            <a href="{{ $link }}" target="_blank" class="btn btn-outline-premium w-100 d-flex justify-content-between align-items-center py-2 text-start">
                                                <span class="text-truncate mr-3"><i class="bi bi-globe2 me-2 text-secondary"></i> {{ $link }}</span>
                                            </a>
                                            @endif
                                        @endforeach
                                    @endif
                                    
                                    @if(!$submission->pdf_url && empty($submission->drive_links) && empty($submission->external_links))
                                        <div class="text-secondary small fst-italic py-2"><i class="bi bi-info-circle"></i> No external resources were provided for this research.</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-top-0 d-flex justify-content-between pt-0 pb-4 px-4">
                            <div class="text-secondary" style="font-size: 0.8rem;">
                                Added to archive: {{ $submission->created_at->format('M d, Y') }}
                            </div>
                            <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $submissions->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>