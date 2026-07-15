<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookBorrow;
use App\Models\FineDue;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LoanController extends Controller
{
    public function index()
    {
        return view('admin.borrows.index');
    }

    public function stats()
    {
        $today = Carbon::today();

        $activeLoansCount = BookBorrow::where('status', 'Borrowed')->count();
        $overdueLoansCount = BookBorrow::where('status', 'Borrowed')->where('due_date', '<', now())->count();
        $returnedTodayCount = BookBorrow::whereDate('return_date', $today)->count();
        $outstandingFines = FineDue::where('fine_status', 'Unpaid')->sum('fine_total');

        return response()->json([
            'active_loans' => $activeLoansCount,
            'overdue_loans' => $overdueLoansCount,
            'returned_today' => $returnedTodayCount,
            'outstanding_fines' => $outstandingFines,
        ]);
    }

    public function list(Request $request)
    {
        $query = BookBorrow::with(['member', 'book.bookData.authors', 'fineDue'])
            ->select('book_borrows.*');

        // Apply Global Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('borrow_id', 'like', "%{$search}%")
                  ->orWhereHas('member', function($q2) use ($search) {
                      $q2->where('student_id_number', 'like', "%{$search}%")
                         ->orWhere('first_name', 'like', "%{$search}%")
                         ->orWhere('last_name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('book.bookData', function($q3) use ($search) {
                      $q3->where('book_title', 'like', "%{$search}%");
                  })
                  ->orWhereHas('book', function($q4) use ($search) {
                      $q4->where('barcode', 'like', "%{$search}%")
                         ->orWhere('accession_number', 'like', "%{$search}%");
                  });
            });
        }

        // Apply Status Filter
        if ($request->filled('status') && $request->status !== 'all') {
            if ($request->status === 'overdue') {
                $query->where('status', 'Borrowed')->where('due_date', '<', now());
            } elseif ($request->status === 'active') {
                $query->where('status', 'Borrowed')->where('due_date', '>=', now());
            } else {
                $query->where('status', ucfirst($request->status));
            }
        }

        // Apply Due Date Filter
        if ($request->filled('due_date_filter') && $request->due_date_filter !== 'all') {
            $today = Carbon::today();
            if ($request->due_date_filter === 'today') {
                $query->whereDate('due_date', $today);
            } elseif ($request->due_date_filter === 'this_week') {
                $query->whereBetween('due_date', [$today->copy()->startOfWeek(), $today->copy()->endOfWeek()]);
            } elseif ($request->due_date_filter === 'overdue') {
                $query->where('due_date', '<', now())->whereNull('return_date');
            }
        }

        // Order By
        $sort = $request->get('sort', 'borrow_date');
        $dir = $request->get('dir', 'desc');

        if ($sort === 'due_date') {
            $query->orderBy('due_date', $dir);
        } elseif ($sort === 'student_name') {
            $query->join('members', 'book_borrows.member_id', '=', 'members.member_id')
                  ->orderBy('members.first_name', $dir)
                  ->orderBy('members.last_name', $dir);
        } else {
            $query->orderBy('issue_date', $dir);
        }

        // We fetch the raw records, then we will group them in PHP by member_id + issue_date
        $borrows = $query->get();

        $grouped = $borrows->groupBy(function($b) {
            // Group by member ID and issue_date (to the minute to capture same-session checkouts)
            return $b->member_id . '_' . Carbon::parse($b->issue_date)->format('Y-m-d H:i');
        });

        // Format for Datatable
        $result = [];
        foreach ($grouped as $groupKey => $items) {
            $first = $items->first();
            
            // Calculate aggregate status
            // If any is overdue, group is overdue. If any is borrowed, group is active. Else returned.
            $hasOverdue = false;
            $hasActive = false;
            $totalFine = 0;
            
            $booksList = [];

            foreach ($items as $item) {
                if ($item->status === 'Borrowed') {
                    if ($item->due_date < now()) {
                        $hasOverdue = true;
                    } else {
                        $hasActive = true;
                    }
                }
                
                if ($item->fineDue && $item->fineDue->fine_status === 'Unpaid') {
                    $totalFine += $item->fineDue->fine_total;
                }
                
                // Add to books list
                $authors = 'Unknown Author';
                if ($item->book->bookData->authors->count() > 0) {
                    $authors = $item->book->bookData->authors->pluck('author_name')->join(', ');
                }

                $imageUrl = null;
                if ($item->book->bookData->bookDetail) {
                    if ($item->book->bookData->bookDetail->image_url) {
                        $imageUrl = asset('storage/' . $item->book->bookData->bookDetail->image_url);
                    } elseif ($item->book->bookData->bookDetail->cover_image) {
                        $src = $item->book->bookData->bookDetail->cover_image;
                        $imageUrl = str_starts_with($src, 'data:image') ? $src : asset('storage/' . ltrim($src, '/'));
                    }
                }

                $booksList[] = [
                    'borrow_id' => $item->borrow_id,
                    'title' => $item->book->bookData->book_title,
                    'authors' => $authors,
                    'barcode' => $item->book->barcode ?? $item->book->accession_number,
                    'status' => $item->status,
                    'cover' => $imageUrl,
                    'return_date' => $item->return_date ? Carbon::parse($item->return_date)->format('M d, Y h:i A') : null,
                ];
            }

            $groupStatus = 'Returned';
            if ($hasOverdue) {
                $groupStatus = 'Overdue';
            } elseif ($hasActive) {
                $groupStatus = 'Active';
            }

            // Calculate remaining days based on the first item's due date
            $dueDate = Carbon::parse($first->due_date);
            $daysDiff = now()->startOfDay()->diffInDays($dueDate->startOfDay(), false);

            $dueState = 'upcoming'; // green
            if ($groupStatus === 'Overdue' || $daysDiff < 0) {
                $dueState = 'overdue'; // red
            } elseif ($daysDiff === 0) {
                $dueState = 'today'; // orange
            }

            $avatarUrl = null;
            if ($first->member->memberAuth && $first->member->memberAuth->profile_image) {
                $src = $first->member->memberAuth->profile_image;
                $avatarUrl = str_starts_with($src, 'data:image') ? $src : asset('storage/' . ltrim($src, '/'));
            }

            $result[] = [
                'group_id' => $groupKey,
                'borrow_ids' => $items->pluck('borrow_id')->toArray(),
                'member' => [
                    'name' => $first->member->first_name . ' ' . $first->member->last_name,
                    'student_id' => $first->member->student_id_number,
                    'initial' => substr($first->member->first_name, 0, 1),
                    'avatar' => $avatarUrl
                ],
                'books' => $booksList,
                'book_count' => count($booksList),
                'first_book' => $booksList[0],
                'issue_date' => Carbon::parse($first->issue_date)->format('M d, Y'),
                'due_date' => $dueDate->format('M d, Y'),
                'due_state' => $dueState,
                'days_diff' => abs($daysDiff),
                'status' => $groupStatus,
                'total_fine' => $totalFine,
                'returned_date' => $first->return_date ? Carbon::parse($first->return_date)->format('M d, Y') : '-'
            ];
        }

        // Manual Pagination after grouping
        $page = (int) $request->get('page', 1);
        $perPage = 10;
        $total = count($result);
        
        $pagedData = array_slice($result, ($page - 1) * $perPage, $perPage);

        return response()->json([
            'data' => $pagedData,
            'current_page' => $page,
            'last_page' => ceil($total / $perPage),
            'total' => $total
        ]);
    }

    public function payFines(Request $request)
    {
        $request->validate([
            'borrow_ids' => 'required|array',
            'borrow_ids.*' => 'integer|exists:book_borrows,borrow_id'
        ]);

        $fines = FineDue::whereIn('borrow_id', $request->borrow_ids)
                        ->where('fine_status', 'Unpaid')
                        ->get();
        
        foreach ($fines as $fine) {
            $fine->fine_status = 'Paid';
            $fine->save();
        }

        return response()->json(['success' => true, 'message' => 'Fines marked as paid.']);
    }
}
