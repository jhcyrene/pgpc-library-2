<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\BookData;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition(): array
    {
        return [
            'book_data_id' => BookData::factory(),
            'accession_number' => fake()->unique()->numerify('PGPC-ACC-####'),
            'barcode' => fake()->unique()->numerify('PGPC-BAR-######'),
            'status' => fake()->randomElement(['Available', 'Available', 'Available', 'Borrowed', 'Reserved', 'Damaged']),
            'location' => fake()->randomElement(['Main Library - Shelf A1', 'Main Library - Shelf B2', 'Computer Studies Section', 'General Reference Section']),
            'date_acquired' => fake()->dateTimeBetween('-2 years', 'now'),
            'last_modified' => now(),
        ];
    }
}
