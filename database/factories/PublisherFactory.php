<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PublisherFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->company().' Publications',
            'contact_person' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->numerify('9#########'),
            'address' => $this->faker->city().', '.$this->faker->state(),
        ];
    }
}
