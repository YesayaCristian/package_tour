@extends('layouts.app')

@section('title', 'Beri Review - TourTravels')

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
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400"></i>
                    <a href="{{ route('orders.show', $order->id) }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">
                        Pesanan #{{ $order->order_code }}
                    </a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400"></i>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Beri Review</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 bg-blue-50 border-b">
            <h1 class="text-2xl font-bold text-gray-800">Beri Review</h1>
            <p class="text-gray-600 mt-1">Berikan penilaian Anda untuk pengalaman wisata</p>
        </div>

        <div class="p-6">
            <!-- Order Information -->
            <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                <h3 class="text-lg font-semibold mb-3">Informasi Pesanan</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Kode Pesanan</p>
                        <p class="font-semibold">#{{ $order->order_code }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Tanggal Pesanan</p>
                        <p class="font-semibold">{{ $order->created_at->format('d F Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Review Form -->
            <form action="{{ route('reviews.store', $order->id) }}" method="POST" id="reviewForm">
                @csrf
                
                <!-- Package Selection -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        Pilih Paket yang akan Direview <span class="text-red-500">*</span>
                    </label>
                    <div class="space-y-3">
                        @foreach($order->items as $item)
                        <div class="border rounded-lg p-4 hover:bg-gray-50 transition duration-150">
                            <div class="flex items-center">
                                <input type="radio" 
                                       name="tour_package_id" 
                                       value="{{ $item->tour_package_id }}" 
                                       id="package_{{ $item->tour_package_id }}"
                                       class="mr-3 focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300"
                                       required>
                                <label for="package_{{ $item->tour_package_id }}" class="flex-1 cursor-pointer">
                                    <div class="flex items-center">
                                        <img src="{{ $item->tourPackage->image ? asset('storage/' . $item->tourPackage->image) : 'https://via.placeholder.com/60?text=Tour' }}" 
                                             alt="{{ $item->tourPackage->title }}" 
                                             class="w-16 h-16 object-cover rounded-lg">
                                        <div class="ml-4">
                                            <h4 class="font-semibold text-gray-900">{{ $item->tourPackage->title }}</h4>
                                            <p class="text-sm text-gray-600">{{ $item->tourPackage->location }}</p>
                                            <p class="text-sm text-gray-500">Quantity: {{ $item->quantity }} orang</p>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @error('tour_package_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Rating -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        Rating <span class="text-red-500">*</span>
                    </label>
                    <div class="flex items-center space-x-1" id="rating-stars">
                        @for($i = 1; $i <= 5; $i++)
                        <button type="button" 
                                class="text-3xl rating-star focus:outline-none transition duration-150"
                                data-rating="{{ $i }}">
                            <i class="far fa-star text-gray-300 hover:text-yellow-400"></i>
                        </button>
                        @endfor
                    </div>
                    <input type="hidden" name="rating" id="rating-value" value="0" required>
                    <p class="text-sm text-gray-500 mt-2" id="rating-text">Pilih rating dengan mengklik bintang</p>
                    @error('rating')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Comment -->
                <div class="mb-6">
                    <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">
                        Ulasan Anda <span class="text-red-500">*</span>
                    </label>
                    <textarea name="comment" id="comment" rows="6" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="Bagikan pengalaman Anda selama mengikuti paket wisata ini. Ceritakan hal-hal yang Anda sukai atau saran untuk perbaikan..."
                              required>{{ old('comment') }}</textarea>
                    <p class="text-sm text-gray-500 mt-1">Minimal 10 karakter (tersisa: <span id="char-count">0</span>/1000)</p>
                    @error('comment')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end space-x-3 pt-4 border-t">
                    <a href="{{ route('orders.show', $order->id) }}" 
                       class="bg-gray-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-gray-600 transition duration-200 flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                    <button type="submit" 
                            id="submitBtn"
                            class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-200 flex items-center disabled:opacity-50 disabled:cursor-not-allowed">
                        <i class="fas fa-paper-plane mr-2"></i>Kirim Review
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Loading Modal -->
<div id="loadingModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-100">
                <i class="fas fa-spinner fa-spin text-blue-600 text-xl"></i>
            </div>
            <h3 class="text-lg leading-6 font-medium text-gray-900 mt-2">Mengirim Review</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Sedang mengirim review Anda. Harap tunggu...
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
        const ratingStars = document.querySelectorAll('.rating-star');
        const ratingValue = document.getElementById('rating-value');
        const ratingText = document.getElementById('rating-text');
        const commentTextarea = document.getElementById('comment');
        const charCount = document.getElementById('char-count');
        const submitBtn = document.getElementById('submitBtn');
        const reviewForm = document.getElementById('reviewForm');
        
        const ratingTexts = {
            1: 'Sangat Buruk - Pengalaman yang tidak menyenangkan',
            2: 'Buruk - Banyak hal yang perlu ditingkatkan',
            3: 'Cukup - Sesuai ekspektasi biasa',
            4: 'Baik - Pengalaman yang menyenangkan',
            5: 'Sangat Baik - Pengalaman luar biasa!'
        };

        // Rating stars functionality
        ratingStars.forEach(star => {
            star.addEventListener('click', function() {
                const rating = parseInt(this.getAttribute('data-rating'));
                ratingValue.value = rating;
                
                // Update stars display
                ratingStars.forEach((s, index) => {
                    const starIcon = s.querySelector('i');
                    if (index < rating) {
                        starIcon.className = 'fas fa-star text-yellow-400';
                    } else {
                        starIcon.className = 'far fa-star text-gray-300';
                    }
                });
                
                // Update rating text
                ratingText.textContent = ratingTexts[rating] || 'Pilih rating dengan mengklik bintang';
                ratingText.className = 'text-sm text-green-600 mt-2 font-medium';
                
                validateForm();
            });

            // Hover effect
            star.addEventListener('mouseenter', function() {
                const rating = parseInt(this.getAttribute('data-rating'));
                ratingStars.forEach((s, index) => {
                    const starIcon = s.querySelector('i');
                    if (index < rating) {
                        if (!starIcon.classList.contains('text-yellow-400')) {
                            starIcon.className = 'fas fa-star text-yellow-300';
                        }
                    }
                });
            });

            star.addEventListener('mouseleave', function() {
                const currentRating = parseInt(ratingValue.value);
                ratingStars.forEach((s, index) => {
                    const starIcon = s.querySelector('i');
                    if (index < currentRating) {
                        starIcon.className = 'fas fa-star text-yellow-400';
                    } else {
                        starIcon.className = 'far fa-star text-gray-300';
                    }
                });
            });
        });

        // Character count for comment
        commentTextarea.addEventListener('input', function() {
            const length = this.value.length;
            charCount.textContent = length;
            
            if (length < 10) {
                charCount.className = 'text-red-600 font-medium';
            } else if (length < 50) {
                charCount.className = 'text-yellow-600 font-medium';
            } else {
                charCount.className = 'text-green-600 font-medium';
            }
            
            validateForm();
        });

        // Form validation
        function validateForm() {
            const rating = parseInt(ratingValue.value);
            const comment = commentTextarea.value.trim();
            const packageSelected = document.querySelector('input[name="tour_package_id"]:checked');
            
            const isValid = rating > 0 && comment.length >= 10 && packageSelected;
            
            submitBtn.disabled = !isValid;
            
            if (isValid) {
                submitBtn.classList.remove('disabled:opacity-50', 'disabled:cursor-not-allowed');
            } else {
                submitBtn.classList.add('disabled:opacity-50', 'disabled:cursor-not-allowed');
            }
            
            return isValid;
        }

        // Check for existing validation errors
        function checkExistingErrors() {
            const ratingError = document.querySelector('[name="rating"] + .text-red-600');
            const commentError = document.querySelector('[name="comment"] + .text-red-600');
            const packageError = document.querySelector('[name="tour_package_id"] + .text-red-600');
            
            if (ratingError || commentError || packageError) {
                validateForm();
            }
        }

        // Form submission
        reviewForm.addEventListener('submit', function(e) {
            if (!validateForm()) {
                e.preventDefault();
                
                let errorMessage = 'Harap lengkapi semua field yang diperlukan:\n';
                
                if (!document.querySelector('input[name="tour_package_id"]:checked')) {
                    errorMessage += '- Pilih paket yang akan direview\n';
                }
                
                if (parseInt(ratingValue.value) === 0) {
                    errorMessage += '- Berikan rating dengan mengklik bintang\n';
                }
                
                if (commentTextarea.value.trim().length < 10) {
                    errorMessage += '- Ulasan harus minimal 10 karakter\n';
                }
                
                alert(errorMessage);
                return;
            }
            
            // Show loading modal
            document.getElementById('loadingModal').classList.remove('hidden');
        });

        // Check for existing errors on page load
        checkExistingErrors();
        
        // Validate form on any change
        document.querySelectorAll('input[name="tour_package_id"]').forEach(radio => {
            radio.addEventListener('change', validateForm);
        });

        // Initial validation
        validateForm();
    });

    // Function to close loading modal (if needed)
    function closeLoadingModal() {
        document.getElementById('loadingModal').classList.add('hidden');
    }
</script>

<style>
    .rating-star {
        transition: all 0.2s ease-in-out;
    }
    
    .rating-star:hover {
        transform: scale(1.2);
    }
    
    #char-count {
        font-weight: bold;
    }
</style>
@endpush