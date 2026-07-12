<?php

namespace Database\Factories;

use App\Models\BookRequest;
use App\Models\BookData;
use App\Models\Book;
use App\Models\Member;
use App\Models\BookRequestStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookRequestFactory extends Factory
{
    protected $model = BookRequest::class;

    public function definition(): array
    {
        $requestDate = fake()->dateTimeBetween('-1 month', 'now');
        $statusId = BookRequestStatus::inRandomOrder()->first()->book_request_status_id ?? 1;

        return [
            'book_data_id' => BookData::factory(),
            'book_id' => fake()->boolean(30) ? Book::factory() : null,
            'member_id' => Member::factory(),
            'book_request_status_id' => $statusId,
            'request_date' => $requestDate,
            'approved_at' => fake()->boolean(50) ? fake()->dateTimeBetween($requestDate, 'now') : null,
            'ready_at' => null,
            'fulfilled_at' => null,
            'cancelled_at' => null,
            'expires_at' => (clone $requestDate)->modify('+3 days'),
            'remarks' => null,
        ];
    }
}
