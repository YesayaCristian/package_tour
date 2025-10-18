@extends('layouts.admin')
@section('title', 'Manage Users')

@section('content')
<h1 class="text-2xl font-bold mb-4">Manage Customers</h1>

<a href="{{ route('admin.users.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">+ Add Customer</a>

@if(session('success'))
<div class="bg-green-100 text-green-700 p-3 rounded mb-3">
    {{ session('success') }}
</div>
@endif

<table class="w-full bg-white shadow rounded">
    <thead class="bg-gray-100">
        <tr>
            <th class="py-2 px-4 text-left">Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($users as $user)
        <tr class="border-b">
            <td class="py-2 px-4">{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->phone ?? '-' }}</td>
            <td class="space-x-2">
                <a href="{{ route('admin.users.edit', $user->id) }}" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</a>
                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline">
                    @csrf @method('DELETE')
                    <button class="bg-red-600 text-white px-2 py-1 rounded" onclick="return confirm('Delete this user?')">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="4" class="text-center py-3">No users found</td></tr>
        @endforelse
    </tbody>
</table>
@endsection
