@extends('layouts.admin')

@section('header')
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-sm-items-center gap-3">
        <div>
            <h2 class="h4 fw-bold text-dark mb-0">Edit Course</h2>
            <small class="text-muted">Update course information</small>
        </div>
    </div>
@endsection

@section('content')
    <div class="py-2 py-md-3">
        <div class="row g-3">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom py-3 px-4">
                        <h5 class="card-title fw-bold text-dark mb-0">{{ $course->title }}</h5>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('admin.courses.update', $course) }}" enctype="multipart/form-data" novalidate>
                            @csrf
                            @method('PUT')

                            <!-- Level Selection -->
                            <div class="mb-4">
                                <label for="level_id" class="form-label fw-semibold">Academic Level <span class="text-danger">*</span></label>
                                <select id="level_id" name="level_id" class="form-select @error('level_id') is-invalid @enderror" required>
                                    <option value="" disabled>Select a level...</option>
                                    @foreach($levels as $level)
                                        <option value="{{ $level->id }}" {{ $course->level_id == $level->id ? 'selected' : '' }}>
                                            {{ $level->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('level_id')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Title -->
                            <div class="mb-4">
                                <label for="title" class="form-label fw-semibold">Course Title <span class="text-danger">*</span></label>
                                <input type="text" id="title" name="title" 
                                       class="form-control @error('title') is-invalid @enderror" 
                                       placeholder="Enter course title"
                                       value="{{ old('title', $course->title) }}" 
                                       required>
                                @error('title')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="mb-4">
                                <label for="description" class="form-label fw-semibold">Course Description</label>
                                <textarea id="description" name="description" rows="5"
                                          class="form-control @error('description') is-invalid @enderror"
                                          placeholder="Enter course description and learning objectives...">{{ old('description', $course->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Thumbnail -->
                            <div class="mb-4">
                                <label for="thumbnail_path" class="form-label fw-semibold">Course Thumbnail</label>
                                
                                @if($course->thumbnail_path)
                                    <div class="mb-3">
                                        <p class="text-muted small mb-2">Current thumbnail:</p>
                                        <img src="{{ asset('storage/' . $course->thumbnail_path) }}" 
                                             alt="{{ $course->title }}" 
                                             class="rounded" 
                                             style="max-width: 300px; max-height: 200px; object-fit: cover;">
                                    </div>
                                @endif

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
                                <small class="text-muted d-block mt-2">Leave empty to keep current thumbnail</small>
                                
                                <!-- Preview -->
                                <div id="thumbnail-preview" class="mt-3" style="display: none;">
                                    <p class="text-muted small mb-2">New thumbnail preview:</p>
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
                                           {{ $course->is_active ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        Publish (make course visible to students)
                                    </label>
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="d-flex gap-2 pt-3 flex-column flex-sm-row">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-2"></i>Save Changes
                                </button>
                                <a href="{{ route('admin.courses.show', $course) }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-2"></i>Back
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Sidebar Info -->
            <div class="col-lg-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-info-circle text-info me-2"></i>Course Information
                        </h6>
                        <div class="mb-3">
                            <small class="text-muted">Level</small>
                            <p class="fw-semibold text-dark mb-0">{{ $course->level->name }}</p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Total Videos</small>
                            <p class="fw-semibold text-dark mb-0">{{ $course->videos->count() }}</p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Created</small>
                            <p class="fw-semibold text-dark mb-0">{{ $course->created_at->format('M d, Y') }}</p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Last Updated</small>
                            <p class="fw-semibold text-dark mb-0">{{ $course->updated_at->format('M d, Y') }}</p>
                        </div>

                        <hr class="my-3">

                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.courses.show', $course) }}" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-eye me-2"></i>View Course
                            </a>
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
