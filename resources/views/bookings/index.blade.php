@extends('layouts.app')

@section('title', 'My Class Bookings - SmartCampus')

@section('content')
<style>
    @keyframes pulse {
        0%, 100% {
            box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.7);
        }
        50% {
            box-shadow: 0 0 0 10px rgba(40, 167, 69, 0);
        }
    }
    
    .pulse-animation {
        animation: pulse 2s infinite;
    }
    
    .pulse-animation:hover {
        animation: none;
        transform: scale(1.05);
        transition: transform 0.2s;
    }
    
    .booking-card {
        transition: all 0.3s ease;
    }
    
    .booking-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }
    
    /* Mobile-specific improvements */
    @media (max-width: 768px) {
        .booking-card {
            margin-bottom: 1rem;
        }
        
        .booking-header {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 0.5rem;
        }
        
        .booking-title {
            font-size: 1rem;
            margin-bottom: 0.25rem;
        }
        
        .level-course-box {
            font-size: 0.85rem;
            padding: 0.5rem !important;
        }
        
        .zoom-btn {
            font-size: 0.95rem;
            padding: 0.75rem !important;
        }
        
        .alert {
            font-size: 0.9rem;
        }
        
        .page-header {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 1rem;
        }
        
        .page-header h3 {
            font-size: 1.5rem;
        }
    }
</style>

