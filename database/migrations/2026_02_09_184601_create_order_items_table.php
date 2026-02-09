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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade'); 
            $table->foreignId('product_id');
            $table->string('product_name'); // Save name in case product is deleted later
            $table->integer('quantity');
            $table->decimal('price', 10, 2); // Save price at time of purchase
            $table->string('image_url')->nullable(); // Save the image URL for history
            $table->enum('return_status', ['none', 'requested', 'approved'])->default('none');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
