<?php

namespace App\Http\Controllers;

use App\Services\MarcImportService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

class MarcImportController extends Controller
{
    private MarcImportService $marcService;

    public function __construct(MarcImportService $marcService)
    {
        $this->marcService = $marcService;
    }

    /**
     * Show the MARC file upload form.
     */
    public function create()
    {
        return view('admin.books.marc.create');
    }

    /**
     * Parse the uploaded MARC file and show a preview table.
     */
    public function preview(Request $request)
    {
        $request->validate([
            'marc_file' => ['required', 'file', 'max:10240'],
        ], [
            'marc_file.required' => 'Please choose a MARC file to upload.',
            'marc_file.file' => 'The MARC upload must be a valid file.',
            'marc_file.max' => 'The MARC file must not be larger than 10 MB.',
        ]);

        $file = $request->file('marc_file');

        if (! $file || ! $file->isValid()) {
            return back()->withErrors([
                'marc_file' => 'The MARC file could not be uploaded. Please choose the file again.',
            ]);
        }

        $ext = strtolower($file->getClientOriginalExtension());
        $allowedExtensions = ['mrc', 'marc', 'xml', 'marcxml'];

        if (! in_array($ext, $allowedExtensions, true)) {
            return back()->withErrors([
                'marc_file' => 'Unsupported file type. Please upload a .mrc, .marc, .xml, or .marcxml file.',
            ]);
        }

        try {
            $records = $this->marcService->parseFile($file);

            if (empty($records)) {
                return back()->with('error', 'No bibliographic records found in the uploaded file.');
            }

            $validatedRows = $this->marcService->validateRecords($records);

            $batchId = 'marc_' . Str::uuid();
            Cache::put($batchId, $validatedRows, now()->addMinutes(30));

            return view('admin.books.marc.preview', compact('validatedRows', 'batchId'));
        } catch (Throwable $e) {
            Log::warning('MARC upload could not be processed.', [
                'filename' => $file->getClientOriginalName(),
                'extension' => $ext,
                'size' => $file->getSize(),
                'exception' => $e,
            ]);

            return back()->withErrors([
                'marc_file' => $e instanceof \RuntimeException
                    ? $e->getMessage()
                    : 'The MARC file could not be processed. Please verify the file and try again.',
            ]);
        }
    }

    /**
     * Import confirmed records from the preview cache.
     */
    public function store(Request $request)
    {
        $request->validate([
            'batch_id'    => 'required|string',
            'accessions'  => 'nullable|array',
            'accessions.*' => 'nullable|string|max:50',
        ]);

        $validatedRows = Cache::get($request->batch_id);

        if (! $validatedRows) {
            return redirect()->route('admin.books.marc-create')
                ->with('error', 'Session expired. Please upload the file again.');
        }

        try {
            $summary = $this->marcService->importRecords(
                $validatedRows,
                $request->input('accessions', []),
            );

            Cache::forget($request->batch_id);

            return view('admin.books.marc.result', compact('summary'));
        } catch (Throwable $e) {
            Log::error('MARC import failed.', [
                'batch_id' => $request->batch_id,
                'exception' => $e,
            ]);

            return redirect()->route('admin.books.marc-create')
                ->with('error', 'The MARC records could not be imported. Please review the file and try again.');
        }
    }
}
