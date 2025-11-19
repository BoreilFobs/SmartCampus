@extends('layouts.app')

@section('title', 'Profile Settings - SmartCampus')

@section('content')
<div class="container px-3 px-md-4 py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="mb-0" style="font-weight: 600; color: #212529;">
                    <i class="bi bi-person-circle"></i> Profile Settings
                </h3>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- User Info Summary Card -->
        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4 text-center">
                    <div class="mb-3">
                        <i class="bi bi-person-circle" style="font-size: 5rem; color: #667eea;"></i>
                    </div>
                    <h4 class="mb-1" style="font-weight: 600; color: #212529;">{{ Auth::user()->name }}</h4>
                    <p class="text-muted mb-3">{{ Auth::user()->email }}</p>
                    
                    <div class="border-top pt-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Account Type:</span>
                            <span class="badge {{ Auth::user()->is_admin ? 'bg-danger' : 'bg-primary' }}">
                                {{ Auth::user()->is_admin ? 'Admin' : 'Student' }}
                            </span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Member Since:</span>
                            <span style="color: #212529; font-weight: 500;">
                                {{ Auth::user()->created_at->format('M Y') }}
                            </span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Email Verified:</span>
                            @if(Auth::user()->email_verified_at)
                                <span class="text-success">
                                    <i class="bi bi-check-circle-fill"></i> Yes
                                </span>
                            @else
                                <span class="text-warning">
                                    <i class="bi bi-exclamation-circle-fill"></i> No
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-body p-4">
                    <h6 class="mb-3" style="font-weight: 600; color: #212529;">
                        <i class="bi bi-bar-chart-fill"></i> My Activity
                    </h6>
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-calendar-check-fill text-success me-2"></i>
                            <span class="text-muted">Total Bookings</span>
                        </div>
                        <span style="color: #212529; font-weight: 600; font-size: 1.1rem;">
                            {{ Auth::user()->bookings()->count() }}
                        </span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-clock-fill text-warning me-2"></i>
                            <span class="text-muted">Pending</span>
                        </div>
                        <span style="color: #212529; font-weight: 600; font-size: 1.1rem;">
                            {{ Auth::user()->bookings()->where('status', 'pending')->count() }}
                        </span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-check-circle-fill text-primary me-2"></i>
                            <span class="text-muted">Completed</span>
                        </div>
                        <span style="color: #212529; font-weight: 600; font-size: 1.1rem;">
                            {{ Auth::user()->bookings()->where('status', 'completed')->count() }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Forms -->
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
                    <h5 class="mb-0 text-white" style="font-weight: 600;">
                        <i class="bi bi-pencil-fill"></i> Update Profile Information
                    </h5>
                </div>
                <div class="card-body p-4">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0" style="font-weight: 600; color: #212529;">
                        <i class="bi bi-shield-lock-fill"></i> Update Password
                    </h5>
                </div>
                <div class="card-body p-4">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-danger">
                    <h5 class="mb-0 text-white" style="font-weight: 600;">
                        <i class="bi bi-exclamation-triangle-fill"></i> Delete Account
                    </h5>
                </div>
                <div class="card-body p-4">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
