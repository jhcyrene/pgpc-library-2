<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\UpdateStudentPasswordRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountSettingsController extends Controller
{
    public function edit()
    {
        return view('student.account-settings.edit');
    }

    public function updatePassword(UpdateStudentPasswordRequest $request)
    {
        $user = Auth::guard('member')->user();
        
        $user->update([
            'password_hash' => Hash::make($request->validated('password'))
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Password updated successfully.',
                'redirect' => route('student.account-settings.edit')
            ]);
        }

        return back()->with('success', 'Password updated successfully.');
    }
}
