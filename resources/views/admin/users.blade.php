@extends('layouts.admin')
@section('title', 'Manage Users')

@section('content')
<h1 class="text-2xl font-bold mb-4">Users</h1>

<table class="w-full bg-white shadow rounded">
    <thead class="bg-gray-100">
        <tr>
            <th class="py-2 px-4">Name</th>
            <th>Email</th>
            <th>Role</th>
        </tr>
    </thead>
    <tbody>
        @for ($i = 1; $i <= 5; $i++)
            <tr class="border-b">
                <td class="py-2 px-4">User {{ $i }}</td>
                <td>user{{ $i }}@mail.com</td>
                <td>{{ $i == 1 ? 'admin' : 'customer' }}</td>
            </tr>
        @endfor
    </tbody>
</table>
@endsection
