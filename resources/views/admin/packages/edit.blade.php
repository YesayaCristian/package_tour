@extends('layouts.admin')
@section('title', 'Edit Package')
@section('content')

<h1 class="text-2xl font-bold mb-4">Edit Package</h1>

<form action="{{ route('admin.packages.update', $package->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow-md">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block mb-1 font-semibold">Title</label>
            <input type="text" name="title" value="{{ $package->title }}" class="w-full border rounded p-2" required>

            <label class="block mb-1 font-semibold mt-4">Price</label>
            <input type="number" name="price" value="{{ $package->price }}" class="w-full border rounded p-2" required>

            <label class="block mb-1 font-semibold mt-4">Duration</label>
            <input type="text" name="duration" value="{{ $package->duration }}" class="w-full border rounded p-2" required>

            <label class="block mb-1 font-semibold mt-4">Location</label>
            <input type="text" name="location" value="{{ $package->location }}" class="w-full border rounded p-2" required>

            <label class="block mb-1 font-semibold mt-4">Available Seats</label>
            <input type="number" name="available_seats" value="{{ $package->available_seats }}" class="w-full border rounded p-2" min="0" required>
        </div>

        <div>
            <label class="block mb-1 font-semibold">Description</label>
            <textarea name="description" class="w-full border rounded p-2 h-48" required>{{ $package->description }}</textarea>

            <label class="block mb-1 font-semibold mt-4">Image</label>
            <input type="file" name="image" class="w-full border rounded p-2">
            @if($package->image)
                <img src="{{ asset('storage/'.$package->image) }}" alt="Package Image" class="w-32 mt-2 rounded">
            @endif
        </div>
    </div>

    <button class="bg-yellow-500 text-white px-4 py-2 mt-4 rounded">Update</button>
    <a href="{{ route('admin.packages.index') }}" class="ml-2 text-gray-600">Cancel</a>
</form>

@endsection
