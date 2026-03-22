<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class OrderTestSeeder extends Seeder
{
    public function run()
    {
        // 1. Fix the Category error by finding or creating one
        $categoryId = DB::table('categories')->value('id');

        if (!$categoryId) {
            $categoryId = DB::table('categories')->insertGetId([
                'name' => 'Electronics',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $this->command->info('Created a new category.');
        }

        // 2. Get or create a Test User
        $user = User::first() ?? User::create([
            'name' => 'Kirpal Sangha',
            'email' => 'test_customer@example.com',
            'password' => bcrypt('password123'),
        ]);

        // 3. Create or get some Products with the required category_id
        $productData = [
            ['name' => 'Tecci Phone Pro', 'price' => 999.99],
            ['name' => 'Tecci Laptop Air', 'price' => 1299.99],
            ['name' => 'Tecci Buds', 'price' => 149.99],
        ];

        $products = [];
        foreach ($productData as $data) {
            $products[] = Product::firstOrCreate(
                ['name' => $data['name']],
                [
                    'price' => $data['price'],
                    'description' => 'High-quality Tecci hardware.',
                    'category_id' => $categoryId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        // 4. Create 10 Test Orders
        $statuses = ['Pending', 'Approved', 'Shipped', 'Completed', 'Cancelled'];

        for ($i = 1; $i <= 10; $i++) {
            $status = $statuses[array_rand($statuses)];
            
            $order = Order::create([
                'user_id' => $user->id,
                'status' => $status,
                'total_price' => 0,
                'created_at' => now()->subDays(rand(1, 14)),
            ]);

            // Add a random item to the order
            $product = $products[array_rand($products)];
            $quantity = rand(1, 2);
            $itemPrice = $product->price * $quantity;

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'product_name' => $product->name,  // Added this required field
                'quantity' => $quantity,
                'price' => $product->price,
            ]);

            $order->update(['total_price' => $itemPrice]);
        }

        $this->command->info('Success! 10 orders have been generated.');
    }
}