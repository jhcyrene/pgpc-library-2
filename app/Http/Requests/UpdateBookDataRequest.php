<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookDataRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'book_title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'series_title' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
            'language' => ['nullable', 'string', 'max:50'],
            'copyright_year' => ['nullable', 'integer', 'min:1000', 'max:'.(date('Y') + 1)],

            'isbn' => ['nullable', 'string', 'max:20'],
            'issn' => ['nullable', 'string', 'max:20'],
            'publisher_id' => ['nullable', 'exists:publishers,publisher_id'],
            'publisher' => ['nullable', 'string', 'max:255'], // If new publisher
            'publication_year' => ['nullable', 'integer', 'min:1000', 'max:'.(date('Y') + 1)],
            'edition' => ['nullable', 'string', 'max:50'],
            'pages' => ['nullable', 'integer', 'min:1'],
            'call_number' => ['nullable', 'string', 'max:50'],
            'classification' => ['nullable', 'string', 'max:50'],
            'book_type' => ['nullable', 'string', 'max:50'],
            'format' => ['nullable', 'string', 'max:50'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],

            'main_author_id' => ['nullable', 'exists:authors,author_id'],
            'main_author_last_name' => ['nullable', 'string', 'max:255'],
            'main_author_first_name' => ['nullable', 'string', 'max:255'],

            'categories' => ['nullable', 'array'],
            'categories.*' => ['exists:categories,category_id'],
        ];
    }
}
