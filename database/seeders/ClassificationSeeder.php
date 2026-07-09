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
        $classes = [
            ['letter' => 'QA', 'definition' => 'Mathematics / Computer Science'],
            ['letter' => 'PZ', 'definition' => 'Fiction and Juvenile Belles Lettres'],
            ['letter' => 'KPM', 'definition' => 'Law of the Philippines'],
            ['letter' => 'Z',  'definition' => 'Bibliography, Library Science'],
            // Add more as needed by Padre Garcia Polytechnic College
        ];

        foreach ($classes as $class) {
            Classification::updateOrCreate(['letter' => $class['letter']], $class);
        }
    }
}
