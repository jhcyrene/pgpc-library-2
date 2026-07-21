<?php

namespace App\Services;

use App\Models\Book;
use Illuminate\Http\UploadedFile;
use RuntimeException;
use Scriptotek\Marc\Collection;
use Scriptotek\Marc\Record;
use Throwable;

class MarcImportService
{
    private BookService $bookService;

    /**
     * ISO 639-2/B code → human-readable language name (common subset).
     */
    private const LANGUAGE_MAP = [
        'eng' => 'English', 'fil' => 'Filipino', 'tgl' => 'Tagalog',
        'spa' => 'Spanish', 'fre' => 'French',   'ger' => 'German',
        'jpn' => 'Japanese', 'kor' => 'Korean',  'chi' => 'Chinese',
        'ara' => 'Arabic',  'ita' => 'Italian',  'por' => 'Portuguese',
        'rus' => 'Russian', 'hin' => 'Hindi',    'tha' => 'Thai',
        'vie' => 'Vietnamese', 'ind' => 'Indonesian', 'mal' => 'Malay',
        'dut' => 'Dutch',  'lat' => 'Latin',     'gre' => 'Greek',
    ];

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    // ------------------------------------------------------------------
    // Parsing
    // ------------------------------------------------------------------

    /**
     * Parse a MARC file (.mrc binary or .xml/.marcxml) into an array of
     * normalised bibliographic data arrays.
     *
     * @return array<int, array{title: string, subtitle: ?string, ...}>
     */
    public function parseFile(UploadedFile $file): array
    {
        $path = $file->getRealPath();

        if (! $path || ! is_readable($path)) {
            throw new RuntimeException('The uploaded MARC file is not readable. Please choose the file again.');
        }

        $contents = $file->get();
        if ($contents === false || $contents === '') {
            throw new RuntimeException('The uploaded MARC file is empty or could not be read.');
        }

        $extension = strtolower($file->getClientOriginalExtension());
        $withoutBom = str_starts_with($contents, "\xEF\xBB\xBF")
            ? substr($contents, 3)
            : $contents;
        $xmlContents = ltrim($withoutBom);
        $looksLikeXml = str_starts_with($xmlContents, '<');

        if (in_array($extension, ['xml', 'marcxml'], true) && ! $looksLikeXml) {
            throw new RuntimeException('The uploaded XML file does not contain valid MARCXML data.');
        }

        $records = [];
        try {
            $collection = Collection::fromString($looksLikeXml ? $xmlContents : $contents);

            foreach ($collection as $record) {
                $parsed = $this->extractFields($record);
                if ($parsed !== null) {
                    $parsed['_marc_xml'] = $record->toXML('UTF-8', true, true);
                    $records[] = $parsed;
                }
            }
        } catch (Throwable $e) {
            throw new RuntimeException(
                'The uploaded file could not be parsed as MARC 21 or MARCXML. Check that the file is complete and uses a supported MARC format.',
                previous: $e,
            );
        }

        return $records;
    }

