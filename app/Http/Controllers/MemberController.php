<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

use App\Models\Member;
use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMemberRequest;
use App\Services\UserManagementService;

class MemberController extends Controller
{
    protected $userService;

    public function __construct(UserManagementService $userService)
    {
        $this->userService = $userService;
    }

    public function create()
    {
        return view('admin.users.create', ['type' => 'member']);
    }

    public function store(StoreMemberRequest $request)
    {
        $profileData = $request->only(['student_id_number', 'first_name', 'middle_name', 'last_name', 'email', 'contact_num', 'program', 'year_level']);
        $authData = $request->only(['create_account', 'username', 'password', 'account_type', 'account_status']);
        
        $member = $this->userService->createMember($profileData, $request->boolean('create_account') ? $authData : null);

        return redirect()->route('admin.users.show', ['type' => 'member', 'id' => $member->member_id])
            ->with('success', 'Member created successfully.');
    }

    public function edit(Member $member)
    {
        $member->load('memberAuth');
        return view('admin.users.edit', ['type' => 'member', 'user' => $member]);
    }

    public function update(UpdateMemberRequest $request, Member $member)
    {
        $profileData = $request->only(['student_id_number', 'first_name', 'middle_name', 'last_name', 'email', 'contact_num', 'program', 'year_level']);
        $authData = $request->only(['create_account', 'username', 'password', 'account_type', 'account_status']);
        
        if (empty($authData['password'])) {
            unset($authData['password']);
        }

        $authDataPass = ($request->boolean('create_account') || $member->memberAuth) ? $authData : null;

        $this->userService->updateMember($member, $profileData, $authDataPass);

        return redirect()->route('admin.users.show', ['type' => 'member', 'id' => $member->member_id])
            ->with('success', 'Member updated successfully.');
    }

    public function destroy(Member $member)
    {
        $hasActiveBorrows = $member->bookBorrows()->whereNull('date_returned')->exists();
        if ($hasActiveBorrows) {
            return back()->with('error', 'This member cannot be deleted because active borrowing records exist.');
        }

        $member->delete();
        if ($member->memberAuth) {
            $member->memberAuth->delete();
        }

        return redirect()->route('admin.users.index', ['type' => 'member'])
            ->with('success', 'Member deactivated/deleted successfully.');
    }
}
