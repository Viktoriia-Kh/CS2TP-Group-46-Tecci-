<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductSpec;

class ProductSpecSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();

        foreach ($products as $product) {
            ProductSpec::create([
                'product_id' => $product->id,
                'spec_name' => 'Processor',
                'spec_value' => 'Intel Core i5',
            ]);

            ProductSpec::create([
                'product_id' => $product->id,
                'spec_name' => 'RAM',
                'spec_value' => '8GB',
            ]);

            ProductSpec::create([
                'product_id' => $product->id,
                'spec_name' => 'Storage',
                'spec_value' => '256GB SSD',
            ]);
        }
    }
}