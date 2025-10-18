@extends('layouts.admin')
@section('title', 'Manage Payments')

@section('content')
<h1 class="text-2xl font-bold mb-4">Payments</h1>

@if(session('success'))
<div class="bg-green-100 text-green-700 p-3 rounded mb-3">{{ session('success') }}</div>
@endif

<table class="w-full bg-white shadow rounded">
    <thead class="bg-gray-100">
        <tr>
            <th class="py-2 px-4">Order Code</th>
            <th>Customer</th>
            <th>Amount</th>
            <th>Method</th>
            <th>Status</th>
            <th>Change Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($payments as $payment)
        <tr class="border-b">
            <td class="py-2 px-4">{{ $payment->order->order_code }}</td>
            <td>{{ $payment->order->user->name }}</td>
            <td>${{ number_format($payment->amount, 2) }}</td>
            <td>{{ ucfirst($payment->payment_method) }}</td>
            <td>{{ ucfirst($payment->status) }}</td>
            <td>
                <form action="{{ route('admin.payments.status', $payment->id) }}" method="POST">
                    @csrf
                    <select name="status" onchange="this.form.submit()" class="border rounded p-1">
                        @foreach(['pending','verified','failed'] as $status)
                            <option value="{{ $status }}" {{ $payment->status == $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="6" class="text-center py-3">No payments found</td></tr>
        @endforelse
    </tbody>
</table>
@endsection
