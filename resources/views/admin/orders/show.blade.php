@extends('layouts.admin')

@section('title', 'Detail Pesanan #' . $order->order_code)
@section('header-title', 'Detail Pesanan')
@section('header-subtitle', '#' . $order->order_code)

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Order Details -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow">
            <!-- Order Header -->
            <div class="px-6 py-4 border-b bg-gray-50">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800">Pesanan #{{ $order->order_code }}</h2>
                        <p class="text-gray-600">Tanggal: {{ $order->created_at->format('d F Y H:i') }}</p>
                    </div>
                    <div class="mt-2 md:mt-0">
                        <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="flex items-center">
                            @csrf
                            @method('PUT')
                            <label class="mr-2 text-sm font-medium text-gray-700">Status:</label>
                            <select name="status" onchange="this.form.submit()" 
                                    class="border border-gray-300 rounded px-3 py-1 text-sm">
                                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="paid" {{ $order->status === 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="p-6">
                <h3 class="text-lg font-semibold mb-4">Detail Paket</h3>
                <div class="space-y-4">
                    @foreach($order->items as $item)
                    <div class="flex items-center p-4 border rounded-lg">
                        <img src="{{ $item->tourPackage->image ? asset('storage/' . $item->tourPackage->image) : 'https://via.placeholder.com/80?text=Tour' }}" 
                             alt="{{ $item->tourPackage->title }}" 
                             class="w-16 h-16 object-cover rounded-lg">
                        
                        <div class="ml-4 flex-1">
                            <h4 class="text-lg font-semibold text-gray-900">{{ $item->tourPackage->title }}</h4>
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
                    <span class="text-primary">Rp {{ number_format($order->total_amount * 1.1, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Payment Information -->
        @if($order->payment)
        <div class="bg-white rounded-lg shadow mt-6">
            <div class="px-6 py-4 border-b">
                <h3 class="text-lg font-semibold text-gray-800">Informasi Pembayaran</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="font-semibold mb-2">Detail Pembayaran</h4>
                        <div class="space-y-2">
                            <div>
                                <span class="text-sm text-gray-600">Status:</span>
                                <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    {{ $order->payment->status === 'confirmed' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $order->payment->status === 'waiting' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $order->payment->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ ucfirst($order->payment->status) }}
                                </span>
                            </div>
                            <div>
                                <span class="text-sm text-gray-600">Tanggal Transfer:</span>
                                <span class="ml-2 font-medium">{{ $order->payment->payment_date->format('d F Y') }}</span>
                            </div>
                            <div>
                                <span class="text-sm text-gray-600">Jumlah Transfer:</span>
                                <span class="ml-2 font-medium">Rp {{ number_format($order->payment->amount, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h4 class="font-semibold mb-2">Bukti Pembayaran</h4>
                        <img src="{{ asset('storage/' . $order->payment->payment_proof) }}" 
                             alt="Bukti Pembayaran" 
                             class="w-full max-w-xs rounded-lg shadow-md border">
                    </div>
                </div>

                <!-- Update Payment Status -->
                <div class="mt-6 pt-6 border-t">
                    <h4 class="font-semibold mb-3">Update Status Pembayaran</h4>
                    <form action="{{ route('admin.payments.updateStatus', $order->payment->id) }}" method="POST" class="flex items-center space-x-4">
                        @csrf
                        @method('PUT')
                        <select name="status" class="border border-gray-300 rounded px-3 py-2">
                            <option value="waiting" {{ $order->payment->status === 'waiting' ? 'selected' : '' }}>Waiting</option>
                            <option value="confirmed" {{ $order->payment->status === 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="rejected" {{ $order->payment->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                        <button type="submit" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-secondary transition duration-200">
                            Update Status
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Customer Information -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b">
                <h3 class="text-lg font-semibold text-gray-800">Informasi Customer</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div>
                        <h4 class="font-semibold text-gray-900">{{ $order->user->name }}</h4>
                        <p class="text-gray-600">{{ $order->user->email }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-600">Telepon</p>
                        <p class="font-medium">{{ $order->user->phone }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-600">Alamat</p>
                        <p class="font-medium">{{ $order->user->address }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-600">Metode Pembayaran</p>
                        <p class="font-medium capitalize">{{ str_replace('_', ' ', $order->payment_method) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Actions -->
        <div class="bg-white rounded-lg shadow mt-6">
            <div class="px-6 py-4 border-b">
                <h3 class="text-lg font-semibold text-gray-800">Aksi</h3>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    <a href="{{ route('admin.orders.index') }}" 
                       class="w-full bg-gray-600 text-white py-2 rounded-md font-semibold hover:bg-gray-700 transition duration-200 block text-center">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                    
                    @if($order->payment)
                    <a href="{{ asset('storage/' . $order->payment->payment_proof) }}" 
                       target="_blank"
                       class="w-full bg-blue-600 text-white py-2 rounded-md font-semibold hover:bg-blue-700 transition duration-200 block text-center">
                        <i class="fas fa-download mr-2"></i>Download Bukti
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection