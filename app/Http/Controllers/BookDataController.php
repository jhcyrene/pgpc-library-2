<?php

namespace App\Http\Controllers;

use App\Models\BookData;
use App\Models\Category;
use App\Models\Publisher;
use App\Http\Requests\StoreBookDataRequest;
use App\Http\Requests\UpdateBookDataRequest;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use App\Services\BookService;
use App\Models\Author;

class BookDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = BookData::query()
            ->with([
                'bookDetail.publisher',
                'authors',
                'categories',
                'books',
            ])
            ->withCount([
                'books as copies_total',
                'books as copies_available' => function ($q) {
                    $q->where('status', 'Available');
                },
                'books as copies_borrowed' => function ($q) {
                    $q->where('status', 'Borrowed');
                },
            ]);

        // Search
        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('book_title', 'like', "%{$search}%")
                  ->orWhere('subtitle', 'like', "%{$search}%")
                  ->orWhereHas('authors', function($q) use ($search) {
                      $q->where('last_name', 'like', "%{$search}%")
                        ->orWhere('first_name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('bookDetail', function($q) use ($search) {
                      $q->where('isbn', 'like', "%{$search}%")
                        ->orWhere('issn', 'like', "%{$search}%")
                        ->orWhere('call_number', 'like', "%{$search}%");
                  });
            });
        }

        // Filters
        if ($categoryId = $request->input('category_id')) {
            $query->whereHas('categories', function($q) use ($categoryId) {
                $q->where('categories.category_id', $categoryId);
            });
        }

        if ($publisherId = $request->input('publisher_id')) {
            $query->whereHas('bookDetail', function($q) use ($publisherId) {
                $q->where('publisher_id', $publisherId);
            });
        }

        $query->orderBy('created_at', 'desc');

        $allBooks = $query->paginate(10)->withQueryString();
        
        $categories = Category::orderBy('category_name')->get();
        $publishers = Publisher::orderBy('publisher_name')->get();

        if ($request->ajax()) {
            return view('admin.books.partials.table', compact('allBooks'))->render();
        }

        return view('admin.bookManager', compact('allBooks', 'categories', 'publishers'));   
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('category_name')->get();
        $publishers = Publisher::orderBy('publisher_name')->get();
        $authors = Author::orderBy('last_name')->get();

        return view('admin.addBook', compact('categories', 'publishers', 'authors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookDataRequest $request, BookService $bookService)
    {
        // Check for duplicates first
        $duplicate = $bookService->checkDuplicate($request->validated());
        if ($duplicate) {
            return back()->withInput()->with('error', 'A book with this ISBN or Title/Year already exists. Consider adding a copy instead.');
        }

        try {
            $bookData = $bookService->createBook($request->validated());
            return redirect()->route('admin.books.index')->with('success', 'Book added successfully!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Failed to add book: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, BookData $bookData)
    {
        $bookData->load([
            'bookDetail.publisher',
            'authors',
            'categories',
            'books'
        ]);

        if ($request->ajax()) {
            return view('admin.books.partials.show_modal', compact('bookData'));
        }

        return view('admin.books.show', compact('bookData'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BookData $bookData)
    {
        $bookData->load(['bookDetail', 'authors', 'categories']);
        
        $categories = Category::orderBy('category_name')->get();
        $publishers = Publisher::orderBy('publisher_name')->get();
        $authors = Author::orderBy('last_name')->get();

        return view('admin.books.edit', compact('bookData', 'categories', 'publishers', 'authors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookDataRequest $request, BookData $bookData, BookService $bookService)
    {
        try {
            $bookService->updateBook($bookData, $request->validated());
            return redirect()->route('admin.books.index')->with('success', 'Book updated successfully!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Failed to update book: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BookData $bookData, BookService $bookService)
    {
        try {
            $success = $bookService->deleteBook($bookData);
            if ($success) {
                return redirect()->route('admin.books.index')->with('success', 'Book and all copies deleted successfully.');
            } else {
                return back()->with('error', 'Cannot delete book because one or more copies are currently borrowed.');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete book: ' . $e->getMessage());
        }
    }
}
