<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\BookBorrow;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class BorrowTransactionController extends Controller
{
    public function index(): Response
    {
        $member = Auth::guard('member')->user()->member;

        $currentBorrows = BookBorrow::with(['book.bookData', 'fineDue'])
            ->where('member_id', $member->member_id)
            ->whereRaw('LOWER(status) IN (?, ?)', ['borrowed', 'overdue'])
            ->orderBy('due_date', 'asc')
            ->limit(5)
            ->get();

        $history = BookBorrow::with(['book.bookData', 'fineDue'])
            ->where('member_id', $member->member_id)
            ->whereRaw('LOWER(status) = ?', ['returned'])
            ->orderBy('return_date', 'desc')
            ->limit(5)
            ->get();

        return Inertia::render('Student/Borrows/Overview', [
            'borrowing' => [
                'current' => $currentBorrows->map(fn (BookBorrow $borrow) => $this->serializeBorrow($borrow))->values(),
                'history' => $history->map(fn (BookBorrow $borrow) => $this->serializeBorrow($borrow))->values(),
            ],
        ]);
    }

    public function current(Request $request): Response
    {
        $member = Auth::guard('member')->user()->member;
        
        $query = BookBorrow::with(['book.bookData', 'fineDue'])
            ->where('member_id', $member->member_id)
            ->whereRaw('LOWER(status) IN (?, ?)', ['borrowed', 'overdue']);

        // Optional filtering/sorting
        if ($request->has('sort')) {
            if ($request->sort === 'due_date_asc') $query->orderBy('due_date', 'asc');
            elseif ($request->sort === 'due_date_desc') $query->orderBy('due_date', 'desc');
            elseif ($request->sort === 'issue_date_desc') $query->orderBy('issue_date', 'desc');
        } else {
            $query->orderBy('due_date', 'asc'); // Default
        }

        $borrows = $query->paginate(10);

        return Inertia::render('Student/Borrows/Current', [
            'borrows' => $this->serializePaginator($borrows),
            'filters' => ['sort' => $request->string('sort')->toString()],
        ]);
    }

    public function history(Request $request): Response
    {
        $member = Auth::guard('member')->user()->member;
        
        $query = BookBorrow::with(['book.bookData', 'fineDue'])
            ->where('member_id', $member->member_id)
            ->whereRaw('LOWER(status) = ?', ['returned']);

        if ($request->has('sort')) {
            if ($request->sort === 'return_date_desc') $query->orderBy('return_date', 'desc');
            elseif ($request->sort === 'return_date_asc') $query->orderBy('return_date', 'asc');
        } else {
            $query->orderBy('return_date', 'desc'); // Default
        }

        $borrows = $query->paginate(15);

        return Inertia::render('Student/Borrows/History', [
            'borrows' => $this->serializePaginator($borrows),
            'filters' => ['sort' => $request->string('sort')->toString()],
        ]);
    }

    public function overdue(): Response
    {
        $member = Auth::guard('member')->user()->member;
        
        $borrows = BookBorrow::with(['book.bookData', 'fineDue'])
            ->where('member_id', $member->member_id)
            ->whereRaw('LOWER(status) IN (?, ?)', ['borrowed', 'overdue'])
            ->where('due_date', '<', now())
            ->orderBy('due_date', 'asc')
            ->paginate(10);

        return Inertia::render('Student/Borrows/Overdue', [
            'borrows' => $this->serializePaginator($borrows),
        ]);
    }

    private function serializePaginator(LengthAwarePaginator $paginator): array
    {
        return [
            'data' => collect($paginator->items())
                ->map(fn (BookBorrow $borrow) => $this->serializeBorrow($borrow))
                ->values(),
            'meta' => [
                'currentPage' => $paginator->currentPage(),
                'lastPage' => $paginator->lastPage(),
                'total' => $paginator->total(),
                'from' => $paginator->firstItem(),
                'to' => $paginator->lastItem(),
            ],
            'links' => [
                'previous' => $paginator->previousPageUrl(),
                'next' => $paginator->nextPageUrl(),
            ],
        ];
    }

    private function serializeBorrow(BookBorrow $borrow): array
    {
        $book = $borrow->book;
        $fine = $borrow->fineDue;
        $isOverdue = $borrow->return_date === null && $borrow->due_date?->isPast();

        return [
            'id' => $borrow->id,
            'title' => $book?->bookData?->book_title ?? 'Untitled book',
            'accessionNumber' => $book?->accession_number,
            'issueDate' => $borrow->issue_date?->format('M d, Y'),
            'dueDate' => $borrow->due_date?->format('M d, Y'),
            'returnDate' => $borrow->return_date?->format('M d, Y'),
            'status' => $borrow->status,
            'isOverdue' => (bool) $isOverdue,
            'daysOverdue' => $isOverdue ? (int) $borrow->due_date->diffInDays(now()) : 0,
            'fine' => $fine ? [
                'total' => (float) $fine->fine_total,
                'status' => $fine->fine_status,
            ] : null,
        ];
    }
}
