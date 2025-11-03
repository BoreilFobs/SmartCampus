@extends('layouts.admin')

@section('header')
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-sm-items-center gap-2">
        <div>
            <h2 class="h4 fw-bold text-dark mb-0">Edit Note</h2>
            <small class="text-muted">Update note for: {{ $note->video->title }}</small>
        </div>
        <div class="d-flex gap-2 flex-column flex-sm-row w-100 w-sm-auto">
            <a href="{{ route('admin.notes.show', $note) }}" class="btn btn-info btn-sm">
                <i class="bi bi-eye me-2"></i>View
            </a>
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
                <!-- Note Form -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body p-4">
                        <form action="{{ route('admin.notes.update', $note) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Video Selection -->
                            <div class="mb-4">
                                <label for="video_id" class="form-label fw-semibold">Select Video <span class="text-danger">*</span></label>
                                <select class="form-select @error('video_id') is-invalid @enderror" id="video_id" name="video_id" required>
                                    <option value="">-- Choose a video --</option>
                                    @foreach($videos->groupBy('course.level.name') as $levelName => $videosByLevel)
                                        <optgroup label="{{ $levelName }}">
                                            @foreach($videosByLevel->groupBy('course.title') as $courseName => $courseVideos)
                                                <optgroup label="&nbsp;&nbsp;{{ $courseName }}" style="margin-left: 20px;">
                                                    @foreach($courseVideos as $video)
                                                        <option value="{{ $video->id }}" {{ $note->video_id == $video->id ? 'selected' : '' }}>
                                                            &nbsp;&nbsp;&nbsp;&nbsp;{{ $video->title }}
                                                        </option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                                @error('video_id')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Note Content -->
                            <div class="mb-4">
                                <label for="content" class="form-label fw-semibold">Note Content <span class="text-danger">*</span></label>
                                <textarea id="content" name="content" class="form-control @error('content') is-invalid @enderror" rows="10">{{ old('content', $note->content) }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <small class="text-muted d-block mt-2">Use the editor to format your note with rich text, code blocks, and more.</small>
                            </div>

                            <!-- PDF Upload Section -->
                            <div class="mb-4">
                                <label for="pdf_path" class="form-label fw-semibold">PDF File (Optional)</label>
                                
                                @if($note->pdf_path)
                                    <div class="alert alert-info mb-3">
                                        <small class="fw-semibold d-block mb-2">Current File:</small>
                                        <small class="d-block">{{ basename($note->pdf_path) }} ({{ formatBytes(Storage::disk('public')->size($note->pdf_path)) }})</small>
                                        <small class="text-muted d-block mt-2">Upload a new file to replace the current one.</small>
                                    </div>
                                @endif

                                <div class="input-group">
                                    <input type="file" class="form-control @error('pdf_path') is-invalid @enderror" id="pdf_path" name="pdf_path" accept=".pdf">
                                    <span class="input-group-text bg-light">PDF</span>
                                </div>
                                @error('pdf_path')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <small class="text-muted d-block mt-2" id="pdf-info"></small>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-2"></i>Update Note
                                </button>
                                <a href="{{ route('admin.notes.index') }}" class="btn btn-outline-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Sidebar Info -->
            <div class="col-12 col-lg-4">
                <div class="card shadow-sm border-0 sticky-top" style="top: 20px;">
                    <div class="card-header bg-light border-bottom py-3 px-4">
                        <h6 class="card-title fw-bold mb-0">
                            <i class="bi bi-file-earmark-text text-primary me-2"></i>Note Information
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <small class="text-muted">Video</small>
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
                            <a href="{{ route('admin.notes.show', $note) }}" class="btn btn-sm btn-outline-info">
                                <i class="bi bi-eye me-1"></i>View Note
                            </a>
                            <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteNoteModal">
                                <i class="bi bi-trash me-1"></i>Delete Note
                            </button>
                        </div>
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

    <!-- TinyMCE Editor CDN -->
    <script src="https://cdn.tiny.cloud/1/haue7crjh1xbbxk70j1d38275csz24yfdps6w5iqcypnjueu/tinymce/8/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: '#content',
            plugins: 'link image code lists table',
            toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | bullist numlist outdent indent | link image | code | removeformat',
            height: 300,
            menubar: false,
            statusbar: true,
            promotion: false,
            content_css: [
                'https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap'
            ],
            body_class: 'tinymce-body',
            setup: function(editor) {
                editor.on('change', function() {
                    editor.save();
                });
            }
        });

        // Handle PDF file input display
        document.getElementById('pdf_path').addEventListener('change', function(e) {
            const file = this.files[0];
            const info = document.getElementById('pdf-info');
            if (file) {
                const size = (file.size / 1024 / 1024).toFixed(2);
                info.textContent = `Selected: ${file.name} (${size} MB)`;
                info.classList.remove('text-danger');
                info.classList.add('text-success');
            } else {
                info.textContent = '';
            }
        });
    </script>

    <style>
        .tinymce-body {
            font-family: 'Roboto', sans-serif;
        }
    </style>
@endsection
