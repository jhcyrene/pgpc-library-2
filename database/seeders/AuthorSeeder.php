<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Author;

class AuthorSeeder extends Seeder
{
    public function run(): void
    {
        $authors = [
            ['first_name' => 'Abraham', 'last_name' => 'Silberschatz'],
            ['first_name' => 'Mark', 'middle_name' => 'P. O.', 'last_name' => 'Morford'],
            ['first_name' => 'Robert', 'middle_name' => 'J.', 'last_name' => 'Lenardon'],
            ['first_name' => 'Thomas', 'middle_name' => 'H.', 'last_name' => 'Cormen'],
            ['first_name' => 'Andrew', 'middle_name' => 'S.', 'last_name' => 'Tanenbaum'],
            ['first_name' => 'Robert', 'middle_name' => 'C.', 'last_name' => 'Martin'],
            ['first_name' => 'David', 'last_name' => 'Thomas'],
            ['first_name' => 'Andrew', 'last_name' => 'Hunt'],
            ['first_name' => 'Stuart', 'last_name' => 'Russell'],
            ['first_name' => 'Peter', 'last_name' => 'Norvig'],
            ['first_name' => 'Ramez', 'last_name' => 'Elmasri'],
            ['first_name' => 'Shamkant', 'middle_name' => 'B.', 'last_name' => 'Navathe'],
            ['first_name' => 'Ian', 'last_name' => 'Sommerville'],
            ['first_name' => 'William', 'last_name' => 'Stallings'],
            ['first_name' => 'Lawrie', 'last_name' => 'Brown'],
            ['first_name' => 'Kenneth', 'middle_name' => 'H.', 'last_name' => 'Rosen'],
            ['first_name' => 'James', 'last_name' => 'Stewart'],
            ['first_name' => 'Teodoro', 'last_name' => 'Agoncillo'],
            ['first_name' => 'Cresencio', 'last_name' => 'Doma', 'suffix' => 'Jr.'],
            ['first_name' => 'Stephen', 'last_name' => 'Robbins'],
        ];

        foreach ($authors as $author) {
            Author::firstOrCreate(
                ['first_name' => $author['first_name'], 'last_name' => $author['last_name']],
                [
                    'middle_name' => $author['middle_name'] ?? null,
                    'suffix' => $author['suffix'] ?? null,
                ]
            );
        }
    }
}
