@extends('layouts.admin')

@section('header')
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-sm-items-center gap-2">
        <div>
            <h2 class="h4 fw-bold text-dark mb-0">Study Notes</h2>
            <small class="text-muted">Manage notes and study materials for your videos</small>
        </div>
        <a href="{{ route('admin.notes.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-circle me-2"></i>Add Note
        </a>
    </div>
@endsection

@section('content')
    <div class="py-2 py-md-3">
        <!-- Notes Table -->
        <div class="card shadow-sm border-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3">Video Title</th>
                            <th class="px-4 py-3 d-none d-lg-table-cell">Course</th>
                            <th class="px-4 py-3 d-none d-md-table-cell">Content Preview</th>
                            <th class="px-4 py-3 d-none d-xl-table-cell">Created By</th>
                            <th class="px-4 py-3 d-none d-xl-table-cell">Created Date</th>
                            <th class="px-4 py-3 text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($notes as $note)
                            <tr class="align-middle">
                                <td class="px-4 py-3">
                                    <div>
                                        <small class="text-muted">Video:</small>
                                        <p class="fw-semibold text-dark mb-0">{{ $note->video->title }}</p>
                                    </div>
                                </td>
                                <td class="px-4 py-3 d-none d-lg-table-cell">
                                    <small class="text-muted">{{ $note->video->course->title }}</small>
                                </td>
                                <td class="px-4 py-3 d-none d-md-table-cell">
                                    <small class="text-muted">{{ Str::limit(strip_tags($note->content), 50) }}</small>
                                </td>
                                <td class="px-4 py-3 d-none d-xl-table-cell">
                                    <small class="text-muted">{{ $note->creator->name ?? 'Unknown' }}</small>
                                </td>
                                <td class="px-4 py-3 d-none d-xl-table-cell">
                                    <small class="text-muted">{{ $note->created_at->format('M d, Y') }}</small>
                                </td>
                                <td class="px-4 py-3 text-end">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.notes.show', $note) }}" class="btn btn-sm btn-info" title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.notes.edit', $note) }}" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteNoteModal{{ $note->id }}" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            <!-- Delete Modal -->
                            <div class="modal fade" id="deleteNoteModal{{ $note->id }}" tabindex="-1" aria-labelledby="deleteNoteLabel{{ $note->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header border-bottom">
                                            <h5 class="modal-title" id="deleteNoteLabel{{ $note->id }}">Delete Note</h5>
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
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-5 text-center">
                                    <div class="mb-3">
                                        <i class="bi bi-file-earmark-text text-muted" style="font-size: 2rem;"></i>
                                    </div>
                                    <p class="text-muted mb-3">No notes created yet. Start by creating your first note.</p>
                                    <a href="{{ route('admin.notes.create') }}" class="btn btn-sm btn-primary">
                                        <i class="bi bi-plus-circle me-1"></i>Create First Note
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $notes->links() }}
        </div>
    </div>
@endsection
