<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\Course;
use App\Models\Video;

class HomeController extends Controller
{
    /**
     * Display the homepage with all active levels and statistics.
     */
    public function index()
    {
        // Fetch all active levels with course counts
        $levels = Level::where('is_active', true)
            ->with(['courses' => function ($query) {
                $query->where('is_active', true);
            }])
            ->orderBy('order')
            ->get()
            ->map(function ($level) {
                $level->course_count = $level->courses->count();
                $level->video_count = $level->courses->sum(function ($course) {
                    return $course->videos->where('is_active', true)->count();
                });
                return $level;
            });

        // Calculate platform statistics
        $totalCourses = Course::where('is_active', true)->count();
        $totalVideos = Video::where('is_active', true)->count();
        $totalLevels = $levels->count();

        return view('welcome', compact('levels', 'totalCourses', 'totalVideos', 'totalLevels'));
    }
}
