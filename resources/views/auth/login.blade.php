@extends('layouts.app')
@section('title', 'Login')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4 text-center">Login</h2>
    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-2 rounded mb-3 text-center">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login.post') }}">
        @csrf
        <input type="email" name="email" value="{{ old('email') }}" placeholder="Email"
            class="w-full border rounded p-2 mb-3" required>
        <input type="password" name="password" placeholder="Password"
            class="w-full border rounded p-2 mb-3" required>
        @if($errors->any())
            <div class="text-red-600 mb-3">
                {{ $errors->first() }}
            </div>
        @endif
        <button class="bg-blue-600 text-white w-full py-2 rounded">Login</button>
        <p class="text-center mt-3">Don't have an account? 
            <a href="{{ route('register') }}" class="text-blue-600">Register</a>
        </p>
    </form>
</div>
@endsection
