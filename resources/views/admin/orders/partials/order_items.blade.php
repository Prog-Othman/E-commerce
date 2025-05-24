<div class="bg-white shadow-sm rounded-lg overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-200">
        <h2 class="text-lg font-medium text-gray-900">Order Items</h2>
    </div>
    <div class="divide-y divide-gray-200">
        @foreach($order->items as $item)
            <div class="p-6 flex">
                <div class="flex-shrink-0 h-20 w-20 rounded-md overflow-hidden">
                    @if($item->product->hasMedia('images'))
                        <img src="{{ $item->product->getFirstMediaUrl('images', 'thumb') }}" 
                             alt="{{ $item->product->name }}" 
                             class="h-full w-full object-cover">
                    @else
                        <div class="h-full w-full bg-gray-200 flex items-center justify-center">
                            <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    @endif
                </div>
                <div class="ml-6 flex-1">
                    <div class="flex">
                        <div class="flex-1">
                            <h3 class="text-sm font-medium text-gray-900">
                                <a href="{{ route('products.show', $item->product) }}" class="hover:text-indigo-600">
                                    {{ $item->product->name }}
                                </a>
                            </h3>
                            <p class="mt-1 text-sm text-gray-500">
                                SKU: {{ $item->product->sku ?? 'N/A' }}
                            </p>
                            @if($item->variant)
                                <p class="mt-1 text-sm text-gray-500">
                                    Variant: {{ $item->variant->name }}
                                </p>
                            @endif
                        </div>
                        <p class="text-sm font-medium text-gray-900">
                            {{ number_format($item->price, 2) }} MAD
                        </p>
                    </div>
                    <div class="mt-2 flex-1 flex items-end justify-between">
                        <p class="text-sm text-gray-500">
                            Qty {{ $item->quantity }}
                        </p>
                        <p class="text-sm font-medium text-gray-900">
                            {{ number_format($item->price * $item->quantity, 2) }} MAD
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
