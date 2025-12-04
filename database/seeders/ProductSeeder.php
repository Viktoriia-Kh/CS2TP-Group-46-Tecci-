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
        $laptops = Category::where('name', 'Laptops')->first()?->id;
        $Desktop = Category::where('name', 'Desktops')->first()?->id;
        $Tablet = Category::where('name', 'Tablets')->first()?->id;
        $Phone = Category::where('name', 'Phones')->first()?->id;
        $Accessory = Category::where('name', 'Accessories')->first()?->id;

        // Helper to create product + inventory
        $make = function ($data) {
            $product = Product::create([
                'category_id' => $data['category_id'],
                'name'        => $data['name'],
                'brand'       => $data['brand'],
                'description' => $data['description'],
                'price'       => $data['price'],
                'student_price' => $data['student_price'],
                'image_url' => $data['image_url'] ?? null,
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
            'qty'         => 10,
            'image_url'     => 'images/products/teccibook-14.jpg',      
        ]);

        $make([
            'category_id' => $laptops,
            'name'        => 'BudgetBook 15',
            'brand'       => 'NovaTech',
            'description' => '15-inch budget-friendly laptop',
            'price'       => 399.99,
            'student_price' => 359.99,
            'qty'         => 8,
            'image_url' => 'images/products/budgetbook-15.jpg',
        ]);

                $make([
            'category_id' => $laptops,
            'name'        => 'TecciBook Pro',
            'brand'       => 'NovaTech',
            'description' => 'placeholder',
            'price'       => 450.99,
            'student_price' => 429.99,
            'qty'         => 8,
            'image_url' => 'images/products/teccibook-pro.jpg',
        ]);

            $make([
            'category_id' => $laptops,
            'name'        => 'TecciBook Max XL',
            'brand'       => 'Tecci',
            'description' => 'placeholder',
            'price'       => 299.99,
            'student_price' => 229.99,
            'qty'         => 8,
            'image_url' => 'images/products/teccibook-max-xl.jpg',
        ]);

            $make([
            'category_id' => $laptops,
            'name'        => 'BudgetBook Max XL',
            'brand'       => 'NovaTeck',
            'description' => 'placeholder',
            'price'       => 199.99,
            'student_price' => 99.99,
            'qty'         => 8,
            'image_url' => 'images/products/budgetbook max xl.jpg',
        ]);

        // Example Desktop products
        $make([
            'category_id' => $Desktop,
            'name'        => 'DeskPro Mini',
            'brand'       => 'Tecci',
            'description' => 'Compact desktop PC for small spaces',
            'price'       => 549.99,
            'student_price' => 449.99,
            'qty'         => 10,
            'image_url' => 'images/products/DeskPro Mini.jpg',
        ]);

        $make([
            'category_id' => $Desktop,
            'name'        => 'NovaStation G1',
            'brand'       => 'NovaTech',
            'description' => 'Entry gaming desktop',
            'price'       => 799.99,
            'student_price' => 359.99,
            'qty'         => 8,
            'image_url' => 'images/products/NovaStation G1.jpg',
        ]);

                $make([
            'category_id' => $Desktop,
            'name'        => 'SuperPC Tower',
            'brand'       => 'PeelTech',
            'description' => 'Reliable all-purpose desktop',
            'price'       => 499.99,
            'student_price' => 429.99,
            'qty'         => 8,
            'image_url' => 'images/products/SuperPC Tower.jpg',
        ]);

            $make([
            'category_id' => $Desktop,
            'name'        => 'WorkMate Office',
            'brand'       => 'LiteEdge',
            'description' => 'Office desktop bundle',
            'price'       => 449.99,
            'student_price' => 229.99,
            'qty'         => 8,
            'image_url' => 'images/products/WorkMate Office.jpg',
        ]);

            $make([
            'category_id' => $Desktop,
            'name'        => 'PowerBox Z4',
            'brand'       => 'ForgeX',
            'description' => 'Performance desktop for creative work',
            'price'       => 999.99,
            'student_price' => 899.99,
            'qty'         => 8,
            'image_url' => 'images/products/PowerBox Z4.jpg',
        ]);


        // Example Tablets products
            $make([
            'category_id' => $Tablet,
            'name'        => 'UniTab 10',
            'brand'       => 'Tecci',
            'description' => '10-inch screen, great for notes',
            'price'       => 299.99,
            'student_price' => 249.99,
            'qty'         => 10,
            'image_url' => 'images/products/UniTab 10.jpg',
        ]);

        $make([
            'category_id' => $Tablet,
            'name'        => 'UniTab 8 Mini',
            'brand'       => 'Tecci',
            'description' => 'Portable 8-inch student tablet',
            'price'       => 199.99,
            'student_price' => 59.99,
            'qty'         => 8,
            'image_url' => 'images/products/UniTab 8 Mini.jpg',
        ]);

                $make([
            'category_id' => $Tablet,
            'name'        => 'SlatePad 12',
            'brand'       => 'NovaTech',
            'description' => 'Large 12-inch productivity tablet',
            'price'       => 379.99,
            'student_price' => 229.99,
            'qty'         => 8,
            'image_url' => 'images/products/SlatePad 12.jpg',
        ]);

            $make([
            'category_id' => $Tablet,
            'name'        => 'StudyTab Pro',
            'brand'       => 'PeelTech',
            'description' => 'Tablet for lecture notes & sketching',
            'price'       => 349.99,
            'student_price' => 229.99,
            'qty'         => 8,
            'image_url' => 'images/products/StudyTab Pro.jpg',
        ]);

            $make([
            'category_id' => $Tablet,
            'name'        => 'LiteTab X',
            'brand'       => 'LiteEdge',
            'description' => 'Lightweight tablet with long battery',
            'price'       => 229.99,
            'student_price' => 199.99,
            'qty'         => 8,
            'image_url' => 'images/products/LiteTab X.jpg',
        ]);


        // Example Phones products
            $make([
            'category_id' => $Phone,
            'name'        => 'CampusPhone Lite',
            'brand'       => 'NovaTech',
            'description' => 'Affordable student smartphone',
            'price'       => 199.99,
            'student_price' => 99.99,
            'qty'         => 10,
            'image_url' => 'images/products/CampusPhone Lite.jpg',
        ]);

        $make([
            'category_id' => $Phone,
            'name'        => 'CampusPhone S2',
            'brand'       => 'NovaTech',
            'description' => 'Mid-range smartphone with strong battery',
            'price'       => 249.99,
            'student_price' => 159.99,
            'qty'         => 8,
            'image_url' => 'images/products/CampusPhone S2.jpg',
        ]);

                $make([
            'category_id' => $Phone,
            'name'        => 'TalkEasy Mini',
            'brand'       => 'LiteEdge',
            'description' => 'Compact phone for everyday use',
            'price'       => 149.99,
            'student_price' => 129.99,
            'qty'         => 8,
            'image_url' => 'images/products/TalkEasy Mini.jpg',
        ]);

            $make([
            'category_id' => $Phone,
            'name'        => 'TecciPhone X',
            'brand'       => 'Tecci',
            'description' => 'Flagship-quality budget phone',
            'price'       => 349.99,
            'student_price' => 229.99,
            'qty'         => 8,
            'image_url' => 'images/products/TecciPhone X.jpg',
        ]);

            $make([
            'category_id' => $Phone,
            'name'        => 'StudyPhone Ultra',
            'brand'       => 'PeelTech',
            'description' => 'Phone ideal for student multitasking',
            'price'       => 229.99,
            'student_price' => 199.99,
            'qty'         => 8,
            'image_url' => 'images/products/StudyPhone Ultra.jpg',
        ]);

        // Example Accssory products
            $make([
            'category_id' => $Accessory,
            'name'        => 'Study Headphones Wireless',
            'brand'       => 'TecciSound',
            'description' => 'Noise-cancelling headphones',
            'price'       => 59.99,
            'student_price' => 39.99,
            'qty'         => 10,
            'image_url' => 'images/products/Study Headphones Wireless.jpg',
        ]);

        $make([
            'category_id' => $Accessory,
            'name'        => 'CampusMouse Pro',
            'brand'       => 'PeelTech',
            'description' => 'Wireless ergonomic mouse',
            'price'       => 24.99,
            'student_price' => 19.99,
            'qty'         => 8,
            'image_url' => 'images/products/CampusMouse Pro.jpg',
        ]);

                $make([
            'category_id' => $Accessory,
            'name'        => 'LiteKeyboard 104',
            'brand'       => 'LiteEdge',
            'description' => 'Full-size keyboard for typing',
            'price'       => 19.99,
            'student_price' => 9.99,
            'qty'         => 8,
            'image_url' => 'images/products/LiteKeyboard 104.jpg',
        ]);

            $make([
            'category_id' => $Accessory,
            'name'        => 'NovaCharger 30W',
            'brand'       => 'NovaTech',
            'description' => 'Fast USB-C charger',
            'price'       => 14.99,
            'student_price' => 9.99,
            'qty'         => 8,
            'image_url' => 'images/products/NovaCharger 30W.jpg',
        ]);

            $make([
            'category_id' => $Accessory,
            'name'        => 'DeskLight LED',
            'brand'       => 'BrightDesk',
            'description' => 'Adjustable LED desk lamp',
            'price'       => 29.99,
            'student_price' => 9.99,
            'qty'         => 8,
            'image_url' => 'images/products/DeskLight LED.jpg',
        ]);

    }

}