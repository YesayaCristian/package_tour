@extends('layouts.app')
@section('title', 'Packages')

@section('content')
<h1 class="text-3xl font-bold mb-6">All Tour Packages</h1>

<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
    @foreach($packages as $package)
        <div class="bg-white shadow rounded overflow-hidden">
            @if($package->image)
                <img src="{{ asset('storage/images/'.$package->image) }}" 
                     class="w-full h-auto object-cover" alt="{{ $package->title }}">
            @else
                <div class="w-full h-64 bg-gray-200 flex items-center justify-center">
                    <span class="text-gray-500">No Image</span>
                </div>
            @endif
            <div class="p-4">
                <h2 class="text-xl font-semibold mb-2">{{ $package->title }}</h2>
                <p class="text-sm text-gray-600 mb-2">Duration: {{ $package->duration }}</p>
                <p class="text-blue-600 font-bold mb-3">$ {{ $package->price }}</p>
                <a href="{{ route('package.detail', $package->id) }}" class="bg-blue-600 text-white px-3 py-1 rounded">Book Now</a>
            </div>
        </div>
    @endforeach
</div>
@endsection
