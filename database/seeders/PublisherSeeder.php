<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Publisher;

class PublisherSeeder extends Seeder
{
    public function run(): void
    {
        $publishers = [
            'Oxford University Press',
            'Pearson Education',
            'McGraw-Hill Education',
            'Cengage Learning',
            'Springer',
            'Wiley',
            'Cambridge University Press',
            'MIT Press',
            'Elsevier',
            'Routledge',
            'O\'Reilly Media',
            'Addison-Wesley',
        ];

        foreach ($publishers as $name) {
            Publisher::firstOrCreate(
                ['publisher_name' => $name],
                [
                    'publication_origin' => 'USA',
                    'publication_type' => 'Academic',
                ]
            );
        }
    }
}
