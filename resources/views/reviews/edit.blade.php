@extends('layouts.app')

@section('title', 'Edit Review - TourTravels')

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
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400"></i>
                    <a href="{{ route('reviews.show', $review->id) }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">
                        Detail Review
                    </a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400"></i>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Edit Review</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 bg-yellow-50 border-b border-yellow-200">
            <h1 class="text-2xl font-bold text-gray-800">Edit Review</h1>
            <p class="text-gray-600 mt-1">Perbarui penilaian Anda untuk pengalaman wisata</p>
        </div>

        <div class="p-6">
            <!-- Review Information -->
            <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                <h3 class="text-lg font-semibold mb-3">Informasi Review</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Paket Wisata</p>
                        <p class="font-semibold">{{ $review->tourPackage->title }}</p>
                        <p class="text-sm text-gray-600">{{ $review->tourPackage->location }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Status</p>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            <i class="fas fa-clock mr-1"></i>Pending
                        </span>
                        <p class="text-xs text-gray-500 mt-1">Review dapat diedit selama status masih pending</p>
                    </div>
                </div>
            </div>

            <!-- Edit Review Form -->
            <form action="{{ route('reviews.update', $review->id) }}" method="POST" id="editReviewForm">
                @csrf
                @method('PUT')
                
                <!-- Current Rating Display -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        Rating Saat Ini <span class="text-red-500">*</span>
                    </label>
                    <div class="flex items-center space-x-1 mb-2">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }} text-lg"></i>
                        @endfor
                        <span class="ml-2 text-gray-600">({{ $review->rating }}/5)</span>
                    </div>
                    <p class="text-sm text-gray-500">Klik bintang di bawah untuk mengubah rating</p>
                </div>

                <!-- New Rating Selection -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        Rating Baru <span class="text-red-500">*</span>
                    </label>
                    <div class="flex items-center space-x-1" id="rating-stars">
                        @for($i = 1; $i <= 5; $i++)
                        <button type="button" 
                                class="text-3xl rating-star focus:outline-none transition duration-150"
                                data-rating="{{ $i }}">
                            <i class="far fa-star text-gray-300 hover:text-yellow-400 {{ $i <= $review->rating ? '!text-yellow-400 fas' : '' }}"></i>
                        </button>
                        @endfor
                    </div>
                    <input type="hidden" name="rating" id="rating-value" value="{{ $review->rating }}" required>
                    <p class="text-sm text-gray-500 mt-2" id="rating-text">
                        @if($review->rating == 1)
                        Sangat Buruk - Pengalaman yang tidak menyenangkan
                        @elseif($review->rating == 2)
                        Buruk - Banyak hal yang perlu ditingkatkan
                        @elseif($review->rating == 3)
                        Cukup - Sesuai ekspektasi biasa
                        @elseif($review->rating == 4)
                        Baik - Pengalaman yang menyenangkan
                        @else
                        Sangat Baik - Pengalaman luar biasa!
                        @endif
                    </p>
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
                              required>{{ old('comment', $review->comment) }}</textarea>
                    <p class="text-sm text-gray-500 mt-1">Minimal 10 karakter (tersisa: <span id="char-count">{{ strlen($review->comment) }}</span>/1000)</p>
                    @error('comment')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Changes Summary -->
                <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                    <h4 class="text-md font-semibold text-blue-800 mb-2">Perubahan yang Akan Disimpan</h4>
                    <div class="space-y-2 text-sm text-blue-700">
                        <div class="flex justify-between">
                            <span>Rating:</span>
                            <span>
                                <span class="line-through text-gray-500 mr-2">{{ $review->rating }}/5</span>
                                <span id="new-rating-display" class="font-semibold">{{ $review->rating }}/5</span>
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span>Ulasan:</span>
                            <span id="changes-indicator" class="font-semibold">Tidak ada perubahan</span>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-between items-center pt-6 border-t">
                    <div class="flex space-x-3">
                        <a href="{{ route('reviews.show', $review->id) }}" 
                           class="bg-gray-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-gray-600 transition duration-200 flex items-center">
                            <i class="fas fa-times mr-2"></i>Batal
                        </a>
                        
                        <button type="button" 
                                onclick="resetForm()"
                                class="bg-yellow-500 text-white px-6 py-3 rounded-lg font-semibold hover:bg-yellow-600 transition duration-200 flex items-center">
                            <i class="fas fa-undo mr-2"></i>Reset
                        </button>
                    </div>

                    <button type="submit" 
                            id="submitBtn"
                            class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-200 flex items-center disabled:opacity-50 disabled:cursor-not-allowed">
                        <i class="fas fa-save mr-2"></i>Simpan Perubahan
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
            <h3 class="text-lg leading-6 font-medium text-gray-900 mt-2">Menyimpan Perubahan</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Sedang menyimpan perubahan review Anda. Harap tunggu...
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
        const editReviewForm = document.getElementById('editReviewForm');
        const newRatingDisplay = document.getElementById('new-rating-display');
        const changesIndicator = document.getElementById('changes-indicator');
        
        const originalRating = {{ $review->rating }};
        const originalComment = `{{ $review->comment }}`;
        
        let hasChanges = false;

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
                
                // Update changes display
                newRatingDisplay.textContent = `${rating}/5`;
                checkForChanges();
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
            
            checkForChanges();
            validateForm();
        });

        // Check for changes
        function checkForChanges() {
            const currentRating = parseInt(ratingValue.value);
            const currentComment = commentTextarea.value.trim();
            
            const ratingChanged = currentRating !== originalRating;
            const commentChanged = currentComment !== originalComment;
            
            hasChanges = ratingChanged || commentChanged;
            
            if (hasChanges) {
                changesIndicator.innerHTML = '<span class="text-green-600">Ada perubahan</span>';
                changesIndicator.classList.add('text-green-600');
            } else {
                changesIndicator.innerHTML = '<span class="text-gray-600">Tidak ada perubahan</span>';
                changesIndicator.classList.remove('text-green-600');
            }
            
            return hasChanges;
        }

        // Form validation
        function validateForm() {
            const rating = parseInt(ratingValue.value);
            const comment = commentTextarea.value.trim();
            
            const isValid = rating > 0 && comment.length >= 10 && hasChanges;
            
            submitBtn.disabled = !isValid;
            
            if (isValid) {
                submitBtn.classList.remove('disabled:opacity-50', 'disabled:cursor-not-allowed');
            } else {
                submitBtn.classList.add('disabled:opacity-50', 'disabled:cursor-not-allowed');
            }
            
            return isValid;
        }

        // Reset form to original values
        window.resetForm = function() {
            if (confirm('Apakah Anda yakin ingin mengembalikan ke nilai semula? Semua perubahan akan hilang.')) {
                ratingValue.value = originalRating;
                
                // Reset stars
                ratingStars.forEach((s, index) => {
                    const starIcon = s.querySelector('i');
                    if (index < originalRating) {
                        starIcon.className = 'fas fa-star text-yellow-400';
                    } else {
                        starIcon.className = 'far fa-star text-gray-300';
                    }
                });
                
                // Reset rating text
                ratingText.textContent = ratingTexts[originalRating] || 'Pilih rating dengan mengklik bintang';
                ratingText.className = 'text-sm text-gray-500 mt-2';
                
                // Reset comment
                commentTextarea.value = originalComment;
                charCount.textContent = originalComment.length;
                charCount.className = 'text-green-600 font-medium';
                
                // Reset displays
                newRatingDisplay.textContent = `${originalRating}/5`;
                checkForChanges();
                validateForm();
            }
        };

        // Form submission
        editReviewForm.addEventListener('submit', function(e) {
            if (!validateForm()) {
                e.preventDefault();
                
                let errorMessage = '';
                
                if (!hasChanges) {
                    errorMessage = 'Tidak ada perubahan yang dilakukan.';
                } else if (parseInt(ratingValue.value) === 0) {
                    errorMessage = 'Harap berikan rating dengan mengklik bintang';
                } else if (commentTextarea.value.trim().length < 10) {
                    errorMessage = 'Ulasan harus minimal 10 karakter';
                }
                
                if (errorMessage) {
                    alert(errorMessage);
                    return;
                }
            }
            
            // Show loading modal
            document.getElementById('loadingModal').classList.remove('hidden');
        });

        // Check for existing errors on page load
        function checkExistingErrors() {
            const ratingError = document.querySelector('[name="rating"] + .text-red-600');
            const commentError = document.querySelector('[name="comment"] + .text-red-600');
            
            if (ratingError || commentError) {
                validateForm();
            }
        }

        // Initial checks
        checkForChanges();
        checkExistingErrors();
        validateForm();
    });

    // Function to close loading modal
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
    
    .changes-highlight {
        animation: highlight 1s ease-in-out;
    }
    
    @keyframes highlight {
        0% { background-color: transparent; }
        50% { background-color: #fef3c7; }
        100% { background-color: transparent; }
    }
</style>
@endpush