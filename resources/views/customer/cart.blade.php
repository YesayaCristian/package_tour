@extends('layouts.app')
@section('title', 'My Cart')

@section('content')
<h1 class="text-2xl font-bold mb-4">Your Cart 🛒</h1>

<table class="w-full bg-white shadow rounded">
    <thead class="bg-gray-100">
        <tr>
            <th class="py-2 px-4">Package</th>
            <th>Quantity</th>
            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody>
        @for ($i = 1; $i <= 3; $i++)
            <tr class="border-b">
                <td class="py-2 px-4">Tour Package #{{ $i }}</td>
                <td>2</td>
                <td>$ {{ 400 * $i }}</td>
            </tr>
        @endfor
    </tbody>
</table>

<div class="mt-4 flex justify-end">
    <a href="{{ route('checkout') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Proceed to Checkout</a>
</div>
@endsection
