<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

use App\Models\MemberAuth;
use App\Http\Requests\UpdateMemberAuthRequest;
use App\Http\Requests\ResetUserPasswordRequest;
use App\Services\UserManagementService;
use Illuminate\Http\Request;

class MemberAuthController extends Controller
{
    protected $userService;

    public function __construct(UserManagementService $userService)
    {
        $this->userService = $userService;
    }

    public function updateStatus(UpdateMemberAuthRequest $request, MemberAuth $memberAuth)
    {
        $this->userService->changeAccountStatus($memberAuth, $request->validated('account_status'));

        return back()->with('success', 'Account status updated successfully.');
    }

    public function unlock(MemberAuth $memberAuth)
    {
        $this->userService->unlockAccount($memberAuth);

        return back()->with('success', 'Account unlocked successfully.');
    }

    public function resetPassword(ResetUserPasswordRequest $request, MemberAuth $memberAuth)
    {
        $this->userService->resetPassword($memberAuth, $request->validated('password'));

        return back()->with('success', 'Password reset successfully.');
    }
}
