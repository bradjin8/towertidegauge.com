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
        Schema::create('weathers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tidegauge_id')->constrained()->onDelete('cascade');
            $table->string('header');
            $table->date('_date')->nullable();
            $table->time('_time')->nullable();
            $table->decimal('barometric_pressure_inches', 8, 2);
            $table->decimal('barometric_pressure_mm', 8, 3);
            $table->decimal('air_temperature', 8, 1);
            $table->decimal('water_temperature', 8, 2);
            $table->decimal('relative_humidity', 8, 1);
            $table->decimal('absolute_humidity', 8, 1);
            $table->decimal('dew_point', 8, 1);
            $table->decimal('wind_direction_true', 8, 1);
            $table->decimal('wind_direction_mg', 8, 1);
            $table->decimal('wind_speed_kts', 8, 1);
            $table->decimal('wind_speed_mps', 8, 1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weathers');
    }
};
