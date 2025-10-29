@extends('layouts.admin')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Admin Dashboard') }}
    </h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Message -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-2">Welcome back, {{ Auth::user()->name }}! 👋</h3>
                    <p class="text-gray-600">You're logged in as an administrator. Here's an overview of your SmartCampus platform.</p>
                </div>
            </div>

            <!-- Statistics Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <!-- Levels Stats -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 uppercase">Levels</p>
                                <p class="text-3xl font-bold text-gray-900">{{ $stats['levels'] }}</p>
                                <p class="text-sm text-gray-500 mt-1">{{ $stats['active_levels'] }} active</p>
                            </div>
                            <div class="bg-blue-100 p-3 rounded-full">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Courses Stats -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 uppercase">Courses</p>
                                <p class="text-3xl font-bold text-gray-900">{{ $stats['courses'] }}</p>
                                <p class="text-sm text-gray-500 mt-1">{{ $stats['active_courses'] }} active</p>
                            </div>
                            <div class="bg-green-100 p-3 rounded-full">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Videos Stats -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 uppercase">Videos</p>
                                <p class="text-3xl font-bold text-gray-900">{{ $stats['videos'] }}</p>
                                <p class="text-sm text-gray-500 mt-1">{{ $stats['active_videos'] }} active</p>
                            </div>
                            <div class="bg-purple-100 p-3 rounded-full">
                                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Notes Stats -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 uppercase">Notes</p>
                                <p class="text-3xl font-bold text-gray-900">{{ $stats['notes'] }}</p>
                                <p class="text-sm text-gray-500 mt-1">Study materials</p>
                            </div>
                            <div class="bg-yellow-100 p-3 rounded-full">
                                <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="#" class="flex items-center p-4 border-2 border-gray-200 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition duration-150">
                            <div class="bg-blue-100 p-3 rounded-full mr-4">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">Add New Course</p>
                                <p class="text-sm text-gray-600">Create a new course</p>
                            </div>
                        </a>

                        <a href="#" class="flex items-center p-4 border-2 border-gray-200 rounded-lg hover:border-purple-500 hover:bg-purple-50 transition duration-150">
                            <div class="bg-purple-100 p-3 rounded-full mr-4">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">Upload Video</p>
                                <p class="text-sm text-gray-600">Add new video content</p>
                            </div>
                        </a>

                        <a href="#" class="flex items-center p-4 border-2 border-gray-200 rounded-lg hover:border-green-500 hover:bg-green-50 transition duration-150">
                            <div class="bg-green-100 p-3 rounded-full mr-4">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">Create Note</p>
                                <p class="text-sm text-gray-600">Add study materials</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Recent Courses -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Courses</h3>
                        @if($recentCourses->count() > 0)
                            <div class="space-y-3">
                                @foreach($recentCourses as $course)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                        <div class="flex-1">
                                            <p class="font-medium text-gray-900">{{ $course->title }}</p>
                                            <p class="text-sm text-gray-600">{{ $course->level->name }} • {{ $course->created_at->diffForHumans() }}</p>
                                        </div>
                                        <span class="px-2 py-1 text-xs font-semibold rounded {{ $course->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ $course->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-center py-4">No courses yet. Create your first course!</p>
                        @endif
                    </div>
                </div>

                <!-- Recent Videos -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Videos</h3>
                        @if($recentVideos->count() > 0)
                            <div class="space-y-3">
                                @foreach($recentVideos as $video)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                        <div class="flex-1">
                                            <p class="font-medium text-gray-900">{{ $video->title }}</p>
                                            <p class="text-sm text-gray-600">{{ $video->course->title }} • {{ $video->created_at->diffForHumans() }}</p>
                                        </div>
                                        <span class="px-2 py-1 text-xs font-semibold rounded {{ $video->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ $video->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-center py-4">No videos yet. Upload your first video!</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- System Info -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">System Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <p class="text-sm text-gray-600">Total Users</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_users'] }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Admin Users</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['admin_users'] }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Platform Version</p>
                            <p class="text-2xl font-bold text-gray-900">v1.0.0</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

