<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreReservationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::guard('member')->check();
    }

    public function rules(): array
    {
        return [
            'pickup_date' => ['required', 'date', 'after_or_equal:today'],
            'remarks' => ['nullable', 'string', 'max:500'],
        ];
    }
}
