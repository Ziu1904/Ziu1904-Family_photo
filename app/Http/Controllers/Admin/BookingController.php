<?php

namespace App\Http\Controllers\Admin;

use App\Models\Booking;
use App\Models\Package;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('user', 'package')
            ->latest()
            ->paginate(15);

        return view('admin.bookings.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        $booking->load('user', 'package', 'reviews', 'albums');
        return view('admin.bookings.show', compact('booking'));
    }

    public function create()
    {
        $users = User::where('role', 'user')->get();
        $packages = Package::where('is_active', true)->get();
        return view('admin.bookings.create', compact('users', 'packages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'package_id' => 'required|exists:packages,id',
            'school' => 'required|string',
            'class' => 'required|string',
            'students_count' => 'required|integer|min:1',
            'concept' => 'required|string',
            'booking_date' => 'required|date',
            'notes' => 'nullable|string',
            'status' => 'required|in:pending,confirmed,completed,cancelled',
            'deposit' => 'nullable|numeric|min:0',
            'total_price' => 'nullable|numeric|min:0',
        ]);

        Booking::create($validated);
        return redirect()->route('admin.bookings.index')->with('success', 'Booking created successfully!');
    }

    public function edit(Booking $booking)
    {
        $users = User::where('role', 'user')->get();
        $packages = Package::where('is_active', true)->get();
        return view('admin.bookings.edit', compact('booking', 'users', 'packages'));
    }

    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'package_id' => 'required|exists:packages,id',
            'school' => 'required|string',
            'class' => 'required|string',
            'students_count' => 'required|integer|min:1',
            'concept' => 'required|string',
            'booking_date' => 'required|date',
            'notes' => 'nullable|string',
            'status' => 'required|in:pending,confirmed,completed,cancelled',
            'deposit' => 'nullable|numeric|min:0',
            'total_price' => 'nullable|numeric|min:0',
        ]);

        $booking->update($validated);
        return redirect()->route('admin.bookings.index')->with('success', 'Booking updated successfully!');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('admin.bookings.index')->with('success', 'Booking deleted successfully!');
    }
}
