@extends('layouts.admin')

@section('title', 'Kelola Paket Wisata')
@section('header-title', 'Kelola Paket Wisata')
@section('header-subtitle', 'Daftar semua paket wisata')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Paket Wisata</h2>
        <p class="text-gray-600">Kelola semua paket wisata yang tersedia</p>
    </div>
    <div class="flex space-x-3">
        <!-- Export PDF Button -->
        <a href="{{ route('admin.packages.export.pdf', request()->query()) }}" 
           class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition duration-200 flex items-center"
           onclick="showExportLoading()">
            <i class="fas fa-file-pdf mr-2"></i>Export PDF
        </a>
        
        <a href="{{ route('admin.packages.create') }}" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-secondary transition duration-200 flex items-center">
            <i class="fas fa-plus mr-2"></i>Tambah Paket
        </a>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="p-2 rounded-full bg-blue-100 text-blue-600 mr-3">
                <i class="fas fa-suitcase"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600">Total Paket</p>
                <p class="text-xl font-semibold">{{ $packages->total() }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="p-2 rounded-full bg-green-100 text-green-600 mr-3">
                <i class="fas fa-check-circle"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600">Available</p>
                <p class="text-xl font-semibold">{{ $packages->where('status', 'available')->count() }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="p-2 rounded-full bg-red-100 text-red-600 mr-3">
                <i class="fas fa-times-circle"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600">Full</p>
                <p class="text-xl font-semibold">{{ $packages->where('status', 'full')->count() }}</p>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex items-center">
            <div class="p-2 rounded-full bg-gray-100 text-gray-600 mr-3">
                <i class="fas fa-pause-circle"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600">Inactive</p>
                <p class="text-xl font-semibold">{{ $packages->where('status', 'inactive')->count() }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Search and Filter -->
<div class="bg-white rounded-lg shadow p-4 mb-6">
    <form action="{{ route('admin.packages.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
        <div class="flex-1">
            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari Paket</label>
            <input type="text" name="search" id="search" value="{{ request('search') }}" 
                   placeholder="Cari berdasarkan nama atau lokasi..." 
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
        </div>
        
        <div class="flex-1">
            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select name="status" id="status" 
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
                <option value="">Semua Status</option>
                <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available</option>
                <option value="full" {{ request('status') == 'full' ? 'selected' : '' }}>Full</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
        
        <div class="flex-1">
            <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
            <input type="text" name="location" id="location" value="{{ request('location') }}" 
                   placeholder="Filter lokasi..." 
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent">
        </div>
        
        <div class="flex items-end space-x-2">
            <button type="submit" 
                    class="bg-primary text-white px-4 py-2 rounded-md hover:bg-secondary transition duration-200 flex items-center">
                <i class="fas fa-search mr-2"></i>Filter
            </button>
            <a href="{{ route('admin.packages.index') }}" 
               class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition duration-200 flex items-center">
                <i class="fas fa-refresh mr-2"></i>Reset
            </a>
        </div>
    </form>
</div>

<!-- Packages Table -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    @if($packages->count() > 0)
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Paket</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi & Durasi</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga & Kursi</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($packages as $package)
                <tr class="hover:bg-gray-50 transition duration-150">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-12 w-12">
                                <img class="h-12 w-12 rounded-lg object-cover" 
                                     src="{{ $package->image ? asset('storage/' . $package->image) : 'https://via.placeholder.com/48?text=Tour' }}" 
                                     alt="{{ $package->title }}">
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ Str::limit($package->title, 40) }}</div>
                                <div class="text-sm text-gray-500 mt-1 line-clamp-2">{{ Str::limit($package->description, 60) }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">
                            <div class="flex items-center mb-1">
                                <i class="fas fa-map-marker-alt text-gray-400 mr-2 text-xs"></i>
                                {{ $package->location }}
                            </div>
                            <div class="flex items-center text-gray-500">
                                <i class="fas fa-clock text-gray-400 mr-2 text-xs"></i>
                                {{ $package->duration }}
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm">
                            <div class="font-semibold text-gray-900 mb-1">Rp {{ number_format($package->price, 0, ',', '.') }}</div>
                            <div class="text-gray-500 flex items-center">
                                <i class="fas fa-users mr-1 text-xs"></i>
                                {{ $package->available_seats }} kursi
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">
                            <div class="mb-1">{{ $package->start_date->format('d M Y') }}</div>
                            <div class="text-gray-500 text-xs">s/d {{ $package->end_date->format('d M Y') }}</div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                            {{ $package->status === 'available' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $package->status === 'full' ? 'bg-red-100 text-red-800' : '' }}
                            {{ $package->status === 'inactive' ? 'bg-gray-100 text-gray-800' : '' }}">
                            @if($package->status === 'available')
                            <i class="fas fa-check-circle mr-1"></i>
                            @elseif($package->status === 'full')
                            <i class="fas fa-times-circle mr-1"></i>
                            @else
                            <i class="fas fa-pause-circle mr-1"></i>
                            @endif
                            {{ ucfirst($package->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('admin.packages.edit', $package->id) }}" 
                               class="text-primary hover:text-secondary transition duration-200"
                               title="Edit Paket">
                                <i class="fas fa-edit"></i>
                            </a>
                            
                            <a href="{{ route('packages.show', $package->id) }}" 
                               target="_blank"
                               class="text-blue-600 hover:text-blue-800 transition duration-200"
                               title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            
                            <form action="{{ route('admin.packages.destroy', $package->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="text-danger hover:text-red-800 transition duration-200"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus paket \"{{ $package->title }}\"?')"
                                        title="Hapus Paket">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
        <div class="flex flex-col md:flex-row items-center justify-between">
            <div class="text-sm text-gray-700 mb-4 md:mb-0">
                Menampilkan {{ $packages->firstItem() }} - {{ $packages->lastItem() }} dari {{ $packages->total() }} paket
            </div>
            <div>
                {{ $packages->links() }}
            </div>
        </div>
    </div>
    @else
    <!-- Empty State -->
    <div class="text-center py-12">
        <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
            <i class="fas fa-suitcase text-gray-400 text-2xl"></i>
        </div>
        <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada paket wisata</h3>
        <p class="text-gray-500 mb-6">Mulai dengan membuat paket wisata pertama Anda</p>
        <a href="{{ route('admin.packages.create') }}" 
           class="bg-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-secondary transition duration-200 inline-flex items-center">
            <i class="fas fa-plus mr-2"></i>Tambah Paket Pertama
        </a>
    </div>
    @endif
</div>

<!-- Export Loading Modal -->
<div id="exportLoadingModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-blue-100">
                <i class="fas fa-spinner fa-spin text-blue-600 text-xl"></i>
            </div>
            <h3 class="text-lg leading-6 font-medium text-gray-900 mt-2">Mempersiapkan Export PDF</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Sedang memproses data untuk export PDF. Harap tunggu...
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
    // Auto submit form when select changes for better UX
    document.addEventListener('DOMContentLoaded', function() {
        const statusSelect = document.getElementById('status');
        const searchInput = document.getElementById('search');
        
        // Debounce function for search
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                this.form.submit();
            }, 500);
        });
        
        // Auto submit when status changes
        statusSelect.addEventListener('change', function() {
            this.form.submit();
        });
    });

    function showExportLoading() {
        document.getElementById('exportLoadingModal').classList.remove('hidden');
        
        // Auto close loading modal after 3 seconds (fallback)
        setTimeout(() => {
            closeExportLoadingModal();
        }, 3000);
    }

    function closeExportLoadingModal() {
        document.getElementById('exportLoadingModal').classList.add('hidden');
    }

    // Enhanced PDF export with direct download
    function exportPdf(url) {
        showExportLoading();
        
        // Create invisible iframe for download
        const iframe = document.createElement('iframe');
        iframe.style.display = 'none';
        iframe.src = url;
        document.body.appendChild(iframe);
        
        // Check if download started
        iframe.onload = function() {
            setTimeout(() => {
                closeExportLoadingModal();
                document.body.removeChild(iframe);
            }, 2000);
        };
    }

    // Attach event listener to PDF export button
    document.addEventListener('DOMContentLoaded', function() {
        const pdfButton = document.querySelector('a[href*="export/pdf"]');
        if (pdfButton) {
            pdfButton.addEventListener('click', function(e) {
                e.preventDefault();
                exportPdf(this.href);
            });
        }
    });
</script>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush