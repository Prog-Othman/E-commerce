<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Shopping Cart') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($cart && $cart->items->count() > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="space-y-6">
                            @foreach($cart->items as $item)
                                <div class="flex items-center space-x-4">
                                    @if($item->product->hasMedia('images'))
                                        <img src="{{ $item->product->getFirstMediaUrl('images') }}" alt="{{ $item->product->name }}"
                                            class="w-24 h-24 object-cover rounded-lg">
                                    @else
                                        <div class="w-24 h-24 bg-gray-200 rounded-lg flex items-center justify-center">
                                            <span class="text-gray-400">No image</span>
                                        </div>
                                    @endif

                                    <div class="flex-1">
                                        <h3 class="text-lg font-semibold text-gray-900">
                                            <a href="{{ route('products.show', $item->product) }}" class="hover:text-indigo-600">
                                                {{ $item->product->name }}
                                            </a>
                                        </h3>
                                        <p class="text-gray-600 text-sm">
                                            ${{ number_format($item->product->price, 2) }} each
                                        </p>
                                    </div>

                                    <div class="flex items-center space-x-4">
                                        <form action="{{ route('cart.update', $item) }}" method="POST" class="flex items-center">
                                            @csrf
                                            @method('PATCH')
                                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}"
                                                class="w-20 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <button type="submit" class="ml-2 text-indigo-600 hover:text-indigo-900">Update</button>
                                        </form>

                                        <form action="{{ route('cart.remove', $item) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Remove</button>
                                        </form>
                                    </div>

                                    <div class="text-right">
                                        <p class="text-lg font-semibold text-gray-900">
                                            ${{ number_format($item->subtotal, 2) }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6 border-t border-gray-200 pt-6">
                            <!-- Coupon Form -->
                            <div class="mb-6">
                                @if(session('coupon'))
                                    <div class="flex justify-between items-center mb-4">
                                        <div>
                                            <p class="text-sm text-gray-600">Applied Coupon:</p>
                                            <p class="text-lg font-semibold text-green-600">{{ session('coupon')->code }}</p>
                                        </div>
                                        <form action="{{ route('checkout.remove-coupon') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-red-600 hover:text-red-900">Remove</button>
                                        </form>
                                    </div>
                                @else
                                    <form action="{{ route('checkout.apply-coupon') }}" method="POST" class="flex space-x-4">
                                        @csrf
                                        <div class="flex-1">
                                            <label for="code" class="sr-only">Coupon Code</label>
                                            <input type="text" name="code" id="code" placeholder="Enter coupon code"
                                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        </div>
                                        <button type="submit"
                                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Apply Coupon
                                        </button>
                                    </form>
                                @endif
                            </div>

                            <div class="flex justify-between items-center">
                                <div>
                                    <form action="{{ route('cart.clear') }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                            Clear Cart
                                        </button>
                                    </form>
                                </div>

                                <div class="text-right">
                                    @if(session('coupon'))
                                        <p class="text-sm text-gray-600">Subtotal: ${{ number_format($cart->total, 2) }}</p>
                                        <p class="text-sm text-green-600">Discount: -${{ number_format(session('coupon')->calculateDiscount($cart->total), 2) }}</p>
                                    @endif
                                    <p class="text-lg font-semibold text-gray-900">
                                        Total: ${{ number_format(session('coupon') ? $cart->total - session('coupon')->calculateDiscount($cart->total) : $cart->total, 2) }}
                                    </p>
                                </div>
                            </div>

                            <div class="mt-6">
                                <a href="{{ route('checkout') }}"
                                    class="w-full flex justify-center items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                                    Proceed to Checkout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <p class="text-gray-600">Your cart is empty.</p>
                        <a href="{{ route('products.index') }}"
                            class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                            Continue Shopping
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout> 