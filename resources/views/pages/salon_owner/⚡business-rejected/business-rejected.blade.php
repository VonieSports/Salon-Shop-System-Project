
<div>
<div class="max-w-lg mx-auto py-10 px-4">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 text-center">
        <div class="mx-auto flex items-center justify-center w-16 h-16 rounded-full bg-red-100 mb-5">
            <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </div>

        <h1 class="text-xl font-bold text-gray-900 mb-2">Business Application Rejected</h1>
        <p class="text-sm text-gray-500 leading-relaxed">
            Your submission for <span class="font-semibold text-gray-700">{{ $tenant->name }}</span> was not approved.
        </p>

        @if ($tenant->rejection_reason)
            <div class="mt-4 bg-red-50 border border-red-100 rounded-xl px-4 py-3 text-left">
                <p class="text-xs font-semibold text-red-700 uppercase tracking-wide mb-1">Reason</p>
                <p class="text-sm text-red-700">{{ $tenant->rejection_reason }}</p>
            </div>
        @endif

        <div class="mt-8 flex justify-center">
            <button wire:click="resubmit"
                    class="inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-[#1E7A4A] text-white rounded-xl hover:bg-[#16633c] transition text-sm font-medium">
                Okay
            </button>
        </div>
    </div>
</div>
</div>