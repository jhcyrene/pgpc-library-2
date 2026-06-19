<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

Route::get('/', function () {
    return view('homepage');
});
Route::get('catalog',[BookController::class,'catalog']);

Route::post('/books/add',[BookController::class,'addbook']);//add books
Route::get('booklist',[BookController::class,'booklist']);
Route::get('publisher',function(){return view('publisher');});

