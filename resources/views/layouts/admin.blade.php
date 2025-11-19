<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ sidebarOpen: false }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SmartCampus') }} - Admin Panel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        body {
            font-family: 'Figtree', sans-serif;
        }
        .nav-link.active {
            background-color: rgba(0, 0, 0, 0.1) !important;
            font-weight: 600;
        }
        .nav-link:hover {
            background-color: rgba(0, 0, 0, 0.05);
            border-radius: 0.375rem;
        }
        main {
            margin-left: 0;
            transition: margin-left 0.3s ease;
        }
        @media (min-width: 992px) {
            main {
                margin-left: 250px;
            }
            aside {
                position: relative !important;
                width: 250px;
                margin-top: 0 !important;
                transform: none !important;
                display: block !important;
            }
            .overlay {
                display: none !important;
            }
            .navbar-toggler {
                display: none !important;
            }
        }
        @media (max-width: 991.98px) {
            aside {
                position: fixed;
                left: -250px;
                transition: left 0.3s ease-in-out;
                z-index: 1020;
            }
            aside.show {
                left: 0;
            }
            .sidebar-scroll {
                max-height: calc(100vh - 56px);
            }
        }
        
        /* Responsive padding and margins */
        @media (max-width: 576px) {
            .navbar-brand {
                font-size: 1rem;
            }
            .container-fluid {
                padding: 0.5rem;
            }
        }
        
        /* Smooth transitions */
        .transition-all {
            transition: all 0.3s ease;
        }
    </style>
