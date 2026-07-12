<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BookBorrow;
use App\Models\Book;
use App\Models\Member;
use App\Models\Librarian;

class BookBorrowSeeder extends Seeder
{
    public function run(): void
    {
        $members = Member::all();
        $librarians = Librarian::all();
        
        // 1. Returned records
        for ($i = 0; $i < 5; $i++) {
            $book = Book::where('status', 'Available')->inRandomOrder()->first();
            if ($book) {
                $issue = now()->subDays(rand(10, 30));
                BookBorrow::create([
                    'book_id' => $book->book_id,
                    'member_id' => $members->random()->member_id,
                    'librarian_id' => $librarians->random()->librarian_id,
                    'issue_date' => $issue,
                    'due_date' => (clone $issue)->modify('+7 days'),
                    'return_date' => (clone $issue)->modify('+' . rand(1, 6) . ' days'),
                    'status' => 'Returned',
                ]);
            }
        }
        
        // 2. Active Borrowed records
        for ($i = 0; $i < 5; $i++) {
            $book = Book::where('status', 'Available')->inRandomOrder()->first();
            if ($book) {
                $issue = now()->subDays(rand(1, 6));
                BookBorrow::create([
                    'book_id' => $book->book_id,
                    'member_id' => $members->random()->member_id,
                    'librarian_id' => $librarians->random()->librarian_id,
                    'issue_date' => $issue,
                    'due_date' => (clone $issue)->modify('+7 days'),
                    'return_date' => null,
                    'status' => 'Borrowed',
                ]);
                
                $book->status = 'Borrowed';
                $book->save();
            }
        }
        
        // 3. Overdue records
        for ($i = 0; $i < 3; $i++) {
            $book = Book::where('status', 'Available')->inRandomOrder()->first();
            if ($book) {
                $issue = now()->subDays(rand(15, 30));
                BookBorrow::create([
                    'book_id' => $book->book_id,
                    'member_id' => $members->random()->member_id,
                    'librarian_id' => $librarians->random()->librarian_id,
                    'issue_date' => $issue,
                    'due_date' => (clone $issue)->modify('+7 days'),
                    'return_date' => null,
                    'status' => 'Overdue',
                ]);
                
                $book->status = 'Borrowed';
                $book->save();
            }
        }
    }
}
