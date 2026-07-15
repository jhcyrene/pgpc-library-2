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

    public function update(UpdateStudentProfileRequest $request)
    {
        $memberAuth = Auth::guard('member')->user();
        $member = $memberAuth->member;
        
        $validated = $request->validated();
        
        // Handle member table updates
        $member->update([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'contact_num' => $validated['contact_num'] ?? null,
        ]);

        // Handle profile image upload to member_auth table
        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $mime = $image->getClientMimeType();
            $base64 = base64_encode($image->get());
            
            $memberAuth->update([
                'profile_image' => "data:{$mime};base64,{$base64}"
            ]);
        }

        return redirect()->route('student.profile.show')->with('success', 'Profile updated successfully.');
    }
}
