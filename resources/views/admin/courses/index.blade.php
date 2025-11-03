@extends('layouts.admin')

@section('header')
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-sm-items-center gap-3">
        <div>
            <h2 class="h4 fw-bold text-dark mb-0">Manage Courses</h2>
            <small class="text-muted">Create, edit, and organize courses</small>
        </div>
        <a href="{{ route('admin.courses.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-circle me-2"></i>Add New Course
        </a>
    </div>
@endsection

@section('content')
    <div class="py-3">
        <!-- Filters -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-3">
                <form method="GET" action="{{ route('admin.courses.index') }}" class="row g-2 g-md-3">
                    <div class="col-12 col-md-4">
                        <label for="level_filter" class="form-label small">Filter by Level:</label>
                        <select id="level_filter" name="level_id" class="form-select form-select-sm">
                            <option value="">All Levels</option>
                            @foreach($levels as $level)
                                <option value="{{ $level->id }}" {{ request('level_id') == $level->id ? 'selected' : '' }}>
                                    {{ $level->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-4">
                        <label for="search" class="form-label small">Search Courses:</label>
                        <input type="text" id="search" name="search" class="form-control form-control-sm" 
                               placeholder="Search by title..." value="{{ request('search') }}">
                    </div>
                    <div class="col-12 col-md-4 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-outline-primary btn-sm flex-grow-1">
                            <i class="bi bi-search me-1"></i>Search
                        </button>
                        <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-arrow-clockwise"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Courses Table -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom py-3 px-3 px-md-4">
                <h5 class="card-title fw-bold text-dark mb-0">
                    <i class="bi bi-book-fill text-primary me-2"></i>Courses
                </h5>
            </div>
            <div class="card-body p-0">
                @if($courses->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3 ps-md-4">Course Title</th>
                                    <th class="d-none d-lg-table-cell">Level</th>
                                    <th class="d-none d-md-table-cell">Videos</th>
                                    <th class="d-none d-xl-table-cell">Status</th>
                                    <th class="d-none d-xl-table-cell">Created</th>
                                    <th class="pe-3 pe-md-4 text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($courses as $course)
                                    <tr>
                                        <td class="ps-3 ps-md-4">
                                            <div class="d-flex align-items-center gap-2">
                                                @if($course->thumbnail_path)
                                                    <img src="{{ asset('storage/' . $course->thumbnail_path) }}" 
                                                         alt="{{ $course->title }}" 
                                                         class="rounded" 
                                                         style="width: 40px; height: 40px; object-fit: cover; flex-shrink: 0;">
                                                @else
                                                    <div class="bg-light rounded d-flex align-items-center justify-content-center flex-shrink-0" 
                                                         style="width: 40px; height: 40px;">
                                                        <i class="bi bi-image text-muted" style="font-size: 0.8rem;"></i>
                                                    </div>
                                                @endif
                                                <div class="text-truncate">
                                                    <p class="fw-semibold text-dark mb-0 text-truncate" style="font-size: 0.95rem;">{{ $course->title }}</p>
                                                    <small class="text-muted d-none d-md-block text-truncate">{{ Str::limit($course->description, 30) }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="d-none d-lg-table-cell">
                                            <span class="badge bg-info text-dark">{{ $course->level->name }}</span>
                                        </td>
                                        <td class="d-none d-md-table-cell">
                                            <span class="badge bg-secondary">{{ $course->videos_count ?? 0 }}</span>
                                        </td>
                                        <td class="d-none d-xl-table-cell">
                                            @if($course->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td class="d-none d-xl-table-cell">
                                            <small class="text-muted">{{ $course->created_at->format('M d') }}</small>
                                        </td>
                                        <td class="pe-3 pe-md-4 text-end">
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="{{ route('admin.courses.show', $course) }}" 
                                                   class="btn btn-outline-primary" 
                                                   title="View">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.courses.edit', $course) }}" 
                                                   class="btn btn-outline-secondary" 
                                                   title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button type="button" 
                                                        class="btn btn-outline-danger" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#deleteModal{{ $course->id }}"
                                                        title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $course->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Delete Course</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p class="mb-0">Are you sure you want to delete <strong>{{ $course->title }}</strong>?</p>
                                                    <small class="text-muted d-block mt-2">This will also delete all associated videos and notes.</small>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <form method="POST" action="{{ route('admin.courses.destroy', $course) }}" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Delete Course</button>
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
                    <div class="d-flex justify-content-center p-4">
                        {{ $courses->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                        <p class="text-muted mt-3 mb-4">No courses found</p>
                        <a href="{{ route('admin.courses.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-2"></i>Create Your First Course
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
