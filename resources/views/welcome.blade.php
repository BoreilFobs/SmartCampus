@extends('layouts.app')

@section('title', 'SmartCampus - Your Premier Online Learning Platform')

@section('description', 'Explore our comprehensive online learning platform with courses for HND and Bachelor students. Watch videos, read summaries, and master your subjects at your own pace.')

@section('content')
<style>
    .hero-banner {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 1rem;
        padding: 3rem 2rem;
        text-align: center;
        color: white;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }
    
    .stat-card {
        background: var(--card-bg);
        border: 2px solid var(--border-color);
        border-radius: 1rem;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.3s ease;
        height: 100%;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        border-color: #4a9eff;
        box-shadow: 0 8px 20px rgba(74, 158, 255, 0.3);
    }
    
    .stat-icon {
        font-size: 2.5rem;
        color: #4a9eff;
        margin-bottom: 0.5rem;
    }
    
    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
    }
    
    .stat-label {
        color: var(--text-secondary);
        font-size: 0.9rem;
        font-weight: 500;
    }
    
    .level-card {
        background: var(--card-bg);
        border: 2px solid var(--border-color);
        border-radius: 1rem;
        overflow: hidden;
        transition: all 0.3s ease;
        height: 100%;
    }
    
    .level-card:hover {
        transform: translateY(-5px);
        border-color: #4a9eff;
        box-shadow: 0 10px 30px rgba(74, 158, 255, 0.3);
    }
    
    .level-header {
        background: linear-gradient(135deg, #4a9eff 0%, #6c63ff 100%);
        padding: 2rem;
        text-align: center;
        color: white;
    }
    
    .level-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
    }
    
    .level-body {
        padding: 1.5rem;
    }
    
    .level-stats {
        display: flex;
        justify-content: space-around;
        padding: 1rem 0;
        border-top: 1px solid var(--border-color);
        border-bottom: 1px solid var(--border-color);
        margin: 1rem 0;
    }
    
    .level-stat-item {
        text-align: center;
    }
    
    .level-stat-number {
        font-size: 1.5rem;
        font-weight: 700;
        color: #4a9eff;
    }
    
    .level-stat-label {
        font-size: 0.8rem;
        color: var(--text-secondary);
    }
    
    .feature-card {
        background: var(--card-bg);
        border: 2px solid var(--border-color);
        border-radius: 1rem;
        padding: 1.5rem;
        height: 100%;
        transition: all 0.3s ease;
    }
    
    .feature-card:hover {
        border-color: #4a9eff;
        transform: translateY(-3px);
    }
    
    .feature-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #4a9eff 0%, #6c63ff 100%);
        border-radius: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        margin-bottom: 1rem;
    }
    
    .section-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }
    
    .section-subtitle {
        color: var(--text-secondary);
        margin-bottom: 2rem;
    }
    
    @media (max-width: 768px) {
        .hero-banner {
            padding: 2rem 1rem;
        }
        
        .hero-banner h1 {
            font-size: 1.75rem;
        }
        
        .stat-number {
            font-size: 2rem;
        }
        
        .stat-icon {
            font-size: 2rem;
        }
        
        .section-title {
            font-size: 1.5rem;
        }
        
        .level-header {
            padding: 1.5rem 1rem;
        }
        
        .level-icon {
            font-size: 2.5rem;
        }
    }
</style>

