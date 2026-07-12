<?php

namespace App\Http\Controllers;

use App\Models\BookData;
use App\Http\Requests\StoreBookDataRequest;
use App\Http\Requests\UpdateBookDataRequest;
use Illuminate\Routing\Controller;

class BookDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allBooks = BookData::with('category')->paginate(10);
        return view('admin.bookManager', compact('allBooks'));   
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookDataRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(BookData $bookData)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BookData $bookData)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookDataRequest $request, BookData $bookData)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BookData $bookData)
    {
        //
    }
}
