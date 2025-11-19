<?php

namespace App\Http\Controllers;

use App\Models\ClassBooking;
use App\Models\Level;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class BookingController extends Controller
{
    /**
     * Display a listing of the student's bookings.
     */
    public function index(): View
    {
        $bookings = ClassBooking::where('student_id', auth()->id())
            ->with(['level', 'course', 'admin'])
            ->latest()
            ->paginate(10);

        return view('bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new booking.
     */
    public function create(): View
    {
        $levels = Level::where('is_active', true)->get();
        
        return view('bookings.create', compact('levels'));
    }

    /**
     * Store a newly created booking in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'level_id' => 'required|exists:levels,id',
            'course_id' => 'required|exists:courses,id',
            'topic' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
        ]);

        $validated['student_id'] = auth()->id();
        $validated['status'] = 'pending';

        ClassBooking::create($validated);

        return redirect()
            ->route('bookings.index')
            ->with('success', 'Your booking request has been submitted successfully! An admin will schedule your class soon.');
    }

    /**
     * Get courses for a specific level (AJAX).
     */
    public function getCourses(Request $request)
    {
        $courses = Course::where('level_id', $request->level_id)
            ->where('is_active', true)
            ->get(['id', 'title']);

        return response()->json($courses);
    }

    /**
     * Cancel a booking.
     */
    public function cancel(ClassBooking $booking): RedirectResponse
    {
        // Ensure the booking belongs to the authenticated student
        if ($booking->student_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Only allow cancellation of pending or scheduled bookings
        if (!in_array($booking->status, ['pending', 'scheduled'])) {
            return redirect()
                ->route('bookings.index')
                ->with('error', 'This booking cannot be cancelled.');
        }

        $booking->update(['status' => 'cancelled']);

        return redirect()
            ->route('bookings.index')
            ->with('success', 'Booking cancelled successfully.');
    }
}
