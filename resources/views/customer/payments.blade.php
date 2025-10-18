@extends('layouts.app')
@section('title', 'Payment')

@section('content')
<div class="max-w-3xl mx-auto mt-10 bg-white p-8 rounded shadow">
    <h1 class="text-2xl font-bold mb-6 text-center">Payment Confirmation 🧾</h1>

    <div class="grid md:grid-cols-2 gap-6">
        <div>
            <h2 class="text-lg font-semibold mb-2">Order Summary</h2>
            <div class="bg-gray-50 p-4 rounded border">
                <p><strong>Order Code:</strong> {{ $order->order_code }}</p>
                <p><strong>Total Amount:</strong> ${{ number_format($order->total_amount,2) }}</p>
                <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
            </div>
        </div>

        <div>
            <h2 class="text-lg font-semibold mb-2">Payment Details</h2>
            <form class="space-y-4" action="{{ route('payments.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="order_id" value="{{ $order->id }}">

                <div>
                    <label class="block mb-1 text-gray-700">Payment Method</label>
                    <select name="payment_method" class="w-full border-gray-300 rounded p-2" required>
                        <option value="transfer">Transfer Bank</option>
                        <option value="credit_card">Credit Card</option>
                        <option value="ewallet">E-Wallet</option>
                    </select>
                </div>

                <div>
                    <label class="block mb-1 text-gray-700">Upload Proof</label>
                    <input type="file" name="payment_proof" class="w-full border-gray-300 rounded p-2">
                </div>

                <button type="submit"
                    class="bg-blue-600 text-white w-full py-2 rounded hover:bg-blue-700 transition">
                    Submit Payment
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
