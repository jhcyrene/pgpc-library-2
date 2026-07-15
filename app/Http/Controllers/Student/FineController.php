<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\FineDue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FineController extends Controller
{
    public function index()
    {
        $member = Auth::guard('member')->user()->member;
        
        $fines = FineDue::with(['bookBorrow.book.bookData', 'finePayments'])
            ->whereHas('bookBorrow', function ($query) use ($member) {
                $query->where('member_id', $member->member_id);
            })
            ->orderBy('fine_date', 'desc')
            ->paginate(10);

        return view('student.fines.index', compact('fines'));
    }
}
