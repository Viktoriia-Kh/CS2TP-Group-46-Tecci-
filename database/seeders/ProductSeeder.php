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
            'description' => 'A 14-inch laptop with SSD storage that delivers fast boot times, improved system responsiveness, and enhanced durability, making it an excellent choice for students who require dependable performance for schoolwork, research, and everyday tasks.',
            'price'       => 499.99,
            'student_price' => 449.99,
            'qty'         => 4,
            'image_url'     => 'images/products/teccibook-14.jpg',      
        ]);

        $make([
            'category_id' => $laptops,
            'name'        => 'BudgetBook 15',
            'brand'       => 'NovaTech',
            'description' => 'A cost-efficient 15-inch laptop offering a spacious display, dependable processing power, and essential connectivity options, ideal for users who need a capable device without exceeding their budget.',
            'price'       => 399.99,
            'student_price' => 359.99,
            'qty'         => 0,
            'image_url' => 'images/products/budgetbook-15.jpg',
        ]);

                $make([
            'category_id' => $laptops,
            'name'        => 'TecciBook Pro',
            'brand'       => 'NovaTech',
            'description' => 'The NovaTech TecciBook Pro features a 14-inch display paired with SSD storage for fast boot times, efficient multitasking, and improved system responsiveness. Designed for everyday productivity, it offers dependable processing power, durable construction, and enough storage for school or work essentials. Ideal for students seeking performance without a premium price tag.',
            'price'       => 450.99,
            'student_price' => 429.99,
            'qty'         => 0,
            'image_url' => 'images/products/teccibook-pro.jpg',
        ]);

            $make([
            'category_id' => $laptops,
            'name'        => 'TecciBook Max XL',
            'brand'       => 'Tecci',
            'description' => 'A dependable 15-inch laptop built for everyday use, offering solid performance at an affordable price—perfect for students and casual users.',
            'price'       => 299.99,
            'student_price' => 229.99,
            'qty'         => 8,
            'image_url' => 'images/products/teccibook-max-xl.jpg',
        ]);

            $make([
            'category_id' => $laptops,
            'name'        => 'BudgetBook Max XL',
            'brand'       => 'NovaTeck',
            'description' => 'The BudgetBook Max XL is an affordable 15-inch laptop designed for everyday essentials. Ideal for students and casual users, it delivers reliable performance for web browsing, coursework, and streaming. With its spacious display and lightweight build, it offers great value without sacrificing usability.',
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
            'description' => 'A space-saving compact desktop PC that delivers impressive power in a tiny package. Ideal for tight work areas, apartments, and minimalist desk setups without sacrificing performance.',
            'price'       => 549.99,
            'student_price' => 449.99,
            'qty'         => 10,
            'image_url' => 'images/products/DeskPro Mini.jpg',
        ]);

        $make([
            'category_id' => $Desktop,
            'name'        => 'NovaStation G1',
            'brand'       => 'NovaTech',
            'description' => 'A powerful entry gaming desktop built to bring you into the world of PC gaming. Enjoy responsive gameplay and solid performance without the premium price tag.',
            'price'       => 799.99,
            'student_price' => 359.99,
            'qty'         => 8,
            'image_url' => 'images/products/NovaStation G1.jpg',
        ]);

                $make([
            'category_id' => $Desktop,
            'name'        => 'SuperPC Tower',
            'brand'       => 'PeelTech',
            'description' => 'A reliable all-purpose desktop built to handle everyday tasks with ease, from web browsing and office work to media streaming and light multitasking. Ideal for home, school, or office environments.',
            'price'       => 499.99,
            'student_price' => 429.99,
            'qty'         => 8,
            'image_url' => 'images/products/SuperPC Tower.jpg',
        ]);

            $make([
            'category_id' => $Desktop,
            'name'        => 'WorkMate Office',
            'brand'       => 'LiteEdge',
            'description' => 'Upgrade your workspace with this all-in-one office desktop bundle. Featuring a dependable desktop PC paired with essential accessories, it delivers seamless productivity for everyday office tasks.',
            'price'       => 449.99,
            'student_price' => 229.99,
            'qty'         => 8,
            'image_url' => 'images/products/WorkMate Office.jpg',
        ]);

            $make([
            'category_id' => $Desktop,
            'name'        => 'PowerBox Z4',
            'brand'       => 'ForgeX',
            'description' => 'Unleash your creativity with a performance desktop built for artists, designers, and creators. Engineered to handle demanding applications, it delivers smooth, efficient workflows for editing, rendering, and production.',
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
            'description' => 'A compact device featuring a 10-inch display, perfectly sized for taking notes, managing tasks, and staying organized on the go.',
            'price'       => 299.99,
            'student_price' => 249.99,
            'qty'         => 10,
            'image_url' => 'images/products/UniTab 10.jpg',
        ]);

        $make([
            'category_id' => $Tablet,
            'name'        => 'UniTab 8 Mini',
            'brand'       => 'Tecci',
            'description' => 'A portable 8-inch student tablet designed for learning on the go, offering a compact form factor that’s ideal for note-taking, reading, and completing everyday school tasks.',
            'price'       => 199.99,
            'student_price' => 59.99,
            'qty'         => 8,
            'image_url' => 'images/products/UniTab 8 Mini.jpg',
        ]);

                $make([
            'category_id' => $Tablet,
            'name'        => 'SlatePad 12',
            'brand'       => 'NovaTech',
            'description' => 'A productivity-focused tablet featuring a 12-inch display that enhances visibility and workspace for tasks such as document editing, digital drawing, multitasking, and video conferencing. Built for users who need a balance of portability and professional functionality.',
            'price'       => 379.99,
            'student_price' => 229.99,
            'qty'         => 8,
            'image_url' => 'images/products/SlatePad 12.jpg',
        ]);

            $make([
            'category_id' => $Tablet,
            'name'        => 'StudyTab Pro',
            'brand'       => 'PeelTech',
            'description' => 'Take better notes and unleash your creativity with a tablet built for both lecture halls and sketch sessions. With precise pen input and a fluid writing experience, it’s ideal for students and aspiring creators.',
            'price'       => 349.99,
            'student_price' => 229.99,
            'qty'         => 8,
            'image_url' => 'images/products/StudyTab Pro.jpg',
        ]);

            $make([
            'category_id' => $Tablet,
            'name'        => 'LiteTab X',
            'brand'       => 'LiteEdge',
            'description' => 'Stay unplugged longer with this ultra-light tablet built for life on the go. Its long-lasting battery ensures you can work, study, or stream anywhere, anytime.',
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
            'description' => 'A cost-effective smartphone tailored for students, featuring efficient hardware for multitasking, a durable battery for all-day use, and essential tools for studying, communication, and online learning.',
            'price'       => 199.99,
            'student_price' => 99.99,
            'qty'         => 10,
            'image_url' => 'images/products/CampusPhone Lite.jpg',
        ]);

        $make([
            'category_id' => $Phone,
            'name'        => 'CampusPhone S2',
            'brand'       => 'NovaTech',
            'description' => 'A mid-range smartphone offering balanced performance and a strong battery life, making it ideal for users who need reliability throughout the day without sacrificing features or speed.',
            'price'       => 249.99,
            'student_price' => 159.99,
            'qty'         => 8,
            'image_url' => 'images/products/CampusPhone S2.jpg',
        ]);

                $make([
            'category_id' => $Phone,
            'name'        => 'TalkEasy Mini',
            'brand'       => 'LiteEdge',
            'description' => 'Small in size, big on convenience. This compact phone delivers smooth everyday performance in a pocket-friendly design perfect for users who prefer simplicity and portability.',
            'price'       => 149.99,
            'student_price' => 129.99,
            'qty'         => 8,
            'image_url' => 'images/products/TalkEasy Mini.jpg',
        ]);

            $make([
            'category_id' => $Phone,
            'name'        => 'TecciPhone X',
            'brand'       => 'Tecci',
            'description' => 'A budget-friendly smartphone that delivers flagship-level features and performance, offering premium design, smooth operation, and advanced capabilities at an accessible price.',
            'price'       => 349.99,
            'student_price' => 229.99,
            'qty'         => 8,
            'image_url' => 'images/products/TecciPhone X.jpg',
        ]);

            $make([
            'category_id' => $Phone,
            'name'        => 'StudyPhone Ultra',
            'brand'       => 'PeelTech',
            'description' => 'Built for busy student life, this phone delivers effortless multitasking. Switch between study apps, streaming, and messaging without slowing down.',
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
            'description' => 'Escape the noise and dive into pure sound. These noise-cancelling headphones let you focus on your music, studies, or commute with powerful audio and outstanding comfort.',
            'price'       => 59.99,
            'student_price' => 39.99,
            'qty'         => 10,
            'image_url' => 'images/products/Study Headphones Wireless.jpg',
        ]);

        $make([
            'category_id' => $Accessory,
            'name'        => 'CampusMouse Pro',
            'brand'       => 'PeelTech',
            'description' => 'A wireless ergonomic mouse designed to provide natural hand positioning and long-lasting comfort, reducing strain during extended work or study sessions.',
            'price'       => 24.99,
            'student_price' => 19.99,
            'qty'         => 8,
            'image_url' => 'images/products/CampusMouse Pro.jpg',
        ]);

                $make([
            'category_id' => $Accessory,
            'name'        => 'LiteKeyboard 104',
            'brand'       => 'LiteEdge',
            'description' => 'Type with confidence on this full-size keyboard. Its spacious layout and comfortable key travel make it perfect for work, school, and long writing sessions',
            'price'       => 19.99,
            'student_price' => 9.99,
            'qty'         => 8,
            'image_url' => 'images/products/LiteKeyboard 104.jpg',
        ]);

            $make([
            'category_id' => $Accessory,
            'name'        => 'NovaCharger 30W',
            'brand'       => 'NovaTech',
            'description' => 'Power up in no time with this fast USB-C charger. Built for speed and convenience, it quickly restores your device’s battery so you can get back to what matters.',
            'price'       => 14.99,
            'student_price' => 9.99,
            'qty'         => 8,
            'image_url' => 'images/products/NovaCharger 30W.jpg',
        ]);

            $make([
            'category_id' => $Accessory,
            'name'        => 'DeskLight LED',
            'brand'       => 'BrightDesk',
            'description' => 'Light your workspace your way with this adjustable LED desk lamp. Its flexible design and crisp illumination make it perfect for late-night study sessions, detailed tasks, and everyday productivity.',
            'price'       => 29.99,
            'student_price' => 9.99,
            'qty'         => 8,
            'image_url' => 'images/products/DeskLight LED.jpg',
        ]);

    }

}