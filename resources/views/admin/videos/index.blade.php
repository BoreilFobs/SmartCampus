@extends('layouts.admin')

@section('header')
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-sm-items-center gap-3">
        <div>
            <h2 class="h4 fw-bold text-dark mb-0">Manage Videos</h2>
            <small class="text-muted">Upload, edit, and organize videos</small>
        </div>
        <a href="{{ route('admin.videos.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-cloud-upload me-2"></i>Upload Video
        </a>
    </div>
@endsection

@section('content')
    <div class="py-2 py-md-3">
        <!-- Videos Table -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom py-3 px-3 px-md-4">
                <h5 class="card-title fw-bold text-dark mb-0">
                    <i class="bi bi-film text-primary me-2"></i>Videos
                </h5>
            </div>
            <div class="card-body p-0">
                @if($videos->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3 ps-md-4">Video Title</th>
                                    <th class="d-none d-lg-table-cell">Course</th>
                                    <th class="d-none d-md-table-cell">File Size</th>
                                    <th class="d-none d-xl-table-cell">Status</th>
                                    <th class="d-none d-xl-table-cell">Uploaded</th>
                                    <th class="pe-3 pe-md-4 text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($videos as $video)
                                    <tr>
                                        <td class="ps-3 ps-md-4">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="bg-info bg-opacity-10 rounded d-flex align-items-center justify-content-center flex-shrink-0" 
                                                     style="width: 40px; height: 40px;">
                                                    <i class="bi bi-play-fill text-info" style="font-size: 1rem;"></i>
                                                </div>
                                                <div class="text-truncate">
                                                    <p class="fw-semibold text-dark mb-0 text-truncate" style="font-size: 0.95rem;">{{ $video->title }}</p>
                                                    <small class="text-muted d-none d-md-block text-truncate">{{ Str::limit($video->description, 30) }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="d-none d-lg-table-cell">
                                            <span class="badge bg-secondary">{{ $video->course->title ?? 'N/A' }}</span>
                                        </td>
                                        <td class="d-none d-md-table-cell">
                                            <small class="text-muted">{{ formatBytes($video->file_size) }}</small>
                                        </td>
                                        <td class="d-none d-xl-table-cell">
                                            @if($video->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td class="d-none d-xl-table-cell">
                                            <small class="text-muted">{{ $video->created_at->format('M d') }}</small>
                                        </td>
                                        <td class="pe-3 pe-md-4 text-end">
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ route('admin.videos.show', $video) }}" 
                                                   class="btn btn-outline-primary" 
                                                   title="View">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.videos.edit', $video) }}" 
                                                   class="btn btn-outline-secondary" 
                                                   title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button type="button" 
                                                        class="btn btn-outline-danger" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#deleteModal{{ $video->id }}"
                                                        title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $video->id }}" tabindex="-1">
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
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="card-footer bg-light border-top p-3">
                        {{ $videos->links() }}
                    </div>
                @else
                    <div class="p-5 text-center">
                        <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                        <p class="text-muted mt-3">No videos uploaded yet.</p>
                        <a href="{{ route('admin.videos.create') }}" class="btn btn-primary btn-sm mt-2">
                            <i class="bi bi-cloud-upload me-2"></i>Upload Your First Video
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
