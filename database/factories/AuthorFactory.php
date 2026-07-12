<?php

namespace Database\Factories;

use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

class AuthorFactory extends Factory
{
    protected $model = Author::class;

    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'middle_name' => fake()->randomElement([fake()->lastName(), null]),
            'last_name' => fake()->lastName(),
            'suffix' => fake()->randomElement(['Jr.', 'Sr.', 'III', null, null, null]),
        ];
    }
}
