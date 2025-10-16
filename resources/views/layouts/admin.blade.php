<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | @yield('title')</title>
    @vite('resources/js/app.js')
</head>
<body class="bg-gray-100 text-gray-800">
    <div class="flex">
        <aside class="w-64 bg-gray-900 text-white min-h-screen p-4">
            <h2 class="text-2xl font-bold mb-6">Admin Panel</h2>
            <nav class="space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="block hover:bg-gray-700 p-2 rounded">Dashboard</a>
                <a href="{{ route('admin.packages') }}" class="block hover:bg-gray-700 p-2 rounded">Packages</a>
                <a href="{{ route('admin.orders') }}" class="block hover:bg-gray-700 p-2 rounded">Orders</a>
                <a href="{{ route('admin.users') }}" class="block hover:bg-gray-700 p-2 rounded">Users</a>
                <a href="{{ route('admin.payments') }}" class="block hover:bg-gray-700 p-2 rounded">Payments</a>
            </nav>
        </aside>

        <main class="flex-1 p-8">
            @yield('content')
        </main>
    </div>
</body>
</html>
