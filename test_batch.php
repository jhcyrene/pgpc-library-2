<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Services\BatchBookImportService;
use Illuminate\Http\UploadedFile;

try {
    $service = app(BatchBookImportService::class);
    $file = new UploadedFile('c:/Others/code/PGLibSystem/sample.csv', 'sample.csv', 'text/csv', null, true);
    $rows = $service->parseCSV($file);
    echo "Parsed:\n";
    print_r($rows);
    $validated = $service->validateRows($rows);
    echo "Validated:\n";
    print_r($validated);
} catch (\Exception $e) {
    echo 'FAILED: ' . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
