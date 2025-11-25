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
        // Bundles Table
        Schema::create('bundles', function (Blueprint $table) {
            $table->id();

            // Relationship: bundle belongs to a school
            $table->foreignId('school_id')
                ->constrained()
                ->cascadeOnDelete();

            // Bundle Details
            $table->string('bundle_name');
            $table->string('class_name');

            // Pricing & Revenue
            $table->decimal('school_percentage', 5, 2)->default(0); // % given to school
            // Customer discount in percentage
            $table->decimal('customer_discount', 5, 2)->default(0);

            // QR Code
            $table->string('qr_code')->unique();

            $table->timestamps();
        });

        // Pivot Table (Books <-> Bundles)
        Schema::create('book_bundle', function (Blueprint $table) {
            $table->id();

            $table->foreignId('book_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('bundle_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_bundle');
        Schema::dropIfExists('bundles');
    }
};
