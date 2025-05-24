<div class="bg-white shadow-sm rounded-lg overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-200">
        <h2 class="text-lg font-medium text-gray-900">Update Status</h2>
    </div>
    <div class="p-6">
        <form action="{{ route('admin.orders.status', $order) }}" method="POST">
            @csrf
            <div class="space-y-4">
                <!-- Status Selection -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select id="status" name="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        @foreach($statuses as $status)
                            <option value="{{ $status->id }}" {{ $order->status_id == $status->id ? 'selected' : '' }}>
                                {{ ucfirst($status->name) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Tracking Number -->
                <div id="shippingFields" style="display: {{ in_array($order->status, ['shipped', 'delivered']) ? 'block' : 'none' }};">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="tracking_number" class="block text-sm font-medium text-gray-700">Tracking Number</label>
                            <input type="text" name="tracking_number" id="tracking_number" 
                                   value="{{ $order->tracking_number }}" 
                                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                        <div>
                            <label for="shipping_carrier" class="block text-sm font-medium text-gray-700">Shipping Carrier</label>
                            <select name="shipping_carrier" id="shipping_carrier" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="">Select Carrier</option>
                                <option value="DHL" {{ $order->shipping_carrier === 'DHL' ? 'selected' : '' }}>DHL</option>
                                <option value="FedEx" {{ $order->shipping_carrier === 'FedEx' ? 'selected' : '' }}>FedEx</option>
                                <option value="UPS" {{ $order->shipping_carrier === 'UPS' ? 'selected' : '' }}>UPS</option>
                                <option value="USPS" {{ $order->shipping_carrier === 'USPS' ? 'selected' : '' }}>USPS</option>
                                <option value="Aramex" {{ $order->shipping_carrier === 'Aramex' ? 'selected' : '' }}>Aramex</option>
                                <option value="Other" {{ !in_array($order->shipping_carrier, ['DHL', 'FedEx', 'UPS', 'USPS', 'Aramex', null]) && $order->shipping_carrier ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                    </div>
                    <div id="customCarrierContainer" class="mt-4" style="display: {{ !in_array($order->shipping_carrier, ['DHL', 'FedEx', 'UPS', 'USPS', 'Aramex', null]) && $order->shipping_carrier ? 'block' : 'none' }};">
                        <label for="custom_shipping_carrier" class="block text-sm font-medium text-gray-700">Custom Carrier Name</label>
                        <input type="text" name="custom_shipping_carrier" id="custom_shipping_carrier" 
                               value="{{ !in_array($order->shipping_carrier, ['DHL', 'FedEx', 'UPS', 'USPS', 'Aramex', null]) ? $order->shipping_carrier : '' }}" 
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                </div>
                
                <!-- Notes -->
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                    <div class="mt-1">
                        <textarea id="notes" name="notes" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border border-gray-300 rounded-md"></textarea>
                    </div>
                    <p class="mt-1 text-sm text-gray-500">Add any notes about this status update.</p>
                </div>
                
                <!-- Notify Customer -->
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="notify_customer" name="notify_customer" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="notify_customer" class="font-medium text-gray-700">Notify customer by email</label>
                        <p class="text-gray-500">Send an email to the customer about this status update.</p>
                    </div>
                </div>
                
                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Update Status
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Show/hide shipping fields based on status selection
    document.getElementById('status').addEventListener('change', function() {
        const status = this.options[this.selectedIndex].text.toLowerCase();
        const shippingFields = document.getElementById('shippingFields');
        
        if (status === 'shipped' || status === 'delivered') {
            shippingFields.style.display = 'block';
        } else {
            shippingFields.style.display = 'none';
        }
    });
    
    // Show/hide custom carrier input
    document.getElementById('shipping_carrier').addEventListener('change', function() {
        const customCarrierContainer = document.getElementById('customCarrierContainer');
        if (this.value === 'Other') {
            customCarrierContainer.style.display = 'block';
            document.getElementById('custom_shipping_carrier').required = true;
        } else {
            customCarrierContainer.style.display = 'none';
            document.getElementById('custom_shipping_carrier').required = false;
        }
    });
    
    // Form submission
    document.querySelector('form').addEventListener('submit', function(e) {
        const statusSelect = document.getElementById('status');
        const status = statusSelect.options[statusSelect.selectedIndex].text.toLowerCase();
        const shippingCarrier = document.getElementById('shipping_carrier');
        const customCarrier = document.getElementById('custom_shipping_carrier');
        
        // If status is shipped/delivered and carrier is other but no custom carrier provided
        if ((status === 'shipped' || status === 'delivered') && 
            shippingCarrier.value === 'Other' && !customCarrier.value.trim()) {
            e.preventDefault();
            alert('Please provide a custom shipping carrier name.');
            customCarrier.focus();
            return false;
        }
    });
</script>
@endpush
