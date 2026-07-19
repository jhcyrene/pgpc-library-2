<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\UpdateStudentProfileRequest;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    public function show(): Response
    {
        $account = Auth::guard('member')->user();

        return Inertia::render('Student/Profile/Show', [
            'profile' => $this->serializeProfile($account->member, $account->profile_image),
        ]);
    }

    public function edit(): Response
    {
        $account = Auth::guard('member')->user();

        return Inertia::render('Student/Profile/Edit', [
            'profile' => $this->serializeProfile($account->member, $account->profile_image),
        ]);
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

    private function serializeProfile(Member $member, ?string $profileImage): array
    {
        return [
            'id' => (int) $member->member_id,
            'studentId' => $member->student_id_number,
            'firstName' => $member->first_name,
            'lastName' => $member->last_name,
            'email' => $member->email,
            'contactNumber' => $member->contact_num,
            'program' => $member->program,
            'yearLevel' => $member->year_level,
            'memberSince' => $member->created_at?->format('M d, Y'),
            'profileImage' => $profileImage,
            'initials' => strtoupper(substr((string) $member->first_name, 0, 1).substr((string) $member->last_name, 0, 1)),
            'actions' => [
                'show' => route('student.profile.show'),
                'edit' => route('student.profile.edit'),
                'update' => route('student.profile.update'),
            ],
        ];
    }
}
