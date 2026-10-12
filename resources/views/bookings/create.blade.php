@extends('layouts.app')

@section('content')
<div class="max-w-full mx-auto px-2">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <!-- Header -->
         <div class="bg-blue-600 px-6 py-4">
            <h1 class="text-2xl font-bold text-white">Book This Item</h1>
            <p class="text-blue-100 text-sm mt-1">Choose your rental dates</p>
         </div>

         <div class="p-6">
            <!-- Item Summary -->
             <div class="flex gap-4 bg-gray-50 rounded-lg p-4 mb-6">
                @if($item->image_url)
                <img src="{{ str_starts_with($item->image_url, 'http') ?
                $item->image_url : asset('storage/' . $item->image_url) }}"
                class="w-24 h-24 object-cover rounded-lg">
                @else
                <div class="w-24 h-24 bg-gray-200 rounded-lg flex items-center justify-center">
                    <span class="text-gray-400"></span>
                </div>
                @endif 
                <div>
                    <h2 class="font-bold text-lg">{{ $item->name }}</h2>
                    <p class="text-gray-600 text-sm">{{ $item->location }}</p>
                    <p class="text-blue-600 font-bold mt-2">${{ number_format($item->price_per_day, 2) }}/day</p>
                </div>
             </div>

             <!-- Booking Form -->
              <form action="{{ route('bookings.store', $item) }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Start Date -->
                     <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">
                            Start Date <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="start_date" id="start_date"
                        value="{{ old('start_date', date('Y-m-d')) }}"
                        min="{{ date('Y-m-d') }}"
                        required
                        onchange="calculateTotal()">
                        @error('start_date')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                     </div>

                     <!-- End Date -->
                      <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">
                                End Date <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="end_date" id="end_date" 
                                   value="{{ old('end_date', date('Y-m-d', strtotime('+1 day'))) }}"
                                   min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                   required
                                   onchange="calculateTotal()">
                            @error('end_date')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                </div>

                <!-- Message to Owner -->
                 <div class="mt-4">
                    <label for="renter_message" class="block text-sm font-medium text-gray-700 mb-1">
                        Message to Owner (Optional)
                    </label>
                    <textarea name="renter_message" id="renter_message" rows="3"
                    placeholder="Let the owner know when you'll pick it up, how you'll use it, etc."
                    maxlength="500">{{ old('renter-message') }}</textarea>

                    @error('renter_message')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>

                    @enderror
                 </div>

                 <!-- Price Calculation -->
                  <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-gray-700">Price per day:</span>
                        <span class="font-medium">${{ number_format($item->price_per_day, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-gray-700">Number of days:</span>
                        <span class="font-medium" if="days_count">1</span>
                    </div>
                    <div class="border-t border-blue-300 pt-2 mt-2 flex justify-between items-center">
                        <span class="font-bold text-lg">Total:</span>
                        <span class="font-bold text-lg-text-blue-600" id="total_price">
                            ${{ number_format($item->price_per_day, 2) }}
                        </span>
                    </div>
                  </div>

                  <!-- Actions -->
                   <div class="mt-6 flex justify-end gap-3">
                    <a href="{{ route('items.show', $item) }}"
                    class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 font-medium">
                    Cancel
                </a>
                <button type="submit"
                class="bg-blue-600 text-white px-8 py-2 rounded-lg hover:bg-blue-700 font-medium shadow-md">
                Request Booking
                </button>
                   </div>
              </form>
         </div>
    </div>
    
    <script>
        const pricePerDay = {{ $item->price_per_day }};

        function calculateTotal() {
            const startDate = new Date(document.getElementById('start_date').value);
            const endDate = new Date(document.getElementById('end_date').value);

            if (startDate && endDate && endDate > startDate) {
                const days = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24));
                const total = days * pricePerDay;

                document.getElementById('days-count').textContent = days;
                document.getElementById('total-price').textContent = '$' + total.toFixed(2);
            }
        }

        // Calculate on page load
        calculateTotal();
    </script>
    @endsection

</div>