</head>
<body class="bg-light">
    <div class="d-flex flex-column min-vh-100">
        <!-- Admin Navigation -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom border-secondary sticky-top">
            <div class="container-fluid px-2 px-sm-3">
                <!-- Mobile menu button -->
                <button @click="sidebarOpen = !sidebarOpen" class="navbar-toggler" type="button" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Logo -->
                <a href="{{ route('admin.dashboard') }}" class="navbar-brand ms-2 ms-sm-0 fw-bold">
                    <i class="bi bi-mortarboard-fill me-2"></i><span class="d-none d-sm-inline">SmartCampus</span> Admin
                </a>

                <!-- Settings Dropdown -->
                <div class="ms-auto d-flex align-items-center gap-2">
                    <span class="text-muted text-sm me-2 d-none d-lg-block small">{{ Auth::user()->name }}</span>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-light dropdown-toggle" type="button" id="adminDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle me-1"></i><span class="d-none d-sm-inline">{{ Auth::user()->name }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="adminDropdown">
                            <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>{{ __('User Dashboard') }}</a></li>
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-person-gear me-2"></i>{{ __('Profile') }}</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                    @csrf
                                    <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); this.closest('form').submit();">
                                        <i class="bi bi-box-arrow-left me-2"></i>{{ __('Log Out') }}
                                    </a>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <div class="d-flex flex-row flex-grow-1">
            <!-- Sidebar -->
            <aside class="bg-white shadow-sm position-fixed position-lg-relative top-0 start-0 h-100 sidebar-scroll"
                   :class="sidebarOpen ? 'show' : ''"
                   style="width: 250px; z-index: 1020; overflow-y: auto; transition: transform 0.3s ease-in-out; margin-top: 0;"
                   @click.away="sidebarOpen = false">
                <nav class="nav flex-column p-3">
                    <!-- Dashboard -->
                    <a href="{{ route('admin.dashboard') }}" 
                       class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : 'text-dark' }} mb-2 rounded d-flex align-items-center">
                        <i class="bi bi-house-fill me-2"></i>Dashboard
                    </a>

                    <!-- Divider -->
                    <div class="border-top border-secondary my-2"></div>
                    <small class="text-secondary fw-bold text-uppercase ms-2 d-block my-2">Content Management</small>

                    <!-- Levels Management -->
                    <a href="{{ route('admin.levels.index') }}" 
                       class="nav-link {{ request()->routeIs('admin.levels.*') ? 'active' : 'text-dark' }} mb-2 rounded d-flex align-items-center">
                        <i class="bi bi-bookmark-fill me-2"></i>Manage Levels
                    </a>

                    <!-- Courses Management -->
                    <a href="{{ route('admin.courses.index') }}" 
                       class="nav-link {{ request()->routeIs('admin.courses.*') ? 'active' : 'text-dark' }} mb-2 rounded d-flex align-items-center">
                        <i class="bi bi-book-fill me-2"></i>Manage Courses
                    </a>

                    <!-- Videos Management -->
                    <a href="{{ route('admin.videos.index') }}" 
                       class="nav-link {{ request()->routeIs('admin.videos.*') ? 'active' : 'text-dark' }} mb-2 rounded d-flex align-items-center">
                        <i class="bi bi-film me-2"></i>Manage Videos
                    </a>

                    <!-- Notes Management -->
                    <a href="{{ route('admin.notes.index') }}" 
                       class="nav-link {{ request()->routeIs('admin.notes.*') ? 'active' : 'text-dark' }} mb-2 rounded d-flex align-items-center">
                        <i class="bi bi-file-earmark-text-fill me-2"></i>Manage Notes
                    </a>

                    <!-- Class Bookings Management -->
                    <a href="{{ route('admin.bookings.index') }}" 
                       class="nav-link {{ request()->routeIs('admin.bookings.*') ? 'active' : 'text-dark' }} mb-2 rounded d-flex align-items-center">
                        <i class="bi bi-calendar-check-fill me-2"></i>Class Bookings
                    </a>

                    <!-- Divider -->
                    <div class="border-top border-secondary my-2"></div>
                    <small class="text-secondary fw-bold text-uppercase ms-2 d-block my-2">Quick Actions</small>

                    <!-- Add Course -->
                    <a href="{{ route('admin.courses.create') }}" 
                       class="nav-link text-dark mb-2 rounded d-flex align-items-center" style="color: #0d6efd !important;">
                        <i class="bi bi-plus-circle-fill me-2"></i>Add New Course
                    </a>

                    <!-- Upload Video -->
                    <a href="{{ route('admin.videos.create') }}" 
                       class="nav-link text-dark mb-2 rounded d-flex align-items-center" style="color: #198754 !important;">
                        <i class="bi bi-cloud-upload-fill me-2"></i>Upload Video
                    </a>

                    <!-- Create Note -->
                    <a href="{{ route('admin.notes.create') }}" 
                       class="nav-link text-dark mb-2 rounded d-flex align-items-center" style="color: #0dcaf0 !important;">
                        <i class="bi bi-pencil-square me-2"></i>Create Note
                    </a>

                    <!-- Divider -->
                    <div class="border-top border-secondary my-2"></div>
                    <small class="text-secondary fw-bold text-uppercase ms-2 d-block my-2">System</small>

                    <!-- Users Management -->
                    <a href="#" 
                       class="nav-link text-dark mb-2 rounded d-flex align-items-center">
                        <i class="bi bi-people-fill me-2"></i>Users
                    </a>

                    <!-- Settings -->
                    <a href="#" 
                       class="nav-link text-dark mb-2 rounded d-flex align-items-center">
                        <i class="bi bi-gear-fill me-2"></i>Settings
                    </a>

                    <!-- Storage Info -->
                    <div class="bg-light rounded p-3 mt-4">
                        <small class="fw-bold text-secondary text-uppercase">Storage Usage</small>
                        <div class="d-flex justify-content-between small mt-2">
                            <span class="text-muted">Used</span>
                            <span class="fw-bold">0 GB</span>
                        </div>
                        <div class="progress mt-2" style="height: 6px;">
                            <div class="progress-bar bg-primary" style="width: 0%"></div>
                        </div>
                        <small class="text-muted">Unlimited</small>
                    </div>
                </nav>
            </aside>

            <!-- Overlay for mobile -->
            <div class="overlay position-fixed top-0 start-0 w-100 h-100 bg-dark bg-opacity-50"
                 x-show="sidebarOpen"
                 @click="sidebarOpen = false"
                 style="z-index: 1010; display: none; transition: opacity 0.3s ease-in-out;"
                 @click.away="sidebarOpen = false">
            </div>

            <!-- Main Content Area -->
            <main class="flex-grow-1">
                <!-- Page Heading -->
                @hasSection('header')
                    <header class="bg-white shadow-sm py-4 px-4 border-bottom">
                        <div class="container-fluid">
                            @yield('header')
                        </div>
                    </header>
                @endif

                <!-- Page Content -->
                <div class="container-fluid py-3 py-md-4 px-2 px-sm-3 px-md-4">
                    <!-- Display Success/Error Messages -->
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <strong>Success!</strong> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                            <i class="bi bi-exclamation-circle-fill me-2"></i>
                            <strong>Error!</strong> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Alpine JS -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>
</html>

