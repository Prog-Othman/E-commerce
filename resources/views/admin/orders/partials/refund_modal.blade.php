@if($order->canBeRefunded())
<!-- Refund Modal -->
<div class="fixed z-10 inset-0 overflow-y-auto hidden" id="refundModal">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
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
                            <!-- Refund Amount -->
                            <div>
                                <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                                <div class="mt-1 relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">MAD</span>
                                    </div>
                                    <input type="number" 
                                           name="amount" 
                                           id="amount" 
                                           step="0.01" 
                                           min="0.01" 
                                           max="{{ $order->refundable_amount }}" 
                                           value="{{ number_format($order->refundable_amount, 2, '.', '') }}" 
                                           class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-12 pr-12 sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <p class="mt-1 text-xs text-gray-500">
                                    Maximum refundable amount: {{ number_format($order->refundable_amount, 2) }} MAD
                                </p>
                            </div>
                            
                            <!-- Refund Reason -->
                            <div>
                                <label for="reason" class="block text-sm font-medium text-gray-700">Reason</label>
                                <div class="mt-1">
                                    <select id="reason" name="reason" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                        <option value="">Select a reason</option>
                                        <option value="Customer Request">Customer Request</option>
                                        <option value="Duplicate Order">Duplicate Order</option>
                                        <option value="Fraudulent Order">Fraudulent Order</option>
                                        <option value="Product Not as Described">Product Not as Described</option>
                                        <option value="Product Damaged">Product Damaged</option>
                                        <option value="Product Not Received">Product Not Received</option>
                                        <option value="Other">Other (please specify)</option>
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Custom Reason -->
                            <div id="customReasonContainer" style="display: none;">
                                <label for="custom_reason" class="block text-sm font-medium text-gray-700">Please specify</label>
                                <div class="mt-1">
                                    <input type="text" name="custom_reason" id="custom_reason" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                            </div>
                            
                            <!-- Notes -->
                            <div>
                                <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                                <div class="mt-1">
                                    <textarea id="notes" name="notes" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border border-gray-300 rounded-md"></textarea>
                                </div>
                                <p class="mt-1 text-xs text-gray-500">
                                    Add any additional notes about this refund.
                                </p>
                            </div>
                            
                            <!-- Refund Method -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Refund Method</label>
                                <div class="mt-2 space-y-2">
                                    <div class="flex items-center">
                                        <input id="refund_method_original" name="refund_method" type="radio" value="original_payment_method" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" checked>
                                        <label for="refund_method_original" class="ml-3 block text-sm font-medium text-gray-700">
                                            Original payment method
                                        </label>
                                    </div>
                                    <div class="flex items-center">
                                        <input id="refund_method_store_credit" name="refund_method" type="radio" value="store_credit" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                                        <label for="refund_method_store_credit" class="ml-3 block text-sm font-medium text-gray-700">
                                            Store credit
                                        </label>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Restock Items -->
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="restock_items" name="restock_items" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded" checked>
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="restock_items" class="font-medium text-gray-700">Restock items</label>
                                    <p class="text-gray-500">Return items to inventory</p>
                                </div>
                            </div>
                            
                            <!-- Send Notification -->
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="notify_customer" name="notify_customer" type="checkbox" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded" checked>
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="notify_customer" class="font-medium text-gray-700">Notify customer</label>
                                    <p class="text-gray-500">Send an email notification to the customer</p>
                                </div>
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
    const reasonSelect = document.getElementById('reason');
    const customReasonContainer = document.getElementById('customReasonContainer');
    const customReasonInput = document.getElementById('custom_reason');

    function openRefundModal() {
        refundModal.classList.remove('hidden');
        refundModal.classList.add('block');
        document.body.classList.add('overflow-hidden');
    }

    function closeRefundModal() {
        refundModal.classList.remove('block');
        refundModal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
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

    // Toggle custom reason field
    reasonSelect.addEventListener('change', function() {
        if (this.value === 'Other') {
            customReasonContainer.style.display = 'block';
            customReasonInput.required = true;
        } else {
            customReasonContainer.style.display = 'none';
            customReasonInput.required = false;
        }
    });

    // Handle refund form submission
    processRefundBtn.addEventListener('click', function() {
        // Validate form
        if (refundForm.checkValidity()) {
            // If custom reason is shown but empty, prevent submission
            if (reasonSelect.value === 'Other' && !customReasonInput.value.trim()) {
                customReasonInput.focus();
                return false;
            }
            
            // Show loading state
            const originalText = processRefundBtn.innerHTML;
            processRefundBtn.disabled = true;
            processRefundBtn.innerHTML = `
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Processing...
            `;
            
            // Submit form
            refundForm.submit();
        } else {
            refundForm.reportValidity();
        }
    });

    // Close modal when cancel button is clicked
    cancelRefundBtn.addEventListener('click', closeRefundModal);
</script>
@endpush
@endif
