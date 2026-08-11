<div class="min-h-screen bg-white">
    <div class="max-w-2xl mx-auto px-4 py-6">

        @if (session()->has('error'))
            <div class="mb-4 bg-red-50 text-red-700 px-4 py-3 rounded-md text-sm font-medium">{{ session('error') }}</div>
        @endif

        <a href="{{ route('customer.item_detail', $post->id) }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-600 hover:text-gray-900 mb-6">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Back
        </a>

        <h1 class="text-xl font-semibold text-gray-900 mb-6">Confirm Booking</h1>

        <div class="border border-gray-200 rounded-md p-5 mb-4">
            <p class="text-xs font-medium text-gray-400 uppercase mb-1">Service</p>
            <p class="text-base font-semibold text-gray-900">{{ $post->name }}</p>
            <p class="text-sm text-gray-500 mt-0.5">{{ $post->tenant?->name }} · {{ \Carbon\Carbon::parse($date)->format('M d, Y') }}</p>
            <p class="text-lg font-bold text-[#1E7A4A] mt-2">₱{{ number_format($post->price ?? 0, 2) }}</p>
        </div>

        <div class="border border-gray-200 rounded-md p-5 mb-4">
            <p class="text-xs font-medium text-gray-400 uppercase mb-2">Staff</p>
            @if ($this->selectedEmployee)
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center shrink-0 overflow-hidden">
                        @if ($this->selectedEmployee->user?->avatar)
                            <img src="{{ Storage::url($this->selectedEmployee->user->avatar) }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-sm font-bold text-gray-600">{{ strtoupper(substr($this->selectedEmployee->user?->name ?? 'S', 0, 1)) }}</span>
                        @endif
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-800">{{ $this->selectedEmployee->user?->name }}</p>
                        @if ($this->availability)
                            <p class="text-xs {{ $this->availability['is_busy'] ? 'text-amber-600' : 'text-emerald-600' }}">
                                @if ($this->availability['is_busy'])
                                    Busy — you'll be #{{ $this->availability['next_queue_number'] }} in queue
                                @else
                                    Available now — queue position #{{ $this->availability['next_queue_number'] }}
                                @endif
                            </p>
                        @endif
                    </div>
                </div>
            @else
                <p class="text-sm text-red-600">No staff selected — go back and choose one.</p>
            @endif
        </div>

        <div class="border border-gray-200 rounded-md p-5 mb-6">
            <p class="text-sm font-medium text-gray-800 mb-3">Payment Method</p>
            <div class="grid grid-cols-2 gap-3">
                <label class="flex items-center gap-2.5 border rounded-md p-3 cursor-pointer transition {{ $paymentType === 'cash' ? 'border-[#1E7A4A] bg-[#1E7A4A]/5' : 'border-gray-200' }}">
                    <input type="radio" name="paymentType" wire:model.live="paymentType" value="cash" class="text-[#1E7A4A] focus:ring-[#1E7A4A]">
                    <span class="text-sm text-gray-700">Pay at Shop</span>
                </label>
                <label class="flex items-center gap-2.5 border rounded-md p-3 cursor-pointer transition {{ $paymentType === 'online' ? 'border-[#1E7A4A] bg-[#1E7A4A]/5' : 'border-gray-200' }}">
                    <input type="radio" name="paymentType" wire:model.live="paymentType" value="online" class="text-[#1E7A4A] focus:ring-[#1E7A4A]">
                    <span class="text-sm text-gray-700">Online (PayMongo)</span>
                </label>
            </div>
        </div>

        <button wire:click="confirmBooking" wire:loading.attr="disabled" wire:target="confirmBooking"
                class="w-full py-3 bg-[#1E7A4A] text-white rounded-md hover:bg-[#16633c] transition text-sm font-semibold disabled:opacity-60">
            <span wire:loading.remove wire:target="confirmBooking">Confirm Booking</span>
            <span wire:loading wire:target="confirmBooking">Booking...</span>
        </button>
    </div>
</div>