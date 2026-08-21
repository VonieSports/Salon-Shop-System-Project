<div class="w-7xl mx-auto pb-[90px] sm:pb-[100px] lg:pb-[110px] mt-5">
    <div class="mx-auto px-4 sm:px-6 py-4 sm:py-6">

        @if ($this->cartItems->isEmpty())
            <div class="bg-white rounded-xl shadow-sm p-16 text-center border border-[#F4D9E2]">
                <div class="w-20 h-20 mx-auto mb-4 text-[#D6657A]/30">
                    <svg class="w-full h-full" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/>
                    </svg>
                </div>
                <p class="text-[#8B6B76] text-base font-medium">Your cart is empty</p>
                <a href="{{ route('customer.dashboard') }}" class="text-[#D6657A] text-sm font-semibold hover:underline mt-2 inline-block">Start Shopping</a>
            </div>
        @else
            <!-- GLOBAL TABLE HEADERS (Desktop only) -->
            <div class="hidden lg:grid grid-cols-[48px_1fr_140px_140px_140px_80px] gap-4 px-6 py-4 text-sm font-medium text-[#8B6B76] bg-white rounded-t-xl border-b border-[#F4D9E2] shadow-sm items-center">
                <div></div> 
                <div>Product</div>
                <div class="text-right">Unit Price</div>
                <div class="text-center">Quantity</div>
                <div class="text-right">Total Price</div>
                <div class="text-right">Action</div>
            </div>

            <!-- Cart Items List -->
            <div class="space-y-4 mt-4">
                @foreach ($this->groupedCartItems as $tenantId => $group)
                    <div class="bg-white rounded-xl shadow-sm border border-[#F4D9E2] overflow-hidden">
                        
                        <!-- Shop Header -->
                        <div class="grid grid-cols-[48px_1fr_140px_140px_140px_80px] gap-4 px-6 py-3 border-b border-[#F4D9E2] bg-[#FFF7F9] items-center">
                            <div class="w-full flex justify-center">
                                <input type="checkbox" 
                                       wire:model.live="groupSelection.{{ $tenantId }}"
                                       class="w-5 h-5 text-[#D6657A] rounded border-[#F4D9E2] focus:ring-[#D6657A]/30 cursor-pointer">
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-[#FCE9ED] flex items-center justify-center text-[10px] font-bold text-[#D6657A]">
                                    {{ strtoupper(substr($group['tenant']?->name ?? 'S', 0, 1)) }}
                                </div>
                                <span class="text-sm font-medium text-[#2D1F24]">{{ $group['tenant']?->name ?? 'Shop' }}</span>
                                <span class="text-[10px] bg-[#F4D9E2] text-[#7A3B4A] px-1.5 py-0.5 rounded-full font-medium">OFFICIAL</span>
                            </div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>

                        <div class="divide-y divide-[#F4D9E2]">
                            @foreach ($group['items'] as $index => $item)
                                <div wire:key="cart-{{ $item['cart_item_id'] }}" 
                                     class="grid grid-cols-1 lg:grid-cols-[48px_1fr_140px_140px_140px_80px] gap-4 px-6 py-4 bg-white hover:bg-[#FFF7F9]/50 transition items-start lg:items-center">
                                    
                                    <!-- Checkbox -->
                                    <div class="w-full flex justify-center pt-1 lg:pt-0">
                                        <input type="checkbox" 
                                               wire:model.live="selectedItems"
                                               value="{{ $item['cart_item_id'] }}"
                                               class="w-5 h-5 text-[#D6657A] rounded border-[#F4D9E2] focus:ring-[#D6657A]/30 cursor-pointer">
                                    </div>

                                    <!-- Product -->
                                    <div class="flex items-start gap-4 min-w-0">
                                        <div class="w-16 h-16 lg:w-20 lg:h-20 rounded-lg bg-[#FFF7F9] border border-[#F4D9E2] overflow-hidden shrink-0">
                                            @if ($item['image'])
                                                <img src="{{ Storage::url($item['image']) }}" class="w-full h-full object-cover">
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0 pt-1">
                                            <p class="text-sm font-medium text-[#2D1F24] line-clamp-2">{{ $item['name'] }}</p>
                                            @if (!empty($item['variant_attributes']))
                                                <p class="text-xs text-[#8B6B76] mt-0.5">
                                                    {{ collect($item['variant_attributes'])->map(fn ($v, $k) => "{$k}: {$v}")->implode(' / ') }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Unit Price -->
                                    <div class="hidden lg:block text-right text-sm font-medium text-[#D6657A]">
                                        ₱{{ number_format($item['unit_price'], 2) }}
                                    </div>

                                    <!-- Quantity -->
                                    <div class="flex lg:justify-center mt-2 lg:mt-0">
                                        <div class="flex items-center border border-[#F4D9E2] rounded-full overflow-hidden inline-flex bg-white">
                                            <button wire:click="updateQuantity('{{ $item['cart_item_id'] }}', {{ $item['quantity'] - 1 }})" 
                                                    class="w-8 h-8 flex items-center justify-center text-[#D6657A] hover:bg-[#FFF7F9] transition">−</button>
                                            <span class="w-10 text-center text-sm bg-[#FFF7F9] py-0.5 text-[#2D1F24]">{{ $item['quantity'] }}</span>
                                            <button wire:click="updateQuantity('{{ $item['cart_item_id'] }}', {{ $item['quantity'] + 1 }})" 
                                                    class="w-8 h-8 flex items-center justify-center text-[#D6657A] hover:bg-[#FFF7F9] transition">+</button>
                                        </div>
                                    </div>

                                    <!-- Total Price (Mobile) -->
                                    <div class="flex items-center justify-between lg:hidden mt-2 border-t border-[#F4D9E2] pt-2">
                                        <div>
                                            <span class="text-xs text-[#8B6B76]">Unit: ₱{{ number_format($item['unit_price'], 2) }}</span>
                                        </div>
                                        <div class="text-sm font-bold text-[#D6657A]">
                                            ₱{{ number_format($item['unit_price'] * $item['quantity'], 2) }}
                                        </div>
                                    </div>

                                    <!-- Total Price (Desktop) -->
                                    <div class="hidden lg:block text-right text-sm font-bold text-[#D6657A]">
                                        ₱{{ number_format($item['unit_price'] * $item['quantity'], 2) }}
                                    </div>

                                    <!-- Actions -->
                                    <div class="hidden lg:flex text-right items-center justify-end">
                                        <button wire:click="removeItem('{{ $item['cart_item_id'] }}')" 
                                                class="text-sm text-[#8B6B76] hover:text-[#C25467] transition">
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- CHECKOUT BAR (Strictly Fixed to Bottom) -->
    @if(!$this->cartItems->isEmpty())
    <div class="fixed bottom-0 left-0 right-0 z-50 max-w-7xl mx-auto bg-white border-t border-[#F4D9E2] shadow-[0_-4px_12px_rgba(214,101,122,0.08)] px-4 py-3 sm:py-4">
        <div class="flex items-center justify-between max-w-7xl mx-auto">
            
            <!-- Left: Select All -->
            <div class="flex items-center gap-3 cursor-pointer" wire:click="$toggle('selectAll')">
                <input type="checkbox" 
                       wire:model.live="selectAll"
                       class="w-5 h-5 text-[#D6657A] rounded border-[#F4D9E2] focus:ring-[#D6657A]/30 cursor-pointer pointer-events-none">
                <span class="text-sm font-medium text-[#2D1F24]">Select All ({{ $this->totalItems }})</span>
            </div>

            <!-- Right: Total & Checkout -->
            <div class="flex items-center gap-3 ml-auto">
                @if(!empty($this->selectedItems))
                    <div class="flex items-baseline gap-1 sm:gap-2">
                        <span class="text-xs sm:text-sm text-[#8B6B76]">Total:</span>
                        <span class="text-base sm:text-xl font-bold text-[#D6657A]">₱{{ number_format($this->grandTotal, 2) }}</span>
                    </div>
                    <button wire:click="proceedToCheckout" 
                            class="px-6 sm:px-8 py-2 sm:py-2.5 bg-[#D6657A] hover:bg-[#C25467] text-[#FFF7F9]  rounded-lg  text-sm sm:text-base font-bold transition shadow-md shadow-[#D6657A]/20 hover:shadow-[#D6657A]/40 whitespace-nowrap">
                        Checkout
                    </button>
                @else
                    <div class="flex items-baseline gap-1 sm:gap-2 opacity-50">
                        <span class="text-xs sm:text-sm text-[#8B6B76]">Total:</span>
                        <span class="text-base sm:text-xl font-bold text-[#D6657A]/30">₱0.00</span>
                    </div>
                    <button disabled class="px-6 sm:px-8 py-2 sm:py-2.5 bg-[#F4D9E2] text-[#8B6B76] rounded-lg  text-sm sm:text-base font-bold cursor-not-allowed whitespace-nowrap">
                        Checkout
                    </button>
                @endif
            </div>
        </div>
    </div>
    @endif
</div>