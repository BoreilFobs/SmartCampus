@extends('layouts.admin')

@section('header')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h2 class="h4 fw-bold text-dark mb-0">
                {{ __('Admin Dashboard') }}
            </h2>
            <small class="text-muted">Welcome back, {{ Auth::user()->name }}! 👋</small>
        </div>
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#refreshModal">
            <i class="bi bi-arrow-clockwise me-2"></i>Refresh
        </button>
    </div>
@endsection

@section('content')
    <div class="py-3">
        <!-- Statistics Grid -->
        <div class="row mb-4">
            <!-- Levels Stats -->
            <div class="col-12 col-sm-6 col-lg-3 mb-3">
                <div class="card shadow-sm border-0 h-100 position-relative overflow-hidden">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-uppercase small fw-semibold text-muted mb-1">Total Levels</p>
                                <h3 class="display-6 fw-bold text-dark mb-2">{{ $stats['levels'] ?? 0 }}</h3>
                                <span class="badge bg-success">{{ $stats['active_levels'] ?? 0 }} Active</span>
                            </div>
                            <div class="bg-primary bg-opacity-10 p-3 rounded-2">
                                <i class="bi bi-bookmark-fill text-primary" style="font-size: 1.75rem;"></i>
                            </div>
                        </div>
                    </div>
                    <div class="position-absolute top-0 end-0 w-50 h-50 bg-primary bg-opacity-5" style="border-radius: 0 0 0 100%;"></div>
                </div>
            </div>

            <!-- Courses Stats -->
            <div class="col-12 col-sm-6 col-lg-3 mb-3">
                <div class="card shadow-sm border-0 h-100 position-relative overflow-hidden">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-uppercase small fw-semibold text-muted mb-1">Total Courses</p>
                                <h3 class="display-6 fw-bold text-dark mb-2">{{ $stats['courses'] ?? 0 }}</h3>
                                <span class="badge bg-success">{{ $stats['active_courses'] ?? 0 }} Active</span>
                            </div>
                            <div class="bg-success bg-opacity-10 p-3 rounded-2">
                                <i class="bi bi-book-fill text-success" style="font-size: 1.75rem;"></i>
                            </div>
                        </div>
                    </div>
                    <div class="position-absolute top-0 end-0 w-50 h-50 bg-success bg-opacity-5" style="border-radius: 0 0 0 100%;"></div>
                </div>
            </div>

            <!-- Videos Stats -->
            <div class="col-12 col-sm-6 col-lg-3 mb-3">
                <div class="card shadow-sm border-0 h-100 position-relative overflow-hidden">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-uppercase small fw-semibold text-muted mb-1">Total Videos</p>
                                <h3 class="display-6 fw-bold text-dark mb-2">{{ $stats['videos'] ?? 0 }}</h3>
                                <span class="badge bg-success">{{ $stats['active_videos'] ?? 0 }} Active</span>
                            </div>
                            <div class="bg-info bg-opacity-10 p-3 rounded-2">
                                <i class="bi bi-film text-info" style="font-size: 1.75rem;"></i>
                            </div>
                        </div>
                    </div>
                    <div class="position-absolute top-0 end-0 w-50 h-50 bg-info bg-opacity-5" style="border-radius: 0 0 0 100%;"></div>
                </div>
            </div>

            <!-- Notes Stats -->
            <div class="col-12 col-sm-6 col-lg-3 mb-3">
                <div class="card shadow-sm border-0 h-100 position-relative overflow-hidden">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <p class="text-uppercase small fw-semibold text-muted mb-1">Total Notes</p>
                                <h3 class="display-6 fw-bold text-dark mb-2">{{ $stats['notes'] ?? 0 }}</h3>
                                <p class="text-muted small mb-0">Study Materials</p>
                            </div>
                            <div class="bg-warning bg-opacity-10 p-3 rounded-2">
                                <i class="bi bi-file-earmark-text-fill text-warning" style="font-size: 1.75rem;"></i>
                            </div>
                        </div>
                    </div>
                    <div class="position-absolute top-0 end-0 w-50 h-50 bg-warning bg-opacity-5" style="border-radius: 0 0 0 100%;"></div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row mb-4">
            <div class="col-12">
                <h5 class="fw-bold text-dark mb-3">Quick Actions</h5>
            </div>
            <div class="col-12 col-md-6 col-lg-4 mb-3">
                <a href="{{ route('admin.courses.create') }}" class="text-decoration-none">
                    <div class="card border shadow-sm h-100 position-relative overflow-hidden transition-all" style="cursor: pointer; border-color: #dee2e6 !important; transition: all 0.3s ease;">
                        <div class="card-body d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 p-3 rounded-2 me-3 d-flex align-items-center justify-content-center" style="min-width: 60px; height: 60px;">
                                <i class="bi bi-plus-circle-fill text-primary" style="font-size: 1.75rem;"></i>
                            </div>
                            <div class="flex-grow-1">
                                <p class="fw-semibold text-dark mb-1">Add New Course</p>
                                <p class="text-muted small mb-0">Create a new course</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-12 col-md-6 col-lg-4 mb-3">
                <a href="{{ route('admin.videos.create') }}" class="text-decoration-none">
                    <div class="card border shadow-sm h-100 position-relative overflow-hidden transition-all" style="cursor: pointer; border-color: #dee2e6 !important; transition: all 0.3s ease;">
                        <div class="card-body d-flex align-items-center">
                            <div class="bg-info bg-opacity-10 p-3 rounded-2 me-3 d-flex align-items-center justify-content-center" style="min-width: 60px; height: 60px;">
                                <i class="bi bi-cloud-upload-fill text-info" style="font-size: 1.75rem;"></i>
                            </div>
                            <div class="flex-grow-1">
                                <p class="fw-semibold text-dark mb-1">Upload Video</p>
                                <p class="text-muted small mb-0">Add new video content</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-12 col-md-6 col-lg-4 mb-3">
                <a href="{{ route('admin.notes.create') }}" class="text-decoration-none">
                    <div class="card border shadow-sm h-100 position-relative overflow-hidden transition-all" style="cursor: pointer; border-color: #dee2e6 !important; transition: all 0.3s ease;">
                        <div class="card-body d-flex align-items-center">
                            <div class="bg-success bg-opacity-10 p-3 rounded-2 me-3 d-flex align-items-center justify-content-center" style="min-width: 60px; height: 60px;">
                                <i class="bi bi-pencil-square text-success" style="font-size: 1.75rem;"></i>
                            </div>
                            <div class="flex-grow-1">
                                <p class="fw-semibold text-dark mb-1">Create Note</p>
                                <p class="text-muted small mb-0">Add study materials</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="row mb-4">
            <!-- Recent Courses -->
            <div class="col-12 col-lg-6 mb-3">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom py-3 px-4">
                        <h5 class="card-title fw-bold text-dark mb-0">
                            <i class="bi bi-book-fill text-success me-2"></i>Recent Courses
                        </h5>
                    </div>
                    <div class="card-body px-4">
                        @if(isset($recentCourses) && $recentCourses->count() > 0)
                            <div class="space-y-3">
                                @foreach($recentCourses as $course)
                                    <div class="d-flex justify-content-between align-items-start p-3 bg-light rounded-2 mb-3 last-mb-0">
                                        <div class="flex-grow-1">
                                            <p class="fw-medium text-dark mb-1">{{ $course->title }}</p>
                                            <p class="text-muted small mb-0">
                                                <i class="bi bi-tag me-1"></i>{{ $course->level->name ?? 'N/A' }} 
                                                <span class="mx-1">•</span>
                                                <i class="bi bi-clock me-1"></i>{{ $course->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                        <span class="badge {{ $course->is_active ? 'bg-success' : 'bg-secondary' }} ms-2 py-2 px-2">
                                            {{ $course->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                                <p class="text-muted mt-3">No courses yet.</p>
                                <a href="{{ route('admin.courses.create') }}" class="btn btn-sm btn-outline-primary">Create your first course</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Recent Videos -->
            <div class="col-12 col-lg-6 mb-3">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom py-3 px-4">
                        <h5 class="card-title fw-bold text-dark mb-0">
                            <i class="bi bi-film text-info me-2"></i>Recent Videos
                        </h5>
                    </div>
                    <div class="card-body px-4">
                        @if(isset($recentVideos) && $recentVideos->count() > 0)
                            <div class="space-y-3">
                                @foreach($recentVideos as $video)
                                    <div class="d-flex justify-content-between align-items-start p-3 bg-light rounded-2 mb-3 last-mb-0">
                                        <div class="flex-grow-1">
                                            <p class="fw-medium text-dark mb-1">{{ $video->title }}</p>
                                            <p class="text-muted small mb-0">
                                                <i class="bi bi-book me-1"></i>{{ $video->course->title ?? 'N/A' }}
                                                <span class="mx-1">•</span>
                                                <i class="bi bi-clock me-1"></i>{{ $video->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                        <span class="badge {{ $video->is_active ? 'bg-success' : 'bg-secondary' }} ms-2 py-2 px-2">
                                            {{ $video->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                                <p class="text-muted mt-3">No videos yet.</p>
                                <a href="{{ route('admin.videos.create') }}" class="btn btn-sm btn-outline-primary">Upload your first video</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- System Information -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom py-3 px-4">
                        <h5 class="card-title fw-bold text-dark mb-0">
                            <i class="bi bi-info-circle me-2"></i>System Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-4 mb-4 mb-md-0">
                                <div class="text-center">
                                    <i class="bi bi-people-fill text-primary" style="font-size: 2rem;"></i>
                                    <p class="text-muted small mt-2 mb-1">Total Users</p>
                                    <h4 class="fw-bold text-dark">{{ $stats['total_users'] ?? 0 }}</h4>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 mb-4 mb-md-0">
                                <div class="text-center">
                                    <i class="bi bi-shield-lock text-success" style="font-size: 2rem;"></i>
                                    <p class="text-muted small mt-2 mb-1">Admin Users</p>
                                    <h4 class="fw-bold text-dark">{{ $stats['admin_users'] ?? 0 }}</h4>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="text-center">
                                    <i class="bi bi-gear-fill text-warning" style="font-size: 2rem;"></i>
                                    <p class="text-muted small mt-2 mb-1">Platform Version</p>
                                    <h4 class="fw-bold text-dark">v1.0.0</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .transition-all {
            transition: all 0.3s ease;
        }
        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
        }
        .space-y-3 > * + * {
            margin-top: 0.75rem;
        }
        .last-mb-0:last-child {
            margin-bottom: 0 !important;
        }
    </style>
@endsection

