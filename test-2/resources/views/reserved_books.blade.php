@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-2xl font-bold mb-4">All Reserved Books</h1>
    <div class="bg-white p-4 rounded shadow">
        @forelse($reservedBooks as $reservation)
        <div class="p-2 bg-yellow-100 border-b">
            <p><strong>Title:</strong> {{ $reservation->book->title }}</p>
            <p><strong>Author:</strong> {{ $reservation->book->author }}</p>
            <p><strong>Reservation Date:</strong> {{ $reservation->created_at->format('Y-m-d H:i:s') }}</p>
        </div>
        @empty
        <p>No reserved books found.</p>
        @endforelse
    </div>
</div>
@endsection