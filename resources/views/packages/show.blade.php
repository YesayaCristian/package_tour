@extends('layouts.app')

@section('title', $package->title . ' - TourTravels')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('home') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                    <i class="fas fa-home mr-2"></i>
                    Home
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400"></i>
                    <a href="{{ route('packages.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">Paket Wisata</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400"></i>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">{{ Str::limit($package->title, 30) }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <!-- Package Image -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                <img src="{{ $package->image ? asset('storage/' . $package->image) : 'https://via.placeholder.com/800x400?text=Tour+Image' }}" 
                     alt="{{ $package->title }}" class="w-full h-96 object-cover">
            </div>

            <!-- Package Details -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $package->title }}</h1>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div class="flex items-center">
                        <i class="fas fa-map-marker-alt text-blue-600 mr-3"></i>
                        <div>
                            <p class="text-sm text-gray-500">Lokasi</p>
                            <p class="font-semibold">{{ $package->location }}</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-clock text-blue-600 mr-3"></i>
                        <div>
                            <p class="text-sm text-gray-500">Durasi</p>
                            <p class="font-semibold">{{ $package->duration }}</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-calendar text-blue-600 mr-3"></i>
                        <div>
                            <p class="text-sm text-gray-500">Tanggal Keberangkatan</p>
                            <p class="font-semibold">{{ $package->start_date->format('d F Y') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-users text-blue-600 mr-3"></i>
                        <div>
                            <p class="text-sm text-gray-500">Kursi Tersedia</p>
                            <p class="font-semibold">{{ $package->available_seats }} orang</p>
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <h3 class="text-xl font-semibold mb-3">Deskripsi Paket</h3>
                    <p class="text-gray-700 leading-relaxed">{{ $package->description }}</p>
                </div>

                <!-- Reviews Section -->
                <div>
                    <h3 class="text-xl font-semibold mb-4">Ulasan Pelanggan</h3>
                    @if($package->reviews()->approved()->count() > 0)
                        <div class="space-y-4">
                            @foreach($package->reviews()->approved()->get() as $review)
                            <div class="border rounded-lg p-4">
                                <div class="flex items-center mb-2">
                                    <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white text-sm font-semibold mr-3">
                                        {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold">{{ $review->user->name }}</p>
                                        <div class="flex items-center">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }} text-sm"></i>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                                <p class="text-gray-700">{{ $review->comment }}</p>
                                <p class="text-sm text-gray-500 mt-2">{{ $review->created_at->format('d M Y') }}</p>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-star text-gray-300 text-4xl mb-3"></i>
                            <p class="text-gray-500">Belum ada ulasan untuk paket ini</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Booking Card -->
            <div class="bg-white rounded-lg shadow-md p-6 sticky top-6">
                <div class="text-center mb-6">
                    <span class="text-3xl font-bold text-blue-600">Rp {{ number_format($package->price, 0, ',', '.') }}</span>
                    <span class="block text-sm text-gray-500">per orang</span>
                </div>

                @if($package->isAvailable())
                    <form action="{{ route('cart.add', $package->id) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">Jumlah Peserta</label>
                            <select name="quantity" id="quantity" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @for($i = 1; $i <= min(10, $package->available_seats); $i++)
                                    <option value="{{ $i }}">{{ $i }} orang</option>
                                @endfor
                            </select>
                        </div>

                        <button type="submit" 
                                class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-200 mb-3">
                            <i class="fas fa-cart-plus mr-2"></i>Tambah ke Keranjang
                        </button>
                    </form>

                    <a href="{{ route('cart.index') }}" 
                       class="w-full bg-green-600 text-white py-3 rounded-lg font-semibold hover:bg-green-700 transition duration-200 block text-center">
                        <i class="fas fa-shopping-cart mr-2"></i>Pesan Sekarang
                    </a>
                @else
                    <button disabled 
                            class="w-full bg-gray-400 text-white py-3 rounded-lg font-semibold cursor-not-allowed">
                        {{ $package->status === 'full' ? 'Kursi Penuh' : 'Tidak Tersedia' }}
                    </button>
                @endif

                <div class="mt-6 pt-6 border-t border-gray-200">
                    <h4 class="font-semibold mb-3">Fasilitas Include:</h4>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Tiket pesawat PP
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Hotel bintang 4
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Transportasi selama tour
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Guide profesional
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-check text-green-500 mr-2"></i>
                            Asuransi perjalanan
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Related Packages -->
            @if($relatedPackages->count() > 0)
            <div class="bg-white rounded-lg shadow-md p-6 mt-6">
                <h3 class="text-lg font-semibold mb-4">Paket Lainnya di {{ $package->location }}</h3>
                <div class="space-y-4">
                    @foreach($relatedPackages as $relatedPackage)
                    <a href="{{ route('packages.show', $relatedPackage->id) }}" class="flex items-center p-3 border rounded-lg hover:bg-gray-50 transition duration-200">
                        <img src="{{ $relatedPackage->image ? asset('storage/' . $relatedPackage->image) : 'https://via.placeholder.com/60?text=Tour' }}" 
                             alt="{{ $relatedPackage->title }}" class="w-16 h-16 object-cover rounded-md">
                        <div class="ml-3">
                            <p class="font-medium text-sm text-gray-900">{{ Str::limit($relatedPackage->title, 30) }}</p>
                            <p class="text-sm text-blue-600 font-semibold">Rp {{ number_format($relatedPackage->price, 0, ',', '.') }}</p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection