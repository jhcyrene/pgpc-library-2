<?php
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\UploadedFile;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$file = new UploadedFile('c:/Others/code/PGLibSystem/open_access_books_Jul_2026.mrc', 'open_access_books_Jul_2026.mrc', 'application/marc', null, true);

$validator = Validator::make(['marc_file' => $file], [
    'marc_file' => ['required', 'file', 'max:10240'],
]);

if ($validator->fails()) {
    echo "Validation failed:\n";
    print_r($validator->errors()->all());
} else {
    echo "Validation passed!\n";
}
