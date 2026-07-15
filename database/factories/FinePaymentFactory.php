<?php

namespace Database\Factories;

use App\Models\FinePayment;
use App\Models\FineDue;
use App\Models\Librarian;
use Illuminate\Database\Eloquent\Factories\Factory;

class FinePaymentFactory extends Factory
{
    protected $model = FinePayment::class;

    public function definition(): array
    {
        return [
            'fine_id' => FineDue::factory(),
            'payment_date' => fake()->dateTimeBetween('-1 month', 'now'),
            'payment_amount' => fake()->randomElement([10.00, 25.00, 50.00]),
            'payment_method' => fake()->randomElement(['Cash', 'GCash', 'Bank Transfer']),
            'official_receipt_no' => fake()->unique()->numerify('OR-######'),
            'received_by' => Librarian::inRandomOrder()->first()->librarian_id ?? Librarian::factory(),
            'remarks' => fake()->boolean(20) ? fake()->sentence() : null,
        ];
    }
}
