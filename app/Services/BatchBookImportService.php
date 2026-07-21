<?php

namespace App\Services;

use App\Models\BookData;
use App\Models\Book;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;

class BatchBookImportService
{
    private $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    public function parseCSV(UploadedFile $file): array
    {
        $rows = array_map('str_getcsv', file($file->getRealPath()));
        if (empty($rows)) {
            return [];
        }

        $header = array_shift($rows);
        $header = array_map('trim', $header);
        
        $data = [];
        foreach ($rows as $row) {
            if (count($header) === count($row)) {
                $data[] = array_combine($header, array_map('trim', $row));
            }
        }
        
        return $data;
    }

    public function validateRows(array $rows, array $options = []): array
    {
        $validatedRows = [];
        $autoGenerateBarcodes = !empty($options['auto_generate_barcodes']);
        
        foreach ($rows as $index => $row) {
            $status = 'valid';
            $errors = [];

            // Required fields
            if (empty($row['book_title'])) {
                $errors[] = 'Book title is required';
            }
            if (empty($row['author_last_name'])) {
                $errors[] = 'Author last name is required';
            }
            if (empty($row['accession_number'])) {
                $errors[] = 'Accession number is required';
            } else {
                // Check accession duplicate in DB
                if (\App\Models\Book::where('accession_number', $row['accession_number'])->exists()) {
                    $errors[] = 'Accession number already exists';
                }
            }

            if (empty($row['barcode']) && $autoGenerateBarcodes) {
                // Generate a unique barcode if missing and option is enabled
                $row['barcode'] = 'PGPC-BAR-' . strtoupper(uniqid());
            }

            if (!empty($row['barcode']) && \App\Models\Book::where('barcode', $row['barcode'])->exists()) {
                $errors[] = 'Barcode already exists';
            }

            // Map to BookService expected structure
            $parsedData = [
                'book_title' => $row['book_title'] ?? '',
                'subtitle' => $row['subtitle'] ?? null,
                'isbn' => $row['isbn'] ?? null,
                'issn' => $row['issn'] ?? null,
                'publisher' => $row['publisher'] ?? null,
                'publication_year' => $row['publication_year'] ?? null,
                'edition' => $row['edition'] ?? null,
                'pages' => $row['pages'] ?? null,
                'call_number' => $row['call_number'] ?? null,
                'classification' => $row['classification'] ?? null,
                'language' => $row['language'] ?? 'English',
                'book_type' => $row['book_type'] ?? 'Book',
                'format' => $row['format'] ?? 'Print',
                'main_author_last_name' => $row['author_last_name'] ?? '',
                'main_author_first_name' => $row['author_first_name'] ?? null,
                'new_categories' => !empty($row['category']) ? [$row['category']] : [],
                'accession_number' => $row['accession_number'] ?? '',
                'barcode' => $row['barcode'] ?? null,
                'location' => $row['location'] ?? null,
                'status' => $row['status'] ?? 'Available',
                'date_acquired' => $row['date_acquired'] ?? now()->toDateString(),
            ];

            if (empty($errors)) {
                // Check if title already exists to mark as "add copy" vs "new title"
                $duplicate = $this->bookService->checkDuplicate($parsedData);
                if ($duplicate) {
                    $status = 'existing_title';
                    $parsedData['existing_book_data_id'] = $duplicate->book_data_id;
                }
            } else {
                $status = 'invalid';
            }

            $validatedRows[] = [
                'original' => $row,
                'parsed' => $parsedData,
                'status' => $status,
                'errors' => $errors,
                'index' => $index,
            ];
        }

        return $validatedRows;
    }

    public function importRows(array $validatedRows): array
    {
        $summary = [
            'total' => count($validatedRows),
            'imported_titles' => 0,
            'imported_copies' => 0,
            'failed' => 0,
            'skipped' => 0,
        ];

        DB::beginTransaction();

        try {
            foreach ($validatedRows as $row) {
                if ($row['status'] === 'invalid') {
                    $summary['failed']++;
                    continue;
                }

                $data = $row['parsed'];

                if ($row['status'] === 'existing_title') {
                    // Add copy to existing title
                    Book::create([
                        'book_data_id' => $data['existing_book_data_id'],
                        'accession_number' => $data['accession_number'],
                        'barcode' => $data['barcode'],
                        'status' => $data['status'],
                        'location' => $data['location'],
                        'date_acquired' => $data['date_acquired'],
                    ]);
                    $summary['imported_copies']++;
                } else {
                    // Create new title + copy
                    $this->bookService->createBook($data);
                    $summary['imported_titles']++;
                    $summary['imported_copies']++;
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $summary;
    }
}
