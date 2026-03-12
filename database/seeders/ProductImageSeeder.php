<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductImage;

class ProductImageSeeder extends Seeder
{
    public function run(): void
    {
        ProductImage::insert([
            [
                'product_id' => 1,
                'image_path' => 'images/products/teccibook-14.jpg',
                'is_primary' => true,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 1,
                'image_path' => 'images/products/teccibook-14.jpg',
                'is_primary' => false,
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}