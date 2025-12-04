<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BasketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('basket')->insert([
            ['product' => 'TecciBook 14', 'price' => 499.99, 'quantity' => 10,'image_url' => 'https://png.pngtree.com/png-vector/20251117/ourlarge/pngtree-futuristic-laptop-design-concept-png-image_17987169.webp'],
            ['product' => 'BudgetBook 15', 'price' => 399.99, 'quantity' => 2,'image_url' => 'https://png.pngtree.com/png-vector/20250512/ourlarge/pngtree-digital-marketing-concept-visualized-laptop-png-image_16221339.png'],
            ['product' => 'phone 2', 'price' => 149.99, 'quantity' => 1,'image_url' => 'https://atlas-content-cdn.pixelsquid.com/stock-images/tesla-phone-concept-red-smartphone-2JKWol9-600.jpg'],
        ]);
        //
    }
}
