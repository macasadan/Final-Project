<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LostItemController;
use App\Http\Controllers\PCRoomController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\Admin\AdminBookController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminLostItemController;

// Admin Routes
Route::middleware(['auth', AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    // Admin dashboard route
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Admin book management routes
    Route::resource('books', AdminBookController::class);

    // Route for returned books list
    Route::get('/returned_books', [AdminController::class, 'returnedBooks'])->name('returnedBooks');
});



// User Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');


    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', [BookController::class, 'userDashboard'])->name('dashboard'); //  User dashboard
    });

    // Book actions
    Route::get('/books', [BookController::class, 'index'])->name('books.index'); // View available books
    Route::get('/books/search', [BookController::class, 'search'])->name('books.search'); // Search books
    Route::post('/books/borrow/{book}', [BookController::class, 'borrow'])->name('books.borrow'); // Borrow book
    Route::post('/books/reserve/{book}', [BookController::class, 'reserve'])->name('books.reserve'); // Reserve book
    Route::get('/borrowed_books', [BookController::class, 'borrowedBooks'])->name('borrowed.books');  // View borrowed books
    Route::get('/reserved_books', [BookController::class, 'reservedBooks'])->name('reserved.books');   // View reserved books
    Route::post('/books/return/{borrowId}', [BookController::class, 'returnBook'])->name('books.return');  // Return borrowed book


    // Lost items
    Route::get('/lost-items/report', function () {
        return view('lost_items.report');
    });
    Route::post('/lost-items/report', [LostItemController::class, 'report'])->name('lost_items.report');

    // PC Room reservation
    Route::post('/pc-rooms/reserve/{room}', [PCRoomController::class, 'reserve'])->name('pc_rooms.reserve');
});

// Public Routes
Route::get('/', function () {
    return view('welcome');
});

// Authenticated Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/dashboard', [ProfileController::class, 'dashboard'])->name('dashboard')->middleware('auth');
});

// Redirect to the correct login view 
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

require __DIR__ . '/auth.php';
