
<div>
    <div class="min-h-screen bg-gray-50 p-4 space-y-5">
    <div>
        <h1 class="text-xl font-bold text-gray-900">Customer Reviews</h1>
        <p class="text-sm text-gray-500 mt-0.5">Feedback left by your customers</p>
    </div>

    @if ($this->reviews->isEmpty())
        <div class="bg-white rounded-lg border border-gray-200 p-16 text-center text-gray-400 text-sm">No reviews yet.</div>
    @else
        <div class="space-y-3">
            @foreach ($this->reviews as $review)
                @php
                    $reviewer = $review->customer?->user ?? $review->customer;
                    $displayName = $this->maskName($reviewer?->name);
                @endphp
                <div class="bg-white rounded-lg border border-gray-200 p-4">
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-full bg-emerald-100 flex items-center justify-center shrink-0 overflow-hidden">
                            @if ($reviewer?->avatar)
                                <img src="{{ Storage::url($reviewer->avatar) }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-xs font-bold text-emerald-700">{{ \App\Support\PrivacyMasker::avatarInitial($reviewer?->name) }}</span>
                            @endif
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-medium text-gray-800">{{ $displayName }}</p>
                                <span class="text-yellow-500 text-xs">{{ str_repeat('★', (int) $review->rating) }}{{ str_repeat('☆', 5 - (int) $review->rating) }}</span>
                            </div>
                            <p class="text-xs text-gray-400 mt-0.5">{{ $review->product?->name ?? 'Item unavailable' }}</p>
                            <p class="text-sm text-gray-600 mt-2 leading-relaxed">{{ $review->comment }}</p>
                            <p class="text-[11px] text-gray-400 mt-2">{{ $review->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div>{{ $this->reviews->links() }}</div>
    @endif
</div>
</div>