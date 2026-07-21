<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\StudentDashboardService;
use Illuminate\Support\Facades\Auth;

class StudentDashboardController extends Controller
{
    protected $dashboardService;

    public function __construct(StudentDashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index()
    {
        $member = Auth::guard('member')->user()->member;

        // Fetch all student dashboard data in a single optimized pass
        $dashboardData = $this->dashboardService->getDashboardData($member);

        $summary = $dashboardData['summary'];
        $currentBorrows = $dashboardData['currentBorrows'];
        $reservations = $dashboardData['reservations'];
        $attentionItems = $dashboardData['attentionItems'];

        // Fetch recommended books for the dashboard
        $recommendedBooks = \App\Models\BookData::with(['authors', 'bookDetail'])
            ->latest()
            ->take(6)
            ->get();

        return view('student.dashboard', compact(
            'summary',
            'currentBorrows',
            'reservations',
            'attentionItems',
            'recommendedBooks'
        ));
    }
}
