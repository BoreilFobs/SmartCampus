@extends('layouts.admin')

@section('title', 'Schedule Class - Admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h3><i class="bi bi-calendar-plus"></i> Schedule Class</h3>
        </div>
    </div>

    <div class="row">
        <!-- Booking Details -->
        <div class="col-lg-5">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Booking Details</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted small">Student</label>
                        <div><strong style="color: var(--text-primary); font-size: 1.1rem;">{{ $booking->student->name }}</strong></div>
                        <div><small style="color: var(--text-secondary);">{{ $booking->student->email }}</small></div>
                    </div>

                    <div class="mb-3">
                        <label class="text-muted small">Level</label>
                        <div><span class="badge bg-secondary" style="font-size: 0.9rem;">{{ $booking->level->name }}</span></div>
                    </div>

                    <div class="mb-3">
                        <label class="text-muted small">Course</label>
                        <div style="color: var(--text-primary); font-weight: 500;">{{ $booking->course->title }}</div>
                    </div>

                    <div class="mb-3">
                        <label class="text-muted small">Topic</label>
                        <div style="color: var(--text-primary); font-weight: 600; font-size: 1.05rem;">{{ $booking->topic }}</div>
                    </div>

                    <div class="mb-3">
                        <label class="text-muted small">Description</label>
                        <div class="p-3 rounded" style="background-color: var(--dark-light); color: var(--text-primary); border: 1px solid var(--border-color);">
                            {{ $booking->description }}
                        </div>
                    </div>

                    <div class="mb-0">
                        <label class="text-muted small">Current Status</label>
                        <div>
                            <span class="badge bg-{{ $booking->status_badge_color }}" style="font-size: 0.9rem;">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Schedule Form -->
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Schedule Information</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.bookings.update', $booking) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Scheduled Date & Time -->
                        <div class="mb-3">
                            <label for="scheduled_at" class="form-label">
                                Scheduled Date & Time <span class="text-danger">*</span>
                            </label>
                            <input 
                                type="datetime-local" 
                                name="scheduled_at" 
                                id="scheduled_at" 
                                class="form-control @error('scheduled_at') is-invalid @enderror"
                                value="{{ old('scheduled_at', $booking->scheduled_at?->format('Y-m-d\TH:i')) }}"
                                required
                                min="{{ now()->format('Y-m-d\TH:i') }}"
                            >
                            @error('scheduled_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Select a date and time for the class
                            </div>
                        </div>

                        <!-- Zoom Link -->
                        <div class="mb-3">
                            <label for="zoom_link" class="form-label">
                                Zoom Meeting Link <span class="text-danger">*</span>
                            </label>
                            <input 
                                type="url" 
                                name="zoom_link" 
                                id="zoom_link" 
                                class="form-control @error('zoom_link') is-invalid @enderror"
                                placeholder="https://zoom.us/j/..."
                                value="{{ old('zoom_link', $booking->zoom_link) }}"
                                required
                            >
                            @error('zoom_link')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Provide the Zoom meeting link for the student
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="mb-3">
                            <label for="status" class="form-label">
                                Status <span class="text-danger">*</span>
                            </label>
                            <select 
                                name="status" 
                                id="status" 
                                class="form-select @error('status') is-invalid @enderror"
                                required
                            >
                                <option value="pending" {{ old('status', $booking->status) == 'pending' ? 'selected' : '' }}>
                                    Pending
                                </option>
                                <option value="scheduled" {{ old('status', $booking->status) == 'scheduled' ? 'selected' : '' }}>
                                    Scheduled
                                </option>
                                <option value="completed" {{ old('status', $booking->status) == 'completed' ? 'selected' : '' }}>
                                    Completed
                                </option>
                                <option value="cancelled" {{ old('status', $booking->status) == 'cancelled' ? 'selected' : '' }}>
                                    Cancelled
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Admin Notes -->
                        <div class="mb-4">
                            <label for="admin_notes" class="form-label">
                                Notes for Student (Optional)
                            </label>
                            <textarea 
                                name="admin_notes" 
                                id="admin_notes" 
                                rows="4" 
                                class="form-control @error('admin_notes') is-invalid @enderror"
                                placeholder="Any additional information or preparation instructions for the student..."
                                maxlength="1000"
                            >{{ old('admin_notes', $booking->admin_notes) }}</textarea>
                            @error('admin_notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Save Schedule
                            </button>
                            <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left"></i> Back
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
