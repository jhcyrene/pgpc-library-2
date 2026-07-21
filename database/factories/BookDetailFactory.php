<?php

namespace Database\Factories;

use App\Models\BookDetail;
use App\Models\BookData;
use App\Models\Publisher;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookDetailFactory extends Factory
{
    protected $model = BookDetail::class;

    public function definition(): array
    {
        $classifications = ['QA76.9.D3', 'QA76.73.P224', 'QA76.76.O63', 'QA76.9.A25', 'BF76.5', 'HD31'];
        $baseClass = fake()->randomElement($classifications);
        $cutter = fake()->bothify('?##');
        $year = fake()->numberBetween(1990, date('Y'));

        return [
            'book_data_id' => BookData::factory(),
            'isbn' => fake()->unique()->isbn13(),
            'issn' => null,
            'publisher_id' => Publisher::inRandomOrder()->first()->publisher_id ?? Publisher::factory(),
            'publication_year' => $year,
            'edition' => fake()->randomElement(['1st', '2nd', '3rd', 'Revised']),
            'pages' => fake()->numberBetween(100, 1000) . ' p.',
            'call_number' => "$baseClass $cutter $year",
            'classification' => $baseClass,
            'book_type' => fake()->randomElement(['Circulation', 'Reference', 'Textbook']),
            'format' => fake()->randomElement(['Print', 'Print', 'Print', 'E-book']),
            'cover_image' => null,
        ];
    }
}
