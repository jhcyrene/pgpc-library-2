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

        // Eager load relationships if needed, though service already handles most
        $summary = $this->dashboardService->getSummary($member);
        $currentBorrows = $this->dashboardService->getCurrentBorrows($member, 5);
        $reservations = $this->dashboardService->getReservationPreview($member, 3);
        $attentionItems = $this->dashboardService->getAttentionItems($member);

        return view('student.dashboard', compact(
            'summary',
            'currentBorrows',
            'reservations',
            'attentionItems'
        ));
    }
}
