<div>
      <!-- Add Shift Modal -->
    @if($showAddShiftModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4" x-data>
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden" 
                 x-transition:enter="transition ease-out duration-200" 
                 x-transition:enter-start="opacity-0 scale-95" 
                 x-transition:enter-end="opacity-100 scale-100"
                 @click.away="wire:closeAddShiftModal">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="text-xl font-bold text-gray-900">Assign Shift</h3>
                    <p class="text-sm text-gray-500 mt-1">Set shift for <strong class="text-gray-800">{{ ucfirst($shiftDay) }}</strong></p>
                </div>

                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Start Time</label>
                        <input type="time" wire:model="shiftStart" 
                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#1E7A4A]/30 focus:border-[#1E7A4A] transition text-base">
                        @error('shiftStart') <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">End Time</label>
                        <input type="time" wire:model="shiftEnd" 
                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#1E7A4A]/30 focus:border-[#1E7A4A] transition text-base">
                        @error('shiftEnd') <span class="text-sm text-red-600 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50 flex justify-end gap-3">
                    <button wire:click="closeAddShiftModal" 
                            class="px-4 py-2 text-base font-medium text-gray-600 hover:text-gray-800 transition">
                        Cancel
                    </button>
                    <button wire:click="saveShift" 
                            wire:loading.attr="disabled"
                            class="px-6 py-2.5 bg-[#1E7A4A] text-white rounded-lg hover:bg-[#16633c] transition text-base font-medium shadow-sm disabled:opacity-60">
                        <span wire:loading.remove wire:target="saveShift">Save Shift</span>
                        <span wire:loading wire:target="saveShift">Saving...</span>
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>