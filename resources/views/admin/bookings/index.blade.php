@extends('layouts.admin')

@section('title', 'Manage Class Bookings - Admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h3><i class="bi bi-calendar-check"></i> Class Bookings Management</h3>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Filter Tabs -->
    <ul class="nav nav-tabs mb-4">
        <li class="nav-item">
            <a class="nav-link {{ !request('status') || request('status') == 'all' ? 'active' : '' }}" 
               href="{{ route('admin.bookings.index') }}">
                All ({{ \App\Models\ClassBooking::count() }})
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request('status') == 'pending' ? 'active' : '' }}" 
               href="{{ route('admin.bookings.index', ['status' => 'pending']) }}">
                Pending ({{ \App\Models\ClassBooking::pending()->count() }})
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request('status') == 'scheduled' ? 'active' : '' }}" 
               href="{{ route('admin.bookings.index', ['status' => 'scheduled']) }}">
                Scheduled ({{ \App\Models\ClassBooking::scheduled()->count() }})
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request('status') == 'completed' ? 'active' : '' }}" 
               href="{{ route('admin.bookings.index', ['status' => 'completed']) }}">
                Completed ({{ \App\Models\ClassBooking::completed()->count() }})
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request('status') == 'cancelled' ? 'active' : '' }}" 
               href="{{ route('admin.bookings.index', ['status' => 'cancelled']) }}">
                Cancelled ({{ \App\Models\ClassBooking::cancelled()->count() }})
            </a>
        </li>
    </ul>

    <!-- Bookings Table -->
    @if($bookings->count() > 0)
        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th style="color: var(--text-primary);">Student</th>
                            <th style="color: var(--text-primary);">Level/Course</th>
                            <th style="color: var(--text-primary);">Topic</th>
                            <th style="color: var(--text-primary);">Status</th>
                            <th style="color: var(--text-primary);">Scheduled</th>
                            <th style="color: var(--text-primary);">Requested</th>
                            <th style="color: var(--text-primary);">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                            <tr style="background-color: var(--card-bg);">
                                <td>
                                    <div>
                                        <strong style="color: var(--text-primary);">{{ $booking->student->name }}</strong><br>
                                        <small style="color: var(--text-secondary);">{{ $booking->student->email }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <span class="badge bg-secondary">{{ $booking->level->name }}</span><br>
                                        <small style="color: var(--text-primary);">{{ $booking->course->title }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <strong style="color: var(--text-primary);">{{ $booking->topic }}</strong><br>
                                        <small style="color: var(--text-secondary);">{{ Str::limit($booking->description, 50) }}</small>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $booking->status_badge_color }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                                <td>
                                    @if($booking->scheduled_at)
                                        <small style="color: var(--text-primary);">
                                            {{ $booking->scheduled_at->format('M j, Y') }}<br>
                                            {{ $booking->scheduled_at->format('g:i A') }}
                                        </small>
                                    @else
                                        <span style="color: var(--text-secondary);">Not scheduled</span>
                                    @endif
                                </td>
                                <td>
                                    <small style="color: var(--text-secondary);">
                                        {{ $booking->created_at->diffForHumans() }}
                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.bookings.edit', $booking) }}" 
                                           class="btn btn-outline-primary" 
                                           title="Schedule Class">
                                            <i class="bi bi-calendar-plus"></i>
                                        </a>
                                        
                                        @if($booking->status != 'completed')
                                            <form action="{{ route('admin.bookings.status', $booking) }}" 
                                                  method="POST" 
                                                  class="d-inline">
                                                @csrf
                                                <input type="hidden" name="status" value="completed">
                                                <button type="submit" 
                                                        class="btn btn-outline-success" 
                                                        title="Mark as Completed">
                                                    <i class="bi bi-check-circle"></i>
                                                </button>
                                            </form>
                                        @endif
                                        
                                        <form action="{{ route('admin.bookings.destroy', $booking) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this booking?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-outline-danger" 
                                                    title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $bookings->appends(request()->query())->links() }}
        </div>
    @else
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="bi bi-calendar-x" style="font-size: 4rem; color: var(--text-secondary);"></i>
                <h5 class="mt-3 mb-2">No Bookings Found</h5>
                <p class="text-secondary">
                    @if(request('status'))
                        No {{ request('status') }} bookings at the moment.
                    @else
                        No class booking requests yet.
                    @endif
                </p>
            </div>
        </div>
    @endif
</div>
@endsection
