@extends('layouts.admin')
@section('title', 'Manage Packages')

@section('content')
<h1 class="text-2xl font-bold mb-4">Tour Packages</h1>

<table class="w-full bg-white shadow rounded">
    <thead class="bg-gray-100">
        <tr>
            <th class="py-2 px-4">Title</th>
            <th>Location</th>
            <th>Price</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @for ($i = 1; $i <= 5; $i++)
            <tr class="border-b">
                <td class="py-2 px-4">Package #{{ $i }}</td>
                <td>Bali</td>
                <td>$ {{ 200 * $i }}</td>
                <td>
                    <button class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</button>
                    <button class="bg-red-600 text-white px-2 py-1 rounded">Delete</button>
                </td>
            </tr>
        @endfor
    </tbody>
</table>
@endsection
