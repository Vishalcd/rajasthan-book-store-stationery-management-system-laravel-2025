<?php

namespace Database\Factories;

use App\Models\School;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class SchoolFactory extends Factory
{
    protected $model = School::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company().' School',
            'code' => strtoupper($this->faker->bothify('SCH###')),
            'principal_name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->numerify('98########'),
            'address' => $this->faker->address(),
            'logo' => "schools/logo/LakBSJz6IMz58QM3wfDLwBAz7OGQFNTAn7WM9KMb.png",
            'total_revenue' => $this->faker->randomFloat(2, 10000, 500000),
        ];
    }

    public function configure(): self
    {
        return $this->afterCreating(function (School $school) {
            // Create the school head user with the same email as the school
            User::factory()->create([
                'name' => 'Head of '.$school->name,
                'email' => $school->email,
                'password' => Hash::make('password'),
                'role' => 'school_head',
                'school_id' => $school->id,
            ]);
        });
    }
}
