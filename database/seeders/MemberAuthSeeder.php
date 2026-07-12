<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\MemberAuth;
use App\Models\Member;
use App\Models\Librarian;

class MemberAuthSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin account
        $admin = Librarian::where('position', 'System Administrator')->first();
        if ($admin) {
            MemberAuth::firstOrCreate(
                ['username' => 'admin'],
                [
                    'librarian_id' => $admin->librarian_id,
                    'account_type' => 'Admin',
                    'password_hash' => Hash::make('password'), // For local development only
                ]
            );
        }

        // 2. Librarian accounts
        $librarians = Librarian::where('position', '!=', 'System Administrator')->get();
        $counter = 1;
        foreach ($librarians as $lib) {
            MemberAuth::firstOrCreate(
                ['username' => 'librarian0' . $counter],
                [
                    'librarian_id' => $lib->librarian_id,
                    'account_type' => 'Librarian',
                    'password_hash' => Hash::make('password'), // For local development only
                ]
            );
            $counter++;
        }

        // 3. Member accounts
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
