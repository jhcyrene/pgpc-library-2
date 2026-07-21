<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterStudentRequest;
use App\Models\Member;
use App\Models\MemberAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ApiAuthController extends Controller
{
    private const STAFF_TYPES   = ['administrator', 'admin', 'librarian'];
    private const STUDENT_TYPES = ['member', 'student'];

    // ─────────────────────────────────────────────────────────────────
    // POST /api/login  (student)
    // POST /api/staff/login  (staff / admin)
    // ─────────────────────────────────────────────────────────────────
    public function login(Request $request)
    {
        return $this->authenticateApi($request, self::STUDENT_TYPES);
    }

    public function staffLogin(Request $request)
    {
        return $this->authenticateApi($request, self::STAFF_TYPES);
    }

    private function authenticateApi(Request $request, array $allowedTypes)
    {
        $request->validate([
            'username'    => ['required', 'string'],
            'password'    => ['required', 'string'],
            'device_name' => ['nullable', 'string', 'max:255'],
        ]);

        $login = $request->input('username');

        /** @var MemberAuth|null $user */
        $user = MemberAuth::with(['member', 'librarian'])
            ->where('username', $login)
            ->orWhereHas('member', fn($q) => $q->where('student_id_number', $login))
            ->first();

        if (! $user) {
            throw ValidationException::withMessages([
                'username' => 'The username or password is incorrect.',
            ]);
        }

        // Google-only account
        if (! $user->hasPassword() && ! empty($user->provider)) {
            throw ValidationException::withMessages([
                'username' => 'This account was created via Google Sign-In. Please sign in using Google.',
            ]);
        }

        // Wrong password
        if (! $user->hasPassword() || ! Hash::check($request->password, $user->password_hash)) {
            $user->increment('failed_attempts');
            throw ValidationException::withMessages([
                'username' => 'The username or password is incorrect.',
            ]);
        }

        // Wrong portal
        $type = strtolower((string) $user->account_type);
        if (! in_array($type, $allowedTypes, true)) {
            throw ValidationException::withMessages([
                'username' => 'This account cannot sign in through this portal.',
            ]);
        }

        // Account not active
        if (strtolower($user->account_status) !== 'active') {
            throw ValidationException::withMessages([
                'username' => 'Your account is currently unavailable. Please contact the library administrator.',
            ]);
        }

        // Issue Sanctum token
        $deviceName  = $request->input('device_name', 'Mobile App');
        $token       = $user->createToken($deviceName)->plainTextToken;

        // Update tracking
        $user->last_login      = now();
        $user->last_login_at   = now();
        $user->last_modified   = now();
        $user->failed_attempts = 0;
        $user->save();

        $profile = $type === 'member' || $type === 'student'
            ? $user->member
            : $user->librarian;

        return response()->json([
            'token'      => $token,
            'token_type' => 'Bearer',
            'user'       => array_merge($user->only([
                'member_auth_id', 'username', 'account_type',
                'account_status', 'profile_image', 'is_verified',
            ]), ['profile' => $profile]),
            'member'     => $user->member,
        ]);
    }

    // ─────────────────────────────────────────────────────────────────
    // POST /api/register
    // ─────────────────────────────────────────────────────────────────
    public function register(RegisterStudentRequest $request)
    {
        $data = $request->validated();

        DB::beginTransaction();
        try {
            $member = Member::create([
                'student_id_number' => $data['student_id_number'],
                'first_name'        => $data['first_name'],
                'middle_name'       => $data['middle_name'] ?? null,
                'last_name'         => $data['last_name'],
                'email'             => $data['email'],
                'contact_num'       => $data['contact_num'] ?? $data['contact_number'] ?? null,
                'program'           => $data['program'],
                'year_level'        => $data['year_level'],
            ]);

            $memberAuth = MemberAuth::create([
                'member_id'      => $member->member_id,
                'username'       => $data['username'],
                'password_hash'  => Hash::make($data['password']),
                'account_type'   => 'Member',
                'account_status' => 'Active',
                'failed_attempts' => 0,
            ]);

            DB::commit();

            $token = $memberAuth->createToken('Mobile App')->plainTextToken;

            return response()->json([
                'message'    => 'Registration successful. You can now access your library account.',
                'token'      => $token,
                'token_type' => 'Bearer',
                'user'       => array_merge($memberAuth->only([
                    'member_auth_id', 'username', 'account_type', 'account_status', 'is_verified',
                ]), ['profile' => $member]),
                'member'     => $member,
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            throw ValidationException::withMessages([
                'student_id_number' => 'Registration failed. Please try again.',
            ]);
        }
    }

    // ─────────────────────────────────────────────────────────────────
    // POST /api/logout
    // ─────────────────────────────────────────────────────────────────
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully.']);
    }

    // ─────────────────────────────────────────────────────────────────
    // GET /api/user   (current authenticated user)
    // ─────────────────────────────────────────────────────────────────
    public function user(Request $request)
    {
        /** @var MemberAuth $auth */
        $auth    = $request->user();
        $profile = strtolower($auth->account_type) === 'member' || strtolower($auth->account_type) === 'student'
            ? $auth->member
            : $auth->librarian;

        return response()->json(array_merge($auth->only([
            'member_auth_id', 'username', 'account_type',
            'account_status', 'profile_image', 'is_verified',
        ]), [
            'profile' => $profile,
            'member'  => $auth->member,
        ]));
    }
}
