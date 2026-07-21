<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\BookBorrow;
use App\Models\BookData;
use App\Models\BookRequest;
use App\Models\SavedItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentSearchController extends Controller
{
    private function applyBookDataFilter($query, string $q): void
    {
        $pattern = '%' . mb_strtolower($q) . '%';
        $query->where(function ($subQuery) use ($pattern) {
            $subQuery->whereRaw('LOWER(book_data.book_title) LIKE ?', [$pattern])
                ->orWhereRaw('LOWER(book_data.subtitle) LIKE ?', [$pattern])
                ->orWhereHas('bookDetail', function ($detailQuery) use ($pattern) {
                    $detailQuery->whereRaw('LOWER(book_details.isbn) LIKE ?', [$pattern])
                        ->orWhereRaw('LOWER(book_details.issn) LIKE ?', [$pattern])
                        ->orWhereRaw('LOWER(book_details.call_number) LIKE ?', [$pattern]);
                })
                ->orWhereHas('authors', function ($authorQuery) use ($pattern) {
                    $authorQuery->whereRaw('LOWER(authors.first_name) LIKE ?', [$pattern])
                        ->orWhereRaw('LOWER(authors.last_name) LIKE ?', [$pattern]);
                });
        });
    }

    public function index(Request $request)
    {
        $q = trim((string) $request->input('q', ''));
        $user = Auth::guard('member')->user();
        $memberId = $user?->member_id;

        $borrows = collect();
        $reservations = collect();
        $savedItems = collect();
        $catalogBooks = collect();

        if ($q !== '') {
            if ($memberId) {
                // 1. Borrow Records
                $borrows = BookBorrow::with(['book.bookData.bookDetail', 'fineDue'])
                    ->where('member_id', $memberId)
                    ->whereHas('book.bookData', function ($query) use ($q) {
                        $this->applyBookDataFilter($query, $q);
                    })
                    ->latest()
                    ->get();

                // 2. Reservations & Requests
                $reservations = BookRequest::with(['bookData.bookDetail', 'bookRequestStatus'])
                    ->where('member_id', $memberId)
                    ->whereHas('bookData', function ($query) use ($q) {
                        $this->applyBookDataFilter($query, $q);
                    })
                    ->latest()
                    ->get();

                // 3. Saved Items
                $savedItems = SavedItem::with(['bookData.bookDetail'])
                    ->where('member_id', $memberId)
                    ->whereHas('bookData', function ($query) use ($q) {
                        $this->applyBookDataFilter($query, $q);
                    })
                    ->latest()
                    ->get();
            }

            // 4. Catalog Books
            $catalogBooks = BookData::with(['authors', 'bookDetail', 'books'])
                ->where(function ($query) use ($q) {
                    $this->applyBookDataFilter($query, $q);
                })
                ->take(12)
                ->get();
        }

        return view('student.search.index', compact('q', 'borrows', 'reservations', 'savedItems', 'catalogBooks'));
    }

    public function search(Request $request)
    {
        $q = trim((string) $request->input('q', ''));

        if (mb_strlen($q) < 1) {
            return response()->json([
                'borrows' => [],
                'reservations' => [],
                'saved' => [],
                'catalog' => [],
            ]);
        }

        $user = Auth::guard('member')->user();
        $memberId = $user?->member_id;

        $borrows = [];
        $reservations = [];
        $saved = [];

        if ($memberId) {
            // 1. User's Borrow History & Active Borrows
            $borrows = BookBorrow::with(['book.bookData.bookDetail'])
                ->where('member_id', $memberId)
                ->whereHas('book.bookData', function ($query) use ($q) {
                    $this->applyBookDataFilter($query, $q);
                })
                ->latest()
                ->take(5)
                ->get()
                ->map(function ($borrow) {
                    $bookData = $borrow->book?->bookData;
                    return [
                        'id' => $borrow->borrow_id,
                        'title' => $bookData?->book_title ?? 'Borrowed Book',
                        'subtitle' => 'Status: ' . ucfirst((string) $borrow->status) . ($borrow->due_date ? ' | Due: ' . $borrow->due_date->format('M d, Y') : ''),
                        'status' => $borrow->status,
                        'url' => route('student.borrow-transactions.index'),
                    ];
                });

            // 2. User's Reservations & Requests
            $reservations = BookRequest::with(['bookData.bookDetail', 'bookRequestStatus'])
                ->where('member_id', $memberId)
                ->whereHas('bookData', function ($query) use ($q) {
                    $this->applyBookDataFilter($query, $q);
                })
                ->latest()
                ->take(5)
                ->get()
                ->map(function ($req) {
                    $bookData = $req->bookData;
                    $statusName = $req->bookRequestStatus?->status_name ?? 'Pending';
                    return [
                        'id' => $req->book_request_id,
                        'title' => $bookData?->book_title ?? 'Reserved Book',
                        'subtitle' => 'Reservation: ' . $statusName,
                        'status' => $statusName,
                        'url' => route('student.reservations.index'),
                    ];
                });

            // 3. User's Saved Items
            $saved = SavedItem::with(['bookData.bookDetail'])
                ->where('member_id', $memberId)
                ->whereHas('bookData', function ($query) use ($q) {
                    $this->applyBookDataFilter($query, $q);
                })
                ->latest()
                ->take(5)
                ->get()
                ->map(function ($item) {
                    $bookData = $item->bookData;
                    return [
                        'id' => $item->saved_item_id,
                        'title' => $bookData?->book_title ?? 'Saved Book',
                        'subtitle' => 'In Saved Items',
                        'url' => route('student.saved-items.index'),
                    ];
                });
        }

        // 4. Catalog Books
        $catalog = BookData::with(['bookDetail'])
            ->where(function ($query) use ($q) {
                $this->applyBookDataFilter($query, $q);
            })
            ->take(5)
            ->get()
            ->map(function ($book) {
                $isbn = $book->bookDetail?->isbn;
                return [
                    'id' => $book->book_data_id,
                    'title' => $book->book_title,
                    'subtitle' => 'Catalog Book' . ($isbn ? ' | ISBN: ' . $isbn : ''),
                    'url' => route('student.search') . '?q=' . urlencode($book->book_title),
                ];
            });

        return response()->json([
            'borrows' => $borrows,
            'reservations' => $reservations,
            'saved' => $saved,
            'catalog' => $catalog,
        ]);
    }
}
