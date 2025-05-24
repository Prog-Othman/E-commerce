@extends('layouts.app')
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-800">Order #{{ $order->id }}</h2>
                    <span class="px-3 py-1 text-sm font-semibold rounded-full 
                        @if($order->status === 'completed') bg-green-100 text-green-800
                        @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                        @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                        @else bg-yellow-100 text-yellow-800
                        @endif">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Order Summary -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Order Summary</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="space-y-4">
                                @foreach($order->items as $item)
                                    <div class="flex justify-between items-center">
                                        <div class="flex items-center">
                                            @if($item->product->hasMedia('images'))
                                                <img src="{{ $item->product->getFirstMediaUrl('images', 'thumb') }}" 
                                                     alt="{{ $item->product->name }}"
                                                     class="w-16 h-16 object-cover rounded-md">
                                            @else
                                                <div class="w-16 h-16 bg-gray-200 rounded-md flex items-center justify-center">
                                                    <span class="text-gray-400 text-xs">No image</span>
                                                </div>
                                            @endif
                                            <div class="ml-4">
                                                <h4 class="text-sm font-medium text-gray-900">{{ $item->product->name }}</h4>
                                                <p class="text-sm text-gray-500">Qty: {{ $item->quantity }}</p>
                                            </div>
                                        </div>
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ number_format($item->subtotal, 2, ',', ' ') }} MAD
                                        </p>
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-6 border-t border-gray-200 pt-4 space-y-2">
                                <div class="flex justify-between text-sm text-gray-600">
                                    <span>Subtotal</span>
                                    <span>{{ number_format($order->total_amount + $order->discount_amount, 2, ',', ' ') }} MAD</span>
                                </div>
                                @if($order->discount_amount > 0)
                                    <div class="flex justify-between text-sm text-green-600">
                                        <span>Discount</span>
                                        <span>-{{ number_format($order->discount_amount, 2, ',', ' ') }} MAD</span>
                                    </div>
                                @endif
                                <div class="flex justify-between text-base font-medium text-gray-900 pt-2 border-t border-gray-200">
                                    <span>Total</span>
                                    <span>{{ number_format($order->total_amount, 2, ',', ' ') }} MAD</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Details -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Order Details</h3>
                        <div class="bg-gray-50 p-6 rounded-lg space-y-4">
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Order Number</h4>
                                <p class="mt-1 text-sm text-gray-900">#{{ $order->id }}</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Date Placed</h4>
                                <p class="mt-1 text-sm text-gray-900">{{ $order->created_at->format('F j, Y \a\t g:i A') }}</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Payment Method</h4>
                                <p class="mt-1 text-sm text-gray-900 capitalize">{{ $order->payment_method }}</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Payment Status</h4>
                                <p class="mt-1 text-sm text-gray-900 capitalize">{{ $order->payment_status }}</p>
                            </div>
                            
                            <div class="pt-4 border-t border-gray-200">
                                <h4 class="text-sm font-medium text-gray-500">Shipping Address</h4>
                                <address class="mt-1 text-sm not-italic text-gray-900">
                                    {{ $order->shipping_address }}<br>
                                    {{ $order->shipping_city }}, {{ $order->shipping_state }}<br>
                                    {{ $order->shipping_country }}, {{ $order->shipping_zipcode }}<br>
                                    {{ $order->shipping_phone }}
                                </address>
                            </div>
                            
                            @if($order->notes)
                                <div class="pt-4 border-t border-gray-200">
                                    <h4 class="text-sm font-medium text-gray-500">Notes</h4>
                                    <p class="mt-1 text-sm text-gray-900">{{ $order->notes }}</p>
                                </div>
                            @endif
                        </div>
                        
                        @if($order->status === 'pending')
                            <div class="mt-6 flex justify-end">
                                <form action="{{ route('orders.cancel', $order) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                            onclick="return confirm('Are you sure you want to cancel this order?')">
                                        Cancel Order
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="mt-8">
                    <a href="{{ route('orders.index') }}" class="text-indigo-600 hover:text-indigo-900">
                        &larr; Back to Orders
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
