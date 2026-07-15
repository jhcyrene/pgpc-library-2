<?php

namespace App\Services;

use App\Models\Author;
use App\Models\Book;
use App\Models\BookData;
use App\Models\BookDetail;
use App\Models\Category;
use App\Models\Publisher;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use RuntimeException;
use Throwable;

class BookService
{
    /**
     * Create a complete book record inside a transaction.
     */
    public function createBook(array $data): BookData
    {
        $storedCoverImage = isset($data['cover_image']) && $data['cover_image'] instanceof UploadedFile
            ? $this->storeCoverImage($data['cover_image'])
            : null;

        try {
            return DB::transaction(function () use ($data, $storedCoverImage) {
                // 1. Create BookData
                $bookData = BookData::create([
                    'book_title' => $data['book_title'],
                    'subtitle' => $data['subtitle'] ?? null,
                    'description' => $data['description'] ?? null,
                    'series_title' => $data['series_title'] ?? null,
                    'notes' => $data['notes'] ?? null,
                    'language' => $data['language'] ?? 'English',
                    'copyright_year' => $data['copyright_year'] ?? null,
                    'marc_record' => $data['marc_record'] ?? null,
                ]);

                // 2. Handle Publisher (Find or Create)
                $publisherId = null;
                if (! empty($data['publisher'])) {
                    $publisher = Publisher::firstOrCreate(
                        ['publisher_name' => trim($data['publisher'])]
                    );
                    $publisherId = $publisher->publisher_id;
                } elseif (! empty($data['publisher_id'])) {
                    $publisherId = $data['publisher_id'];
                }

                // 3. Create BookDetail
                BookDetail::create([
                    'book_data_id' => $bookData->book_data_id,
                    'isbn' => $data['isbn'] ?? null,
                    'issn' => $data['issn'] ?? null,
                    'publisher_id' => $publisherId,
                    'publication_year' => $data['publication_year'] ?? null,
                    'edition' => $data['edition'] ?? null,
                    'pages' => $data['pages'] ?? null,
                    'call_number' => $data['call_number'] ?? null,
                    'classification' => $data['classification'] ?? null,
                    'book_type' => $data['book_type'] ?? 'Book',
                    'format' => $data['format'] ?? 'Print',
                    'cover_image' => $storedCoverImage,
                ]);

                // 4. Handle Authors
                $authorsToAttach = [];

                // Main Author
                if (! empty($data['main_author_last_name'])) {
                    $mainAuthor = Author::firstOrCreate(
                        ['last_name' => trim($data['main_author_last_name']), 'first_name' => trim($data['main_author_first_name'] ?? '')]
                    );
                    $authorsToAttach[$mainAuthor->author_id] = ['role' => 'Author'];
                } elseif (! empty($data['main_author_id'])) {
                    $authorsToAttach[$data['main_author_id']] = ['role' => 'Author'];
                }

                // Additional Authors (if any)
                if (! empty($data['additional_authors'])) {
                    foreach ($data['additional_authors'] as $addAuthor) {
                        if (! empty($addAuthor['author_id'])) {
                            $authorsToAttach[$addAuthor['author_id']] = ['role' => $addAuthor['role'] ?? 'Author'];
                        } elseif (! empty($addAuthor['last_name'])) {
                            $author = Author::firstOrCreate(
                                ['last_name' => trim($addAuthor['last_name']), 'first_name' => trim($addAuthor['first_name'] ?? '')]
                            );
                            $authorsToAttach[$author->author_id] = ['role' => $addAuthor['role'] ?? 'Author'];
                        }
                    }
                }

                if (! empty($authorsToAttach)) {
                    $bookData->authors()->attach($authorsToAttach);
                }

                // 5. Handle Categories
                $categoriesToAttach = [];
                if (! empty($data['categories'])) {
                    foreach ($data['categories'] as $catId) {
                        $categoriesToAttach[] = $catId;
                    }
                }
                if (! empty($data['new_categories'])) {
                    foreach ($data['new_categories'] as $newCatName) {
                        $category = Category::firstOrCreate(['category_name' => trim($newCatName)]);
                        $categoriesToAttach[] = $category->category_id;
                    }
                }

                if (! empty($categoriesToAttach)) {
                    $bookData->categories()->attach($categoriesToAttach);
                }

                // 6. Create Initial Physical Copy
                if (! empty($data['accession_number'])) {
                    Book::create([
                        'book_data_id' => $bookData->book_data_id,
                        'accession_number' => $data['accession_number'],
                        'barcode' => $data['barcode'] ?? null,
                        'status' => $data['status'] ?? 'Available',
                        'location' => $data['location'] ?? null,
                        'date_acquired' => $data['date_acquired'] ?? now()->toDateString(),
                    ]);
                }

                return $bookData;
            });
        } catch (Throwable $exception) {
            $this->deleteCoverImage($storedCoverImage);

            throw $exception;
        }
    }

