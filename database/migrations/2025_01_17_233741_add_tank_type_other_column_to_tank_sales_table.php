<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tank_sales', function (Blueprint $table) {
            $table->string('tank_type_other')->nullable()->after('tank_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tank_sales', function (Blueprint $table) {
            $table->dropColumn('tank_type_other');
        });
    }
};