<!-- resources/views/admin/books/create.blade.php -->

@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Add New Book</h1>

    <form action="{{ route('admin.books.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Author</label>
            <input type="text" name="author" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Published Year</label>
            <input type="number" name="published_year" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Description</label>
            <input type="text" name="isbn" class="form-control" required>
        </div>
        <div class="form-group">
            <label>ISBN</label>
            <input type="text" name="isbn" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Quantity</label>
            <input type="number" name="quantity" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Add Book</button>
    </form>
</div>
@endsection