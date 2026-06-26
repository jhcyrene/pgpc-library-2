<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    return view('welcome');
});



Route::get('catalog',[BookController::class,'catalog']);

Route::post('/books/add',[BookController::class,'addbook']);//add books
Route::get('booklist',[BookController::class,'booklist']);//display books

Route::get('publisher',[PublisherController::class,'publisherlist']);//display publisher
Route::post('/publisher/add',[PublisherController::class,'addpublisher']);//add publisher

Route::get('author',function(){return view('author');});
Route::get('category',[CategoryController::class,'categorylist']);//display category
Route::post('/category/add',[CategoryController::class,'addcategory']);//add category
Route::post('/category/sub',[CategoryController::class,'addsubcategory']);//add subcategory
Route::get('/category/subcategory/{id}', [CategoryController::class, 'getSubCategory']);
Route::get('/category/{id}', [CategoryController::class, 'getCategory']);

// Auth Design Routes
Route::get('/login', function () { return view('auth.login'); });
Route::get('/register', function () { return view('auth.register'); });
Route::get('/forgot-password', function () { return view('auth.forgot-password'); });

// Legal Design Routes
Route::get('/terms', function () { return view('terms.terms-of-service'); });
Route::get('/privacy', function () { return view('terms.privacy-policy'); });
