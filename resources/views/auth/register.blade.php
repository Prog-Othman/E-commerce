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
        <h2 class="text-2xl font-extrabold text-gray-900 text-center">Create your account</h2>
        <p class="mt-2 text-center text-sm text-gray-500">Or <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">start your 14-day free trial</a></p>
        <div class="mt-8 w-full max-w-md bg-white p-8 rounded-xl shadow-lg">
            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf
                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email address')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
                <!-- Confirm Password -->
                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
                <div>
                    <button type="submit" class="w-full flex justify-center items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-md shadow transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 21v-2a4 4 0 00-8 0v2M12 11a4 4 0 100-8 4 4 0 000 8z"/></svg>
                        Register
                    </button>
                </div>
                <div class="mt-2 text-center">
                    <span class="text-sm text-gray-600">Already registered?</span>
                    <a href="{{ route('login') }}" class="underline text-sm text-indigo-600 hover:text-indigo-900 ml-1">Sign in</a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
