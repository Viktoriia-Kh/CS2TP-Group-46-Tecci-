<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
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

        $products = Product::all();

        foreach ($products as $product) {
            Review::updateOrCreate(
                [
                    'product_id' => $product->id,
                    'user_id' => $user->id,
                ],
                [
                    'rating' => rand(3, 5),
                    'review_text' => 'Good product for students.',
                ]
            );
        }
    }
}