<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BatchBookImportService;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;

class BatchBookController extends Controller
{
    private $batchService;

    public function __construct(BatchBookImportService $batchService)
    {
        $this->batchService = $batchService;
    }

    public function create()
    {
        return view('admin.books.batch.create');
    }

    public function template()
    {
        $headers = [
            'book_title', 'subtitle', 'author_first_name', 'author_last_name', 
            'isbn', 'issn', 'publisher', 'publication_year', 'edition', 'pages', 
            'call_number', 'classification', 'category', 'language', 'book_type', 
            'format', 'accession_number', 'barcode', 'location', 'date_acquired', 'status'
        ];

        $callback = function() use ($headers) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $headers);
            // Add a sample row
            fputcsv($file, [
                'Sample Book', '', 'John', 'Doe', '9781234567890', '', 'Sample Publisher', 
                '2023', '1st', '300', 'QA76.S3', 'Science', 'Computer Science', 'English', 
                'Book', 'Print', 'ACC-1001', 'BAR-1001', 'Shelf A', date('Y-m-d'), 'Available'
            ]);
            fclose($file);
        };

        return response()->stream($callback, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="book_import_template.csv"',
        ]);
    }

    public function preview(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:10240',
        ]);

        try {
            $rows = $this->batchService->parseCSV($request->file('csv_file'));
            
            if (empty($rows)) {
                return back()->with('error', 'The uploaded CSV file is empty or invalid.');
            }

            $validatedRows = $this->batchService->validateRows($rows);
            
            // Cache the validated rows for the actual import step
            $batchId = uniqid('batch_');
            Cache::put($batchId, $validatedRows, now()->addMinutes(30));

            return view('admin.books.batch.preview', compact('validatedRows', 'batchId'));
        } catch (\Exception $e) {
            return back()->with('error', 'Error processing file: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'batch_id' => 'required|string',
        ]);

        $validatedRows = Cache::get($request->batch_id);

        if (!$validatedRows) {
            return redirect()->route('admin.books.batch-create')
                ->with('error', 'Batch session expired. Please upload the file again.');
        }

        try {
            $summary = $this->batchService->importRows($validatedRows);
            Cache::forget($request->batch_id);

            return view('admin.books.batch.result', compact('summary'));
        } catch (\Exception $e) {
            return redirect()->route('admin.books.batch-create')
                ->with('error', 'Import failed: ' . $e->getMessage());
        }
    }
}
