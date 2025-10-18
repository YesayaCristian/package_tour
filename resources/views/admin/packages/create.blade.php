@extends('layouts.admin')
@section('title', 'Add Package')
@section('content')

<h1 class="text-2xl font-bold mb-4">Add New Package</h1>

<form action="{{ route('admin.packages.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow-md">
    @csrf
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block mb-1 font-semibold">Title</label>
            <input type="text" name="title" class="w-full border rounded p-2" required>

            <label class="block mb-1 font-semibold mt-4">Price</label>
            <input type="number" name="price" class="w-full border rounded p-2" required>

            <label class="block mb-1 font-semibold mt-4">Duration</label>
            <input type="text" name="duration" class="w-full border rounded p-2" required>

            <label class="block mb-1 font-semibold mt-4">Location</label>
            <input type="text" name="location" class="w-full border rounded p-2" required>

            <label class="block mb-1 font-semibold mt-4">Available Seats</label>
            <input type="number" name="available_seats" class="w-full border rounded p-2" min="0" required>
        </div>

        <div>
            <label class="block mb-1 font-semibold">Description</label>
            <textarea name="description" class="w-full border rounded p-2 h-48" required></textarea>

            <label class="block mb-1 font-semibold mt-4">Image</label>
            <input type="file" name="image" class="w-full border rounded p-2">
        </div>
    </div>

    <button class="bg-blue-600 text-white px-4 py-2 mt-4 rounded">Save</button>
    <a href="{{ route('admin.packages.index') }}" class="ml-2 text-gray-600">Cancel</a>
</form>

@endsection
