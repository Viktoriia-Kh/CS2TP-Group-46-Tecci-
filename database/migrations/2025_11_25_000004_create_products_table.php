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
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // Primary key (product_id)

            // Foreign key linking product → category
            $table->foreignId('category_id')
                ->constrained(`categories`) // references categories.id
                ->cascadeOnDelete(); // delete products if category deleted
    
            $table->string('name', 150); // Product name
            $table->string('brand')->nullable(); // Brand
            $table->text('description')->nullable(); // Description
            $table->decimal('price', 10, 2);  // Standard price
            $table->decimal('student_price', 10, 2)->nullable();  // Student price
            $table->string('image_url')->nullable();  // Image path or URL

            $table->timestamps(); // created_at + updated_at
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
