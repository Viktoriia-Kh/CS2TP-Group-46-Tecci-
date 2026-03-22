<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductImage;

class ProductImageSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();

        foreach ($products as $product) {
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $product->image_url ?? 'images/products/teccibook-14.jpg',
                'is_primary' => true,
                'sort_order' => 1,
            ]);
        }
    }
}