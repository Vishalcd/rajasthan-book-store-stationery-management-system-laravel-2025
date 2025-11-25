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
        Schema::create('extra_items', function (Blueprint $table) {
            $table->id();

            // Link each extra item to an invoice
            $table->foreignId('invoice_id')
                ->constrained()
                ->cascadeOnDelete();

            // Item details
            $table->string('name');
            $table->decimal('price', 10, 2);
            $table->integer('quantity')->default(1);
            $table->decimal('total_price', 10, 2)->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extra_items');
    }
};
