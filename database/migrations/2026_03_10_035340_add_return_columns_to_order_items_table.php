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
    Schema::table('order_items', function (Blueprint $table) {
        // Only add 'return_reason' if it doesn't already exist
        if (!Schema::hasColumn('order_items', 'return_reason')) {
            $table->text('return_reason')->nullable();
        }

        // Only add 'return_status' if it doesn't already exist
        if (!Schema::hasColumn('order_items', 'return_status')) {
            $table->string('return_status')->nullable();
        }
    });
        }

    public function down()
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn(['return_reason', 'return_status']);
        });
    }
};
