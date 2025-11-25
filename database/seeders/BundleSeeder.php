<?php

namespace Database\Seeders;

use App\Models\Bundle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BundleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 12 bundles
        Bundle::factory()->count(12)->create();
    }
}
