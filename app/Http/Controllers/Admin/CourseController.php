<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\Course;
use App\Models\Level;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    /**
     * Display a listing of courses.
     */
    public function index()
    {
        $courses = Course::with('level')
            ->orderBy('level_id')
            ->orderBy('order')
            ->paginate(15);

        $levels = Level::active()->get();

        return view('admin.courses.index', compact('courses', 'levels'));
    }

    /**
     * Show the form for creating a new course.
     */
    public function create()
    {
        $levels = Level::active()->get();

        return view('admin.courses.create', compact('levels'));
    }

    /**
     * Store a newly created course in database.
     */
    public function store(StoreCourseRequest $request)
    {
        try {
            $data = $request->validated();

            // Generate slug from title
            $data['slug'] = Str::slug($data['title']);

            // Check if slug already exists, append random string if it does
            if (Course::where('slug', $data['slug'])->exists()) {
                $data['slug'] = Str::slug($data['title']) . '-' . Str::random(5);
            }

            // Handle thumbnail upload
            if ($request->hasFile('thumbnail_path')) {
                $file = $request->file('thumbnail_path');
                $path = $file->store('thumbnails/courses', 'public');
                $data['thumbnail_path'] = $path;
            }

            // Set order (last position in level)
            $lastOrder = Course::where('level_id', $data['level_id'])
                ->max('order') ?? 0;
            $data['order'] = $lastOrder + 1;

            // Add created_by (current admin user)
            $data['created_by'] = auth()->id();

            $course = Course::create($data);

            return redirect()
                ->route('admin.courses.show', $course)
                ->with('success', 'Course created successfully!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Error creating course: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified course.
     */
    public function show(Course $course)
    {
        $course->load(['level', 'videos']);

        return view('admin.courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified course.
     */
    public function edit(Course $course)
    {
        $levels = Level::active()->get();

        return view('admin.courses.edit', compact('course', 'levels'));
    }

    /**
     * Update the specified course in database.
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
        try {
            $data = $request->validated();

            // Update slug if title changed
            if ($data['title'] !== $course->title) {
                $newSlug = Str::slug($data['title']);

                // Check if new slug already exists (excluding current course)
                if (Course::where('slug', $newSlug)
                    ->where('id', '!=', $course->id)
                    ->exists()) {
                    $newSlug = Str::slug($data['title']) . '-' . Str::random(5);
                }

                $data['slug'] = $newSlug;
            }

            // Handle thumbnail upload
            if ($request->hasFile('thumbnail_path')) {
                // Delete old thumbnail if exists
                if ($course->thumbnail_path && \Storage::disk('public')->exists($course->thumbnail_path)) {
                    \Storage::disk('public')->delete($course->thumbnail_path);
                }

                $file = $request->file('thumbnail_path');
                $path = $file->store('thumbnails/courses', 'public');
                $data['thumbnail_path'] = $path;
            }

            $course->update($data);

            return redirect()
                ->route('admin.courses.show', $course)
                ->with('success', 'Course updated successfully!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Error updating course: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified course from database.
     */
    public function destroy(Course $course)
    {
        try {
            // Delete thumbnail if exists
            if ($course->thumbnail_path && \Storage::disk('public')->exists($course->thumbnail_path)) {
                \Storage::disk('public')->delete($course->thumbnail_path);
            }

            $course->delete();

            return redirect()
                ->route('admin.courses.index')
                ->with('success', 'Course deleted successfully!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Error deleting course: ' . $e->getMessage());
        }
    }

    /**
     * Reorder courses.
     */
    public function reorder()
    {
        $courses = request()->input('courses', []);

        foreach ($courses as $index => $courseId) {
            Course::find($courseId)->update(['order' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }
}
