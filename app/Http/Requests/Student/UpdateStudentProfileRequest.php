<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateStudentProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::guard('member')->check();
    }

    public function rules(): array
    {
        $memberId = Auth::guard('member')->user()->member_id;
        
        return [
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150', 'unique:members,email,'.$memberId.',member_id'],
            'contact_num' => ['nullable', 'string', 'max:20'],
            'profile_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];
    }
}
