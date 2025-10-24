@extends('layouts.app')

@section('title', 'Paket Wisata - TourTravels')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Paket Wisata</h1>
        <p class="text-gray-600">Temukan pengalaman wisata terbaik dengan paket pilihan kami</p>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <form action="{{ route('packages.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi</label>
                <input type="text" name="location" value="{{ request('location') }}" 
                       placeholder="Cari lokasi..." 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Harga Min</label>
                <input type="number" name="min_price" value="{{ request('min_price') }}" 
                       placeholder="Harga minimum" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Harga Max</label>
                <input type="number" name="max_price" value="{{ request('max_price') }}" 
                       placeholder="Harga maksimum" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition duration-200">
                    <i class="fas fa-search mr-2"></i>Cari
                </button>
            </div>
        </form>
    </div>

    <!-- Packages Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($packages as $package)
        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300">
            <div class="relative">
                <img src="{{ $package->image ? asset('storage/' . $package->image) : 'https://via.placeholder.com/400x250?text=Tour+Image' }}" 
                     alt="{{ $package->title }}" class="w-full h-48 object-cover">
                <div class="absolute top-4 right-4">
                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                        {{ $package->status }}
                    </span>
                </div>
            </div>
            
            <div class="p-6">
                <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $package->title }}</h3>
                <p class="text-gray-600 mb-3">{{ $package->location }}</p>
                <p class="text-sm text-gray-500 mb-4 line-clamp-2">{{ Str::limit($package->description, 100) }}</p>
                
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <span class="text-2xl font-bold text-blue-600">Rp {{ number_format($package->price, 0, ',', '.') }}</span>
                        <span class="block text-sm text-gray-500">per orang</span>
                    </div>
                    <span class="text-sm text-gray-500 bg-gray-100 px-2 py-1 rounded">{{ $package->duration }}</span>
                </div>

                <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                    <div class="flex items-center">
                        <i class="fas fa-users mr-1"></i>
                        <span>{{ $package->available_seats }} kursi tersedia</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-calendar mr-1"></i>
                        <span>{{ $package->start_date->format('d M Y') }}</span>
                    </div>
                </div>

                <div class="flex space-x-2">
                    <a href="{{ route('packages.show', $package->id) }}" 
                       class="flex-1 bg-blue-600 text-white text-center py-2 rounded-lg hover:bg-blue-700 transition duration-200">
                        Lihat Detail
                    </a>
                    @auth
                    <form action="{{ route('cart.add', $package->id) }}" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" 
                                class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition duration-200"
                                {{ $package->available_seats <= 0 ? 'disabled' : '' }}>
                            <i class="fas fa-cart-plus"></i>
                        </button>
                    </form>
                    @endauth
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-3 text-center py-12">
            <i class="fas fa-suitcase text-gray-400 text-6xl mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-600 mb-2">Tidak ada paket wisata ditemukan</h3>
            <p class="text-gray-500">Coba ubah filter pencarian Anda</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($packages->hasPages())
    <div class="mt-8">
        {{ $packages->links() }}
    </div>
    @endif
</div>
@endsection