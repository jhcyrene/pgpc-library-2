<?php

namespace App\Services;

use App\Models\Member;
use App\Models\BookBorrow;
use App\Models\BookRequest;
use App\Models\FineDue;

class StudentDashboardService
{
    public function getSummary(Member $member): array
    {
        $outstandingFines = FineDue::withSum('finePayments', 'payment_amount')
            ->whereHas('bookBorrow', function ($query) use ($member) {
                $query->where('member_id', $member->member_id);
            })
            ->whereRaw('LOWER(fine_status) IN (?, ?, ?)', ['unpaid', 'partial', 'partially paid'])
            ->get()
            ->sum(function (FineDue $fine) {
                return max(0, (float) $fine->fine_total - (float) ($fine->fine_payments_sum_payment_amount ?? 0));
            });

        return [
            'active_borrows' => BookBorrow::where('member_id', $member->member_id)
                ->whereRaw('LOWER(status) IN (?, ?)', ['borrowed', 'overdue'])
                ->count(),
            'overdue_items' => BookBorrow::where('member_id', $member->member_id)
                ->whereRaw('LOWER(status) IN (?, ?)', ['borrowed', 'overdue'])
                ->where('due_date', '<', now())
                ->count(),
            'pending_reservations' => BookRequest::where('member_id', $member->member_id)
                ->whereHas('bookRequestStatus', function ($query) {
                    $query->whereRaw('LOWER(status_name) = ?', ['pending']);
                })
                ->count(),
            'ready_for_pickup' => BookRequest::where('member_id', $member->member_id)
                ->whereHas('bookRequestStatus', function ($query) {
                    $query->whereRaw('LOWER(status_name) = ?', ['ready for pickup']);
                })
                ->count(),
            'outstanding_fines' => $outstandingFines,
            'total_books_borrowed' => BookBorrow::where('member_id', $member->member_id)
                ->count(),
        ];
    }

    public function getCurrentBorrows(Member $member, int $limit = 5)
    {
        return BookBorrow::with(['book.bookData'])
            ->where('member_id', $member->member_id)
            ->whereRaw('LOWER(status) IN (?, ?)', ['borrowed', 'overdue'])
            ->orderBy('due_date', 'asc')
            ->limit($limit)
            ->get();
    }

    public function getReservationPreview(Member $member, int $limit = 5)
    {
        return BookRequest::with(['bookData', 'bookRequestStatus'])
            ->where('member_id', $member->member_id)
            ->whereHas('bookRequestStatus', function ($query) {
                $query->whereRaw('LOWER(status_name) IN (?, ?, ?)', ['pending', 'approved', 'ready for pickup']);
            })
            ->orderBy('request_date', 'desc')
            ->limit($limit)
            ->get();
    }

    public function getAttentionItems(Member $member): array
    {
        $attention = [];

        // Overdue items
        $overdue = BookBorrow::with(['book.bookData'])
            ->where('member_id', $member->member_id)
            ->whereRaw('LOWER(status) IN (?, ?)', ['borrowed', 'overdue'])
            ->where('due_date', '<', now())
            ->get();
            
        foreach ($overdue as $item) {
            $attention[] = [
                'type' => 'overdue',
                'title' => 'Overdue Item',
                'message' => "The book '{$item->book?->bookData?->book_title}' was due on " . $item->due_date->format('M d, Y') . ".",
                'action_url' => route('student.overdue-items.index')
            ];
        }

        // Ready for pickup
        $ready = BookRequest::with(['bookData'])
            ->where('member_id', $member->member_id)
            ->whereHas('bookRequestStatus', function ($query) {
                $query->whereRaw('LOWER(status_name) = ?', ['ready for pickup']);
            })
            ->get();

        foreach ($ready as $item) {
            $attention[] = [
                'type' => 'ready',
                'title' => 'Ready for Pickup',
                'message' => "Your reservation for '{$item->bookData?->book_title}' is ready for pickup until " . ($item->expires_at ? $item->expires_at->format('M d, Y') : 'the deadline') . ".",
                'action_url' => route('student.reservations.index')
            ];
        }
        
        // Outstanding fines summary
        $unpaidFinesCount = FineDue::whereHas('bookBorrow', function ($query) use ($member) {
                $query->where('member_id', $member->member_id);
            })
            ->whereRaw('LOWER(fine_status) IN (?, ?, ?)', ['unpaid', 'partial', 'partially paid'])
            ->count();
            
        if ($unpaidFinesCount > 0) {
            $attention[] = [
                'type' => 'fine',
                'title' => 'Outstanding Fines',
                'message' => "You have {$unpaidFinesCount} outstanding fine(s) that need your attention.",
                'action_url' => route('student.fines.index')
            ];
        }

        return $attention;
    }
}
