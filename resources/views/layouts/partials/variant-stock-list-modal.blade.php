@if ($showStockManagerModal)
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="fixed inset-0 bg-black/50" wire:click="closeStockManager"></div>

            <div class="relative bg-white rounded-2xl shadow-2xl max-w-lg w-full max-h-[85vh] overflow-hidden flex flex-col">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between shrink-0">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Variant Stock</h3>
                        @if ($this->stockManagerProduct)
                            <p class="text-xs text-gray-400 mt-0.5">{{ $this->stockManagerProduct->name }}</p>
                        @endif
                    </div>
                    <button wire:click="closeStockManager" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                @if ($this->stockManagerProduct)
                    <div class="overflow-y-auto p-4 space-y-2">
                        @forelse ($this->stockManagerProduct->variants as $variant)
                            <div wire:key="stockmgr-variant-{{ $variant->id }}" class="flex items-center gap-3 bg-gray-50 rounded-xl p-3 border border-gray-100">
                                @if ($variant->image)
                                    <img src="{{ Storage::url($variant->image) }}" class="w-10 h-10 rounded-lg object-cover shrink-0">
                                @else
                                    <div class="w-10 h-10 rounded-lg bg-gray-200 shrink-0"></div>
                                @endif

                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">
                                        @foreach ($variant->attributes ?? [] as $key => $value)
                                            <span class="text-gray-400 font-normal">{{ $key }}:</span> {{ $value }}@if(!$loop->last) &bull; @endif
                                        @endforeach
                                    </p>
                                    <p class="text-xs text-gray-400 font-mono">{{ $variant->sku ?? '—' }}</p>
                                </div>

                                <div class="text-right shrink-0">
                                    <p class="text-sm font-semibold text-gray-900">{{ $variant->stock ?? 0 }}</p>
                                    <p class="text-[10px] text-gray-400 uppercase tracking-wide">in stock</p>
                                </div>

                                <button wire:click="openAdjustModal({{ $this->stockManagerProduct->id }}, {{ $variant->id }})"
                                        class="p-2 text-[#1E7A4A] hover:bg-[#1E7A4A]/10 rounded-lg transition shrink-0" title="Add Stock">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                    </svg>
                                </button>
                            </div>
                        @empty
                            <p class="text-sm text-gray-400 text-center py-6">No variants found.</p>
                        @endforelse
                    </div>
                @endif

                <div class="px-6 py-3.5 border-t border-gray-100 shrink-0">
                    <button wire:click="closeStockManager" class="w-full px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
@endif