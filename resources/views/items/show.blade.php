@extends('layouts.app')

@section('content')
    <div class="px-4">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="grid grid-cols-1 md:grid-cols-2">
            <!-- Image -->
            <div>
                @if($item->image_url)
        <img src="{{ str_starts_with($item->image_url, 'http') ? $item->image_url : asset('storage/' . $item->image_url) }}" 
            alt="{{ $item->name }}" class="w-full h-full object-cover">
        @else
            <div class="w-full h-full bg-gray-200 flex items-center justify-center min-h-[400px]">
                <span class="text-gray-400 text-xl">📷 No image available</span>
            </div>
        @endif
            </div>
            
            <!-- Details -->
            <div class="p-6">
                <h1 class="text-3xl font-bold">{{ $item->name }}</h1>
                <div class="mt-2 flex items-center gap-2">
                    <span class="bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded">{{ $item->category }}</span>
                    <span class="bg-green-100 text-green-800 text-sm px-3 py-1 rounded">{{ $item->location }}</span>
                </div>
                
                <div class="mt-4">
                    <p class="text-gray-600">{{ $item->description }}</p>
                </div>
                
                <div class="mt-6 border-t pt-4">
                    <div class="flex justify-between items-center">
                        <span class="text-3xl font-bold text-blue-600">${{ number_format($item->price_per_day, 2) }}/day</span>
                        @if($item->is_available)
                            <span class="bg-green-500 text-white px-4 py-2 rounded-lg">Available</span>
                        @else
                            <span class="bg-red-500 text-white px-4 py-2 rounded-lg">Not Available</span>
                        @endif
                    </div>
                </div>
                
                <div class="mt-6 flex gap-4">
                    <a href="{{ route('items.index') }}" class="bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700">
                        Back
                    </a>
                    @auth
                    @if($item->is_available && $item->user_id !== auth()->id())
                    <a href="{{ route('bookings.create', $item) }}"
                    class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                    Rent Now
</a>
@elseif($item->user_id === auth()->id())
<span class="text-gray-500 italic">This is your item</span>
@endif
@else
<a href="{{ route('login') }}"
class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
Login to Rent
</a>
@endauth
                </div>
            </div>
        </div>
</div>
    </div>
@endsection