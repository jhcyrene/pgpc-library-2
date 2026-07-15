<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Member;

class MemberSeeder extends Seeder
{
    public function run(): void
    {
        $members = [
            ['id' => '2024-0001', 'first' => 'Juan', 'last' => 'Dela Cruz', 'program' => 'BSIT', 'year' => '1st Year'],
            ['id' => '2024-0002', 'first' => 'Maria', 'last' => 'Santos', 'program' => 'BSBA', 'year' => '2nd Year'],
            ['id' => '2023-0001', 'first' => 'Pedro', 'last' => 'Reyes', 'program' => 'BSIT', 'year' => '3rd Year'],
            ['id' => '2023-0002', 'first' => 'Ana', 'last' => 'Cruz', 'program' => 'BSED', 'year' => '4th Year'],
            ['id' => '2025-0001', 'first' => 'Jose', 'last' => 'Garcia', 'program' => 'BEED', 'year' => '1st Year'],
            ['id' => '2025-0002', 'first' => 'Luz', 'last' => 'Mendoza', 'program' => 'BSHM', 'year' => '2nd Year'],
            ['id' => '2022-0001', 'first' => 'Miguel', 'last' => 'Aquino', 'program' => 'BSIT', 'year' => '4th Year'],
            ['id' => '2022-0002', 'first' => 'Rosa', 'last' => 'Bautista', 'program' => 'BSBA', 'year' => '3rd Year'],
            ['id' => '2024-0010', 'first' => 'Antonio', 'last' => 'Ocampo', 'program' => 'BSED', 'year' => '2nd Year'],
            ['id' => '2024-0011', 'first' => 'Carmen', 'last' => 'Rosario', 'program' => 'BEED', 'year' => '1st Year'],
        ];

        foreach ($members as $index => $m) {
            Member::firstOrCreate(
                ['student_id_number' => $m['id']],
                [
                    'first_name' => $m['first'],
                    'last_name' => $m['last'],
                    'email' => strtolower($m['first'] . '.' . $m['last'] . '@student.edu.ph'),
                    'contact_num' => '0917' . str_pad($index, 7, '0', STR_PAD_LEFT),
                    'program' => $m['program'],
                    'year_level' => $m['year'],
                    'member_status_id' => 1,
                ]
            );
        }
        
        // Use factory for remaining
        Member::factory()->count(10)->create();
    }
}
