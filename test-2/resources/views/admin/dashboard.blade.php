<!-- resources/views/admin/dashboard.blade.php -->
@extends('layouts.admin')

@section('content')
<div class="container">
    <h2 class="text-2xl font-bold mb-4">Admin Dashboard</h2>
    <div class="grid grid-cols-3 gap-4">
        <div class="p-4 bg-green-200 rounded shadow">
            <h3 class="text-lg font-semibold">Books</h3>
            <p>Manage library books</p>
            <a href="{{ route('admin.books.index') }}" class="mt-2 block bg-blue-500 text-white p-2 rounded text-center hover:bg-blue-700">Manage Books</a>
        </div>
        <div class="p-4 bg-yellow-200 rounded shadow">
            <h3 class="text-lg font-semibold">Returned Books</h3>
            <p>Check returned books</p>
            <a href="{{ route('admin.returnedBooks') }}" class="mt-2 block bg-blue-500 text-white p-2 rounded text-center hover:bg-blue-700">View Returned Books</a>
        </div>
        <!-- Add more sections as needed -->
    </div>
</div>
@endsection