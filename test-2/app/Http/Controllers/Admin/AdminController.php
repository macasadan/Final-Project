<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Borrow;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Method for displaying the admin dashboard
    public function dashboard()
    {
        // Example data: total number of books and total borrowed books
        $totalBooks = Book::count();
        $totalBorrowedBooks = Borrow::whereNull('returned_at')->count();

        // Pass data to the dashboard view
        return view('admin.dashboard', compact('totalBooks', 'totalBorrowedBooks'));
    }

    // Method for displaying the list of returned books
    public function returnedBooks(Request $request)
    {
        $query = Borrow::whereNotNull('returned_at')
            ->with(['book', 'user']);

        // Add filters if needed
        if ($request->has('date_from')) {
            $query->where('returned_at', '>=', $request->date_from);
        }
        if ($request->has('date_to')) {
            $query->where('returned_at', '<=', $request->date_to);
        }
        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('book', function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            })->orWhereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $returnedBooks = $query->latest('returned_at')
            ->paginate(10);

        return view('admin.returned_books', compact('returnedBooks'));
    }
}
