<div class="min-h-screen bg-[#F5F5F5]">
    <div class="max-w-7xl mx-auto px-3 sm:px-4 py-4 sm:py-6 pb-[90px] sm:pb-[100px] lg:pb-6">

        @if (session()->has('error'))
            <div class="mb-4 bg-[#FCE9ED] border border-[#D6657A]/30 text-[#7A3B4A] px-4 py-3 rounded-lg text-sm font-medium">{{ session('error') }}</div>
        @endif

        <!-- Back Button -->
        <a href="{{ route('customer.service_detail', $post->id) }}" 
           class="inline-flex items-center gap-2 text-sm font-medium text-[#D6657A] hover:text-[#C25467] transition mb-4 sm:mb-6">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back
        </a>

        <!-- Header -->
        <div class="flex items-center gap-3 mb-5 sm:mb-6">
            <div class="w-10 h-10 rounded-xl bg-[#FCE9ED] flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-[#D6657A]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-lg sm:text-xl font-bold text-[#2D1F24]">Confirm Booking</h1>
                <p class="text-xs text-[#8B6B76]">Review your appointment details</p>
            </div>
        </div>

        <!-- Service Details Card -->
        <div class="bg-white rounded-xl shadow-sm border border-[#F4D9E2] overflow-hidden mb-4">
            <div class="px-4 py-3 border-b border-[#F4D9E2] bg-[#FFF7F9] flex items-center justify-between">
                <span class="text-xs font-semibold text-[#2D1F24] uppercase tracking-wider">Service Details</span>
                <span class="text-[10px] bg-[#FCE9ED] text-[#D6657A] px-2 py-0.5 rounded-full font-medium">CONFIRM</span>
            </div>
            <div class="p-4 space-y-3">
                <div>
                    <p class="text-xs text-[#8B6B76] font-medium mb-0.5">Service</p>
                    <p class="text-sm sm:text-base font-semibold text-[#2D1F24]">{{ $post->name }}</p>
                </div>
                <div class="flex flex-wrap items-center gap-3 text-xs text-[#8B6B76]">
                    <span class="flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        {{ $post->tenant?->name ?? 'Shop' }}
                    </span>
                    <span class="text-[#D6657A]/30">|</span>
                    <span class="flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ \Carbon\Carbon::parse($date)->format('M d, Y') }}
                    </span>
                </div>
                <div class="pt-2 border-t border-[#F4D9E2]">
                    <p class="text-2xl sm:text-3xl font-bold text-[#D6657A]">₱{{ number_format($post->price ?? 0, 2) }}</p>
                </div>
            </div>
        </div>

        <!-- Staff Card -->
        <div class="bg-white rounded-xl shadow-sm border border-[#F4D9E2] overflow-hidden mb-4">
            <div class="px-4 py-3 border-b border-[#F4D9E2] bg-[#FFF7F9]">
                <span class="text-xs font-semibold text-[#2D1F24] uppercase tracking-wider">Staff Assigned</span>
            </div>
            <div class="p-4">
                @if ($this->selectedEmployee)
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-[#F4D9E2] flex items-center justify-center shrink-0 overflow-hidden border-2 border-[#F4D9E2]">
                            @if ($this->selectedEmployee->user?->avatar)
                                <img src="{{ Storage::url($this->selectedEmployee->user->avatar) }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-base font-bold text-[#D6657A]">{{ strtoupper(substr($this->selectedEmployee->user?->name ?? 'S', 0, 1)) }}</span>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-[#2D1F24]">{{ $this->selectedEmployee->user?->name }}</p>
                            @if ($this->availability)
                                <div class="flex items-center gap-1.5 mt-0.5">
                                    <span class="inline-block w-1.5 h-1.5 rounded-full {{ $this->availability['is_busy'] ? 'bg-amber-500' : 'bg-[#D6657A]' }}"></span>
                                    <p class="text-xs {{ $this->availability['is_busy'] ? 'text-amber-600' : 'text-[#D6657A]' }}">
                                        @if ($this->availability['is_busy'])
                                            Busy — you'll be #{{ $this->availability['next_queue_number'] }} in queue
                                        @else
                                            Available — queue position #{{ $this->availability['next_queue_number'] }}
                                        @endif
                                    </p>
                                </div>
                            @endif
                        </div>
                        <div class="shrink-0 bg-[#FCE9ED] px-2 py-0.5 rounded-full">
                            <span class="text-[10px] font-medium text-[#D6657A]">✓</span>
                        </div>
                    </div>
                @else
                    <div class="flex items-center gap-3 text-[#C25467]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <p class="text-sm">No staff selected — go back and choose one.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Payment Method Card -->
        <div class="bg-white rounded-xl shadow-sm border border-[#F4D9E2] overflow-hidden mb-6">
            <div class="px-4 py-3 border-b border-[#F4D9E2] bg-[#FFF7F9]">
                <span class="text-xs font-semibold text-[#2D1F24] uppercase tracking-wider">Payment Method</span>
            </div>
            <div class="p-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <label class="flex items-center gap-2.5 border rounded-lg p-3 cursor-pointer transition {{ $paymentType === 'cash' ? 'border-[#D6657A] bg-[#FFF7F9] shadow-sm' : 'border-[#F4D9E2] hover:border-[#D6657A]/50' }}">
                        <input type="radio" name="paymentType" wire:model.live="paymentType" value="cash" class="text-[#D6657A] focus:ring-[#D6657A]/30">
                        <div class="flex flex-col">
                            <span class="text-sm font-medium text-[#2D1F24]">Pay at Shop</span>
                            <span class="text-[10px] text-[#8B6B76]">Cash on pickup</span>
                        </div>
                    </label>
                    <label class="flex items-center gap-2.5 border rounded-lg p-3 cursor-pointer transition {{ $paymentType === 'online' ? 'border-[#D6657A] bg-[#FFF7F9] shadow-sm' : 'border-[#F4D9E2] hover:border-[#D6657A]/50' }}">
                        <input type="radio" name="paymentType" wire:model.live="paymentType" value="online" class="text-[#D6657A] focus:ring-[#D6657A]/30">
                        <div class="flex flex-col">
                            <span class="text-sm font-medium text-[#2D1F24]">Online Payment</span>
                            <span class="text-[10px] text-[#8B6B76]">Pay with PayMongo</span>
                        </div>
                    </label>
                </div>
            </div>
        </div>

        <!-- Order Summary (Mobile Sticky) -->
        <div class="lg:hidden fixed bottom-0 left-0 right-0 z-50 bg-white border-t border-[#F4D9E2] shadow-[0_-4px_12px_rgba(214,101,122,0.08)] px-4 py-2.5">
            <div class="flex items-center justify-between gap-3">
                <div class="flex-1 min-w-0">
                    <div class="flex items-baseline gap-1.5">
                        <span class="text-xs text-[#8B6B76]">Total:</span>
                        <span class="text-base font-bold text-[#D6657A]">₱{{ number_format($post->price ?? 0, 2) }}</span>
                    </div>
                    <p class="text-[10px] text-[#8B6B76] truncate">{{ $post->name }}</p>
                </div>

                <button wire:click="confirmBooking" wire:loading.attr="disabled" wire:target="confirmBooking"
                        class="flex-shrink-0 px-5 py-2 bg-[#D6657A] hover:bg-[#C25467] text-[#FFF7F9] rounded-lg text-sm font-bold transition shadow-md shadow-[#D6657A]/20 active:scale-95 disabled:opacity-60">
                    <span wire:loading.remove wire:target="confirmBooking">Confirm</span>
                    <span wire:loading wire:target="confirmBooking">Booking...</span>
                </button>
            </div>
        </div>

        <!-- Desktop Confirm Button -->
        <div class="hidden lg:block">
            <button wire:click="confirmBooking" wire:loading.attr="disabled" wire:target="confirmBooking"
                    class="w-full py-3 bg-[#D6657A] hover:bg-[#C25467] text-[#FFF7F9] rounded-xl transition text-sm font-bold flex items-center justify-center gap-2 disabled:opacity-60 shadow-md shadow-[#D6657A]/20 hover:shadow-[#D6657A]/40">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
                <span wire:loading.remove wire:target="confirmBooking">Confirm Booking</span>
                <span wire:loading wire:target="confirmBooking">Processing...</span>
            </button>
        </div>

        <!-- Trust Badges -->
        <div class="mt-4 grid grid-cols-3 gap-2">
            <div class="text-center bg-white rounded-lg p-2 border border-[#F4D9E2]">
                <svg class="w-5 h-5 text-[#D6657A] mx-auto mb-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
                <p class="text-[10px] text-[#8B6B76]">Secure Booking</p>
            </div>
            <div class="text-center bg-white rounded-lg p-2 border border-[#F4D9E2]">
                <svg class="w-5 h-5 text-[#D6657A] mx-auto mb-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <p class="text-[10px] text-[#8B6B76]">In-Store Service</p>
            </div>
            <div class="text-center bg-white rounded-lg p-2 border border-[#F4D9E2]">
                <svg class="w-5 h-5 text-[#D6657A] mx-auto mb-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                <p class="text-[10px] text-[#8B6B76]">Expert Staff</p>
            </div>
        </div>
    </div>
</div>