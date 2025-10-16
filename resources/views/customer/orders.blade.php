@extends('layouts.app')
@section('title', 'My Orders')

@section('content')
<h1 class="text-2xl font-bold mb-4">Order History 📦</h1>

@for ($i = 1; $i <= 4; $i++)
<div class="bg-white shadow rounded p-4 mb-3">
    <h2 class="font-bold">Order Code: ORD-20251015-00{{ $i }}</h2>
    <p>Status: <span class="text-green-600">Paid</span></p>
    <p>Total: $ {{ 400 * $i }}</p>
</div>
@endfor
@endsection
