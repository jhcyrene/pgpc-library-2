<?php

namespace Tests\Feature\Student;

use App\Models\Author;
use App\Models\Book;
use App\Models\BookBorrow;
use App\Models\BookData;
use App\Models\BookDetail;
use App\Models\BookRequest;
use App\Models\BookRequestStatus;
use App\Models\Member;
use App\Models\MemberAuth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class StudentPortalDataFlowTest extends TestCase
{
    use RefreshDatabase;

    private Member $member;

    protected function setUp(): void
    {
        parent::setUp();

        $this->member = Member::factory()->create();
        $account = MemberAuth::factory()->create([
            'member_id' => $this->member->member_id,
            'username' => 'student_flow_test',
            'password_hash' => Hash::make('password123'),
            'account_type' => 'Member',
            'account_status' => 'Active',
        ]);

        $this->actingAs($account, 'member');
    }

    public function test_borrow_pages_use_seeded_statuses_and_render_book_titles(): void
    {
        $borrowedTitle = BookData::factory()->create(['book_title' => 'Currently Borrowed Title']);
        $borrowedCopy = Book::factory()->create(['book_data_id' => $borrowedTitle->book_data_id]);
        BookBorrow::create([
            'book_id' => $borrowedCopy->book_id,
            'member_id' => $this->member->member_id,
            'librarian_id' => null,
            'issue_date' => now()->subDay(),
            'due_date' => now()->addDays(6),
            'return_date' => null,
            'status' => 'Borrowed',
        ]);

        $overdueTitle = BookData::factory()->create(['book_title' => 'Overdue Active Title']);
        $overdueCopy = Book::factory()->create(['book_data_id' => $overdueTitle->book_data_id]);
        BookBorrow::create([
            'book_id' => $overdueCopy->book_id,
            'member_id' => $this->member->member_id,
            'librarian_id' => null,
            'issue_date' => now()->subDays(10),
            'due_date' => now()->subDays(3),
            'return_date' => null,
            'status' => 'Overdue',
        ]);

        $returnedTitle = BookData::factory()->create(['book_title' => 'Returned History Title']);
        $returnedCopy = Book::factory()->create(['book_data_id' => $returnedTitle->book_data_id]);
        BookBorrow::create([
            'book_id' => $returnedCopy->book_id,
            'member_id' => $this->member->member_id,
            'librarian_id' => null,
            'issue_date' => now()->subDays(20),
            'due_date' => now()->subDays(13),
            'return_date' => now()->subDays(14),
            'status' => 'Returned',
        ]);

        $this->get(route('student.borrow-transactions.current'))
            ->assertOk()
            ->assertSee('Currently Borrowed Title')
            ->assertSee('Overdue Active Title')
            ->assertDontSee('Returned History Title');

        $this->get(route('student.overdue-items.index'))
            ->assertOk()
            ->assertSee('Overdue Active Title')
            ->assertDontSee('Currently Borrowed Title');

        $this->get(route('student.borrow-transactions.history'))
            ->assertOk()
            ->assertSee('Returned History Title');
    }

    public function test_reservation_flow_uses_title_case_statuses_and_real_book_fields(): void
    {
        $pending = BookRequestStatus::create(['status_name' => 'Pending']);
        $approved = BookRequestStatus::create(['status_name' => 'Approved']);
        $cancelled = BookRequestStatus::create(['status_name' => 'Cancelled']);

        $bookData = BookData::factory()->create(['book_title' => 'Reservation Flow Title']);
        $author = Author::factory()->create([
            'first_name' => 'Ada',
            'last_name' => 'Lovelace',
        ]);
        $bookData->authors()->attach($author->author_id, ['role' => 'Main']);
        BookDetail::factory()->create([
            'book_data_id' => $bookData->book_data_id,
            'isbn' => '9781234567897',
            'publication_year' => 2024,
        ]);

        $this->get(route('student.reservations.create', $bookData))
            ->assertOk()
            ->assertSee('Reservation Flow Title')
            ->assertSee('Ada Lovelace')
            ->assertSee('9781234567897')
            ->assertSee('2024');

        $this->post(route('student.reservations.store', $bookData), [
            'remarks' => 'Hold this title for me.',
        ])->assertRedirect();

        $reservation = BookRequest::query()->sole();
        $this->assertSame($pending->book_request_status_id, $reservation->book_request_status_id);

        $approvedAt = now()->startOfMinute();
        $reservation->update([
            'book_request_status_id' => $approved->book_request_status_id,
            'approved_at' => $approvedAt,
        ]);

        $this->get(route('student.reservations.show', $reservation))
            ->assertOk()
            ->assertSee('Reservation Flow Title')
            ->assertSee('Ada Lovelace')
            ->assertSee('#'.$reservation->book_request_id)
            ->assertSee($approvedAt->format('F j, Y, g:i a'));

        $this->patch(route('student.reservations.cancel', $reservation))->assertRedirect();

        $this->assertDatabaseHas('book_requests', [
            'book_request_id' => $reservation->book_request_id,
            'book_request_status_id' => $cancelled->book_request_status_id,
        ]);
    }

    public function test_check_availability_returns_unavailable_dates_efficiently(): void
    {
        $bookData = BookData::factory()->create();
        
        $response = $this->getJson(route('student.reservations.check-availability', [
            'bookData' => $bookData->book_data_id,
            'year' => 2026,
            'month' => 7,
        ]));

        $response->assertOk()
            ->assertJson([
                'success' => true,
            ])
            ->assertJsonStructure(['success', 'unavailable_dates']);
    }

    public function test_profile_update_persists_the_contact_number_field(): void
    {
        $this->put(route('student.profile.update'), [
            'first_name' => $this->member->first_name,
            'last_name' => $this->member->last_name,
            'email' => $this->member->email,
            'contact_num' => '09171234567',
        ])->assertRedirect(route('student.profile.show'));

        $this->assertDatabaseHas('members', [
            'member_id' => $this->member->member_id,
            'contact_num' => '09171234567',
        ]);

        $this->get(route('student.profile.show'))
            ->assertOk()
            ->assertSee('09171234567');
    }
}
