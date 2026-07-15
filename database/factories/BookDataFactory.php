<?php

namespace Database\Factories;

use App\Models\BookData;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookDataFactory extends Factory
{
    protected $model = BookData::class;

    public function definition(): array
    {
        return [
            'book_title' => fake()->unique()->sentence(4),
            'subtitle' => fake()->boolean(30) ? fake()->sentence(3) : null,
            'description' => fake()->paragraph(),
            'series_title' => fake()->boolean(20) ? fake()->words(3, true) : null,
            'notes' => fake()->boolean(20) ? fake()->sentence() : null,
            'language' => 'English',
            'copyright_year' => fake()->numberBetween(1990, date('Y')),
            'marc_record' => null,
        ];
    }
}
