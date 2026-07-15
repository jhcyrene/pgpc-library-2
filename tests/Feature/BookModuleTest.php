<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Book;
use App\Models\BookData;
use App\Models\BookDetail;
use App\Models\Category;
use App\Models\Librarian;
use App\Models\MemberAuth;
use App\Models\Publisher;
use App\Services\BookService;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BookModuleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $librarian = Librarian::factory()->create();
        $administrator = MemberAuth::create([
            'librarian_id' => $librarian->librarian_id,
            'username' => 'book_test_admin',
            'password_hash' => Hash::make('password123'),
            'account_type' => 'Administrator',
            'account_status' => 'Active',
        ]);
        $this->actingAs($administrator, 'member');

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
            'isbn' => '9781234567890',
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
            'categories' => [$this->category->category_id],
        ];

        $response = $this->post(route('admin.books.store'), $data);

        $response->assertRedirect(route('admin.books.index'));
        $this->assertDatabaseHas('book_data', ['book_title' => 'Regular Book']);
        $this->assertDatabaseHas('books', ['accession_number' => 'ACC-REG-001']);
        $this->assertDatabaseHas('book_details', ['isbn' => '9780987654321']);
    }

    public function test_regular_add_stores_uploaded_cover_image(): void
    {
        Storage::fake('public');

        $response = $this->post(route('admin.books.store'), [
            'book_title' => 'Book With Cover',
            'accession_number' => 'ACC-COVER-001',
            'cover_image' => UploadedFile::fake()->image('cover.png', 400, 600),
        ]);

        $response->assertRedirect(route('admin.books.index'));

        $bookData = BookData::where('book_title', 'Book With Cover')->firstOrFail();
        $coverPath = $bookData->bookDetail?->cover_image;

        $this->assertNotNull($coverPath);
        $this->assertStringStartsWith('book-covers/', $coverPath);
        Storage::disk('public')->assertExists($coverPath);
    }

    public function test_cover_upload_rejects_non_image_files(): void
    {
        Storage::fake('public');

        $response = $this->post(route('admin.books.store'), [
            'book_title' => 'Invalid Cover Book',
            'accession_number' => 'ACC-COVER-INVALID',
            'cover_image' => UploadedFile::fake()->create('cover.pdf', 100, 'application/pdf'),
        ]);

        $response->assertSessionHasErrors('cover_image');
        $this->assertDatabaseMissing('book_data', ['book_title' => 'Invalid Cover Book']);
    }

    public function test_update_retains_or_replaces_cover_image_safely(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('book-covers/original.png', 'original cover');

        $bookData = BookData::create(['book_title' => 'Editable Cover Book']);
        BookDetail::create([
            'book_data_id' => $bookData->book_data_id,
            'cover_image' => 'book-covers/original.png',
        ]);

        $this->put(route('admin.books.update', $bookData), [
            'book_title' => 'Cover Book Without Replacement',
        ])->assertRedirect(route('admin.books.index'));

        $this->assertSame('book-covers/original.png', $bookData->fresh()->bookDetail?->cover_image);
        Storage::disk('public')->assertExists('book-covers/original.png');

        $this->put(route('admin.books.update', $bookData), [
            'book_title' => 'Cover Book With Replacement',
            'cover_image' => UploadedFile::fake()->image('replacement.jpg', 400, 600),
        ])->assertRedirect(route('admin.books.index'));

        $replacementPath = $bookData->fresh()->bookDetail?->cover_image;

        $this->assertNotNull($replacementPath);
        $this->assertNotSame('book-covers/original.png', $replacementPath);
        Storage::disk('public')->assertMissing('book-covers/original.png');
        Storage::disk('public')->assertExists($replacementPath);
    }

    public function test_deleting_book_removes_its_cover_image(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('book-covers/delete-me.png', 'cover');

        $bookData = BookData::create(['book_title' => 'Book To Delete']);
        BookDetail::create([
            'book_data_id' => $bookData->book_data_id,
            'cover_image' => 'book-covers/delete-me.png',
        ]);

        $this->delete(route('admin.books.destroy', $bookData))
            ->assertRedirect(route('admin.books.index'));

        $this->assertDatabaseMissing('book_data', ['book_data_id' => $bookData->book_data_id]);
        Storage::disk('public')->assertMissing('book-covers/delete-me.png');
    }

    public function test_failed_book_creation_removes_orphaned_cover_image(): void
    {
        Storage::fake('public');

        $existingBookData = BookData::create(['book_title' => 'Existing Book']);
        Book::create([
            'book_data_id' => $existingBookData->book_data_id,
            'accession_number' => 'ACC-ROLLBACK-001',
        ]);

        try {
            app(BookService::class)->createBook([
                'book_title' => 'Rolled Back Book',
                'accession_number' => 'ACC-ROLLBACK-001',
                'cover_image' => UploadedFile::fake()->image('orphan.png', 400, 600),
            ]);

            $this->fail('Creating a duplicate accession number should fail.');
        } catch (QueryException) {
            // The service must roll back the database and remove the already-stored file.
        }

        $this->assertDatabaseMissing('book_data', ['book_title' => 'Rolled Back Book']);
        Storage::disk('public')->assertDirectoryEmpty('book-covers');
    }

    public function test_cannot_create_duplicate_accession_number()
    {
        BookData::create(['book_title' => 'Test Book']);
        Book::create(['book_data_id' => 1, 'accession_number' => 'ACC-DUP-001']);

        $data = [
            'book_title' => 'Another Book',
            'main_author_last_name' => 'Brown',
            'accession_number' => 'ACC-DUP-001',
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
            'status' => 'Available',
        ]);

        $response->assertRedirect(route('admin.books.copies.index', $bookData->book_data_id));
        $this->assertDatabaseHas('books', ['accession_number' => 'ACC-COPY-001', 'book_data_id' => $bookData->book_data_id]);
    }
}
