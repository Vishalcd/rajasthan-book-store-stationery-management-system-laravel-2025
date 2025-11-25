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
        Schema::create('books', function (Blueprint $table) {
            $table->id();

            // Relationship: Each book belongs to a publisher
            $table->foreignId('publisher_id')
                ->constrained()            // references "id" on publishers table
                ->cascadeOnDelete();       // delete books when publisher is deleted

            // Book Info
            $table->string('title');
            $table->string('author')->nullable(); // Can extend later to authors table
            $table->text('description')->nullable();

            // Pricing
            $table->decimal('purchase_price', 10, 2)->default(0);
            $table->decimal('selling_price', 10, 2)->default(0);

            // Inventory
            $table->integer('stock_quantity')->default(0);

            // Media
            $table->string('cover_image')->nullable(); // Storage path of book cover

            // Timestamps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
