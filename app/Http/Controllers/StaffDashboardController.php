<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookBorrow;
use App\Models\BookData;
use App\Models\BookRequest;
use App\Models\Member;
use Illuminate\View\View;

class StaffDashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_titles' => BookData::query()->count(),
            'total_copies' => Book::query()->count(),
            'active_members' => Member::query()
                ->whereHas('memberAuth', function ($query) {
                    $query->whereRaw('LOWER(account_status) = ?', ['active']);
                })
                ->count(),
            'borrowed_items' => BookBorrow::query()
                ->whereRaw('LOWER(status) IN (?, ?)', ['borrowed', 'overdue'])
                ->count(),
            'overdue_items' => BookBorrow::query()
                ->whereRaw('LOWER(status) IN (?, ?)', ['borrowed', 'overdue'])
                ->where('due_date', '<', now())
                ->count(),
            'pending_reservations' => BookRequest::query()
                ->whereHas('bookRequestStatus', function ($query) {
                    $query->whereRaw('LOWER(status_name) = ?', ['pending']);
                })
                ->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
