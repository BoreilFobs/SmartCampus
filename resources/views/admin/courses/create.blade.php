@extends('layouts.admin')

@section('header')
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-sm-items-center gap-3">
        <div>
            <h2 class="h4 fw-bold text-dark mb-0">Create New Course</h2>
            <small class="text-muted">Add a new course to your platform</small>
        </div>
    </div>
@endsection

@section('content')
    <div class="py-2 py-md-3">
        <div class="row g-3">
            <!-- Main Form -->
            <div class="col-12 col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom py-3 px-4">
                        <h5 class="card-title fw-bold text-dark mb-0">Course Details</h5>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('admin.courses.store') }}" enctype="multipart/form-data" novalidate>
                            @csrf

                            <!-- Level Selection -->
                            <div class="mb-4">
                                <label for="level_id" class="form-label fw-semibold">Academic Level <span class="text-danger">*</span></label>
                                <select id="level_id" name="level_id" class="form-select @error('level_id') is-invalid @enderror" required>
                                    <option value="" selected disabled>Select a level...</option>
                                    @foreach($levels as $level)
                                        <option value="{{ $level->id }}" {{ old('level_id') == $level->id ? 'selected' : '' }}>
                                            {{ $level->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('level_id')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <small class="text-muted d-block mt-2">Choose which academic level this course belongs to</small>
                            </div>

                            <!-- Title -->
                            <div class="mb-4">
                                <label for="title" class="form-label fw-semibold">Course Title <span class="text-danger">*</span></label>
                                <input type="text" id="title" name="title" 
                                       class="form-control @error('title') is-invalid @enderror" 
                                       placeholder="Enter course title"
                                       value="{{ old('title') }}" 
                                       required>
                                @error('title')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <small class="text-muted d-block mt-2">Make the title descriptive and unique</small>
                            </div>

                            <!-- Description -->
                            <div class="mb-4">
                                <label for="description" class="form-label fw-semibold">Course Description</label>
                                <textarea id="description" name="description" rows="5"
                                          class="form-control @error('description') is-invalid @enderror"
                                          placeholder="Enter course description and learning objectives...">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <small class="text-muted d-block mt-2">Describe what students will learn in this course (max 1000 characters)</small>
                            </div>

                            <!-- Thumbnail -->
                            <div class="mb-4">
                                <label for="thumbnail_path" class="form-label fw-semibold">Course Thumbnail</label>
                                <div class="input-group">
                                    <input type="file" id="thumbnail_path" name="thumbnail_path" 
                                           class="form-control @error('thumbnail_path') is-invalid @enderror"
                                           accept="image/jpeg,image/jpg,image/png,image/webp"
                                           onchange="previewImage(event)">
                                    <label class="input-group-text" for="thumbnail_path">
                                        <i class="bi bi-image me-2"></i>Browse
                                    </label>
                                    @error('thumbnail_path')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <small class="text-muted d-block mt-2">JPG, PNG, or WebP (max 5MB) - Recommended: 16:9 aspect ratio</small>
                                
                                <!-- Preview -->
                                <div id="thumbnail-preview" class="mt-3" style="display: none;">
                                    <img id="preview-image" src="" alt="Thumbnail preview" 
                                         class="rounded" style="max-width: 300px; max-height: 200px; object-fit: cover;">
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="mb-4">
                                <div class="form-check">
                                    <input type="checkbox" id="is_active" name="is_active" 
                                           class="form-check-input" 
                                           value="1" 
                                           {{ old('is_active') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        Publish immediately (make course visible to students)
                                    </label>
                                </div>
                                <small class="text-muted d-block mt-2">Uncheck to keep this course in draft mode</small>
                            </div>

                            <!-- Buttons -->
                            <div class="d-flex gap-2 pt-3 flex-column flex-sm-row">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-2"></i>Create Course
                                </button>
                                <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-2"></i>Back to Courses
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Help Card -->
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 bg-light">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-lightbulb text-warning me-2"></i>Tips for Creating Courses
                        </h6>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-3">
                                <small class="text-dark"><strong>Title:</strong> Keep it clear and descriptive</small>
                            </li>
                            <li class="mb-3">
                                <small class="text-dark"><strong>Description:</strong> Explain learning outcomes</small>
                            </li>
                            <li class="mb-3">
                                <small class="text-dark"><strong>Thumbnail:</strong> Use high-quality images (16:9)</small>
                            </li>
                            <li class="mb-3">
                                <small class="text-dark"><strong>Level:</strong> Correctly categorize the course</small>
                            </li>
                            <li>
                                <small class="text-dark"><strong>Status:</strong> Save as draft if not ready yet</small>
                            </li>
                        </ul>

                        <hr class="my-4">

                        <div class="alert alert-info mb-0" role="alert">
                            <small>
                                <i class="bi bi-info-circle me-2"></i>
                                You can add videos to this course after creation.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-image').src = e.target.result;
                    document.getElementById('thumbnail-preview').style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                document.getElementById('thumbnail-preview').style.display = 'none';
            }
        }
    </script>
@endsection
