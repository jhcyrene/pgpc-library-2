<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BookData;
use App\Models\Book;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $books = BookData::all();
        $counter = 1;

        foreach ($books as $book) {
            $copies = rand(1, 3);
            
            for ($i = 0; $i < $copies; $i++) {
                $padded = str_pad($counter, 4, '0', STR_PAD_LEFT);
                $bar = str_pad($counter, 6, '0', STR_PAD_LEFT);
                
                Book::firstOrCreate(
                    ['accession_number' => "PGPC-ACC-$padded"],
                    [
                        'book_data_id' => $book->book_data_id,
                        'barcode' => "PGPC-BAR-$bar",
                        'status' => 'Available',
                        'location' => 'Main Library - Shelf ' . chr(rand(65, 70)) . rand(1, 5),
                        'date_acquired' => now()->subDays(rand(10, 500)),
                        'last_modified' => now(),
                    ]
                );
                
                $counter++;
            }
        }
        
        // Mark one random book as Damaged
        $book = Book::inRandomOrder()->first();
        if ($book) {
            $book->status = 'Damaged';
            $book->save();
        }
    }
}
