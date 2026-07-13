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
    public function checkEligibility(Member $member, BookData $bookData): array
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

        return ['eligible' => true, 'reason' => ''];
    }

    public function createReservation(Member $member, BookData $bookData, array $data = []): BookRequest
    {
        $eligibility = $this->checkEligibility($member, $bookData);
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
