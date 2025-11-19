<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassBooking;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class BookingController extends Controller
{
    /**
     * Display a listing of all bookings.
     */
    public function index(Request $request): View
    {
        $query = ClassBooking::with(['student', 'level', 'course', 'admin']);

        // Filter by status if provided
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $bookings = $query->latest()->paginate(15);

        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Show the form for scheduling a booking.
     */
    public function edit(ClassBooking $booking): View
    {
        $booking->load(['student', 'level', 'course']);
        
        return view('admin.bookings.edit', compact('booking'));
    }

    /**
     * Update the booking with schedule details.
     */
    public function update(Request $request, ClassBooking $booking): RedirectResponse
    {
        $validated = $request->validate([
            'scheduled_at' => 'required|date|after:now',
            'zoom_link' => 'required|url',
            'admin_notes' => 'nullable|string|max:1000',
            'status' => 'required|in:pending,scheduled,completed,cancelled',
        ]);

        $validated['admin_id'] = auth()->id();

        $booking->update($validated);

        return redirect()
            ->route('admin.bookings.index')
            ->with('success', 'Booking updated successfully!');
    }

    /**
     * Update booking status.
     */
    public function updateStatus(Request $request, ClassBooking $booking): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,scheduled,completed,cancelled',
        ]);

        $booking->update($validated);

        return redirect()
            ->route('admin.bookings.index')
            ->with('success', 'Booking status updated successfully!');
    }

    /**
     * Delete a booking.
     */
    public function destroy(ClassBooking $booking): RedirectResponse
    {
        $booking->delete();

        return redirect()
            ->route('admin.bookings.index')
            ->with('success', 'Booking deleted successfully!');
    }
}
