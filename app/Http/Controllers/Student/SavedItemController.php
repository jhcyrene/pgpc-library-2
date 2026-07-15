<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\BookData;
use App\Models\SavedItem;
use App\Services\SavedItemService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SavedItemController extends Controller
{
    protected $savedItemService;

    public function __construct(SavedItemService $savedItemService)
    {
        $this->savedItemService = $savedItemService;
    }

    public function index()
    {
        $member = Auth::guard('member')->user()->member;

        $savedItems = SavedItem::with(['bookData.authors'])
            ->where('member_id', $member->member_id)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('student.saved-items.index', compact('savedItems'));
    }

    public function store(Request $request, BookData $bookData)
    {
        $member = Auth::guard('member')->user()->member;
        
        $this->savedItemService->saveItem($member, $bookData);

        return back()->with('success', 'Title saved to your list.');
    }

    public function destroy(BookData $bookData)
    {
        $member = Auth::guard('member')->user()->member;
        
        $this->savedItemService->removeItem($member, $bookData);

        return back()->with('success', 'Title removed from your list.');
    }
}
