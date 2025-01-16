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
        Schema::create('tank_sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prospect_id')->nullable()->constrained();
            $table->foreignId('customer_id')->nullable()->constrained();
            $table->string('requested_by');
            $table->string('requested_by_email');
            $table->timestamp('requested_at');
            $table->string('contact_name');
            $table->string('contact_email');
            $table->string('contact_phone');
            $table->string('requirement_urgent');
            $table->string('timeline');
            $table->string('fuel_type');
            $table->string('tank_type');
            $table->string('tank_size');
            $table->string('tank_location');
            $table->string('additional_requirements');
            $table->decimal('quotes', 10, 2);
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tank_sales');
    }
};
