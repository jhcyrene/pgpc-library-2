<?php

namespace Database\Factories;

use App\Models\Librarian;
use Illuminate\Database\Eloquent\Factories\Factory;

class LibrarianFactory extends Factory
{
    protected $model = Librarian::class;

    public function definition(): array
    {
        return [
            'employee_number' => fake()->unique()->numerify('EMP-####'),
            'first_name' => fake()->firstName(),
            'middle_name' => fake()->randomElement([fake()->lastName(), null]),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'position' => fake()->randomElement(['Librarian', 'Assistant Librarian', 'Library Staff']),
        ];
    }
}
