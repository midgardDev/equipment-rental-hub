@extends('layouts.app')

@section('content')
    <div class="max-w-full mx-auto px-2">
        <h1 class="text-2xl font-bold mb-6">📋 My Bookings</h1>

        <!-- Tabs -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="border-b border-gray-200">
                <nav class="flex -mb-px">
                    <button onclick="showTab('rentals')" id="tab-rentals"
                            class="tab-btn py-4 px-6 text-sm font-medium border-b-2 border-blue-500 text-blue-600">
                         My Rentals ({{ $myRentals->count() }})
                    </button>
                    <button onclick="showTab('listings')" id="tab-listings"
                            class="tab-btn py-4 px-6 text-sm font-medium border-b-2 border-transparent text-gray-500 hover:text-gray-700">
                         My Item Bookings ({{ $myItemBookings->count() }})
                    </button>
                </nav>
            </div>

            <!-- My Rentals Tab -->
            <div id="content-rentals" class="tab-content p-6">
                @forelse($myRentals as $booking)
                    <div class="border rounded-lg p-4 mb-4 hover:shadow-md transition">
                        <div class="flex flex-wrap justify-between items-center gap-4">
                            <div class="flex gap-4 items-center">
                                @if($booking->item->image_url)
                                    <img src="{{ str_starts_with($booking->item->image_url, 'http') ? $booking->item->image_url : asset('storage/' . $booking->item->image_url) }}" 
                                         class="w-16 h-16 object-cover rounded">
                                @endif
                                <div>
                                    <h3 class="font-bold">{{ $booking->item->name }}</h3>
                                    <p class="text-sm text-gray-600">
                                        {{ $booking->start_date->format('M d') }} - {{ $booking->end_date->format('M d, Y') }}
                                    </p>
                                    <p class="text-sm font-medium text-blue-600">${{ number_format($booking->total_price, 2) }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="text-xs px-3 py-1 rounded-full font-semibold
                                    @if($booking->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($booking->status === 'approved') bg-green-100 text-green-800
                                    @elseif($booking->status === 'completed') bg-blue-100 text-blue-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($booking->status) }}
                                </span>
                                <a href="{{ route('bookings.show', $booking) }}" 
                                   class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm">
                                    View
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-8">You haven't rented anything yet.</p>
                @endforelse
            </div>

            <!-- My Item Bookings Tab -->
            <div id="content-listings" class="tab-content p-6 hidden">
                @forelse($myItemBookings as $booking)
                    <div class="border rounded-lg p-4 mb-4 hover:shadow-md transition">
                        <div class="flex flex-wrap justify-between items-center gap-4">
                            <div class="flex gap-4 items-center">
                                @if($booking->item->image_url)
                                    <img src="{{ str_starts_with($booking->item->image_url, 'http') ? $booking->item->image_url : asset('storage/' . $booking->item->image_url) }}" 
                                         class="w-16 h-16 object-cover rounded">
                                @endif
                                <div>
                                    <h3 class="font-bold">{{ $booking->item->name }}</h3>
                                    <p class="text-sm text-gray-600">Renter: {{ $booking->renter->name }}</p>
                                    <p class="text-sm text-gray-600">
                                        {{ $booking->start_date->format('M d') }} - {{ $booking->end_date->format('M d, Y') }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="text-xs px-3 py-1 rounded-full font-semibold
                                    @if($booking->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($booking->status === 'approved') bg-green-100 text-green-800
                                    @elseif($booking->status === 'completed') bg-blue-100 text-blue-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($booking->status) }}
                                </span>
                                <a href="{{ route('bookings.show', $booking) }}" 
                                   class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm">
                                    View
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-8">No one has booked your items yet.</p>
                @endforelse
            </div>
        </div>
    </div>

    <script>
        function showTab(tab) {
            // Hide all tabs
            document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
            document.querySelectorAll('.tab-btn').forEach(el => {
                el.classList.remove('border-blue-500', 'text-blue-600');
                el.classList.add('border-transparent', 'text-gray-500');
            });

            // Show selected tab
            document.getElementById('content-' + tab).classList.remove('hidden');
            const btn = document.getElementById('tab-' + tab);
            btn.classList.remove('border-transparent', 'text-gray-500');
            btn.classList.add('border-blue-500', 'text-blue-600');
        }
    </script>
@endsection