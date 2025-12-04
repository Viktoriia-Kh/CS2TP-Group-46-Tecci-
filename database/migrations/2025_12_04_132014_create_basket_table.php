<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(){
    Schema::create('basket', function (Blueprint $table) {
        $table->id();
        $table->string('product');
        $table->decimal('price', 10, 2);
        $table->integer('quantity')->default(1);
        $table->string('image_url')->nullable(); // product image
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('basket');
    }
};
