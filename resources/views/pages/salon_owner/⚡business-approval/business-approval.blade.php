
<div>
    <div class="max-w-lg mx-auto py-10 px-4">
    @if (session()->has('info'))
        <div class="mb-4 bg-blue-50 text-blue-700 px-4 py-3 rounded-xl text-sm font-medium text-center">
            {{ session('info') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 text-center">
        <div class="mx-auto flex items-center justify-center w-16 h-16 rounded-full bg-amber-100 mb-5">
            <svg class="w-8 h-8 text-amber-600 animate-pulse" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>

        <h1 class="text-xl font-bold text-gray-900 mb-2">Your Business Is Under Review</h1>
        <p class="text-sm text-gray-500 leading-relaxed mb-1">
            Thanks for submitting <span class="font-semibold text-gray-700">{{ $tenant->name }}</span> for approval.
        </p>
        <p class="text-sm text-gray-500 leading-relaxed">
            Our team is reviewing your business details. You'll be able to access your dashboard as soon as it's approved.
        </p>

        @if ($tenant->submitted_at)
            <p class="text-xs text-gray-400 mt-4">Submitted on {{ $tenant->submitted_at->format('M d, Y \a\t g:i A') }}</p>
        @endif

        <div class="mt-8 flex justify-center">
            <button wire:click="checkStatus" wire:loading.attr="disabled"
                    class="inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-[#1E7A4A] text-white rounded-xl hover:bg-[#16633c] transition text-sm font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Check Status
            </button>
        </div>
    </div>
</div>
</div>