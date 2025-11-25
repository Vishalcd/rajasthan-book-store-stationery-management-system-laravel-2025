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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();

            // Relationship: sale belongs to an invoice
            $table->foreignId('invoice_id')
                ->constrained()
                ->cascadeOnDelete();

            // Relationship: sale belongs to a bundle
            $table->foreignId('bundle_id')
                ->constrained()
                ->cascadeOnDelete();

            // Financial amount for this sale entry
            $table->decimal('amount', 10, 2);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
