<div class="bg-white shadow-sm rounded-lg overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-200">
        <h2 class="text-lg font-medium text-gray-900">Customer Information</h2>
    </div>
    <div class="p-6">
        <div class="space-y-6">
            <!-- Customer Details -->
            <div>
                <h3 class="text-sm font-medium text-gray-500">Contact Information</h3>
                <div class="mt-2">
                    <p class="text-sm text-gray-900">{{ $order->user->name }}</p>
                    <p class="text-sm text-gray-500">{{ $order->user->email }}</p>
                    @if($order->contact_phone)
                        <p class="mt-1 text-sm text-gray-900">{{ $order->contact_phone }}</p>
                    @endif
                    
                    @if($order->user->id)
                        <div class="mt-2">
                            <a href="{{ route('admin.users.show', $order->user) }}" 
                               class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-500">
                                View Customer Profile
                                <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Shipping Address -->
            <div>
                <h3 class="text-sm font-medium text-gray-500">Shipping Address</h3>
                <address class="mt-2 not-italic">
                    <p class="text-sm text-gray-900">{{ $order->shipping_name ?? $order->user->name }}</p>
                    @if($order->shipping_company)
                        <p class="text-sm text-gray-900">{{ $order->shipping_company }}</p>
                    @endif
                    <p class="text-sm text-gray-900">{{ $order->shipping_address_line1 }}</p>
                    @if($order->shipping_address_line2)
                        <p class="text-sm text-gray-900">{{ $order->shipping_address_line2 }}</p>
                    @endif
                    <p class="text-sm text-gray-900">
                        {{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_zipcode }}
                    </p>
                    <p class="text-sm text-gray-900">
                        {{ $order->shipping_country }}
                    </p>
                    @if($order->shipping_phone)
                        <p class="mt-1 text-sm text-gray-900">
                            <span class="text-gray-500">Phone:</span> {{ $order->shipping_phone }}
                        </p>
                    @endif
                </address>
            </div>
            
            <!-- Billing Address -->
            @if($order->billing_address_line1)
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Billing Address</h3>
                    <address class="mt-2 not-italic">
                        <p class="text-sm text-gray-900">{{ $order->billing_name ?? $order->user->name }}</p>
                        @if($order->billing_company)
                            <p class="text-sm text-gray-900">{{ $order->billing_company }}</p>
                        @endif
                        <p class="text-sm text-gray-900">{{ $order->billing_address_line1 }}</p>
                        @if($order->billing_address_line2)
                            <p class="text-sm text-gray-900">{{ $order->billing_address_line2 }}</p>
                        @endif
                        <p class="text-sm text-gray-900">
                            {{ $order->billing_city }}, {{ $order->billing_state }} {{ $order->billing_zipcode }}
                        </p>
                        <p class="text-sm text-gray-900">
                            {{ $order->billing_country }}
                        </p>
                        @if($order->billing_phone)
                            <p class="mt-1 text-sm text-gray-900">
                                <span class="text-gray-500">Phone:</span> {{ $order->billing_phone }}
                            </p>
                        @endif
                    </address>
                </div>
            @endif
            
            <!-- Payment Information -->
            <div>
                <h3 class="text-sm font-medium text-gray-500">Payment Information</h3>
                <div class="mt-2">
                    <p class="text-sm text-gray-900">
                        <span class="capitalize">{{ $order->payment_method }}</span>
                        @if($order->payment_reference)
                            <span class="text-gray-500">({{ $order->payment_reference }})</span>
                        @endif
                    </p>
                    <p class="mt-1 text-sm">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                            {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 
                               ($order->payment_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                               ($order->payment_status === 'failed' ? 'bg-red-100 text-red-800' : 
                               'bg-gray-100 text-gray-800')) }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                        @if($order->payment_status === 'paid' && $order->paid_at)
                            <span class="text-xs text-gray-500 ml-1">
                                on {{ $order->paid_at->format('M d, Y') }}
                            </span>
                        @endif
                    </p>
                </div>
                
                @if($order->canBeRefunded())
                    <div class="mt-4">
                        <button type="button" 
                                onclick="openRefundModal()"
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            <svg class="-ml-0.5 mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m5 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Process Refund
                        </button>
                    </div>
                @endif
            </div>
            
            <!-- Shipping Information -->
            @if($order->shipping_method || $order->tracking_number || $order->shipped_at)
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Shipping Information</h3>
                    <div class="mt-2 space-y-1">
                        @if($order->shipping_method)
                            <p class="text-sm text-gray-900">
                                <span class="text-gray-500">Method:</span> 
                                <span class="capitalize">{{ $order->shipping_method }}</span>
                            </p>
                        @endif
                        
                        @if($order->tracking_number)
                            <p class="text-sm text-gray-900">
                                <span class="text-gray-500">Tracking #:</span> 
                                @if($order->tracking_url)
                                    <a href="{{ $order->tracking_url }}" target="_blank" class="text-indigo-600 hover:text-indigo-500">
                                        {{ $order->tracking_number }}
                                    </a>
                                @else
                                    {{ $order->tracking_number }}
                                @endif
                            </p>
                        @endif
                        
                        @if($order->shipped_at)
                            <p class="text-sm text-gray-900">
                                <span class="text-gray-500">Shipped on:</span> 
                                {{ $order->shipped_at->format('M d, Y') }}
                            </p>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
