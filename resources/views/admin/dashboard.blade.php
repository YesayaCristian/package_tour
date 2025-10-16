@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
<h1 class="text-3xl font-bold mb-6">Admin Dashboard</h1>

<div class="grid grid-cols-2 md:grid-cols-4 gap-4">
    <div class="bg-blue-600 text-white p-4 rounded">Total Packages: 12</div>
    <div class="bg-green-600 text-white p-4 rounded">Total Orders: 45</div>
    <div class="bg-yellow-500 text-white p-4 rounded">Pending Payments: 5</div>
    <div class="bg-red-600 text-white p-4 rounded">Customers: 30</div>
</div>
@endsection
