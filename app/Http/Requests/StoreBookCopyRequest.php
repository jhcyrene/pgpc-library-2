<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBookCopyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'accession_number' => ['required', 'string', 'max:50', 'unique:books,accession_number'],
            'barcode' => ['nullable', 'string', 'max:50', 'unique:books,barcode'],
            'status' => ['required', 'string', 'max:50'],
            'location' => ['nullable', 'string', 'max:100'],
            'date_acquired' => ['nullable', 'date'],
        ];
    }
}
