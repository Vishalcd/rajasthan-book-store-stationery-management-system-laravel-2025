<?php

namespace Database\Seeders;

use App\Models\Bundle;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Validation\Rules\In;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $this->call([
            PublisherSeeder::class,
            BookSeeder::class,
            SchoolSeeder::class,
            BundleSeeder::class,
            InvoiceSaleSeeder::class,
        ]);
    }
}
