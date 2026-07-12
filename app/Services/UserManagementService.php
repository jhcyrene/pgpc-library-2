<?php

namespace App\Services;

use App\Models\Member;
use App\Models\Librarian;
use App\Models\MemberAuth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserManagementService
{
    /**
     * Create a new Member and their associated account.
     */
    public function createMember(array $profileData, ?array $authData = null): Member
    {
        return DB::transaction(function () use ($profileData, $authData) {
            $member = Member::create($profileData);

            if ($authData && ($authData['create_account'] ?? false)) {
                $this->createMemberAccount($member, $authData);
            }

            return $member;
        });
    }

    /**
     * Update a Member and their associated account.
     */
    public function updateMember(Member $member, array $profileData, ?array $authData = null): Member
    {
        return DB::transaction(function () use ($member, $profileData, $authData) {
            $member->update($profileData);

            if ($authData) {
                if ($member->memberAuth) {
                    $this->updateAccount($member->memberAuth, $authData);
                } elseif ($authData['create_account'] ?? false) {
                    $this->createMemberAccount($member, $authData);
                }
            }

            return $member;
        });
    }

    /**
     * Create a new Librarian and their associated account.
     */
    public function createLibrarian(array $profileData, array $authData): Librarian
    {
        return DB::transaction(function () use ($profileData, $authData) {
            $librarian = Librarian::create($profileData);
            
            if ($authData['create_account'] ?? true) {
                $this->createLibrarianAccount($librarian, $authData);
            }

            return $librarian;
        });
    }

    /**
     * Update a Librarian and their associated account.
     */
    public function updateLibrarian(Librarian $librarian, array $profileData, ?array $authData = null): Librarian
    {
        return DB::transaction(function () use ($librarian, $profileData, $authData) {
            $librarian->update($profileData);

            if ($authData) {
                if ($librarian->memberAuth) {
                    $this->updateAccount($librarian->memberAuth, $authData);
                } elseif ($authData['create_account'] ?? false) {
                    $this->createLibrarianAccount($librarian, $authData);
                }
            }

            return $librarian;
        });
    }

    /**
     * Create an account for a Member.
     */
    public function createMemberAccount(Member $member, array $data): MemberAuth
    {
        return MemberAuth::create([
            'member_id' => $member->member_id,
            'librarian_id' => null,
            'account_type' => $data['account_type'] ?? 'Member',
            'account_status' => $data['account_status'] ?? 'Active',
            'username' => $data['username'],
            'password_hash' => Hash::make($data['password']),
            'last_modified' => now(),
            'is_verified' => true,
        ]);
    }

    /**
     * Create an account for a Librarian.
     */
    public function createLibrarianAccount(Librarian $librarian, array $data): MemberAuth
    {
        return MemberAuth::create([
            'member_id' => null,
            'librarian_id' => $librarian->librarian_id,
            'account_type' => $data['account_type'] ?? 'Librarian',
            'account_status' => $data['account_status'] ?? 'Active',
            'username' => $data['username'],
            'password_hash' => Hash::make($data['password']),
            'last_modified' => now(),
            'is_verified' => true,
        ]);
    }

    /**
     * Update an existing MemberAuth account.
     */
    public function updateAccount(MemberAuth $account, array $data): MemberAuth
    {
        $updateData = [];

        if (isset($data['username'])) {
            $updateData['username'] = $data['username'];
        }
        if (isset($data['account_type'])) {
            $updateData['account_type'] = $data['account_type'];
        }
        if (isset($data['account_status'])) {
            $updateData['account_status'] = $data['account_status'];
        }

        if (!empty($updateData)) {
            $updateData['last_modified'] = now();
            $account->update($updateData);
        }

        return $account;
    }

    /**
     * Change the status of an account.
     */
    public function changeAccountStatus(MemberAuth $account, string $status): MemberAuth
    {
        $account->update([
            'account_status' => $status,
            'last_modified' => now(),
        ]);

        return $account;
    }

    /**
     * Unlock an account and reset its failed attempts.
     */
    public function unlockAccount(MemberAuth $account): MemberAuth
    {
        $account->update([
            'account_status' => 'Active',
            'failed_attempts' => 0,
            'last_modified' => now(),
        ]);

        return $account;
    }

    /**
     * Reset the password of an account safely.
     */
    public function resetPassword(MemberAuth $account, string $password): void
    {
        $account->update([
            'password_hash' => Hash::make($password),
            'password_changed_at' => now(),
            'password_token' => null,
            'token_expiry' => null,
            'last_modified' => now(),
            'failed_attempts' => 0,
        ]);
    }
}
