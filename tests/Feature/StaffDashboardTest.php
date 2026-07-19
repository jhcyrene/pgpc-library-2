<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\BookBorrow;
use App\Models\BookData;
use App\Models\BookRequest;
use App\Models\BookRequestStatus;
use App\Models\Librarian;
use App\Models\Member;
use App\Models\MemberAuth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class StaffDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_administrator_dashboard_uses_explicit_react_props_and_preserves_stats_json(): void
    {
        $staff = Librarian::factory()->create([
            'first_name' => 'Amina',
            'last_name' => 'Admin',
        ]);
        $administrator = MemberAuth::factory()->create([
            'librarian_id' => $staff->librarian_id,
            'username' => 'amina.admin',
            'password_hash' => Hash::make('password123'),
            'account_type' => 'Administrator',
            'account_status' => 'Active',
        ]);

        $member = Member::factory()->create([
            'first_name' => 'Student',
            'last_name' => 'Borrower',
        ]);
        MemberAuth::factory()->create([
            'member_id' => $member->member_id,
            'username' => 'active.borrower',
            'password_hash' => Hash::make('password123'),
            'account_type' => 'Member',
            'account_status' => 'Active',
        ]);

        $bookData = BookData::factory()->create(['book_title' => 'Staff Dashboard Title']);
        $book = Book::factory()->create([
            'book_data_id' => $bookData->book_data_id,
            'status' => 'Borrowed',
        ]);
        BookBorrow::create([
            'book_id' => $book->book_id,
            'member_id' => $member->member_id,
            'librarian_id' => $staff->librarian_id,
            'issue_date' => now()->subDay(),
            'due_date' => now()->addDays(6),
            'return_date' => null,
            'status' => 'Borrowed',
        ]);

        $pending = BookRequestStatus::create(['status_name' => 'Pending']);
        BookRequest::create([
            'book_data_id' => $bookData->book_data_id,
            'member_id' => $member->member_id,
            'book_request_status_id' => $pending->book_request_status_id,
            'request_date' => now(),
            'pickup_date' => now()->addDay(),
        ]);

        $this->actingAs($administrator, 'member')
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Staff/Dashboard')
                ->where('staffPortal.staff.firstName', 'Amina')
                ->where('staffPortal.staff.roleLabel', 'Administrator')
                ->where('staffPortal.staff.isAdministrator', true)
                ->where('staffPortal.routes.dashboard', route('admin.dashboard'))
                ->where('staffPortal.routes.users', route('admin.users.index'))
                ->where('dashboard.summary.totalTitles', 1)
                ->where('dashboard.summary.totalCopies', 1)
                ->where('dashboard.summary.activeMembers', 1)
                ->where('dashboard.summary.borrowedItems', 1)
                ->where('dashboard.summary.overdueItems', 0)
                ->where('dashboard.summary.pendingReservations', 1)
                ->has('dashboard.currentBorrowers', 1)
                ->where('dashboard.currentBorrowers.0.memberName', 'Student Borrower')
                ->where('dashboard.currentBorrowers.0.bookTitle', 'Staff Dashboard Title')
                ->has('dashboard.mostBorrowedItems', 1)
                ->where('dashboard.mostBorrowedItems.0.borrowCount', 1));

        $this->actingAs($administrator, 'member')
            ->getJson(route('admin.dashboard.stats'))
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('stats.total_titles', 1)
            ->assertJsonPath('current_borrowers.0.book_title', 'Staff Dashboard Title');
    }
}
