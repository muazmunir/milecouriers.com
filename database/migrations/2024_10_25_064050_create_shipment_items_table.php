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
        Schema::create('shipment_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shipment_id')->constrained('shipments')->onDelete('cascade'); // Foreign key to shipments
            $table->string('description'); // Package description
            $table->unsignedBigInteger('type_of_packaging_id'); // Foreign key to packaging types
            $table->decimal('quantity', 8, 2)->default(0); // Quantity
            $table->decimal('weight', 8, 2)->default(0); // Weight
            $table->decimal('declared_value', 10, 2)->default(0); // Declared value
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipment_items');
    }
};
