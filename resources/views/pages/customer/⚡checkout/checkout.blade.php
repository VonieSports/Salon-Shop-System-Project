<div class="min-h-screen bg-white">
    <div class="max-w-5xl mx-auto px-4 py-6">

        @if (session()->has('error'))
            <div class="mb-4 bg-red-50 text-red-700 px-4 py-3 rounded-lg text-sm font-medium">{{ session('error') }}</div>
        @endif

        <div class="flex items-center justify-between mb-8">
            <a href="{{ route('customer.dashboard') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-emerald-700 hover:text-emerald-800">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to shop
            </a>
            <div class="flex items-center gap-1.5 text-xs text-gray-400">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
                Secure Checkout
            </div>
        </div>

        @if ($this->groupedCart->isEmpty())
            <div class="text-center py-20">
                <p class="text-gray-500 text-sm">Your cart is empty.</p>
                <a href="{{ route('customer.dashboard') }}" class="text-emerald-700 font-medium text-sm mt-2 inline-block hover:underline">Browse products</a>
            </div>
        @else
            <h1 class="text-3xl font-bold text-gray-900 mb-8">Checkout</h1>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 items-start">

                <div class="lg:col-span-2 space-y-6">
                    @foreach ($this->groupedCart as $tenantId => $group)
                        <div>
                            <div class="flex items-center gap-2 mb-3">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                <p class="text-sm font-semibold text-gray-800">{{ $group['tenant']?->name ?? 'Shop' }}</p>
                            </div>

                            <div class="space-y-4">
                                @foreach ($group['items'] as $item)
                                    <div wire:key="cart-{{ $item['cart_item_id'] }}" class="flex items-center gap-4 border border-gray-200 rounded-xl p-3">
                                        <div class="w-16 h-16 rounded-lg bg-gray-50 border border-gray-100 overflow-hidden shrink-0">
                                            @if ($item['image'])
                                                <img src="{{ Storage::url($item['image']) }}" class="w-full h-full object-cover">
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate">{{ $item['name'] }}</p>
                                            @if (!empty($item['variant_attributes']))
                                                <p class="text-xs text-gray-500 mt-0.5">{{ collect($item['variant_attributes'])->map(fn ($v, $k) => "{$k}: {$v}")->implode(' / ') }}</p>
                                            @endif
                                            <p class="text-sm font-semibold text-gray-900 mt-1">₱{{ number_format($item['unit_price'], 2) }}</p>
                                        </div>
                                        <div class="flex items-center border border-gray-200 rounded-lg overflow-hidden shrink-0">
                                            <button wire:click="updateQuantity('{{ $item['cart_item_id'] }}', {{ $item['quantity'] - 1 }})" class="w-7 h-7 flex items-center justify-center text-gray-500 hover:bg-gray-50 text-sm">−</button>
                                            <span class="w-8 text-center text-sm">{{ $item['quantity'] }}</span>
                                            <button wire:click="updateQuantity('{{ $item['cart_item_id'] }}', {{ $item['quantity'] + 1 }})" class="w-7 h-7 flex items-center justify-center text-gray-500 hover:bg-gray-50 text-sm">+</button>
                                        </div>
                                        <button wire:click="removeItem('{{ $item['cart_item_id'] }}')" class="text-gray-300 hover:text-red-500 transition shrink-0">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </button>
                                    </div>
                                @endforeach
                            </div>

                            <input type="text" wire:model="notes.{{ $tenantId }}" placeholder="Note for the seller (optional)"
                                   class="mt-3 w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-1 focus:ring-emerald-400 focus:border-emerald-400">
                        </div>
                    @endforeach

                    <div class="border border-gray-200 rounded-xl p-4 flex items-start gap-3">
                        <svg class="w-5 h-5 text-emerald-700 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <div>
                            <p class="text-sm font-semibold text-gray-800">In-store pickup</p>
                            <p class="text-xs text-gray-500 mt-0.5">No shipping needed — pick up your order directly from the shop.</p>
                        </div>
                    </div>

                    <div class="border border-gray-200 rounded-xl p-4">
                        <p class="text-sm font-semibold text-gray-800 mb-3">Payment Method</p>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="flex items-center gap-2.5 border rounded-lg p-3 cursor-pointer transition {{ $paymentType === 'cash' ? 'border-emerald-600 bg-emerald-50' : 'border-gray-200' }}">
                                <input type="radio" wire:model.live="paymentType" value="cash" class="text-emerald-600 focus:ring-emerald-500">
                                <span class="text-sm text-gray-700">Cash on Pickup</span>
                            </label>
                            <label class="flex items-center gap-2.5 border rounded-lg p-3 cursor-pointer transition {{ $paymentType === 'online' ? 'border-emerald-600 bg-emerald-50' : 'border-gray-200' }}">
                                <input type="radio" wire:model.live="paymentType" value="online" class="text-emerald-600 focus:ring-emerald-500">
                                <span class="text-sm text-gray-700">Online (PayMongo)</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="lg:sticky lg:top-6">
                    <div class="border border-gray-200 rounded-xl p-5">
                        <p class="text-base font-bold text-gray-900 mb-4">Order Summary</p>

                        <div class="space-y-3 mb-4 max-h-56 overflow-y-auto pr-1">
                            @foreach ($this->groupedCart as $group)
                                @foreach ($group['items'] as $item)
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 rounded-md bg-gray-50 border border-gray-100 overflow-hidden shrink-0">
                                            @if ($item['image'])<img src="{{ Storage::url($item['image']) }}" class="w-full h-full object-cover">@endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-xs font-medium text-gray-800 truncate">{{ $item['name'] }}</p>
                                            <p class="text-[11px] text-gray-400">Qty {{ $item['quantity'] }}</p>
                                        </div>
                                        <p class="text-xs font-semibold text-gray-900">₱{{ number_format($item['unit_price'] * $item['quantity'], 2) }}</p>
                                    </div>
                                @endforeach
                            @endforeach
                        </div>

                        <div class="space-y-2 text-sm border-t border-gray-100 pt-4">
                            <div class="flex justify-between text-gray-500">
                                <span>Subtotal</span>
                                <span class="text-gray-800">₱{{ number_format($this->grandTotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-gray-500">
                                <span>Pickup Fee</span>
                                <span class="text-gray-800">₱0.00</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between border-t border-gray-200 pt-4 mt-4">
                            <span class="text-base font-bold text-gray-900">Total</span>
                            <span class="text-2xl font-bold text-emerald-700">₱{{ number_format($this->grandTotal, 2) }}</span>
                        </div>

                        <button wire:click="placeOrder" wire:loading.attr="disabled" wire:target="placeOrder"
                                class="w-full mt-5 py-3.5 bg-emerald-700 text-white rounded-lg hover:bg-emerald-800 transition text-sm font-bold flex items-center justify-center gap-2 disabled:opacity-60">
                            <span wire:loading.remove wire:target="placeOrder">Place Order →</span>
                            <span wire:loading wire:target="placeOrder">Processing...</span>
                        </button>
                    </div>

                    <div class="grid grid-cols-3 gap-2 mt-4">
                        <div class="text-center">
                            <svg class="w-5 h-5 text-emerald-700 mx-auto mb-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            <p class="text-[10px] text-gray-500">Secure Checkout</p>
                        </div>
                        <div class="text-center">
                            <svg class="w-5 h-5 text-emerald-700 mx-auto mb-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <p class="text-[10px] text-gray-500">In-Store Pickup</p>
                        </div>
                        <div class="text-center">
                            <svg class="w-5 h-5 text-emerald-700 mx-auto mb-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            <p class="text-[10px] text-gray-500">Easy Returns</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>