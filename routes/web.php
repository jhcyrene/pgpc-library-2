<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\PublisherController;

Route::get('/', function () {
    return view('homepage');
});
Route::get('catalog',[BookController::class,'catalog']);

Route::post('/books/add',[BookController::class,'addbook']);//add books
Route::get('booklist',[BookController::class,'booklist']);//display books

Route::post('/publisher/add',[PublisherController::class,'addpublisher']);//add publisher
Route::get('publisher',[PublisherController::class,'publisherlist']);//display publisher

