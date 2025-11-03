@extends('layouts.app')

@section('title', 'SmartCampus - Your Premier Online Learning Platform')

@section('description', 'Explore our comprehensive online learning platform with courses for HND and Bachelor students. Watch videos, read summaries, and master your subjects at your own pace.')

@section('content')
<div class="container-fluid">
    <!-- Hero Section -->
    <div class="hero-section fade-in-up" data-animate>
        <h1>Welcome to SmartCampus</h1>
        <p>Your premier online learning platform for HND and Bachelor students</p>
        <div class="mt-4">
            <a href="#courses" class="btn btn-primary me-2">Explore Courses</a>
            @if(!auth()->check())
                <a href="{{ route('login') }}" class="btn btn-outline-light">Login</a>
            @endif
        </div>
    </div>

    <!-- Statistics Section -->
    <div class="row g-4 mb-5" data-animate>
        <div class="col-md-3 col-6">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="text-primary fw-bold" style="font-size: 2rem;">{{ $totalCourses }}</h5>
                    <p class="text-secondary">Courses Available</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="text-primary fw-bold" style="font-size: 2rem;">{{ $totalVideos }}</h5>
                    <p class="text-secondary">Video Lessons</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="text-primary fw-bold" style="font-size: 2rem;">{{ $totalLevels }}</h5>
                    <p class="text-secondary">Academic Levels</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="text-primary fw-bold" style="font-size: 2rem;">100%</h5>
                    <p class="text-secondary">Free Access</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Academic Levels Section -->
    <div id="levels" class="mb-5" data-animate>
        <h2 class="text-center mb-4 text-gradient fw-bold">Academic Levels</h2>
        <div class="course-grid">
            @forelse($levels as $level)
                <div class="card course-card fade-in-up">
                    <div class="course-card-header d-flex align-items-center justify-content-center">
                        <div class="text-center text-white">
                            <i class="bi bi-layers" style="font-size: 3rem;"></i>
                            <h4 class="mt-2 mb-0">{{ $level->name }}</h4>
                        </div>
                    </div>
                    <div class="course-card-body">
                        <p class="course-card-desc text-secondary">
                            {{ $level->description ?? 'Professional and technical education' }}
                        </p>
                        <div class="course-stats">
                            <span>
                                <i class="bi bi-collection"></i>
                                {{ $level->course_count }} Courses
                            </span>
                            <span>
                                <i class="bi bi-play-circle"></i>
                                {{ $level->video_count }} Videos
                            </span>
                        </div>
                        <a href="{{ route('level.show', $level->slug) }}" class="btn btn-primary btn-sm mt-3 w-100">
                            Explore <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="text-center w-100">
                    <p class="text-secondary">No levels available yet.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Features Section -->
    <div id="features" class="bg-white rounded-4 p-5 mb-5" data-animate>
        <h2 class="text-center mb-4 text-gradient fw-bold">Why Choose SmartCampus?</h2>
        <div class="row g-4">
            <div class="col-md-6">
                <div class="d-flex align-items-start">
                    <div class="badge badge-primary me-3" style="font-size: 1.5rem;">
                        <i class="bi bi-check2"></i>
                    </div>
                    <div>
                        <h5>High-Quality Videos</h5>
                        <p class="text-secondary">Professional video content organized by academic levels</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex align-items-start">
                    <div class="badge badge-primary me-3" style="font-size: 1.5rem;">
                        <i class="bi bi-check2"></i>
                    </div>
                    <div>
                        <h5>Comprehensive Summaries</h5>
                        <p class="text-secondary">Detailed notes and summaries for each video lesson</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex align-items-start">
                    <div class="badge badge-primary me-3" style="font-size: 1.5rem;">
                        <i class="bi bi-check2"></i>
                    </div>
                    <div>
                        <h5>Learn at Your Pace</h5>
                        <p class="text-secondary">Watch videos anytime, anywhere with no time restrictions</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex align-items-start">
                    <div class="badge badge-primary me-3" style="font-size: 1.5rem;">
                        <i class="bi bi-check2"></i>
                    </div>
                    <div>
                        <h5>100% Free Access</h5>
                        <p class="text-secondary">All content is completely free for all students</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="hero-section text-center fade-in-up" data-animate>
        <h3>Ready to Start Learning?</h3>
        <p class="mb-4">Browse through our courses and elevate your knowledge today!</p>
        <a href="#levels" class="btn btn-light btn-lg">Get Started</a>
    </div>
</div>

@push('scripts')
<script>
    // Add smooth animations
    document.addEventListener('DOMContentLoaded', function() {
        const elements = document.querySelectorAll('[data-animate]');
        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('fade-in-up');
                }
            });
        }, { threshold: 0.1 });

        elements.forEach(el => observer.observe(el));
    });
</script>
@endpush
@endsection
