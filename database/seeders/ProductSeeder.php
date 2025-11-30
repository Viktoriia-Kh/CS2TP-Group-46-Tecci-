<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Inventory;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {

        // Get the category IDs
        $laptops = Category::where('name', 'Laptops')->first()->id ?? null;

        // Helper to create product + inventory
        $make = function ($data) {
            $product = Product::create([
                'category_id' => $data['category_id'],
                'name'        => $data['name'],
                'brand'       => $data['brand'],
                'description' => $data['description'],
                'price'       => $data['price'],
                'student_price' => $data['student_price'],
            ]);

            Inventory::create([
                'product_id'         => $product->id,
                'quantity_available' => $data['qty'],
                'reorder_threshold'  => 5,
            ]);
        };

        // Example laptop products
        $make([
            'category_id' => $laptops,
            'name'        => 'TecciBook 14',
            'brand'       => 'Tecci',
            'description' => '14-inch SSD laptop ideal for students',
            'price'       => 499.99,
            'student_price' => 449.99,
            'qty'         => 10
        ]);

        $make([
            'category_id' => $laptops,
            'name'        => 'BudgetBook 15',
            'brand'       => 'NovaTech',
            'description' => '15-inch budget-friendly laptop',
            'price'       => 399.99,
            'student_price' => 359.99,
            'qty'         => 8
        ]);
    }

}
