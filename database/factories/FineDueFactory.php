<?php

namespace Database\Factories;

use App\Models\FineDue;
use App\Models\BookBorrow;
use Illuminate\Database\Eloquent\Factories\Factory;

class FineDueFactory extends Factory
{
    protected $model = FineDue::class;

    public function definition(): array
    {
        return [
            'borrow_id' => BookBorrow::factory(),
            'fine_date' => fake()->dateTimeBetween('-1 month', 'now'),
            'fine_total' => fake()->randomElement([10.00, 25.00, 50.00, 100.00, 250.00]),
            'fine_status' => fake()->randomElement(['Unpaid', 'Partial', 'Paid', 'Waived']),
            'remarks' => fake()->boolean(30) ? fake()->sentence() : null,
        ];
    }
}
