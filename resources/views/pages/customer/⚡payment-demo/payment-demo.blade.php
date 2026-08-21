<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete your payment</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">

    <div class="min-h-screen flex items-center justify-center p-4">

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 w-full max-w-sm overflow-hidden">

            <div class="px-5 pt-5 pb-4 text-center border-b border-gray-100">
            
                <p class="text-2xl font-bold text-gray-900">₱{{ number_format($order->total, 2) }}</p>
                <p class="text-xs text-gray-400 mt-1">Order #{{ $order->order_number }}</p>
            </div>

            <form id="payment-form" method="POST" action="{{ route('customer.payment.demo.confirm', $pending->paymongo_link_id) }}">
                @csrf

                <div class="p-5 space-y-4">
                    <!-- Channel selector -->
                    <div class="grid grid-cols-3 gap-2">
                        <label class="cursor-pointer">
                            <input type="radio" name="channel" value="gcash" checked class="peer sr-only">
                            <div class="flex flex-col items-center gap-1.5 border-2 border-gray-200 rounded-xl py-2.5 transition
                                        peer-checked:border-[#0075FF] peer-checked:bg-[#0075FF]/5">
                                <img src="{{ asset('images/gcash.jpg') }}" alt="GCash" class="w-7 h-7 object-contain rounded-full">
                                <span class="text-[11px] font-medium text-gray-700">GCash</span>
                            </div>
                        </label>

                        <label class="cursor-pointer">
                            <input type="radio" name="channel" value="maya" class="peer sr-only">
                            <div class="flex flex-col items-center gap-1.5 border-2 border-gray-200 rounded-xl py-2.5 transition
                                        peer-checked:border-[#00D66E] peer-checked:bg-[#00D66E]/5">
                                <img src="{{ asset('images/maya.jpg') }}" alt="Maya" class="w-7 h-7 object-contain rounded-full">
                                <span class="text-[11px] font-medium text-gray-700">Maya</span>
                            </div>
                        </label>

                        <label class="cursor-pointer">
                            <input type="radio" name="channel" value="qrph" class="peer sr-only">
                            <div class="flex flex-col items-center gap-1.5 border-2 border-gray-200 rounded-xl py-2.5 transition
                                        peer-checked:border-gray-800 peer-checked:bg-gray-100">
                                <img src="{{ asset('images/paypal.jpg') }}" alt="QR Ph" class="w-7 h-7 object-contain rounded-full">
                                <span class="text-[11px] font-medium text-gray-700">Paypal</span>
                            </div>
                        </label>
                    </div>

                    <!-- QR -->
                    <div class="flex flex-col items-center gap-2">
                        <div class="w-40 h-40 rounded-xl border-2 border-gray-200 p-1.5 bg-white">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode($pending->checkout_url) }}"
                                alt="Payment QR code" class="w-full h-full object-contain">
                        </div>
                        <p class="text-[11px] text-gray-400 text-center">
                            Scan with your selected app, or tap below to simulate payment.
                        </p>
                    </div>

                    <!-- Confirm -->
                    <button type="submit" id="confirm-btn"
                        class="w-full py-3 rounded-full bg-[#1E7A4A] text-white text-sm font-semibold hover:bg-[#16633c] transition active:scale-[0.99] disabled:opacity-60">
                        <span id="confirm-btn-text">Simulate Successful Payment</span>
                    </button>
                </div>
            </form>

        </div>
    </div>

    <!-- Thank you popup (hidden by default) -->
    <div id="thankyou-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-black/50">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-xs p-6 text-center">
            <div class="w-14 h-14 rounded-full bg-emerald-50 flex items-center justify-center mx-auto mb-4">
                <svg class="w-7 h-7 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h2 class="text-lg font-bold text-gray-900 mb-1">Thank you!</h2>
            <p class="text-sm text-gray-500 mb-6">Your payment was received successfully.</p>
            <button id="thankyou-ok-btn"
                class="w-full py-3 rounded-full bg-[#1E7A4A] text-white text-sm font-semibold hover:bg-[#16633c] transition">
                OK
            </button>
        </div>
    </div>

    <script>
        (function () {
            const form = document.getElementById('payment-form');
            const confirmBtn = document.getElementById('confirm-btn');
            const confirmBtnText = document.getElementById('confirm-btn-text');
            const modal = document.getElementById('thankyou-modal');
            const okBtn = document.getElementById('thankyou-ok-btn');
            let redirectUrl = null;

            form.addEventListener('submit', function (e) {
                e.preventDefault();

                confirmBtn.disabled = true;
                confirmBtnText.textContent = 'Processing...';

                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: new FormData(form),
                })
                    .then(function (res) {
                        if (!res.ok) throw new Error('Payment confirmation failed.');
                        return res.json();
                    })
                    .then(function (data) {
                        redirectUrl = data.redirect_url;
                        modal.classList.remove('hidden');
                        modal.classList.add('flex');
                    })
                    .catch(function () {
                        confirmBtn.disabled = false;
                        confirmBtnText.textContent = 'Simulate Successful Payment';
                        alert('Something went wrong confirming your payment. Please try again.');
                    });
            });

            okBtn.addEventListener('click', function () {
                if (redirectUrl) {
                    window.location.href = redirectUrl;
                }
            });
        })();
    </script>

</body>
</html>