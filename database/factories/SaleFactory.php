<?php

namespace Database\Factories;

use App\Models\Sale;
use App\Models\Invoice;
use App\Models\Bundle;
use Illuminate\Database\Eloquent\Factories\Factory;

class SaleFactory extends Factory
{
    protected $model = Sale::class;

    public function definition(): array
    {
        $bundle = Bundle::inRandomOrder()->first() ?? Bundle::factory()->create();
        $invoice = Invoice::inRandomOrder()->first() ?? Invoice::factory()->create(['bundle_id' => $bundle->id]);

        return [
            'invoice_id' => $invoice->id,
            'bundle_id' => $bundle->id,
            'amount' => $invoice->amount ?? $this->faker->randomFloat(2, 200, 2000),
            'created_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'updated_at' => now(),
        ];
    }
}
