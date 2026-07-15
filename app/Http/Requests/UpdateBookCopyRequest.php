<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBookCopyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $bookId = $this->route('book')->book_id ?? $this->route('book');

        return [
            'accession_number' => ['required', 'string', 'max:50', Rule::unique('books', 'accession_number')->ignore($bookId, 'book_id')],
            'barcode' => ['nullable', 'string', 'max:50', Rule::unique('books', 'barcode')->ignore($bookId, 'book_id')],
            'status' => ['required', 'string', 'max:50'],
            'location' => ['nullable', 'string', 'max:100'],
            'date_acquired' => ['nullable', 'date'],
        ];
    }
}
