<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Publisher;
use App\Http\Requests\QuickStoreBookRequest;
use App\Services\BookService;
use Illuminate\Routing\Controller;

class QuickBookController extends Controller
{
    public function create()
    {
        $categories = Category::orderBy('category_name')->get();
        $publishers = Publisher::orderBy('publisher_name')->get();

        return view('admin.books.quickAdd', compact('categories', 'publishers'));
    }

    public function store(QuickStoreBookRequest $request, BookService $bookService)
    {
        $data = $request->validated();
        
        // Add defaults for quick add
        $data['status'] = 'Available';
        $data['language'] = 'English';
        $data['format'] = 'Print';
        $data['book_type'] = 'Book';

        if (!empty($data['category_id'])) {
            $data['categories'] = [$data['category_id']];
        }

        // Check for duplicates
        $duplicate = $bookService->checkDuplicate($data);
        if ($duplicate) {
            return back()->withInput()->with('error', 'A book with this ISBN or Title/Year already exists. Consider adding a copy instead.');
        }

        try {
            $bookService->createBook($data);
            return redirect()->route('admin.books.index')->with('success', 'Book quick-added successfully!');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Failed to quick-add book: ' . $e->getMessage());
        }
    }
}
