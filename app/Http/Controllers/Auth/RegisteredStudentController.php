<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterStudentRequest;
use App\Models\Member;
use App\Models\MemberAuth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Exception;

class RegisteredStudentController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create()
    {
        return Inertia::render('Auth/Register', [
            'routes' => [
                'home' => route('home'),
                'submit' => route('register.store'),
                'login' => route('login'),
            ],
        ]);
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(RegisterStudentRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();

            $member = Member::create([
                'student_id_number' => $data['student_id_number'],
                'first_name' => $data['first_name'],
                'middle_name' => $data['middle_name'] ?? null,
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'contact_num' => $data['contact_num'] ?? null,
                'program' => $data['program'],
                'year_level' => $data['year_level'],
            ]);

            MemberAuth::create([
                'member_id' => $member->member_id,
                'username' => $data['username'],
                'password_hash' => Hash::make($data['password']),
                'account_type' => 'Member',
                'account_status' => 'Active',
                'failed_attempts' => 0,
            ]);

            DB::commit();

            if ($request->expectsJson()) {
                return response()->json([
                    'redirect' => route('login'),
                    'message' => 'Registration successful. You can now log in.'
                ]);
            }

            return redirect()->route('login')->with('success', 'Registration successful. You can now log in.');

        } catch (Exception $e) {
            DB::rollBack();
            report($e);
            
            throw \Illuminate\Validation\ValidationException::withMessages([
                'student_id_number' => 'An error occurred during registration. Please try again.',
            ]);
        }
    }
}
