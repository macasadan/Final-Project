<?php


namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{

    public function dashboard()
    {
        // Fetch reserved books for the authenticated user
        $reservedBooks = Reservation::where('user_id', Auth::id())->with('book')->limit(2)->get();

        // Fetch borrowed books for the authenticated user
        $borrowedBooks = Borrow::where('user_id', Auth::id())->with('book')->limit(2)->get();

        return view('dashboard', compact('reservedBooks', 'borrowedBooks'));
    }

    // Users return a borrowed book
    public function returnBook(Request $request, $borrowId)
    {
        DB::beginTransaction();
        try {
            $borrow = Borrow::where('id', $borrowId)
                ->where('user_id', Auth::id())
                ->whereNull('returned_at')
                ->firstOrFail();

            // Check if the book is already returned
            if ($borrow->returned_at) {
                return $request->ajax()
                    ? response()->json(['error' => 'This book has already been returned.'], 400)
                    : redirect()->back()->with('error', 'This book has already been returned.');
            }

            // Update book quantity
            $borrow->book->increment('quantity');

            // Update borrow record with return details
            $borrow->update([
                'returned_at' => now(),
                'return_status' => 'returned',
                'returned_condition' => $request->input('condition') // Optional: If you want to track book condition
            ]);

            DB::commit();

            return $request->ajax()
                ? response()->json(['success' => 'Book returned successfully!', 'borrowId' => $borrowId])
                : redirect()->back()->with('success', 'Book returned successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return $request->ajax()
                ? response()->json(['error' => 'Error returning book. Please try again.'], 500)
                : redirect()->back()->with('error', 'Error returning book. Please try again.');
        }
    }




    // Search for books
    public function search(Request $request)
    {
        $query = $request->input('query');
        $books = Book::where('title', 'LIKE', "%{$query}%")
            ->orWhere('author', 'LIKE', "%{$query}%")
            ->get();

        return view('books.search', compact('books'));
    }

    // Users Borrow a book
    public function borrow(Book $book)
    {
        // Check if the book is available
        if ($book->quantity > 0) {
            // Reduce the quantity of the book
            $book->decrement('quantity');

            // Create a borrow record
            $borrow = Borrow::create([
                'user_id' => Auth::id(),
                'book_id' => $book->id,
                'borrow_date' => now(), // Set the current timestamp as the borrowed date
                'due_date' => now()->addDays(14), // Example: Set the due date 14 days from now
            ]);

            return redirect()->back()->with('success', 'Book borrowed successfully!');
        } else {
            return redirect()->back()->with('error', 'Book is not available.');
        }
    }

    // Reserve a book
    public function reserve(Book $book)
    {
        // Check if the user has already reserved this book
        $existingReservation = Reservation::where('user_id', Auth::id())
            ->where('book_id', $book->id)
            ->first();

        if ($existingReservation) {
            return redirect()->back()->with('error', 'You have already reserved this book.');
        }

        // Create a reservation
        $reservation = Reservation::create([
            'user_id' => Auth::id(),
            'book_id' => $book->id,
            'reservation_date' => Carbon::now(), // Set the current date and time
        ]);

        return redirect()->back()->with('success', 'Book reserved successfully!');
    }

    // Borrowing and Reservation Logic

    public function borrowedBooks()
    {
        // Fetch all borrowed books for the authenticated user
        $borrowedBooks = Borrow::where('user_id', Auth::id())
            ->whereNull('returned_at') // Only show books not yet returned
            ->with('book') // Include book details for easy access
            ->get();
        return view('borrowed_books', compact('borrowedBooks'));
    }

    public function reservedBooks()
    {
        // Fetch all reserved books for the authenticated user
        $reservedBooks = Reservation::where('user_id', Auth::id())->with('book')->get();
        return view('reserved_books', compact('reservedBooks'));
    }


    // Show available books
    public function index()
    {
        $books = Book::where('quantity', '>', 0)->get();
        return view('books.index', compact('books'));
    }
}
