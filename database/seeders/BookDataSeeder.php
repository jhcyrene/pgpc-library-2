<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookDataSeeder extends Seeder
{
    use WithoutModelEvents;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = [
            [
                'call_number' => 'QA76.73.P98',
                'isbn' => '9780134190440',
                'book_title' => 'Learning Python',
                'author' => 'Mark Lutz',
                'publisher_id' => 1,
                'publication_year' => 2013,
                'edition' => '5th Edition',
                'description' => 'Comprehensive, in-depth introduction to the core Python language.',
                'cover_image' => null,
                'copies_total' => 5,
                'copies_available' => 5,
            ],
            [
                'call_number' => 'TK5105.888',
                'isbn' => '9780132350884',
                'book_title' => 'Clean Code: A Handbook of Agile Software Craftsmanship',
                'author' => 'Robert C. Martin',
                'publisher_id' => 2,
                'publication_year' => 2008,
                'edition' => null,
                'description' => "Even bad code can function. But if code isn't clean, it can bring a development organization to its knees.",
                'cover_image' => null,
                'copies_total' => 3,
                'copies_available' => 3,
            ],
            [
                'call_number' => 'QA76.73.J38',
                'isbn' => '374157065',
                'book_title' => 'Effective Java',
                'author' => 'Joshua Bloch',
                'publisher_id' => 3,
                'publication_year' => 2018,
                'edition' => '3rd Edition',
                'description' => "The Definitive Guide to Java Platform Best Practices—Updated for Java 7, 8, and 9.",
                'cover_image' => null,
                'copies_total' => 4,
                'copies_available' => 4,
            ],
[
                'call_number' => 'TBD-19515344',
                'isbn' => '19515344',
                'book_title' => 'Classical Mythology',
                'author' => 'Mark P. O. Morford',
                'publisher_id' => 1, // Placeholder for Oxford University Press
                'publication_year' => 2002,
                'edition' => null,
                'description' => null,
                'cover_image' => 'http://images.amazon.com/images/P/0195153448.01.THUMBZZZ.jpg',
                'copies_total' => 2,
                'copies_available' => 2,
            ],
            [
                'call_number' => 'TBD-2005018',
                'isbn' => '2005018',
                'book_title' => 'Clara Callan',
                'author' => 'Richard Bruce Wright',
                'publisher_id' => 1, // Placeholder for HarperFlamingo Canada
                'publication_year' => 2001,
                'edition' => null,
                'description' => null,
                'cover_image' => 'http://images.amazon.com/images/P/0002005018.01.THUMBZZZ.jpg',
                'copies_total' => 2,
                'copies_available' => 2,
            ],
            [
                'call_number' => 'TBD-60973129',
                'isbn' => '60973129',
                'book_title' => 'Decision in Normandy',
                'author' => "Carlo D'Este",
                'publisher_id' => 1, // Placeholder for HarperPerennial
                'publication_year' => 1991,
                'edition' => null,
                'description' => null,
                'cover_image' => 'http://images.amazon.com/images/P/0060973129.01.THUMBZZZ.jpg',
                'copies_total' => 2,
                'copies_available' => 2,
            ],
            [
                'call_number' => 'TBD-374157065',
                'isbn' => '374157065',
                'book_title' => 'Flu: The Story of the Great Influenza Pandemic of 1918 and the Search for the Virus That Caused It',
                'author' => 'Gina Bari Kolata',
                'publisher_id' => 1, // Placeholder for Farrar Straus Giroux
                'publication_year' => 1999,
                'edition' => null,
                'description' => null,
                'cover_image' => 'http://images.amazon.com/images/P/0374157065.01.THUMBZZZ.jpg',
                'copies_total' => 2,
                'copies_available' => 2,
            ],
            [
                'call_number' => 'TBD-393045218',
                'isbn' => '393045218',
                'book_title' => 'The Mummies of Urumchi',
                'author' => 'E. J. W. Barber',
                'publisher_id' => 1, // Placeholder for W. W. Norton & Company
                'publication_year' => 1999,
                'edition' => null,
                'description' => null,
                'cover_image' => 'http://images.amazon.com/images/P/0393045218.01.THUMBZZZ.jpg',
                'copies_total' => 2,
                'copies_available' => 2,
            ],
            [
                'call_number' => 'TBD-399135782',
                'isbn' => '399135782',
                'book_title' => "The Kitchen God's Wife",
                'author' => 'Amy Tan',
                'publisher_id' => 1, // Placeholder for Putnam Pub Group
                'publication_year' => 1991,
                'edition' => null,
                'description' => null,
                'cover_image' => 'http://images.amazon.com/images/P/0399135782.01.THUMBZZZ.jpg',
                'copies_total' => 2,
                'copies_available' => 2,
            ],
            [
                'call_number' => 'TBD-425176428',
                'isbn' => '425176428',
                'book_title' => "What If?: The World's Foremost Military Historians Imagine What Might Have Been",
                'author' => 'Robert Cowley',
                'publisher_id' => 1, // Placeholder for Berkley Publishing Group
                'publication_year' => 2000,
                'edition' => null,
                'description' => null,
                'cover_image' => 'http://images.amazon.com/images/P/0425176428.01.THUMBZZZ.jpg',
                'copies_total' => 2,
                'copies_available' => 2,
            ],
            [
                'call_number' => 'TBD-671870432',
                'isbn' => '671870432',
                'book_title' => 'PLEADING GUILTY',
                'author' => 'Scott Turow',
                'publisher_id' => 1, // Placeholder for Audioworks
                'publication_year' => 1993,
                'edition' => null,
                'description' => null,
                'cover_image' => 'http://images.amazon.com/images/P/0671870432.01.THUMBZZZ.jpg',
                'copies_total' => 2,
                'copies_available' => 2,
            ],
            [
                'call_number' => 'TBD-679425608',
                'isbn' => '679425608',
                'book_title' => 'Under the Black Flag: The Romance and the Reality of Life Among the Pirates',
                'author' => 'David Cordingly',
                'publisher_id' => 1, // Placeholder for Random House
                'publication_year' => 1996,
                'edition' => null,
                'description' => null,
                'cover_image' => 'http://images.amazon.com/images/P/0679425608.01.THUMBZZZ.jpg',
                'copies_total' => 2,
                'copies_available' => 2,
            ],
            [
                'call_number' => 'TBD-074322678X',
                'isbn' => '074322678X',
                'book_title' => "Where You'll Find Me: And Other Stories",
                'author' => 'Ann Beattie',
                'publisher_id' => 1, // Placeholder for Scribner
                'publication_year' => 2002,
                'edition' => null,
                'description' => null,
                'cover_image' => 'http://images.amazon.com/images/P/074322678X.01.THUMBZZZ.jpg',
                'copies_total' => 2,
                'copies_available' => 2,
            ]

        ];

        DB::table('book_data')->insert($books);
    }
}

