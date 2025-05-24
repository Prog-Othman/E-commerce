@extends('layouts.app')

@section('title', 'Order #' . $order->order_number)

@section('content')
<div class="flex">
    <!-- Sidebar -->
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
        <div class="p-8">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <div class="flex items-center">
                        <h1 class="text-2xl font-semibold text-gray-900">Commande #{{ $order->order_number }}</h1>
                        @if($order->status)
                            @php
                                $bgColor = 'bg-[' . $order->status->color . ']/10';
                                $textColor = 'text-[' . $order->status->color . ']';
                            @endphp
                            <span class="ml-4 px-3 py-1 text-sm font-medium rounded-full {{ $bgColor }} {{ $textColor }}">
                                {{ $order->status->name }}
                            </span>
                        @else
                            <span class="ml-4 px-3 py-1 text-sm font-medium rounded-full bg-gray-100 text-gray-800">
                                Inconnu
                            </span>
                        @endif
                    </div>
                    <p class="mt-1 text-sm text-gray-500">
                        Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}
                    </p>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Back to Orders
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Order Details -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Order Items -->
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
                                                    <a href="{{ route('products.show', $item->product) }}">
                                                        {{ $item->product->name }}
                                                    </a>
                                                </h3>
                                                <p class="mt-1 text-sm text-gray-500">
                                                    SKU: {{ $item->product->sku ?? 'N/A' }}
                                                </p>
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

                    <!-- Order Summary -->
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
                                @endif
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Shipping</span>
                                    <span class="text-sm font-medium text-gray-900">{{ number_format($order->shipping_amount, 2) }} MAD</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Tax</span>
                                    <span class="text-sm font-medium text-gray-900">{{ number_format($order->tax_amount, 2) }} MAD</span>
                                </div>
                                <div class="flex justify-between pt-4 border-t border-gray-200">
                                    <span class="text-base font-medium text-gray-900">Total</span>
                                    <span class="text-base font-bold text-gray-900">{{ number_format($order->total_amount, 2) }} MAD</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Actions & Info -->
                <div class="space-y-6">
                    <!-- Status Update -->
                    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                        <div class="px-6 py-5 border-b border-gray-200">
                            <h2 class="text-lg font-medium text-gray-900">Update Status</h2>
                        </div>
                        <div class="p-6">
                            <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="space-y-4">
                                @csrf
                                @method('PATCH')
                                <div>
                                    <label for="status_id" class="block text-sm font-medium text-gray-700">Statut</label>
                                    <select id="status_id" name="status_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                        @foreach($statuses as $status)
                                            <option value="{{ $status->id }}" {{ $order->status && $order->status->id === $status->id ? 'selected' : '' }}>
                                                {{ $status->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                                    <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                                    <p class="mt-2 text-sm text-gray-500">Add any notes about this status update.</p>
                                </div>
                                <div>
                                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Mettre à jour le statut
                                    </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Customer Information -->
                    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                        <div class="px-6 py-5 border-b border-gray-200">
                            <h2 class="text-lg font-medium text-gray-900">Customer Information</h2>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Contact Information</h3>
                                    <p class="mt-1 text-sm text-gray-900">{{ $order->user->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $order->user->email }}</p>
                                    <p class="text-sm text-gray-500">{{ $order->shipping_phone }}</p>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Shipping Address</h3>
                                    <p class="mt-1 text-sm text-gray-900">{{ $order->shipping_address }}</p>
                                    <p class="text-sm text-gray-900">{{ $order->shipping_city }}, {{ $order->shipping_state }}</p>
                                    <p class="text-sm text-gray-900">{{ $order->shipping_country }}, {{ $order->shipping_zipcode }}</p>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-500">Payment Method</h3>
                                    <p class="mt-1 text-sm text-gray-900">
                                        {{ ucfirst($order->payment_method) }}
                                        @if($order->payment_status)
                                            <span class="ml-2 px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ 
                                                $order->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 
                                                ($order->payment_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                                'bg-gray-100 text-gray-800') 
                                            }}">
                                                {{ ucfirst($order->payment_status) }}
                                            </span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order History -->
                    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                        <div class="px-6 py-5 border-b border-gray-200">
                            <h2 class="text-lg font-medium text-gray-900">Order History</h2>
                        </div>
                        <div class="p-6">
                            <div class="flow-root">
                                <ul class="-mb-8">
                                    @forelse($order->statusHistory as $history)
                                        <li>
                                            <div class="relative pb-8">
                                                @if(!$loop->last)
                                                    <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                                @endif
                                                <div class="relative flex space-x-3">
                                                    <div>
                                                        @php
                                                            $statusIcons = [
                                                                'En attente' => 'schedule',
                                                                'Traitement' => 'sync',
                                                                'Expédié' => 'local_shipping',
                                                                'Livré' => 'check_circle',
                                                                'Annulé' => 'cancel',
                                                                'Remboursé' => 'monetization_on',
                                                            ];
                                                            $icon = $history->status ? ($statusIcons[$history->status->name] ?? 'info') : 'info';
                                                            $bgColor = $history->status ? 'bg-[' . $history->status->color . ']/10' : 'bg-gray-100';
                                                            $textColor = $history->status ? 'text-[' . $history->status->color . ']' : 'text-gray-600';
                                                        @endphp
                                                        <span class="h-8 w-8 rounded-full {{ $bgColor }} flex items-center justify-center ring-8 ring-white">
                                                            <span class="material-icons {{ $textColor }} text-base">{{ $icon }}</span>
                                                        </span>
                                                    </div>
                                                    <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                        <div>
                                                            <p class="text-sm text-gray-500">
                                                                Statut changé en <span class="font-medium {{ $textColor }}">{{ $history->status ? $history->status->name : 'Inconnu' }}</span>
                                                                @if($history->notes)
                                                                    <span class="block text-gray-500 mt-1">{{ $history->notes }}</span>
                                                                @endif
                                                            </p>
                                                        </div>
                                                        <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                            <time datetime="{{ $history->created_at->toIso8601String() }}">
                                                                {{ $history->created_at->diffForHumans() }}
                                                            </time>
                                                            @if($history->user)
                                                                <p class="text-xs text-gray-400">by {{ $history->user->name }}</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @empty
                                        <li class="text-sm text-gray-500 py-4">No history available for this order.</li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($order->status && in_array($order->status->name, ['En attente', 'Traitement']))
