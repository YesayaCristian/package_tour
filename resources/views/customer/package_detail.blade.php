@extends('layouts.app')
@section('title', $package->title)

@section('content')
<div class="grid md:grid-cols-2 gap-6">
    @if($package->image)
        <img src="{{ asset('storage/images/'.$package->image) }}" 
             class="w-full h-full object-cover rounded shadow" 
             alt="{{ $package->title }}">
    @else
        <div class="w-full h-96 bg-gray-200 flex items-center justify-center rounded shadow">
            <span class="text-gray-500">No Image</span>
        </div>
    @endif

    <div>
        <h1 class="text-3xl font-bold mb-2">{{ $package->title }}</h1>
        <p class="text-gray-700 mb-3">{{ $package->description }}</p>
        <p class="text-lg text-blue-600 font-semibold mb-4">$ {{ $package->price }}</p>
        <p class="mb-2">Location: {{ $package->location }}</p>
        <p class="mb-2">Duration: {{ $package->duration }}</p>
        <p class="mb-2">Available Seats: {{ $package->available_seats }}</p>

        <form action="{{ route('cart.add') }}" method="POST">
            @csrf
            <input type="hidden" name="package_id" value="{{ $package->id }}">
            <div class="flex items-center space-x-2 mt-2">
                <input type="number" name="quantity" value="1" min="1" class="w-16 border rounded px-2 py-1">
                <button class="bg-green-600 text-white px-4 py-2 rounded">Add to Cart</button>
            </div>
        </form>
    </div>
</div>
@endsection
