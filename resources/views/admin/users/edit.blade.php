@extends('layouts.admin')
@section('title', 'Edit Customer')
@section('content')

<h1 class="text-2xl font-bold mb-4">Edit Customer</h1>

<form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="bg-white p-6 rounded shadow-md">
    @csrf
    @method('PUT')

    <div class="mb-4">
        <label class="block mb-1 font-semibold">Name</label>
        <input type="text" name="name" value="{{ $user->name }}" class="w-full border rounded p-2" required>
    </div>

    <div class="mb-4">
        <label class="block mb-1 font-semibold">Email</label>
        <input type="email" name="email" value="{{ $user->email }}" class="w-full border rounded p-2" required>
    </div>

    <div class="mb-4">
        <label class="block mb-1 font-semibold">Phone</label>
        <input type="text" name="phone" value="{{ $user->phone }}" class="w-full border rounded p-2">
    </div>

    <button class="bg-yellow-500 text-white px-4 py-2 rounded">Update</button>
    <a href="{{ route('admin.users.index') }}" class="ml-2 text-gray-600">Cancel</a>
</form>

@endsection
