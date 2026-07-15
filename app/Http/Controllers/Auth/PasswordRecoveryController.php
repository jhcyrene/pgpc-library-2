<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\MemberAuth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;
use Throwable;

class PasswordRecoveryController extends Controller
{
    public function create(): View
    {
        return view('auth.student.forgot-password');
    }

    public function sendCode(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email:rfc', 'max:255'],
        ]);

        $email = strtolower(trim($validated['email']));
        $member = Member::with('memberAuth')
            ->whereRaw('LOWER(email) = ?', [$email])
            ->first();

        if (!$member?->memberAuth) {
            return back()->with('status', 'If that email belongs to a student account, password recovery instructions will be sent.');
        }

        $code = (string) random_int(100000, 999999);
        $account = $member->memberAuth;
        $account->forceFill([
            'password_token' => Hash::make($code),
            'token_expiry' => now()->addMinutes(10),
        ])->save();

        try {
            Mail::raw(
                "Your PGPC Library password reset code is {$code}. It expires in 10 minutes. If you did not request this code, you can ignore this message.",
                function ($message) use ($member): void {
                    $message->to($member->email, trim($member->first_name . ' ' . $member->last_name))
                        ->subject('PGPC Library password reset code');
                },
            );
        } catch (Throwable $exception) {
            report($exception);
            $account->forceFill(['password_token' => null, 'token_expiry' => null])->save();

            return back()->withErrors([
                'email' => 'The reset code could not be sent right now. Please try again or contact the library.',
            ])->withInput();
        }

        $request->session()->put([
            'password_reset_account_id' => $account->getKey(),
            'password_reset_email' => $member->email,
        ]);
        $request->session()->forget('password_reset_verified');

        return redirect()->route('forgot-password.otp')
            ->with('status', 'A six-digit verification code was sent to your email.');
    }

    public function showOtp(Request $request): View|RedirectResponse
    {
        if (!$request->session()->has('password_reset_account_id')) {
            return redirect()->route('forgot-password');
        }

        return view('auth.student.otp');
    }

    public function verifyCode(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'digits' => ['required', 'array', 'size:6'],
            'digits.*' => ['required', 'digits:1'],
        ]);

        $account = MemberAuth::find($request->session()->get('password_reset_account_id'));
        $code = implode('', $validated['digits']);

        if (
            !$account ||
            !$account->password_token ||
            !$account->token_expiry ||
            $account->token_expiry->isPast() ||
            !Hash::check($code, $account->password_token)
        ) {
            return back()->withErrors([
                'digits' => 'The verification code is invalid or has expired.',
            ]);
        }

        $request->session()->put('password_reset_verified', true);

        return redirect()->route('forgot-password.reset');
    }

    public function showReset(Request $request): View|RedirectResponse
    {
        if (!$request->session()->get('password_reset_verified')) {
            return redirect()->route('forgot-password');
        }

        return view('auth.student.reset-password');
    }

    public function reset(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
        ]);

        $account = MemberAuth::find($request->session()->get('password_reset_account_id'));

        if (!$request->session()->get('password_reset_verified') || !$account) {
            return redirect()->route('forgot-password');
        }

        $account->forceFill([
            'password_hash' => Hash::make($validated['password']),
            'password_changed_at' => now(),
            'password_token' => null,
            'token_expiry' => null,
            'failed_attempts' => 0,
        ])->save();

        $request->session()->forget([
            'password_reset_account_id',
            'password_reset_email',
            'password_reset_verified',
        ]);

        return redirect()->route('login')->with('status', 'Your password has been reset. You can now sign in.');
    }
}
