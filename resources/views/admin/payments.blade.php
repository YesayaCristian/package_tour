@extends('layouts.admin')
@section('title', 'Payments')

@section('content')
<h1 class="text-2xl font-bold mb-4">Payments</h1>

<table class="w-full bg-white shadow rounded">
    <thead class="bg-gray-100">
        <tr>
            <th class="py-2 px-4">Order Code</th>
            <th>Amount</th>
            <th>Method</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @for ($i = 1; $i <= 4; $i++)
            <tr class="border-b">
                <td class="py-2 px-4">ORD-20251015-00{{ $i }}</td>
                <td>$ {{ 500 * $i }}</td>
                <td>Transfer</td>
                <td><span class="text-green-600">Verified</span></td>
            </tr>
        @endfor
    </tbody>
</table>
@endsection
