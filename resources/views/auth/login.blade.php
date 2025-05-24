@extends('layouts.guest')

@section('title', 'Login')

@section('content')
<div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
    <!-- Logo -->
    <div class="flex justify-center mb-6">
        <svg class="w-16 h-16 text-indigo-600" fill="none" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
            <circle cx="16" cy="16" r="16" fill="#6366F1" fill-opacity="0.1"/>
            <path d="M16 10a2 2 0 110 4 2 2 0 010-4zm0 8a2 2 0 110 4 2 2 0 010-4zm-6-4a2 2 0 110 4 2 2 0 010-4zm12 0a2 2 0 110 4 2 2 0 010-4z" fill="#6366F1"/>
        </svg>
    </div>
    
    <h1 class="text-2xl font-bold text-center text-gray-900 mb-6">Sign in to your account</h1>
    
    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf
        
        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus 
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @error('email')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        
        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            @error('password')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        
        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <input id="remember_me" type="checkbox" name="remember" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                <label for="remember_me" class="ml-2 text-sm text-gray-600">Remember me</label>
            </div>
            
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:text-indigo-500">
                    Forgot your password?
                </a>
            @endif
        </div>
        
        <!-- Submit Button -->
        <div>
            <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Sign in
            </button>
        </div>
    </form>
    
    <!-- Registration Link -->
    <div class="mt-6 text-center">
        <p class="text-sm text-gray-600">
            Don't have an account?
            <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                Register here
            </a>
        </p>
    </div>
</div>
@endsection
