<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Book;
use App\Models\BookBorrow;
use App\Models\FineDue;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CirculationController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $todaysCheckouts = BookBorrow::whereDate('issue_date', $today)->count();
        $todaysReturns = BookBorrow::whereDate('return_date', $today)->count();
        $overdueBooks = BookBorrow::whereNull('return_date')->where('due_date', '<', now())->count();
        $outstandingFines = FineDue::where('fine_status', 'Unpaid')->sum('fine_total');

        $recentCheckins = BookBorrow::with(['book.bookData.authors', 'member'])
            ->whereNotNull('return_date')
            ->orderBy('return_date', 'desc')
            ->limit(5)
            ->get();

        return view('admin.circulation.index', compact(
            'todaysCheckouts',
            'todaysReturns',
            'overdueBooks',
            'outstandingFines',
            'recentCheckins'
        ));
    }

    public function stats()
    {
        $today = Carbon::today();

        $todaysCheckouts = BookBorrow::whereDate('issue_date', $today)->count();
        $todaysReturns = BookBorrow::whereDate('return_date', $today)->count();
        $overdueBooks = BookBorrow::whereNull('return_date')->where('due_date', '<', now())->count();
        $outstandingFines = FineDue::where('fine_status', 'Unpaid')->sum('fine_total');

        $recentCheckins = BookBorrow::with(['book.bookData.authors', 'member'])
            ->whereNotNull('return_date')
            ->orderBy('return_date', 'desc')
            ->limit(5)
            ->get();

        $recentCheckinsHtml = view('admin.circulation.partials.recent_checkins', compact('recentCheckins'))->render();

        return response()->json([
            'todaysCheckouts' => $todaysCheckouts,
            'todaysReturns' => $todaysReturns,
            'overdueBooks' => $overdueBooks,
            'outstandingFines' => $outstandingFines,
            'recentCheckinsHtml' => $recentCheckinsHtml
        ]);
    }

    public function searchMembers(Request $request)
    {
        $query = $request->get('q');
        if (strlen($query) < 1) {
            return response()->json([]);
        }

        $members = Member::where('first_name', 'ilike', "%{$query}%")
            ->orWhere('last_name', 'ilike', "%{$query}%")
            ->orWhere('student_id_number', 'ilike', "%{$query}%")
            ->orWhere('email', 'ilike', "%{$query}%")
            ->limit(10)
            ->get(['member_id', 'first_name', 'last_name', 'student_id_number', 'email', 'program', 'year_level']);

        return response()->json($members);
    }

    public function getMember($identifier)
    {
        // Try to find by student_id_number, email
        $member = Member::where('student_id_number', $identifier)
            ->orWhere('email', $identifier)
            ->first();

        if (!$member) {
            return response()->json(['error' => 'Member not found'], 404);
        }

        // Check active borrows
        $activeBorrows = BookBorrow::with('book.bookData')
            ->where('member_id', $member->member_id)
            ->whereNull('return_date')
            ->get();

        // Check fines using relationship
        $fines = FineDue::whereHas('bookBorrow', function($q) use ($member) {
            $q->where('member_id', $member->member_id);
        })->where('fine_status', 'Unpaid')->sum('fine_total');


        return response()->json([
            'member' => $member,
            'active_borrows' => $activeBorrows,
            'total_fines' => $fines
        ]);
    }

    public function getBook($identifier)
    {
        $book = Book::with('bookData.authors')
            ->where('accession_number', $identifier)
            ->orWhere('barcode', $identifier)
            ->first();

        if (!$book) {
            return response()->json(['error' => 'Book copy not found'], 404);
        }

        if (strtolower($book->status) !== 'available') {
            return response()->json(['error' => 'This book copy is currently ' . $book->status], 400);
        }

        return response()->json([
            'book' => $book,
            'due_date' => now()->addDays((int) env('DEFAULT_BORROW_DAYS', 3))->format('M d, Y')
        ]);
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'student_id' => 'required|string',
            'book_identifiers' => 'required|array',
            'book_identifiers.*' => 'string'
        ]);

        $member = Member::where('student_id_number', $request->student_id)->first();
        if (!$member) {
            return response()->json(['success' => false, 'message' => 'Member not found.'], 404);
        }

        $successCount = 0;
        $errors = [];

        try {
            DB::transaction(function () use ($member, $request, &$successCount, &$errors) {
                foreach ($request->book_identifiers as $identifier) {
                    $book = Book::with('bookData')
                        ->where('accession_number', $identifier)
                        ->orWhere('barcode', $identifier)
                        ->first();

                    if (!$book) {
                        $errors[] = "$identifier: Not found.";
                        continue;
                    }

                    if (strtolower($book->status) !== 'available') {
                        $errors[] = "$identifier: Currently " . $book->status;
                        continue;
                    }

                    BookBorrow::create([
                        'book_id' => $book->book_id,
                        'member_id' => $member->member_id,
                        'librarian_id' => auth()->id(),
                        'issue_date' => now(),
                        'due_date' => now()->addDays((int) env('DEFAULT_BORROW_DAYS', 3)),
                        'status' => 'Borrowed'
                    ]);

                    $book->status = 'Borrowed';
                    $book->save();
                    $successCount++;
                }
            });

            if ($successCount === 0) {
                return response()->json(['success' => false, 'message' => 'Failed to checkout books.', 'errors' => $errors], 400);
            }

            $msg = "Successfully checked out $successCount book(s).";
            if (count($errors) > 0) {
                $msg .= " Some books failed: " . implode(', ', $errors);
            }

            return response()->json([
                'success' => true, 
                'message' => $msg
            ]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Transaction failed. ' . $e->getMessage()], 500);
        }
    }

    public function checkin(Request $request)
    {
        $request->validate([
            'book_identifier' => 'required|string'
        ]);

        $book = Book::with('bookData')
            ->where('accession_number', $request->book_identifier)
            ->orWhere('barcode', $request->book_identifier)
            ->first();

        if (!$book) {
            return response()->json(['success' => false, 'message' => 'Book copy not found.'], 404);
        }

        $borrow = BookBorrow::where('book_id', $book->book_id)
            ->whereNull('return_date')
            ->first();

        if (!$borrow) {
            return response()->json(['success' => false, 'message' => 'This book is not currently checked out.'], 400);
        }

        try {
            $fineAmount = 0;
            DB::transaction(function () use ($borrow, $book, &$fineAmount) {
                $borrow->return_date = now();
                $borrow->status = 'Returned';
                
                // Calculate fine if overdue
                if ($borrow->return_date > $borrow->due_date) {
                    $daysOverdue = Carbon::parse($borrow->due_date)->startOfDay()->diffInDays(now()->startOfDay());
                    if ($daysOverdue > 0) {
                        $fineRate = (float) env('DAILY_FINE_AMOUNT', 10.0);
                        $fineAmount = $daysOverdue * $fineRate;

                        FineDue::create([
                            'borrow_id' => $borrow->borrow_id,
                            'fine_date' => now()->toDateString(),
                            'fine_total' => $fineAmount,
                            'fine_status' => 'Unpaid'
                        ]);
                    }
                }
                
                $borrow->save();

                $book->status = 'Available';
                $book->save();
            });

            $msg = 'Successfully checked in: ' . $book->bookData->book_title;
            if ($fineAmount > 0) {
                $msg .= '. Overdue fine assessed: ₱' . number_format($fineAmount, 2);
            }

            return response()->json([
                'success' => true,
                'message' => $msg,
                'fine' => $fineAmount > 0 ? $fineAmount : null
            ]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Transaction failed.'], 500);
        }
    }
}
