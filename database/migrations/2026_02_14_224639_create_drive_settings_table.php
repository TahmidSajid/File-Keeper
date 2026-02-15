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
        Schema::create('drive_settings', function (Blueprint $table) {
            $table->id();
            $table->string('google_client_id');
            $table->string('google_client_secret');
            $table->string('google_refresh_token')->nullable();
            $table->string('folder_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drive_settings');
    }
};
