@extends('layouts.app')
@section('title', 'My Cart')

@section('content')
<h1 class="text-2xl font-bold mb-4">Your Cart 🛒</h1>

@if(session('success'))
    <div class="bg-green-100 text-green-700 p-2 rounded mb-3">{{ session('success') }}</div>
@endif

@if($items->isEmpty())
    <p>Your cart is empty.</p>
@else
<table class="w-full bg-white shadow rounded">
    <thead class="bg-gray-100">
        <tr>
            <th class="py-2 px-4 text-left">Package</th>
            <th class="text-center">Quantity</th>
            <th class="text-right">Subtotal</th>
            <th class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        @php $total = 0; @endphp
        @foreach($items as $item)
            @php $total += $item->subtotal; @endphp
            <tr class="border-b">
                <td class="py-2 px-4">{{ $item->tourPackage->title }}</td>
                <td class="text-center">{{ $item->quantity }}</td>
                <td class="text-right">$ {{ number_format($item->subtotal, 2) }}</td>
                <td class="text-center">
                    <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="bg-red-600 text-white px-3 py-1 rounded">Remove</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="flex justify-between items-center mt-4">
    <form action="{{ route('cart.clear') }}" method="POST">
        @csrf
        @method('DELETE')
        <button class="bg-gray-500 text-white px-4 py-2 rounded">Clear Cart</button>
    </form>

    <div class="text-right">
        <p class="font-semibold text-lg mb-2">Total: $ {{ number_format($total, 2) }}</p>
        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            <button class="bg-blue-600 text-white px-4 py-2 rounded">Proceed to Checkout</button>
        </form>
    </div>
</div>
@endif
@endsection
