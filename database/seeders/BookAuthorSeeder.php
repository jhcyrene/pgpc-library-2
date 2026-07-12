<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BookData;
use App\Models\Author;
use App\Models\BookAuthor;

class BookAuthorSeeder extends Seeder
{
    public function run(): void
    {
        $books = BookData::all();
        $authors = Author::all();

        foreach ($books as $book) {
            // Pick 1 to 2 random authors for each book
            $selectedAuthors = $authors->random(rand(1, 2));
            
            foreach ($selectedAuthors as $index => $author) {
                $role = $index === 0 ? 'Main Author' : 'Additional Author';
                
                BookAuthor::firstOrCreate(
                    [
                        'book_data_id' => $book->book_data_id,
                        'author_id' => $author->author_id,
                        'role' => $role,
                    ]
                );
            }
        }
    }
}
