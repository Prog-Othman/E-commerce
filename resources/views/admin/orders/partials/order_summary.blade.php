<div class="bg-white shadow-sm rounded-lg overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-200">
        <h2 class="text-lg font-medium text-gray-900">Order Summary</h2>
    </div>
    <div class="p-6">
        <div class="space-y-4">
            <div class="flex justify-between">
                <span class="text-sm text-gray-600">Subtotal</span>
                <span class="text-sm font-medium text-gray-900">{{ number_format($order->subtotal, 2) }} MAD</span>
            </div>
            
            @if($order->discount_amount > 0)
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600">Discount</span>
                    <span class="text-sm font-medium text-red-600">-{{ number_format($order->discount_amount, 2) }} MAD</span>
                </div>
                
                @if($order->coupon)
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Coupon Applied</span>
                        <span class="text-sm font-medium text-gray-900">{{ $order->coupon->code }} ({{ $order->coupon->discount_type === 'fixed' ? number_format($order->coupon->discount_value, 2) . ' MAD' : $order->coupon->discount_value . '%' }})</span>
                    </div>
                @endif
            @endif
            
            <div class="flex justify-between">
                <span class="text-sm text-gray-600">Shipping</span>
                <span class="text-sm font-medium text-gray-900">
                    {{ number_format($order->shipping_amount, 2) }} MAD
                    @if($order->shipping_method)
                        <span class="text-gray-500 text-xs block">({{ $order->shipping_method }})</span>
                    @endif
                </span>
            </div>
            
            <div class="flex justify-between">
                <span class="text-sm text-gray-600">Tax</span>
                <span class="text-sm font-medium text-gray-900">
                    {{ number_format($order->tax_amount, 2) }} MAD
                    @if($order->tax_rate > 0)
                        <span class="text-gray-500 text-xs block">({{ $order->tax_rate }}%)</span>
                    @endif
                </span>
            </div>
            
            <div class="pt-4 border-t border-gray-200">
                <div class="flex justify-between">
                    <span class="text-base font-medium text-gray-900">Total</span>
                    <span class="text-base font-bold text-gray-900">{{ number_format($order->total_amount, 2) }} MAD</span>
                </div>
                @if($order->payment_status === 'paid')
                    <div class="mt-2 text-right">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-green-400" fill="currentColor" viewBox="0 0 8 8">
                                <circle cx="4" cy="4" r="3" />
                            </svg>
                            Paid on {{ $order->paid_at->format('M d, Y') }}
                        </span>
                    </div>
                @endif
            </div>
            
            @if($order->notes)
                <div class="pt-4 border-t border-gray-200">
                    <h3 class="text-sm font-medium text-gray-900">Order Notes</h3>
                    <p class="mt-1 text-sm text-gray-600">{{ $order->notes }}</p>
                </div>
            @endif
        </div>
    </div>
</div>
