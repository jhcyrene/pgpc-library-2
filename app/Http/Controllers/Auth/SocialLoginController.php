<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\MemberAuth;
use App\Models\Member;
use App\Models\Librarian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Exception;

class SocialLoginController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        try {
            $socialUser = Socialite::driver('google')->user();
        } catch (Exception $e) {
            return redirect()->route('login')->with('error', 'Google authentication failed: ' . $e->getMessage());
        }

        $userEmail = strtolower(trim((string) $socialUser->getEmail()));
        $googleId = (string) $socialUser->getId();
        $currentAuth = Auth::guard('member')->user();

        // 1. If user is ALREADY logged in, link Google account to current session
        if ($currentAuth) {
            $existingOther = MemberAuth::where('provider', 'google')
                ->where('provider_id', $googleId)
                ->where('auth_id', '!=', $currentAuth->auth_id)
                ->first();

            if ($existingOther) {
                return redirect()->route('student.account-settings.edit')
                    ->with('error', 'This Google account is already linked to another library user.');
            }

            $currentAuth->update([
                'provider' => 'google',
                'provider_id' => $googleId,
            ]);

            return redirect()->route('student.account-settings.edit')
                ->with('success', 'Google account linked successfully!');
        }

        // 2. Try to find an existing MemberAuth account with this social provider ID
        $auth = MemberAuth::where('provider', 'google')
            ->where('provider_id', $googleId)
            ->first();

        if ($auth) {
            return $this->loginAndRedirect($auth);
        }

        // 3. Check if a Member or Librarian exists with this email (case-insensitive)
        $member = Member::whereRaw('LOWER(email) = ?', [$userEmail])->first();
        $librarian = !$member ? Librarian::whereRaw('LOWER(email) = ?', [$userEmail])->first() : null;

        if ($member || $librarian) {
            $auth = $member 
                ? MemberAuth::where('member_id', $member->member_id)->first()
                : MemberAuth::where('librarian_id', $librarian->librarian_id)->first();

            if ($auth) {
                // Link Google provider ID cleanly to existing member account
                $auth->provider = 'google';
                $auth->provider_id = $googleId;
                $auth->save();

                return $this->loginAndRedirect($auth);
            } else {
                // Member/Librarian record exists, but MemberAuth record was missing: create MemberAuth for existing user
                $auth = MemberAuth::create([
                    'member_id' => $member?->member_id,
                    'librarian_id' => $librarian?->librarian_id,
                    'username' => $userEmail,
                    'account_type' => $librarian ? 'librarian' : 'student',
                    'password_hash' => null,
                    'provider' => 'google',
                    'provider_id' => $googleId,
                    'account_status' => 'Active',
                    'is_verified' => true
                ]);

                return $this->loginAndRedirect($auth);
            }
        }

        // 4. New Registration: Create student member account and auth record atomically
        $nameParts = explode(' ', (string) $socialUser->getName(), 2);
        $firstName = $nameParts[0] ?? 'Google';
        $lastName = $nameParts[1] ?? 'User';

        $auth = DB::transaction(function () use ($googleId, $userEmail, $firstName, $lastName) {
            $existingMember = Member::whereRaw('LOWER(email) = ?', [$userEmail])->first();

            if (!$existingMember) {
                $existingMember = Member::create([
                    'student_id_number' => 'G-' . Str::upper(Str::random(8)),
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'email' => $userEmail,
                    'member_status_id' => 1,
                ]);
            }

            $existingAuth = MemberAuth::where('member_id', $existingMember->member_id)->first();
            if ($existingAuth) {
                $existingAuth->provider = 'google';
                $existingAuth->provider_id = $googleId;
                $existingAuth->save();
                return $existingAuth;
            }

            return MemberAuth::create([
                'member_id' => $existingMember->member_id,
                'username' => $userEmail,
                'account_type' => 'student',
                'password_hash' => null,
                'provider' => 'google',
                'provider_id' => $googleId,
                'account_status' => 'Active',
                'is_verified' => true
            ]);
        });

        // Redirect newly registered Google user to complete profile details
        return $this->loginAndRedirect($auth, true);
    }

    public function showLinkForm(Request $request)
    {
        if (!$request->session()->has('oauth_user')) {
            return redirect()->route('login');
        }

        return view('auth.link', [
            'email' => $request->session()->get('oauth_user.email')
        ]);
    }

    public function linkAccount(Request $request)
    {
        $request->validate([
            'password' => 'required|string'
        ]);

        if (!$request->session()->has('oauth_user')) {
            return redirect()->route('login');
        }

        $sessionData = $request->session()->get('oauth_user');
        $auth = MemberAuth::find($sessionData['auth_id']);

        if (!$auth || !Hash::check($request->password, $auth->password_hash)) {
            return back()->withErrors(['password' => 'Incorrect password for this account.']);
        }

        $auth->provider = $sessionData['provider'];
        $auth->provider_id = $sessionData['provider_id'];
        $auth->save();

        $request->session()->forget('oauth_user');

        return $this->loginAndRedirect($auth);
    }

    private function loginAndRedirect($auth, $isNewUser = false)
    {
        Auth::guard('member')->login($auth, true);

        // Update tracking timestamps
        $auth->last_login = now();
        $auth->last_login_at = now();
        $auth->last_modified = now();
        $auth->failed_attempts = 0;
        $auth->save();

        if ($isNewUser) {
            return redirect()->route('student.profile.complete')->with('status', 'Welcome to PGPC Library! Please complete your student profile information.');
        }

        $type = strtolower((string) $auth->account_type);

        return match (true) {
            in_array($type, ['student', 'member'], true) => redirect()->route('student.dashboard'),
            $type === 'librarian' => redirect()->route('librarian.dashboard'),
            in_array($type, ['administrator', 'admin'], true) => redirect()->route('admin.dashboard'),
            default => redirect()->route('home'),
        };
    }
}
