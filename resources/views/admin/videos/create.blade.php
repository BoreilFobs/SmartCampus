@extends('layouts.admin')

@section('header')
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-sm-items-center gap-3">
        <div>
            <h2 class="h4 fw-bold text-dark mb-0">Upload Video</h2>
            <small class="text-muted">Add a new video to your platform</small>
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
                        <h5 class="card-title fw-bold text-dark mb-0">Video Details</h5>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('admin.videos.store') }}" enctype="multipart/form-data" novalidate>
                            @csrf

                            <!-- Course Selection -->
                            <div class="mb-4">
                                <label for="course_id" class="form-label fw-semibold">Course <span class="text-danger">*</span></label>
                                <select id="course_id" name="course_id" class="form-select @error('course_id') is-invalid @enderror" required>
                                    <option value="" disabled selected>Select a course...</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                            {{ $course->level->name }} - {{ $course->title }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('course_id')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Video Title -->
                            <div class="mb-4">
                                <label for="title" class="form-label fw-semibold">Video Title <span class="text-danger">*</span></label>
                                <input type="text" id="title" name="title" 
                                       class="form-control @error('title') is-invalid @enderror" 
                                       placeholder="Enter video title"
                                       value="{{ old('title') }}" 
                                       required>
                                @error('title')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Video Description -->
                            <div class="mb-4">
                                <label for="description" class="form-label fw-semibold">Description</label>
                                <textarea id="description" name="description" rows="3"
                                          class="form-control @error('description') is-invalid @enderror"
                                          placeholder="Enter video description (optional)...">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Video File Upload -->
                            <div class="mb-4">
                                <label for="video_path" class="form-label fw-semibold">Video File <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="file" id="video_path" name="video_path" 
                                           class="form-control @error('video_path') is-invalid @enderror"
                                           accept="video/mp4,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/webm"
                                           onchange="updateFileInfo(event)"
                                           required>
                                    <label class="input-group-text" for="video_path">
                                        <i class="bi bi-file-video me-2"></i>Browse
                                    </label>
                                    @error('video_path')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <small class="text-muted d-block mt-2">
                                    Supported formats: MP4, MOV, AVI, WMV, WebM (Max 2GB)
                                </small>

                                <!-- File info -->
                                <div id="file-info" style="display: none;" class="alert alert-info mt-3 mb-0">
                                    <small>
                                        <strong>Selected file:</strong> <span id="file-name"></span><br>
                                        <strong>File size:</strong> <span id="file-size"></span>
                                    </small>
                                </div>
                            </div>

                            <!-- Duration -->
                            <div class="mb-4">
                                <label for="duration" class="form-label fw-semibold">Duration (seconds)</label>
                                <input type="number" id="duration" name="duration" 
                                       class="form-control @error('duration') is-invalid @enderror" 
                                       placeholder="Optional: e.g., 3600"
                                       value="{{ old('duration') }}"
                                       min="0">
                                @error('duration')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="mb-4">
                                <div class="form-check">
                                    <input type="checkbox" id="is_active" name="is_active" 
                                           class="form-check-input" 
                                           value="1" 
                                           {{ old('is_active') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        Publish (make video visible to students)
                                    </label>
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="d-flex gap-2 pt-3 flex-column flex-sm-row">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-cloud-upload me-2"></i>Upload Video
                                </button>
                                <a href="{{ route('admin.videos.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-2"></i>Back
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Help Card -->
            <div class="col-12 col-lg-4">
                <div class="card shadow-sm border-0 bg-light">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-lightbulb text-warning me-2"></i>Video Upload Tips
                        </h6>
                        <ul class="list-unstyled mb-0 small">
                            <li class="mb-3">
                                <small class="text-dark"><strong>Format:</strong> MP4 is recommended for best compatibility</small>
                            </li>
                            <li class="mb-3">
                                <small class="text-dark"><strong>Size:</strong> Maximum 2GB per video</small>
                            </li>
                            <li class="mb-3">
                                <small class="text-dark"><strong>Resolution:</strong> 720p minimum recommended</small>
                            </li>
                            <li class="mb-3">
                                <small class="text-dark"><strong>Duration:</strong> Enter duration in seconds for tracking</small>
                            </li>
                            <li class="mb-3">
                                <small class="text-dark"><strong>Course:</strong> Assign to correct course before publishing</small>
                            </li>
                            <li>
                                <small class="text-dark"><strong>Publishing:</strong> Check the publish box to make visible</small>
                            </li>
                        </ul>

                        <hr class="my-3">

                        <div class="alert alert-info mb-0" role="alert">
                            <small>
                                <i class="bi bi-info-circle me-2"></i>
                                Videos are stored securely and can be edited after upload.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateFileInfo(event) {
            const file = event.target.files[0];
            if (file) {
                const fileName = file.name;
                const fileSize = (file.size / (1024 * 1024)).toFixed(2); // Convert to MB
                
                document.getElementById('file-name').textContent = fileName;
                document.getElementById('file-size').textContent = fileSize + ' MB';
                document.getElementById('file-info').style.display = 'block';
            } else {
                document.getElementById('file-info').style.display = 'none';
            }
        }
    </script>
@endsection
