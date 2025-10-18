@extends('layouts.admin')
@section('title', 'Manage Packages')

@section('content')
<h1 class="text-2xl font-bold mb-4">Tour Packages</h1>

<a href="{{ route('admin.packages.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">+ Add Package</a>

@if(session('success'))
<div class="bg-green-100 text-green-700 p-3 rounded mb-3">{{ session('success') }}</div>
@endif

<table class="w-full bg-white shadow rounded">
    <thead class="bg-gray-100">
        <tr>
            <th class="py-2 px-4">Title</th>
            <th>Location</th>
            <th>Price</th>
            <th>Available Seats</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($packages as $package)
        <tr class="border-b">
            <td class="py-2 px-4">{{ $package->title }}</td>
            <td>{{ $package->location }}</td>
            <td>${{ number_format($package->price, 2) }}</td>
            <td>{{ $package->available_seats }}</td>
            <td>
                <a href="{{ route('admin.packages.edit', $package->id) }}" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</a>
                <form action="{{ route('admin.packages.destroy', $package->id) }}" method="POST" class="inline">
                    @csrf @method('DELETE')
                    <button class="bg-red-600 text-white px-2 py-1 rounded" onclick="return confirm('Delete this package?')">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="5" class="text-center py-3">No packages found</td></tr>
        @endforelse
    </tbody>
</table>
@endsection
