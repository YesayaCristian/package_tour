@extends('layouts.admin')
@section('title', 'Add Customer')
@section('content')

<h1 class="text-2xl font-bold mb-4">Add New Customer</h1>

<form action="{{ route('admin.users.store') }}" method="POST" class="bg-white p-6 rounded shadow-md">
    @csrf
    <div class="mb-4">
        <label class="block mb-1 font-semibold">Name</label>
        <input type="text" name="name" class="w-full border rounded p-2" required>
    </div>

    <div class="mb-4">
        <label class="block mb-1 font-semibold">Email</label>
        <input type="email" name="email" class="w-full border rounded p-2" required>
    </div>

    <div class="mb-4">
        <label class="block mb-1 font-semibold">Phone</label>
        <input type="text" name="phone" class="w-full border rounded p-2">
    </div>

    <div class="mb-4">
        <label class="block mb-1 font-semibold">Password</label>
        <input type="password" name="password" class="w-full border rounded p-2" required>
    </div>

    <div class="mb-4">
        <label class="block mb-1 font-semibold">Confirm Password</label>
        <input type="password" name="password_confirmation" class="w-full border rounded p-2" required>
    </div>

    <button class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
    <a href="{{ route('admin.users.index') }}" class="ml-2 text-gray-600">Cancel</a>
</form>

@endsection
