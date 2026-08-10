
<div>
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8 max-w-sm w-full text-center">
        <div class="w-14 h-14 rounded-full bg-blue-50 flex items-center justify-center mx-auto mb-4">
            <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
            </svg>
        </div>
        <p class="text-xs text-amber-600 font-medium mb-2">DEMO MODE — no real charge</p>
        <h1 class="text-lg font-bold text-gray-900">Pay ₱{{ number_format($order->total, 2) }}</h1>
        <p class="text-sm text-gray-500 mt-1">Order #{{ $order->order_number }}</p>

        <form method="POST" action="{{ route('customer.payment.demo.confirm', $pending->paymongo_link_id) }}" class="mt-6">
            @csrf
            <button type="submit" class="w-full py-3 bg-emerald-700 text-white rounded-lg font-semibold hover:bg-emerald-800 transition">
                Simulate Successful Payment
            </button>
        </form>
    </div>
</div>