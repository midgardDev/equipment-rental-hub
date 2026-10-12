<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    public function definition(): array
    {
        // Get a completed booking or create one
        $booking = Booking::where('status', 'completed')->inRandomOrder()->first();
        
        if (!$booking) {
            // Create a completed booking if none exists
            $booking = Booking::factory()->create(['status' => 'completed']);
        }

        return [
            'booking_id' => $booking->id,
            'reviewer_id' => $booking->renter_id,
            'reviewee_id' => $booking->item->user_id,
            'rating' => $this->faker->numberBetween(1, 5),
            'comment' => $this->faker->optional()->paragraph(),
        ];
    }
}