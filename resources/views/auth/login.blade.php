<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>


<x-guest-layout>
    <div class="flex flex-col items-center justify-center min-h-screen bg-gray-50">
        <!-- Logo -->
        <div class="flex justify-center mb-4">
            <svg class="w-12 h-12 text-indigo-500" fill="none" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                <circle cx="16" cy="16" r="16" fill="#6366F1" fill-opacity="0.1"/>
                <path d="M16 10a2 2 0 110 4 2 2 0 010-4zm0 8a2 2 0 110 4 2 2 0 010-4zm-6-4a2 2 0 110 4 2 2 0 010-4zm12 0a2 2 0 110 4 2 2 0 010-4z" fill="#6366F1"/>
            </svg>
        </div>
        <h2 class="text-2xl font-extrabold text-gray-900 text-center">Sign in to your account</h2>
        <p class="mt-2 text-center text-sm text-gray-500">Or <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">start your 14-day free trial</a></p>
        <div class="mt-8 w-full max-w-md bg-white p-8 rounded-xl shadow-lg">
            <x-auth-session-status class="mb-4" :status="session('status')" />
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email address')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <label for="remember_me" class="flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                        <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a class="text-sm text-indigo-600 hover:text-indigo-500" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
                </div>
                <div>
                    <button type="submit" class="w-full flex justify-center items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-md shadow transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 11c0-1.104.896-2 2-2s2 .896 2 2-.896 2-2 2-2-.896-2-2zm0 0V7m0 4v4m0 0H8m4 0h4"/></svg>
                        Sign in
                    </button>
                </div>
                <div class="mt-2 text-center">
                    <span class="text-sm text-gray-600">Don't have an account?</span>
                    <a href="{{ route('register') }}" class="underline text-sm text-indigo-600 hover:text-indigo-900 ml-1">Register</a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
