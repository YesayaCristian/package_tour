@extends('layouts.app')

@section('title', 'Keranjang Belanja - TourTravels')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Keranjang Belanja</h1>

    @if($cart && $cart->items->count() > 0)
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Cart Items -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md">
                <div class="px-6 py-4 border-b">
                    <h2 class="text-lg font-semibold">Item dalam Keranjang</h2>
                </div>
                
                <div class="divide-y">
                    @foreach($cart->items as $item)
                    <div class="p-6">
                        <div class="flex items-center">
                            <img src="{{ $item->tourPackage->image ? asset('storage/' . $item->tourPackage->image) : 'https://via.placeholder.com/80?text=Tour' }}" 
                                 alt="{{ $item->tourPackage->title }}" 
                                 class="w-20 h-20 object-cover rounded-lg">
                            
                            <div class="ml-4 flex-1">
                                <h3 class="text-lg font-semibold text-gray-900">{{ $item->tourPackage->title }}</h3>
                                <p class="text-gray-600">{{ $item->tourPackage->location }}</p>
                                <p class="text-gray-500 text-sm">{{ $item->tourPackage->duration }}</p>
                            </div>
                            
                            <div class="text-right">
                                <p class="text-lg font-semibold text-blue-600">Rp {{ number_format($item->total_price, 0, ',', '.') }}</p>
                                <p class="text-sm text-gray-500">Rp {{ number_format($item->tourPackage->price, 0, ',', '.') }} x {{ $item->quantity }}</p>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between mt-4">
                            <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center">
                                @csrf
                                @method('PUT')
                                <label class="mr-2 text-sm font-medium text-gray-700">Quantity:</label>
                                <select name="quantity" onchange="this.form.submit()" 
                                        class="px-2 py-1 border border-gray-300 rounded-md text-sm">
                                    @for($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}" {{ $item->quantity == $i ? 'selected' : '' }}>{{ $i }}</option>
                                    @endfor
                                </select>
                            </form>
                            
                            <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="text-red-600 hover:text-red-800 text-sm font-medium"
                                        onclick="return confirm('Hapus item dari keranjang?')">
                                    <i class="fas fa-trash mr-1"></i>Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-md p-6 sticky top-6">
                <h2 class="text-lg font-semibold mb-4">Ringkasan Pesanan</h2>
                
                <div class="space-y-3 mb-4">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-semibold">Rp {{ number_format($cart->total, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Pajak (10%)</span>
                        <span class="font-semibold">Rp {{ number_format($cart->total * 0.1, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-lg font-semibold border-t pt-3">
                        <span>Total</span>
                        <span class="text-blue-600">Rp {{ number_format($cart->total * 1.1, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Checkout Form -->
                <form action="{{ route('checkout') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Metode Pembayaran</label>
                        <select name="payment_method" required 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Pilih metode pembayaran</option>
                            <option value="bank_transfer">Transfer Bank</option>
                            <option value="ewallet">E-Wallet</option>
                            <option value="credit_card">Kartu Kredit</option>
                            <option value="cash">Tunai</option>
                        </select>
                    </div>

                    <button type="submit" 
                            class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-200">
                        <i class="fas fa-shopping-bag mr-2"></i>Lanjutkan Checkout
                    </button>
                </form>

                <div class="mt-4 text-center">
                    <a href="{{ route('packages.index') }}" 
                       class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                        <i class="fas fa-arrow-left mr-1"></i>Lanjutkan Belanja
                    </a>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="bg-white rounded-lg shadow-md p-12 text-center">
        <i class="fas fa-shopping-cart text-gray-400 text-6xl mb-4"></i>
        <h2 class="text-2xl font-semibold text-gray-600 mb-4">Keranjang Belanja Kosong</h2>
        <p class="text-gray-500 mb-6">Silakan tambahkan paket wisata ke keranjang belanja Anda</p>
        <a href="{{ route('packages.index') }}" 
           class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-200">
            <i class="fas fa-suitcase mr-2"></i>Jelajahi Paket Wisata
        </a>
    </div>
    @endif
</div>
@endsection