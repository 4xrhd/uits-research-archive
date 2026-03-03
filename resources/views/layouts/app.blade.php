<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'UITS Research Archive') }}</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        :root {
            --primary-color: #0f172a; /* Slate 900 */
            --primary-light: #334155; /* Slate 700 */
            --accent-color: #2563eb; /* Blue 600 */
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --bg-body: #ffffff;
            --bg-alt: #f8fafc;
            --border-color: #e2e8f0;
            --text-main: #1e293b;
            --text-muted: #4b5563; /* Darkened from #64748b for better visibility */
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            min-height: 100vh;
            line-height: 1.6;
        }

        /* Hero Section - Clean White Style */
        .hero-section {
            background-color: var(--bg-alt);
            border-bottom: 1px solid var(--border-color);
            color: var(--text-main);
            padding: 5rem 0;
        }

        .hero-icon {
            width: 72px;
            height: 72px;
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 1.25rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            color: var(--accent-color);
            font-size: 1.75rem;
        }

        /* Cards - Modern Minimalist */
        .card {
            border: 1px solid var(--border-color);
            background: white;
            border-radius: 1rem;
            box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card:hover {
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1);
            transform: translateY(-2px);
            border-color: var(--accent-color);
        }

        .archive-card {
            cursor: pointer;
            height: 100%;
        }

        /* Badges - Subtle Colors */
        .badge {
            font-weight: 500;
            padding: 0.4em 0.8em;
            border-radius: 6px;
        }

        .badge-research { background-color: #eff6ff; color: #1e40af; }
        .badge-article { background-color: #faf5ff; color: #6b21a8; }
        .badge-capstone { background-color: #fffaf5; color: #9a3412; }
        .badge-thesis { background-color: #f5f3ff; color: #3730a3; }
        .badge-approved { background-color: #ecfdf5; color: #065f46; }
        .badge-pending { background-color: #fffbeb; color: #92400e; }
        .badge-rejected { background-color: #fef2f2; color: #991b1b; }

        /* Search Box */
        .search-box {
            background: white;
            border: 1px solid var(--border-color);
            border-radius: 1.25rem;
            padding: 1.5rem;
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1);
            margin-top: -3rem;
        }

        .form-control {
            border-radius: 0.75rem;
            border: 1px solid var(--border-color);
            padding: 0.75rem 1rem;
        }

        .form-control:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }

        /* Buttons */
        .btn {
            padding: 0.6rem 1.2rem;
            border-radius: 0.75rem;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-primary {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
        }

        .btn-primary:hover {
            background-color: #1d4ed8;
            border-color: #1d4ed8;
            transform: translateY(-1px);
        }

        /* Stats Cards */
        .stat-card { border: 1px solid var(--border-color); }
        .stat-card-success { border-top: 3px solid var(--success-color); }
        .stat-card-warning { border-top: 3px solid var(--warning-color); }
        .stat-card-danger { border-top: 3px solid var(--danger-color); }

        /* Navigation */
        .navbar {
            background-color: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(8px);
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 0;
        }

        .navbar-brand {
            font-weight: 800;
            letter-spacing: -0.025em;
            color: var(--primary-color);
        }

        /* Footer */
        footer {
            background-color: var(--bg-alt);
            border-top: 1px solid var(--border-color);
            padding: 4rem 0;
            margin-top: 6rem;
        }

        /* Utilities */
        .text-muted { color: #4b5563 !important; } /* Hardcoded darker value for utility class */
        .bg-light { background-color: var(--bg-alt) !important; }
        
        .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ url('/') }}">
                <div class="bg-primary text-white rounded p-1" style="background: var(--accent-color) !important;">
                    <i class="bi bi-book-half fs-5"></i>
                </div>
                <span class="fw-bold fs-5">UITS Archive</span>
            </a>
            
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <i class="bi bi-list fs-2 text-dark"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center gap-3">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('archive') }}">Explore Archive</a>
                    </li>
                    
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}">My Desk</a>
                        </li>
                        
                        @if(auth()->user()->role === 'admin')
                            <li class="nav-item">
                                <a class="nav-link fw-bold text-primary" href="{{ route('admin.dashboard') }}">
                                    <i class="bi bi-shield-lock me-1"></i> Admin Panel
                                </a>
                            </li>
                        @endif

                        <li class="nav-item ms-lg-2 dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 border rounded-pill px-3 py-1" href="#" role="button" data-bs-toggle="dropdown">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 24px; height: 24px; font-size: 0.7rem;">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <span class="small">{{ auth()->user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow rounded-4 mt-2">
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger py-2">
                                            <i class="bi bi-box-arrow-right me-2"></i> Log out
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item ms-lg-2">
                            <a href="{{ route('login') }}" class="nav-link px-3">Log in</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('register') }}" class="btn btn-primary btn-sm px-4 rounded-pill">Sign up</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <!-- Simple Footer -->
    <footer class="py-5 mt-auto">
        <div class="container text-center">
            <div class="mb-4">
                <div class="d-inline-flex align-items-center gap-2 mb-2">
                    <div class="bg-primary text-white rounded p-1" style="background: var(--accent-color) !important;">
                        <i class="bi bi-book-half fs-6"></i>
                    </div>
                    <span class="fw-bold fs-6">UITS Research Archive</span>
                </div>
                <p class="text-muted small">Preserving knowledge and research for future generations.</p>
            </div>
            <div class="text-muted small">
                &copy; {{ date('Y') }} University of Information Technology and Sciences. All rights reserved.
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')
</body>
</html>
