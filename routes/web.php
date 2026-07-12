<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookDataController;



Route::get('/', function () {
    return view('home');
});

// Admin Route Group protected by 'admin' middleware
// Route::prefix('admin')->middleware(['auth'])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('admin.dashboard');
//     })->name('admin.dashboard');
// });

Route::redirect('/admin', '/admin/dashboard')->name('admin');

Route::prefix('admin')->group(function () {
    // Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/dashboard', function () { return view('admin.dashboard');})->name('admin.dashboard');
    Route::get('/bookManager', [BookDataController::class, 'index'])->name('admin.bookManager');
    Route::get('/addBook', function () { return view('admin.addBook');})->name('admin.addBook');
});
// // Auth Design Routes
Route::prefix('student')->group(function () {
    Route::get('/login', function () { return view('auth.login'); });
    Route::get('/register', function () { return view('auth.register'); });
    Route::get('/forgot-password', function () { return view('auth.forgotpassword'); });
    Route::get('/forgot-password?otp=true', function () { return view('auth.otp'); });
});



// Route::get('catalog',[BookController::class,'catalog']);

// Route::post('/books/add',[BookController::class,'addbook']);//add books
// Route::get('booklist',[BookController::class,'booklist']);//display books

// Route::get('publisher',[PublisherController::class,'publisherlist']);//display publisher
// Route::post('/publisher/add',[PublisherController::class,'addpublisher']);//add publisher

// Route::get('author',function(){return view('author');});
// Route::get('category',[CategoryController::class,'categorylist']);//display category
// Route::post('/category/add',[CategoryController::class,'addcategory']);//add category
// Route::post('/category/sub',[CategoryController::class,'addsubcategory']);//add subcategory
// Route::get('/category/subcategory/{id}', [CategoryController::class, 'getSubCategory']);
// Route::get('/category/{id}', [CategoryController::class, 'getCategory']);

// Route::get('/cata', function () { return view('admin.circulation.fast-cataloging'); });




// Route::get('/register', function () { return view('auth.register'); });
// Route::get('/forgot-password', function () { return view('auth.forgot-password'); });

// // Legal Design Routes
// Route::get('/terms', function () { return view('terms.terms-of-service'); });
// Route::get('/privacy', function () { return view('terms.privacy-policy'); });

// // Admin Design Routes
// Route::prefix('admin')->group(function () {
//     Route::get('/', function () { return view('admin.index'); });
//     Route::get('/dashboard', function () { return view('admin.dashboard'); });
//     Route::get('/circulation', function () { return view('admin.circulation'); });
//     Route::get('/circulation/checkout', function () { return view('admin.circulation.checkout'); });
//     Route::get('/circulation/checkin', function () { return view('admin.circulation.checkin'); });
//     Route::get('/circulation/renew', function () { return view('admin.circulation.renew'); });
//     Route::get('/circulation/fast-cataloging', function () { return view('admin.circulation.fast-cataloging'); });
//     Route::get('/bookmanage', function () { return view('admin.books'); });
//     Route::get('/users', function () { return view('admin.users'); });
//     Route::get('/borrows', function () { return view('admin.borrows'); });
//     Route::get('/reservations', function () { return view('admin.reservations'); });
//     Route::get('/settings', function () { return view('admin.settings'); });
//     Route::get('/profile', function () { return view('admin.profile'); });
//     Route::get('/report', function () { return view('admin.report'); });
// });

// // User Design Routes
// Route::prefix('users')->group(function () {
//     Route::get('/', function () { return view('users.index'); });
//     Route::get('/dashboard', function () { return view('users.dashboard'); });
//     Route::get('/borrows', function () { return view('users.borrows'); });
//     Route::get('/reservations', function () { return view('users.reservations'); });
//     Route::get('/lists', function () { return view('users.lists'); });
//     Route::get('/history', function () { return view('users.history'); });
//     Route::get('/fines', function () { return view('users.fines'); });
//     Route::get('/profile', function () { return view('users.profile'); });
// });

// // OPAC Route
// Route::get('/opac', function () { return view('opac.list'); });
// // Route::get('/opac/list', function () { return view('opac.list'); });
