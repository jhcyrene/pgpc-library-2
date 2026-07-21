<?php

namespace App\Services;

use App\Models\Member;
use App\Models\BookBorrow;
use App\Models\BookRequest;
use App\Models\FineDue;

class StudentDashboardService
{
    /**
     * Cache/Batch fetch all dashboard data for a member in minimal DB queries.
     */
    public function getDashboardData(Member $member): array
    {
        $memberId = $member->member_id;

        // 1. Fetch all BookBorrow records once for this member
        $allBorrows = BookBorrow::with(['book.bookData'])
            ->where('member_id', $memberId)
            ->get();

        $activeBorrows = $allBorrows->filter(function ($b) {
            $status = strtolower((string) $b->status);
            return in_array($status, ['borrowed', 'overdue'], true);
        });

        $now = now();
        $overdueBorrows = $activeBorrows->filter(function ($b) use ($now) {
            return $b->due_date && $b->due_date < $now;
        });

        // 2. Fetch all active/pending BookRequest records once for this member
        $allRequests = BookRequest::with(['bookData', 'bookRequestStatus'])
            ->where('member_id', $memberId)
            ->get();

        $pendingRequests = $allRequests->filter(function ($r) {
            return strtolower((string) ($r->bookRequestStatus?->status_name ?? '')) === 'pending';
        });

        $readyForPickupRequests = $allRequests->filter(function ($r) {
            return strtolower((string) ($r->bookRequestStatus?->status_name ?? '')) === 'ready for pickup';
        });

        $activeReservations = $allRequests->filter(function ($r) {
            $status = strtolower((string) ($r->bookRequestStatus?->status_name ?? ''));
            return in_array($status, ['pending', 'approved', 'ready for pickup'], true);
        });

        // 3. Outstanding Fines (1 query)
        $unpaidFines = FineDue::withSum('finePayments', 'payment_amount')
            ->whereHas('bookBorrow', function ($query) use ($memberId) {
                $query->where('member_id', $memberId);
            })
            ->whereRaw('LOWER(fine_status) IN (?, ?, ?)', ['unpaid', 'partial', 'partially paid'])
            ->get();

        $outstandingFines = $unpaidFines->sum(function (FineDue $fine) {
            return max(0, (float) $fine->fine_total - (float) ($fine->fine_payments_sum_payment_amount ?? 0));
        });
        $unpaidFinesCount = $unpaidFines->count();

        // 4. Construct Summary
        $summary = [
            'active_borrows'       => $activeBorrows->count(),
            'overdue_items'        => $overdueBorrows->count(),
            'pending_reservations' => $pendingRequests->count(),
            'ready_for_pickup'     => $readyForPickupRequests->count(),
            'outstanding_fines'    => $outstandingFines,
            'total_books_borrowed' => $allBorrows->count(),
        ];

        // 5. Current Borrows preview
        $currentBorrows = $activeBorrows->sortBy('due_date')->take(5)->values();

        // 6. Reservation preview
        $reservations = $activeReservations->sortByDesc('request_date')->take(3)->values();

        // 7. Attention items
        $attentionItems = [];

        foreach ($overdueBorrows as $item) {
            $dueDateStr = $item->due_date ? $item->due_date->format('M d, Y') : '';
            $attentionItems[] = [
                'type'       => 'overdue',
                'title'      => 'Overdue Item',
                'message'    => "The book '{$item->book?->bookData?->book_title}' was due on {$dueDateStr}.",
                'action_url' => route('student.overdue-items.index'),
            ];
        }

        foreach ($readyForPickupRequests as $item) {
            $deadlineStr = $item->expires_at ? $item->expires_at->format('M d, Y') : 'the deadline';
            $attentionItems[] = [
                'type'       => 'ready',
                'title'      => 'Ready for Pickup',
                'message'    => "Your reservation for '{$item->bookData?->book_title}' is ready for pickup until {$deadlineStr}.",
                'action_url' => route('student.reservations.index'),
            ];
        }

        if ($unpaidFinesCount > 0) {
            $attentionItems[] = [
                'type'       => 'fine',
                'title'      => 'Outstanding Fines',
                'message'    => "You have {$unpaidFinesCount} outstanding fine(s) that need your attention.",
                'action_url' => route('student.fines.index'),
            ];
        }

        return [
            'summary'        => $summary,
            'currentBorrows' => $currentBorrows,
            'reservations'   => $reservations,
            'attentionItems' => $attentionItems,
        ];
    }

    public function getSummary(Member $member): array
    {
        return $this->getDashboardData($member)['summary'];
    }

    public function getCurrentBorrows(Member $member, int $limit = 5)
    {
        return $this->getDashboardData($member)['currentBorrows']->take($limit);
    }

    public function getReservationPreview(Member $member, int $limit = 5)
    {
        return $this->getDashboardData($member)['reservations']->take($limit);
    }

    public function getAttentionItems(Member $member): array
    {
        return $this->getDashboardData($member)['attentionItems'];
    }
}