    /**
     * Map a single MARC record to the flat array structure that
     * BookService::createBook() expects.
     */
    private function extractFields(Record $record): ?array
    {
        $title = $this->subfield($record, '245', 'a');
        if (! $title) {
            return null; // Unusable without a title
        }

        // ---- Title / subtitle ----
        $subtitle = $this->subfield($record, '245', 'b');

        // ---- Authors (100 = main, 700 = additional) ----
        $mainAuthorRaw = $this->subfield($record, '100', 'a');
        [$mainLastName, $mainFirstName] = $mainAuthorRaw ? $this->splitAuthorName($mainAuthorRaw) : [null, null];

        $additionalAuthors = [];
        foreach ($record->getFields('700') as $field) {
            $name = $this->getSubfieldData($field, 'a');
            if ($name) {
                [$last, $first] = $this->splitAuthorName($name);
                $relator = $this->getSubfieldData($field, 'e');
                $additionalAuthors[] = [
                    'last_name'  => $last,
                    'first_name' => $first,
                    'role'       => $this->normaliseRelator($relator),
                ];
            }
        }

        // ---- Identifiers ----
        $isbn = $this->subfield($record, '020', 'a');
        $issn = $this->subfield($record, '022', 'a');

        // Clean ISBN (strip qualifiers like "(pbk.)")
        if ($isbn) {
            $isbn = preg_replace('/\s*\(.+\)\s*$/', '', $isbn);
            $isbn = preg_replace('/[^0-9Xx-]/', '', $isbn);
        }

        // ---- Publication ----
        $publisher = $this->subfield($record, '264', 'b')
                  ?? $this->subfield($record, '260', 'b');
        $pubYear   = $this->subfield($record, '264', 'c')
                  ?? $this->subfield($record, '260', 'c');

        // Extract 4-digit year
        if ($pubYear && preg_match('/(\d{4})/', $pubYear, $m)) {
            $pubYear = $m[1];
        } else {
            // Fallback to 008 positions 7-10
            $field008 = $this->controlField($record, '008');
            if ($field008 && strlen($field008) >= 11) {
                $candidate = substr($field008, 7, 4);
                $pubYear = ctype_digit($candidate) ? $candidate : null;
            }
        }

        // ---- Edition ----
        $edition = $this->subfield($record, '250', 'a');

        // ---- Physical description ----
        $pages = $this->subfield($record, '300', 'a');
        if ($pages && preg_match('/(\d+)/', $pages, $m)) {
            $pages = $m[1];
        }

        // ---- Call number ----
        $callNumber = $this->buildCallNumber($record);

        // ---- Classification (DDC from 082) ----
        $classification = $this->subfield($record, '082', 'a');

        // ---- Language (008 positions 35-37) ----
        $language = 'English';
        $field008 = $this->controlField($record, '008');
        if ($field008 && strlen($field008) >= 38) {
            $code = substr($field008, 35, 3);
            $language = self::LANGUAGE_MAP[$code] ?? 'English';
        }

        // ---- Description / Summary ----
        $description = $this->subfield($record, '520', 'a');

        // ---- Series ----
        $series = $this->subfield($record, '490', 'a');

        // ---- Notes ----
        $notes = $this->subfield($record, '500', 'a');

        // ---- Subjects → categories ----
        $categories = [];
        foreach ($record->getFields('650') as $field) {
            $subject = $this->getSubfieldData($field, 'a');
            if ($subject) {
                $categories[] = $this->clean($subject);
            }
        }

        return [
            'book_title'             => $this->clean($title),
            'subtitle'               => $subtitle ? $this->clean($subtitle) : null,
            'description'            => $description ? $this->clean($description) : null,
            'series_title'           => $series ? $this->clean($series) : null,
            'notes'                  => $notes ? $this->clean($notes) : null,
            'language'               => $language,
            'isbn'                   => $isbn ?: null,
            'issn'                   => $issn ? $this->clean($issn) : null,
            'publisher'              => $publisher ? $this->clean($publisher) : null,
            'publication_year'       => $pubYear ?: null,
            'edition'                => $edition ? $this->clean($edition) : null,
            'pages'                  => $pages ?: null,
            'call_number'            => $callNumber,
            'classification'         => $classification ? $this->clean($classification) : null,
            'book_type'              => 'Book',
            'format'                 => 'Print',
            'main_author_last_name'  => $mainLastName,
            'main_author_first_name' => $mainFirstName,
            'additional_authors'     => $additionalAuthors,
            'new_categories'         => array_unique($categories),
        ];
    }

    // ------------------------------------------------------------------
    // Validation (mirrors BatchBookImportService::validateRows)
    // ------------------------------------------------------------------

    /**
     * Validate parsed records and return the same structure used by
     * the batch CSV preview.
     */
    public function validateRecords(array $records, array $options = []): array
    {
        $validated = [];
        $autoGenerateBarcodes = !empty($options['auto_generate_barcodes']);

        foreach ($records as $index => $parsed) {
            $errors = [];

            if (empty($parsed['book_title'])) {
                $errors[] = 'Book title is required.';
            }
            if (empty($parsed['main_author_last_name'])) {
                $errors[] = 'Main author is required.';
            }

            if (empty($parsed['barcode']) && $autoGenerateBarcodes) {
                $parsed['barcode'] = 'PGPC-BAR-' . strtoupper(uniqid());
            }

            $status = empty($errors) ? 'valid' : 'invalid';

            if ($status === 'valid') {
                $duplicate = $this->bookService->checkDuplicate($parsed);
                if ($duplicate) {
                    $status = 'existing_title';
                    $parsed['existing_book_data_id'] = $duplicate->book_data_id;
                }
            }

            $validated[] = [
                'index'    => $index,
                'parsed'   => $parsed,
                'status'   => $status,
                'errors'   => $errors,
            ];
        }

        return $validated;
    }

    // ------------------------------------------------------------------
    // Import
    // ------------------------------------------------------------------

    /**
     * Import validated + confirmed records.
     *
     * $accessions is an optional map of index → accession_number supplied
     * by the user on the preview form.
     */
    public function importRecords(array $validatedRows, array $accessions = []): array
    {
        $summary = [
            'total'           => count($validatedRows),
            'imported_titles' => 0,
            'imported_copies' => 0,
            'skipped'         => 0,
            'failed'          => 0,
        ];

        \Illuminate\Support\Facades\DB::beginTransaction();

        try {
            foreach ($validatedRows as $row) {
                if ($row['status'] === 'invalid') {
                    $summary['failed']++;
                    continue;
                }

                $data = $row['parsed'];
                $idx  = $row['index'];

                // Merge optional accession number from the form
                $accession = trim($accessions[$idx] ?? '');
                if ($accession !== '') {
                    // Verify accession uniqueness
                    if (Book::where('accession_number', $accession)->exists()) {
                        $summary['failed']++;
                        continue;
                    }
                    $data['accession_number'] = $accession;
                }

                // Store raw MARC XML
                $data['marc_record'] = $data['_marc_xml'] ?? null;
                unset($data['_marc_xml']);

                if ($row['status'] === 'existing_title' && isset($data['existing_book_data_id'])) {
                    // Add copy to existing title (only if accession provided)
                    if (! empty($data['accession_number'])) {
                        Book::create([
                            'book_data_id'     => $data['existing_book_data_id'],
                            'accession_number' => $data['accession_number'],
                            'status'           => 'Available',
                            'date_acquired'    => now()->toDateString(),
                        ]);
                        $summary['imported_copies']++;
                    } else {
                        $summary['skipped']++;
                    }
                } else {
                    // New title
                    $this->bookService->createBook($data);
                    $summary['imported_titles']++;
                    if (! empty($data['accession_number'])) {
                        $summary['imported_copies']++;
                    }
                }
            }

            \Illuminate\Support\Facades\DB::commit();
        } catch (Throwable $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            throw $e;
        }

        return $summary;
    }

    // ------------------------------------------------------------------
    // Helpers
    // ------------------------------------------------------------------

    /**
     * Get a single subfield value from a data field.
     */
    private function subfield(Record $record, string $tag, string $code): ?string
    {
        $field = $record->getField($tag);
        if (! $field) {
            return null;
        }

        return $this->getSubfieldData($field, $code);
    }

    /**
     * Get a control field (00X) value.
     */
    private function controlField(Record $record, string $tag): ?string
    {
        $field = $record->getField($tag);
        if (! $field) {
            return null;
        }

        $rawField = method_exists($field, 'getField') ? $field->getField() : $field;

        return method_exists($rawField, 'getData') ? $rawField->getData() : null;
    }

    /**
     * Safely extract subfield data from a File_MARC_Data_Field.
     */
    private function getSubfieldData($field, string $code): ?string
    {
        if (method_exists($field, 'getSubfield')) {
            $sf = $field->getSubfield($code);
            return $sf ? $sf->getData() : null;
        }

        // Sometimes the library returns a Scriptotek\Marc\Fields\Field
        // which implements a different method: sf()
        if (method_exists($field, 'sf')) {
            return $field->sf($code);
        }

        return null;
    }

    /**
     * Build a call number from 050 or 090.
     */
    private function buildCallNumber(Record $record): ?string
    {
        foreach (['050', '090'] as $tag) {
            $field = $record->getField($tag);
            if ($field) {
                $a = $this->getSubfieldData($field, 'a');
                $b = $this->getSubfieldData($field, 'b');
                if ($a) {
                    return trim($a . ' ' . ($b ?? ''));
                }
            }
        }

        return null;
    }

    /**
     * Split "Last, First" into [last, first].
     */
    private function splitAuthorName(?string $raw): array
    {
        if (! $raw) {
            return ['', ''];
        }

        $raw = $this->clean($raw);

        if (str_contains($raw, ',')) {
            $parts = array_map('trim', explode(',', $raw, 2));
            return [$parts[0], $parts[1] ?? ''];
        }

        // Single-word name treated as last name
        return [$raw, ''];
    }

    /**
     * Normalise MARC relator terms to a simple role.
     */
    private function normaliseRelator(?string $term): string
    {
        if (! $term) {
            return 'Author';
        }

        $term = strtolower($this->clean($term));

        return match (true) {
            str_contains($term, 'editor')     => 'Editor',
            str_contains($term, 'translator') => 'Translator',
            str_contains($term, 'illustrat')  => 'Illustrator',
            default                           => 'Author',
        };
    }

    /**
     * Strip trailing punctuation and whitespace common in MARC data.
     */
    private function clean(?string $value): string
    {
        if ($value === null) {
            return '';
        }

        return trim($value, " \t\n\r\0\x0B/,:;.");
    }
}
