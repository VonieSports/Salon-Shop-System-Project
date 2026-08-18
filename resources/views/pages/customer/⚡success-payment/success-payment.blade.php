<div class="min-h-screen bg-gray-50 flex items-center justify-center p-4">
    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
        
        <!-- Top Brand Header -->
        <div class="bg-[#1E7A4A] px-6 py-5 text-center">
            <div class="inline-flex items-center gap-2 mb-1">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c-1.5 2-4 3-4 6a4 4 0 008 0c0-3-2.5-4-4-6z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 13v8M9 18h6"/>
                </svg>
                <span class="text-white font-bold text-lg tracking-tight">Style Station</span>
            </div>
            <p class="text-white/80 text-xs">Payment Successful</p>
        </div>

        <!-- Success Animation -->
        <div class="px-6 pt-8 pb-4 flex justify-center">
            <div class="w-20 h-20 rounded-full bg-emerald-50 border-4 border-emerald-100 flex items-center justify-center">
                <svg class="w-10 h-10 text-[#1E7A4A]" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
        </div>

        <!-- Content -->
        <div class="px-6 pb-8 text-center space-y-3">
            <h1 class="text-2xl font-bold text-gray-900">Payment Received!</h1>
            <p class="text-sm text-gray-500">
                Thank you for your purchase. Your order has been confirmed and will be processed shortly.
            </p>

            <!-- Order Details -->
            <div class="bg-gray-50 rounded-xl p-4 mt-4 text-left border border-gray-200">
                <div class="flex items-center justify-between text-sm mb-2">
                    <span class="text-gray-500">Order Number</span>
                    <span class="font-semibold text-gray-800">{{ $order->order_number }}</span>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-500">Total Paid</span>
                    <span class="font-bold text-[#1E7A4A]">₱{{ number_format($order->total, 2) }}</span>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="pt-4 flex flex-col sm:flex-row gap-3">
                <a href="{{ route('customer.track_order', $order->id) }}" 
                   class="flex-1 px-5 py-3 bg-[#1E7A4A] hover:bg-[#16633c] text-white rounded-xl text-sm font-semibold transition text-center">
                    Track My Order
                </a>
                <a href="{{ route('customer.dashboard') }}" 
                   class="flex-1 px-5 py-3 bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 rounded-xl text-sm font-semibold transition text-center">
                    Continue Shopping
                </a>
            </div>

        
        </div>

    </div>
</div>