<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\BookBorrow;
use App\Models\BookData;
use App\Models\Member;
use App\Models\MemberAuth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class StudentDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_dashboard_renders_title_case_borrow_data_in_admin_aligned_sections(): void
    {
        $member = Member::factory()->create(['first_name' => 'Maria']);
        $account = MemberAuth::factory()->create([
            'member_id' => $member->member_id,
            'account_type' => 'Member',
            'account_status' => 'Active',
            'username' => 'maria.student',
            'password_hash' => Hash::make('password123'),
        ]);
        $bookData = BookData::factory()->create(['book_title' => 'Database Systems Handbook']);
        $book = Book::factory()->create([
            'book_data_id' => $bookData->book_data_id,
            'status' => 'Borrowed',
        ]);
        BookBorrow::factory()->create([
            'book_id' => $book->book_id,
            'member_id' => $member->member_id,
            'librarian_id' => null,
            'status' => 'Borrowed',
            'issue_date' => now()->subDay(),
            'due_date' => now()->addDays(6),
            'return_date' => null,
        ]);

        $this->actingAs($account, 'member')
            ->get(route('student.dashboard'))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Student/Dashboard')
                ->where('studentPortal.student.firstName', 'Maria')
                ->where('studentPortal.routes.catalog', route('opac.index'))
                ->where('dashboard.summary.activeBorrows', 1)
                ->has('dashboard.currentBorrows', 1)
                ->where('dashboard.currentBorrows.0.title', 'Database Systems Handbook')
                ->where('dashboard.currentBorrows.0.isOverdue', false)
            );
    }
}
