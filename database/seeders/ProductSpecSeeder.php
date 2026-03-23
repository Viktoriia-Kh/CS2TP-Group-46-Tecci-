<?php
namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductSpec;
use Illuminate\Database\Seeder;

class ProductSpecSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::with('category')->get();

        foreach ($products as $product) {

            // Decide spec set based on category
            $category = strtolower($product->category->name ?? '');

            $specs = [];

            if (str_contains($category, 'laptop')) { // laptops
                $specs = [
                    'Processor' => collect(['Intel i5', 'Intel i7', 'Ryzen 5', 'Ryzen 7'])->random(),
                    'RAM' => collect(['8GB', '16GB', '32GB'])->random(),
                    'Storage' => collect(['256GB SSD', '512GB SSD', '1TB SSD'])->random(),
                    'Display' => collect(['13"', '14"', '15.6"'])->random(),
                    'Battery Life' => collect(['6 hours', '8 hours', '10 hours'])->random(),
                ];
            }

            elseif (str_contains($category, 'desktop') || str_contains($category, 'pc')) {// PCs
                $specs = [
                    'Processor' => collect(['Intel i7', 'Intel i9', 'Ryzen 7', 'Ryzen 9'])->random(),
                    'RAM' => collect(['16GB', '32GB', '64GB'])->random(),
                    'Storage' => collect(['512GB SSD', '1TB SSD', '2TB SSD'])->random(),
                    'GPU' => collect(['RTX 3060', 'RTX 3070', 'RTX 4060'])->random(),
                ];
            }

            elseif (str_contains($category, 'phone')) {// phones
                $specs = [
                    'Screen Size' => collect(['6.1"', '6.5"', '6.7"'])->random(),
                    'Storage' => collect(['64GB', '128GB', '256GB'])->random(),
                    'Camera' => collect(['12MP', '48MP', '108MP'])->random(),
                    'Battery' => collect(['3000mAh', '4000mAh', '5000mAh'])->random(),
                ];
            }

            elseif (str_contains($category, 'tablet')) {// tablets
                $specs = [
                    'Screen Size' => collect(['10"', '11"', '12.9"'])->random(),
                    'Storage' => collect(['64GB', '128GB', '256GB'])->random(),
                    'Battery Life' => collect(['8 hours', '10 hours', '12 hours'])->random(),
                ];
            }

            else { // accessories
                $specs = [
                    'Compatibility' => collect(['Universal', 'Windows', 'Mac'])->random(),
                    'Connectivity' => collect(['USB', 'Bluetooth', 'Wireless'])->random(),
                    'Warranty' => collect(['1 Year', '2 Years'])->random(),
                ];
            }

            // Save specs (no duplicates)
            foreach ($specs as $name => $value) {
                ProductSpec::create([
                    'product_id' => $product->id,
                    'spec_name' => $name,
                    'spec_value' => $value,
                ]);
            }
        }
    }
}