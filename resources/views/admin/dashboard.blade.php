@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')
<h1 class="text-3xl font-bold mb-6">Admin Dashboard</h1>

<div class="grid grid-cols-1 md:grid-cols-4 gap-4">
    <div class="bg-blue-600 text-white p-4 rounded">Total Packages: {{ $totalPackages }}</div>
    <div class="bg-green-600 text-white p-4 rounded">Total Orders: {{ $totalOrders }}</div>
    <div class="bg-yellow-500 text-white p-4 rounded">Payments: {{ $totalPayments }}</div>
    <div class="bg-red-600 text-white p-4 rounded">Customers: {{ $totalCustomers }}</div>
</div>
@endsection
