<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterStudentRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'student_id_number' => ['required', 'string', 'max:50', 'unique:members,student_id_number'],
            'first_name'        => ['required', 'string', 'max:100'],
            'middle_name'       => ['nullable', 'string', 'max:100'],
            'last_name'         => ['required', 'string', 'max:100'],
            'email'             => ['required', 'email', 'max:150', 'unique:members,email'],
            // Accept contact_num (web form) or contact_number (mobile API)
            'contact_num'       => ['nullable', 'string', 'max:20'],
            'contact_number'    => ['nullable', 'string', 'max:20'],
            'program'           => ['required', 'string', 'max:100'],
            'year_level'        => ['required', 'string', 'max:50'],
            'username'          => ['required', 'string', 'max:100', 'unique:member_auth,username'],
            'password'          => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
            // Web form requires terms; API callers (mobile) may skip this field
            'terms'             => [$this->expectsJson() ? 'nullable' : 'required', 'accepted'],
        ];
    }
}
