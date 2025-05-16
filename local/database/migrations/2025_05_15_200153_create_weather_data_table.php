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
        Schema::create('weather_data', function (Blueprint $table) {
            $table->id();
            $table->string('serial', 20);
            $table->string('time', 20);
            $table->decimal('wind_direction', 5,1);
            $table->decimal('wind_speed', 5,1);
            $table->decimal('temperature', 5,1);
            $table->decimal('humidity', 5,1);
            $table->decimal('pressure', 5,1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weather_data');
    }
};
