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
        
        return view('student.reservations.create', compact('bookData', 'eligibility'));
    }

    public function store(StoreReservationRequest $request, BookData $bookData)
    {
        $member = Auth::guard('member')->user()->member;
        
        try {
            $reservation = $this->reservationService->createReservation($member, $bookData, $request->validated());
            return redirect()->route('student.reservations.show', $reservation)
                ->with('success', 'Reservation successfully created!');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
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
