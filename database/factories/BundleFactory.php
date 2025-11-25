<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\School;
use App\Models\Book;
use App\Models\Bundle;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use Str;

class BundleFactory extends Factory
{
    protected $model = Bundle::class;

    public function definition(): array
    {
        $school = School::inRandomOrder()->first() ?? School::factory()->create();
        $className = 'Class '.$this->faker->numberBetween(1, 12);

        return [
            'school_id' => $school->id,
            'bundle_name' => "$school->name $className Bundle",
            'class_name' => $className,
            'school_percentage' => $this->faker->randomFloat(2, 5, 20),
            'customer_discount' => $this->faker->randomFloat(2, 5, 10),
            'qr_code' => 'dummy'.Str::random(14), // will update after create
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Bundle $bundle) {

            // Use bundle ID instead of random code
            $bundleCode = $bundle->id;

            // Make directory
            Storage::disk('public')->makeDirectory('qrcodes');

            // File name
            $qrFileName = "bundle-{$bundleCode}.svg";

            // Generate QR using bundle ID link
            QrCode::format('svg')
                ->size(500)
                ->generate(
                    url('/checkout/bundle/'.$bundleCode),
                    storage_path('app/public/qrcodes/'.$qrFileName)
                );

            // Update bundle with QR file path
            $bundle->update([
                'qr_code' => 'qrcodes/'.$qrFileName,
            ]);

            // Attach books to pivot
            $books = Book::inRandomOrder()->take(rand(3, 6))->pluck('id');
            $bundle->books()->attach($books);
        });
    }
}
