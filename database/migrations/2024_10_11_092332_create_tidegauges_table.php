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
        Schema::create('tidegauges', function (Blueprint $table) {
            $table->id();
            $table->string('_serial');
            $table->string('_country');
            $table->string('_loc');
            $table->decimal('_lat', 10, 8);  // Latitude with precision (10 total digits, 8 after decimal)
            $table->decimal('_lon', 10, 8);  // Longitude with precision (10 total digits, 8 after decimal)
            $table->date('_date');
            $table->time('_time');
            $table->decimal('_tide', 8, 2);  // Assuming tide is a decimal value
            $table->string('_units');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tidegauges');
    }
};
