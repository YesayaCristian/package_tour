@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('header-title', 'Dashboard')
@section('header-subtitle', 'Overview sistem TourTravels')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Stat Card 1 -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                <i class="fas fa-users text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total Customers</p>
                <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_users'] }}</p>
            </div>
        </div>
    </div>

    <!-- Stat Card 2 -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-600">
                <i class="fas fa-suitcase text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total Paket</p>
                <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_packages'] }}</p>
            </div>
        </div>
    </div>

    <!-- Stat Card 3 -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                <i class="fas fa-shopping-cart text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total Pesanan</p>
                <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_orders'] }}</p>
            </div>
        </div>
    </div>

    <!-- Stat Card 4 -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                <i class="fas fa-money-bill-wave text-xl"></i>
            </div>
            <div class="ml-4">
                <p class="text-sm font-medium text-gray-600">Total Pendapatan</p>
                <p class="text-2xl font-semibold text-gray-900">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Recent Orders -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b">
            <h3 class="text-lg font-semibold text-gray-800">Pesanan Terbaru</h3>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @foreach($recent_orders as $order)
                <div class="flex items-center justify-between p-4 border rounded-lg">
                    <div>
                        <p class="font-medium text-gray-900">#{{ $order->order_code }}</p>
                        <p class="text-sm text-gray-600">{{ $order->user->name }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                            {{ $order->status === 'paid' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="mt-4 text-center">
                <a href="{{ route('admin.orders.index') }}" class="text-primary hover:text-secondary text-sm font-medium">
                    Lihat semua pesanan →
                </a>
            </div>
        </div>
    </div>

    <!-- Popular Packages -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b">
            <h3 class="text-lg font-semibold text-gray-800">Paket Populer</h3>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @foreach($popular_packages as $package)
                <div class="flex items-center justify-between p-4 border rounded-lg">
                    <div class="flex items-center">
                        <img src="{{ $package->image ? asset('storage/' . $package->image) : 'https://via.placeholder.com/50?text=Tour' }}" 
                             alt="{{ $package->title }}" class="w-12 h-12 rounded-lg object-cover">
                        <div class="ml-4">
                            <p class="font-medium text-gray-900">{{ Str::limit($package->title, 30) }}</p>
                            <p class="text-sm text-gray-600">{{ $package->location }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold">Rp {{ number_format($package->price, 0, ',', '.') }}</p>
                        <p class="text-sm text-gray-600">{{ $package->order_items_count }} pesanan</p>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="mt-4 text-center">
                <a href="{{ route('admin.packages.index') }}" class="text-primary hover:text-secondary text-sm font-medium">
                    Lihat semua paket →
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="mt-8 bg-white rounded-lg shadow">
    <div class="px-6 py-4 border-b">
        <h3 class="text-lg font-semibold text-gray-800">Quick Actions</h3>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('admin.packages.create') }}" class="flex items-center p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-primary hover:bg-blue-50 transition duration-200">
                <i class="fas fa-plus text-primary text-xl mr-3"></i>
                <div>
                    <p class="font-medium text-gray-900">Tambah Paket Baru</p>
                    <p class="text-sm text-gray-600">Buat paket wisata baru</p>
                </div>
            </a>
            
            <a href="{{ route('admin.orders.index') }}" class="flex items-center p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-primary hover:bg-blue-50 transition duration-200">
                <i class="fas fa-shopping-cart text-primary text-xl mr-3"></i>
                <div>
                    <p class="font-medium text-gray-900">Kelola Pesanan</p>
                    <p class="text-sm text-gray-600">{{ $stats['pending_orders'] }} pesanan pending</p>
                </div>
            </a>
            
            <a href="{{ route('admin.payments.index') }}" class="flex items-center p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-primary hover:bg-blue-50 transition duration-200">
                <i class="fas fa-credit-card text-primary text-xl mr-3"></i>
                <div>
                    <p class="font-medium text-gray-900">Verifikasi Pembayaran</p>
                    <p class="text-sm text-gray-600">{{ $stats['pending_payments'] }} menunggu</p>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection