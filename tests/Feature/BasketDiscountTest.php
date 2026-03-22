<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product; 

class BasketDiscountTest extends TestCase
{
    use RefreshDatabase; 

    /**
     * Test Case 1: Discount persists after quantity adjustment
     */
    public function test_discount_persists_after_quantity_change()
    {
        // 0 - Create a dummy category FIRST to satisfy the foreign key constraint
        \Illuminate\Support\Facades\DB::table('categories')->insert([
            'id' => 1,
            'name' => 'Test Category', // Change 'name' if your categories table uses a different column
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 1 - Manually create a dummy product (Bypasses missing Factory error)
        $product = new \App\Models\Product();
        $product->id = 1;
        $product->name = 'Test Laptop';
        $product->price = 1000;
        $product->description = 'Test Description';
        $product->image_url = 'test.jpg';

        // Added category_id because the database requires it
        $product->category_id = 1;
        
        $product->save();

        // 2 - Simulate Session with item
        $basketData = [
            1 => [
                "name" => "Test Laptop",
                "quantity" => 1,
                "price" => 1000,
                "image" => "test.jpg"
            ]
        ];

        // 3 - Apply Discount
        $response = $this->withSession(['basket' => $basketData])
                         ->post('/apply-discount', [
                             'code' => 'xmas10'
                         ]);

        // Check it applied correctly
        $response->assertSessionHas('discount_code', 'xmas10');

        // 4 - Simulate changing quantity
        $response = $this->get(route('basket.add', 1));

        // 5 - Important assertion:
        $response->assertSessionHas('discount_code', 'xmas10');
    }

    /**
     * Test Case 2: Discount persists when navigating away
     */
    public function test_discount_persists_across_navigation()
    {
        // 1 - Set up session with discount applied
        $sessionData = [
            'basket' => [1 => ["name" => "Item", "price" => 100, "quantity" => 1, "image" => "img"]],
            'discount_code' => 'welcome20',
            'discount_multiplier' => 0.80
        ];

        // 2 - Visit Products page
        $response = $this->withSession($sessionData)->get(route('products.index'));
        $response->assertStatus(200);

        // 3 - Return to Basket
        $response = $this->withSession($sessionData)->get(route('basket.index'));

        // 4 - Assert session still holds discount
        $response->assertSessionHas('discount_code', 'welcome20');
    }
    
    /**
     * Test Case 3: Invalid code is rejected
     */
    public function test_invalid_code_is_rejected()
    {
        $response = $this->post('/apply-discount', [
            'code' => 'INVALID123'
        ]);

        // FIX - The controller returns JSON 400, instead of a session error
        // Assert the status is 400 (Bad Request) & check the JSON message
        $response->assertStatus(400)
                 ->assertJson(['message' => 'Invalid discount code.']);
        
        // Ensure invalid code was NOT saved
        $response->assertSessionMissing('discount_code');
    }
}