@extends('layouts.app')
@section('title', 'Home')

@section('content')
<h1 class="text-3xl font-bold mb-6">Discover Amazing Tour Packages 🌴</h1>

<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
    @for ($i = 1; $i <= 6; $i++)
        <div class="bg-white shadow rounded overflow-hidden">
            <img src="https://picsum.photos/400/250?random={{ $i }}" class="w-full h-48 object-cover" alt="">
            <div class="p-4">
                <h2 class="text-xl font-semibold mb-2">Package #{{ $i }}</h2>
                <p class="text-sm text-gray-600 mb-2">Location: Bali</p>
                <p class="text-blue-600 font-bold mb-3">$ {{ 200 * $i }}</p>
                <a href="{{ route('package.detail', $i) }}" class="bg-blue-600 text-white px-3 py-1 rounded">View Details</a>
            </div>
        </div>
    @endfor
</div>
@endsection
