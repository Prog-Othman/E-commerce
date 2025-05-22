<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Checkout') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Order Summary -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Summary</h3>
                        
                        <div class="space-y-4">
                            @foreach($cart->items as $item)
                                <div class="flex justify-between">
                                    <div>
                                        <p class="text-gray-900">{{ $item->product->name }}</p>
                                        <p class="text-sm text-gray-600">Quantity: {{ $item->quantity }}</p>
                                    </div>
                                    <p class="text-gray-900">${{ number_format($item->subtotal, 2) }}</p>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6 border-t border-gray-200 pt-4">
                            <div class="flex justify-between">
                                <p class="text-lg font-semibold text-gray-900">Total</p>
                                <p class="text-lg font-semibold text-gray-900">${{ number_format($cart->total, 2) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Checkout Form -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Shipping Information</h3>

                        <form action="{{ route('orders.store') }}" method="POST" id="payment-form">
                            @csrf

                            <div class="space-y-4">
                                <div>
                                    <label for="shipping_address" class="block text-sm font-medium text-gray-700">Address</label>
                                    <input type="text" name="shipping_address" id="shipping_address" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="shipping_city" class="block text-sm font-medium text-gray-700">City</label>
                                        <input type="text" name="shipping_city" id="shipping_city" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>

                                    <div>
                                        <label for="shipping_state" class="block text-sm font-medium text-gray-700">State</label>
                                        <input type="text" name="shipping_state" id="shipping_state" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="shipping_country" class="block text-sm font-medium text-gray-700">Country</label>
                                        <input type="text" name="shipping_country" id="shipping_country" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>

                                    <div>
                                        <label for="shipping_zipcode" class="block text-sm font-medium text-gray-700">ZIP Code</label>
                                        <input type="text" name="shipping_zipcode" id="shipping_zipcode" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>
                                </div>

                                <div>
                                    <label for="shipping_phone" class="block text-sm font-medium text-gray-700">Phone</label>
                                    <input type="tel" name="shipping_phone" id="shipping_phone" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>

                                <div>
                                    <label for="payment_method" class="block text-sm font-medium text-gray-700">Payment Method</label>
                                    <select name="payment_method" id="payment_method" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="stripe">Credit Card (Stripe)</option>
                                        <option value="paypal">PayPal</option>
                                    </select>
                                </div>

                                <div id="stripe-elements" class="mt-4">
                                    <label for="card-element" class="block text-sm font-medium text-gray-700">Credit Card Details</label>
                                    <div id="card-element" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <!-- Stripe Elements will be inserted here -->
                                    </div>
                                    <div id="card-errors" class="mt-2 text-sm text-red-600"></div>
                                </div>

                                <div>
                                    <label for="notes" class="block text-sm font-medium text-gray-700">Order Notes (Optional)</label>
                                    <textarea name="notes" id="notes" rows="3"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                                </div>
                            </div>

                            <div class="mt-6">
                                <button type="submit"
                                    class="w-full flex justify-center items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                                    Place Order
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe = Stripe('{{ config('services.stripe.key') }}');
        const elements = stripe.elements();
        const card = elements.create('card');
        card.mount('#card-element');

        const form = document.getElementById('payment-form');
        const cardErrors = document.getElementById('card-errors');

        form.addEventListener('submit', async (event) => {
            event.preventDefault();

            if (document.getElementById('payment_method').value === 'stripe') {
                const {token, error} = await stripe.createToken(card);

                if (error) {
                    cardErrors.textContent = error.message;
                } else {
                    const hiddenInput = document.createElement('input');
                    hiddenInput.setAttribute('type', 'hidden');
                    hiddenInput.setAttribute('name', 'stripe_token');
                    hiddenInput.setAttribute('value', token.id);
                    form.appendChild(hiddenInput);
                    form.submit();
                }
            } else {
                form.submit();
            }
        });
    </script>
    @endpush
</x-app-layout> 