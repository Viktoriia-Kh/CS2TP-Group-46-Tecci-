<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();  // Primary key (inventory_id)

            // Link inventory to product
            $table->foreignId('product_id')
                ->constrained(`products`)  // references products.id
                ->cascadeOnDelete();

            $table->integer('quantity_available')->default(0); // Current stock level
            $table->integer('reorder_threshold')->default(5);  // When to alert low stock
            $table->timestamp('last_reordered')->nullable();   // Admin log for restock

            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
