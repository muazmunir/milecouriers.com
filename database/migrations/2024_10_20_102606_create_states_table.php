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
        Schema::create('states', function (Blueprint $table) {
            $table->id();
            $table->string('name');                              // State name
            $table->unsignedBigInteger('country_id');            // Foreign key to countries table
            $table->string('state_code')->nullable();            // State code (optional, matches `state_code` from your JSON)
            $table->decimal('latitude', 10, 8)->nullable();      // Latitude (optional)
            $table->decimal('longitude', 11, 8)->nullable();     // Longitude (optional)
            // Foreign key constraint for country_id
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('states');
    }
};
