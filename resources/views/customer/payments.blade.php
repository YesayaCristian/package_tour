@extends('layouts.app')
@section('title', 'Payment')

@section('content')
<div class="max-w-3xl mx-auto mt-10 bg-white p-8 rounded shadow">
    <h1 class="text-2xl font-bold mb-6 text-center">Payment Confirmation 🧾</h1>

    <div class="grid md:grid-cols-2 gap-6">
        <div>
            <h2 class="text-lg font-semibold mb-2">Order Summary</h2>
            <div class="bg-gray-50 p-4 rounded border">
                <p><strong>Order Code:</strong> ORD-20251015-001</p>
                <p><strong>Total Amount:</strong> $1200</p>
                <p><strong>Status:</strong> Pending</p>
            </div>
        </div>

        <div>
            <h2 class="text-lg font-semibold mb-2">Payment Details</h2>
            <form class="space-y-4">
                <div>
                    <label class="block mb-1 text-gray-700">Payment Method</label>
                    <select class="w-full border-gray-300 rounded p-2">
                        <option>Transfer Bank</option>
                        <option>Credit Card</option>
                        <option>E-Wallet</option>
                    </select>
                </div>

                <div>
                    <label class="block mb-1 text-gray-700">Amount</label>
                    <input type="text" value="1200" class="w-full border-gray-300 rounded p-2" readonly>
                </div>

                <div>
                    <label class="block mb-1 text-gray-700">Payment Proof</label>
                    <input type="file" class="w-full border-gray-300 rounded p-2">
                </div>

                <button type="submit"
                    class="bg-blue-600 text-white w-full py-2 rounded hover:bg-blue-700 transition">
                    Submit Payment
                </button>
            </form>
        </div>
    </div>

    <div class="mt-10">
        <h2 class="text-lg font-semibold mb-3">Recent Payments</h2>
        <table class="w-full border text-sm text-gray-700">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border p-2">ID</th>
                    <th class="border p-2">Method</th>
                    <th class="border p-2">Amount</th>
                    <th class="border p-2">Status</th>
                    <th class="border p-2">Date</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border p-2 text-center">1</td>
                    <td class="border p-2 text-center">Transfer</td>
                    <td class="border p-2 text-center">$1200</td>
                    <td class="border p-2 text-center text-yellow-500 font-semibold">Pending</td>
                    <td class="border p-2 text-center">2025-10-15 12:45</td>
                </tr>
                <tr>
                    <td class="border p-2 text-center">2</td>
                    <td class="border p-2 text-center">E-Wallet</td>
                    <td class="border p-2 text-center">$850</td>
                    <td class="border p-2 text-center text-green-600 font-semibold">Verified</td>
                    <td class="border p-2 text-center">2025-10-10 09:30</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
