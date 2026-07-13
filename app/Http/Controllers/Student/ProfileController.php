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
        $member = Auth::guard('member')->user()->member;
        $member->update($request->validated());

        return redirect()->route('student.profile.show')->with('success', 'Profile updated successfully.');
    }
}
