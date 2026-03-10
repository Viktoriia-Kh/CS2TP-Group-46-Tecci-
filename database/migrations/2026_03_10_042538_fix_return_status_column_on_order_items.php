<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(){
        Schema::table('order_items', function (Blueprint $table) {
           
            $table->dropColumn('return_status');
        });

        Schema::table('order_items', function (Blueprint $table) {
            
            $table->string('return_status')->nullable()->default('none');
        });
    }

    public function down(){
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('return_status');
        });
    }
};
