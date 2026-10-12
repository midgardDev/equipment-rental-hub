<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Item;
use App\Models\Booking;
use App\Models\Review;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User Factory

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'adminn@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'user_type' => 'both',
        ]);

        User::factory()->create([
            'name' => 'John Owner',
            'email' => 'ownerr@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
            'user_type' => 'owner',
        ]);

        User::factory()->create([
            'name' => 'Jane Renter',
            'email' => 'renterr@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'user',
            'user_type' => 'renter',
        ]);

        // Regular users
        User::factory(10)->create();

        // Items
        Item::factory(20)->create();

        // Bookings
        Booking::factory(30)->create();

        // Reviews
        Review::factory(15)->create();
    }
}
