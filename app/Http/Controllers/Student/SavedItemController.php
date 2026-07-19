<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\BookData;
use App\Models\SavedItem;
use App\Services\SavedItemService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class SavedItemController extends Controller
{
    protected $savedItemService;

    public function __construct(SavedItemService $savedItemService)
    {
        $this->savedItemService = $savedItemService;
    }

    public function index(): Response
    {
        $member = Auth::guard('member')->user()->member;

        $savedItems = SavedItem::with(['bookData.authors', 'bookData.bookDetail'])
            ->where('member_id', $member->member_id)
            ->orderBy('created_at', 'desc')
            ->paginate(12)
            ->withQueryString();

        $items = $savedItems->getCollection()->map(function (SavedItem $savedItem): array {
            $book = $savedItem->bookData;
            $coverImage = $book?->bookDetail?->cover_image;

            return [
                'id' => (int) $savedItem->saved_item_id,
                'bookId' => (int) $savedItem->book_data_id,
                'title' => $book?->book_title ?? 'Untitled book',
                'authors' => $book?->authors
                    ->map(fn ($author) => trim(collect([
                        $author->first_name,
                        $author->middle_name,
                        $author->last_name,
                        $author->suffix,
                    ])->filter()->implode(' ')))
                    ->filter()
                    ->values()
                    ->all() ?? [],
                'coverUrl' => $coverImage
                    ? (str_starts_with($coverImage, 'data:image') ? $coverImage : asset('storage/'.ltrim($coverImage, '/')))
                    : null,
                'savedAt' => $savedItem->created_at?->format('M d, Y'),
                'actions' => [
                    'reserve' => route('student.reservations.create', $book),
                    'remove' => route('student.saved-items.destroy', $book),
                ],
            ];
        })->values();

        return Inertia::render('Student/SavedItems/Index', [
            'savedItems' => [
                'data' => $items,
                'meta' => [
                    'currentPage' => $savedItems->currentPage(),
                    'lastPage' => $savedItems->lastPage(),
                    'total' => $savedItems->total(),
                    'from' => $savedItems->firstItem(),
                    'to' => $savedItems->lastItem(),
                ],
                'links' => [
                    'previous' => $savedItems->previousPageUrl(),
                    'next' => $savedItems->nextPageUrl(),
                ],
            ],
        ]);
    }

    public function store(Request $request, BookData $bookData)
    {
        $member = Auth::guard('member')->user()->member;
        
        $this->savedItemService->saveItem($member, $bookData);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'saved' => true,
                'message' => 'Title saved to your list.',
            ]);
        }

        return back()->with('success', 'Title saved to your list.');
    }

    public function destroy(Request $request, BookData $bookData)
    {
        $member = Auth::guard('member')->user()->member;
        
        $this->savedItemService->removeItem($member, $bookData);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'saved' => false,
                'message' => 'Title removed from your list.',
            ]);
        }

        return back()->with('success', 'Title removed from your list.');
    }
}
