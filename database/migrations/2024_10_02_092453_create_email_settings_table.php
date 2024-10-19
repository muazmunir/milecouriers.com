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
        Schema::create('email_settings', function (Blueprint $table) {
            $table->id();
            $table->text('driver')->nullable();
            $table->text('host')->nullable();
            $table->text('port')->nullable();
            $table->text('username')->nullable();
            $table->text('password')->nullable();
            $table->text('encryption')->nullable();
            $table->text('sender_email')->nullable();
            $table->text('sender_name')->nullable();
            $table->text('reply_email')->nullable();
            $table->boolean('status')->default('1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_settings');
    }
};
