<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordRecoveryController;
use App\Http\Controllers\Auth\RegisteredStudentController;
use App\Http\Controllers\BatchBookController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookDataController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\LibrarianController;
use App\Http\Controllers\Librarian\ProfileSettingsController;
use App\Http\Controllers\MemberAuthController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\QuickBookController;
use App\Http\Controllers\StaffDashboardController;
use App\Http\Controllers\Student\AccountSettingsController;
use App\Http\Controllers\Student\BorrowTransactionController;
use App\Http\Controllers\Student\FineController;
use App\Http\Controllers\Student\ProfileController;
use App\Http\Controllers\Student\ReservationController;
use App\Http\Controllers\Student\SavedItemController;
use App\Http\Controllers\Student\StudentDashboardController;
use App\Http\Controllers\Student\StudentSearchController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/opac', [CatalogController::class, 'index'])->name('opac.index');
Route::get('/opac-search', [CatalogController::class, 'advancedSearch'])->name('opac.search');
Route::get('/opac/book/{bookData}', [CatalogController::class, 'show'])->name('opac.book.show');

Route::get('/api/opac/books', [CatalogController::class, 'index'])->name('api.opac.books');
Route::get('/api/opac/books/{bookData}', [CatalogController::class, 'show'])->name('api.opac.book');

