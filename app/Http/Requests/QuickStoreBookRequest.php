<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuickStoreBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'book_title' => ['required', 'string', 'max:255'],
            'main_author_last_name' => ['required', 'string', 'max:255'],
            'main_author_first_name' => ['nullable', 'string', 'max:255'],
            'isbn' => ['nullable', 'string', 'max:20'],
            'category_id' => ['nullable', 'exists:categories,category_id'],
            'publisher_id' => ['nullable', 'exists:publishers,publisher_id'],
            'publisher' => ['nullable', 'string', 'max:255'],
            'publication_year' => ['nullable', 'integer', 'min:1000', 'max:' . (date('Y') + 1)],
            'call_number' => ['nullable', 'string', 'max:50'],
            
            'accession_number' => ['required', 'string', 'max:50', 'unique:books,accession_number'],
            'barcode' => ['nullable', 'string', 'max:50', 'unique:books,barcode'],
            'location' => ['nullable', 'string', 'max:100'],
            'date_acquired' => ['nullable', 'date'],
        ];
    }
}
