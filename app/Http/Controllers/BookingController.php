<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Item;
use Illuminate\Http\Request;
use Carbon\carbon;


class BookingController extends Controller
{
    // All bookings for the logged in user (renter & owner)
    public function index()
    {
        $userId = auth()->id();

        // Bookings where the user is the renter
        $myRentals = Booking::where('renter_id', $userId)
        ->with('item')
        ->latest()
        ->get();

        // Bookings where the user is the owner
        $myItemBookings = Booking::whereHas('item', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->with(['item', 'renter'])
        ->latest()
        ->get();

        return view('bookings.index', compact('myRentals', 'myItemBookings'));
    }

    /**
     * Show the booking form for a specific item.
     */
    public function create(Item $item)
    {
        // Onwer of the item should not be able to book their own item
        if ($item->user_id === auth()->id()) {
            return redirect()->route('items.show', $item)
            ->with('error', 'You cannot book your own item.');
        }

        // Items must be available for booking
        if (!$item->is_available) {
            return redirect()->route('items.show', $item)
            ->with('error', 'This item is not available for rent.');
        }

        return view('bookings.create', compact('item'));
    }

    /**
     * Store a new booking
     */
    public function store(Request $request, Item $item)
    {
        // Validate
        $validated = $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'renter_message' => 'nullable|string|max:500',
        ]);

        // Prevent owner from booking their own item
        if ($item->user_id === auth()->id()) {
            return redirect()->route('items.show', $item)
            ->with('error', 'You cannot book your own item.');
        }

        // Calculate total price
        $startDate = Carbon::parse($validated['start_date']);
        $endDate = Carbon::parse($validated['end_date']);
        $days = $startDate->diffInDays($endDate);
        $totalPrice = $days * $item->price_per_day;

        // Create the booking
        $booking = Booking::create([
            'item_id' => $item->id,
            'renter_id' => auth()->id(),
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'total_price' => $totalPrice,
            'status' => 'pending',
            'renter_message' => $validated['renter_message'] ?? null,
        ]);

        return redirect()->route('bookings.show', $booking)
        ->with('success', 'Booking request sent! Waiting for owner approval.');
    }

    // Show a specific booking
    public function show(Booking $booking)
    {
        // Only the renter or the owner of the item can view the booking
        $isRenter = $booking->renter_id === auth()->id();
        $isOwner = $booking->item->user_id === auth()->id();

        if (!$isRenter && !$isOwner) {
            abort(403, 'You are not authorized to view this booking.');
        }

        return view('bookings.show', compact('booking', 'isRenter', 'isOwner'));
    }

    // Owner approves a booking
    public function approve(Booking $booking)
    {
        // Only the item owner can approve the booking
        if ($booking->item->user_id !== auth()->id()) {
            abort(403, 'Only the item owner can approve the bookings.');
        }

        if ($booking->status !== 'pending') {
            return redirect()->back()->with('error', 'This booking is no longer pending');
        }

        $booking->update(['status' => 'approved']);

        return redirect()->route('bookings.show', $booking)
        ->with('success', 'Booking approved!');
    }

    // Cancel a booking
    public function cancel(Booking $booking)
    {
        // Only the renter or owner can cancel
        $isRenter = $booking->renter_id === auth()->id();
        $isOwner = $booking->item->user_id === auth()->id();

        if (!$isRenter && !$isOwner) {
            abort(403, 'You are not authorized to cancel this booking.');
        }

        if (in_array($booking->status, ['completed', 'cancelled'])) {
            return redirect()->back()->with('error', 'This booking cannot be cancelled.');
        }

        $booking->update(['status' => 'cancelled']);

        return redirect()->route('bookings.index')
        ->with('success', 'Booking cancelled');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
