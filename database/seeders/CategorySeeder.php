<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Laptops',     'description' => 'Affordable student laptops',                'is_active' => true],
            ['name' => 'Desktops',    'description' => 'Gaming and study computers',               'is_active' => true],
            ['name' => 'Tablets',     'description' => 'Portable devices for notes and browsing',  'is_active' => true],
            ['name' => 'Phones',      'description' => 'Budget-friendly smartphones',              'is_active' => true],
            ['name' => 'Accessories', 'description' => 'Headphones, keyboards, mice and more',     'is_active' => true],
        ];

        // Insert each category into the database
        foreach ($categories as $cat) {
            Category::create($cat);
        }
    }
}