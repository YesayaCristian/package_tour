<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin TourTravels</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3B82F6',
                        secondary: '#1E40AF',
                        danger: '#EF4444',
                        success: '#10B981',
                        warning: '#F59E0B',
                    }
                }
            }
        }
    </script>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Admin Layout -->
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-lg">
            <div class="p-4 border-b">
                <h1 class="text-xl font-bold text-primary">TourTravels Admin</h1>
                <p class="text-sm text-gray-600">Panel Administrator</p>
            </div>
            
            <nav class="mt-6">
                <div class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase">Main Menu</div>
                
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-primary {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-primary border-r-2 border-primary' : '' }}">
                    <i class="fas fa-tachometer-alt w-6"></i>
                    <span class="ml-3">Dashboard</span>
                </a>
                
                <a href="{{ route('admin.packages.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-primary {{ request()->routeIs('admin.packages.*') ? 'bg-blue-50 text-primary border-r-2 border-primary' : '' }}">
                    <i class="fas fa-suitcase w-6"></i>
                    <span class="ml-3">Paket Wisata</span>
                </a>
                
                <a href="{{ route('admin.orders.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-primary {{ request()->routeIs('admin.orders.*') ? 'bg-blue-50 text-primary border-r-2 border-primary' : '' }}">
                    <i class="fas fa-shopping-cart w-6"></i>
                    <span class="ml-3">Pesanan</span>
                </a>
                
                <a href="{{ route('admin.payments.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-primary {{ request()->routeIs('admin.payments.*') ? 'bg-blue-50 text-primary border-r-2 border-primary' : '' }}">
                    <i class="fas fa-credit-card w-6"></i>
                    <span class="ml-3">Pembayaran</span>
                </a>

                <a href="{{ route('admin.reviews.index') }}" class="flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-primary {{ request()->routeIs('admin.reviews.*') ? 'bg-blue-50 text-primary border-r-2 border-primary' : '' }}">
                    <i class="fas fa-star w-6"></i>
                    <span class="ml-3">Reviews</span>
                    @php
                        $pendingReviewsCount = \App\Models\Review::where('status', 'pending')->count();
                    @endphp
                    @if($pendingReviewsCount > 0)
                        <span class="ml-auto bg-red-500 text-white rounded-full px-2 py-1 text-xs">
                            {{ $pendingReviewsCount }}
                        </span>
                    @endif
                </a>

                <div class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase mt-6">Account</div>
                
                <form method="POST" action="{{ route('logout') }}" class="px-4 py-3">
                    @csrf
                    <button type="submit" class="flex items-center w-full text-gray-700 hover:text-danger">
                        <i class="fas fa-sign-out-alt w-6"></i>
                        <span class="ml-3">Logout</span>
                    </button>
                </form>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Header -->
            <header class="bg-white shadow-sm">
                <div class="flex items-center justify-between px-6 py-4">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">@yield('header-title', 'Dashboard')</h2>
                        <p class="text-sm text-gray-600">@yield('header-subtitle', 'Selamat datang di admin panel')</p>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-800">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-600 capitalize">{{ Auth::user()->role }}</p>
                        </div>
                        <div class="w-10 h-10 bg-primary rounded-full flex items-center justify-center text-white font-semibold">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6">
                <!-- Notifications -->
                @if(session('success'))
                    <div class="bg-success text-white p-4 rounded-lg mb-6">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-2"></i>
                            {{ session('success') }}
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-danger text-white p-4 rounded-lg mb-6">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i>
                            {{ session('error') }}
                        </div>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>