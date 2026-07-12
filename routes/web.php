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

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () { return view('admin.dashboard');})->name('dashboard');
    
    // API Routes
    Route::get('/api/publishers/search', [\App\Http\Controllers\PublisherController::class, 'search'])->name('api.publishers.search');
    
    // Legacy routes for sidebar compatibility
    Route::get('/bookManager', [BookDataController::class, 'index'])->name('bookManager');
    Route::get('/addBook', [BookDataController::class, 'create'])->name('addBook');
    
    // Book Management Routes
    Route::resource('books', BookDataController::class);

    // Book Physical Copies
    Route::get('books/{bookData}/copies', [\App\Http\Controllers\BookController::class, 'index'])->name('books.copies.index');
    Route::get('books/{bookData}/copies/create', [\App\Http\Controllers\BookController::class, 'create'])->name('books.copies.create');
    Route::post('books/{bookData}/copies', [\App\Http\Controllers\BookController::class, 'store'])->name('books.copies.store');
    Route::get('book-copies/{book}/edit', [\App\Http\Controllers\BookController::class, 'edit'])->name('book-copies.edit');
    Route::put('book-copies/{book}', [\App\Http\Controllers\BookController::class, 'update'])->name('book-copies.update');
    Route::delete('book-copies/{book}', [\App\Http\Controllers\BookController::class, 'destroy'])->name('book-copies.destroy');

    // Quick Add
    Route::get('books-quick/create', [\App\Http\Controllers\QuickBookController::class, 'create'])->name('books.quick-create');
    Route::post('books-quick', [\App\Http\Controllers\QuickBookController::class, 'store'])->name('books.quick-store');

    // Batch Add
    Route::get('books-batch/create', [\App\Http\Controllers\BatchBookController::class, 'create'])->name('books.batch-create');
    Route::post('books-batch/preview', [\App\Http\Controllers\BatchBookController::class, 'preview'])->name('books.batch-preview');
    Route::post('books-batch/import', [\App\Http\Controllers\BatchBookController::class, 'store'])->name('books.batch-store');
    Route::get('books-batch/template', [\App\Http\Controllers\BatchBookController::class, 'template'])->name('books.batch-template');

    // User Management
    Route::get('users', [\App\Http\Controllers\UserManagementController::class, 'index'])->name('users.index');
    Route::get('users/{type}/{id}', [\App\Http\Controllers\UserManagementController::class, 'show'])->name('users.show');

    Route::resource('members', \App\Http\Controllers\MemberController::class)->except(['index', 'show']);
    Route::resource('librarians', \App\Http\Controllers\LibrarianController::class)->except(['index', 'show']);

    Route::patch('accounts/{memberAuth}/status', [\App\Http\Controllers\MemberAuthController::class, 'updateStatus'])->name('accounts.status');
    Route::patch('accounts/{memberAuth}/unlock', [\App\Http\Controllers\MemberAuthController::class, 'unlock'])->name('accounts.unlock');
    Route::put('accounts/{memberAuth}/password', [\App\Http\Controllers\MemberAuthController::class, 'resetPassword'])->name('accounts.password');
});
// // Auth Design Routes
Route::prefix('student')->group(function () {
    Route::get('/login', function () { return view('auth.login'); });
    Route::get('/register', function () { return view('auth.register'); });
    Route::get('/forgot-password', function (\Illuminate\Http\Request $request) { 
        if ($request->query('otp') === 'true') {
            return view('auth.otp');
        }
        return view('auth.forgotpassword'); 
    });
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
