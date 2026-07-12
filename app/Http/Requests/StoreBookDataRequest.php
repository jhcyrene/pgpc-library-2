<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreBookDataRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'book_title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'series_title' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
            'language' => ['nullable', 'string', 'max:50'],
            'copyright_year' => ['nullable', 'integer', 'min:1000', 'max:' . (date('Y') + 1)],
            
            'isbn' => ['nullable', 'string', 'max:20'],
            'issn' => ['nullable', 'string', 'max:20'],
            'publisher_id' => ['nullable', 'exists:publishers,publisher_id'],
            'publisher' => ['nullable', 'string', 'max:255'], // If new publisher
            'publication_year' => ['nullable', 'integer', 'min:1000', 'max:' . (date('Y') + 1)],
            'edition' => ['nullable', 'string', 'max:50'],
            'pages' => ['nullable', 'integer', 'min:1'],
            'call_number' => ['nullable', 'string', 'max:50'],
            'classification' => ['nullable', 'string', 'max:50'],
            'book_type' => ['nullable', 'string', 'max:50'],
            'format' => ['nullable', 'string', 'max:50'],
            
            'main_author_id' => ['nullable', 'exists:authors,author_id'],
            'main_author_last_name' => ['nullable', 'string', 'max:255'],
            'main_author_first_name' => ['nullable', 'string', 'max:255'],
            
            'categories' => ['nullable', 'array'],
            'categories.*' => ['exists:categories,category_id'],
            
            'accession_number' => ['required', 'string', 'max:50', 'unique:books,accession_number'],
            'barcode' => ['nullable', 'string', 'max:50', 'unique:books,barcode'],
            'status' => ['nullable', 'string', 'max:50'],
            'location' => ['nullable', 'string', 'max:100'],
            'date_acquired' => ['nullable', 'date'],
        ];
    }
}
