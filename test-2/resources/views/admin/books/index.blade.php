<!-- resources/views/admin/books/index.blade.php -->

@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="mb-4">Books Management</h1>

    <!-- Flash Message for Successful Operations -->
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <!-- Button to Create New Book -->
    <a href="{{ route('admin.books.create') }}" class="btn btn-primary mb-3">Add New Book</a>

    <!-- Table of Books -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>Published Year</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($books as $book)
            <tr>
                <td>{{ $book->id }}</td>
                <td>{{ $book->title }}</td>
                <td>{{ $book->author }}</td>
                <td>{{ $book->published_year }}</td>
                <td>
                    <a href="{{ route('admin.books.edit', $book->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this book?')">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">No books found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination links -->
    <div class="mt-4">
        {{ $books->links() }}
    </div>
</div>
@endsection