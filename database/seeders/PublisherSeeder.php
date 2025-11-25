<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Publisher;

class PublisherSeeder extends Seeder
{
    public function run(): void
    {
        $publishers = [
            [
                'name' => 'Tantia Publications',
                'contact_person' => 'Mahaveer Chaudhary',
                'email' => 'info@tantia-publications.com',
                'phone' => '9876543210',
                'address' => 'Sriganganagar, Rajasthan',
            ],
            [
                'name' => 'Blesswin Books Company',
                'contact_person' => 'Navyansh Yadav',
                'email' => 'contact@blesswinbooks.in',
                'phone' => '9123456789',
                'address' => 'Jaipur, Rajasthan',
            ],
            [
                'name' => 'Bright Future Publishers',
                'contact_person' => 'Rahul Verma',
                'email' => 'info@brightfuturepub.com',
                'phone' => '9988776655',
                'address' => 'Delhi, India',
            ],
        ];

        foreach ($publishers as $publisher) {
            Publisher::create($publisher);
        }

        // ✅ Generate 21 random publishers via factory
        Publisher::factory()->count(21)->create();
    }
}
