<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use App\Models\BookData;
use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use App\Models\Author;

class BookModuleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Create base related records if needed
        $this->category = Category::create(['category_name' => 'Fiction']);
        $this->publisher = Publisher::create(['publisher_name' => 'Test Publisher']);
        $this->author = Author::create(['last_name' => 'Doe', 'first_name' => 'John']);
    }

    public function test_book_manager_page_loads()
    {
        $response = $this->get(route('admin.books.index'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.bookManager');
    }

    public function test_add_book_page_loads()
    {
        $response = $this->get(route('admin.books.create'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.addBook');
    }

    public function test_quick_add_page_loads()
    {
        $response = $this->get(route('admin.books.quick-create'));
        $response->assertStatus(200);
        $response->assertViewIs('admin.books.quickAdd');
    }

    public function test_can_create_book_via_quick_add()
    {
        $data = [
            'book_title' => 'Quick Book',
            'main_author_last_name' => 'Smith',
            'accession_number' => 'ACC-QUICK-001',
            'isbn' => '9781234567890'
        ];

        $response = $this->post(route('admin.books.quick-store'), $data);
        
        $response->assertRedirect(route('admin.books.index'));
        $this->assertDatabaseHas('book_data', ['book_title' => 'Quick Book']);
        $this->assertDatabaseHas('books', ['accession_number' => 'ACC-QUICK-001']);
    }

    public function test_can_create_book_via_regular_add()
    {
        $data = [
            'book_title' => 'Regular Book',
            'isbn' => '9780987654321',
            'publication_year' => 2023,
            'accession_number' => 'ACC-REG-001',
            'status' => 'Available',
            'main_author_id' => $this->author->author_id,
            'publisher_id' => $this->publisher->publisher_id,
            'categories' => [$this->category->category_id]
        ];

        $response = $this->post(route('admin.books.store'), $data);

        $response->assertRedirect(route('admin.books.index'));
        $this->assertDatabaseHas('book_data', ['book_title' => 'Regular Book']);
        $this->assertDatabaseHas('books', ['accession_number' => 'ACC-REG-001']);
        $this->assertDatabaseHas('book_details', ['isbn' => '9780987654321']);
    }

    public function test_cannot_create_duplicate_accession_number()
    {
        BookData::create(['book_title' => 'Test Book']);
        Book::create(['book_data_id' => 1, 'accession_number' => 'ACC-DUP-001']);

        $data = [
            'book_title' => 'Another Book',
            'main_author_last_name' => 'Brown',
            'accession_number' => 'ACC-DUP-001'
        ];

        $response = $this->post(route('admin.books.quick-store'), $data);
        
        // Should have validation error for accession_number
        $response->assertSessionHasErrors('accession_number');
    }

    public function test_can_add_copy_to_existing_book()
    {
        $bookData = BookData::create(['book_title' => 'Test Book for Copy']);

        $response = $this->post(route('admin.books.copies.store', $bookData->book_data_id), [
            'accession_number' => 'ACC-COPY-001',
            'status' => 'Available'
        ]);

        $response->assertRedirect(route('admin.books.copies.index', $bookData->book_data_id));
        $this->assertDatabaseHas('books', ['accession_number' => 'ACC-COPY-001', 'book_data_id' => $bookData->book_data_id]);
    }
}
