<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Services\MarcImportService;
use Illuminate\Http\UploadedFile;

try {
    $service = app(MarcImportService::class);
    $file = new UploadedFile('c:/Others/code/PGLibSystem/open_access_books_Jul_2026.mrc', 'test.mrc', 'application/marc', null, true);
    
    $start = microtime(true);
    $records = $service->parseFile($file);
    echo 'Parsing took ' . round(microtime(true) - $start, 2) . " seconds.\n";
    
    $start = microtime(true);
    $validated = $service->validateRecords($records);
    echo 'Validation took ' . round(microtime(true) - $start, 2) . " seconds.\n";
    
    echo 'SUCCESS! ' . count($validated) . ' records validated.';
} catch (\Exception $e) {
    echo 'FAILED: ' . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
