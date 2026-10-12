<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('-1 month', '+1 month');
        $endDate = clone $startDate;
        $endDate->modify('+' . $this->faker->numberBetween(1, 7) . ' days');
        
        // Create an item if none exists
        $item = Item::inRandomOrder()->first() ?? Item::factory()->create();
        $days = $startDate->diff($endDate)->days;
        $totalPrice = $item->price_per_day * $days;

        // Create a renter who is not the owner of the item
        $renter = User::where('id', '!=', $item->user_id)->inRandomOrder()->first() 
                  ?? User::factory()->create();

        return [
            'item_id' => $item->id,
            'renter_id' => $renter->id,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'total_price' => $totalPrice,
            'status' => $this->faker->randomElement(['pending', 'approved', 'completed', 'cancelled']),
            'renter_message' => $this->faker->optional()->sentence(),
        ];
    }
}