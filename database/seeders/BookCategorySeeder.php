<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BookData;
use App\Models\Category;
use App\Models\BookCategory;

class BookCategorySeeder extends Seeder
{
    public function run(): void
    {
        $books = BookData::all();
        $categories = Category::all();

        foreach ($books as $book) {
            // Pick 1 to 3 random categories
            $selectedCats = $categories->random(rand(1, 3));
            
            foreach ($selectedCats as $cat) {
                BookCategory::firstOrCreate(
                    [
                        'book_data_id' => $book->book_data_id,
                        'category_id' => $cat->category_id,
                    ]
                );
            }
        }
    }
}
