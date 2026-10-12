<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    protected static ?string $locale = 'en_US';

    public function definition(): array
    {
        $categories = ['Tools', 'Garden', 'Electronics', 'Sports', 'Photography'];
        $locations = ['Nairobi', 'Mombasa', 'Kisumu', 'Eldoret', 'Thika'];
        $prices = [5.00, 10.00, 15.00, 25.00, 50.00, 75.00];

        // Create user if none exists
        $user = User::inRandomOrder()->first() ?? User::factory()->create();

        return [
            'user_id' => $user->id,
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->paragraphs(2, true),
            'price_per_day' => $this->faker->randomElement($prices),
            'category' => $this->faker->randomElement($categories),
            'location' => $this->faker->randomElement($locations),
            'is_available' => $this->faker->boolean(80),
            'image_url' => 'https://picsum.photos/seed/' . $this->faker->unique()->word . '/640/480',
        ];
    }
}