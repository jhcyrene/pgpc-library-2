<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreLibrarianRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Profile fields
            'employee_number' => ['required', 'string', 'max:255', 'unique:librarians,employee_number'],
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255', 'unique:librarians,email'],
            'position' => ['nullable', 'string', 'max:255'],

            // Auth fields
            'create_account' => ['nullable', 'boolean'],
            'username' => ['required_if:create_account,1', 'nullable', 'string', 'max:255', 'unique:member_auth,username'],
            'password' => ['required_if:create_account,1', 'nullable', 'string', 'min:8', 'confirmed'],
            'account_type' => ['nullable', 'string', 'in:Librarian,Administrator'],
            'account_status' => ['nullable', 'string', 'in:Active,Inactive,Suspended,Locked'],
        ];
    }
}
