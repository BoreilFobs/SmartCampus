{{-- Navigation Component --}}
<nav class="navbar navbar-expand-lg navbar-dark bg-gradient-primary sticky-top shadow-lg" id="mainNav">
    <div class="container-fluid px-4">
        {{-- Brand Logo --}}
        <a class="navbar-brand d-flex align-items-center fw-bold" href="{{ route('home') }}">
            <i class="bi bi-mortarboard-fill me-2 fs-4 text-warning"></i>
            <span class="brand-text">Smart<span class="text-warning">Campus</span></span>
        </a>
        
        {{-- Mobile Toggle Button --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        {{-- Navigation Links --}}
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                        <i class="bi bi-house-door me-1"></i> Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}#levels">
                        <i class="bi bi-collection me-1"></i> Courses
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}#about">
                        <i class="bi bi-info-circle me-1"></i> About
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}#contact">
                        <i class="bi bi-envelope me-1"></i> Contact
                    </a>
                </li>
                
                @auth
                    @if(auth()->user()->is_admin)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-speedometer2 me-1"></i> Dashboard
                            </a>
                        </li>
                    @endif
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" 
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle me-1"></i> {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i> Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-outline-light btn-sm" href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Login
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

@push('styles')
<style>
    /* Navigation Styles */
    #mainNav {
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    }
    
    #mainNav.scrolled {
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }
    
    .navbar-brand {
        font-size: 1.5rem;
        transition: transform 0.3s ease;
    }
    
    .navbar-brand:hover {
        transform: scale(1.05);
    }
    
    .brand-text {
        font-weight: 800;
        letter-spacing: -0.5px;
    }
    
    .nav-link {
        position: relative;
        padding: 0.5rem 1rem !important;
        transition: all 0.3s ease;
        font-weight: 500;
    }
    
    .nav-link::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        width: 0;
        height: 2px;
        background: #ffc107;
        transition: all 0.3s ease;
        transform: translateX(-50%);
    }
    
    .nav-link:hover::after,
    .nav-link.active::after {
        width: 80%;
    }
    
    .nav-link:hover,
    .nav-link.active {
        color: #ffc107 !important;
    }
    
    .dropdown-menu {
        border: none;
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        border-radius: 8px;
        margin-top: 0.5rem;
    }
    
    .dropdown-item {
        padding: 0.5rem 1rem;
        transition: all 0.3s ease;
    }
    
    .dropdown-item:hover {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    @media (max-width: 991px) {
        .nav-link::after {
            display: none;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Navbar scroll effect
    window.addEventListener('scroll', function() {
        const navbar = document.getElementById('mainNav');
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });
</script>
@endpush
