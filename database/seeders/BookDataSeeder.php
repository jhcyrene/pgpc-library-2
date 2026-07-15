<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BookData;

class BookDataSeeder extends Seeder
{
    public function run(): void
    {
        $titles = [
            'Classical Mythology',
            'Database System Concepts',
            'Introduction to Algorithms',
            'Computer Networks',
            'Operating System Concepts',
            'Clean Code',
            'The Pragmatic Programmer',
            'Artificial Intelligence: A Modern Approach',
            'Data Structures and Algorithms',
            'Web Development with Laravel',
            'Fundamentals of Database Systems',
            'Software Engineering',
            'Computer Security Principles and Practice',
            'Discrete Mathematics and Its Applications',
            'College Algebra',
            'Philippine History',
            'Research Methods in Information Technology',
            'Principles of Management',
            'English for Academic Purposes',
            'Introduction to Information Systems',
        ];

        foreach ($titles as $index => $title) {
            BookData::firstOrCreate(
                ['book_title' => $title],
                [
                    'language' => 'English',
                    'copyright_year' => 2000 + $index,
                ]
            );
        }
    }
}
