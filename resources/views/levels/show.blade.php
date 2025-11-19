@extends('layouts.app')

@section('title', $level->name . ' Courses - SmartCampus')

@section('description', 'Explore all ' . $level->name . ' courses on SmartCampus. Learn through high-quality video lessons and comprehensive summaries.')

@section('content')
<div class="container-fluid px-3 px-md-4 py-4">
    <!-- Level Header -->
    <div class="mb-4">
        <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
            <div class="card-body p-4">
                <h1 class="mb-3" style="font-weight: 700;">{{ $level->name }}</h1>
                <p class="mb-3" style="font-size: 1.1rem; opacity: 0.95;">
                    {{ $level->description ?? 'Comprehensive courses for ' . $level->name . ' level students' }}
                </p>
                <div class="d-flex flex-wrap gap-2">
                    <span class="badge bg-white text-dark px-3 py-2">
                        <i class="bi bi-collection"></i> {{ $courses->count() }} Courses
                    </span>
                    <span class="badge bg-white text-dark px-3 py-2">
                        <i class="bi bi-play-circle"></i> {{ $totalVideos }} Video Lessons
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-3">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input 
                        type="text" 
                        class="form-control border-start-0" 
                        id="courseSearch" 
                        placeholder="Search courses..."
                        style="box-shadow: none;"
                    >
                </div>
            </div>
        </div>
    </div>

    <!-- Courses Grid -->
    <div id="coursesContainer" class="row g-3 mb-4">
        @forelse($courses as $course)
            <div class="col-12 col-md-6 col-lg-4 course-item" data-title="{{ strtolower($course->title) }}" data-description="{{ strtolower($course->description) }}">
                <div class="card h-100 border-0 shadow-sm" style="transition: all 0.3s ease;">
                    <div class="card-img-top" style="height: 200px; position: relative; overflow: hidden; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                        @if($course->thumbnail_path)
                            <img src="{{ asset('storage/' . $course->thumbnail_path) }}" alt="{{ $course->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <div class="d-flex align-items-center justify-content-center h-100">
                                <i class="bi bi-film" style="font-size: 3rem; color: white; opacity: 0.9;"></i>
                            </div>
                        @endif
                    </div>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title mb-2" style="font-weight: 600; color: #212529;">{{ $course->title }}</h5>
                        <p class="card-text text-muted mb-3 flex-grow-1" style="font-size: 0.9rem;">
                            {{ Str::limit($course->description, 100) }}
                        </p>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <small class="text-muted">
                                <i class="bi bi-play-circle"></i>
                                {{ $course->videos_count ?? $course->videos()->where('is_active', true)->count() }} Videos
                            </small>
                            <small class="text-muted">
                                <i class="bi bi-clock"></i>
                                ~2.5h
                            </small>
                        </div>
                        <a href="{{ route('course.show', $course->slug) }}" class="btn btn-primary w-100" style="font-weight: 600;">
                            View Course <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-info-circle" style="font-size: 3rem; color: #6c757d;"></i>
                        <p class="mt-3 mb-0 text-muted">No courses available for this level yet.</p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Empty Search State -->
    <div id="noResults" class="card border-0 shadow-sm" style="display: none;">
        <div class="card-body text-center py-5">
            <i class="bi bi-search" style="font-size: 3rem; color: #6c757d;"></i>
            <p class="mt-3 mb-0 text-muted">No courses found matching your search.</p>
        </div>
    </div>

    <!-- Back to Levels -->
    <div class="text-center mt-4 mb-4">
        <a href="{{ route('home') }}" class="btn btn-outline-primary px-4">
            <i class="bi bi-arrow-left me-2"></i> Back to Levels
        </a>
    </div>
</div>

<style>
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }
</style>

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
                    coursesContainer.style.display = 'flex';
                }
            });
        }
    });
</script>
@endpush
@endsection
