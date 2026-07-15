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
        // Map book titles to their actual authors (by last name)
        $bookAuthorMap = [
            'Classical Mythology'                          => [['last_name' => 'Morford'], ['last_name' => 'Lenardon']],
            'Database System Concepts'                     => [['last_name' => 'Silberschatz']],
            'Introduction to Algorithms'                   => [['last_name' => 'Cormen']],
            'Computer Networks'                            => [['last_name' => 'Tanenbaum']],
            'Operating System Concepts'                    => [['last_name' => 'Silberschatz']],
            'Clean Code'                                   => [['last_name' => 'Martin']],
            'The Pragmatic Programmer'                     => [['last_name' => 'Hunt'], ['last_name' => 'Thomas']],
            'Artificial Intelligence: A Modern Approach'   => [['last_name' => 'Russell'], ['last_name' => 'Norvig']],
            'Data Structures and Algorithms'               => [['last_name' => 'Cormen']],
            'Web Development with Laravel'                 => [['last_name' => 'Thomas']],
            'Fundamentals of Database Systems'             => [['last_name' => 'Elmasri'], ['last_name' => 'Navathe']],
            'Software Engineering'                         => [['last_name' => 'Sommerville']],
            'Computer Security Principles and Practice'    => [['last_name' => 'Stallings'], ['last_name' => 'Brown']],
            'Discrete Mathematics and Its Applications'    => [['last_name' => 'Rosen']],
            'College Algebra'                              => [['last_name' => 'Stewart']],
            'Philippine History'                           => [['last_name' => 'Agoncillo']],
            'Research Methods in Information Technology'    => [['last_name' => 'Doma']],
            'Principles of Management'                     => [['last_name' => 'Robbins']],
            'English for Academic Purposes'                => [['last_name' => 'Sommerville']],
            'Introduction to Information Systems'          => [['last_name' => 'Stallings']],
        ];

        foreach ($bookAuthorMap as $title => $authors) {
            $book = BookData::where('book_title', $title)->first();
            if (!$book) continue;

            foreach ($authors as $index => $authorMatch) {
                $author = Author::where('last_name', $authorMatch['last_name'])->first();
                if (!$author) continue;

                $role = $index === 0 ? 'Main Author' : 'Additional Author';

                BookAuthor::firstOrCreate([
                    'book_data_id' => $book->book_data_id,
                    'author_id' => $author->author_id,
                    'role' => $role,
                ]);
            }
        }
    }
}
