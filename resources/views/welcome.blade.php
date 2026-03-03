<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>UITS Research Archive | Explore the Infinite</title>
    
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
            --primary: #0f172a;
            --accent: #2563eb;
            --accent-glow: rgba(37, 99, 235, 0.4);
            --bg: #ffffff;
            --bg-offset: #f8fafc;
            --text-main: #1e293b;
            --text-muted: #475569; /* Slate 600 - Darker for better visibility */
            --glass: rgba(255, 255, 255, 0.85); /* Slightly more opaque */
            --glass-border: rgba(255, 255, 255, 0.4);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg);
            color: var(--text-main);
            overflow-x: hidden;
            scroll-behavior: smooth;
        }

        h1, h2, h3, h4, h5, h6, .navbar-brand {
            font-family: 'Outfit', sans-serif;
            color: var(--primary);
        }

        /* --- Animations --- */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }

        .animate-float { animation: float 3s ease-in-out infinite; }

        /* --- Navbar --- */
        .navbar {
            background: var(--glass) !important;
            backdrop-filter: blur(12px) saturate(180%);
            border-bottom: 1px solid var(--glass-border);
            padding: 1.25rem 0;
            transition: all 0.3s;
        }

        .nav-link {
            font-weight: 600;
            color: var(--text-main) !important;
            transition: color 0.2s;
            padding: 0.5rem 1.25rem !important;
        }

        .nav-link:hover {
            color: var(--accent) !important;
        }

        /* --- Background Elements --- */
        .bg-blob {
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, var(--accent-glow) 0%, transparent 70%);
            z-index: -1;
            filter: blur(80px);
            border-radius: 50%;
            pointer-events: none;
        }

        .blob-1 { top: -10%; right: -10%; animation: blob 15s infinite; }
        .blob-2 { bottom: 10%; left: -5%; animation: blob 12s infinite alternate; }

        /* --- Hero Section --- */
        .hero {
            position: relative;
            padding: 10rem 0 8rem;
            min-height: 90vh;
            display: flex;
            align-items: center;
        }

        .hero-title {
            font-size: 5rem;
            font-weight: 800;
            line-height: 1;
            letter-spacing: -3px;
            margin-bottom: 2rem;
            background: linear-gradient(135deg, var(--primary) 0%, var(--accent) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-label {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1.5rem;
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 99px;
            font-size: 0.875rem;
            font-weight: 700;
            color: var(--text-muted);
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
        }

        .hero-subtitle {
            font-size: 1.25rem;
            max-width: 650px;
            margin-bottom: 3.5rem;
            color: var(--text-muted);
            line-height: 1.7;
        }

        .hero-img-container {
            position: relative;
            z-index: 1;
        }

        .hero-img-main {
            width: 100%;
            border-radius: 40px;
            box-shadow: 0 40px 80px -20px rgba(0,0,0,0.1);
            border: 1px solid rgba(255,255,255,0.7);
            backdrop-filter: blur(10px);
        }

        /* --- Buttons --- */
        .btn-modern {
            padding: 1rem 2.5rem;
            border-radius: 18px;
            font-weight: 700;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .btn-primary-m {
            background-color: var(--primary);
            color: white;
            border: none;
            box-shadow: 0 20px 25px -10px rgba(15, 23, 42, 0.3);
        }

        .btn-primary-m:hover {
            transform: translateY(-5px) scale(1.05);
            background-color: var(--accent);
            box-shadow: 0 25px 30px -10px var(--accent-glow);
            color: white;
        }

        .btn-outline-m {
            background: white;
            color: var(--primary);
            border: 1px solid #e2e8f0;
        }

        .btn-outline-m:hover {
            transform: translateY(-5px);
            background: #f8fafc;
            border-color: var(--accent);
        }

        /* --- Features --- */
        .features {
            padding: 8rem 0;
            background: #f1f5f9; /* Slate 100 - slightly darker for better card contrast */
        }

        .feature-card {
            background: var(--glass);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 32px;
            padding: 3rem;
            height: 100%;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .feature-card:hover {
            transform: translateY(-15px) scale(1.02);
            border-color: var(--accent);
            box-shadow: 0 30px 60px -15px rgba(0,0,0,0.1);
        }

        .feature-icon-box {
            width: 70px;
            height: 70px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin-bottom: 2rem;
            color: white;
            box-shadow: 0 10px 20px -5px rgba(0,0,0,0.2);
        }

        /* --- Footer --- */
        .footer-premium {
            padding: 6rem 0 3rem;
            background: white;
            border-top: 1px solid #e2e8f0;
        }

        /* --- Responsiveness --- */
        .feature-card p {
            color: #334155 !important; /* Slate 700 - very clear and dark */
            font-size: 1.05rem;
            font-weight: 500;
            line-height: 1.6;
            margin-bottom: 0;
        }

        @media (max-width: 768px) {
            .hero-title { font-size: 3.5rem; letter-spacing: -2px; }
            .hero { text-align: center; padding-top: 8rem; }
            .hero-subtitle { margin-left: auto; margin-right: auto; }
        }
    </style>
</head>
<body>

    <div class="bg-blob blob-1"></div>
    <div class="bg-blob blob-2"></div>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-3" href="{{ url('/') }}">
                <div class="bg-primary text-white rounded-pill p-2 px-3" style="background: var(--primary) !important;">
                    <i class="bi bi-infinity fs-5"></i>
                </div>
                <span class="fw-bold fs-4 tracking-tight">RESEARCH<span class="text-primary-emphasis">HUB</span></span>
            </a>
            
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <i class="bi bi-grid-fill fs-2"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto align-items-center gap-3">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('archive') }}">Browse Archive</a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a href="{{ url('/dashboard') }}" class="btn-modern btn-outline-m py-2 px-4">
                                <i class="bi bi-rocket-takeoff-fill"></i> Dash
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="nav-link">Sign In</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('register') }}" class="btn-modern btn-primary-m py-2 px-4 shadow-none">
                                Join Now
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Hero -->
    <section class="hero">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-7">
                    <div class="hero-label">
                        <i class="bi bi-stars text-warning me-2"></i> Elevating Academic Integrity at UITS
                    </div>
                    <h1 class="hero-title">
                        Preserving the <br>
                        Future of Science.
                    </h1>
                    <p class="hero-subtitle">
                        Experience the next generation of academic discovery. A unified ecosystem for thesis preservation, collaborative research, and scholarly excellence.
                    </p>
                    <div class="d-flex flex-wrap gap-4 justify-content-center justify-content-lg-start">
                        <a href="{{ route('archive') }}" class="btn-modern btn-primary-m">
                            Start Exploring <i class="bi bi-chevron-right fs-small"></i>
                        </a>
                        @auth
                            <a href="{{ route('submissions.create') }}" class="btn-modern btn-outline-m">
                                Submit Work
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="btn-modern btn-outline-m">
                                Create Account
                            </a>
                        @endauth
                    </div>

                    <div class="mt-5 pt-4 d-none d-lg-flex gap-5 text-muted">
                        <div>
                            <div class="fs-2 fw-800 text-dark">500+</div>
                            <div class="small fw-bold">Published Papers</div>
                        </div>
                        <div class="border-start ps-5">
                            <div class="fs-2 fw-800 text-dark">80+</div>
                            <div class="small fw-bold">Expert Reviewers</div>
                        </div>
                        <div class="border-start ps-5">
                            <div class="fs-2 fw-800 text-dark">12k</div>
                            <div class="small fw-bold">Daily Reads</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="hero-img-container">
                        <!-- We use our generated image here -->
                        <div class="animate-float">
                            <div class="hero-img-main overflow-hidden border">
                                <img src="{{ asset('images/hero_bg.png') }}" class="w-100 h-100 object-fit-cover" alt="UITS Research">
                            </div>
                        </div>
                        <!-- Decorative floating card -->
                        <div class="position-absolute d-none d-md-block" style="top: -20px; left: -40px; z-index: 2;">
                            <div class="bg-white p-4 rounded-4 shadow-lg border animate-float" style="animation-delay: 1s;">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-success text-white rounded-circle p-2 px-3">
                                        <i class="bi bi-check-lg"></i>
                                    </div>
                                    <div>
                                        <div class="small text-muted fw-bold">Latest Approval</div>
                                        <div class="fw-bold">AI Ethics in Modern Ed.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Detailed Features -->
    <section class="features">
        <div class="container">
            <div class="text-center mb-5 pb-5">
                <h6 class="text-primary fw-bold text-uppercase tracking-widest mb-3" style="color: #1e40af !important; letter-spacing: 0.15em;">Core Infrastructure</h6>
                <h2 class="display-3 fw-bold" style="color: #0f172a; letter-spacing: -2px;">Engineered for Scholars.</h2>
            </div>
            <div class="row g-4 lg-g-5">
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon-box bg-primary">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Immutable Archiving</h4>
                        <p>Your research is cryptographically indexed and preserved forever. No data loss, only legacy.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon-box" style="background: var(--accent);">
                            <i class="bi bi-lightning-charge-fill"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Accelerated Review</h4>
                        <p>A streamlined workflow between students and faculty, cutting down approval times by 60%.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card">
                        <div class="feature-icon-box bg-dark">
                            <i class="bi bi-search-heart"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Semantic Discovery</h4>
                        <p>Find correlations between research papers with our AI-assisted search and recommendations.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats / Trust -->
    <section class="py-5 overflow-hidden">
        <div class="container py-4">
            <div class="bg-dark rounded-5 p-5 position-relative overflow-hidden text-center text-lg-start">
                <div class="row align-items-center z-1 position-relative">
                    <div class="col-lg-8">
                        <h2 class="text-white display-5 fw-bold mb-3">Ready to contribute to human knowledge?</h2>
                        <p class="text-white opacity-75 fs-5">Join the 1000+ researchers currently publishing at UITS.</p>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <a href="{{ route('register') }}" class="btn-modern btn-primary-m bg-white text-dark py-3 px-5">
                            Create Free Account
                        </a>
                    </div>
                </div>
                <!-- Background visual decoration for dark card -->
                <div class="bg-blob" style="background: radial-gradient(circle, var(--accent) 0%, transparent 60%); top: -50%; right: -20%; opacity: 0.3;"></div>
            </div>
        </div>
    </section>

    <footer class="footer-premium">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-5">
                    <a class="navbar-brand d-flex align-items-center gap-2 mb-4" href="#">
                        <div class="bg-primary text-white rounded-pill p-1 px-3">
                            <i class="bi bi-infinity"></i>
                        </div>
                        <span class="fw-bold fs-5">RESEARCHHUB</span>
                    </a>
                    <p class="text-muted mb-4 opacity-75" style="max-width: 350px;">
                        The official research and thesis repository of UITS. Empowering students and faculty to share knowledge with the world.
                    </p>
                    <div class="d-flex gap-3">
                        <a href="#" class="btn btn-light rounded-circle shadow-sm"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="btn btn-light rounded-circle shadow-sm"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" class="btn btn-light rounded-circle shadow-sm"><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>
                <div class="col-6 col-lg-2 offset-lg-1">
                    <h6 class="fw-bold mb-4">Platform</h6>
                    <ul class="list-unstyled d-grid gap-2 small fw-semibold text-muted">
                        <li><a href="{{ route('archive') }}" class="text-decoration-none text-reset">Research Archive</a></li>
                        <li><a href="#" class="text-decoration-none text-reset">Faculty Portal</a></li>
                        <li><a href="#" class="text-decoration-none text-reset">Student Tools</a></li>
                        <li><a href="#" class="text-decoration-none text-reset">API Docs</a></li>
                    </ul>
                </div>
                <div class="col-6 col-lg-2">
                    <h6 class="fw-bold mb-4">Resources</h6>
                    <ul class="list-unstyled d-grid gap-2 small fw-semibold text-muted">
                        <li><a href="#" class="text-decoration-none text-reset">Privacy Policy</a></li>
                        <li><a href="#" class="text-decoration-none text-reset">Terms of Service</a></li>
                        <li><a href="#" class="text-decoration-none text-reset">Submission Guide</a></li>
                        <li><a href="#" class="text-decoration-none text-reset">Help Center</a></li>
                    </ul>
                </div>
                <div class="col-lg-2">
                    <h6 class="fw-bold mb-4">Contact</h6>
                    <ul class="list-unstyled d-grid gap-2 small fw-semibold text-muted">
                        <li><i class="bi bi-envelope me-2"></i> info@uits.edu</li>
                        <li><i class="bi bi-geo-alt me-2"></i> Dhaka, Bangladesh</li>
                    </ul>
                </div>
            </div>
            <div class="mt-5 pt-5 border-top text-center text-muted small fw-bold">
                &copy; {{ date('Y') }} UITS Research Archive. Designed with <i class="bi bi-heart-fill text-danger mx-1"></i> for Academic Excellence.
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
