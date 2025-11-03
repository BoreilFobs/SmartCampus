@extends('layouts.admin')

@section('header')
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-sm-items-center gap-2">
        <div>
            <h2 class="h4 fw-bold text-dark mb-0">Note Details</h2>
            <small class="text-muted">{{ $note->video->title }}</small>
        </div>
        <div class="d-flex gap-2 flex-column flex-sm-row w-100 w-sm-auto">
            <a href="{{ route('admin.notes.edit', $note) }}" class="btn btn-warning btn-sm">
                <i class="bi bi-pencil-square me-2"></i>Edit
            </a>
            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteNoteModal">
                <i class="bi bi-trash me-2"></i>Delete
            </button>
            <a href="{{ route('admin.notes.index') }}" class="btn btn-outline-secondary btn-sm">
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
                <!-- Note Content Card -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white border-bottom py-3 px-4">
                        <h5 class="card-title fw-bold mb-0">Note Content</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="prose prose-sm max-w-none" style="line-height: 1.8;">
                            {!! $note->content !!}
                        </div>
                    </div>
                </div>

                <!-- PDF Section -->
                @if($note->hasPdf())
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
                            <h5 class="card-title fw-bold mb-0">
                                <i class="bi bi-file-pdf text-danger me-2"></i>PDF Summary
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <div class="bg-light p-3 rounded">
                                    <i class="bi bi-file-pdf text-danger" style="font-size: 1.5rem;"></i>
                                </div>
                                <div>
                                    <p class="fw-semibold text-dark mb-1">{{ basename($note->pdf_path) }}</p>
                                    <small class="text-muted">
                                        Size: {{ formatBytes(Storage::disk('public')->size($note->pdf_path)) }}
                                    </small>
                                </div>
                            </div>
                            <a href="{{ asset('storage/' . $note->pdf_path) }}" download class="btn btn-sm btn-danger">
                                <i class="bi bi-download me-1"></i>Download PDF
                            </a>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar Info -->
            <div class="col-12 col-lg-4">
                <!-- Note Info Card -->
                <div class="card shadow-sm border-0 sticky-top mb-4" style="top: 20px;">
                    <div class="card-header bg-light border-bottom py-3 px-4">
                        <h6 class="card-title fw-bold mb-0">
                            <i class="bi bi-info-circle text-info me-2"></i>Note Information
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <small class="text-muted">Video Title</small>
                            <p class="fw-semibold text-dark mb-0">{{ $note->video->title }}</p>
                        </div>

                        <hr>

                        <div class="mb-3">
                            <small class="text-muted">Course</small>
                            <p class="fw-semibold text-dark mb-0">{{ $note->video->course->title }}</p>
                        </div>

                        <hr>

                        <div class="mb-3">
                            <small class="text-muted">Level</small>
                            <p class="fw-semibold text-dark mb-0">{{ $note->video->course->level->name }}</p>
                        </div>

                        <hr>

                        <div class="mb-3">
                            <small class="text-muted">Created By</small>
                            <p class="fw-semibold text-dark mb-0">{{ $note->creator->name ?? 'Unknown' }}</p>
                        </div>

                        <hr>

                        <div class="mb-3">
                            <small class="text-muted">Created Date</small>
                            <p class="fw-semibold text-dark mb-0">{{ $note->created_at->format('M d, Y H:i') }}</p>
                        </div>

                        @if($note->updated_at->ne($note->created_at))
                            <hr>
                            <div class="mb-3">
                                <small class="text-muted">Last Updated</small>
                                <p class="fw-semibold text-dark mb-0">{{ $note->updated_at->format('M d, Y H:i') }}</p>
                            </div>
                        @endif

                        <hr>

                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.notes.edit', $note) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil me-1"></i>Edit Note
                            </a>
                            <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteNoteModal">
                                <i class="bi bi-trash me-1"></i>Delete Note
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions Card -->
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-light border-bottom py-3 px-4">
                        <h6 class="card-title fw-bold mb-0">
                            <i class="bi bi-lightning text-warning me-2"></i>Quick Actions
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <a href="{{ route('admin.videos.show', $note->video) }}" class="btn btn-sm btn-outline-primary w-100">
                            <i class="bi bi-play-circle me-1"></i>View Video
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Modal -->
    <div class="modal fade" id="deleteNoteModal" tabindex="-1" aria-labelledby="deleteNoteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-bottom">
                    <h5 class="modal-title" id="deleteNoteLabel">Delete Note</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this note? This action cannot be undone.</p>
                    <div class="bg-light p-3 rounded">
                        <p class="mb-1"><strong>Video:</strong> {{ $note->video->title }}</p>
                        <p class="mb-0"><strong>Course:</strong> {{ $note->video->course->title }}</p>
                    </div>
                </div>
                <div class="modal-footer border-top">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('admin.notes.destroy', $note) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete Note</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .prose {
            color: #333;
            font-size: 1rem;
        }
        .prose h1, .prose h2, .prose h3, .prose h4, .prose h5, .prose h6 {
            margin-top: 1.5em;
            margin-bottom: 0.5em;
            font-weight: 600;
        }
        .prose p {
            margin-bottom: 1em;
        }
        .prose ul, .prose ol {
            margin-left: 1.5em;
            margin-bottom: 1em;
        }
        .prose code {
            background-color: #f5f5f5;
            padding: 0.2em 0.4em;
            border-radius: 3px;
            font-family: monospace;
        }
        .prose pre {
            background-color: #f5f5f5;
            padding: 1em;
            border-radius: 5px;
            overflow-x: auto;
            margin-bottom: 1em;
        }
        .prose blockquote {
            border-left: 4px solid #ddd;
            margin-left: 0;
            padding-left: 1em;
            color: #666;
        }
    </style>
@endsection
