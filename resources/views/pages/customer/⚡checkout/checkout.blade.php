<div class="bg-[#F5F5F5]">
    <div class="max-w-7xl mx-auto px-3 sm:px-4 py-3 sm:py-6 pb-[90px] sm:pb-[100px] lg:pb-6">
        
        @if (session()->has('error'))
            <div class="mb-4 bg-[#FCE9ED] border border-[#D6657A]/30 text-[#7A3B4A] px-4 py-3 rounded-lg text-sm font-medium">{{ session('error') }}</div>
        @endif

        @if ($this->groupedCart->isEmpty())
            <div class="text-center py-20 bg-white rounded-xl shadow-sm border border-[#F4D9E2]">
                <p class="text-[#8B6B76] text-sm">Your cart is empty.</p>
                <a href="{{ route('customer.dashboard') }}" class="text-[#D6657A] font-medium text-sm mt-2 inline-block hover:underline">Browse products</a>
            </div>
        @else
            <!-- Header with Back Button -->
            <div class="flex items-center gap-3 mb-4 sm:mb-6">
                <a href="{{ route('customer.cart') }}" 
                   class="flex items-center gap-1.5 text-[#D6657A] hover:text-[#C25467] transition font-medium text-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                    </svg>
            
                </a>
                <h1 class="text-xl sm:text-2xl font-bold text-[#2D1F24]">Checkout</h1>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6 items-start">

                <!-- Left Column - Takes 2/3 on desktop -->
                <div class="lg:col-span-2 space-y-4">
                    @foreach ($this->groupedCart as $tenantId => $group)
                        <div class="bg-white rounded-lg shadow-sm border border-[#F4D9E2] overflow-hidden">
                            <!-- Shop Header -->
                            <div class="px-4 py-3 border-b border-[#F4D9E2] bg-[#FFF7F9] flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-full bg-[#FCE9ED] flex items-center justify-center text-[10px] font-bold text-[#D6657A]">
                                        {{ strtoupper(substr($group['tenant']?->name ?? 'S', 0, 1)) }}
                                    </div>
                                    <span class="text-sm font-medium text-[#2D1F24]">{{ $group['tenant']?->name ?? 'Shop' }}</span>
                                    <span class="text-[10px] bg-[#F4D9E2] text-[#7A3B4A] px-1.5 py-0.5 rounded-full font-medium">OFFICIAL</span>
                                </div>
                            </div>

                            <!-- Items -->
                            <div class="divide-y divide-[#F4D9E2]">
                                @foreach ($group['items'] as $item)
                                    <div wire:key="cart-{{ $item['cart_item_id'] }}" class="flex items-start gap-3 p-3 sm:p-4">
                                        <!-- Image -->
                                        <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-lg bg-[#FFF7F9] border border-[#F4D9E2] overflow-hidden shrink-0">
                                            @if ($item['image'])
                                                <img src="{{ Storage::url($item['image']) }}" class="w-full h-full object-cover">
                                            @endif
                                        </div>
                                        
                                        <!-- Info -->
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-[#2D1F24]">{{ $item['name'] }}</p>
                                            @if (!empty($item['variant_attributes']))
                                                <p class="text-xs text-[#8B6B76] mt-0.5">
                                                    {{ collect($item['variant_attributes'])->map(fn ($v, $k) => "{$k}: {$v}")->implode(' / ') }}
                                                </p>
                                            @endif
                                            <div class="flex items-center gap-3 mt-1">
                                                <span class="text-xs text-[#8B6B76]">Qty: {{ $item['quantity'] }}</span>
                                                <span class="text-xs font-bold text-[#D6657A]">₱{{ number_format($item['unit_price'] * $item['quantity'], 2) }}</span>
                                            </div>
                                        </div>

                                        <!-- Price -->
                                        <div class="text-sm font-bold text-[#D6657A] shrink-0">
                                            ₱{{ number_format($item['unit_price'] * $item['quantity'], 2) }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Note Input -->
                            <div class="px-4 py-3 border-t border-[#F4D9E2] bg-[#FFF7F9]">
                                <input type="text" wire:model="notes.{{ $tenantId }}" placeholder="Note for seller (optional)"
                                       class="w-full px-3 py-1.5 text-sm border border-[#F4D9E2] rounded-lg focus:ring-2 focus:ring-[#D6657A]/30 focus:border-[#D6657A] transition bg-white text-[#2D1F24] placeholder:text-[#8B6B76]/50">
                            </div>
                        </div>
                    @endforeach

                    <!-- Payment Method -->
                    <div class="bg-white rounded-lg shadow-sm border border-[#F4D9E2] overflow-hidden">
                        <div class="px-4 py-3 border-b border-[#F4D9E2] bg-[#FFF7F9]">
                            <h2 class="text-sm font-semibold text-[#2D1F24]">Payment Method</h2>
                        </div>
                        <div class="p-4">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <label class="flex items-center gap-2.5 border rounded-lg p-3 cursor-pointer transition {{ $paymentType === 'cash' ? 'border-[#D6657A] bg-[#FFF7F9] shadow-sm' : 'border-[#F4D9E2] hover:border-[#D6657A]/50' }}">
                                    <input type="radio" name="paymentType" wire:model.live="paymentType" value="cash" class="text-[#D6657A] focus:ring-[#D6657A]/30">
                                    <span class="text-sm text-[#2D1F24]">Cash on Pickup</span>
                                </label>
                                <label class="flex items-center gap-2.5 border rounded-lg p-3 cursor-pointer transition {{ $paymentType === 'online' ? 'border-[#D6657A] bg-[#FFF7F9] shadow-sm' : 'border-[#F4D9E2] hover:border-[#D6657A]/50' }}">
                                    <input type="radio" name="paymentType" wire:model.live="paymentType" value="online" class="text-[#D6657A] focus:ring-[#D6657A]/30">
                                    <span class="text-sm text-[#2D1F24]">Online Payment</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Order Summary (Desktop) -->
                <div class="hidden lg:block lg:sticky lg:top-6">
                    <div class="bg-white rounded-lg shadow-sm border border-[#F4D9E2] overflow-hidden">
                        <div class="px-5 py-4 border-b border-[#F4D9E2] bg-[#FFF7F9]">
                            <h2 class="text-sm font-bold text-[#2D1F24]">Order Summary</h2>
                        </div>
                        <div class="p-5">
                            <div class="space-y-3 mb-4 max-h-56 overflow-y-auto pr-1">
                                @foreach ($this->groupedCart as $group)
                                    @foreach ($group['items'] as $item)
                                        <div class="flex items-center gap-3">
                                            <div class="w-12 h-12 rounded-md bg-[#FFF7F9] border border-[#F4D9E2] overflow-hidden shrink-0">
                                                @if ($item['image'])<img src="{{ Storage::url($item['image']) }}" class="w-full h-full object-cover">@endif
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-xs font-medium text-[#2D1F24] truncate">{{ $item['name'] }}</p>
                                                <p class="text-[10px] text-[#8B6B76]">Qty {{ $item['quantity'] }}</p>
                                            </div>
                                            <p class="text-xs font-semibold text-[#D6657A]">₱{{ number_format($item['unit_price'] * $item['quantity'], 2) }}</p>
                                        </div>
                                    @endforeach
                                @endforeach
                            </div>

                            <div class="space-y-2 text-sm border-t border-[#F4D9E2] pt-4">
                                <div class="flex justify-between text-[#8B6B76]">
                                    <span>Subtotal ({{ $this->totalItems }} items)</span>
                                    <span class="text-[#2D1F24]">₱{{ number_format($this->grandTotal, 2) }}</span>
                                </div>
                        
                            </div>

                            <div class="flex items-center justify-between border-t border-[#F4D9E2] pt-4 mt-4">
                                <span class="text-sm font-bold text-[#2D1F24]">Total Payment</span>
                                <span class="text-xl font-bold text-[#D6657A]">₱{{ number_format($this->grandTotal, 2) }}</span>
                            </div>

                            <button wire:click="placeOrder" wire:loading.attr="disabled" wire:target="placeOrder"
                                    class="w-full mt-5 py-3 bg-[#D6657A] hover:bg-[#C25467] text-[#FFF7F9] rounded-lg transition text-sm font-bold flex items-center justify-center gap-2 disabled:opacity-60 shadow-md shadow-[#D6657A]/20 hover:shadow-[#D6657A]/40">
                                <span wire:loading.remove wire:target="placeOrder">Place Order →</span>
                                <span wire:loading wire:target="placeOrder">Processing...</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- STICKY BOTTOM BAR - Mobile Only -->
    @if(!$this->groupedCart->isEmpty())
    <div class="lg:hidden fixed bottom-0 left-0 right-0 z-50 bg-white border-t border-[#F4D9E2] shadow-[0_-4px_12px_rgba(214,101,122,0.08)] px-4 py-2.5">
        <div class="flex items-center justify-between gap-3">
            <div class="flex-1 min-w-0">
                <div class="flex items-baseline gap-1.5">
                    <span class="text-xs text-[#8B6B76]">Total:</span>
                    <span class="text-base font-bold text-[#D6657A]">₱{{ number_format($this->grandTotal, 2) }}</span>
                </div>
                <p class="text-[10px] text-[#8B6B76] truncate">{{ $this->totalItems }} item(s)</p>
            </div>

            <button wire:click="placeOrder" wire:loading.attr="disabled" wire:target="placeOrder"
                    class="flex-shrink-0 px-5 py-2 bg-[#D6657A] hover:bg-[#C25467] text-[#FFF7F9] rounded-lg text-sm font-bold transition shadow-md shadow-[#D6657A]/20 active:scale-95 disabled:opacity-60">
                <span wire:loading.remove wire:target="placeOrder">Place Order</span>
                <span wire:loading wire:target="placeOrder">Processing...</span>
            </button>
        </div>
    </div>
    @endif
</div>