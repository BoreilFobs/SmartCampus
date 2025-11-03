@extends('layouts.app')

@section('title', $level->name . ' Courses - SmartCampus')

@section('description', 'Explore all ' . $level->name . ' courses on SmartCampus. Learn through high-quality video lessons and comprehensive summaries.')

@section('content')
<div class="container-fluid">
    <!-- Level Header -->
    <div class="hero-section mb-5 fade-in-up" data-animate>
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1>{{ $level->name }}</h1>
                <p>{{ $level->description ?? 'Comprehensive courses for ' . $level->name . ' level students' }}</p>
                <div class="mt-3">
                    <span class="badge badge-light me-2">
                        <i class="bi bi-collection"></i> {{ $courses->count() }} Courses
                    </span>
                    <span class="badge badge-light">
                        <i class="bi bi-play-circle"></i> {{ $totalVideos }} Video Lessons
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="mb-4 fade-in-up" data-animate>
        <div class="input-group" style="max-width: 400px;">
            <span class="input-group-text bg-white border-end-0">
                <i class="bi bi-search"></i>
            </span>
            <input 
                type="text" 
                class="form-control border-start-0" 
                id="courseSearch" 
                placeholder="Search courses..."
            >
        </div>
    </div>

    <!-- Courses Grid -->
    <div id="coursesContainer" class="course-grid mb-5">
        @forelse($courses as $course)
            <div class="course-card fade-in-up course-item" data-animate data-title="{{ strtolower($course->title) }}" data-description="{{ strtolower($course->description) }}">
                <div class="course-card-header">
                    @if($course->thumbnail_path)
                        <img src="{{ asset('storage/' . $course->thumbnail_path) }}" alt="{{ $course->title }}" style="object-fit: cover;">
                    @else
                        <div class="d-flex align-items-center justify-content-center h-100 bg-gradient">
                            <i class="bi bi-film" style="font-size: 3rem; color: white;"></i>
                        </div>
                    @endif
                </div>
                <div class="course-card-body">
                    <h5 class="course-card-title">{{ $course->title }}</h5>
                    <p class="course-card-desc">
                        {{ Str::limit($course->description, 100) }}
                    </p>
                    <div class="course-stats">
                        <span>
                            <i class="bi bi-play-circle"></i>
                            {{ $course->videos_count ?? $course->videos()->where('is_active', true)->count() }} Videos
                        </span>
                        <span>
                            <i class="bi bi-clock"></i>
                            <span class="course-duration">~2.5h</span>
                        </span>
                    </div>
                    <a href="{{ route('course.show', $course->slug) }}" class="btn btn-primary btn-sm mt-3 w-100">
                        View Course <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        @empty
            <div class="alert alert-info w-100 text-center py-5" role="alert">
                <i class="bi bi-info-circle" style="font-size: 2rem;"></i>
                <p class="mt-2 mb-0">No courses available for this level yet.</p>
            </div>
        @endforelse
    </div>

    <!-- Empty Search State -->
    <div id="noResults" class="alert alert-warning text-center py-5" style="display: none;" role="alert">
        <i class="bi bi-search" style="font-size: 2rem;"></i>
        <p class="mt-2 mb-0">No courses found matching your search.</p>
    </div>

    <!-- Back to Levels -->
    <div class="text-center mb-4">
        <a href="{{ route('home') }}" class="btn btn-outline-primary">
            <i class="bi bi-arrow-left me-2"></i> Back to Levels
        </a>
    </div>
</div>

@push('scripts')
<script>
    // Search functionality
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('courseSearch');
        const courseItems = document.querySelectorAll('.course-item');
        const noResults = document.getElementById('noResults');
        const coursesContainer = document.getElementById('coursesContainer');

        if (searchInput) {
            searchInput.addEventListener('keyup', function() {
                const query = this.value.toLowerCase();
                let visibleCount = 0;

                courseItems.forEach(item => {
                    const title = item.dataset.title;
                    const description = item.dataset.description;

                    if (title.includes(query) || description.includes(query) || query === '') {
                        item.style.display = '';
                        visibleCount++;
                    } else {
                        item.style.display = 'none';
                    }
                });

                if (visibleCount === 0 && query !== '') {
                    noResults.style.display = 'block';
                    coursesContainer.style.display = 'none';
                } else {
                    noResults.style.display = 'none';
                    coursesContainer.style.display = 'grid';
                }
            });
        }
    });
</script>
@endpush
@endsection