<!-- Refund Modal -->
<div class="fixed z-10 inset-0 overflow-y-auto hidden" id="refundModal">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
            <div>
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <div class="mt-3 text-center sm:mt-5">
                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                        Process Refund
                    </h3>
                    <div class="mt-2">
                        <p class="text-sm text-gray-500">
                            Are you sure you want to process a refund for this order? This action cannot be undone.
                        </p>
                    </div>
                    <form id="refundForm" action="{{ route('admin.orders.refund', $order) }}" method="POST" class="mt-4">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">MAD</span>
                                    </div>
                                    <input type="number" name="amount" id="amount" step="0.01" min="0.01" max="{{ $order->total_amount }}" value="{{ $order->total_amount }}" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-12 pr-12 sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <p class="mt-1 text-xs text-gray-500">
                                    Maximum refundable amount: {{ number_format($order->total_amount, 2) }} MAD
                                </p>
                            </div>
                            <div>
                                <label for="reason" class="block text-sm font-medium text-gray-700">Reason</label>
                                <div class="mt-1">
                                    <textarea id="reason" name="reason" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border border-gray-300 rounded-md" required></textarea>
                                </div>
                                <p class="mt-1 text-xs text-gray-500">
                                    Please provide a reason for this refund.
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                <button type="button" id="processRefundBtn" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:col-start-2 sm:text-sm">
                    Process Refund
                </button>
                <button type="button" id="cancelRefundBtn" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:col-start-1 sm:text-sm">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Handle refund modal
    const refundModal = document.getElementById('refundModal');
    const processRefundBtn = document.getElementById('processRefundBtn');
    const cancelRefundBtn = document.getElementById('cancelRefundBtn');
    const refundForm = document.getElementById('refundForm');

    function openRefundModal() {
        refundModal.classList.remove('hidden');
        refundModal.classList.add('block');
    }

    function closeRefundModal() {
        refundModal.classList.remove('block');
        refundModal.classList.add('hidden');
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        if (event.target === refundModal) {
            closeRefundModal();
        }
    }

    // Close modal when pressing Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeRefundModal();
        }
    });

    // Handle refund form submission
    processRefundBtn.addEventListener('click', function() {
        refundForm.submit();
    });

    // Close modal when cancel button is clicked
    cancelRefundBtn.addEventListener('click', closeRefundModal);
</script>
@endpush
@endif

@endsection
