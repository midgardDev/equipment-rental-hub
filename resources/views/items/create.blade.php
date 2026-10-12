@extends('layouts.app')

@section('content')
    <div class="max-w-full mx-auto px-2">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Header -->
            <div class="bg-blue-600 px-6 py-4">
                <h1 class="text-2xl font-bold text-white">List Your Equipment for Rent</h1>
                <p class="text-blue-100 text-sm mt-1">Fill in the details below to list your item</p>
            </div>

            <!-- Form -->
            <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-4">
                        <h2 class="text-lg font-semibold text-gray-700 border-b pb-2">Basic Information</h2>
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                Item Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" id="name" 
                                   placeholder="e.g., Bosch Drill Machine"
                                   value="{{ old('name') }}" required>
                            @error('name')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-1">
                                Category <span class="text-red-500">*</span>
                            </label>
                            <select name="category" id="category" required>
                                <option value="">Select a category</option>
                                <option value="Tools" {{ old('category') == 'Tools' ? 'selected' : '' }}>Tools</option>
                                <option value="Garden" {{ old('category') == 'Garden' ? 'selected' : '' }}>Garden</option>
                                <option value="Electronics" {{ old('category') == 'Electronics' ? 'selected' : '' }}>Electronics</option>
                                <option value="Sports" {{ old('category') == 'Sports' ? 'selected' : '' }}>Sports</option>
                                <option value="Photography" {{ old('category') == 'Photography' ? 'selected' : '' }}>Photography</option>
                            </select>
                            @error('category')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-1">
                                Description <span class="text-red-500">*</span>
                            </label>
                            <textarea name="description" id="description" rows="5" 
                                      placeholder="Describe your item, its condition, what it includes..."
                                      required>{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="space-y-4 md:border-l md:pl-8">
                        <h2 class="text-lg font-semibold text-gray-700 border-b pb-2">Rental Details</h2>

                        <!-- Price Per Day -->
                        <div>
    <label for="price_per_day" class="block text-sm font-medium text-gray-700 mb-1">
        Price Per Day ($) <span class="text-red-500">*</span>
    </label>
    <input type="number" name="price_per_day" id="price_per_day" 
           placeholder="0.00"
           value="{{ old('price_per_day') }}" step="0.01" min="0" required>
    @error('price_per_day')
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

                        <!-- Location -->
                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700 mb-1">
                                Location <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="location" id="location" 
                                   placeholder="e.g., Nairobi, Westlands"
                                   value="{{ old('location') }}" required>
                            @error('location')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Image Upload -->
                        <div>
                            <label for="image" class="block text-sm font-medium text-gray-700 mb-1">
                                Item Photo
                            </label>
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:border-blue-500 transition cursor-pointer"
                                 onclick="document.getElementById('image').click()">
                                <input type="file" name="image" id="image" 
                                       accept="image/*" class="hidden"
                                       onchange="previewImage(this)">
                                <div id="preview-container">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <p class="mt-2 text-sm text-gray-600">Click to upload a photo</p>
                                    <p class="text-xs text-gray-500">PNG, JPG, JPEG up to 2MB</p>
                                </div>
                            </div>
                            @error('image')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Availability -->
                        <div class="bg-gray-50 rounded-lg p-3">
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" name="is_available" value="1" 
                                       {{ old('is_available', true) ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-700">Available for rent immediately</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 pt-6 border-t border-gray-200 flex justify-end gap-3">
                    <a href="{{ route('items.index') }}" 
                       class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 transition font-medium">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="bg-blue-600 text-white px-8 py-2 rounded-lg hover:bg-blue-700 transition font-medium shadow-md">
                        List Item
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewImage(input) {
            const container = document.getElementById('preview-container');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    container.innerHTML = `
                        <img src="${e.target.result}" class="mx-auto max-h-40 rounded-lg" alt="Preview">
                        <p class="mt-2 text-sm text-blue-600">Click to change photo</p>
                    `;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection