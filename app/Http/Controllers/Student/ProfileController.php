<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\UpdateStudentProfileRequest;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        $member = Auth::guard('member')->user()->member;
        return view('student.profile.show', compact('member'));
    }

    public function edit()
    {
        $member = Auth::guard('member')->user()->member;
        return view('student.profile.edit', compact('member'));
    }

    public function complete()
    {
        $member = Auth::guard('member')->user()->member;
        return view('student.profile.complete', compact('member'));
    }

    public function storeComplete(UpdateStudentProfileRequest $request)
    {
        return $this->update($request);
    }

    public function update(UpdateStudentProfileRequest $request)
    {
        $memberAuth = Auth::guard('member')->user();
        $member = $memberAuth->member;
        
        $validated = $request->validated();

        // Handle password change / creation if requested
        if ($request->filled('new_password')) {
            if ($memberAuth->hasPassword()) {
                if (!$request->filled('current_password') || !\Illuminate\Support\Facades\Hash::check($request->input('current_password'), $memberAuth->password_hash)) {
                    if ($request->ajax() || $request->wantsJson()) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Current password does not match.',
                            'errors' => ['current_password' => ['Current password does not match.']]
                        ], 422);
                    }
                    return back()->withErrors(['current_password' => 'Current password does not match.']);
                }
            }

            if ($request->input('new_password') !== $request->input('new_password_confirmation')) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Password confirmation does not match.',
                        'errors' => ['new_password' => ['Password confirmation does not match.']]
                    ], 422);
                }
                return back()->withErrors(['new_password' => 'Password confirmation does not match.']);
            }

            $memberAuth->update([
                'password_hash' => \Illuminate\Support\Facades\Hash::make($request->input('new_password'))
            ]);
        }
        
        // Handle member table updates
        $member->update([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'contact_num' => $validated['contact_num'] ?? null,
            'program' => $validated['program'] ?? $member->program,
            'year_level' => $validated['year_level'] ?? $member->year_level,
        ]);

        if (!empty($validated['username'])) {
            $memberAuth->update([
                'username' => $validated['username']
            ]);
        }

        // Handle profile image removal
        if ($request->boolean('remove_profile_image')) {
            $memberAuth->update([
                'profile_image' => null
            ]);
        }
        // Handle profile image upload/base64 to member_auth table
        elseif ($request->filled('profile_image_base64')) {
            $memberAuth->update([
                'profile_image' => $request->input('profile_image_base64')
            ]);
        } elseif ($request->filled('profile_image') && str_starts_with((string)$request->input('profile_image'), 'data:image')) {
            $memberAuth->update([
                'profile_image' => $request->input('profile_image')
            ]);
        } elseif ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $mime = $image->getClientMimeType();
            $base64 = base64_encode(file_get_contents($image->getRealPath()));
            
            $memberAuth->update([
                'profile_image' => "data:{$mime};base64,{$base64}"
            ]);
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully.',
                'redirect' => route('student.profile.show')
            ]);
        }

        return redirect()->route('student.profile.show')->with('success', 'Profile updated successfully.');
    }
}
