<?php

namespace Database\Factories;

use App\Models\Bundle;
use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

class InvoiceFactory extends Factory
{
    protected $model = Invoice::class;

    public function definition(): array
    {
        $bundle = Bundle::inRandomOrder()->first() ?? Bundle::factory()->create();

        return [
            'bundle_id' => $bundle->id,
            'invoice_number' => 'INV-'.str_pad($bundle->id, 6, '0', STR_PAD_LEFT),
            'amount' => $bundle->bundle_price ?? $this->faker->randomFloat(2, 200, 2000),
            'customer_name' => $this->faker->name(),
            'customer_number' => $this->faker->unique()->phoneNumber(),
            'note' => $this->faker->optional()->sentence(),
            'created_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'updated_at' => now(),
        ];
    }
}
