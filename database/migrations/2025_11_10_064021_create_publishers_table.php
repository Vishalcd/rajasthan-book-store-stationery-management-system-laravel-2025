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
        Schema::create('publishers', function (Blueprint $table) {
            $table->id();

            // Basic Details
            $table->string('name');                 // Publisher or company name
            $table->string('contact_person')->nullable();

            // Contact Info
            $table->string('email')->nullable();
            $table->string('phone')->nullable();

            // Address Info
            $table->string('address')->nullable();

            // Timestamps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publishers');
    }
};
