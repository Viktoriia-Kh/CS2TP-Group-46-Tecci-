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
        Schema::create('categories', function (Blueprint $table) {
            $table->id(); // Primary key (category_id)
            $table->string('name', 100); // Category names like laptops or phones
            $table->text('description')->nullable(); // Optional category description
            $table->boolean('is_active')->default(true); // To hide/show categories
            $table->timestamps();  // Track when created or updated
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
