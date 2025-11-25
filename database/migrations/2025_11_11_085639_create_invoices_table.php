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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->nullable();


            // Relationship: invoice belongs to a bundle
            $table->foreignId('bundle_id')
                ->constrained()
                ->cascadeOnDelete();

            // Customer Info (Optional)
            $table->string('customer_name')->nullable();
            $table->string('customer_number')->nullable();

            // Financials
            $table->decimal('amount', 10, 2);

            // Optional Notes
            $table->text('note')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
