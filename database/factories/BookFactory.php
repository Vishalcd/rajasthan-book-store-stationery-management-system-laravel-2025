<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Publisher;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition()
    {
        return [
            'publisher_id' => Publisher::inRandomOrder()->first()?->id ?? Publisher::factory(),
            'title' => $this->faker->sentence(3),
            'author' => $this->faker->name(),
            'purchase_price' => $this->faker->randomFloat(2, 100, 500),
            'selling_price' => $this->faker->randomFloat(2, 600, 1000),
            'stock_quantity' => $this->faker->numberBetween(10, 100),
            'cover_image' => "books/cover/UrZp1Y0axvb9zDmrJp75ub9ABRcwcctDbDKdNBM1.jpg",
            'description' => $this->faker->paragraph(3),
        ];
    }
}
