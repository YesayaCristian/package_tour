@extends('layouts.app')

@section('title', 'Detail Review - TourTravels')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('reviews.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                    <i class="fas fa-star mr-2"></i>
                    Review Saya
                </a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400"></i>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Detail Review</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Header -->
        <div class="px-6 py-4 bg-blue-50 border-b">
            <h1 class="text-2xl font-bold text-gray-800">Detail Review</h1>
            <p class="text-gray-600 mt-1">Review Anda untuk paket wisata</p>
        </div>

        <div class="p-6">
            <!-- Package Information -->
            <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                <h3 class="text-lg font-semibold mb-3">Informasi Paket Wisata</h3>
                <div class="flex items-center">
                    <img src="{{ $review->tourPackage->image ? asset('storage/' . $review->tourPackage->image) : 'https://via.placeholder.com/80?text=Tour' }}" 
                         alt="{{ $review->tourPackage->title }}" 
                         class="w-16 h-16 object-cover rounded-lg">
                    <div class="ml-4">
                        <h4 class="text-xl font-semibold text-gray-900">{{ $review->tourPackage->title }}</h4>
                        <p class="text-gray-600">{{ $review->tourPackage->location }}</p>
                        <p class="text-sm text-gray-500">{{ $review->tourPackage->duration }}</p>
                    </div>
                </div>
            </div>

            <!-- Review Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <h3 class="text-lg font-semibold mb-3">Detail Review</h3>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-600">Rating</p>
                            <div class="flex items-center mt-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }} text-lg"></i>
                                @endfor
                                <span class="ml-2 text-gray-900 font-semibold">({{ $review->rating }}/5)</span>
                            </div>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Status</p>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium mt-1
                                {{ $review->status === 'approved' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $review->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $review->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                @if($review->status === 'approved')
                                <i class="fas fa-check mr-1"></i>Disetujui
                                @elseif($review->status === 'pending')
                                <i class="fas fa-clock mr-1"></i>Menunggu Persetujuan
                                @else
                                <i class="fas fa-times mr-1"></i>Ditolak
                                @endif
                            </span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Dibuat Pada</p>
                            <p class="text-gray-900">{{ $review->created_at->translatedFormat('d F Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold mb-3">Informasi Pesanan</h3>
                    <div class="space-y-3">
                        <div>
                            <p class="text-sm text-gray-600">Kode Pesanan</p>
                            <p class="text-gray-900 font-semibold">#{{ $review->order->order_code }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Tanggal Pesanan</p>
                            <p class="text-gray-900">{{ $review->order->created_at->format('d F Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600">Status Pesanan</p>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $review->order->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $review->order->status === 'paid' ? 'bg-blue-100 text-blue-800' : '' }}">
                                {{ ucfirst($review->order->status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Comment -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-3">Ulasan Anda</h3>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-gray-700 leading-relaxed">{{ $review->comment }}</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-between items-center pt-6 border-t">
                <a href="{{ route('reviews.index') }}" 
                   class="bg-gray-500 text-white px-6 py-2 rounded-lg font-semibold hover:bg-gray-600 transition duration-200 flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>

                @if($review->status === 'pending')
                <div class="flex space-x-3">
                    <a href="{{ route('reviews.edit', $review->id) }}" 
                       class="bg-blue-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-700 transition duration-200 flex items-center">
                        <i class="fas fa-edit mr-2"></i>Edit Review
                    </a>
                    
                    <form action="{{ route('reviews.destroy', $review->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="bg-red-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-red-700 transition duration-200 flex items-center"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus review ini?')">
                            <i class="fas fa-trash mr-2"></i>Hapus Review
                        </button>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection