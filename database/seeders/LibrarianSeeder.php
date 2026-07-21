<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Librarian;

class LibrarianSeeder extends Seeder
{
    public function run(): void
    {
        $librarians = [
            ['emp' => 'EMP-0001', 'first' => 'Admin', 'last' => 'System', 'pos' => 'System Administrator'],
            ['emp' => 'EMP-0002', 'first' => 'Ricardo', 'last' => 'Dalisay', 'pos' => 'Head Librarian'],
            ['emp' => 'EMP-0003', 'first' => 'Gloria', 'last' => 'Macapagal', 'pos' => 'Assistant Librarian'],
            ['emp' => 'EMP-0004', 'first' => 'Fernando', 'last' => 'Poe', 'pos' => 'Library Staff'],
        ];

        foreach ($librarians as $lib) {
            Librarian::firstOrCreate(
                ['employee_number' => $lib['emp']],
                [
                    'first_name' => $lib['first'],
                    'last_name' => $lib['last'],
                    'email' => strtolower($lib['first'] . '@library.edu.ph'),
                    'position' => $lib['pos'],
                ]
            );
        }
    }
}
