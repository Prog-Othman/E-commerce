@extends('layouts.app')

@section('title', 'Create Coupon')

@section('content')
<div class="flex min-h-screen bg-white">
    <div class="w-64 h-screen sticky top-0">
        @include('partials.sidebar')
    </div>

    <!-- Main Content -->
    <div class="flex-1 overflow-x-hidden">
        <!-- Header -->
        <div class="sticky top-0 z-10">
            @include('partials.header')
        </div>

        <!-- Page Content -->
        <div class="flex-1 p-8 bg-gray-50">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold text-gray-900">Create New Coupon</h1>
            </div>

            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="p-6">
                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded">
                            <p class="font-bold">Whoops! Something went wrong.</p>
                            <ul class="list-disc list-inside text-sm mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.coupons.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Code -->
                            <div class="col-span-2">
                                <label for="code" class="block text-sm font-medium text-gray-700">Code</label>
                                <input type="text" name="code" id="code" value="{{ old('code') }}" 
                                    class="mt-1 block w-full pl-3 pr-10 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent bg-gray-50 text-sm transition-all duration-200"
                                    placeholder="Leave empty to generate a random code">
                                @error('code')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Type -->
                            <div>
                                <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                                <select name="type" id="type" 
                                    class="mt-1 block w-full pl-3 pr-10 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent bg-gray-50 text-sm transition-all duration-200">
                                    <option value="percentage" {{ old('type') === 'percentage' ? 'selected' : '' }}>Percentage</option>
                                    <option value="fixed" {{ old('type') === 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
                                </select>
                                @error('type')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Value -->
                            <div>
                                <label for="value" class="block text-sm font-medium text-gray-700">Value</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <input type="number" name="value" id="value" value="{{ old('value') }}" step="0.01" min="0"
                                        class="block w-full pl-3 pr-12 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent bg-gray-50 text-sm transition-all duration-200"
                                        placeholder="0.00">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm" id="value-symbol">%</span>
                                    </div>
                                </div>
                                @error('value')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Min Order Amount -->
                            <div>
                                <label for="min_order_amount" class="block text-sm font-medium text-gray-700">Minimum Order Amount</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">$</span>
                                    </div>
                                    <input type="number" name="min_order_amount" id="min_order_amount" value="{{ old('min_order_amount') }}" step="0.01" min="0"
                                        class="block w-full pl-7 pr-12 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent bg-gray-50 text-sm transition-all duration-200"
                                        placeholder="0.00">
                                </div>
                                <p class="mt-1 text-xs text-gray-500">Leave empty for no minimum</p>
                                @error('min_order_amount')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Max Uses -->
                            <div>
                                <label for="max_uses" class="block text-sm font-medium text-gray-700">Maximum Uses</label>
                                <input type="number" name="max_uses" id="max_uses" value="{{ old('max_uses') }}" min="1"
                                    class="mt-1 block w-full pl-3 pr-10 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent bg-gray-50 text-sm transition-all duration-200"
                                    placeholder="Leave empty for unlimited">
                                <p class="mt-1 text-xs text-gray-500">Leave empty for unlimited uses</p>
                                @error('max_uses')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Start Date -->
                            <div>
                                <label for="starts_at" class="block text-sm font-medium text-gray-700">Start Date</label>
                                <input type="datetime-local" name="starts_at" id="starts_at" value="{{ old('starts_at') }}"
                                    class="mt-1 block w-full pl-3 pr-10 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent bg-gray-50 text-sm transition-all duration-200">
                                <p class="mt-1 text-xs text-gray-500">Leave empty to start immediately</p>
                                @error('starts_at')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Expiry Date -->
                            <div>
                                <label for="expires_at" class="block text-sm font-medium text-gray-700">Expiry Date</label>
                                <input type="datetime-local" name="expires_at" id="expires_at" value="{{ old('expires_at') }}"
                                    class="mt-1 block w-full pl-3 pr-10 py-2 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent bg-gray-50 text-sm transition-all duration-200">
                                <p class="mt-1 text-xs text-gray-500">Leave empty for no expiry</p>
                                @error('expires_at')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Active Status -->
                            <div class="flex items-center mt-6">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" name="is_active" id="is_active" value="1" 
                                    {{ old('is_active', true) ? 'checked' : '' }}
                                    class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300 rounded">
                                <label for="is_active" class="ml-2 block text-sm text-gray-700">
                                    Active
                                </label>
                            </div>
                        </div>

                        <div class="mt-8 pt-5 border-t border-gray-200">
                            <div class="flex justify-end">
                                <a href="{{ route('admin.coupons.index') }}" 
                                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 mr-3">
                                    Cancel
                                </a>
                                <button type="submit" 
                                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                                    Create Coupon
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Update the value symbol based on the selected type
    document.getElementById('type').addEventListener('change', function() {
        const valueSymbol = document.getElementById('value-symbol');
        valueSymbol.textContent = this.value === 'percentage' ? '%' : '$';
    });
</script>
@endpush
@endsection 