<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\BookBorrow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowTransactionController extends Controller
{
    public function index()
    {
        $member = Auth::guard('member')->user()->member;

        $currentBorrows = BookBorrow::with(['book.bookData'])
            ->where('member_id', $member->member_id)
            ->whereRaw('LOWER(status) IN (?, ?)', ['borrowed', 'overdue'])
            ->orderBy('due_date', 'asc')
            ->limit(5)
            ->get();

        $history = BookBorrow::with(['book.bookData'])
            ->where('member_id', $member->member_id)
            ->whereRaw('LOWER(status) = ?', ['returned'])
            ->orderBy('return_date', 'desc')
            ->limit(5)
            ->get();

        return view('student.borrow-transactions.index', compact('currentBorrows', 'history'));
    }

    public function current(Request $request)
    {
        $member = Auth::guard('member')->user()->member;
        
        $query = BookBorrow::with(['book.bookData', 'fineDue'])
            ->where('member_id', $member->member_id)
            ->whereRaw('LOWER(status) IN (?, ?)', ['borrowed', 'overdue']);

        // Optional filtering/sorting
        if ($request->has('sort')) {
            if ($request->sort === 'due_date_asc') $query->orderBy('due_date', 'asc');
            elseif ($request->sort === 'due_date_desc') $query->orderBy('due_date', 'desc');
            elseif ($request->sort === 'issue_date_desc') $query->orderBy('issue_date', 'desc');
        } else {
            $query->orderBy('due_date', 'asc'); // Default
        }

        $borrows = $query->paginate(10);

        return view('student.borrow-transactions.current', compact('borrows'));
    }

    public function history(Request $request)
    {
        $member = Auth::guard('member')->user()->member;
        
        $query = BookBorrow::with(['book.bookData'])
            ->where('member_id', $member->member_id)
            ->whereRaw('LOWER(status) = ?', ['returned']);

        if ($request->has('sort')) {
            if ($request->sort === 'return_date_desc') $query->orderBy('return_date', 'desc');
            elseif ($request->sort === 'return_date_asc') $query->orderBy('return_date', 'asc');
        } else {
            $query->orderBy('return_date', 'desc'); // Default
        }

        $borrows = $query->paginate(15);

        return view('student.borrow-transactions.history', compact('borrows'));
    }

    public function overdue()
    {
        $member = Auth::guard('member')->user()->member;
        
        $overdueBorrows = BookBorrow::with(['book.bookData', 'fineDue'])
            ->where('member_id', $member->member_id)
            ->whereRaw('LOWER(status) IN (?, ?)', ['borrowed', 'overdue'])
            ->where('due_date', '<', now())
            ->orderBy('due_date', 'asc')
            ->paginate(10);

        return view('student.borrow-transactions.overdue', compact('overdueBorrows'));
    }
}
