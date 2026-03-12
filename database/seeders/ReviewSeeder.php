<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\User;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        if (!$user) {
            $user = User::create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => bcrypt('password123'),
            ]);
        }

        Review::insert([
            [
                'product_id' => 1,
                'user_id' => $user->id,
                'rating' => 5,
                'review_text' => 'Great laptop for students.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}