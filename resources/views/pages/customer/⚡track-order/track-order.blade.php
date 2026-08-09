
<div>
    <div class="min-h-screen bg-gray-50 py-6">
    <div class="mx-auto px-4 space-y-5">

        @if (session()->has('success'))
            <div class="bg-emerald-50 text-emerald-700 px-4 py-3 rounded-lg text-sm font-medium">{{ session('success') }}</div>
        @endif

        <div class="flex items-center gap-2">
            <a href="{{ route('customer.order_history') }}" class="p-1.5 rounded-lg hover:bg-gray-200 transition">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div>
                <h1 class="text-lg font-semibold text-gray-900">Order #{{ $order->order_number }}</h1>
                <p class="text-xs text-gray-400">Placed on {{ $order->created_at->format('M d, Y g:i A') }}</p>
            </div>
        </div>

        @if ($order->status === 'canceled')
            <div class="bg-white rounded-lg border border-red-200 p-5 flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-red-50 flex items-center justify-center shrink-0">
                    <svg class="w-4.5 h-4.5 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
                <p class="text-sm text-red-700 font-medium">This order was canceled.</p>
            </div>
        @else
            <!-- Tracking stepper -->
            <div class="bg-white rounded-lg border border-gray-200 p-5">
                @php $currentIndex = $this->currentStepIndex(); @endphp
                <div class="flex items-center">
                    @foreach (self::STEPS as $key => $label)
                        @php $stepIndex = array_search($key, array_keys(self::STEPS)); $done = $stepIndex <= $currentIndex; @endphp
                        <div class="flex-1 flex flex-col items-center relative">
                            @if (!$loop->first)
                                <div class="absolute top-3 right-1/2 w-full h-0.5 {{ $stepIndex <= $currentIndex ? 'bg-emerald-600' : 'bg-gray-200' }}"></div>
                            @endif
                            <div class="relative z-10 w-6 h-6 rounded-full flex items-center justify-center text-[10px] font-bold {{ $done ? 'bg-emerald-600 text-white' : 'bg-gray-200 text-gray-400' }}">
                                @if ($done && $stepIndex < $currentIndex)
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                @else
                                    {{ $stepIndex + 1 }}
                                @endif
                            </div>
                            <p class="text-[11px] mt-2 text-center {{ $done ? 'text-gray-800 font-medium' : 'text-gray-400' }}">{{ $label }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Pickup location -->
        <div class="bg-white rounded-lg border border-gray-200 p-5">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-2">Pickup Location</p>
            <p class="text-sm font-medium text-gray-800">{{ $order->tenant?->name }}</p>
            <p class="text-sm text-gray-500 mt-0.5">{{ $order->tenant?->address ?: 'Address not set' }}</p>
            <p class="text-xs text-gray-400 mt-1">{{ $order->tenant?->phone }}</p>
        </div>

        <!-- Items -->
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <div class="px-5 py-3 border-b border-gray-100">
                <p class="text-sm font-semibold text-gray-800">Order Items</p>
            </div>
            <div class="divide-y divide-gray-100">
                @foreach ($order->items as $item)
                    <div class="flex items-center justify-between px-5 py-3 text-sm">
                        <div>
                            <p class="text-gray-800">{{ $item->name }} × {{ $item->quantity }}</p>
                            @if ($item->variant_details)
                                @php $attrs = json_decode($item->variant_details, true); @endphp
                                @if ($attrs)
                                    <p class="text-xs text-gray-400 mt-0.5">{{ collect($attrs)->map(fn ($v, $k) => "{$k}: {$v}")->implode(', ') }}</p>
                                @endif
                            @endif
                        </div>
                        <span class="font-medium text-gray-800">${{ number_format($item->subtotal, 2) }}</span>
                    </div>
                @endforeach
            </div>
            <div class="px-5 py-3 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
                <span class="text-sm font-medium text-gray-700">Total Payment</span>
                <span class="text-lg font-bold text-emerald-700">${{ number_format($order->total, 2) }}</span>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-3 text-xs text-gray-500">
            <div class="bg-white rounded-lg border border-gray-200 p-4">
                <p class="text-gray-400 mb-1">Payment Method</p>
                <p class="text-gray-800 font-medium">{{ $order->payment_type === 'cash' ? 'Cash on Pickup' : 'Online Payment' }}</p>
            </div>
            <div class="bg-white rounded-lg border border-gray-200 p-4">
                <p class="text-gray-400 mb-1">Payment Status</p>
                <p class="text-gray-800 font-medium">{{ ucfirst($order->payment_status) }}</p>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-3">
            @if (in_array($order->status, ['pending', 'confirmed'], true))
                <button wire:click="cancelOrder" wire:confirm="Cancel this order?"
                        class="flex-1 px-5 py-2.5 border border-red-200 text-red-600 rounded-md text-sm font-medium hover:bg-red-50 transition">
                    Cancel Order
                </button>
            @endif
            <a href="{{ route('customer.order_history') }}" class="flex-1 text-center px-5 py-2.5 bg-emerald-700 text-white rounded-md text-sm font-medium hover:bg-emerald-800 transition">
                View All Orders
            </a>
        </div>
    </div>
</div>
</div>