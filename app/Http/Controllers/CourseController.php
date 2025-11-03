<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\View\View;

class CourseController extends Controller
{
    /**
     * Display a specific course with its videos.
     * 
     * Shows all active videos for the selected course in a video player with
     * a playlist sidebar. Videos can be navigated sequentially and include
     * associated notes and PDFs.
     */
    public function show(Course $course): View
    {
        // Eager load all relationships to avoid N+1 queries
        $course->load([
            'videos' => function ($query) {
                $query->where('is_active', true)
                      ->orderBy('order')
                      ->with('notes');
            },
            'level'
        ]);

        // Get videos
        $videos = $course->videos;

        // Return view with course and videos
        return view('courses.show', [
            'course' => $course,
            'videos' => $videos
        ]);
    }
}
