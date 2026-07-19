<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\FineDue;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class FineController extends Controller
{
    public function index(): Response
    {
        $member = Auth::guard('member')->user()->member;

        $memberFines = FineDue::query()
            ->whereHas('bookBorrow', function ($query) use ($member) {
                $query->where('member_id', $member->member_id);
            });

        $summaryFines = (clone $memberFines)
            ->withSum('finePayments', 'payment_amount')
            ->get(['fine_id', 'fine_total']);

        $fines = (clone $memberFines)
            ->with(['bookBorrow.book.bookData', 'finePayments' => fn ($query) => $query->orderBy('payment_date', 'desc')])
            ->orderBy('fine_date', 'desc')
            ->paginate(10)
            ->withQueryString();

        $items = $fines->getCollection()->map(function (FineDue $fine): array {
            $total = (float) $fine->fine_total;
            $totalPaid = (float) $fine->finePayments->sum('payment_amount');
            $balance = max(0, round($total - $totalPaid, 2));

            return [
                'id' => (int) $fine->fine_id,
                'book' => [
                    'title' => $fine->bookBorrow?->book?->bookData?->book_title ?? 'Untitled book',
                    'accessionNumber' => $fine->bookBorrow?->book?->accession_number,
                ],
                'fineDate' => $fine->fine_date?->format('M d, Y'),
                'amount' => $total,
                'totalPaid' => $totalPaid,
                'balance' => $balance,
                'isPaid' => $balance <= 0,
                'recordedStatus' => $fine->fine_status,
                'remarks' => $fine->remarks,
                'payments' => $fine->finePayments->map(fn ($payment) => [
                    'id' => (int) $payment->fine_payment_id,
                    'date' => $payment->payment_date?->format('M d, Y h:i A'),
                    'amount' => (float) $payment->payment_amount,
                    'method' => $payment->payment_method,
                    'receiptNumber' => $payment->official_receipt_no,
                    'remarks' => $payment->remarks,
                ])->values(),
            ];
        })->values();

        $assessed = (float) $summaryFines->sum(fn (FineDue $fine) => (float) $fine->fine_total);
        $paid = (float) $summaryFines->sum(fn (FineDue $fine) => (float) ($fine->fine_payments_sum_payment_amount ?? 0));

        return Inertia::render('Student/Fines/Index', [
            'fineSummary' => [
                'records' => $summaryFines->count(),
                'assessed' => $assessed,
                'paid' => $paid,
                'outstanding' => max(0, round($assessed - $paid, 2)),
            ],
            'fines' => [
                'data' => $items,
                'meta' => [
                    'currentPage' => $fines->currentPage(),
                    'lastPage' => $fines->lastPage(),
                    'total' => $fines->total(),
                    'from' => $fines->firstItem(),
                    'to' => $fines->lastItem(),
                ],
                'links' => [
                    'previous' => $fines->previousPageUrl(),
                    'next' => $fines->nextPageUrl(),
                ],
            ],
        ]);
    }
}
