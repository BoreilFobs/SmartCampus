@extends('layouts.admin')

@section('header')
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-sm-items-center gap-3">
        <div>
            <h2 class="h4 fw-bold text-dark mb-0">Edit Video</h2>
            <small class="text-muted">Update video information</small>
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
                        <h5 class="card-title fw-bold text-dark mb-0">{{ $video->title }}</h5>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('admin.videos.update', $video) }}" enctype="multipart/form-data" novalidate>
                            @csrf
                            @method('PUT')

                            <!-- Course Selection -->
                            <div class="mb-4">
                                <label for="course_id" class="form-label fw-semibold">Course <span class="text-danger">*</span></label>
                                <select id="course_id" name="course_id" class="form-select @error('course_id') is-invalid @enderror" required>
                                    <option value="">Select a course...</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}" {{ $video->course_id == $course->id ? 'selected' : '' }}>
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
                                       value="{{ old('title', $video->title) }}" 
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
                                          placeholder="Enter video description...">{{ old('description', $video->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Current Video File Info -->
                            @if($video->video_path)
                                <div class="alert alert-info mb-4">
                                    <small>
                                        <strong>Current file:</strong> {{ basename($video->video_path) }}<br>
                                        <strong>File size:</strong> {{ formatBytes($video->file_size) }}
                                    </small>
                                </div>
                            @endif

                            <!-- Video File Upload (Optional for replacement) -->
                            <div class="mb-4">
                                <label for="video_path" class="form-label fw-semibold">Replace Video File</label>
                                <div class="input-group">
                                    <input type="file" id="video_path" name="video_path" 
                                           class="form-control @error('video_path') is-invalid @enderror"
                                           accept="video/mp4,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/webm"
                                           onchange="updateFileInfo(event)">
                                    <label class="input-group-text" for="video_path">
                                        <i class="bi bi-file-video me-2"></i>Browse
                                    </label>
                                    @error('video_path')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <small class="text-muted d-block mt-2">Leave empty to keep current video</small>

                                <!-- File info -->
                                <div id="file-info" style="display: none;" class="alert alert-info mt-3 mb-0">
                                    <small>
                                        <strong>New file:</strong> <span id="file-name"></span><br>
                                        <strong>File size:</strong> <span id="file-size"></span>
                                    </small>
                                </div>
                            </div>

                            <!-- Duration -->
                            <div class="mb-4">
                                <label for="duration" class="form-label fw-semibold">Duration (seconds)</label>
                                <input type="number" id="duration" name="duration" 
                                       class="form-control @error('duration') is-invalid @enderror" 
                                       placeholder="e.g., 3600"
                                       value="{{ old('duration', $video->duration) }}"
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
                                           {{ $video->is_active ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        Publish (make video visible to students)
                                    </label>
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="d-flex gap-2 pt-3 flex-column flex-sm-row">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-2"></i>Save Changes
                                </button>
                                <a href="{{ route('admin.videos.show', $video) }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-2"></i>Back
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Sidebar Info -->
            <div class="col-12 col-lg-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-info-circle text-info me-2"></i>Video Information
                        </h6>
                        <div class="mb-3">
                            <small class="text-muted">Course</small>
                            <p class="fw-semibold text-dark mb-0">{{ $video->course->title }}</p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">File Size</small>
                            <p class="fw-semibold text-dark mb-0">{{ formatBytes($video->file_size) }}</p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Duration</small>
                            <p class="fw-semibold text-dark mb-0">
                                @if($video->duration)
                                    {{ gmdate('H:i:s', $video->duration) }}
                                @else
                                    Not set
                                @endif
                            </p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Created</small>
                            <p class="fw-semibold text-dark mb-0">{{ $video->created_at->format('M d, Y') }}</p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Last Updated</small>
                            <p class="fw-semibold text-dark mb-0">{{ $video->updated_at->format('M d, Y') }}</p>
                        </div>

                        <hr class="my-3">

                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.videos.show', $video) }}" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-eye me-2"></i>View Video
                            </a>
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
                const fileSize = (file.size / (1024 * 1024)).toFixed(2);
                
                document.getElementById('file-name').textContent = fileName;
                document.getElementById('file-size').textContent = fileSize + ' MB';
                document.getElementById('file-info').style.display = 'block';
            } else {
                document.getElementById('file-info').style.display = 'none';
            }
        }
    </script>
@endsection