    /**
     * Update a complete book record inside a transaction.
     */
    public function updateBook(BookData $bookData, array $data): BookData
    {
        $oldCoverImage = $bookData->bookDetail?->cover_image;
        $storedCoverImage = isset($data['cover_image']) && $data['cover_image'] instanceof UploadedFile
            ? $this->storeCoverImage($data['cover_image'])
            : null;

        try {
            $updatedBook = DB::transaction(function () use ($bookData, $data, $storedCoverImage) {
                // 1. Update BookData
                $bookData->update([
                    'book_title' => $data['book_title'],
                    'subtitle' => $data['subtitle'] ?? null,
                    'description' => $data['description'] ?? null,
                    'series_title' => $data['series_title'] ?? null,
                    'notes' => $data['notes'] ?? null,
                    'language' => $data['language'] ?? 'English',
                    'copyright_year' => $data['copyright_year'] ?? null,
                ]);

                // 2. Handle Publisher
                $publisherId = null;
                if (! empty($data['publisher'])) {
                    $publisher = Publisher::firstOrCreate(
                        ['publisher_name' => trim($data['publisher'])]
                    );
                    $publisherId = $publisher->publisher_id;
                } elseif (! empty($data['publisher_id'])) {
                    $publisherId = $data['publisher_id'];
                }

                // 3. Update BookDetail
                $detailData = [
                    'isbn' => $data['isbn'] ?? null,
                    'issn' => $data['issn'] ?? null,
                    'publisher_id' => $publisherId,
                    'publication_year' => $data['publication_year'] ?? null,
                    'edition' => $data['edition'] ?? null,
                    'pages' => $data['pages'] ?? null,
                    'call_number' => $data['call_number'] ?? null,
                    'classification' => $data['classification'] ?? null,
                    'book_type' => $data['book_type'] ?? 'Book',
                    'format' => $data['format'] ?? 'Print',
                ];

                if ($storedCoverImage !== null) {
                    $detailData['cover_image'] = $storedCoverImage;
                }

                $bookData->bookDetail()->updateOrCreate(
                    ['book_data_id' => $bookData->book_data_id],
                    $detailData,
                );

                // 4. Handle Main Author (Simplify: Replace existing authors with the main author)
                $authorsToAttach = [];
                if (! empty($data['main_author_last_name'])) {
                    $mainAuthor = Author::firstOrCreate(
                        ['last_name' => trim($data['main_author_last_name']), 'first_name' => trim($data['main_author_first_name'] ?? '')]
                    );
                    $authorsToAttach[$mainAuthor->author_id] = ['role' => 'Author'];
                } elseif (! empty($data['main_author_id'])) {
                    $authorsToAttach[$data['main_author_id']] = ['role' => 'Author'];
                }

                if (! empty($authorsToAttach)) {
                    $bookData->authors()->sync($authorsToAttach);
                }

                // 5. Handle Categories
                $categoriesToAttach = [];
                if (! empty($data['categories'])) {
                    foreach ($data['categories'] as $catId) {
                        $categoriesToAttach[] = $catId;
                    }
                }
                if (! empty($data['new_categories'])) {
                    foreach ($data['new_categories'] as $newCatName) {
                        $category = Category::firstOrCreate(['category_name' => trim($newCatName)]);
                        $categoriesToAttach[] = $category->category_id;
                    }
                }

                $bookData->categories()->sync($categoriesToAttach);

                return $bookData;
            });
        } catch (Throwable $exception) {
            $this->deleteCoverImage($storedCoverImage);

            throw $exception;
        }

        if ($storedCoverImage !== null && $oldCoverImage !== $storedCoverImage) {
            $this->deleteCoverImage($oldCoverImage);
        }

        return $updatedBook;
    }

    /**
     * Check if a book title/author combination or ISBN already exists.
     */
    public function checkDuplicate(array $data): ?BookData
    {
        // 1. Check by ISBN
        if (! empty($data['isbn'])) {
            $existingByIsbn = BookData::whereHas('bookDetail', function ($q) use ($data) {
                $q->where('isbn', $data['isbn']);
            })->first();

            if ($existingByIsbn) {
                return $existingByIsbn;
            }
        }

        // 2. Check by Title & Publication Year
        if (! empty($data['book_title']) && ! empty($data['publication_year'])) {
            $existingByTitle = BookData::where('book_title', trim($data['book_title']))
                ->whereHas('bookDetail', function ($q) use ($data) {
                    $q->where('publication_year', $data['publication_year']);
                })->first();

            if ($existingByTitle) {
                return $existingByTitle;
            }
        }

        return null;
    }

    /**
     * Delete a book safely if it has no active borrows.
     */
    public function deleteBook(BookData $bookData): bool
    {
        // Check for active borrows on any copy
        $hasActiveBorrows = $bookData->books()->where('status', 'Borrowed')->exists();

        if ($hasActiveBorrows) {
            return false;
        }

        $coverImage = $bookData->bookDetail?->cover_image;

        DB::transaction(function () use ($bookData) {
            $bookData->books()->delete();
            $bookData->bookDetail()->delete();
            $bookData->authors()->detach();
            $bookData->categories()->detach();
            $bookData->delete();
        });

        $this->deleteCoverImage($coverImage);

        return true;
    }

    private function storeCoverImage(UploadedFile $coverImage): string
    {
        $mime = $coverImage->getClientMimeType();
        $base64 = base64_encode($coverImage->get());

        return "data:{$mime};base64,{$base64}";
    }

    private function deleteCoverImage(?string $path): void
    {
        // No-op: cover image is now stored as base64 in the database.
    }
}
