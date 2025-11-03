@extends('layouts.admin')

@section('header')
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-sm-items-center gap-2">
        <div>
            <h2 class="h4 fw-bold text-dark mb-0">{{ $course->title }}</h2>
            <small class="text-muted">{{ $course->level->name }}</small>
        </div>
        <div class="d-flex gap-2 flex-column flex-sm-row w-100 w-sm-auto">
            <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-warning btn-sm">
                <i class="bi bi-pencil-square me-2"></i>Edit
            </a>
            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteCourseModal">
                <i class="bi bi-trash me-2"></i>Delete
            </button>
            <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-2"></i>Back
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="py-2 py-md-3">
        <div class="row g-3">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Course Header Card -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="row g-0">
                        <div class="col-md-4">
                            @if($course->thumbnail_path)
                                <img src="{{ asset('storage/' . $course->thumbnail_path) }}" 
                                     alt="{{ $course->title }}"
                                     class="img-fluid rounded-start h-100 object-fit-cover"
                                     style="object-fit: cover; height: 250px;">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center rounded-start h-100"
                                     style="height: 250px;">
                                    <div class="text-center text-muted">
                                        <i class="bi bi-image fs-1"></i>
                                        <p class="mt-2">No thumbnail</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-8">
                            <div class="card-body p-4">
                                <div class="mb-3">
                                    <span class="badge bg-primary">{{ $course->level->name }}</span>
                                    @if($course->is_active)
                                        <span class="badge bg-success">Published</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Draft</span>
                                    @endif
                                </div>

                                @if($course->description)
                                    <p class="text-muted mb-0">
                                        {{ Str::limit($course->description, 200) }}
                                    </p>
                                @else
                                    <p class="text-muted mb-0 fst-italic">No description provided</p>
                                @endif

                                <hr class="my-3">

                                <div class="row g-2">
                                    <div class="col-6">
                                        <small class="text-muted">Videos</small>
                                        <p class="fw-semibold text-dark mb-0">{{ $course->videos->count() }}</p>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Created</small>
                                        <p class="fw-semibold text-dark mb-0">{{ $course->created_at->format('M d, Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Full Description -->
                @if($course->description)
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white border-bottom py-3 px-4">
                            <h5 class="card-title fw-bold mb-0">Description</h5>
                        </div>
                        <div class="card-body p-4">
                            <p class="text-dark mb-0" style="line-height: 1.6;">
                                {{ $course->description }}
                            </p>
                        </div>
                    </div>
                @endif

                <!-- Videos Section -->
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
                        <h5 class="card-title fw-bold mb-0">
                            <i class="bi bi-play-circle me-2 text-primary"></i>Videos ({{ $course->videos->count() }})
                        </h5>
                        <a href="{{ route('admin.videos.create') }}" 
                           class="btn btn-sm btn-primary">
                            <i class="bi bi-plus-circle me-1"></i>Add Video
                        </a>
                    </div>
                    <div class="card-body p-0">
                        @if($course->videos->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach($course->videos as $video)
                                    <div class="list-group-item px-4 py-3 d-flex justify-content-between align-items-center">
                                        <div class="flex-grow-1">
                                            <h6 class="fw-semibold text-dark mb-1">
                                                <i class="bi bi-play-fill text-primary me-2"></i>{{ $video->title }}
                                            </h6>
                                            <small class="text-muted">
                                                Duration: 
                                                @if($video->duration)
                                                    {{ gmdate('H:i:s', $video->duration) }}
                                                @else
                                                    Not set
                                                @endif
                                            </small>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.videos.edit', $video) }}" 
                                               class="btn btn-sm btn-outline-primary" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger" 
                                                    title="Delete"
                                                    onclick="deleteVideo({{ $video->id }})">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="p-4 text-center text-muted">
                                <p class="mb-0">No videos added yet. Start by adding your first video.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Course Stats Card -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white border-bottom py-3 px-4">
                        <h6 class="card-title fw-bold mb-0">
                            <i class="bi bi-bar-chart text-info me-2"></i>Course Statistics
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <small class="text-muted">Total Videos</small>
                            <p class="fw-bold fs-5 text-dark mb-0">{{ $course->videos->count() }}</p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Status</small>
                            <p class="fw-bold text-dark mb-0">
                                @if($course->is_active)
                                    <span class="badge bg-success">Published</span>
                                @else
                                    <span class="badge bg-warning text-dark">Draft</span>
                                @endif
                            </p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Slug</small>
                            <p class="text-monospace text-dark mb-0" style="font-size: 0.85rem;">
                                {{ $course->slug }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Timeline Card -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white border-bottom py-3 px-4">
                        <h6 class="card-title fw-bold mb-0">
                            <i class="bi bi-calendar-event text-secondary me-2"></i>Timeline
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <small class="text-muted">Created</small>
                            <p class="fw-semibold text-dark mb-0">{{ $course->created_at->format('M d, Y H:i') }}</p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Last Updated</small>
                            <p class="fw-semibold text-dark mb-0">{{ $course->updated_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom py-3 px-4">
                        <h6 class="card-title fw-bold mb-0">
                            <i class="bi bi-lightning-fill text-warning me-2"></i>Quick Actions
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-pencil-square me-2"></i>Edit Course
                            </a>
                            <a href="{{ route('admin.videos.create') }}" 
                               class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-plus-circle me-2"></i>Add Video
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Course Modal -->
    <div class="modal fade" id="deleteCourseModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content border-0">
                <div class="modal-header bg-danger bg-opacity-10 border-0">
                    <h5 class="modal-title fw-bold text-danger">Delete Course?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-2">Are you sure you want to delete this course?</p>
                    <p class="text-danger small mb-0">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        This action cannot be undone. All associated data will be removed.
                    </p>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form method="POST" action="{{ route('admin.courses.destroy', $course) }}" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash me-2"></i>Delete Course
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function deleteVideo(videoId) {
            if (confirm('Are you sure you want to delete this video?')) {
                // Implement video deletion via AJAX if needed
                console.log('Delete video:', videoId);
            }
        }
    </script>
@endsection