<div class="container px-3 px-md-4 py-4">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4 page-header">
                <h3 class="mb-0" style="font-weight: 600; color: #212529;">
                    <i class="bi bi-calendar-check"></i> My Class Bookings
                </h3>
                <a href="{{ route('bookings.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> 
                    <span class="d-none d-sm-inline">Book a Class</span>
                    <span class="d-inline d-sm-none">Book</span>
                </a>
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                    <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Bookings List -->
                @if($bookings->count() > 0)
                <div class="row g-3 g-md-4">
                    @foreach($bookings as $booking)
                        <div class="col-12 col-lg-6">
                            <div class="card h-100 booking-card border-0 shadow-sm">
                                <div class="card-header d-flex justify-content-between align-items-center booking-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
                                    <h5 class="mb-0 booking-title text-white" style="font-weight: 600;">{{ $booking->topic }}</h5>
                                    <span class="badge bg-white text-{{ $booking->status_badge_color }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </div>
                                <div class="card-body">
                                    <!-- Level & Course -->
                                    <div class="mb-3 p-3 rounded level-course-box" style="background: #f8f9fa;">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-bookmark-fill me-2" style="color: #667eea; font-size: 1.2rem;"></i>
                                            <div>
                                                <strong style="color: #212529; font-size: 0.95rem;">
                                                    {{ $booking->level->name }}
                                                </strong>
                                                <br>
                                                <span style="color: #6c757d; font-size: 0.9rem;">
                                                    {{ $booking->course->title }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Description -->
                                    <p style="color: #495057;" class="mb-3">{{ $booking->description }}</p>

                                    <!-- Scheduled Info -->
                                    @if($booking->isScheduled() && $booking->scheduled_at)
                                        @php
                                            $now = now();
                                            $scheduledTime = $booking->scheduled_at;
                                            $isTimeReached = $now->greaterThanOrEqualTo($scheduledTime->subMinutes(15));
                                            $isPast = $now->greaterThan($scheduledTime->copy()->addHours(2));
                                        @endphp
                                        <div class="alert {{ $isTimeReached && !$isPast ? 'alert-success' : 'alert-info' }} mb-3 border-0">
                                            <div class="d-flex align-items-start">
                                                <i class="bi bi-calendar3 me-2 mt-1"></i>
                                                <div>
                                                    <strong>Scheduled for:</strong><br>
                                                    <span style="font-size: 1rem;">
                                                        {{ $booking->scheduled_at->format('l, F j, Y \a\t g:i A') }}
                                                    </span>
                                                    @if($isTimeReached && !$isPast)
                                                        <br><span class="badge bg-success mt-1">
                                                            <i class="bi bi-check-circle"></i> Ready to join
                                                        </span>
                                                    @elseif($isPast)
                                                        <br><span class="badge bg-secondary mt-1">
                                                            <i class="bi bi-clock-history"></i> Class time passed
                                                        </span>
                                                    @else
                                                        <br><span class="badge bg-warning text-dark mt-1">
                                                            <i class="bi bi-hourglass-split"></i> Starts {{ $booking->scheduled_at->diffForHumans() }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Zoom Link -->
                                    @if($booking->hasZoomLink())
                                        @php
                                            $now = now();
                                            $scheduledTime = $booking->scheduled_at;
                                            $isTimeReached = $now->greaterThanOrEqualTo($scheduledTime->subMinutes(15));
                                            $isPast = $now->greaterThan($scheduledTime->copy()->addHours(2));
                                        @endphp
                                        <div class="mb-3">
                                            @if($isTimeReached && !$isPast)
                                                <a href="{{ $booking->zoom_link }}" 
                                                   target="_blank" 
                                                   class="btn btn-success w-100 d-flex align-items-center justify-content-center gap-2 pulse-animation zoom-btn">
                                                    <i class="bi bi-camera-video-fill"></i> 
                                                    <span style="font-weight: 600;">Join Zoom Class Now</span>
                                                </a>
                                                <small class="d-block text-center mt-2" style="color: #6fa86f;">
                                                    <i class="bi bi-check-circle-fill"></i> Class is ready to join!
                                                </small>
                                            @else
                                                <button class="btn btn-secondary w-100 d-flex align-items-center justify-content-center gap-2 zoom-btn" 
                                                        disabled
                                                        title="{{ $isPast ? 'Class time has passed' : 'Available 15 minutes before class' }}">
                                                    <i class="bi bi-camera-video"></i> 
                                                    <span class="text-truncate">
                                                        @if($isPast)
                                                            Zoom Class Ended
                                                        @else
                                                            <span class="d-none d-sm-inline">Available {{ $booking->scheduled_at->subMinutes(15)->diffForHumans() }}</span>
                                                            <span class="d-inline d-sm-none">Not yet available</span>
                                                        @endif
                                                    </span>
                                                </button>
                                                @if(!$isPast)
                                                    <small class="d-block text-center mt-2" style="color: var(--text-secondary);">
                                                        <i class="bi bi-hourglass-split"></i> 
                                                        <span class="d-none d-sm-inline">Zoom will be available 15 minutes before class starts</span>
                                                        <span class="d-inline d-sm-none">Available 15 min before class</span>
                                                    </small>
                                                @endif
                                            @endif
                                        </div>
                                    @endif

                                    <!-- Admin Notes -->
                                    @if($booking->admin_notes)
                                        <div class="alert alert-warning mb-3 border-0">
                                            <div class="d-flex align-items-start">
                                                <i class="bi bi-info-circle-fill me-2"></i>
                                                <div>
                                                    <strong>Admin Note:</strong><br>
                                                    <span>{{ $booking->admin_notes }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Request Date -->
                                    <small class="text-muted">
                                        <i class="bi bi-clock"></i> Requested {{ $booking->created_at->diffForHumans() }}
                                    </small>
                                </div>
                                <div class="card-footer bg-light border-0">
                                    @if(in_array($booking->status, ['pending', 'scheduled']))
                                        <form action="{{ route('bookings.cancel', $booking) }}" method="POST" 
                                              onsubmit="return confirm('Are you sure you want to cancel this booking?')">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-x-circle"></i> Cancel Booking
                                            </button>
                                        </form>
                                    @else
                                        <small class="text-muted">
                                            This booking is {{ $booking->status }}
                                        </small>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $bookings->links() }}
                </div>
            @else
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-calendar-x" style="font-size: 4rem; color: #6c757d;"></i>
                        <h5 class="mt-3 mb-2" style="color: #212529;">No Bookings Yet</h5>
                        <p class="text-muted mb-4">
                            You haven't requested any one-on-one classes yet.
                        </p>
                        <a href="{{ route('bookings.create') }}" class="btn btn-primary px-4">
                            <i class="bi bi-plus-circle"></i> Book Your First Class
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    // Auto-refresh page when Zoom button should become active (only if needed)
    @if($bookings->count() > 0)
        @php
            $nextAvailableTime = null;
            $now = now();
            
            foreach($bookings as $booking) {
                if($booking->scheduled_at && $booking->hasZoomLink() && $booking->isScheduled()) {
                    $scheduledTime = $booking->scheduled_at;
                    $availableTime = $scheduledTime->copy()->subMinutes(15);
                    $classEndTime = $scheduledTime->copy()->addHours(2);
                    
                    // Only set refresh if we're BEFORE the available time (not during or after)
                    if($now->lessThan($availableTime)) {
                        if(!$nextAvailableTime || $availableTime->lessThan($nextAvailableTime)) {
                            $nextAvailableTime = $availableTime;
                        }
                    }
                }
            }
        @endphp
        
        @if($nextAvailableTime && $nextAvailableTime->isFuture())
            @php
                $millisecondsUntilRefresh = max(0, $nextAvailableTime->diffInMilliseconds($now));
            @endphp
            
            @if($millisecondsUntilRefresh > 0)
                setTimeout(function() {
                    console.log('Auto-refreshing to activate Zoom button');
                    location.reload();
                }, {{ $millisecondsUntilRefresh }});
                
                console.log('Page will auto-refresh in {{ round($millisecondsUntilRefresh / 1000 / 60, 1) }} minutes at {{ $nextAvailableTime->format("Y-m-d H:i:s") }}');
            @endif
        @endif
    @endif
</script>
@endsection
