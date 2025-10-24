@extends('layouts.admin')

@section('title', 'Edit Paket Wisata')
@section('header-title', 'Edit Paket Wisata')
@section('header-subtitle', $package->title)

@section('content')
<div class="bg-white rounded-lg shadow">
    <form action="{{ route('admin.packages.update', $package->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="p-6 space-y-6">
            <!-- Basic Information -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Dasar</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Nama Paket *</label>
                        <input type="text" name="title" id="title" required 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                               value="{{ old('title', $package->title) }}">
                        @error('title')
                            <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Lokasi *</label>
                        <input type="text" name="location" id="location" required 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                               value="{{ old('location', $package->location) }}">
                        @error('location')
                            <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="duration" class="block text-sm font-medium text-gray-700 mb-2">Durasi *</label>
                        <input type="text" name="duration" id="duration" required 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                               value="{{ old('duration', $package->duration) }}">
                        @error('duration')
                            <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Harga *</label>
                        <input type="number" name="price" id="price" required min="0" step="0.01"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                               value="{{ old('price', $package->price) }}">
                        @error('price')
                            <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Dates and Seats -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Jadwal dan Kuota</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai *</label>
                        <input type="date" name="start_date" id="start_date" required 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                               value="{{ old('start_date', $package->start_date->format('Y-m-d')) }}">
                        @error('start_date')
                            <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Selesai *</label>
                        <input type="date" name="end_date" id="end_date" required 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                               value="{{ old('end_date', $package->end_date->format('Y-m-d')) }}">
                        @error('end_date')
                            <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="available_seats" class="block text-sm font-medium text-gray-700 mb-2">Kursi Tersedia *</label>
                        <input type="number" name="available_seats" id="available_seats" required min="0"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                               value="{{ old('available_seats', $package->available_seats) }}">
                        @error('available_seats')
                            <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi *</label>
                <textarea name="description" id="description" required rows="6"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">{{ old('description', $package->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                @enderror
            </div>

            <!-- Image and Status -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Gambar Paket</label>
                    
                    @if($package->image)
                    <div class="mb-3">
                        <img src="{{ asset('storage/' . $package->image) }}" 
                             alt="Current Image" 
                             class="w-32 h-32 object-cover rounded-lg border">
                        <p class="text-sm text-gray-500 mt-1">Gambar saat ini</p>
                    </div>
                    @endif
                    
                    <input type="file" name="image" id="image" accept="image/*"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                    @error('image')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Kosongkan jika tidak ingin mengubah gambar</p>
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                    <select name="status" id="status" required 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                        <option value="available" {{ old('status', $package->status) == 'available' ? 'selected' : '' }}>Available</option>
                        <option value="inactive" {{ old('status', $package->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="full" {{ old('status', $package->status) == 'full' ? 'selected' : '' }}>Full</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="px-6 py-4 bg-gray-50 border-t flex justify-end space-x-3">
            <a href="{{ route('admin.packages.index') }}" 
               class="bg-gray-600 text-white px-6 py-2 rounded-md font-semibold hover:bg-gray-700 transition duration-200">
                Batal
            </a>
            <button type="submit" 
                    class="bg-primary text-white px-6 py-2 rounded-md font-semibold hover:bg-secondary transition duration-200">
                Update Paket
            </button>
        </div>
    </form>
</div>
@endsection