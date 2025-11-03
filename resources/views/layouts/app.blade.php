<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'SmartCampus - Learn Anytime, Anywhere')</title>
    <meta name="description" content="@yield('description', 'SmartCampus - Your premier online learning platform for HND and Bachelor students. Watch courses, read summaries, and learn at your own pace.')">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #4a9eff;
            --secondary-color: #4a9eff;
            --accent-color: #6c757d;
            --dark-bg: #1a1a1a;
            --card-bg: #2d2d2d;
            --dark-light: #3a3a3a;
            --text-primary: #e0e0e0;
            --text-secondary: #a0a0a0;
            --border-color: #444444;
            --success-color: #6fa86f;
            --warning-color: #d4a56a;
            --danger-color: #c97070;
        }
        
        * {
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background-color: var(--dark-bg);
            color: var(--text-primary);
            overflow-x: hidden;
        }
        
        /* Navigation Styles */
        .navbar {
            background: #1a1a1a;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
            padding: 0.5rem 1rem;
            border-bottom: 1px solid var(--border-color);
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.3rem;
            color: #4a9eff !important;
        }
        
        .nav-link {
            color: var(--text-secondary) !important;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .nav-link:hover,
        .nav-link.active {
            color: #4a9eff !important;
        }
        
        /* Sidebar Styles */
        .sidebar {
            background: #1a1a1a;
            min-height: 100vh;
            padding: 2rem 1rem;
            position: fixed;
            left: 0;
            top: 0;
            width: 250px;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.3);
            z-index: 100;
            border-right: 1px solid var(--border-color);
        }
        
        .sidebar-content {
            margin-top: 1rem;
        }
        
        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .sidebar-menu li {
            margin-bottom: 0.5rem;
        }
        
        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: var(--text-secondary);
            text-decoration: none;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background-color: #3a3a3a;
            color: #4a9eff;
        }
        
        /* Mobile Tabs */
        .mobile-tabs {
            background: var(--card-bg);
            border-bottom: 2px solid var(--border-color);
            position: sticky;
            top: 56px;
            z-index: 90;
            display: none;
        }
        
        .mobile-tabs .nav-link {
            color: var(--text-secondary) !important;
            font-weight: 600;
            border-bottom: 3px solid transparent;
            margin-bottom: -2px;
        }
        
        .mobile-tabs .nav-link.active {
            color: #4a9eff !important;
            border-bottom-color: #4a9eff;
        }
        
        /* Main Content */
        .main-content {
            margin-left: 250px;
            padding: 2rem;
        }
        
        /* Cards */
        .card {
            border: 1px solid var(--border-color);
            border-radius: 0.75rem;
            background-color: var(--card-bg);
            color: var(--text-primary);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
        }
        
        .card:hover {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.4);
            transform: translateY(-2px);
            border-color: #4a9eff;
        }
        
        .card-header {
            background: #3a3a3a;
            color: var(--text-primary);
            border: none;
            font-weight: 600;
            border-bottom: 1px solid var(--border-color);
        }
        
        .card-body {
            color: var(--text-primary);
        }
        
        .card-footer {
            background-color: #252525;
            border-top: 1px solid var(--border-color);
        }
        
        /* Buttons */
        .btn-primary {
            background: #4a9eff;
            border: none;
            font-weight: 600;
            padding: 0.6rem 1.5rem;
            transition: all 0.3s ease;
            color: white;
        }
        
        .btn-primary:hover {
            background: #3d8ce0;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            color: white;
        }
        
        .btn-outline-primary {
            color: #4a9eff;
            border: 1px solid #4a9eff;
        }
        
        .btn-outline-primary:hover {
            background-color: #4a9eff;
            border-color: #4a9eff;
            color: white;
        }
        
        /* Badges */
        .badge-primary {
            background: #4a9eff;
        }
        
        /* Hero Section */
        .hero-section {
            background: #3a3a3a;
            color: white;
            padding: 4rem 2rem;
            text-align: center;
            border-radius: 1rem;
            margin-bottom: 3rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }
        
        .hero-section h1 {
            font-weight: 700;
            font-size: clamp(1.5rem, 5vw, 2.5rem);
            margin-bottom: 1rem;
            color: white;
        }
        
        .hero-section p {
            font-size: 1.1rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }
        
        /* Course Grid */
        .course-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2rem;
            margin: 2rem 0;
        }
        
        .course-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 0.75rem;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
            color: var(--text-primary);
        }
        
        .course-card:hover {
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.4);
            transform: translateY(-4px);
            border-color: #4a9eff;
        }
        
        .course-card-header {
            height: 180px;
            background: #3a3a3a;
            position: relative;
            overflow: hidden;
        }
        
        .course-card-header img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .course-card-body {
            padding: 1.5rem;
        }
        
        .course-card-title {
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
            color: var(--text-primary);
        }
        
        .course-card-desc {
            font-size: 0.9rem;
            color: var(--text-secondary);
            margin-bottom: 1rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .course-stats {
            display: flex;
            justify-content: space-between;
            font-size: 0.85rem;
            color: var(--text-secondary);
            padding-top: 1rem;
            border-top: 1px solid var(--border-color);
        }
        
        /* Video Player Container */
        .video-container {
            position: relative;
            width: 100%;
            padding-bottom: 56.25%; /* 16:9 aspect ratio */
            height: 0;
            overflow: hidden;
            border-radius: 0.75rem;
            margin-bottom: 2rem;
            background: #000;
        }
        
        .video-container video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
        
        /* Playlist Styles */
        .playlist-item {
            padding: 1rem;
            background: #3a3a3a;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            margin-bottom: 0.75rem;
            cursor: pointer;
            transition: all 0.3s ease;
            color: var(--text-primary);
        }
        
        .playlist-item:hover {
            background: var(--card-bg);
            border-color: #4a9eff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        }
        
        .playlist-item.active {
            background: var(--card-bg);
            border-color: #4a9eff;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.4);
        }
        
        .playlist-item-title {
            font-weight: 600;
            margin-bottom: 0.25rem;
            color: var(--text-primary);
        }
        
        .playlist-item-duration {
            font-size: 0.85rem;
            color: var(--text-secondary);
        }
        
        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }
        
        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .slide-in-down {
            animation: slideInDown 0.4s ease-out;
        }
        
        /* Loading Skeleton */
        .skeleton {
            background: linear-gradient(90deg, #3a3a3a 25%, #4a4a4a 50%, #3a3a3a 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
        }
        
        @keyframes loading {
            0% {
                background-position: 200% 0;
            }
            100% {
                background-position: -200% 0;
            }
        }
        
        /* Alerts */
        .alert {
            border: 1px solid var(--border-color);
            background-color: var(--dark-light);
            color: var(--text-primary);
        }
        
        .alert-success {
            border-color: var(--success-color);
            color: var(--success-color);
        }
        
        .alert-danger {
            border-color: var(--danger-color);
            color: var(--danger-color);
        }
        
        .alert-warning {
            border-color: var(--warning-color);
            color: var(--warning-color);
        }
        
        /* Forms */
        .form-control,
        .form-select {
            background-color: var(--dark-light);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
        }
        
        .form-control:focus,
        .form-select:focus {
            background-color: var(--dark-light);
            border-color: var(--primary-color);
            color: var(--text-primary);
            box-shadow: 0 0 0 0.2rem rgba(0, 212, 255, 0.25);
        }
        
        .form-control::placeholder {
            color: var(--text-secondary);
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }
            
            .main-content {
                margin-left: 0;
                padding: 1rem;
            }
            
            .mobile-tabs {
                display: block;
            }
            
            .hero-section {
                padding: 2rem 1rem;
                margin-bottom: 2rem;
            }
            
            .hero-section h1 {
                font-size: 1.5rem;
            }
            
            .course-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }
            
            .navbar {
                padding: 0.5rem 0.5rem;
            }
            
            .navbar-brand {
                font-size: 1rem;
            }
        }
        
        /* Footer */
        footer {
            background: #1a1a1a;
            color: var(--text-primary);
            padding: 2rem;
            margin-top: 3rem;
            text-align: center;
            border-top: 1px solid var(--border-color);
        }
        
        footer a {
            color: #4a9eff;
            text-decoration: none;
        }
        
        footer a:hover {
            text-decoration: underline;
        }
        
        /* Utility Classes */
        .text-gradient {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .gradient-border {
            border: 2px solid;
            border-image: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%) 1;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="bi bi-book-fill"></i> SmartCampus
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <span class="nav-link text-white">Welcome, {{ Auth::user()->name }}</span>
                        </li>
                        @if(Auth::user()->is_admin)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">Admin</a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="nav-link btn btn-link">Logout</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-light text-primary ms-2" href="{{ route('register') }}">Register</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Mobile Tabs (shown only on mobile) -->
    <div class="mobile-tabs d-lg-none">
        <ul class="nav nav-tabs border-0" role="tablist">
            @yield('mobile_tabs')
        </ul>
    </div>
    
    <!-- Desktop Sidebar (shown only on desktop) -->
    <div class="sidebar d-none d-lg-block">
        <div class="sidebar-brand mb-3">
            <h5 class="text-white mb-0">
                <i class="bi bi-book-fill"></i> SmartCampus
            </h5>
        </div>
        <nav class="sidebar-content">
            <ul class="sidebar-menu">
                <li><a href="{{ route('home') }}" class="active"><i class="bi bi-house-door"></i> Home</a></li>
                <li><a href="#courses"><i class="bi bi-collection"></i> Courses</a></li>
                <li><a href="#levels"><i class="bi bi-layers"></i> Levels</a></li>
                <li><a href="#categories"><i class="bi bi-tags"></i> Categories</a></li>
            </ul>
        </nav>
    </div>
    
    <!-- Main Content -->
    <div class="main-content">
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong>
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        @yield('content')
    </div>
    
    <!-- Footer -->
    <footer>
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} SmartCampus. All rights reserved.</p>
            <p class="small mt-2">Making education accessible to all students worldwide.</p>
        </div>
    </footer>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add smooth scroll behavior
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({ behavior: 'smooth' });
                    }
                });
            });
            
            // Add animation classes
            const elements = document.querySelectorAll('[data-animate]');
            const observer = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('fade-in-up');
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1 });
            
            elements.forEach(el => observer.observe(el));
        });
    </script>
    
    @stack('scripts')
</body>
</html>
