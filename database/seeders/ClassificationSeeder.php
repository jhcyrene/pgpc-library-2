<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Classification;

class ClassificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $classes = [
        //     ['letter' => 'A', 'definition' => 'General Works'],
        //     ['letter' => 'B', 'definition' => 'Philosophy, Psychology, and Religion'],
        //     ['letter' => 'C', 'definition' => 'Auxiliary Sciences of History'],
        //     ['letter' => 'D', 'definition' => 'World History (except American History)'],
        //     ['letter' => 'E', 'definition' => 'History of the Americas (General)'],
        //     ['letter' => 'F', 'definition' => 'History of the Americas (Local)'],
        //     ['letter' => 'G', 'definition' => 'Geography, Anthropology, and Recreation'],
        //     ['letter' => 'H', 'definition' => 'Social Sciences'],
        //     ['letter' => 'J', 'definition' => 'Political Science'],
        //     ['letter' => 'K', 'definition' => 'Law'],
        //     ['letter' => 'L', 'definition' => 'Education'],
        //     ['letter' => 'M', 'definition' => 'Music'],
        //     ['letter' => 'N', 'definition' => 'Fine Arts'],
        //     ['letter' => 'P', 'definition' => 'Language and Literature'],
        //     ['letter' => 'Q', 'definition' => 'Science (Including Mathematics & Computer Science)'],
        //     ['letter' => 'R', 'definition' => 'Medicine'],
        //     ['letter' => 'S', 'definition' => 'Agriculture'],
        //     ['letter' => 'T', 'definition' => 'Technology and Engineering'],
        //     ['letter' => 'U', 'definition' => 'Military Science'],
        //     ['letter' => 'V', 'definition' => 'Naval Science'],
        //     ['letter' => 'Z', 'definition' => 'Bibliography and Library Science'],

        //     // --- Highly Relevant Subclasses for IT & Engineering ---
        //     ['letter' => 'QA', 'definition' => 'Mathematics and Computer Science'],
        //     ['letter' => 'TA', 'definition' => 'Civil Engineering'],
        //     ['letter' => 'TK', 'definition' => 'Electrical Engineering and Electronics'],
        //     ['letter' => 'TP', 'definition' => 'Chemical Technology'],


        //     // --- Relevant Subclasses for Service Management / Business ---
        //     ['letter' => 'HF', 'definition' => 'Commerce and Business Administration'],
        //     ['letter' => 'HG', 'definition' => 'Finance'],
        //     ['letter' => 'HD', 'definition' => 'Industries, Land use, Labor'],

        //     // --- Philippine Specific ---
        //     ['letter' => 'KPM', 'definition' => 'Law of the Philippines'],
        //     ['letter' => 'DS',  'definition' => 'History of Asia'],
        //     ['letter' => 'DS501-DS899', 'definition' => 'History of the Philippines'],



        //     ];

        // foreach ($classes as $class) {
        //     Classification::updateOrCreate(['letter' => $class['letter']], $class);
        // }
    }
}
