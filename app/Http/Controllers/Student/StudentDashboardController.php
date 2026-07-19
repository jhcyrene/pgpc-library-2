<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\StudentDashboardService;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class StudentDashboardController extends Controller
{
    protected $dashboardService;

    public function __construct(StudentDashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index()
    {
        $member = Auth::guard('member')->user()->member;

        // Eager load relationships if needed, though service already handles most
        $summary = $this->dashboardService->getSummary($member);
        $currentBorrows = $this->dashboardService->getCurrentBorrows($member, 5);
        $reservations = $this->dashboardService->getReservationPreview($member, 3);
        $attentionItems = $this->dashboardService->getAttentionItems($member);

        $now = now();

        return Inertia::render('Student/Dashboard', [
            'dashboard' => [
                'greeting' => $now->hour < 12 ? 'morning' : ($now->hour < 18 ? 'afternoon' : 'evening'),
                'dateLabel' => $now->format('l, F j, Y'),
                'summary' => [
                    'activeBorrows' => (int) $summary['active_borrows'],
                    'overdueItems' => (int) $summary['overdue_items'],
                    'pendingReservations' => (int) $summary['pending_reservations'],
                    'readyForPickup' => (int) $summary['ready_for_pickup'],
                    'outstandingFines' => (float) $summary['outstanding_fines'],
                    'totalBooksBorrowed' => (int) $summary['total_books_borrowed'],
                ],
                'currentBorrows' => $currentBorrows->map(fn ($borrow): array => [
                    'id' => (int) $borrow->borrow_id,
                    'title' => $borrow->book?->bookData?->book_title ?? 'Untitled book',
                    'accessionNumber' => $borrow->book?->accession_number,
                    'dueDate' => $borrow->due_date?->format('M d, Y'),
                    'isOverdue' => $borrow->due_date?->isPast() ?? false,
                ])->values(),
                'reservations' => $reservations->map(fn ($reservation): array => [
                    'id' => (int) $reservation->book_request_id,
                    'title' => $reservation->bookData?->book_title ?? 'Untitled book',
                    'status' => $reservation->bookRequestStatus?->status_name ?? 'Pending',
                    'requestDate' => $reservation->request_date?->format('M d, Y'),
                    'showUrl' => route('student.reservations.show', $reservation),
                ])->values(),
                'attentionItems' => collect($attentionItems)->map(fn (array $item): array => [
                    'type' => $item['type'],
                    'title' => $item['title'],
                    'message' => $item['message'],
                    'actionUrl' => $item['action_url'],
                ])->values(),
            ],
        ]);
    }
}
