<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PublisherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $publishers = [
            ['publisher_name' => 'O\'Reilly Media'],
            ['publisher_name' => 'Addison-Wesley Professional'],
            ['publisher_name' => 'Packt Publishing'],
            ['publisher_name' => 'Apress'],
            ['publisher_name' => 'Manning Publications'],
            ['publisher_name' => 'No Starch Press'],
            ['publisher_name' => 'Prentice Hall'],
            ['publisher_name' => 'Wiley'],
            ['publisher_name' => 'Springer'],
            ['publisher_name' => 'Cambridge University Press'],
        ];

        foreach ($publishers as $publisher) {
            \App\Models\Publisher::create($publisher);
        }
    }
}