// Google Social Authentication (Accessible to guests for login & authenticated users for linking)
Route::get('/auth/google', [\App\Http\Controllers\Auth\SocialLoginController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [\App\Http\Controllers\Auth\SocialLoginController::class, 'handleGoogleCallback'])->name('auth.google.callback');

// Auth Routes
Route::middleware('guest:member')->group(function () {
    Route::get('/auth/google/link', [\App\Http\Controllers\Auth\SocialLoginController::class, 'showLinkForm'])->name('auth.google.link');
    Route::post('/auth/google/link', [\App\Http\Controllers\Auth\SocialLoginController::class, 'linkAccount'])->name('auth.google.link.submit');

    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'storeStudent'])->name('login.store');

    Route::get('/register', [RegisteredStudentController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredStudentController::class, 'store'])->name('register.store');

    Route::get('/forgot-password', [PasswordRecoveryController::class, 'create'])->name('forgot-password');
    Route::post('/forgot-password', [PasswordRecoveryController::class, 'sendCode'])
        ->middleware('throttle:5,1')
        ->name('forgot-password.send');
    Route::get('/forgot-password/verify', [PasswordRecoveryController::class, 'showOtp'])->name('forgot-password.otp');
    Route::post('/forgot-password/verify', [PasswordRecoveryController::class, 'verifyCode'])
        ->middleware('throttle:10,1')
        ->name('forgot-password.verify');
    Route::get('/forgot-password/reset', [PasswordRecoveryController::class, 'showReset'])->name('forgot-password.reset');
    Route::post('/forgot-password/reset', [PasswordRecoveryController::class, 'reset'])
        ->middleware('throttle:5,1')
        ->name('forgot-password.update');
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth:member')->name('logout');

// Student Routes
Route::prefix('student')->name('student.')->group(function () {

    // Protected Student Routes
    Route::middleware(['student'])->group(function () {
        // Unified Topbar Live Search & Dashboard Search Page
        Route::get('/search', [StudentSearchController::class, 'index'])->name('search');
        Route::get('/search-unified', [StudentSearchController::class, 'search'])->name('search-unified');

        // Dashboard
        Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');

        // Borrow Transactions
        Route::get('/borrow-transactions', [BorrowTransactionController::class, 'index'])->name('borrow-transactions.index');
        Route::get('/borrow-transactions/current', [BorrowTransactionController::class, 'current'])->name('borrow-transactions.current');
        Route::get('/borrow-transactions/history', [BorrowTransactionController::class, 'history'])->name('borrow-transactions.history');
        Route::get('/overdue-items', [BorrowTransactionController::class, 'overdue'])->name('overdue-items.index');

        // Saved Items
        Route::get('/saved-items', [SavedItemController::class, 'index'])->name('saved-items.index');
        Route::post('/saved-items/{bookData}', [SavedItemController::class, 'store'])->name('saved-items.store');
        Route::delete('/saved-items/{bookData}', [SavedItemController::class, 'destroy'])->name('saved-items.destroy');

        // Reservations
        Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
        Route::get('/reservations/create/{bookData}', [ReservationController::class, 'create'])->name('reservations.create');
        Route::get('/reservations/check-availability/{bookData}', [ReservationController::class, 'checkAvailability'])->name('reservations.check-availability');
        Route::post('/reservations/{bookData}', [ReservationController::class, 'store'])->name('reservations.store');
        Route::get('/reservations/{reservation}', [ReservationController::class, 'show'])->name('reservations.show');
        Route::patch('/reservations/{reservation}/cancel', [ReservationController::class, 'cancel'])->name('reservations.cancel');

        // Fines
        Route::get('/fines', [FineController::class, 'index'])->name('fines.index');

        // Profile & Settings
        Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
        Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::get('/profile/complete', [ProfileController::class, 'complete'])->name('profile.complete');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::post('/profile/complete', [ProfileController::class, 'storeComplete'])->name('profile.complete.store');

        Route::get('/account-settings', [AccountSettingsController::class, 'edit'])->name('account-settings.edit');
        Route::put('/account-settings/password', [AccountSettingsController::class, 'updatePassword'])->name('account-settings.password');
        Route::delete('/account-settings/unlink-google', [AccountSettingsController::class, 'unlinkGoogle'])->name('account-settings.unlink-google');
    });
});

Route::middleware('guest:member')->group(function () {
    Route::get('/staff/login', [AuthenticatedSessionController::class, 'createStaff'])->name('staff.login');
    Route::post('/staff/login', [AuthenticatedSessionController::class, 'storeStaff'])->name('staff.login.store');

    // Keep old bookmarks and cached forms working without maintaining separate login pages.
    Route::post('/admin/login', [AuthenticatedSessionController::class, 'storeStaff'])->name('adminlogin.store');
    Route::post('/librarian/login', [AuthenticatedSessionController::class, 'storeStaff'])->name('librarianlogin.store');
    Route::get('/admin/login', [AuthenticatedSessionController::class, 'redirectToStaffLogin'])->name('adminlogin');
    Route::get('/librarian/login', [AuthenticatedSessionController::class, 'redirectToStaffLogin'])->name('librarianlogin');
});

Route::prefix('librarian')->middleware(['librarian'])->name('librarian.')->group(function () {
    Route::redirect('/', '/librarian/dashboard')->name('home');
    Route::get('/dashboard', [StaffDashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/stats', [StaffDashboardController::class, 'stats'])->name('dashboard.stats');
    Route::get('/settings', [ProfileSettingsController::class, 'index'])->name('settings.index');
    Route::put('/settings/profile', [ProfileSettingsController::class, 'updateProfile'])->name('settings.profile');
    Route::put('/settings/password', [ProfileSettingsController::class, 'updatePassword'])->name('settings.password');
});

Route::prefix('admin')->middleware(['admin'])->name('admin.')->group(function () {
    Route::redirect('/', '/admin/dashboard')->name('home');

    Route::get('/dashboard', [StaffDashboardController::class, 'index'])
        ->middleware('administrator')
        ->name('dashboard');
    Route::get('/dashboard/stats', [StaffDashboardController::class, 'stats'])
        ->middleware('administrator')
        ->name('dashboard.stats');

    // API Routes
    Route::get('/api/publishers/search', [PublisherController::class, 'search'])->name('api.publishers.search');

    // Legacy routes for sidebar compatibility
    Route::get('/bookManager', [BookDataController::class, 'index'])->name('bookManager');
    Route::get('/addBook', [BookDataController::class, 'create'])->name('addBook');

    // Book Management Routes
    Route::resource('books', BookDataController::class)->parameters([
        'books' => 'bookData',
    ]);

    // Circulation
    Route::get('/circulation', [\App\Http\Controllers\CirculationController::class, 'index'])->name('circulation.index');
    Route::get('/api/circulation/stats', [\App\Http\Controllers\CirculationController::class, 'stats'])->name('circulation.stats');
    Route::get('/api/circulation/members/search', [\App\Http\Controllers\CirculationController::class, 'searchMembers'])->name('circulation.member.search');
    Route::get('/api/circulation/books/search', [\App\Http\Controllers\CirculationController::class, 'searchBooks'])->name('circulation.books.search');
    Route::get('/api/circulation/member/{identifier}', [\App\Http\Controllers\CirculationController::class, 'getMember'])->name('circulation.member');
    Route::get('/api/circulation/member-details/{identifier}', [\App\Http\Controllers\CirculationController::class, 'getMember'])->name('circulation.member.details');
    Route::get('/circulation/book/{identifier}', [\App\Http\Controllers\CirculationController::class, 'getBook'])->name('circulation.book');
    Route::get('/circulation/book-lookup', [\App\Http\Controllers\CirculationController::class, 'getBook'])->name('circulation.book.lookup');
    Route::post('/circulation/checkout', [\App\Http\Controllers\CirculationController::class, 'checkout'])->name('circulation.checkout');
    Route::post('/circulation/checkin', [\App\Http\Controllers\CirculationController::class, 'checkin'])->name('circulation.checkin');

    // Borrows
    Route::get('/borrows', [\App\Http\Controllers\LoanController::class, 'index'])->name('borrows.index');
    Route::get('/borrows/{borrow}', [\App\Http\Controllers\LoanController::class, 'show'])->name('borrows.show');
    Route::get('/api/borrows', [\App\Http\Controllers\LoanController::class, 'list'])->name('api.borrows.list');
    Route::post('/api/borrows/pay', [\App\Http\Controllers\LoanController::class, 'payFines'])->name('api.borrows.pay');
    Route::get('/api/borrows/stats', [\App\Http\Controllers\LoanController::class, 'stats'])->name('api.borrows.stats');

    // Book Physical Copies
    Route::get('books/{bookData}/copies', [BookController::class, 'index'])->name('books.copies.index');
    Route::get('books/{bookData}/copies/create', [BookController::class, 'create'])->name('books.copies.create');
    Route::post('books/{bookData}/copies', [BookController::class, 'store'])->name('books.copies.store');
    Route::get('book-copies/{book}/edit', [BookController::class, 'edit'])->name('book-copies.edit');
    Route::put('book-copies/{book}', [BookController::class, 'update'])->name('book-copies.update');
    Route::delete('book-copies/{book}', [BookController::class, 'destroy'])->name('book-copies.destroy');

    // Quick Add
    Route::get('books-quick/create', [QuickBookController::class, 'create'])->name('books.quick-create');
    Route::post('books-quick', [QuickBookController::class, 'store'])->name('books.quick-store');

    // Batch Add
    Route::get('books-batch/create', [BatchBookController::class, 'create'])->name('books.batch-create');
    Route::post('books-batch/preview', [BatchBookController::class, 'preview'])->name('books.batch-preview');
    Route::get('books-batch/preview/{batch_id}', [BatchBookController::class, 'showPreview'])->name('books.batch-preview.show');
    Route::post('books-batch/import', [BatchBookController::class, 'store'])->name('books.batch-store');
    Route::get('books-batch/template', [BatchBookController::class, 'template'])->name('books.batch-template');

    // MARC Import
    Route::get('books-marc/create', [BatchBookController::class, 'create'])->name('books.marc-create');
    Route::post('books-marc/preview', [\App\Http\Controllers\MarcImportController::class, 'preview'])->name('books.marc-preview');
    Route::get('books-marc/preview/{batch_id}', [\App\Http\Controllers\MarcImportController::class, 'showPreview'])->name('books.marc-preview.show');
    Route::post('books-marc/import', [\App\Http\Controllers\MarcImportController::class, 'store'])->name('books.marc-store');

    Route::middleware('administrator')->group(function () {
        // Administrator-only user and account management.
        Route::get('users', [UserManagementController::class, 'index'])->name('users.index');
        Route::get('users/{type}/{id}', [UserManagementController::class, 'show'])->name('users.show');

        Route::resource('members', MemberController::class)->except(['index', 'show']);
        Route::resource('librarians', LibrarianController::class)->except(['index', 'show']);

        Route::patch('accounts/{memberAuth}/status', [MemberAuthController::class, 'updateStatus'])->name('accounts.status');
        Route::patch('accounts/{memberAuth}/unlock', [MemberAuthController::class, 'unlock'])->name('accounts.unlock');
        Route::put('accounts/{memberAuth}/password', [MemberAuthController::class, 'resetPassword'])->name('accounts.password');
    });

    // Reservations (Book Requests)
    Route::get('reservations', [\App\Http\Controllers\BookRequestController::class, 'index'])->name('reservations.index');
    Route::get('reservations/{reservation}', [\App\Http\Controllers\BookRequestController::class, 'show'])->name('reservations.show');
    Route::patch('reservations/{reservation}/status', [\App\Http\Controllers\BookRequestController::class, 'updateStatus'])->name('reservations.status');

    // System Settings
    Route::get('/settings', [\App\Http\Controllers\SettingController::class, 'index'])->name('settings.index')->middleware('administrator');
    Route::post('/settings', [\App\Http\Controllers\SettingController::class, 'store'])->name('settings.store')->middleware('administrator');
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

// Legal Routes
Route::get('/privacy', function () { return view('privacy'); })->name('privacy');

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

// // OPAC Route
// Route::get('/opac', function () { return view('opac.list'); });
// // Route::get('/opac/list', function () { return view('opac.list'); });
