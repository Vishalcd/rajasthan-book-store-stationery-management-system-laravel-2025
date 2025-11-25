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
        Schema::create('schools', function (Blueprint $table) {
            $table->id();

            // Basic Information
            $table->string('name');                          // School name
            $table->string('code')->nullable()->unique();    // Optional unique school code (e.g., SCH001)

            // Contact Information
            $table->string('principal_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();

            // Media
            $table->string('logo')->nullable();               // Logo image path

            // Finance
            $table->decimal('total_revenue', 12, 2)->default(0); // Total revenue from sold bundles

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schools');
    }
};
