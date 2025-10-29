<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ sidebarOpen: false }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SmartCampus') }} - Admin Panel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen">
        <!-- Admin Navigation -->
        <nav class="bg-gray-800 border-b border-gray-700 fixed w-full z-30">
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- Mobile menu button -->
                        <button @click="sidebarOpen = !sidebarOpen" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:bg-gray-700 focus:text-white transition duration-150 ease-in-out mr-2">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': sidebarOpen, 'inline-flex': !sidebarOpen }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': !sidebarOpen, 'inline-flex': sidebarOpen }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>

                        <!-- Logo -->
                        <div class="shrink-0 flex items-center">
                            <a href="{{ route('admin.dashboard') }}" class="text-white text-xl font-bold">
                                🎓 SmartCampus Admin
                            </a>
                        </div>
                    </div>

                    <!-- Settings Dropdown -->
                    <div class="flex items-center">
                        <span class="text-gray-400 text-sm mr-4 hidden sm:block">Admin Mode</span>
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-400 bg-gray-900 hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                    <div>{{ Auth::user()->name }}</div>

                                    <div class="ml-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('dashboard')">
                                    {{ __('User Dashboard') }}
                                </x-dropdown-link>

                                <x-dropdown-link :href="route('profile.edit')">
                                    {{ __('Profile') }}
                                </x-dropdown-link>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
               class="fixed left-0 top-16 h-full w-64 bg-white shadow-lg transform transition-transform duration-300 ease-in-out z-20 lg:translate-x-0 overflow-y-auto">
            <nav class="mt-5 px-2 space-y-1">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" 
                   class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.dashboard') ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <svg class="mr-3 h-6 w-6 {{ request()->routeIs('admin.dashboard') ? 'text-gray-500' : 'text-gray-400 group-hover:text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>

                <!-- Divider -->
                <div class="border-t border-gray-200 my-3"></div>
                <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Content Management</p>

                <!-- Levels Management -->
                <a href="#" 
                   class="group flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                    <svg class="mr-3 h-6 w-6 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Manage Levels
                </a>

                <!-- Courses Management -->
                <a href="#" 
                   class="group flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                    <svg class="mr-3 h-6 w-6 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    Manage Courses
                </a>

                <!-- Videos Management -->
                <a href="#" 
                   class="group flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                    <svg class="mr-3 h-6 w-6 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                    Manage Videos
                </a>

                <!-- Notes Management -->
                <a href="#" 
                   class="group flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                    <svg class="mr-3 h-6 w-6 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Manage Notes
                </a>

                <!-- Divider -->
                <div class="border-t border-gray-200 my-3"></div>
                <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Quick Actions</p>

                <!-- Add Course -->
                <a href="#" 
                   class="group flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-blue-50 hover:text-blue-700">
                    <svg class="mr-3 h-6 w-6 text-blue-400 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Add New Course
                </a>

                <!-- Upload Video -->
                <a href="#" 
                   class="group flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-purple-50 hover:text-purple-700">
                    <svg class="mr-3 h-6 w-6 text-purple-400 group-hover:text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                    Upload Video
                </a>

                <!-- Create Note -->
                <a href="#" 
                   class="group flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-green-50 hover:text-green-700">
                    <svg class="mr-3 h-6 w-6 text-green-400 group-hover:text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Create Note
                </a>

                <!-- Divider -->
                <div class="border-t border-gray-200 my-3"></div>
                <p class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">System</p>

                <!-- Users Management -->
                <a href="#" 
                   class="group flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                    <svg class="mr-3 h-6 w-6 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Users
                </a>

                <!-- Settings -->
                <a href="#" 
                   class="group flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 hover:text-gray-900">
                    <svg class="mr-3 h-6 w-6 text-gray-400 group-hover:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Settings
                </a>

                <!-- Storage Info -->
                <div class="px-3 py-4 mt-4 bg-gray-50 rounded-md">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Storage</p>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-600">Used</span>
                        <span class="font-semibold text-gray-900">0 GB</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: 0%"></div>
                    </div>
                </div>
            </nav>
        </aside>

        <!-- Overlay for mobile -->
        <div x-show="sidebarOpen" 
             @click="sidebarOpen = false"
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-gray-600 bg-opacity-75 z-10 lg:hidden"
             style="display: none;">
        </div>

        <!-- Main Content Area -->
        <div class="lg:pl-64 pt-16">
            <!-- Page Heading -->
            @hasSection('header')
                <header class="bg-white shadow">
                    <div class="px-4 sm:px-6 lg:px-8 py-6">
                        @yield('header')
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                <!-- Display Success/Error Messages -->
                @if (session('success'))
                    <div class="px-4 sm:px-6 lg:px-8 mt-4">
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="px-4 sm:px-6 lg:px-8 mt-4">
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>

