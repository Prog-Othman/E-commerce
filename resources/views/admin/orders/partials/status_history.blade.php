<div class="bg-white shadow-sm rounded-lg overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-200">
        <h2 class="text-lg font-medium text-gray-900">Status History</h2>
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
                                            'pending' => 'schedule',
                                            'processing' => 'sync',
                                            'shipped' => 'local_shipping',
                                            'delivered' => 'check_circle',
                                            'cancelled' => 'cancel',
                                            'refunded' => 'monetization_on',
                                        ];
                                        $icon = $statusIcons[$history->status] ?? 'info';
                                        
                                        $statusColors = [
                                            'pending' => 'bg-yellow-500',
                                            'processing' => 'bg-blue-500',
                                            'shipped' => 'bg-indigo-500',
                                            'delivered' => 'bg-green-500',
                                            'cancelled' => 'bg-red-500',
                                            'refunded' => 'bg-gray-500',
                                        ];
                                        $color = $statusColors[$history->status] ?? 'bg-gray-500';
                                    @endphp
                                    <span class="h-8 w-8 rounded-full {{ $color }} flex items-center justify-center ring-8 ring-white">
                                        <span class="material-icons text-white text-base">{{ $icon }}</span>
                                    </span>
                                </div>
                                <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                    <div>
                                        <p class="text-sm text-gray-500">
                                            Status changed to <span class="font-medium text-gray-900">{{ ucfirst($history->status) }}</span>
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
                    <li class="text-sm text-gray-500 py-4">No status history available for this order.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
