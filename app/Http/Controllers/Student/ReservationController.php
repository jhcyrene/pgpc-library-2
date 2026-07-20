<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\BookData;
use App\Models\BookRequest;
use App\Services\ReservationService;
use App\Http\Requests\Student\StoreReservationRequest;
use Illuminate\Support\Facades\Auth;
use Exception;

class ReservationController extends Controller
{
    protected $reservationService;

    public function __construct(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
    }

    public function index()
    {
        $member = Auth::guard('member')->user()->member;
        
        $reservations = BookRequest::with(['bookData', 'bookRequestStatus'])
            ->where('member_id', $member->member_id)
            ->orderBy('request_date', 'desc')
            ->paginate(10);

        return view('student.reservations.index', compact('reservations'));
    }

    public function create(BookData $bookData)
    {
        $member = Auth::guard('member')->user()->member;
        $bookData->loadMissing(['authors', 'bookDetail']);
        
        $eligibility = $this->reservationService->checkEligibility($member, $bookData);
        
        if (request()->ajax() || request()->wantsJson()) {
            $events = [];
            
            $reservations = \App\Models\BookRequest::where('book_data_id', $bookData->book_data_id)
                ->whereNotNull('pickup_date')
                ->whereHas('bookRequestStatus', function ($q) {
                    $q->whereIn('status_name', ['Pending', 'Approved', 'Ready for pickup']);
                })->get();
                
            foreach ($reservations as $res) {
                $events[] = [
                    'title' => 'Reserved',
                    'start' => $res->pickup_date->format('Y-m-d'),
                    'color' => '#f59e0b',
                    'allDay' => true,
                ];
            }
            
            $borrows = \App\Models\BookBorrow::whereHas('book', function ($q) use ($bookData) {
                $q->where('book_data_id', $bookData->book_data_id);
            })->whereIn('status', ['Borrowed', 'Overdue'])->get();
            
            foreach ($borrows as $borrow) {
                if ($borrow->issue_date && $borrow->due_date) {
                    $events[] = [
                        'title' => 'Borrowed',
                        'start' => $borrow->issue_date->format('Y-m-d'),
                        'end' => \Carbon\Carbon::parse($borrow->due_date)->addDay()->format('Y-m-d'),
                        'color' => '#ef4444',
                        'allDay' => true,
                    ];
                }
            }
            
            $html = view('components.opac.reserveBookModal', compact('bookData', 'eligibility', 'events'))->render();
            
            return response()->json([
                'success' => true,
                'html' => $html
            ]);
        }
        
        return view('student.reservations.create', compact('bookData', 'eligibility'));
    }

    public function store(StoreReservationRequest $request, BookData $bookData)
    {
        $member = Auth::guard('member')->user()->member;
        
        try {
            $reservation = $this->reservationService->createReservation($member, $bookData, $request->validated());
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Reservation successfully created!'
                ]);
            }
            
            return redirect()->route('student.reservations.show', $reservation)
                ->with('success', 'Reservation successfully created!');
        } catch (Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 400);
            }
            return back()->with('error', $e->getMessage());
        }
    }

    public function checkAvailability(BookData $bookData, \Illuminate\Http\Request $request)
    {
        $year = (int) $request->query('year', now()->year);
        $month = (int) $request->query('month', now()->month);
        
        $startDate = \Carbon\Carbon::create($year, $month, 1)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();
        
        $unavailableDates = [];
        $tempDate = $startDate->copy();
        
        while ($tempDate->lte($endDate)) {
            $avail = $this->reservationService->getAvailableCopiesCountOnDate($bookData, $tempDate);
            if ($avail <= 0) {
                $unavailableDates[] = $tempDate->format('Y-m-d');
            }
            $tempDate->addDay();
        }
        
        return response()->json([
            'success' => true,
            'unavailable_dates' => $unavailableDates
        ]);
    }

    public function show(BookRequest $reservation)
    {
        $member = Auth::guard('member')->user()->member;

        if ($reservation->member_id !== $member->member_id) {
            abort(403);
        }

        $reservation->load([
            'bookData.authors',
            'bookData.bookDetail',
            'bookRequestStatus',
            'member',
        ]);

        return view('student.reservations.show', compact('reservation'));
    }

    public function cancel(BookRequest $reservation)
    {
        $member = Auth::guard('member')->user()->member;

        try {
            $this->reservationService->cancelReservation($member, $reservation);
            return back()->with('success', 'Reservation successfully cancelled.');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
