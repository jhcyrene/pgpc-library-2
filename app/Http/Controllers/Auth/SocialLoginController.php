<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\MemberAuth;
use App\Models\Member;
use App\Models\Librarian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
            return redirect()->route('login')->with('error', 'Google authentication failed.');
        }

        // 1. Try to find an existing MemberAuth account with this social provider ID
        $auth = MemberAuth::where('provider', 'google')
            ->where('provider_id', $socialUser->getId())
            ->first();

        if ($auth) {
            return $this->loginAndRedirect($auth);
        }

        // 2. Check if a Member or Librarian exists with this email
        $member = Member::where('email', $socialUser->getEmail())->first();
        $librarian = !$member ? Librarian::where('email', $socialUser->getEmail())->first() : null;

        if ($member || $librarian) {
            $auth = $member 
                ? MemberAuth::where('member_id', $member->member_id)->first()
                : MemberAuth::where('librarian_id', $librarian->librarian_id)->first();

            if ($auth) {
                // If provider isn't set on the auth account yet:
                if (!$auth->provider) {
                    // If account has a password set (standard email/password registration), prompt to verify password once
                    if (!empty($auth->password_hash)) {
                        $request->session()->put('oauth_user', [
                            'email' => $socialUser->getEmail(),
                            'provider_id' => $socialUser->getId(),
                            'provider' => 'google',
                            'auth_id' => $auth->member_auth_id
                        ]);

                        return redirect()->route('auth.google.link')->with('info', 'An account with this email already exists. Please verify your password to link Google.');
                    }

                    // Otherwise (no password set, registered via Google previously), auto-link provider
                    $auth->provider = 'google';
                    $auth->provider_id = $socialUser->getId();
                    $auth->save();
                }

                return $this->loginAndRedirect($auth);
            }
        }

        // 3. New Registration: Create student member account
        $nameParts = explode(' ', $socialUser->getName(), 2);
        $firstName = $nameParts[0] ?? 'Google';
        $lastName = $nameParts[1] ?? 'User';

        $newMember = Member::create([
            'student_id_number' => 'G-' . Str::upper(Str::random(8)),
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $socialUser->getEmail(),
            'member_status_id' => 1,
        ]);

        $auth = MemberAuth::create([
            'member_id' => $newMember->member_id,
            'username' => $newMember->email,
            'account_type' => 'student',
            'provider' => 'google',
            'provider_id' => $socialUser->getId(),
            'account_status' => 'Active',
            'is_verified' => true
        ]);

        // Redirect newly registered Google user to complete profile academic details
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

        $oauthData = $request->session()->get('oauth_user');
        $auth = MemberAuth::find($oauthData['auth_id']);

        if (!$auth || !Hash::check($request->password, $auth->password_hash)) {
            return back()->withErrors(['password' => 'The password you entered is incorrect.']);
        }

        // Link OAuth credentials
        $auth->provider = $oauthData['provider'];
        $auth->provider_id = $oauthData['provider_id'];
        $auth->save();

        $request->session()->forget('oauth_user');

        return $this->loginAndRedirect($auth);
    }

    private function loginAndRedirect(MemberAuth $auth, bool $isNewRegistration = false)
    {
        if (strtolower($auth->account_status) !== 'active') {
            return redirect()->route('login')->with('error', 'Your account is disabled.');
        }

        Auth::guard('member')->login($auth, true);

        $auth->last_login = now();
        $auth->last_login_at = now();
        $auth->last_modified = now();
        $auth->failed_attempts = 0;
        $auth->save();

        if ($isNewRegistration) {
            return redirect()->route('student.profile.edit')->with('success', 'Account created with Google! Please complete your course/program and year level details.');
        }

        $type = strtolower((string) $auth->account_type);
        return redirect()->to(match (true) {
            in_array($type, ['member', 'student'], true) => route('student.dashboard'),
            $type === 'librarian' => route('librarian.dashboard'),
            in_array($type, ['administrator', 'admin'], true) => route('admin.dashboard'),
            default => route('home'),
        });
    }
}
