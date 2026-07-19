<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\UpdateStudentPasswordRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use Inertia\Inertia;
use Inertia\Response;

class AccountSettingsController extends Controller
{
    public function edit(): Response
    {
        $account = Auth::guard('member')->user();
        $lastLogin = $account->last_login_at ?? $account->last_login;

        return Inertia::render('Student/AccountSettings/Edit', [
            'account' => [
                'username' => $account->username,
                'accountType' => $account->account_type,
                'accountStatus' => $account->account_status,
                'lastLogin' => $lastLogin ? Carbon::parse($lastLogin)->format('M d, Y h:i A') : null,
                'passwordChangedAt' => $account->password_changed_at?->format('M d, Y h:i A'),
            ],
            'form' => [
                'updatePasswordUrl' => route('student.account-settings.password'),
            ],
        ]);
    }

    public function updatePassword(UpdateStudentPasswordRequest $request)
    {
        $user = Auth::guard('member')->user();
        
        $user->update([
            'password_hash' => Hash::make($request->validated('password'))
        ]);

        return back()->with('success', 'Password updated successfully.');
    }
}
