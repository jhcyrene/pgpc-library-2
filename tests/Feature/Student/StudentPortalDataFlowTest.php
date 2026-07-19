<?php

namespace Tests\Feature\Student;

use App\Models\Author;
use App\Models\Book;
use App\Models\BookBorrow;
use App\Models\BookData;
use App\Models\BookDetail;
use App\Models\BookRequest;
use App\Models\BookRequestStatus;
use App\Models\FineDue;
use App\Models\FinePayment;
use App\Models\Member;
use App\Models\MemberAuth;
use App\Models\SavedItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Testing\AssertableInertia as Assert;
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
            ->assertInertia(fn (Assert $page) => $page
                ->component('Student/Borrows/Current')
                ->has('borrows.data', 2)
                ->where('borrows.data.0.title', 'Overdue Active Title')
                ->where('borrows.data.1.title', 'Currently Borrowed Title'));

        $this->get(route('student.overdue-items.index'))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Student/Borrows/Overdue')
                ->has('borrows.data', 1)
                ->where('borrows.data.0.title', 'Overdue Active Title')
                ->where('borrows.data.0.isOverdue', true));

        $this->get(route('student.borrow-transactions.history'))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Student/Borrows/History')
                ->has('borrows.data', 1)
                ->where('borrows.data.0.title', 'Returned History Title'));

        $this->get(route('student.borrow-transactions.index'))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Student/Borrows/Overview')
                ->has('borrowing.current', 2)
                ->has('borrowing.history', 1));
    }

    public function test_saved_items_render_explicit_props_and_can_be_removed_and_restored(): void
    {
        $bookData = BookData::factory()->create(['book_title' => 'Saved Reading Title']);
        $savedItem = SavedItem::create([
            'member_id' => $this->member->member_id,
            'book_data_id' => $bookData->book_data_id,
        ]);

        $this->get(route('student.saved-items.index'))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Student/SavedItems/Index')
                ->has('savedItems.data', 1)
                ->where('savedItems.data.0.id', $savedItem->saved_item_id)
                ->where('savedItems.data.0.bookId', $bookData->book_data_id)
                ->where('savedItems.data.0.title', 'Saved Reading Title')
                ->where('savedItems.data.0.actions.remove', route('student.saved-items.destroy', $bookData))
                ->where('savedItems.data.0.actions.reserve', route('student.reservations.create', $bookData)));

        $this->delete(route('student.saved-items.destroy', $bookData))
            ->assertRedirect()
            ->assertSessionHas('success', 'Title removed from your list.');

        $this->assertDatabaseMissing('saved_items', [
            'member_id' => $this->member->member_id,
            'book_data_id' => $bookData->book_data_id,
        ]);

        $this->postJson(route('student.saved-items.store', $bookData))
            ->assertOk()
            ->assertJson([
                'success' => true,
                'saved' => true,
                'message' => 'Title saved to your list.',
            ]);

        $this->assertDatabaseHas('saved_items', [
            'member_id' => $this->member->member_id,
            'book_data_id' => $bookData->book_data_id,
        ]);
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
            ->assertInertia(fn (Assert $page) => $page
                ->component('Student/Reservations/Create')
                ->where('book.id', $bookData->book_data_id)
                ->where('book.title', 'Reservation Flow Title')
                ->where('book.authors.0', 'Ada Lovelace')
                ->where('book.isbn', '9781234567897')
                ->where('book.publicationYear', 2024)
                ->where('eligibility.eligible', true)
                ->where('form.storeUrl', route('student.reservations.store', $bookData)));

        $this->post(route('student.reservations.store', $bookData), [
            'pickup_date' => now()->addDay()->toDateString(),
            'remarks' => 'Hold this title for me.',
        ])->assertRedirect()
            ->assertSessionHasNoErrors()
            ->assertSessionMissing('error');

        $reservation = BookRequest::query()->sole();
        $this->assertSame($pending->book_request_status_id, $reservation->book_request_status_id);

        $this->get(route('student.reservations.index'))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Student/Reservations/Index')
                ->has('reservations.data', 1)
                ->where('reservations.data.0.id', $reservation->book_request_id)
                ->where('reservations.data.0.book.title', 'Reservation Flow Title')
                ->where('reservations.data.0.status', 'Pending'));

        $approvedAt = now()->startOfMinute();
        $reservation->update([
            'book_request_status_id' => $approved->book_request_status_id,
            'approved_at' => $approvedAt,
        ]);

        $this->get(route('student.reservations.show', $reservation))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Student/Reservations/Show')
                ->where('reservation.id', $reservation->book_request_id)
                ->where('reservation.book.title', 'Reservation Flow Title')
                ->where('reservation.book.authors.0', 'Ada Lovelace')
                ->where('reservation.status', 'Approved')
                ->where('reservation.statusDate', $approvedAt->format('F j, Y, g:i a'))
                ->where('reservation.canCancel', true)
                ->where('reservation.cancelUrl', route('student.reservations.cancel', $reservation)));

        $this->patch(route('student.reservations.cancel', $reservation))->assertRedirect();

        $this->assertDatabaseHas('book_requests', [
            'book_request_id' => $reservation->book_request_id,
            'book_request_status_id' => $cancelled->book_request_status_id,
        ]);
    }

    public function test_fines_are_member_scoped_and_expose_server_calculated_balances(): void
    {
        $bookData = BookData::factory()->create(['book_title' => 'Fine Balance Title']);
        $book = Book::factory()->create([
            'book_data_id' => $bookData->book_data_id,
            'accession_number' => 'ACC-FINE-001',
        ]);
        $borrow = BookBorrow::create([
            'book_id' => $book->book_id,
            'member_id' => $this->member->member_id,
            'librarian_id' => null,
            'issue_date' => now()->subDays(14),
            'due_date' => now()->subDays(7),
            'return_date' => now()->subDay(),
            'status' => 'Returned',
        ]);
        $fine = FineDue::create([
            'borrow_id' => $borrow->borrow_id,
            'fine_date' => now()->subDay()->toDateString(),
            'fine_total' => 100,
            'fine_status' => 'Partial',
            'remarks' => 'Overdue return.',
        ]);
        $payment = FinePayment::create([
            'fine_id' => $fine->fine_id,
            'payment_date' => now()->subHours(2),
            'payment_amount' => 40,
            'payment_method' => 'Cash',
            'official_receipt_no' => 'OR-FINE-001',
            'received_by' => null,
        ]);

        $otherMember = Member::factory()->create();
        $otherBorrow = BookBorrow::create([
            'book_id' => $book->book_id,
            'member_id' => $otherMember->member_id,
            'librarian_id' => null,
            'issue_date' => now()->subDays(10),
            'due_date' => now()->subDays(3),
            'return_date' => now(),
            'status' => 'Returned',
        ]);
        FineDue::create([
            'borrow_id' => $otherBorrow->borrow_id,
            'fine_date' => now()->toDateString(),
            'fine_total' => 500,
            'fine_status' => 'Unpaid',
        ]);

        $this->get(route('student.fines.index'))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Student/Fines/Index')
                ->where('fineSummary.records', 1)
                ->where('fineSummary.assessed', 100)
                ->where('fineSummary.paid', 40)
                ->where('fineSummary.outstanding', 60)
                ->has('fines.data', 1)
                ->where('fines.data.0.id', $fine->fine_id)
                ->where('fines.data.0.book.title', 'Fine Balance Title')
                ->where('fines.data.0.book.accessionNumber', 'ACC-FINE-001')
                ->where('fines.data.0.balance', 60)
                ->where('fines.data.0.isPaid', false)
                ->where('fines.data.0.payments.0.id', $payment->fine_payment_id)
                ->where('fines.data.0.payments.0.receiptNumber', 'OR-FINE-001'));
    }

    public function test_profile_update_persists_the_contact_number_field(): void
    {
        $this->get(route('student.profile.edit'))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Student/Profile/Edit')
                ->where('profile.id', $this->member->member_id)
                ->where('profile.firstName', $this->member->first_name)
                ->where('profile.lastName', $this->member->last_name)
                ->where('profile.email', $this->member->email)
                ->where('profile.actions.update', route('student.profile.update')));

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
            ->assertInertia(fn (Assert $page) => $page
                ->component('Student/Profile/Show')
                ->where('profile.id', $this->member->member_id)
                ->where('profile.contactNumber', '09171234567')
                ->where('profile.actions.edit', route('student.profile.edit')));
    }

    public function test_account_settings_verify_current_password_and_update_the_hash(): void
    {
        $account = Auth::guard('member')->user();

        $this->get(route('student.account-settings.edit'))
            ->assertOk()
            ->assertInertia(fn (Assert $page) => $page
                ->component('Student/AccountSettings/Edit')
                ->where('account.username', 'student_flow_test')
                ->where('account.accountType', 'Member')
                ->where('account.accountStatus', 'Active')
                ->where('form.updatePasswordUrl', route('student.account-settings.password')));

        $this->put(route('student.account-settings.password'), [
            'current_password' => 'incorrect-password',
            'password' => 'NewSecurePassword123!',
            'password_confirmation' => 'NewSecurePassword123!',
        ])->assertSessionHasErrors('current_password');

        $this->assertTrue(Hash::check('password123', $account->fresh()->password_hash));

        $this->put(route('student.account-settings.password'), [
            'current_password' => 'password123',
            'password' => 'NewSecurePassword123!',
            'password_confirmation' => 'NewSecurePassword123!',
        ])->assertRedirect()
            ->assertSessionHas('success', 'Password updated successfully.');

        $this->assertTrue(Hash::check('NewSecurePassword123!', $account->fresh()->password_hash));
    }
}
