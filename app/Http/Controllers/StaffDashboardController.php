<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookBorrow;
use App\Models\BookData;
use App\Models\BookRequest;
use App\Models\Member;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class StaffDashboardController extends Controller
{
    public function index(): InertiaResponse
    {
        $data = $this->dashboardData();

        return Inertia::render('Staff/Dashboard', [
            'dashboard' => [
                'dateLabel' => now()->format('l, F j, Y'),
                'greeting' => now()->hour < 12 ? 'morning' : (now()->hour < 18 ? 'afternoon' : 'evening'),
                'summary' => [
                    'totalTitles' => $data['stats']['total_titles'],
                    'totalCopies' => $data['stats']['total_copies'],
                    'activeMembers' => $data['stats']['active_members'],
                    'borrowedItems' => $data['stats']['borrowed_items'],
                    'overdueItems' => $data['stats']['overdue_items'],
                    'pendingReservations' => $data['stats']['pending_reservations'],
                ],
                'currentBorrowers' => collect($data['current_borrowers'])->map(fn (array $borrower) => [
                    'memberName' => $borrower['member_name'],
                    'bookTitle' => $borrower['book_title'],
                    'borrowDate' => $borrower['borrow_date'],
                    'status' => $borrower['status'],
                ])->values(),
                'mostBorrowedItems' => collect($data['most_borrowed_items'])->map(fn (array $item) => [
                    'bookTitle' => $item['book_title'],
                    'borrowCount' => (int) $item['borrow_count'],
                    'copiesTotal' => (int) $item['copies_total'],
                    'copiesAvailable' => (int) $item['copies_available'],
                ])->values(),
            ],
        ]);
    }

    public function stats()
    {
        return response()->json([
            'success' => true,
            ...$this->dashboardData(),
        ]);
    }

    private function dashboardData(): array
    {
        $stats = [
            'total_titles' => BookData::query()->count(),
            'total_copies' => Book::query()->count(),
            'active_members' => Member::query()
                ->whereHas('memberAuth', function ($query) {
                    $query->whereRaw('LOWER(account_status) = ?', ['active']);
                })
                ->count(),
            'borrowed_items' => BookBorrow::query()
                ->whereRaw('LOWER(status) IN (?, ?)', ['borrowed', 'overdue'])
                ->count(),
            'overdue_items' => BookBorrow::query()
                ->whereRaw('LOWER(status) IN (?, ?)', ['borrowed', 'overdue'])
                ->where('due_date', '<', now())
                ->count(),
            'pending_reservations' => BookRequest::query()
                ->whereHas('bookRequestStatus', function ($query) {
                    $query->whereRaw('LOWER(status_name) = ?', ['pending']);
                })
                ->count(),
        ];

        $current_borrowers = BookBorrow::with(['member', 'book.bookData'])
            ->whereRaw('LOWER(status) IN (?, ?)', ['borrowed', 'overdue'])
            ->orderByDesc('issue_date')
            ->take(5)
            ->get()
            ->map(function ($borrow) {
                return [
                    'member_name' => collect([$borrow->member?->first_name, $borrow->member?->last_name])->filter()->implode(' ') ?: 'Unknown Member',
                    'book_title' => $borrow->book?->bookData?->book_title ?? 'Unknown Book',
                    'borrow_date' => $borrow->issue_date ? \Carbon\Carbon::parse($borrow->issue_date)->format('M d, Y') : 'Unknown',
                    'status' => ucfirst($borrow->status),
                ];
            });

        $mostBorrowedBookIds = BookBorrow::query()->join('books', 'book_borrows.book_id', '=', 'books.book_id')
            ->selectRaw('books.book_data_id, count(*) as borrow_count')
            ->groupBy('books.book_data_id')
            ->orderByDesc('borrow_count')
            ->take(5)
            ->get();

        $most_borrowed_items = [];
        foreach ($mostBorrowedBookIds as $row) {
            $bookData = BookData::find($row->book_data_id);
            if ($bookData) {
                $copiesTotal = Book::where('book_data_id', $bookData->book_data_id)->count();
                $copiesAvailable = Book::where('book_data_id', $bookData->book_data_id)->whereRaw('LOWER(status) = ?', ['available'])->count();
                
                $most_borrowed_items[] = [
                    'book_title' => $bookData->book_title,
                    'borrow_count' => $row->borrow_count,
                    'copies_total' => $copiesTotal,
                    'copies_available' => $copiesAvailable,
                ];
            }
        }

        return [
            'stats' => $stats, 
            'current_borrowers' => $current_borrowers,
            'most_borrowed_items' => $most_borrowed_items
        ];
    }
}
