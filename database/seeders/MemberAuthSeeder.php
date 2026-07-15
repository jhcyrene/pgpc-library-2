<?php

namespace Database\Seeders;

use App\Models\Librarian;
use App\Models\Member;
use App\Models\MemberAuth;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MemberAuthSeeder extends Seeder
{
    private const ADMIN_USERNAME = 'admin';

    private const ADMIN_PASSWORD = 'Admin@12345';

    private const LIBRARIAN_USERNAME = 'librarian';

    private const LIBRARIAN_PASSWORD = 'Librarian@12345';

    public function run(): void
    {
        // Local-development staff accounts. Never use these credentials in production.
        $staffAccounts = [
            [
                'employee_number' => 'EMP-0001',
                'username' => self::ADMIN_USERNAME,
                'password' => self::ADMIN_PASSWORD,
                'account_type' => 'Administrator',
            ],
            [
                'employee_number' => 'EMP-0002',
                'username' => self::LIBRARIAN_USERNAME,
                'password' => self::LIBRARIAN_PASSWORD,
                'account_type' => 'Librarian',
            ],
        ];

        foreach ($staffAccounts as $staffAccount) {
            $librarian = Librarian::where('employee_number', $staffAccount['employee_number'])->first();

            if (! $librarian) {
                $this->command?->warn("Librarian {$staffAccount['employee_number']} not found – skipping.");

                continue;
            }

            $account = MemberAuth::withTrashed()->updateOrCreate(
                ['librarian_id' => $librarian->librarian_id],
                [
                    'member_id' => null,
                    'username' => $staffAccount['username'],
                    'account_type' => $staffAccount['account_type'],
                    'account_status' => 'Active',
                    'password_hash' => Hash::make($staffAccount['password']),
                    'failed_attempts' => 0,
                    'is_verified' => true,
                    'password_changed_at' => now(),
                    'last_modified' => now(),
                ]
            );

            if ($account->trashed()) {
                $account->restore();
            }

            $this->command?->info("Staff account [{$staffAccount['username']}] ready (auth ID: {$account->member_auth_id}).");
        }

        // Student/member accounts
        $members = Member::all();
        foreach ($members as $member) {
            MemberAuth::firstOrCreate(
                ['username' => $member->student_id_number],
                [
                    'member_id' => $member->member_id,
                    'account_type' => 'Member',
                    'password_hash' => Hash::make('password'), // For local development only
                ]
            );
        }
    }
}
