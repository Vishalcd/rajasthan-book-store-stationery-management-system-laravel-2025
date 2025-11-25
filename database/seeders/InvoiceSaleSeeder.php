<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Invoice;
use App\Models\Sale;
use App\Models\Bundle;

class InvoiceSaleSeeder extends Seeder
{
    public function run(): void
    {
        // Make sure there are bundles first
        if (Bundle::count() === 0) {
            $this->command->warn('No bundles found. Creating 5 sample bundles...');
            Bundle::factory(5)->create();
        }

        $this->command->info('Creating invoices and linked sales...');

        // Create 20 invoices with sales
        Invoice::factory(20)->create()->each(function ($invoice) {
            Sale::factory()->create([
                'invoice_id' => $invoice->id,
                'bundle_id' => $invoice->bundle_id,
                'amount' => $invoice->amount,
            ]);
        });

        $this->command->info('✅ 20 Invoices & Sales created successfully.');
    }
}
