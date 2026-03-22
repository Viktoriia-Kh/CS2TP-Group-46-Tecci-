<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Supports guest & authenticated user baskets:
     * - Guests identified by session_id (Laravel session token)
     * - Users identified by user_id (foreign key to users table)
     */
    public function up(): void
    {
        Schema::create('basket_items', function (Blueprint $table) {
            $table->id();
            
            // USER IDENTIFICATION (one of these will be set)
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('session_id')->nullable()->index(); // For guest users
            
            // PRODUCT REFERENCE
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            
            // ITEM DETAILS
            $table->integer('quantity')->default(1);
            
            // TIMESTAMPS
            $table->timestamps();
            
            // INDEXES for performance
            $table->index(['user_id', 'product_id']); // Fast lookup for logged-in users
            $table->index(['session_id', 'product_id']); // Fast lookup for guests
            
            // CONSTRAINT: Prevent duplicate items for same user/session + product
            // This ensures one row per product per user/session
            $table->unique(['user_id', 'product_id', 'session_id'], 'unique_basket_item');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('basket_items');
    }
};
