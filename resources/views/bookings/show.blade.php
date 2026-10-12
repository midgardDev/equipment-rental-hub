@extends('layouts.app')

@section('content')
<div class="w-full px-2">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Header -->
         <div class="px-6 py-4
            @if($booking->status === 'pending') bg-yellow-500
            @elseif($booking->status === 'approved') bg-green-600
            @elseif($booking->status === 'completed') bg-blue-600
            @else bg-red-600 @endif">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-white">Booking #{{ $booking->id }}</h1>
                    <p class="text-white text-sm opacity-90">
                        Created {{ $booking->created_at->diffForHumans() }}
</p>
</div>
<span class="bg-white bg-opacity-20 text-white px-4 py-2 rounded-lg font-semibold uppercase text-sm">
    @if($booking->status === 'pending') Pending
    @elseif($booking->status === 'approved') Approved
    @elseif($booking->status === 'completed') Completed
    @else Cancelled @endif
</span>
</div>
</div>

<div class="p-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Left (Item Details) -->
         <div class="space-y-4">
            <h2 class="text-lg font-semibold text-gray-700 border-b pb-2">Item Details</h2>
            <div class="flex gap-4 bg-gray-50 rounded-lg p-4">
                @if($booking->item->image_url)
                <img src="{{ str_starts_with($booking->item->image_url, 'http') ? $booking->item->image_url : asset('storage/' . $booking->item->image_url) }}"
                class="w-full h-48 object-cover rounded-lg">
                @else
                <div class="w-24 h-24 bg-gray-200 rounded-lg flex items-center justify-center">
                    <span class="text-gray-400 text-2xl"></span>
</div>
                        @endif
                        <div class="flex-1">
                            <h3 class="font-bold text-lg">{{ $booking->item->name }}</h3>
                            <p class="text-gray-600 text-sm">{{ $booking->item->category }}</p>
                            <p class="text-gray-600 text-sm"> {{ $booking->item->location }}</p>
                                    <a href="{{ route('items.show', $booking->item) }}
                            class="text-blue-600 text-sm hover:underline mt-1 inline-block">
                            View Item 
</a>
</div>
</div>
<div class="bg-gray-50 rounded-lg p-4">
    <h3 class="font-semibold text-gray-700 mb-2">Owner</h3>
    <p class="text-gray-800">{{ $booking->item->owner->name }}</p>
</div>
</div>

<!-- Right (Booking Details) -->
 <div class="space-y-4 md:border-1 md:pl-8">
    <h2 class=" text-lg font-semibold text-gray-700 border-b pb-2">Rental Details</h2>
    <div class="bg-gray-50 rounded-lg p-4 space-y-3">
        <div class="flex justify-between">
            <span class="text-gray-600">Renter:</span>
            <span class="font-medium">{{ $booking->renter->name }}</span>
</div>
<div class="flex justify-between">
    <span class="text-gray-600">Start Date:</span>
    <span class="font-medium">{{ $booking->end_date->format('M d, Y') }}</span>
</div>
<div class="flex justify-between">
    <span class="text-gray-600">Duration:</span>
    <span class="font-medium">{{ $booking->start_date->diffInDays($booking->end_date) }}</span>
</div>
<div class="border-t pt-2 flex justify-between">
    <span class="font-bold text-lg">Total:</span>
    <span class="font-bold text-lg text-blue-600">
        ${{ number_format($booking->total_price, 2) }}
</span>
</div>
</div>

@if($booking->renter_message && trim($booking->renter_message) !== '')
<div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
    <h3 class="font-semibold text-blue-800 mb-1">Message from Renter</h3>
    <p class="text-gray-700 text-sm">{{ $booking->renter_mesage }}</p>
</div>
@endif
</div>
</div>

<!-- Action Buttons -->
 <div class="mt-8 pt-6 border-t border-gray-200 flex flex-wrap justify-between items-center gap-3">
    <a href="{{ route('bookings.index') }}"
    class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 font-medium">
    Back to Bookings
</a>

<div class="felx gap-3">
    @if($isOwner && $booking->status === 'pending')
    <form action="{{ route('bookings.approve', $booking) }}"
    method="POST" class="inline">
    @csrf
    @method('PATCH')
    <button type="submit"
    class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 font-medium">
    Approve Booking
</button>
</form>
@endif

@if(in_array($booking->status, ['pending', 'approved']))
<form action="{{ route('bookings.cancel', $booking) }}"
method="POST" class="inline"
onsubmit="return confirm('Are you sure you want to cancel this booking?');">
@csrf
@method('PATCH')
<button type="submit"
class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 font-medium">
Cancel Booking
</button>
</form>
@endif
</div>