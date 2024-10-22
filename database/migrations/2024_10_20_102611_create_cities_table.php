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
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('name');                    // City name
            $table->unsignedBigInteger('state_id');    // Foreign key to states table
            $table->unsignedBigInteger('country_id');  // Foreign key to countries table
            $table->decimal('latitude', 10, 7)->nullable();  // Latitude (optional)
            $table->decimal('longitude', 10, 7)->nullable(); // Longitude (optional)
            
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};
