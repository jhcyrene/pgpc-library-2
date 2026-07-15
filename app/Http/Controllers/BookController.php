<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookData;
use App\Http\Requests\StoreBookCopyRequest;
use App\Http\Requests\UpdateBookCopyRequest;
use Illuminate\Routing\Controller;

class BookController extends Controller
{
    /**
     * Display a listing of physical copies for a specific book.
     */
    public function index(BookData $bookData)
    {
        $bookData->load(['books', 'bookDetail', 'authors']);
        return view('admin.books.copies.index', compact('bookData'));
    }

    /**
     * Show the form for creating a new physical copy.
     */
    public function create(BookData $bookData)
    {
        $bookData->load(['bookDetail', 'authors']);
        return view('admin.books.copies.create', compact('bookData'));
    }

    /**
     * Store a newly created physical copy in storage.
     */
    public function store(StoreBookCopyRequest $request, BookData $bookData)
    {
        $data = $request->validated();
        $data['book_data_id'] = $bookData->book_data_id;
        
        Book::create($data);

        return redirect()->route('admin.books.copies.index', $bookData->book_data_id)
            ->with('success', 'Physical copy added successfully.');
    }

    /**
     * Show the form for editing the specified physical copy.
     */
    public function edit(\Illuminate\Http\Request $request, Book $book)
    {
        $book->load('bookData.bookDetail', 'bookData.authors');
        
        if ($request->ajax()) {
            return view('admin.books.copies.partials.edit_modal_content', compact('book'));
        }
        
        return view('admin.books.copies.edit', compact('book'));
    }

    /**
     * Update the specified physical copy in storage.
     */
    public function update(UpdateBookCopyRequest $request, Book $book)
    {
        $book->update($request->validated());

        return redirect()->route('admin.books.copies.index', $book->book_data_id)
            ->with('success', 'Physical copy updated successfully.');
    }

    /**
     * Remove or archive the specified physical copy.
     */
    public function destroy(Book $book)
    {
        // Check if there are active borrows for this copy
        $hasActiveBorrows = $book->bookBorrows()->where('status', 'Borrowed')->exists();

        if ($hasActiveBorrows) {
            return back()->with('error', 'Cannot delete this copy because it is currently borrowed.');
        }

        // We'll archive instead of delete to be safe, since there is no soft delete.
        $book->update(['status' => 'Archived']);

        return back()->with('success', 'Physical copy archived successfully.');
    }
}
