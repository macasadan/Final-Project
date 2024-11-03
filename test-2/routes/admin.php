<?php

use App\Http\Controllers\Admin\AdminBookController;
use App\Http\Controllers\Admin\AdminController;

// Admin dashboard
Route::get('/dashboard', [AdminBookController::class, 'dashboard'])->name('dashboard');

// Admin book management routes
Route::resource('books', AdminBookController::class);
Route::get('/returned-books', [AdminController::class, 'returnedBooks'])->name('returnedBooks');
Route::get('/borrowed-books', [AdminController::class, 'borrowedBooks'])->name('borrowedBooks');
