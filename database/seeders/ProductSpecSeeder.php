<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductSpec;

class ProductSpecSeeder extends Seeder
{
    public function run(): void
    {
        ProductSpec::insert([
            [
                'product_id' => 1,
                'spec_name' => 'Processor',
                'spec_value' => 'Intel Core i5',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 1,
                'spec_name' => 'RAM',
                'spec_value' => '8GB',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 1,
                'spec_name' => 'Storage',
                'spec_value' => '512GB SSD',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}