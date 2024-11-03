<!-- resources/views/layouts/admin.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col">
        <header class="bg-blue-800 text-white p-4 flex justify-between items-center">
            <h1 class="text-3xl font-bold">Admin Dashboard</h1>
            <nav class="flex items-center space-x-4">
                <a href="{{ route('admin.dashboard') }}" class="hover:underline">Dashboard</a>
                <a href="{{ route('admin.books.index') }}" class="hover:underline">Manage Books</a>
                <a href="{{ route('admin.returnedBooks') }}" class="hover:underline">Returned Books</a>

                <!-- Logout Button -->
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="hover:underline">Logout</button>
                </form>
            </nav>
        </header>

        <main class="flex-grow p-4">
            @yield('content')
        </main>

        <footer class="bg-gray-800 text-white p-2 text-center">
            <p>Library Management System &copy; {{ date('Y') }}</p>
        </footer>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>