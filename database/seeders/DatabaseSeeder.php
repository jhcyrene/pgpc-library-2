<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AuthorSeeder::class,
            PublisherSeeder::class,
            CategorySeeder::class,
            MemberSeeder::class,
            LibrarianSeeder::class,
            BookDataSeeder::class,
            BookDetailSeeder::class,
            BookAuthorSeeder::class,
            BookCategorySeeder::class,
            BookSeeder::class,
            MemberAuthSeeder::class,
            BookRequestStatusSeeder::class,
            BookRequestSeeder::class,
            BookBorrowSeeder::class,
            FineDueSeeder::class,
            FinePaymentSeeder::class,
        ]);
    }
}
