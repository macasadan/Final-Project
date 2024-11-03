<!-- resources/views/borrowed_books.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-2xl font-bold mb-4">All Borrowed Books</h1>
    <div class="bg-white p-4 rounded shadow">
        <div class="bg-white p-4 rounded shadow">
            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
            @endif

            <div id="borrowed-books-list">
                @forelse($borrowedBooks as $borrow)
                <div class="p-2 bg-green-100 border-b flex justify-between items-center" id="borrowed-book-{{ $borrow->id }}">
                    <div>
                        <p><strong>Title:</strong> {{ $borrow->book->title }}</p>
                        <p><strong>Author:</strong> {{ $borrow->book->author }}</p>
                        <p><strong>Borrowed Date:</strong> {{ \Carbon\Carbon::parse($borrow->borrowed_date)->format('Y-m-d') }}</p>
                        <p><strong>Due Date:</strong> {{ \Carbon\Carbon::parse($borrow->due_date)->format('Y-m-d') }}</p>
                    </div>
                    <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700 return-book-btn" data-borrow-id="{{ $borrow->id }}">
                        Return
                    </button>
                </div>
                @empty
                <p>No borrowed books found.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Attach event listener to dynamically generated buttons
        document.querySelectorAll('.return-book-btn').forEach(button => {
            button.addEventListener('click', function() {
                const borrowId = this.getAttribute('data-borrow-id');
                const bookElement = document.getElementById('borrowed_books-' + borrowId);

                fetch(`/books/return/${borrowId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Remove the book from the list
                            bookElement.remove();
                            alert(data.success);
                        } else if (data.error) {
                            alert(data.error);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while returning the book. Please try again.');
                    });
            });
        });
    });
</script>
@endpush
@endsection