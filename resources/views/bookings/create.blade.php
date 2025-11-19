@extends('layouts.app')

@section('title', 'Book a Class - SmartCampus')

@section('content')
<style>
    @media (max-width: 768px) {
        .form-header h4 {
            font-size: 1.25rem;
        }
        
        .form-description {
            font-size: 0.9rem;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .action-buttons .btn {
            width: 100%;
        }
    }
</style>

<div class="container px-3 px-md-4 py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header form-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
                    <h4 class="mb-0 text-white" style="font-weight: 600;">
                        <i class="bi bi-calendar-plus"></i> Book a One-on-One Class
                    </h4>
                </div>
                <div class="card-body p-4">
                    <p class="form-description mb-4" style="color: #495057;">
                        Need help understanding a particular topic? Request a one-on-one class with an instructor. 
                        Select the level, course, and topic you'd like to learn about, and an admin will schedule a class based on your availability.
                    </p>

                    <form action="{{ route('bookings.store') }}" method="POST" id="bookingForm">
                        @csrf

                        <!-- Level Selection -->
                        <div class="mb-4">
                            <label for="level_id" class="form-label fw-semibold">
                                Level <span class="text-danger">*</span>
                            </label>
                            <select 
                                name="level_id" 
                                id="level_id" 
                                class="form-select @error('level_id') is-invalid @enderror" 
                                required
                            >
                                <option value="">Select a level</option>
                                @foreach($levels as $level)
                                    <option value="{{ $level->id }}" {{ old('level_id') == $level->id ? 'selected' : '' }}>
                                        {{ $level->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('level_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Course Selection -->
                        <div class="mb-4">
                            <label for="course_id" class="form-label fw-semibold">
                                Course <span class="text-danger">*</span>
                            </label>
                            <select 
                                name="course_id" 
                                id="course_id" 
                                class="form-select @error('course_id') is-invalid @enderror" 
                                required
                                disabled
                            >
                                <option value="">Select a level first</option>
                            </select>
                            @error('course_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div id="courseLoader" class="text-primary mt-2" style="display: none;">
                                <span class="spinner-border spinner-border-sm" role="status"></span>
                                Loading courses...
                            </div>
                        </div>

                        <!-- Topic -->
                        <div class="mb-4">
                            <label for="topic" class="form-label fw-semibold">
                                Topic/Concept <span class="text-danger">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="topic" 
                                id="topic" 
                                class="form-control @error('topic') is-invalid @enderror" 
                                placeholder="e.g., Database Normalization, Object-Oriented Programming, etc."
                                value="{{ old('topic') }}"
                                required
                                maxlength="255"
                            >
                            @error('topic')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description" class="form-label fw-semibold">
                                Description <span class="text-danger">*</span>
                            </label>
                            <textarea 
                                name="description" 
                                id="description" 
                                rows="5" 
                                class="form-control @error('description') is-invalid @enderror" 
                                placeholder="Please describe what you'd like to learn or what concepts you're struggling with..."
                                required
                                maxlength="1000"
                            >{{ old('description') }}</textarea>
                            <div class="form-text text-muted">
                                <span id="charCount">0</span>/1000 characters
                            </div>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-2 action-buttons">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-send"></i> Submit Request
                            </button>
                            <a href="{{ route('bookings.index') }}" class="btn btn-outline-secondary px-4">
                                <i class="bi bi-arrow-left"></i> 
                                <span class="d-none d-sm-inline">Back to My Bookings</span>
                                <span class="d-inline d-sm-none">Back</span>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Character counter for description
    const descriptionField = document.getElementById('description');
    const charCount = document.getElementById('charCount');
    
    descriptionField.addEventListener('input', function() {
        charCount.textContent = this.value.length;
    });
    
    // Update on page load if there's old input
    charCount.textContent = descriptionField.value.length;

    // Load courses when level is selected
    const levelSelect = document.getElementById('level_id');
    const courseSelect = document.getElementById('course_id');
    const courseLoader = document.getElementById('courseLoader');
    
    levelSelect.addEventListener('change', function() {
        const levelId = this.value;
        
        if (!levelId) {
            courseSelect.innerHTML = '<option value="">Select a level first</option>';
            courseSelect.disabled = true;
            return;
        }
        
        // Show loader
        courseLoader.style.display = 'block';
        courseSelect.disabled = true;
        courseSelect.innerHTML = '<option value="">Loading...</option>';
        
        // Fetch courses for this level
        fetch(`{{ route('bookings.courses') }}?level_id=${levelId}`)
            .then(response => response.json())
            .then(courses => {
                courseLoader.style.display = 'none';
                
                if (courses.length === 0) {
                    courseSelect.innerHTML = '<option value="">No courses available for this level</option>';
                    return;
                }
                
                courseSelect.innerHTML = '<option value="">Select a course</option>';
                courses.forEach(course => {
                    const option = document.createElement('option');
                    option.value = course.id;
                    option.textContent = course.title;
                    
                    // Preserve old selection if validation failed
                    if ('{{ old('course_id') }}' == course.id) {
                        option.selected = true;
                    }
                    
                    courseSelect.appendChild(option);
                });
                
                courseSelect.disabled = false;
            })
            .catch(error => {
                console.error('Error loading courses:', error);
                courseLoader.style.display = 'none';
                courseSelect.innerHTML = '<option value="">Error loading courses</option>';
            });
    });
    
    // Trigger course loading if there's an old level selection
    @if(old('level_id'))
        levelSelect.dispatchEvent(new Event('change'));
    @endif
</script>
@endsection
