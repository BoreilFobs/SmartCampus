<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Level;
use App\Models\Course;
use App\Models\Video;
use App\Models\Note;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard with statistics.
     *
     * Shows overview statistics including:
     * - Total levels, courses, videos, notes
     * - Recent activity
     * - Quick action links
     */
    public function dashboard(): View
    {
        // Gather statistics for dashboard
        $stats = [
            'levels' => Level::count(),
            'active_levels' => Level::where('is_active', true)->count(),
            'courses' => Course::count(),
            'active_courses' => Course::where('is_active', true)->count(),
            'videos' => Video::count(),
            'active_videos' => Video::where('is_active', true)->count(),
            'notes' => Note::count(),
            'total_users' => User::count(),
            'admin_users' => User::where('is_admin', true)->count(),
        ];

        // Get recent courses (last 5)
        $recentCourses = Course::with(['level', 'creator'])
            ->latest()
            ->take(5)
            ->get();

        // Get recent videos (last 5)
        $recentVideos = Video::with(['course.level', 'uploader'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentCourses', 'recentVideos'));
    }
}

