@extends('layouts.app')

@section('title', 'Home - TourTravels')

@section('content')
<!-- Hero Section -->
<section class="bg-blue-600 text-white py-20">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <h1 class="text-5xl font-bold mb-6">Jelajahi Keindahan Indonesia</h1>
        <p class="text-xl mb-8">Temukan pengalaman wisata tak terlupakan dengan paket terbaik kami</p>
        <a href="{{ route('packages.index') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-300">
            Jelajahi Paket Wisata
        </a>
    </div>
</section>

<!-- Featured Packages -->
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12">Paket Wisata Populer</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($packages as $package)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300">
                <img src="{{ $package->image ? asset('storage/' . $package->image) : 'https://via.placeholder.com/400x250?text=Tour+Image' }}" 
                     alt="{{ $package->title }}" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h3 class="text-xl font-semibold mb-2">{{ $package->title }}</h3>
                    <p class="text-gray-600 mb-4">{{ $package->location }}</p>
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-2xl font-bold text-blue-600">Rp {{ number_format($package->price, 0, ',', '.') }}</span>
                        <span class="text-sm text-gray-500">{{ $package->duration }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                        <span><i class="fas fa-users"></i> {{ $package->available_seats }} kursi tersedia</span>
                        <div class="flex items-center">
                            <i class="fas fa-star text-yellow-400"></i>
                            <span class="ml-1">{{ number_format($package->average_rating, 1) }}</span>
                        </div>
                    </div>
                    <a href="{{ route('packages.show', $package->id) }}" class="block w-full bg-blue-600 text-white text-center py-2 rounded-lg hover:bg-blue-700 transition duration-300">
                        Lihat Detail
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-8">
            <a href="{{ route('packages.index') }}" class="bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-300 transition duration-300">
                Lihat Semua Paket
            </a>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="bg-gray-100 py-16">
    <div class="max-w-7xl mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-shield-alt text-blue-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold mb-2">Aman & Terpercaya</h3>
                <p class="text-gray-600">Pembayaran aman dengan sistem yang terpercaya</p>
            </div>
            <div class="text-center">
                <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-headset text-blue-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold mb-2">24/7 Support</h3>
                <p class="text-gray-600">Customer service siap membantu kapan saja</p>
            </div>
            <div class="text-center">
                <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-tag text-blue-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold mb-2">Harga Terbaik</h3>
                <p class="text-gray-600">Dapatkan penawaran harga terbaik untuk setiap paket</p>
            </div>
        </div>
    </div>
</section>
@endsection