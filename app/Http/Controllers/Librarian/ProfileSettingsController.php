<?php

namespace App\Http\Controllers\Librarian;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileSettingsController extends Controller
{
    /**
     * Show the librarian's profile settings page.
     */
    public function index()
    {
        $staffAccount = Auth::guard('member')->user();
        $librarian    = $staffAccount?->librarian;

        return view('librarian.settings', compact('staffAccount', 'librarian'));
    }

    /**
     * Update the librarian's profile information.
     */
    public function updateProfile(Request $request)
    {
        $staffAccount = Auth::guard('member')->user();
        $librarian    = $staffAccount?->librarian;

        $validated = $request->validate([
            'first_name'  => 'required|string|max:100',
            'middle_name' => 'nullable|string|max:100',
            'last_name'   => 'required|string|max:100',
            'email'       => 'required|email|max:255',
            'position'    => 'nullable|string|max:100',
        ]);

        if ($librarian) {
            $librarian->update($validated);
        }

        return redirect()->route('librarian.settings.index')
            ->with('success', 'Profile updated successfully.');
    }

    /**
     * Update the librarian's password.
     */
    public function updatePassword(Request $request)
    {
        $staffAccount = Auth::guard('member')->user();

        $request->validate([
            'current_password'      => 'required|string',
            'password'              => ['required', 'confirmed', Password::min(8)],
        ]);

        if (! Hash::check($request->current_password, $staffAccount->password_hash)) {
            return back()
                ->withErrors(['current_password' => 'The current password is incorrect.'])
                ->withInput();
        }

        $staffAccount->update([
            'password_hash'       => Hash::make($request->password),
            'password_changed_at' => now(),
        ]);

        return redirect()->route('librarian.settings.index')
            ->with('success', 'Password updated successfully.');
    }
}
