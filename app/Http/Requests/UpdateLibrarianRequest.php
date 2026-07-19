<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLibrarianRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $librarianId = $this->route('librarian') ? $this->route('librarian')->librarian_id : null;
        $memberAuthId = $this->route('librarian') && $this->route('librarian')->memberAuth ? $this->route('librarian')->memberAuth->member_auth_id : null;

        return [
            // Profile fields
            'employee_number' => ['required', 'string', 'max:255', Rule::unique('librarians')->ignore($librarianId, 'librarian_id')],
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255', Rule::unique('librarians')->ignore($librarianId, 'librarian_id')],
            'position' => ['nullable', 'string', 'max:255'],

            // Auth fields
            'create_account' => ['nullable', 'boolean'],
            'username' => ['required_with:create_account', 'nullable', 'string', 'max:255', Rule::unique('member_auth')->ignore($memberAuthId, 'member_auth_id')],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'account_type' => ['nullable', 'string', 'in:Librarian,Administrator'],
            'account_status' => ['nullable', 'string', 'in:Active,Inactive,Suspended,Locked'],
        ];
    }
}
