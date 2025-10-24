@extends('layouts.app')

@section('title', 'Detail Pesanan #' . $order->order_code . ' - TourTravels')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('orders.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                    <i class="fas fa-shopping-bag mr-2"></i>
                    Pesanan Saya
                </a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400"></i>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">#{{ $order->order_code }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- Order Header -->
        <div class="px-6 py-4 bg-gray-50 border-b">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Pesanan #{{ $order->order_code }}</h1>
                    <p class="text-gray-600">Tanggal: {{ $order->created_at->format('d F Y H:i') }}</p>
                </div>
                <div class="mt-2 md:mt-0">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                        {{ $order->status === 'paid' ? 'bg-green-100 text-green-800' : '' }}
                        {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                        {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}
                        {{ $order->status === 'completed' ? 'bg-blue-100 text-blue-800' : '' }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="p-6">
            <h2 class="text-lg font-semibold mb-4">Detail Paket</h2>
            <div class="space-y-4">
                @foreach($order->items as $item)
                <div class="flex items-center p-4 border rounded-lg">
                    <img src="{{ $item->tourPackage->image ? asset('storage/' . $item->tourPackage->image) : 'https://via.placeholder.com/80?text=Tour' }}" 
                         alt="{{ $item->tourPackage->title }}" 
                         class="w-16 h-16 object-cover rounded-lg">
                    
                    <div class="ml-4 flex-1">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $item->tourPackage->title }}</h3>
                        <p class="text-gray-600">{{ $item->tourPackage->location }}</p>
                        <p class="text-gray-500 text-sm">{{ $item->tourPackage->duration }}</p>
                    </div>
                    
                    <div class="text-right">
                        <p class="text-sm text-gray-500">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                        <p class="text-lg font-semibold text-gray-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Order Summary -->
        <div class="px-6 py-4 bg-gray-50 border-t">
            <div class="flex justify-between items-center mb-2">
                <span class="text-gray-600">Subtotal:</span>
                <span class="font-semibold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between items-center mb-2">
                <span class="text-gray-600">Pajak (10%):</span>
                <span class="font-semibold">Rp {{ number_format($order->total_amount * 0.1, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between items-center text-lg font-bold border-t pt-2">
                <span>Total:</span>
                <span class="text-blue-600">Rp {{ number_format($order->total_amount * 1.1, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Payment Information -->
        <div class="p-6 border-t">
            <h2 class="text-lg font-semibold mb-4">Informasi Pembayaran</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-600">Metode Pembayaran</p>
                    <p class="font-semibold capitalize">{{ str_replace('_', ' ', $order->payment_method) }}</p>
                </div>
                @if($order->payment)
                <div>
                    <p class="text-sm text-gray-600">Status Pembayaran</p>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                        {{ $order->payment->status === 'confirmed' ? 'bg-green-100 text-green-800' : '' }}
                        {{ $order->payment->status === 'waiting' ? 'bg-yellow-100 text-yellow-800' : '' }}
                        {{ $order->payment->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                        {{ ucfirst($order->payment->status) }}
                    </span>
                </div>
                @endif
            </div>

            <!-- Payment Upload Form -->
            @if($order->status === 'pending' && !$order->payment)
            <div id="payment" class="mt-6 p-4 bg-blue-50 rounded-lg">
                <h3 class="text-lg font-semibold mb-3">Upload Bukti Pembayaran</h3>
                <form action="{{ route('orders.payment.upload', $order->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Transfer</label>
                            <input type="date" name="payment_date" required 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   value="{{ old('payment_date') }}">
                            @error('payment_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Transfer</label>
                            <input type="number" name="amount" value="{{ $order->total_amount * 1.1 }}" required 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('amount')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Bukti Transfer</label>
                        <input type="file" name="payment_proof" accept="image/*" required 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @error('payment_proof')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG (Maks. 2MB)</p>
                    </div>
                    <button type="submit" 
                            class="bg-blue-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-700 transition duration-200 flex items-center">
                        <i class="fas fa-upload mr-2"></i>Upload Bukti Pembayaran
                    </button>
                </form>
            </div>
            @endif

            <!-- Payment Proof Display -->
            @if($order->payment)
            <div class="mt-6">
                <h3 class="text-lg font-semibold mb-3">Bukti Pembayaran</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-600 mb-2">Bukti Transfer:</p>
                        <img src="{{ asset('storage/' . $order->payment->payment_proof) }}" 
                             alt="Bukti Pembayaran" 
                             class="w-full max-w-xs rounded-lg shadow-md border">
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Tanggal Transfer: {{ $order->payment->payment_date->format('d F Y') }}</p>
                        <p class="text-sm text-gray-600">Jumlah: Rp {{ number_format($order->payment->amount, 0, ',', '.') }}</p>
                        <p class="text-sm text-gray-600">Status: 
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $order->payment->status === 'confirmed' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $order->payment->status === 'waiting' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $order->payment->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                {{ ucfirst($order->payment->status) }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Review Section -->
        @if($order->status === 'completed')
        <div class="p-6 border-t bg-gray-50">
            <h2 class="text-lg font-semibold mb-4">Review Pesanan</h2>
            
            @if(!\App\Models\Review::hasOrderReviewed($order->id))
            <div class="p-4 bg-green-50 rounded-lg border border-green-200">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div class="mb-4 md:mb-0">
                        <h4 class="text-lg font-semibold text-green-800 mb-1">Beri Review</h4>
                        <p class="text-green-600 text-sm">Bagikan pengalaman Anda selama mengikuti paket wisata ini</p>
                    </div>
                    <a href="{{ route('reviews.create', $order->id) }}" 
                       class="bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition duration-200 flex items-center justify-center">
                        <i class="fas fa-star mr-2"></i>Beri Review
                    </a>
                </div>
            </div>
            @else
            <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div class="mb-4 md:mb-0">
                        <h4 class="text-lg font-semibold text-blue-800 mb-1">Review Terkirim</h4>
                        <p class="text-blue-600 text-sm">Terima kasih telah memberikan review untuk pesanan ini</p>
                    </div>
                    <a href="{{ route('reviews.index') }}" 
                       class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-200 flex items-center justify-center">
                        <i class="fas fa-eye mr-2"></i>Lihat Review Saya
                    </a>
                </div>
            </div>
            @endif

            <!-- Existing Reviews -->
            @php
                $existingReviews = \App\Models\Review::where('order_id', $order->id)
                    ->where('user_id', Auth::id())
                    ->with('tourPackage')
                    ->get();
            @endphp

            @if($existingReviews->count() > 0)
            <div class="mt-6">
                <h4 class="text-md font-semibold mb-3">Review Anda untuk Pesanan Ini</h4>
                <div class="space-y-4">
                    @foreach($existingReviews as $review)
                    <div class="bg-white rounded-lg border p-4">
                        <div class="flex items-start justify-between mb-3">
                            <div>
                                <h5 class="font-semibold text-gray-900">{{ $review->tourPackage->title }}</h5>
                                <p class="text-sm text-gray-600">{{ $review->tourPackage->location }}</p>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ $review->status === 'approved' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $review->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $review->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                {{ ucfirst($review->status) }}
                            </span>
                        </div>
                        
                        <div class="flex items-center mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }} text-sm"></i>
                            @endfor
                            <span class="ml-2 text-sm text-gray-600">({{ $review->rating }}/5)</span>
                        </div>
                        
                        <p class="text-gray-700 text-sm mb-3">{{ $review->comment }}</p>
                        
                        <div class="flex items-center justify-between text-xs text-gray-500">
                            <span>Dikirim pada: {{ $review->created_at->format('d M Y H:i') }}</span>
                            @if($review->status === 'pending')
                            <div class="flex space-x-2">
                                <a href="{{ route('reviews.edit', $review->id) }}" 
                                   class="text-blue-600 hover:text-blue-800 transition duration-200">
                                    <i class="fas fa-edit mr-1"></i>Edit
                                </a>
                                <form action="{{ route('reviews.destroy', $review->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-800 transition duration-200"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus review ini?')">
                                        <i class="fas fa-trash mr-1"></i>Hapus
                                    </button>
                                </form>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
        @endif
    </div>

    <!-- Action Buttons -->
    <div class="mt-6 flex flex-col sm:flex-row justify-between space-y-3 sm:space-y-0 sm:space-x-4">
        <a href="{{ route('orders.index') }}" 
           class="bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-gray-700 transition duration-200 flex items-center justify-center">
            <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar Pesanan
        </a>
        
        <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
            @if($order->status === 'pending' && !$order->payment)
            <a href="#payment" 
               class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-200 flex items-center justify-center">
                <i class="fas fa-credit-card mr-2"></i>Bayar Sekarang
            </a>
            @endif
            
            @if($order->payment && $order->payment->status === 'waiting')
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded-lg text-sm">
                <i class="fas fa-clock mr-2"></i>Menunggu verifikasi pembayaran
            </div>
            @endif

            @if($order->status === 'completed' && !\App\Models\Review::hasOrderReviewed($order->id))
            <a href="{{ route('reviews.create', $order->id) }}" 
               class="bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition duration-200 flex items-center justify-center">
                <i class="fas fa-star mr-2"></i>Beri Review
            </a>
            @endif
        </div>
    </div>

    <!-- Order Timeline -->
    <div class="mt-8 bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold mb-4">Status Pesanan</h3>
        <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
            <div class="flex items-center {{ $order->status !== 'pending' ? 'text-green-600' : 'text-gray-400' }}">
                <div class="flex-shrink-0 w-8 h-8 rounded-full {{ $order->status !== 'pending' ? 'bg-green-100' : 'bg-gray-100' }} flex items-center justify-center">
                    <i class="fas {{ $order->status !== 'pending' ? 'fa-check text-green-600' : 'fa-clock text-gray-400' }} text-sm"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium">Pesanan Dibuat</p>
                    <p class="text-xs text-gray-500">{{ $order->created_at->format('d M Y H:i') }}</p>
                </div>
            </div>

            <div class="flex items-center {{ in_array($order->status, ['paid', 'completed']) ? 'text-green-600' : 'text-gray-400' }}">
                <div class="flex-shrink-0 w-8 h-8 rounded-full {{ in_array($order->status, ['paid', 'completed']) ? 'bg-green-100' : 'bg-gray-100' }} flex items-center justify-center">
                    <i class="fas {{ in_array($order->status, ['paid', 'completed']) ? 'fa-check text-green-600' : 'fa-clock text-gray-400' }} text-sm"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium">Pembayaran</p>
                    <p class="text-xs text-gray-500">
                        @if($order->payment)
                            {{ $order->payment->status === 'confirmed' ? 'Terkonfirmasi' : 'Menunggu' }}
                        @else
                            Menunggu
                        @endif
                    </p>
                </div>
            </div>

            <div class="flex items-center {{ $order->status === 'completed' ? 'text-green-600' : 'text-gray-400' }}">
                <div class="flex-shrink-0 w-8 h-8 rounded-full {{ $order->status === 'completed' ? 'bg-green-100' : 'bg-gray-100' }} flex items-center justify-center">
                    <i class="fas {{ $order->status === 'completed' ? 'fa-check text-green-600' : 'fa-clock text-gray-400' }} text-sm"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium">Selesai</p>
                    <p class="text-xs text-gray-500">
                        @if($order->status === 'completed')
                            Tour Selesai
                        @else
                            Dalam Proses
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Help Section -->
    @if($order->status === 'pending' || ($order->payment && $order->payment->status === 'waiting'))
    <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-info-circle text-yellow-400 text-lg"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-yellow-800">Butuh Bantuan?</h3>
                <div class="mt-2 text-sm text-yellow-700">
                    <p>Jika Anda mengalami kendala dalam proses pembayaran atau memiliki pertanyaan, silakan hubungi customer service kami:</p>
                    <ul class="list-disc list-inside mt-1 space-y-1">
                        <li>WhatsApp: +62 812-3456-7890</li>
                        <li>Email: support@tourtravels.com</li>
                        <li>Telepon: (021) 1234-5678</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<!-- Loading Modal for Payment Upload -->
<div id="loadingModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-100">
                <i class="fas fa-spinner fa-spin text-blue-600 text-xl"></i>
            </div>
            <h3 class="text-lg leading-6 font-medium text-gray-900 mt-2">Mengupload Bukti Pembayaran</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Sedang mengupload bukti pembayaran Anda. Harap tunggu...
                </p>
                <div class="mt-4">
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full animate-pulse"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Payment form submission loading
        const paymentForm = document.querySelector('form[action*="payment.upload"]');
        if (paymentForm) {
            paymentForm.addEventListener('submit', function() {
                document.getElementById('loadingModal').classList.remove('hidden');
            });
        }

        // Smooth scroll to payment section
        const paymentLinks = document.querySelectorAll('a[href="#payment"]');
        paymentLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const paymentSection = document.getElementById('payment');
                if (paymentSection) {
                    paymentSection.scrollIntoView({ 
                        behavior: 'smooth',
                        block: 'start'
                    });
                    
                    // Add highlight effect
                    paymentSection.classList.add('bg-blue-100');
                    setTimeout(() => {
                        paymentSection.classList.remove('bg-blue-100');
                    }, 2000);
                }
            });
        });

        // Auto-set payment date to today if empty
        const paymentDateInput = document.querySelector('input[name="payment_date"]');
        if (paymentDateInput && !paymentDateInput.value) {
            const today = new Date().toISOString().split('T')[0];
            paymentDateInput.value = today;
        }

        // Validate payment amount
        const amountInput = document.querySelector('input[name="amount"]');
        if (amountInput) {
            amountInput.addEventListener('change', function() {
                const expectedAmount = {{ $order->total_amount * 1.1 }};
                const enteredAmount = parseFloat(this.value);
                
                if (enteredAmount < expectedAmount) {
                    this.classList.add('border-red-500');
                    this.classList.remove('border-gray-300');
                    
                    // Show warning
                    if (!document.getElementById('amount-warning')) {
                        const warning = document.createElement('p');
                        warning.id = 'amount-warning';
                        warning.className = 'mt-1 text-sm text-red-600';
                        warning.innerHTML = '<i class="fas fa-exclamation-triangle mr-1"></i> Jumlah transfer kurang dari yang seharusnya.';
                        this.parentNode.appendChild(warning);
                    }
                } else {
                    this.classList.remove('border-red-500');
                    this.classList.add('border-gray-300');
                    
                    const warning = document.getElementById('amount-warning');
                    if (warning) {
                        warning.remove();
                    }
                }
            });
        }

        // File upload preview
        const fileInput = document.querySelector('input[name="payment_proof"]');
        if (fileInput) {
            fileInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    // Validate file type
                    const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                    if (!validTypes.includes(file.type)) {
                        alert('Hanya file JPG, PNG yang diizinkan.');
                        this.value = '';
                        return;
                    }
                    
                    // Validate file size (2MB)
                    if (file.size > 2 * 1024 * 1024) {
                        alert('Ukuran file maksimal 2MB.');
                        this.value = '';
                        return;
                    }
                    
                    // Show file name
                    const fileNameDisplay = document.getElementById('file-name') || (function() {
                        const display = document.createElement('p');
                        display.id = 'file-name';
                        display.className = 'text-sm text-green-600 mt-1';
                        fileInput.parentNode.appendChild(display);
                        return display;
                    })();
                    
                    fileNameDisplay.innerHTML = `<i class="fas fa-check mr-1"></i> File dipilih: ${file.name}`;
                }
            });
        }
    });

    // Close loading modal function (if needed)
    function closeLoadingModal() {
        document.getElementById('loadingModal').classList.add('hidden');
    }
</script>

<style>
    /* Custom styles for better UX */
    .smooth-hover {
        transition: all 0.3s ease-in-out;
    }
    
    .highlight {
        animation: highlight 2s ease-in-out;
    }
    
    @keyframes highlight {
        0% { background-color: transparent; }
        50% { background-color: #dbeafe; }
        100% { background-color: transparent; }
    }
</style>
@endpush