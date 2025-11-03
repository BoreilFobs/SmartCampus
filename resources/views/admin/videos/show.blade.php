@extends('layouts.admin')

@section('header')
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-sm-items-center gap-2">
        <div>
            <h2 class="h4 fw-bold text-dark mb-0">{{ $video->title }}</h2>
            <small class="text-muted">{{ $video->course->title }}</small>
        </div>
        <div class="d-flex gap-2 flex-column flex-sm-row w-100 w-sm-auto">
            <a href="{{ route('admin.videos.edit', $video) }}" class="btn btn-warning btn-sm">
                <i class="bi bi-pencil-square me-2"></i>Edit
            </a>
            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteVideoModal">
                <i class="bi bi-trash me-2"></i>Delete
            </button>
            <a href="{{ route('admin.videos.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-2"></i>Back
            </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="py-2 py-md-3">
        <div class="row g-3">
            <!-- Main Content -->
            <div class="col-12 col-lg-8">
                <!-- Video Player Card -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body p-4">
                        <div class="bg-dark rounded d-flex align-items-center justify-content-center" style="height: 300px;">
                            @if($video->video_path)
                                <video width="100%" height="100%" controls class="rounded" style="object-fit: contain;">
                                    <source src="{{ asset('storage/' . $video->video_path) }}" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            @else
                                <div class="text-center text-muted">
                                    <i class="bi bi-exclamation-triangle" style="font-size: 3rem;"></i>
                                    <p class="mt-3">No video file found</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Video Details Card -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white border-bottom py-3 px-4">
                        <h5 class="card-title fw-bold mb-0">Video Details</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <small class="text-muted">Status</small>
                                <p class="fw-semibold text-dark mb-0">
                                    @if($video->is_active)
                                        <span class="badge bg-success">Published</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Draft</span>
                                    @endif
                                </p>
                            </div>
                            <div class="col-sm-6">
                                <small class="text-muted">Course</small>
                                <p class="fw-semibold text-dark mb-0">{{ $video->course->title }}</p>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <small class="text-muted">File Size</small>
                                <p class="fw-semibold text-dark mb-0">{{ formatBytes($video->file_size) }}</p>
                            </div>
                            <div class="col-sm-6">
                                <small class="text-muted">Duration</small>
                                <p class="fw-semibold text-dark mb-0">
                                    @if($video->duration)
                                        {{ gmdate('H:i:s', $video->duration) }}
                                    @else
                                        Not set
                                    @endif
                                </p>
                            </div>
                        </div>
                        @if($video->description)
                            <div>
                                <small class="text-muted">Description</small>
                                <p class="text-dark mb-0" style="line-height: 1.6;">{{ $video->description }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Notes Section -->
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
                        <h5 class="card-title fw-bold mb-0">
                            <i class="bi bi-file-earmark-text text-primary me-2"></i>Study Notes ({{ $video->notes->count() }})
                        </h5>
                        <a href="{{ route('admin.notes.create') }}" class="btn btn-sm btn-primary">
                            <i class="bi bi-plus-circle me-1"></i>Add Note
                        </a>
                    </div>
                    <div class="card-body p-0">
                        @if($video->notes->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach($video->notes as $note)
                                    <div class="list-group-item px-4 py-3">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="flex-grow-1">
                                                <h6 class="fw-semibold text-dark mb-1">
                                                    <i class="bi bi-file-earmark-text text-primary me-2"></i>Study Material
                                                </h6>
                                                <small class="text-muted">
                                                    Created: {{ $note->created_at->format('M d, Y') }}
                                                </small>
                                            </div>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('admin.notes.edit', $note) }}" 
                                                   class="btn btn-sm btn-outline-primary" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-outline-danger" 
                                                        onclick="deleteNote({{ $note->id }})" title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="p-4 text-center text-muted">
                                <p class="mb-0">No study notes yet. Add your first note.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-12 col-lg-4">
                <!-- Video Stats Card -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white border-bottom py-3 px-4">
                        <h6 class="card-title fw-bold mb-0">
                            <i class="bi bi-bar-chart text-info me-2"></i>Video Statistics
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <small class="text-muted">Title</small>
                            <p class="fw-bold text-dark mb-0">{{ Str::limit($video->title, 30) }}</p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">File Size</small>
                            <p class="fw-bold text-dark mb-0">{{ formatBytes($video->file_size) }}</p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Status</small>
                            <p class="fw-bold text-dark mb-0">
                                @if($video->is_active)
                                    <span class="badge bg-success">Published</span>
                                @else
                                    <span class="badge bg-warning text-dark">Draft</span>
                                @endif
                            </p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Study Notes</small>
                            <p class="fw-bold text-dark mb-0">{{ $video->notes->count() }}</p>
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
                            <small class="text-muted">Uploaded</small>
                            <p class="fw-semibold text-dark mb-0">{{ $video->created_at->format('M d, Y H:i') }}</p>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">Last Updated</small>
                            <p class="fw-semibold text-dark mb-0">{{ $video->updated_at->format('M d, Y H:i') }}</p>
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
                            <a href="{{ route('admin.videos.edit', $video) }}" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-pencil-square me-2"></i>Edit Video
                            </a>
                            <a href="{{ route('admin.notes.create') }}" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-plus-circle me-2"></i>Add Study Note
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Video Modal -->
    <div class="modal fade" id="deleteVideoModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content border-0">
                <div class="modal-header bg-danger bg-opacity-10 border-0">
                    <h5 class="modal-title fw-bold text-danger">Delete Video?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-2">Are you sure you want to delete this video?</p>
                    <p class="text-danger small mb-0">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        This action cannot be undone.
                    </p>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form method="POST" action="{{ route('admin.videos.destroy', $video) }}" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash me-2"></i>Delete Video
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function deleteNote(noteId) {
            if (confirm('Are you sure you want to delete this note?')) {
                // Implement via AJAX or form submission if needed
                console.log('Delete note:', noteId);
            }
        }
    </script>
@endsection
