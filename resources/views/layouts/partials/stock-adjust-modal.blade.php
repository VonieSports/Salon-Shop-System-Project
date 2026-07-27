@if ($showAdjustModal)
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="fixed inset-0 bg-black/50" wire:click="closeAdjustModal"></div>

            <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-900">Adjust Stock</h3>
                    <button wire:click="closeAdjustModal" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                @if ($this->adjustProduct)
                    <div class="px-6 py-4 space-y-4">
                        <div class="bg-gray-50 rounded-xl p-3">
                            <p class="text-sm font-semibold text-gray-900">{{ $this->adjustProduct->name }}</p>
                            <p class="text-xs text-gray-500 mt-0.5">Current stock: <span class="font-semibold text-gray-700">{{ $this->adjustProduct->stock }}</span></p>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1.5">Movement Type</label>
                            <select wire:model="adjustType" class="w-full px-4 py-2.5 bg-gray-100 border border-transparent rounded-xl focus:ring-2 focus:ring-[#1E7A4A]/30 focus:bg-white transition text-sm">
                                <option value="restock">Restock (+)</option>
                                <option value="return">Customer Return (+)</option>
                                <option value="adjustment">Manual Adjustment (+)</option>
                                <option value="sale">Manual Sale (-)</option>
                                <option value="damage">Damaged / Lost (-)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1.5">Quantity</label>
                            <input type="number" wire:model="adjustQuantity" min="1"
                                   class="w-full px-4 py-2.5 bg-gray-100 border border-transparent rounded-xl focus:ring-2 focus:ring-[#1E7A4A]/30 focus:bg-white transition text-sm" placeholder="0">
                            @error('adjustQuantity') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1.5">Reference / Note</label>
                            <input type="text" wire:model="adjustReference" placeholder="e.g. Supplier invoice #1023"
                                   class="w-full px-4 py-2.5 bg-gray-100 border border-transparent rounded-xl focus:ring-2 focus:ring-[#1E7A4A]/30 focus:bg-white transition text-sm">
                        </div>
                    </div>

                    <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex justify-end gap-3">
                        <button wire:click="closeAdjustModal" class="px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition">Cancel</button>
                        <button wire:click="adjustStock" wire:loading.attr="disabled" wire:target="adjustStock"
                                class="px-4 py-2.5 bg-[#1E7A4A] text-white rounded-xl hover:bg-[#16633c] transition text-sm font-medium">
                            <span wire:loading.remove wire:target="adjustStock">Save Adjustment</span>
                            <span wire:loading wire:target="adjustStock">Saving...</span>
                        </button>
                    </div>
                @else
                    <div class="p-10 text-center text-sm text-gray-500">Product not found.</div>
                @endif
            </div>
        </div>
    </div>
@endif