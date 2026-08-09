<div class="min-h-screen bg-gray-50 py-6">
    <div class=" mx-auto px-4">

        @if (session()->has('error'))
            <div class="mb-4 bg-red-50 text-red-700 px-4 py-3 rounded-lg text-sm font-medium">{{ session('error') }}</div>
        @endif

        <div class="flex items-center gap-2 mb-5">
            <a href="{{ route('customer.dashboard') }}" class="p-1.5 rounded-lg hover:bg-gray-200 transition">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <h1 class="text-lg font-semibold text-gray-900">Checkout</h1>
        </div>

        @if ($this->groupedCart->isEmpty())
            <div class="bg-white rounded-lg border border-gray-200 p-16 text-center">
                <p class="text-gray-500 text-sm">Your cart is empty.</p>
                <a href="{{ route('customer.dashboard') }}" class="text-emerald-700 font-medium text-sm mt-2 inline-block hover:underline">Browse products</a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 items-start">

                <!-- LEFT: cart contents -->
                <div class="lg:col-span-2 space-y-4">
                    @foreach ($this->groupedCart as $tenantId => $group)
                        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                            <div class="px-4 py-3 border-b border-gray-100 flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                <p class="text-sm font-semibold text-gray-800">{{ $group['tenant']?->name ?? 'Shop' }}</p>
                            </div>

                            <div class="divide-y divide-gray-100">
                                @foreach ($group['items'] as $item)
                                    <div wire:key="cart-{{ $item['cart_item_id'] }}" class="flex items-center gap-3 p-4">
                                        <div class="w-14 h-14 rounded-md bg-gray-100 overflow-hidden shrink-0 border border-gray-100">
                                            @if ($item['image'])
                                                <img src="{{ Storage::url($item['image']) }}" class="w-full h-full object-cover">
                                            @endif
                                        </div>

                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm text-gray-800 line-clamp-1">{{ $item['name'] }}</p>
                                            @if (!empty($item['variant_attributes']))
                                                <p class="text-xs text-gray-400 mt-0.5">
                                                    {{ collect($item['variant_attributes'])->map(fn ($v, $k) => "{$k}: {$v}")->implode(', ') }}
                                                </p>
                                            @endif
                                        </div>

                                        <p class="text-sm font-medium text-gray-800 w-20 text-right shrink-0">${{ number_format($item['unit_price'], 2) }}</p>

                                        <div class="flex items-center border border-gray-200 rounded overflow-hidden shrink-0">
                                            <button wire:click="updateQuantity('{{ $item['cart_item_id'] }}', {{ $item['quantity'] - 1 }})"
                                                    class="w-7 h-7 flex items-center justify-center text-gray-500 hover:bg-gray-50 text-sm">−</button>
                                            <span class="w-8 text-center text-sm">{{ $item['quantity'] }}</span>
                                            <button wire:click="updateQuantity('{{ $item['cart_item_id'] }}', {{ $item['quantity'] + 1 }})"
                                                    class="w-7 h-7 flex items-center justify-center text-gray-500 hover:bg-gray-50 text-sm">+</button>
                                        </div>

                                        <p class="text-sm font-semibold text-gray-900 w-20 text-right shrink-0">${{ number_format($item['unit_price'] * $item['quantity'], 2) }}</p>

                                        <button wire:click="removeItem('{{ $item['cart_item_id'] }}')" class="text-gray-300 hover:text-red-500 transition shrink-0">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>
                                @endforeach
                            </div>

                            <div class="px-4 py-2.5 bg-gray-50 border-t border-gray-100 flex items-center gap-2 text-xs text-gray-500">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Store pickup only — no delivery for this order
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- RIGHT: sticky order summary -->
                <div class="lg:sticky lg:top-6">
                    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                        <div class="px-4 py-3 border-b border-gray-100">
                            <p class="text-sm font-semibold text-gray-800">Order Summary</p>
                        </div>

                        <div class="p-4 space-y-3">
                            <div>
                                <label class="block text-xs text-gray-500 mb-1.5">Payment Method</label>
                                <select wire:model="paymentType" class="w-full px-3 py-2 border border-gray-200 rounded text-sm bg-white focus:ring-1 focus:ring-emerald-400 focus:border-emerald-400">
                                    <option value="cash">Cash on Pickup</option>
                                    <option value="online">Online Payment</option>
                                </select>
                            </div>

                            <div class="pt-2 space-y-2 text-sm border-t border-gray-100">
                                <div class="flex justify-between text-gray-500">
                                    <span>Merchandise Subtotal ({{ $this->totalItems }} item{{ $this->totalItems === 1 ? '' : 's' }})</span>
                                    <span class="text-gray-800">${{ number_format($this->grandTotal, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-gray-500">
                                    <span>Pickup Fee</span>
                                    <span class="text-gray-800">$0.00</span>
                                </div>
                            </div>

                            <div class="pt-3 border-t border-gray-100 flex items-center justify-between">
                                <span class="text-sm font-medium text-gray-700">Total Payment</span>
                                <span class="text-xl font-bold text-emerald-700">${{ number_format($this->grandTotal, 2) }}</span>
                            </div>
                        </div>

                        <div class="p-4 pt-0">
                            <button wire:click="placeOrder" wire:loading.attr="disabled" wire:target="placeOrder"
                                    class="w-full py-2.5 bg-emerald-700 text-white rounded-md hover:bg-emerald-800 transition text-sm font-semibold disabled:opacity-60">
                                <span wire:loading.remove wire:target="placeOrder">Place Order</span>
                                <span wire:loading wire:target="placeOrder">Placing order...</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>