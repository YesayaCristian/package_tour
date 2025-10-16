<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Package Tour | @yield('title')</title>
    @vite('resources/js/app.js')
</head>
<body class="bg-gray-50 text-gray-800">

    {{-- Navbar --}}
    <nav class="bg-blue-600 text-white py-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-2xl font-bold">🌏 PackageTour</a>
            <div class="space-x-4 flex items-center">
                <a href="{{ route('packages') }}">Packages</a>

                {{-- 🔹 Tampilkan Cart & My Orders hanya jika user login sebagai customer --}}
                @auth
                    @if(auth()->user()->role === 'customer')
                        <a href="{{ route('cart') }}">Cart</a>
                        <a href="{{ route('orders') }}">My Orders</a>
                    @endif
                @endauth

                {{-- 🔹 Jika admin login, tampilkan link ke admin dashboard --}}
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="bg-white text-blue-600 px-3 py-1 rounded">
                            Admin Panel
                        </a>
                    @endif

                    {{-- Tombol Logout --}}
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-white text-blue-600 px-3 py-1 rounded">
                            Logout
                        </button>
                    </form>
                @else
                    {{-- Tombol Login untuk guest --}}
                    <a href="{{ route('login') }}" class="bg-white text-blue-600 px-3 py-1 rounded">Login</a>
                @endauth
            </div>
        </div>
    </nav>


    {{-- Main Content --}}
    <main class="container mx-auto py-8">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-gray-900 text-white py-4 text-center mt-10">
        <p>© 2025 PackageTour. All rights reserved.</p>
    </footer>

</body>
</html>
