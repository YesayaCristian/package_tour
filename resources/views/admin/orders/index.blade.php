@extends('layouts.admin')
@section('title', 'Manage Orders')

@section('content')
<h1 class="text-2xl font-bold mb-4">Orders</h1>

@if(session('success'))
<div class="bg-green-100 text-green-700 p-3 rounded mb-3">{{ session('success') }}</div>
@endif

<table class="w-full bg-white shadow rounded">
    <thead class="bg-gray-100">
        <tr>
            <th class="py-2 px-4">Order Code</th>
            <th>Customer</th>
            <th>Total</th>
            <th>Status</th>
            <th>Change Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($orders as $order)
        <tr class="border-b">
            <td class="py-2 px-4">{{ $order->order_code }}</td>
            <td>{{ $order->user->name }}</td>
            <td>${{ number_format($order->total_amount, 2) }}</td>
            <td>{{ ucfirst($order->status) }}</td>
            <td>
                <form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
                    @csrf
                    <select name="status" onchange="this.form.submit()" class="border rounded p-1">
                        @foreach(['pending','paid','cancelled','completed'] as $status)
                            <option value="{{ $status }}" {{ $order->status == $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="5" class="text-center py-3">No orders found</td></tr>
        @endforelse
    </tbody>
</table>
@endsection
