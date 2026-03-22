<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /* Run the migrations */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Add shipping address fields
            $table->string('first_name')->nullable()->after('status');
            $table->string('last_name')->nullable()->after('first_name');
            $table->string('address_line1')->nullable()->after('last_name');
            $table->string('address_line2')->nullable()->after('address_line1');
            $table->string('city', 100)->nullable()->after('address_line2');
            $table->string('postcode', 20)->nullable()->after('city');
            $table->string('country', 100)->nullable()->after('postcode');
            $table->string('phone', 20)->nullable()->after('country');
        });
    }

    /* Reverse the migrations */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'first_name',
                'last_name',
                'address_line1',
                'address_line2',
                'city',
                'postcode',
                'country',
                'phone'
            ]);
        });
    }
};
