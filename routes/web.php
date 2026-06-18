<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

Route::get('/', function () {
    return view('homepage');
});
Route::get('catalog',[BookController::class,'catalog']);

Route::post('/books/add',[BookController::class,'addbook']);//add books
