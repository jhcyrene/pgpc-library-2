<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\MemberAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthenticatedSessionController extends Controller
{
    /**
     * Canonical account-type groups used across portals and middleware.
     *
     * Any variation stored in the database (e.g. "Admin", "Administrator",
     * "Student", "Member") is normalised to lowercase before comparison so
     * that casing mismatches never lock a user out.
     */
    private const STAFF_TYPES = ['administrator', 'admin', 'librarian'];
    private const STUDENT_TYPES = ['member', 'student'];

    /**
     * Display the login view.
     */
    public function create()
    {
        if (Auth::guard('member')->check()) {
            return $this->redirectAuthenticatedUser();
        }

        return view('auth.student.login');
    }

    /**
     * Display the shared administrator and librarian login view.
     */
    public function createStaff()
    {
        if (Auth::guard('member')->check()) {
            return $this->redirectAuthenticatedUser();
        }

        return view('auth.staff.login');
    }

    /**
     * Redirect legacy role-specific login URLs to the shared staff page.
     */
    public function redirectToStaffLogin()
    {
        return redirect()->route('staff.login');
    }

    public function storeStudent(LoginRequest $request)
    {
        return $this->authenticateForPortal(
            $request,
            self::STUDENT_TYPES,
            route('student.dashboard'),
            true,
        );
    }

    public function storeStaff(LoginRequest $request)
    {
        return $this->authenticateForPortal(
            $request,
            self::STAFF_TYPES,
            null,
        );
    }

    /**
     * Authenticate an account only through its assigned portal.
     */
    private function authenticateForPortal(
        LoginRequest $request,
        array $allowedTypes,
        ?string $defaultRoute,
        bool $useIntendedUrl = false,
    ) {
        $credentials = $request->validated();

        $user = MemberAuth::with(['member', 'librarian'])
            ->where('username', $credentials['login'])
            ->orWhereHas('member', function ($query) use ($credentials) {
                $query->where('student_id_number', $credentials['login']);
            })
            ->first();

        if ($user && Hash::check($credentials['password'], $user->password_hash)) {
            $type = strtolower((string) $user->account_type);

            if (! in_array($type, $allowedTypes, true)) {
                return back()->withErrors([
                    'login' => 'This account cannot sign in through this portal.',
                ])->onlyInput('login');
            }

            // Validate broken relationships safely
            if (
                (in_array($type, self::STUDENT_TYPES, true) && ! $user->member_id) ||
                (in_array($type, self::STAFF_TYPES, true) && ! $user->librarian_id) ||
                ($user->member_id && $user->librarian_id) ||
                ! in_array($type, [...self::STAFF_TYPES, ...self::STUDENT_TYPES], true)
            ) {
                return back()->withErrors([
                    'login' => 'Your account configuration is invalid. Please contact the library administrator.',
                ])->onlyInput('login');
            }

            // Check account status
            $status = strtolower($user->account_status);
            if ($status !== 'active') {
                return back()->withErrors([
                    'login' => 'Your account is currently unavailable. Please contact the library administrator.',
                ])->onlyInput('login');
            }

            Auth::guard('member')->login($user, $request->boolean('remember'));

            $request->session()->regenerate();

            // Update user tracking
            $user->last_login = now();
            $user->last_login_at = now();
            $user->last_modified = now();
            $user->failed_attempts = 0;
            $user->save();

            $destination = $defaultRoute ?? $this->dashboardRouteFor($type);

            return $useIntendedUrl
                ? redirect()->intended($destination)
                : redirect()->to($destination);
        }

        if ($user) {
            $user->increment('failed_attempts');
        }

        return back()->withErrors([
            'login' => 'The username or password is incorrect.',
        ])->onlyInput('login');
    }

    private function redirectAuthenticatedUser()
    {
        $accountType = strtolower((string) Auth::guard('member')->user()?->account_type);

        return redirect()->intended($this->dashboardRouteFor($accountType));
    }

    private function dashboardRouteFor(string $accountType): string
    {
        return match (true) {
            in_array($accountType, self::STUDENT_TYPES, true) => route('student.dashboard'),
            $accountType === 'librarian' => route('librarian.dashboard'),
            in_array($accountType, ['administrator', 'admin'], true) => route('admin.dashboard'),
            default => route('home'),
        };
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        Auth::guard('member')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
