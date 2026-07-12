<?php

namespace Database\Factories;

use App\Models\BookBorrow;
use App\Models\Book;
use App\Models\Member;
use App\Models\Librarian;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookBorrowFactory extends Factory
{
    protected $model = BookBorrow::class;

    public function definition(): array
    {
        $issueDate = fake()->dateTimeBetween('-1 month', 'now');
        $dueDate = (clone $issueDate)->modify('+7 days');
        $status = fake()->randomElement(['Borrowed', 'Returned', 'Overdue']);
        
        $returnDate = null;
        if ($status === 'Returned') {
            $returnDate = fake()->dateTimeBetween($issueDate, 'now');
        }

        return [
            'book_id' => Book::factory(),
            'member_id' => Member::factory(),
            'librarian_id' => Librarian::inRandomOrder()->first()->librarian_id ?? Librarian::factory(),
            'issue_date' => $issueDate,
            'due_date' => $dueDate,
            'return_date' => $returnDate,
            'status' => $status,
        ];
    }
}
