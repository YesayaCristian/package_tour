@extends('layouts.app')

@section('title', 'Review Saya - TourTravels')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Review Saya</h1>
    <p class="text-gray-600 mb-8">Lihat dan kelola semua review yang telah Anda berikan</p>

    @if($reviews->count() > 0)
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Paket Wisata</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rating</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($reviews as $review)
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <img class="h-10 w-10 rounded-lg object-cover" 
                                     src="{{ $review->tourPackage->image ? asset('storage/' . $review->tourPackage->image) : 'https://via.placeholder.com/40?text=Tour' }}" 
                                     alt="{{ $review->tourPackage->title }}">
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ Str::limit($review->tourPackage->title, 40) }}</div>
                                    <div class="text-sm text-gray-500">{{ $review->tourPackage->location }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }} text-sm"></i>
                                @endfor
                                <span class="ml-2 text-sm text-gray-600">({{ $review->rating }}/5)</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $review->status === 'approved' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $review->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $review->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                @if($review->status === 'approved')
                                <i class="fas fa-check mr-1"></i>
                                @elseif($review->status === 'pending')
                                <i class="fas fa-clock mr-1"></i>
                                @else
                                <i class="fas fa-times mr-1"></i>
                                @endif
                                {{ ucfirst($review->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $review->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('reviews.show', $review->id) }}" 
                                   class="text-blue-600 hover:text-blue-900 transition duration-200"
                                   title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                @if($review->status === 'pending')
                                <a href="{{ route('reviews.edit', $review->id) }}" 
                                   class="text-green-600 hover:text-green-900 transition duration-200"
                                   title="Edit Review">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-900 transition duration-200"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus review ini?')"
                                            title="Hapus Review">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            {{ $reviews->links() }}
        </div>
    </div>
    @else
    <div class="bg-white rounded-lg shadow-md p-12 text-center">
        <i class="fas fa-star text-gray-300 text-6xl mb-4"></i>
        <h2 class="text-2xl font-semibold text-gray-600 mb-4">Belum Ada Review</h2>
        <p class="text-gray-500 mb-6">Anda belum memberikan review untuk paket wisata yang telah diselesaikan.</p>
        <a href="{{ route('orders.index') }}" 
           class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-200 inline-flex items-center">
            <i class="fas fa-shopping-bag mr-2"></i>Lihat Pesanan Saya
        </a>
    </div>
    @endif
</div>
@endsection