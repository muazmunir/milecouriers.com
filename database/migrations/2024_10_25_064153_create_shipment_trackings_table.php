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
        Schema::create('shipment_trackings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipment_id')->constrained('shipments')->onDelete('cascade'); // Foreign key linking to shipments table
            $table->string('location'); // The location of the shipment
            $table->timestamp('tracked_at'); // The timestamp of when the tracking information was recorded
            $table->unsignedBigInteger('status_id')->nullable(); // Status of the shipment (can use ENUM for predefined statuses)
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipment_trackings');
    }
};
