@extends('layouts.app')

@section('title', 'Dashboard - SmartCampus')

@section('content')
<div class="container px-3 px-md-4 py-4">
    <div class="row">
        <div class="col-12">
            <h3 class="mb-4" style="font-weight: 600; color: #212529;">
                <i class="bi bi-speedometer2"></i> Dashboard
            </h3>
        </div>
    </div>

    <div class="row g-4">
        <!-- Welcome Card -->
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body p-4 text-white">
                    <h4 class="mb-2" style="font-weight: 600;">Welcome back, {{ Auth::user()->name }}! 👋</h4>
                    <p class="mb-0" style="opacity: 0.95;">You're all set to continue your learning journey.</p>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <i class="bi bi-collection-fill" style="font-size: 2.5rem; color: #667eea;"></i>
                    </div>
                    <h5 class="mb-1" style="font-weight: 600; color: #212529;">{{ \App\Models\Level::count() }}</h5>
                    <p class="text-muted mb-0">Levels Available</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <i class="bi bi-play-circle-fill" style="font-size: 2.5rem; color: #764ba2;"></i>
                    </div>
                    <h5 class="mb-1" style="font-weight: 600; color: #212529;">{{ \App\Models\Course::count() }}</h5>
                    <p class="text-muted mb-0">Total Courses</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <i class="bi bi-calendar-check-fill" style="font-size: 2.5rem; color: #28a745;"></i>
                    </div>
                    <h5 class="mb-1" style="font-weight: 600; color: #212529;">
                        {{ Auth::user()->bookings()->count() }}
                    </h5>
                    <p class="text-muted mb-0">My Bookings</p>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <i class="bi bi-camera-video-fill" style="font-size: 2.5rem; color: #ffc107;"></i>
                    </div>
                    <h5 class="mb-1" style="font-weight: 600; color: #212529;">{{ \App\Models\Video::count() }}</h5>
                    <p class="text-muted mb-0">Video Lessons</p>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0" style="font-weight: 600; color: #212529;">
                        <i class="bi bi-lightning-fill"></i> Quick Actions
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <a href="{{ route('home') }}" class="btn btn-outline-primary w-100 py-3">
                                <i class="bi bi-collection"></i>
                                <div class="mt-1">Browse Levels</div>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('bookings.create') }}" class="btn btn-outline-success w-100 py-3">
                                <i class="bi bi-calendar-plus"></i>
                                <div class="mt-1">Book a Class</div>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('bookings.index') }}" class="btn btn-outline-info w-100 py-3">
                                <i class="bi bi-calendar-check"></i>
                                <div class="mt-1">My Bookings</div>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="{{ route('profile.edit') }}" class="btn btn-outline-secondary w-100 py-3">
                                <i class="bi bi-person-circle"></i>
                                <div class="mt-1">Edit Profile</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity or Info -->
        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white">
                    <h5 class="mb-0" style="font-weight: 600; color: #212529;">
                        <i class="bi bi-info-circle-fill"></i> Getting Started
                    </h5>
                </div>
                <div class="card-body p-4">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-3">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            <span>Explore available levels</span>
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            <span>Watch video lessons</span>
                        </li>
                        <li class="mb-3">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            <span>Book one-on-one classes</span>
                        </li>
                        <li class="mb-0">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            <span>Download course notes</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
