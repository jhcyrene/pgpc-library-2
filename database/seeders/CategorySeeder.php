<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Computer Science',
            'Information Technology',
            'Database Systems',
            'Programming',
            'Networking',
            'Cybersecurity',
            'Mathematics',
            'Science',
            'Literature',
            'History',
            'Mythology',
            'Business',
            'Education',
            'Research',
            'General Reference',
        ];

        foreach ($categories as $name) {
            Category::firstOrCreate(
                ['category_name' => $name]
            );
        }
    }
}
