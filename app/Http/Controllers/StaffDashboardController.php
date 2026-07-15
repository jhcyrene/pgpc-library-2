<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookBorrow;
use App\Models\BookData;
use App\Models\BookRequest;
use App\Models\Member;
use Illuminate\View\View;

class StaffDashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard');
    }

    public function stats()
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

        return response()->json([
            'success' => true, 
            'stats' => $stats, 
            'current_borrowers' => $current_borrowers,
            'most_borrowed_items' => $most_borrowed_items
        ]);
    }
}