<div class="container-fluid px-3 px-md-4 py-3 py-md-4">
    <!-- Hero Banner -->
    <div class="hero-banner" data-animate>
        <h1 class="mb-3">Welcome to SmartCampus</h1>
        <p class="lead mb-4">Your premier online learning platform for HND and Bachelor students</p>
        <div class="d-flex gap-2 justify-content-center flex-wrap">
            <a href="#levels" class="btn btn-light btn-lg">
                <i class="bi bi-mortarboard-fill"></i> Explore Courses
            </a>
            @if(!auth()->check())
                <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg">
                    <i class="bi bi-person-plus-fill"></i> Get Started
                </a>
            @else
                <a href="{{ route('bookings.create') }}" class="btn btn-outline-light btn-lg">
                    <i class="bi bi-calendar-plus-fill"></i> Book a Class
                </a>
            @endif
        </div>
    </div>

    <!-- Statistics Section -->
    <div class="row g-3 g-md-4 mb-4" data-animate>
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="bi bi-book-fill"></i>
                </div>
                <div class="stat-number">{{ $totalCourses }}</div>
                <div class="stat-label">Courses Available</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="bi bi-play-circle-fill"></i>
                </div>
                <div class="stat-number">{{ $totalVideos }}</div>
                <div class="stat-label">Video Lessons</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="bi bi-layers-fill"></i>
                </div>
                <div class="stat-number">{{ $totalLevels }}</div>
                <div class="stat-label">Academic Levels</div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="bi bi-unlock-fill"></i>
                </div>
                <div class="stat-number">100%</div>
                <div class="stat-label">Free Access</div>
            </div>
        </div>
    </div>

    <!-- Academic Levels Section -->
    <div id="levels" class="mb-4" data-animate>
        <div class="text-center mb-4">
            <h2 class="section-title">Academic Levels</h2>
            <p class="section-subtitle">Choose your level and start learning today</p>
        </div>
        
        <div class="row g-3 g-md-4">
            @forelse($levels as $level)
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="level-card">
                        <div class="level-header">
                            <div class="level-icon">
                                <i class="bi bi-mortarboard-fill"></i>
                            </div>
                            <h4 class="mb-0">{{ $level->name }}</h4>
                        </div>
                        <div class="level-body">
                            <p style="color: var(--text-primary); min-height: 60px;">
                                {{ $level->description ?? 'Professional and technical education program' }}
                            </p>
                            
                            <div class="level-stats">
                                <div class="level-stat-item">
                                    <div class="level-stat-number">{{ $level->course_count }}</div>
                                    <div class="level-stat-label">Courses</div>
                                </div>
                                <div class="level-stat-item">
                                    <div class="level-stat-number">{{ $level->video_count }}</div>
                                    <div class="level-stat-label">Videos</div>
                                </div>
                            </div>
                            
                            <a href="{{ route('level.show', $level->slug) }}" class="btn btn-primary w-100 mt-3">
                                <i class="bi bi-arrow-right-circle-fill"></i> Explore Level
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="bi bi-inbox" style="font-size: 4rem; color: var(--text-secondary);"></i>
                        <p class="text-secondary mt-3">No levels available yet. Check back soon!</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Features Section -->
    <div id="features" class="mb-4" data-animate>
        <div class="text-center mb-4">
            <h2 class="section-title">Why Choose SmartCampus?</h2>
            <p class="section-subtitle">Everything you need for successful learning</p>
        </div>
        
        <div class="row g-3 g-md-4">
            <div class="col-12 col-md-6 col-lg-3">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-play-btn-fill"></i>
                    </div>
                    <h5 style="color: var(--text-primary); font-weight: 600; margin-bottom: 0.75rem;">High-Quality Videos</h5>
                    <p style="color: var(--text-secondary); margin-bottom: 0;">
                        Professional video content organized by academic levels for effective learning
                    </p>
                </div>
            </div>
            
            <div class="col-12 col-md-6 col-lg-3">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-file-earmark-text-fill"></i>
                    </div>
                    <h5 style="color: var(--text-primary); font-weight: 600; margin-bottom: 0.75rem;">Comprehensive Notes</h5>
                    <p style="color: var(--text-secondary); margin-bottom: 0;">
                        Detailed notes and summaries for each video lesson with downloadable PDFs
                    </p>
                </div>
            </div>
            
            <div class="col-12 col-md-6 col-lg-3">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-calendar-check-fill"></i>
                    </div>
                    <h5 style="color: var(--text-primary); font-weight: 600; margin-bottom: 0.75rem;">One-on-One Classes</h5>
                    <p style="color: var(--text-secondary); margin-bottom: 0;">
                        Book personalized classes with instructors for topics you need help with
                    </p>
                </div>
            </div>
            
            <div class="col-12 col-md-6 col-lg-3">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="bi bi-unlock-fill"></i>
                    </div>
                    <h5 style="color: var(--text-primary); font-weight: 600; margin-bottom: 0.75rem;">100% Free Access</h5>
                    <p style="color: var(--text-secondary); margin-bottom: 0;">
                        All content is completely free for all students with no hidden costs
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="text-center py-4 py-md-5" data-animate>
        <div class="card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
            <div class="card-body p-4 p-md-5">
                <h3 class="text-white mb-3">Ready to Start Learning?</h3>
                <p class="text-white mb-4 opacity-75">
                    Join thousands of students already advancing their education with SmartCampus
                </p>
                @if(!auth()->check())
                    <a href="{{ route('register') }}" class="btn btn-light btn-lg">
                        <i class="bi bi-person-plus-fill"></i> Create Free Account
                    </a>
                @else
                    <a href="#levels" class="btn btn-light btn-lg">
                        <i class="bi bi-mortarboard-fill"></i> Browse Courses
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
