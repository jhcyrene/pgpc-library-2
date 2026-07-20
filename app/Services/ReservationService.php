<?php

namespace App\Services;

use App\Models\Member;
use App\Models\BookData;
use App\Models\BookRequest;
use App\Models\BookRequestStatus;
use Illuminate\Support\Facades\DB;
use Exception;

class ReservationService
{
    public function getAvailableCopiesCountOnDate(BookData $bookData, $date): int
    {
        $targetDate = \Carbon\Carbon::parse($date)->startOfDay();
        
        $totalCopies = $bookData->books()->count();
        if ($totalCopies <= 0) {
            return 0;
        }

        $activeBorrows = \App\Models\BookBorrow::whereHas('book', function ($q) use ($bookData) {
                $q->where('book_data_id', $bookData->book_data_id);
            })
            ->whereIn(DB::raw('LOWER(status)'), ['borrowed', 'overdue'])
            ->count();

        $activeReservations = \App\Models\BookRequest::where('book_data_id', $bookData->book_data_id)
            ->whereDate('pickup_date', $targetDate)
            ->whereHas('bookRequestStatus', function ($q) {
                $q->whereIn(DB::raw('LOWER(status_name)'), ['pending', 'approved', 'ready for pickup']);
            })
            ->count();

        $available = $totalCopies - $activeBorrows - $activeReservations;
        return max(0, $available);
    }

    public function checkEligibility(Member $member, BookData $bookData, $pickupDate = null): array
    {
        // 1. Check account status (assuming active)
        if ($member->memberAuth && strtolower((string) $member->memberAuth->account_status) !== 'active') {
            return ['eligible' => false, 'reason' => 'Your account is not active.'];
        }

        // 2. Check for existing active reservation for the same title
        $hasActiveReservation = BookRequest::where('member_id', $member->member_id)
            ->where('book_data_id', $bookData->book_data_id)
            ->whereHas('bookRequestStatus', function ($query) {
                $query->whereRaw(
                    'LOWER(status_name) IN (?, ?, ?)',
                    ['pending', 'approved', 'ready for pickup']
                );
            })->exists();

        if ($hasActiveReservation) {
            return ['eligible' => false, 'reason' => 'You already have an active reservation for this title.'];
        }

        // 3. Check for active borrow for the same title
        $hasActiveBorrow = $member->bookBorrows()
            ->whereRaw('LOWER(status) IN (?, ?)', ['borrowed', 'overdue'])
            ->whereHas('book', function ($query) use ($bookData) {
                $query->where('book_data_id', $bookData->book_data_id);
            })->exists();

        if ($hasActiveBorrow) {
            return ['eligible' => false, 'reason' => 'You are currently borrowing a copy of this title.'];
        }

        // 4. Check reservation limits (e.g. max 3 active reservations)
        $activeReservationsCount = BookRequest::where('member_id', $member->member_id)
            ->whereHas('bookRequestStatus', function ($query) {
                $query->whereRaw(
                    'LOWER(status_name) IN (?, ?, ?)',
                    ['pending', 'approved', 'ready for pickup']
                );
            })->count();

        if ($activeReservationsCount >= 3) {
            return ['eligible' => false, 'reason' => 'You have reached the maximum limit of 3 active reservations.'];
        }

        // 5. Check copy availability on selected pickup date
        if ($pickupDate) {
            $avail = $this->getAvailableCopiesCountOnDate($bookData, $pickupDate);
            if ($avail <= 0) {
                return ['eligible' => false, 'reason' => 'No copies of this book are available for reservation on the selected date.'];
            }
        }

        return ['eligible' => true, 'reason' => ''];
    }

    public function createReservation(Member $member, BookData $bookData, array $data = []): BookRequest
    {
        $pickupDate = $data['pickup_date'] ?? null;
        $eligibility = $this->checkEligibility($member, $bookData, $pickupDate);
        if (!$eligibility['eligible']) {
            throw new Exception($eligibility['reason']);
        }

        return DB::transaction(function () use ($member, $bookData, $data) {
            $pendingStatus = BookRequestStatus::whereRaw('LOWER(status_name) = ?', ['pending'])->first();
            if (!$pendingStatus) {
                throw new Exception('Pending status not found in database.');
            }

            $reservation = new BookRequest();
            $reservation->member_id = $member->member_id;
            $reservation->book_data_id = $bookData->book_data_id;
            $reservation->book_request_status_id = $pendingStatus->book_request_status_id;
            $reservation->request_date = now();
            $reservation->pickup_date = $data['pickup_date'] ?? null;
            $reservation->remarks = $data['remarks'] ?? null;
            $reservation->save();

            return $reservation;
        });
    }

    public function cancelReservation(Member $member, BookRequest $reservation): void
    {
        if ($reservation->member_id !== $member->member_id) {
            throw new Exception('Unauthorized to cancel this reservation.');
        }

        $currentStatus = strtolower((string) $reservation->bookRequestStatus->status_name);
        if (!in_array($currentStatus, ['pending', 'approved', 'ready for pickup'])) {
            throw new Exception("Cannot cancel a reservation with status: {$currentStatus}");
        }

        $cancelledStatus = BookRequestStatus::whereRaw('LOWER(status_name) = ?', ['cancelled'])->first();
        if (!$cancelledStatus) {
            throw new Exception('Cancelled status not found in database.');
        }

        $reservation->book_request_status_id = $cancelledStatus->book_request_status_id;
        $reservation->cancelled_at = now();
        $reservation->save();
    }
}
