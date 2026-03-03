<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>UITS Research Archive</title>
    
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
            --primary-glow: rgba(99, 102, 241, 0.4);
            --secondary-glow: rgba(168, 85, 247, 0.4);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #0f1115;
            color: #f8fafc;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
            position: relative;
        }

        h1, h2, h3, h4, h5, h6, .navbar-brand {
            font-family: 'Outfit', sans-serif;
        }

        /* Abstract Background Elements */
        .bg-orb-1 {
            position: absolute;
            top: -10%;
            left: -10%;
            width: 50vw;
            height: 50vw;
            background: radial-gradient(circle, var(--primary-glow) 0%, transparent 60%);
            border-radius: 50%;
            z-index: -1;
            filter: blur(60px);
            animation: float 15s infinite ease-in-out alternate;
        }

        .bg-orb-2 {
            position: absolute;
            bottom: -20%;
            right: -10%;
            width: 60vw;
            height: 60vw;
            background: radial-gradient(circle, var(--secondary-glow) 0%, transparent 60%);
            border-radius: 50%;
            z-index: -1;
            filter: blur(80px);
            animation: float 20s infinite ease-in-out alternate-reverse;
        }

        @keyframes float {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(5%, 10%) scale(1.1); }
        }

        /* Glassmorphism Navbar */
        .navbar {
            background: rgba(15, 17, 21, 0.7) !important;
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            padding: 1rem 0;
            transition: all 0.3s ease;
        }
        
        .nav-link {
            color: rgba(255, 255, 255, 0.8) !important;
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .nav-link:hover {
            color: #fff !important;
            transform: translateY(-2px);
        }

        /* Hero Section */
        .hero-section {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: calc(100vh - 76px);
            padding: 4rem 0;
        }

        .hero-title {
            font-size: 4.5rem;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, #fff 0%, #a5b4fc 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: slideUp 0.8s ease-out forwards;
            opacity: 0;
            transform: translateY(30px);
        }

        .hero-subtitle {
            font-size: 1.25rem;
            color: #94a3b8;
            font-weight: 400;
            margin-bottom: 2.5rem;
            max-width: 600px;
            animation: slideUp 0.8s ease-out 0.2s forwards;
            opacity: 0;
            transform: translateY(30px);
        }

        @keyframes slideUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Premium Buttons */
        .btn-premium {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            color: white;
            border: none;
            padding: 0.8rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 15px rgba(99, 102, 241, 0.3);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-premium::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(255,255,255,0.2) 0%, transparent 100%);
            opacity: 0;
            transition: opacity 0.3s;
        }

        .btn-premium:hover {
            color: white;
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.4);
        }

        .btn-premium:hover::after {
            opacity: 1;
        }

        .btn-outline-premium {
            background: rgba(255, 255, 255, 0.03);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 0.8rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-outline-premium:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 255, 255, 0.2);
            color: white;
            transform: translateY(-3px);
        }

        /* Glass Cards for features */
        .feature-card {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 20px;
            padding: 2rem;
            backdrop-filter: blur(10px);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            height: 100%;
            animation: fadeIn 1s ease-out 0.4s forwards;
            opacity: 0;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            background: rgba(255, 255, 255, 0.04);
            border-color: rgba(255, 255, 255, 0.1);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }

        .feature-icon {
            width: 50px;
            height: 50px;
            border-radius: 15px;
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.2) 0%, rgba(139, 92, 246, 0.2) 100%);
            color: #a5b4fc;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            transition: transform 0.3s ease;
        }

        .feature-card:hover .feature-icon {
            transform: scale(1.1) rotate(5deg);
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .btn-wrapper {
            animation: slideUp 0.8s ease-out 0.3s forwards;
            opacity: 0;
            transform: translateY(30px);
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 3rem;
            }
            .feature-card {
                margin-bottom: 1rem;
            }
        }
    </style>
