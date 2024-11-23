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
        Schema::create('smart_meters', function (Blueprint $table) {
            $table->id();
    $table->string('serial_number')->unique();
    $table->string('location');
    $table->string('status')->default('active'); // active, inactive
    $table->decimal('last_reading', 8, 2)->nullable()->change(); 
    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('smart_meters');
    }
};