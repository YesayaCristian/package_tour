@extends('layouts.admin')
@section('title', 'Manage Orders')

@section('content')
<h1 class="text-2xl font-bold mb-4">Orders</h1>

<table class="w-full bg-white shadow rounded">
    <thead class="bg-gray-100">
        <tr>
            <th class="py-2 px-4">Order Code</th>
            <th>User</th>
            <th>Total</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @for ($i = 1; $i <= 5; $i++)
            <tr class="border-b">
                <td class="py-2 px-4">ORD-20251015-00{{ $i }}</td>
                <td>Customer {{ $i }}</td>
                <td>$ {{ 300 * $i }}</td>
                <td><span class="text-green-600">Paid</span></td>
            </tr>
        @endfor
    </tbody>
</table>
@endsection
