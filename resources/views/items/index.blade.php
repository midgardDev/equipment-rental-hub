@extends('layouts.app')

@section('content')
@if(session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
    {{ session('success') }}
</div>
@endif
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Available Equipment for Rent</h1>
        @auth
    <a href="{{ route('items.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
        + List Your Item
    </a>
@endauth
    </div>

    <!-- Search/Filter Section -->
    <div class="bg-white p-4 rounded-lg shadow mb-6">
        <form action="{{ route('items.index') }}" method="GET" class="flex flex-wrap md:flex-nowrap gap-4 items-center">
            <input type="text" name="search" placeholder="Search items..." 
       class="flex-1 min-w-[200px] px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            <select name="category" class="w-full md:w-48 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">All Categories</option>
                <option value="Tools">Tools</option>
                <option value="Garden">Garden</option>
                <option value="Electronics">Electronics</option>
                <option value="Sports">Sports</option>
                <option value="Photography">Photography</option>
            </select>
            <button type="submit" class="bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700">
                Search
            </button>
        </form>
    </div>

    <!-- Items Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        @forelse ($items as $item)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
                @if($item->image_url)
    <img src="{{ str_starts_with($item->image_url, 'http') ? $item->image_url : asset('storage/' . $item->image_url) }}" 
         alt="{{ $item->name }}" class="w-full h-48 object-cover">
@else
    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
        <span class="text-gray-400">📷 No image</span>
    </div>
@endif
                <div class="p-4">
                    <div class="flex justify-between items-start">
                        <h3 class="text-lg font-semibold">{{ $item->name }}</h3>
                        <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">{{ $item->category }}</span>
                    </div>
                    <p class="text-gray-600 text-sm mt-2">{{ Str::limit($item->description, 100) }}</p>
                    <div class="mt-3 flex justify-between items-center">
                        <span class="text-xl font-bold text-blue-600">${{ number_format($item->price_per_day, 2) }}/day</span>
                        <span class="text-sm text-gray-500">{{ $item->location }}</span>
                    </div>
                    <div class="mt-3 flex justify-between items-center">
                        <span class="text-sm">
                            @if($item->is_available)
                                <span class="text-green-600">Available</span>
                            @else
                                <span class="text-red-600">Not Available</span>
                            @endif
                        </span>
                        <a href="{{ route('items.show', $item) }}" 
                           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 text-sm">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-12">
                <p class="text-gray-500">No items found. Be the first to list an item!</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $items->links() }}
    </div>
@endsection