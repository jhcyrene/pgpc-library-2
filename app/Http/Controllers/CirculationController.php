<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Book;
use App\Models\BookBorrow;
use App\Models\FineDue;
use App\Models\Setting;
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
        $activeBorrowsCount = BookBorrow::whereNull('return_date')->count();

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
            'activeBorrowsCount',
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
        $activeBorrowsCount = BookBorrow::whereNull('return_date')->count();

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
            'activeBorrows' => $activeBorrowsCount,
            'recentCheckinsHtml' => $recentCheckinsHtml
        ]);
    }

    public function searchMembers(Request $request)
    {
        $query = $request->input('q');
        $like = DB::connection()->getDriverName() === 'pgsql' ? 'ilike' : 'like';
        if (strlen($query) < 1) {
            return response()->json(['members' => []]);
        }

        $members = Member::where('first_name', $like, "%{$query}%")
            ->orWhere('last_name', $like, "%{$query}%")
            ->orWhere('student_id_number', $like, "%{$query}%")
            ->orWhere('email', $like, "%{$query}%")
            ->limit(10)
            ->get();

        $formatted = $members->map(function($m) {
            $activeBorrowsCount = BookBorrow::where('member_id', $m->member_id)->whereNull('return_date')->count();
            $fines = FineDue::whereHas('bookBorrow', function($q) use ($m) {
                $q->where('member_id', $m->member_id);
            })->where('fine_status', 'Unpaid')->sum('fine_total');
            $canBorrow = ($activeBorrowsCount < 3) && ($fines == 0);

            return [
                'id' => $m->student_id_number,
                'member_db_id' => $m->member_id,
                'name' => $m->first_name . ' ' . $m->last_name,
                'student_number' => $m->student_id_number,
                'course' => $m->program ?? 'Student',
                'can_borrow' => $canBorrow,
                'status' => $canBorrow ? 'Eligible' : ($fines > 0 ? 'Fines Due' : 'Limit Reached')
            ];
        });

        return response()->json(['members' => $formatted]);
    }

    public function getMember(Request $request, $identifier = null)
    {
        $id = $identifier ?: $request->input('id', $request->input('member_id', $request->input('q')));

        if (!$id) {
            return response()->json(['error' => 'No member identifier provided'], 400);
        }

        $member = Member::where(function ($q) use ($id) {
            $q->where('student_id_number', $id)
              ->orWhere('email', $id);
            if (is_numeric($id)) {
                $q->orWhere('member_id', (int) $id);
            }
        })->first();

        if (!$member) {
            $member = Member::where(function ($q) use ($id) {
                $q->where('student_id_number', 'LIKE', "%{$id}%")
                  ->orWhere('email', 'LIKE', "%{$id}%");
            })->first();
        }

        if (!$member) {
            return response()->json(['error' => 'Member not found'], 404);
        }

        $activeBorrows = BookBorrow::with('book.bookData')
            ->where('member_id', $member->member_id)
            ->whereNull('return_date')
            ->get();

        $fines = FineDue::whereHas('bookBorrow', function($q) use ($member) {
            $q->where('member_id', $member->member_id);
        })->where('fine_status', 'Unpaid')->sum('fine_total');

        $maxSlots = 3;
        $currentlyBorrowed = $activeBorrows->count();
        $availableSlots = max(0, $maxSlots - $currentlyBorrowed);

        return response()->json([
            'success' => true,
            'member' => [
                'id' => $member->student_id_number,
                'member_db_id' => $member->member_id,
                'initials' => strtoupper(substr($member->first_name ?? 'S', 0, 1) . substr($member->last_name ?? '', 0, 1)),
                'name' => $member->first_name . ' ' . $member->last_name,
                'student_number' => $member->student_id_number,
                'course' => $member->program ?? 'Student',
                'year' => $member->year_level ? 'Year ' . $member->year_level : '',
                'currently_borrowed' => $currentlyBorrowed,
                'available_slots' => $availableSlots,
                'fines' => (float)$fines,
                'can_borrow' => $availableSlots > 0 && $fines == 0,
                'status' => $fines > 0 ? 'Has Unpaid Fines' : ($availableSlots == 0 ? 'Max Limit Reached' : 'Eligible')
            ],
            'active_borrows' => $activeBorrows,
            'total_fines' => $fines
        ]);
    }

    public function searchBooks(Request $request)
    {
        $query = $request->input('q');
        $statusFilter = strtolower((string) $request->input('status'));
        $like = DB::connection()->getDriverName() === 'pgsql' ? 'ilike' : 'like';
        if (strlen($query) < 1) {
            return response()->json(['books' => []]);
        }

        $booksQuery = Book::with(['bookData.authors', 'bookData.bookDetail'])
            ->where(function ($queryBuilder) use ($query, $like) {
                $queryBuilder->where('barcode', $like, "%{$query}%")
                    ->orWhere('accession_number', $like, "%{$query}%")
                    ->orWhereHas('bookData', function ($q) use ($query, $like) {
                        $q->where('book_title', $like, "%{$query}%");
                    });
            });

        if ($statusFilter === 'borrowed') {
            $booksQuery->whereIn(DB::raw('LOWER(status)'), ['borrowed', 'overdue']);
        }

        $books = $booksQuery->limit(10)->get();

        $formatted = $books->map(function($b) {
            $authors = 'Unknown Author';
            if ($b->bookData && $b->bookData->authors && $b->bookData->authors->count() > 0) {
                $authors = $b->bookData->authors->map(fn($a) => trim($a->first_name . ' ' . $a->last_name))->filter()->join(', ');
            }

            $borrower = null;
            if (in_array(strtolower((string) $b->status), ['borrowed', 'overdue'])) {
                $activeBorrow = BookBorrow::with('member')
                    ->where('book_id', $b->book_id)
                    ->whereNull('return_date')
                    ->first();
                if ($activeBorrow && $activeBorrow->member) {
                    $borrower = $activeBorrow->member->first_name . ' ' . $activeBorrow->member->last_name;
                }
            }

            return [
                'id' => $b->book_id,
                'barcode' => $b->barcode ?: $b->accession_number,
                'accession_number' => $b->accession_number,
                'title' => $b->bookData->book_title ?? 'Unknown Title',
                'authors' => $authors,
                'status' => $b->status,
                'borrower' => $borrower,
                'cover_image' => $b->bookData->bookDetail->cover_image ?? null
            ];
        });

        return response()->json(['books' => $formatted]);
    }

    public function getBook(Request $request, $identifier = null)
    {
        $id = $identifier ?: $request->input('barcode', $request->input('identifier'));

        if (!$id) {
            return response()->json(['success' => false, 'error' => 'No barcode or identifier provided'], 400);
        }

        $book = Book::with(['bookData.authors', 'bookData.bookDetail'])
            ->where(function ($q) use ($id) {
                $q->where('accession_number', $id)
                  ->orWhere('barcode', $id);
                if (is_numeric($id)) {
                    $q->orWhere('book_id', (int) $id);
                }
            })
            ->first();

        if (!$book) {
            return response()->json(['success' => false, 'error' => 'Book copy not found'], 404);
        }

        if (strtolower($book->status) !== 'available') {
            return response()->json(['success' => false, 'error' => 'This book copy is currently ' . $book->status], 400);
        }

        return response()->json([
            'success' => true,
            'book' => $book,
            'due_date' => now()->addDays((int) Setting::get('default_borrow_days', 3))->format('M d, Y')
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
                        ->where(function ($q) use ($identifier) {
                            $q->where('accession_number', $identifier)
                              ->orWhere('barcode', $identifier);
                            if (is_numeric($identifier)) {
                                $q->orWhere('book_id', (int) $identifier);
                            }
                        })
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
                        'due_date' => now()->addDays((int) Setting::get('default_borrow_days', 3)),
                        'status' => 'Borrowed'
                    ]);

                    $book->status = 'Borrowed';
                    $book->save();

                    // Fulfill any active reservation for this student & book title
                    $fulfilledStatus = \App\Models\BookRequestStatus::whereRaw('LOWER(status_name) in (?, ?)', ['completed', 'fulfilled'])->first();
                    if ($fulfilledStatus) {
                        $activeReservation = \App\Models\BookRequest::where('member_id', $member->member_id)
                            ->where('book_data_id', $book->book_data_id)
                            ->whereHas('bookRequestStatus', function ($q) {
                                $q->whereRaw('LOWER(status_name) in (?, ?, ?, ?)', ['pending', 'approved', 'ready for pickup', 'ready']);
                            })
                            ->orderBy('request_date', 'asc')
                            ->first();

                        if ($activeReservation) {
                            $activeReservation->book_request_status_id = $fulfilledStatus->book_request_status_id;
                            $activeReservation->book_id = $book->book_id;
                            if (!$activeReservation->approved_at) $activeReservation->approved_at = now();
                            if (!$activeReservation->ready_at) $activeReservation->ready_at = now();
                            $activeReservation->fulfilled_at = now();
                            $activeReservation->save();
                        }
                    }

                    $successCount++;
                }
            });

            if ($successCount > 0) {
                return response()->json([
                    'success' => true,
                    'message' => "Successfully checked out {$successCount} book(s) to {$member->first_name}."
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Checkout failed: ' . implode(', ', $errors)
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error processing checkout: ' . $e->getMessage()
            ], 500);
        }
    }

    public function checkin(Request $request)
    {
        $request->validate([
            'book_identifier' => 'required|string'
        ]);

        $identifier = $request->input('book_identifier');

        $book = Book::where(function ($q) use ($identifier) {
            $q->where('accession_number', $identifier)
              ->orWhere('barcode', $identifier);
            if (is_numeric($identifier)) {
                $q->orWhere('book_id', (int) $identifier);
            }
        })->first();

        if (!$book) {
            return response()->json(['success' => false, 'message' => 'Book not found.'], 404);
        }

        $borrow = BookBorrow::with(['book.bookData', 'member'])
            ->where('book_id', $book->book_id)
            ->whereNull('return_date')
            ->first();

        if (!$borrow) {
            return response()->json(['success' => false, 'message' => 'This book is not currently marked as borrowed.'], 400);
        }

        try {
            DB::transaction(function () use ($book, $borrow) {
                $borrow->return_date = now();
                $borrow->status = 'Returned';

                if (now()->gt($borrow->due_date)) {
                    $daysOverdue = now()->diffInDays($borrow->due_date);
                    $rate = (float) Setting::get('fine_rate_per_day', 5);
                    $fineAmount = $daysOverdue * $rate;

                    FineDue::create([
                        'borrow_id' => $borrow->borrow_id,
                        'fine_total' => $fineAmount,
                        'fine_status' => 'Unpaid'
                    ]);

                    $borrow->fine_amount = $fineAmount;
                }

                $borrow->save();

                $book->status = 'Available';
                $book->save();
            });

            return response()->json([
                'success' => true,
                'message' => "Successfully returned '{$borrow->book->bookData->book_title}'.",
                'borrow' => [
                    'book_title' => $borrow->book->bookData->book_title,
                    'member_name' => $borrow->member->first_name . ' ' . $borrow->member->last_name,
                    'fine_amount' => $borrow->fine_amount ?? 0
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error processing check-in: ' . $e->getMessage()
            ], 500);
        }
    }
}
