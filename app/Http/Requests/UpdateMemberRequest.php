<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMemberRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $memberId = $this->route('member') ? $this->route('member')->member_id : null;
        $memberAuthId = $this->route('member') && $this->route('member')->memberAuth ? $this->route('member')->memberAuth->member_auth_id : null;

        return [
            // Profile fields
            'student_id_number' => ['required', 'string', 'max:255', Rule::unique('members')->ignore($memberId, 'member_id')],
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('members')->ignore($memberId, 'member_id')],
            'contact_num' => ['nullable', 'string', 'max:50'],
            'program' => ['nullable', 'string', 'max:255'],
            'year_level' => ['nullable', 'string', 'max:50'],

            // Auth fields
            'create_account' => ['nullable', 'boolean'],
            'username' => ['required_with:create_account', 'nullable', 'string', 'max:255', Rule::unique('member_auth')->ignore($memberAuthId, 'member_auth_id')],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'account_type' => ['nullable', 'string', 'in:Member'],
            'account_status' => ['nullable', 'string', 'in:Active,Inactive,Suspended,Locked'],
        ];
    }
}
