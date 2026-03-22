<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminInventoryController extends Controller
{
    public function index()
    {
        // Load all products with category and inventory
        $products = Product::with(['category', 'inventory', 'specs'])->get();

        // Convert DB products
        $productsForJs = $products->map(function ($p) {
            return [
                'id'        => $p->id,
                'name'      => $p->name,
                'price'     => (float) $p->price,
                'category'  => $p->category
                                ? strtolower(str_replace(' ', '', $p->category->name))
                                : 'uncategorised',
                'condition' => $p->condition ?? 'new',
                'description' => $p->description,
                'image_url' => $p->image_url
                    ? asset($p->image_url)
                    : asset('images/Laptop.jpg'),
                'stock_quantity' => $p->inventory ? $p->inventory->quantity_available : 0,
                'stock_status' => $p->stock_status,
                'specs' => $p->specs->map(function ($spec) {
                    return [
                        'spec_name' => $spec->spec_name,
                        'spec_value' => $spec->spec_value,
                    ];
                })->values(),
            ];
        });

        // Render YOUR list page view
        return view('admin-inventory', [
            'productsForJs' => $productsForJs,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'category' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $categoryMap = [
            'desktops' => 'Desktops',
            'laptops' => 'Laptops',
            'phones' => 'Phones',
            'tablets' => 'Tablets',
            'accessories' => 'Accessories',
        ];

        $categoryName = $categoryMap[$request->category] ?? null;
        $category = Category::where('name', $categoryName)->first();

        if (!$category) {
            return response()->json(['message' => 'Category not found.'], 422);
        }

        $imagePath = 'images/Laptop.jpg';

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . preg_replace('/\s+/', '-', strtolower($file->getClientOriginalName()));
            $file->move(public_path('images/products'), $filename);
            $imagePath = 'images/products/' . $filename;
        }

        $product = Product::create([
            'category_id' => $category->id,
            'name' => $request->name,
            'brand' => 'Tecci',
            'description' => $request->description,
            'price' => $request->price,
            'student_price' => null,
            'image_url' => $imagePath,
        ]);

        $product->inventory()->create([
            'quantity_available' => $request->stock_quantity,
            'reorder_threshold' => 5,
        ]);

        $product->images()->create([
            'image_path' => $imagePath,
            'is_primary' => true,
            'sort_order' => 1,
        ]);

        // Save product specs
        $specNames = $request->input('spec_names', []);
        $specValues = $request->input('spec_values', []);

        foreach ($specNames as $index => $specName) {
            $specValue = $specValues[$index] ?? null;

            if (!empty($specName) && !empty($specValue)) {
                $product->specs()->create([
                    'spec_name' => $specName,
                    'spec_value' => $specValue,
                ]);
            }
        }

        return response()->json([
            'message' => 'Product added successfully.',
        ]);
    }
    
    // UPDATE PRODUCT (SAVES EDIT CHANGES TO DATABASE)
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:150',
            'category' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $categoryMap = [
            'desktops' => 'PCs',
            'laptops' => 'Laptops',
            'phones' => 'Phones',
            'tablets' => 'Tablets',
            'accessories' => 'Accessories',
        ];

        $categoryName = $categoryMap[$request->category] ?? null;
        $category = \App\Models\Category::where('name', $categoryName)->first();

        $imagePath = $product->image_url;

        // If admin uploaded a new image
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . preg_replace('/\s+/', '-', strtolower($file->getClientOriginalName()));
            $file->move(public_path('images/products'), $filename);
            $imagePath = 'images/products/' . $filename;
        }

        // Update product table
        $product->update([
            'category_id' => $category ? $category->id : $product->category_id,
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'image_url' => $imagePath,
        ]);

        // Update inventory table
        if ($product->inventory) {
            $product->inventory->update([
                'quantity_available' => $request->stock_quantity,
            ]);
        } else {
            $product->inventory()->create([
                'quantity_available' => $request->stock_quantity,
                'reorder_threshold' => 5,
            ]);
        }

        // Replace existing specs with new specs
        $product->specs()->delete();

        $specNames = $request->input('spec_names', []);
        $specValues = $request->input('spec_values', []);

        foreach ($specNames as $index => $specName) {
            $specValue = $specValues[$index] ?? null;

            if (!empty($specName) && !empty($specValue)) {
                $product->specs()->create([
                    'spec_name' => $specName,
                    'spec_value' => $specValue,
                ]);
            }
        }

        // Update image table too
        $product->images()->delete();
        $product->images()->create([
            'image_path' => $imagePath,
            'is_primary' => true,
            'sort_order' => 1,
        ]);

        return response()->json([
            'message' => 'Product updated successfully.'
        ]);
    }

    // DELETE PRODUCT (REMOVES FROM DATABASE)
    public function destroy(Product $product)
    {
        // Delete inventory first (to avoid foreign key issues)
        if ($product->inventory) {
            $product->inventory->delete();
        }

        // Delete related images (optional but good practice)
        $product->images()->delete();

        // Delete product
        $product->delete();

        return response()->json([
            'message' => 'Product deleted successfully.'
        ]);
    }
}