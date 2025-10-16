@extends('layouts.app')
@section('title', 'Checkout')

@section('content')
<div class="max-w-lg mx-auto mt-10 bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-4">Checkout 💳</h1>

    <div class="border-b border-gray-200 pb-4 mb-4">
        <p class="mb-2 text-gray-700">Order Code: <span class="font-bold text-blue-600">ORD-20251015-001</span></p>
        <p class="mb-2 text-gray-700">Total Amount: <span class="font-bold text-green-600">$1200</span></p>
        <p class="text-gray-700">Status: <span class="text-yellow-500 font-semibold">Pending</span></p>
    </div>

    <form action="{{ route('payments') }}" method="GET">
        <button type="submit"
            class="bg-green-600 text-white w-full py-3 rounded hover:bg-green-700 transition duration-200">
            Pay Now
        </button>
    </form>
</div>
@endsection
