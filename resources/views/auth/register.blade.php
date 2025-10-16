@extends('layouts.app')
@section('title', 'Register')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4 text-center">Register</h2>
    <form method="POST" action="{{ route('register.post') }}">
        @csrf
        <input type="text" name="name" value="{{ old('name') }}" placeholder="Full Name" class="w-full border rounded p-2 mb-3" required>
        <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" class="w-full border rounded p-2 mb-3" required>
        <input type="text" name="phone" value="{{ old('phone') }}" placeholder="Phone (optional)" class="w-full border rounded p-2 mb-3">
        <input type="password" name="password" placeholder="Password" class="w-full border rounded p-2 mb-3" required>
        <input type="password" name="password_confirmation" placeholder="Confirm Password" class="w-full border rounded p-2 mb-3" required>
        @if($errors->any())
            <div class="text-red-600 mb-3">
                {{ implode(', ', $errors->all()) }}
            </div>
        @endif
        <button class="bg-green-600 text-white w-full py-2 rounded">Register</button>
        <p class="text-center mt-3">Already have an account? 
            <a href="{{ route('login') }}" class="text-blue-600">Login</a>
        </p>
    </form>
</div>
@endsection
