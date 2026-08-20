<div>
    <div class="min-h-screen py-8">
        <div class="w-6xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-gray-900">Order Tracking</h1>
                <p class="text-sm text-gray-500 mt-1">Track the status of your order at any time.</p>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mb-6 bg-white rounded-xl border border-gray-200 p-4 sm:p-6 shadow-sm">
                <div>
                    <p class="text-xs text-gray-400 mb-1">Order Number</p>
                    <p class="text-sm font-semibold text-gray-900">#{{ $order->order_number }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-1">Order Placed</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $order->created_at->format('M d, Y') }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-1">Status</p>
                    <p class="text-sm font-semibold text-emerald-600 capitalize">{{ $order->status->label() }}</p>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-900">Order Tracking</h2>

            </div>

            <!-- Tracking Stepper -->
            @if ($order->status === \App\Enums\OrderStatus::CANCELED)
                <div class="bg-white rounded-xl border border-red-200 p-6 flex items-center gap-3 shadow-sm mb-6">
                    <div class="w-10 h-10 rounded-full bg-red-50 flex items-center justify-center shrink-0">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </div>
                    <p class="text-sm text-red-700 font-medium">This order was canceled.</p>
                </div>
            @else
                <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm mb-6">
                    @php $currentIndex = $this->currentStepIndex(); @endphp
                    <div class="flex items-center">
                        @foreach (\App\Enums\OrderStatus::getFlow() as $stepIndex => $step)
                            @php $done = $stepIndex <= $currentIndex; @endphp
                            <div class="flex-1 flex flex-col items-center relative">
                                @if ($stepIndex > 0)
                                    <div class="absolute top-3 right-1/2 w-full h-0.5 {{ $stepIndex <= $currentIndex ? 'bg-indigo-500' : 'bg-gray-200' }}"></div>
                                @endif
                                <div class="relative z-10 w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold {{ $done ? 'bg-indigo-500 text-white' : 'bg-gray-200 text-gray-400' }}">
                                    @if ($done && $stepIndex < $currentIndex)
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                    @else
                                        {{ $stepIndex + 1 }}
                                    @endif
                                </div>
                                <p class="text-xs font-medium mt-2 text-center {{ $done ? 'text-gray-900' : 'text-gray-400' }}">{{ $step->label() }}</p>
                            
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Items from the order -->
            <div class="flex items-center justify-between mb-2">
                <h2 class="text-lg font-semibold text-gray-900">Items from the order</h2>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden mb-6">
                <!-- Table Headers -->
                <div class="hidden sm:flex px-6 py-3 bg-gray-50 border-b border-gray-200 items-center text-xs font-medium text-gray-500">
                    <div class="w-1/2">Product</div>
                    <div class="w-1/4 text-center">Quantity</div>
                    <div class="w-1/4 text-right">Price</div>
                </div>

                <!-- Items List -->
                <div class="divide-y divide-gray-100">
                    @foreach ($order->items as $item)
                        @php $itemImage = $item->product?->image ?? $item->service?->image; @endphp
                        <div class="flex flex-col sm:flex-row sm:items-center px-6 py-4 gap-3 sm:gap-0 bg-white hover:bg-gray-50/50 transition">
                            
                            <!-- Product Info -->
                            <div class="flex items-center gap-4 w-full sm:w-1/2 min-w-0">
                                <div class="w-14 h-14 rounded-md bg-gray-100 overflow-hidden shrink-0 border border-gray-100">
                                    @if ($itemImage)
                                        <img src="{{ Storage::url($itemImage) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $item->name }}</p>
                                    @if ($item->variant_details)
                                        @php $attrs = json_decode($item->variant_details, true); @endphp
                                        @if ($attrs)
                                            <p class="text-xs text-gray-500 mt-0.5">{{ collect($attrs)->map(fn ($v, $k) => "{$k}: {$v}")->implode(', ') }}</p>
                                        @endif
                                    @endif
                                    <!-- Product ID for Design Match -->
                                    <p class="text-[10px] text-gray-400 mt-0.5">Product ID: {{ $item->product_id ?? 'N/A' }}</p>
                                </div>
                            </div>

                            <!-- Quantity (Static Text - No +/- Buttons) -->
                            <div class="w-full sm:w-1/4 flex justify-between sm:justify-center items-center gap-3 px-2">
                                <span class="text-sm text-gray-600">Qty:</span>
                                <span class="text-sm font-semibold text-gray-900">{{ $item->quantity }}</span>
                            </div>

                            <!-- Price (Static Text - No X Delete) -->
                            <div class="w-full sm:w-1/4 flex justify-between sm:justify-end items-center">
                                <span class="text-sm font-semibold text-gray-900">₱{{ number_format($item->subtotal, 2) }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Totals Grid -->
            <div class=" sm:grid-cols-2 gap-4 mb-6">
                <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm space-y-2">
                    
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Subtotal</span>
                        <span class="text-gray-900 font-medium">₱{{ number_format($order->subtotal, 2) }}</span>
                    </div>
                      <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Discount</span>
                        <span class="text-gray-900 font-medium">₱{{ number_format($order->discount ?? 0, 2) }}</span>
                    </div>
                      <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Tax</span>
                        <span class="text-gray-900 font-medium">₱{{ number_format($order->tax ?? 0, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-base font-medium border-t border-gray-100 pt-2 mt-1">
                        <span class="text-gray-700">Total Payment</span>
                        <span class="text-emerald-600">₱{{ number_format($order->total, 2) }}</span>
                    </div>
   <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-3 pt-2 mt-1">
            
                        @if ($this->canCancel())
                    <button wire:click="cancelOrder" wire:confirm="Cancel this order?"
                            class="flex-1 px-5 py-2.5 border border-red-200 text-red-600 rounded-md text-sm font-medium hover:bg-red-50 transition">
                        Cancel Order
                    </button>
                @elseif ($order->payment_type === 'online' && $order->payment_status === \App\Enums\PaymentStatus::PAID && $order->status->canCancel())
                    <p class="flex-1 text-xs text-gray-400 text-center self-center">Paid online — this order can no longer be canceled.</p>
                @endif
                <a href="{{ route('customer.order_history') }}" class="flex-1 text-center px-5 py-2.5 bg-[#1E7A4A] text-white rounded-md text-sm font-medium hover:bg-[#16633c] transition">
                    View All Orders
                </a>
                 </div>
                </div>
            </div>

         
           
        </div>
    </div>
</div>