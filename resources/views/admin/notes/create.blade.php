@extends('layouts.admin')

@section('header')
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-sm-items-center gap-2">
        <div>
            <h2 class="h4 fw-bold text-dark mb-0">Create New Note</h2>
            <small class="text-muted">Add study materials and notes for a video</small>
        </div>
        <a href="{{ route('admin.notes.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-2"></i>Back
        </a>
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
                        <form action="{{ route('admin.notes.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

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
                                                        <option value="{{ $video->id }}" {{ old('video_id') == $video->id ? 'selected' : '' }}>
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
                                <textarea id="content" name="content" class="form-control @error('content') is-invalid @enderror" rows="10">{{ old('content') }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                                <small class="text-muted d-block mt-2">Use the editor to format your note with rich text, code blocks, and more.</small>
                            </div>

                            <!-- PDF Upload -->
                            <div class="mb-4">
                                <label for="pdf_path" class="form-label fw-semibold">Upload PDF (Optional)</label>
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
                                    <i class="bi bi-check-circle me-2"></i>Create Note
                                </button>
                                <a href="{{ route('admin.notes.index') }}" class="btn btn-outline-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Sidebar Help -->
            <div class="col-12 col-lg-4">
                <div class="card shadow-sm border-0 sticky-top" style="top: 20px;">
                    <div class="card-header bg-light border-bottom py-3 px-4">
                        <h6 class="card-title fw-bold mb-0">
                            <i class="bi bi-info-circle text-info me-2"></i>Note Tips
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <small class="fw-semibold text-dark d-block mb-2">💾 Content</small>
                            <small class="text-muted">Write comprehensive study notes with formatting. You can use the editor below to add bold, italic, lists, and code blocks.</small>
                        </div>

                        <hr>

                        <div class="mb-3">
                            <small class="fw-semibold text-dark d-block mb-2">📄 PDF Summary</small>
                            <small class="text-muted">Optionally attach a PDF file with a summary or transcript. Maximum file size: 20 MB.</small>
                        </div>

                        <hr>

                        <div class="mb-3">
                            <small class="fw-semibold text-dark d-block mb-2">✏️ Format Your Note</small>
                            <small class="text-muted">
                                <ul class="ps-3 mb-0">
                                    <li>Use <strong>bold</strong> for emphasis</li>
                                    <li>Create lists for organized content</li>
                                    <li>Add code blocks for technical content</li>
                                    <li>Include links and images as needed</li>
                                </ul>
                            </small>
                        </div>

                        <hr>

                        <div>
                            <small class="fw-semibold text-dark d-block mb-2">ℹ️ Important</small>
                            <small class="text-muted">Make sure to select the correct video before saving. Notes are linked to specific videos.</small>
                        </div>
                    </div>
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
