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
        <aside class="w-64 bg-gray-900 text-white min-h-screen p-4 flex flex-col justify-between">
            <div>
                <h2 class="text-2xl font-bold mb-6">Admin Panel</h2>

                <nav class="space-y-2">
                    <a href="{{ route('admin.dashboard') }}"
                       class="block p-2 rounded {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                        Dashboard
                    </a>

                    <a href="{{ route('admin.packages.index') }}"
                       class="block p-2 rounded {{ request()->routeIs('admin.packages.*') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                        Packages
                    </a>

                    <a href="{{ route('admin.orders.index') }}"
                       class="block p-2 rounded {{ request()->routeIs('admin.orders.*') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                        Orders
                    </a>

                    <a href="{{ route('admin.users.index') }}"
                       class="block p-2 rounded {{ request()->routeIs('admin.users.*') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                        Users
                    </a>

                    <a href="{{ route('admin.payments.index') }}"
                       class="block p-2 rounded {{ request()->routeIs('admin.payments.*') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                        Payments
                    </a>
                </nav>
            </div>

            {{-- Tombol Logout --}}
            <form action="{{ route('logout') }}" method="POST" class="mt-6">
                @csrf
                <button type="submit"
                    class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2 rounded transition">
                    Logout
                </button>
            </form>
        </aside>

        <main class="flex-1 p-8">
            {{-- Flash message global --}}
            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @elseif(session('error'))
                <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>
