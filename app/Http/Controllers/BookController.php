<?php

namespace App\Http\Controllers;
use App\Models\Book;
use App\Models\Publisher;
use App\Models\Category;

use Illuminate\Http\Request;

class BookController extends Controller
{
    public function addbook(Request $request){
        Book::create([
            'BookID'=>$request->bookid,
            'ISBN'=>$request->isbn,
            'BookTitle'=>$request->title,
            'DatePublished'=>$request->datepublished,
            'Author'=>$request->author,
            'Publisher'=>$request->publisher,
            'Category'=>$request->category,
            'SubCategory'=>$request->subcategory,
            'Status'=>'available'
        ]);
        return redirect()->back()->with('success', 'Book Added to Catalog!');
    }
    public function catalog(){
        $books=Book::all();//get all data
        $publishers=Publisher::orderBy('Name','asc')->get();
        $categories=Category::orderBy('CategoryName','asc')->get();
        return view('catalog',compact('books','publishers','categories'));
        }
    public function booklist()
    {
        $books=Book::all();//get all data
        return view('booklist',compact('books'));
    }
}
