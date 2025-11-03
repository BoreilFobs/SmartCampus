<?php

namespace App\Http\Controllers;

use App\Models\Level;
use Illuminate\View\View;

class LevelController extends Controller
{
    /**
     * Display a specific level with its courses.
     * 
     * Shows all active courses for the selected level with search functionality.
     * Courses are ordered by their position and include video count information.
     */
    public function show(Level $level): View
    {
        // Eager load courses with their videos to avoid N+1 queries
        $level->load([
            'courses' => function ($query) {
                $query->where('is_active', true)
                      ->orderBy('order')
                      ->with(['videos' => function ($subQuery) {
                          $subQuery->where('is_active', true);
                      }]);
            }
        ]);

        // Get courses
        $courses = $level->courses;
        
        // Calculate total videos
        $totalVideos = $courses->sum(function ($course) {
            return $course->videos->count();
        });

        // Return view with level and courses
        return view('levels.show', [
            'level' => $level,
            'courses' => $courses,
            'totalVideos' => $totalVideos
        ]);
    }
}