</head>
<body>

    <!-- Background Orbs -->
    <div class="bg-orb-1"></div>
    <div class="bg-orb-2"></div>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2 text-white" href="{{ url('/') }}">
                <div class="bg-primary text-white rounded p-1" style="background: linear-gradient(135deg, #6366f1, #8b5cf6) !important;">
                    <i class="bi bi-book-half fs-5"></i>
                </div>
                <span class="fw-bold fs-5">UITS Research Archive</span>
            </a>
            
            <button class="navbar-toggler border-0 px-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <i class="bi bi-list fs-1 text-white"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center gap-2">
                    <li class="nav-item">
                        <a class="nav-link px-3" href="{{ route('archive') }}">Explore Archive</a>
                    </li>
                    
                    @if (Route::has('login'))
                        @auth
                            <li class="nav-item ms-lg-2">
                                <a href="{{ url('/dashboard') }}" class="btn btn-outline-premium btn-sm py-2 px-4 shadow-none">
                                    <i class="bi bi-speedometer2"></i> Dashboard
                                </a>
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

    <!-- Hero Section -->
    <main class="hero-section">
        <div class="container text-center text-lg-start">
            <div class="row align-items-center min-vh-75 mt-5">
                <div class="col-lg-6 mb-5 mb-lg-0 position-relative z-1">
                    <div class="badge bg-transparent border border-secondary text-secondary rounded-pill px-3 py-2 mb-4" style="backdrop-filter: blur(5px); animation: fadeIn 0.8s ease-out;">
                        <i class="bi bi-stars text-warning me-1"></i> The Future of Academic Discovery
                    </div>
                    <h1 class="hero-title">
                        Discover & Share<br>
                        Brilliant Research.
                    </h1>
                    <p class="hero-subtitle mb-5 mx-auto mx-lg-0">
                        The ultimate central repository for thesis, capstone projects, and articles from the brilliant minds at UITS. Upload, search, and preserve knowledge forever.
                    </p>
                    <div class="d-flex flex-column flex-sm-row gap-3 btn-wrapper justify-content-center justify-content-lg-start">
                        <a href="{{ route('archive') }}" class="btn btn-premium btn-lg">
                            Explore Archive <i class="bi bi-arrow-right"></i>
                        </a>
                        @guest
                            <a href="{{ route('register') }}" class="btn btn-outline-premium btn-lg">
                                Submit Research
                            </a>
                        @endguest
                        @auth
                            <a href="{{ route('submissions.create') }}" class="btn btn-outline-premium btn-lg">
                                Submit Research
                            </a>
                        @endauth
                    </div>
                </div>

                <div class="col-lg-5 offset-lg-1 position-relative z-1">
                    <div class="row g-4">
                        <div class="col-sm-6">
                            <div class="feature-card">
                                <div class="feature-icon">
                                    <i class="bi bi-search"></i>
                                </div>
                                <h4 class="fw-bold fs-5 text-white mb-2">Smart Search</h4>
                                <p class="text-secondary small mb-0">Quickly find specific papers, authors, or topics using our intelligent semantic search engine.</p>
                            </div>
                        </div>
                        <div class="col-sm-6" style="margin-top: 2rem;">
                            <div class="feature-card">
                                <div class="feature-icon" style="background: linear-gradient(135deg, rgba(236, 72, 153, 0.2) 0%, rgba(244, 63, 94, 0.2) 100%); color: #fda4af;">
                                    <i class="bi bi-shield-check"></i>
                                </div>
                                <h4 class="fw-bold fs-5 text-white mb-2">Peer Reviewed</h4>
                                <p class="text-secondary small mb-0">All submissions are reviewed by our dedicated faculty members ensuring high quality standards.</p>
                            </div>
                        </div>
                        <div class="col-sm-6" style="margin-top: -1rem;">
                            <div class="feature-card">
                                <div class="feature-icon" style="background: linear-gradient(135deg, rgba(16, 185, 129, 0.2) 0%, rgba(5, 150, 105, 0.2) 100%); color: #6ee7b7;">
                                    <i class="bi bi-cloud-arrow-up"></i>
                                </div>
                                <h4 class="fw-bold fs-5 text-white mb-2">Permanent Storage</h4>
                                <p class="text-secondary small mb-0">Your hard work is preserved permanently. Link your PDFs safely inside the UITS Archive.</p>
                            </div>
                        </div>
                        <div class="col-sm-6" style="margin-top: 1rem;">
                            <div class="feature-card">
                                <div class="feature-icon" style="background: linear-gradient(135deg, rgba(245, 158, 11, 0.2) 0%, rgba(217, 119, 6, 0.2) 100%); color: #fcd34d;">
                                    <i class="bi bi-globe2"></i>
                                </div>
                                <h4 class="fw-bold fs-5 text-white mb-2">Global Access</h4>
                                <p class="text-secondary small mb-0">Share your published articles and thesis papers easily via secure public links to anyone, anywhere.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
