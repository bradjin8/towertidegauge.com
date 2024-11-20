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
        //
        Schema::table('tidegauges', function (Blueprint $table) {
            $table->dropColumn(['_date', '_time', '_tide', '_units']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('tidegauges', function (Blueprint $table) {
            $table->date('_date');
            $table->time('_time');
            $table->decimal('_tide', 8, 2);
            $table->string('_units');
        });
    }
};
