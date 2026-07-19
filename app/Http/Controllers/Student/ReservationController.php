<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\BookData;
use App\Models\BookRequest;
use App\Services\ReservationService;
use App\Http\Requests\Student\StoreReservationRequest;
use Exception;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class ReservationController extends Controller
{
    protected $reservationService;

    public function __construct(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
    }

    public function index(): Response
    {
        $member = Auth::guard('member')->user()->member;
        
        $reservations = BookRequest::with(['bookData.authors', 'bookData.bookDetail', 'bookRequestStatus'])
            ->where('member_id', $member->member_id)
            ->orderBy('request_date', 'desc')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render('Student/Reservations/Index', [
            'reservations' => [
                'data' => $reservations->getCollection()
                    ->map(fn (BookRequest $reservation) => $this->serializeReservation($reservation))
                    ->values(),
                'meta' => [
                    'currentPage' => $reservations->currentPage(),
                    'lastPage' => $reservations->lastPage(),
                    'total' => $reservations->total(),
                    'from' => $reservations->firstItem(),
                    'to' => $reservations->lastItem(),
                ],
                'links' => [
                    'previous' => $reservations->previousPageUrl(),
                    'next' => $reservations->nextPageUrl(),
                ],
            ],
        ]);
    }

    public function create(BookData $bookData): Response|\Illuminate\Http\JsonResponse
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
        
        return Inertia::render('Student/Reservations/Create', [
            'book' => $this->serializeBook($bookData),
            'eligibility' => [
                'eligible' => (bool) $eligibility['eligible'],
                'reason' => $eligibility['reason'],
            ],
            'form' => [
                'storeUrl' => route('student.reservations.store', $bookData),
                'minimumPickupDate' => now()->toDateString(),
            ],
        ]);
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

    public function show(BookRequest $reservation): Response
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

        return Inertia::render('Student/Reservations/Show', [
            'reservation' => $this->serializeReservation($reservation, true),
        ]);
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

    private function serializeReservation(BookRequest $reservation, bool $detailed = false): array
    {
        $status = $reservation->bookRequestStatus?->status_name ?? 'Unknown';
        $normalizedStatus = strtolower($status);
        $statusDate = match ($normalizedStatus) {
            'approved' => $reservation->approved_at,
            'ready for pickup' => $reservation->ready_at ?? $reservation->approved_at,
            'completed' => $reservation->fulfilled_at,
            'cancelled' => $reservation->cancelled_at,
            default => null,
        };

        $data = [
            'id' => (int) $reservation->book_request_id,
            'book' => $this->serializeBook($reservation->bookData),
            'requestDate' => $reservation->request_date?->format('M d, Y h:i A'),
            'status' => $status,
            'statusKey' => $normalizedStatus,
            'showUrl' => route('student.reservations.show', $reservation),
        ];

        if ($detailed) {
            $data += [
                'requestDateLong' => $reservation->request_date?->format('F j, Y, g:i a'),
                'pickupDate' => $reservation->pickup_date?->format('F j, Y'),
                'statusDate' => $statusDate?->format('F j, Y, g:i a'),
                'remarks' => $reservation->remarks,
                'requester' => trim(($reservation->member?->first_name ?? '').' '.($reservation->member?->last_name ?? '')),
                'canCancel' => in_array($normalizedStatus, ['pending', 'approved'], true),
                'cancelUrl' => route('student.reservations.cancel', $reservation),
            ];
        }

        return $data;
    }

    private function serializeBook(?BookData $book): array
    {
        $coverImage = $book?->bookDetail?->cover_image;

        return [
            'id' => $book ? (int) $book->book_data_id : null,
            'title' => $book?->book_title ?? 'Untitled book',
            'authors' => $book?->authors
                ->map(fn ($author) => trim(collect([
                    $author->first_name,
                    $author->last_name,
                ])->filter()->implode(' ')))
                ->filter()
                ->values()
                ->all() ?? [],
            'coverUrl' => $coverImage
                ? (str_starts_with($coverImage, 'data:image') ? $coverImage : asset('storage/'.ltrim($coverImage, '/')))
                : null,
            'isbn' => $book?->bookDetail?->isbn,
            'publicationYear' => $book?->bookDetail?->publication_year,
        ];
    }
}
