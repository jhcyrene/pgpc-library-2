<?php

namespace App\Http\Controllers;

use App\Models\BookRequest;
use App\Models\BookRequestStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->query('status', 'all');
        $search = $request->query('search');
        $dateFilter = $request->query('date_filter', 'all');
        $sort = $request->query('sort', 'request_date');
        $dir = $request->query('dir', 'desc');

        // Base query with relations
        $query = BookRequest::with(['member', 'bookData', 'bookRequestStatus', 'book']);

        // Apply Status Filter
        if ($status !== 'all') {
            $query->whereHas('bookRequestStatus', function ($q) use ($status) {
                $q->whereRaw('LOWER(status_name) = ?', [strtolower(str_replace('-', ' ', $status))]);
            });
        }

        // Apply Search Filter
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                // Search by Student Name or Number
                $q->whereHas('member', function ($subQ) use ($search) {
                    $subQ->where('first_name', 'like', "%{$search}%")
                         ->orWhere('last_name', 'like', "%{$search}%")
                         ->orWhere('student_number', 'like', "%{$search}%");
                })
                // Search by Book Title
                ->orWhereHas('bookData', function ($subQ) use ($search) {
                    $subQ->where('book_title', 'like', "%{$search}%");
                });
            });
        }

        // Apply Date Filter
        if ($dateFilter !== 'all') {
            $now = \Carbon\Carbon::now();
            switch ($dateFilter) {
                case 'today':
                    $query->whereDate('request_date', $now->toDateString());
                    break;
                case 'this_week':
                    $query->whereBetween('request_date', [$now->startOfWeek()->toDateString(), $now->endOfWeek()->toDateString()]);
                    break;
                case 'this_month':
                    $query->whereMonth('request_date', $now->month)
                          ->whereYear('request_date', $now->year);
                    break;
            }
        }

        // Apply Sorting
        $allowedSorts = ['request_date', 'student_name'];
        if (in_array($sort, $allowedSorts)) {
            if ($sort === 'student_name') {
                $query->join('members', 'book_requests.member_id', '=', 'members.id')
                      ->orderBy('members.first_name', $dir)
                      ->orderBy('members.last_name', $dir)
                      ->select('book_requests.*');
            } else {
                $query->orderBy($sort, $dir);
            }
        } else {
            $query->orderBy('request_date', 'desc');
        }

        $reservations = $query->paginate(15)->withQueryString();

        // Calculate Stats
        $pendingCount = BookRequest::whereHas('bookRequestStatus', function ($q) {
            $q->whereRaw('LOWER(status_name) = ?', ['pending']);
        })->count();

        $approvedCount = BookRequest::whereHas('bookRequestStatus', function ($q) {
            $q->whereRaw('LOWER(status_name) = ?', ['approved']);
        })->count();

        $readyForPickupCount = BookRequest::whereHas('bookRequestStatus', function ($q) {
            $q->whereRaw('LOWER(status_name) = ?', ['ready for pickup']);
        })->count();

        $completedCount = BookRequest::whereHas('bookRequestStatus', function ($q) {
            $q->whereIn(DB::raw('LOWER(status_name)'), ['completed', 'fulfilled']);
        })->count();

        
        if ($request->ajax()) {
            return view('admin.reservations.partials.table', compact('reservations', 'status'));
        }
        
        return view('admin.reservations.index', compact(
            'reservations', 'status', 'pendingCount', 'approvedCount', 'readyForPickupCount', 'completedCount'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, BookRequest $reservation)
    {
        $reservation->load(['member', 'bookData.authors', 'bookData.bookDetail', 'book', 'bookRequestStatus']);
        
        $availableCopies = collect();
        if (strtolower((string) $reservation->bookRequestStatus->status_name) === 'approved') {
            // Get books that belong to this book_data_id and are 'Available'
            $availableCopies = \App\Models\Book::where('book_data_id', $reservation->book_data_id)
                ->where('status', 'Available')
                ->get();
        }

        if ($request->ajax()) {
            return view('admin.reservations.partials.show-content', compact('reservation', 'availableCopies'));
        }

        return view('admin.reservations.show', compact('reservation', 'availableCopies'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BookRequest $bookRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BookRequest $bookRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BookRequest $bookRequest)
    {
        //
    }

    /**
     * Update the status of the reservation.
     */
    public function updateStatus(Request $request, BookRequest $reservation)
    {
        $request->validate([
            'status' => 'required|string',
            'book_id' => 'nullable|exists:books,book_id'
        ]);

        $newStatusName = $request->input('status');
        $newStatus = BookRequestStatus::whereRaw('LOWER(status_name) = ?', [strtolower($newStatusName)])->first();

        if (!$newStatus) {
            return back()->with('error', 'Invalid status selected.');
        }

        try {
            DB::transaction(function () use ($reservation, $newStatusName, $newStatus, $request) {
                $reservation->book_request_status_id = $newStatus->book_request_status_id;

                switch (strtolower($newStatusName)) {
                    case 'approved':
                        $reservation->approved_at = now();
                        break;
                    case 'ready for pickup':
                        if (!$request->book_id) {
                            throw new \Exception('A specific book copy must be assigned for pickup.');
                        }
                        
                        $book = \App\Models\Book::find($request->book_id);
                        if (strtolower($book->status) !== 'available') {
                            throw new \Exception('The selected book copy is not available.');
                        }
                        
                        $reservation->book_id = $book->book_id;
                        $reservation->ready_at = now();
                        $reservation->expires_at = now()->addDays((int) env('RESERVATION_EXPIRE_DAYS', 1));
                        break;
                    case 'completed':
                    case 'fulfilled':
                        $reservation->fulfilled_at = now();
                        break;
                    case 'cancelled':
                    case 'rejected':
                        $reservation->cancelled_at = now();
                        break;
                }

                $reservation->save();
            });

            if ($request->ajax() || $request->wantsJson()) {
                $reservation->refresh();
                $reservation->load(['member', 'bookData.authors', 'bookData.bookDetail', 'book', 'bookRequestStatus']);
                
                $availableCopies = collect();
                if (strtolower((string) $reservation->bookRequestStatus->status_name) === 'approved') {
                    $availableCopies = \App\Models\Book::where('book_data_id', $reservation->book_data_id)
                        ->where('status', 'Available')
                        ->get();
                }

                $html = view('admin.reservations.partials.status-card', compact('reservation', 'availableCopies'))->render();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Reservation status updated successfully.',
                    'html' => $html
                ]);
            }

            return redirect()->route('admin.reservations.show', $reservation)->with('success', 'Reservation status updated successfully.');
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 400);
            }
            return back()->with('error', $e->getMessage());
        }
    }
}
