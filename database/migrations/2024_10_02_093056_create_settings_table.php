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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('logo')->nullable();
            $table->text('favicon')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('instagram')->nullable();
            $table->string('github')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('fax')->nullable();
            $table->text('address')->nullable();
            $table->string('language')->nullable();
            $table->unsignedBigInteger('timezone_id')->nullable();
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->text('copyright_text')->nullable();
            $table->string('google_analytics_id')->nullable();
            $table->boolean('is_google_analytics')->default(false);
            $table->string('facebook_chat_page_id')->nullable();
            $table->boolean('is_facebook_chat')->default(false);
            $table->string('recaptcha_site_key')->nullable();
            $table->string('recaptcha_secret_key')->nullable();
            $table->boolean('is_recaptcha')->default(false);
            $table->string('google_oauth_client_id')->nullable();
            $table->string('google_oauth_secret')->nullable();
            $table->boolean('is_google_oauth')->default(false);
            $table->string('facebook_oauth_client_id')->nullable();
            $table->string('facebook_oauth_secret')->nullable();
            $table->boolean('is_facebook_oauth')->default(false);
            $table->string('github_oauth_client_id')->nullable();
            $table->string('github_oauth_secret')->nullable();
            $table->boolean('is_github_oauth')->default(false);
            $table->boolean('status')->default('1');
            $table->timestamps();
            $table->foreign('timezone_id')->references('id')->on('timezones')->onDelete('cascade');
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
