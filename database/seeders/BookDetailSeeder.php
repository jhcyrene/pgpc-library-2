<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BookDetail;
use App\Models\BookData;
use App\Models\Publisher;

class BookDetailSeeder extends Seeder
{
    public function run(): void
    {
        $books = BookData::all();
        $publishers = Publisher::all();
        
        $classifications = [
            'Classical Mythology' => 'BL722',
            'Database System Concepts' => 'QA76.9.D3',
            'Introduction to Algorithms' => 'QA76.6',
            'Computer Networks' => 'TK5105.5',
            'Operating System Concepts' => 'QA76.76.O63',
            'Clean Code' => 'QA76.73.P224',
            'The Pragmatic Programmer' => 'QA76.6',
            'Artificial Intelligence: A Modern Approach' => 'Q335',
            'Data Structures and Algorithms' => 'QA76.9.D35',
            'Web Development with Laravel' => 'QA76.625',
            'Fundamentals of Database Systems' => 'QA76.9.D3',
            'Software Engineering' => 'QA76.758',
            'Computer Security Principles and Practice' => 'QA76.9.A25',
            'Discrete Mathematics and Its Applications' => 'QA39.3',
            'College Algebra' => 'QA154.3',
            'Philippine History' => 'DS668',
            'Research Methods in Information Technology' => 'ZA3075',
            'Principles of Management' => 'HD31',
            'English for Academic Purposes' => 'PE1128.A2',
            'Introduction to Information Systems' => 'T58.6',
        ];

        foreach ($books as $index => $book) {
            $class = $classifications[$book->book_title] ?? 'QA76';
            $pub = $publishers->random();
            $year = $book->copyright_year;
            $cutter = chr(rand(65, 90)) . rand(10, 99);

            BookDetail::firstOrCreate(
                ['book_data_id' => $book->book_data_id],
                [
                    'isbn' => '978-' . rand(1000000000, 9999999999),
                    'publisher_id' => $pub->publisher_id,
                    'publication_year' => $year,
                    'edition' => '1st',
                    'pages' => rand(200, 800) . ' p.',
                    'call_number' => "$class $cutter $year",
                    'classification' => $class,
                    'book_type' => 'Circulation',
                    'format' => 'Print',
                ]
            );
        }
    }
}
