
<div>
<div x-show="showCategoryModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div x-show="showCategoryModal" x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black bg-opacity-50"
             @click="showCategoryModal = false"></div>

        <div x-show="showCategoryModal" x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="relative bg-white rounded-2xl shadow-xl max-w-md w-full">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Create Category</h3>
                    <button @click="showCategoryModal = false" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <div class="space-y-4">
                    <div>
                        <label for="new_category_name" class="block text-sm font-medium text-gray-700 mb-1.5">Category Name</label>
                        <input type="text" id="new_category_name" wire:model="newCategoryName"
                               wire:keydown.enter.prevent="createCategory"
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-[#1E7A4A] focus:border-transparent text-sm"
                               placeholder="Enter category name">
                        @error('newCategoryName') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button @click="showCategoryModal = false"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition">
                            Cancel
                        </button>
                        <button wire:click="createCategory" wire:loading.attr="disabled" wire:target="createCategory"
                                class="px-4 py-2 bg-[#1E7A4A] text-white rounded-xl hover:bg-[#16633c] transition text-sm font-medium">
                            <span wire:loading.remove wire:target="createCategory">Create Category</span>
                            <span wire:loading wire:target="createCategory">Creating...</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 
</div>