@extends('layouts.app')
@section('title', 'My Orders')

@section('content')
<h1 class="text-2xl font-bold mb-4">Order History 📦</h1>

@if(session('success'))
    <div class="bg-green-100 text-green-700 p-2 rounded mb-3">{{ session('success') }}</div>
@endif

@forelse($orders as $order)
<div class="bg-white shadow rounded p-4 mb-4">
    <h2 class="font-bold text-lg text-blue-600">Order Code: {{ $order->order_code }}</h2>
    <p>Total: ${{ number_format($order->total_amount, 2) }}</p>
    <p>Status: <span class="font-semibold text-yellow-600">{{ ucfirst($order->status) }}</span></p>
    <p>Payment Status: <span class="font-semibold text-green-600">{{ ucfirst($order->payment_status) }}</span></p>

    <table class="w-full mt-3 border text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="border p-2 text-left">Package</th>
                <th class="border p-2 text-center">Qty</th>
                <th class="border p-2 text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td class="border p-2">{{ $item->tourPackage->title }}</td>
                    <td class="border p-2 text-center">{{ $item->quantity }}</td>
                    <td class="border p-2 text-right">${{ number_format($item->subtotal,2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@empty
<p>No orders yet.</p>
@endforelse
@endsection
