@if($showConfirmationModal)
    <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ show: true }" x-show="show" x-cloak>
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="fixed inset-0 bg-black/50" @click="show = false; $wire.cancelConfirmation()"></div>
            
            <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full p-6 transform transition-all">
                <div class="text-center">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $confirmationTitle ?? 'Remove Image?' }}</h3>
                    <p class="text-sm text-gray-500 mb-6">{{ $confirmationMessage ?? 'This action cannot be undone.' }}</p>

                    <div class="flex gap-3 justify-center">
                        <button type="button" 
                                wire:click="cancelConfirmation"
                                @click="show = false"
                                class="px-5 py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition text-sm font-medium">
                            Cancel
                        </button>
                        <button type="button" 
                                wire:click="confirmAction"
                                class="px-5 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm font-medium">
                            Yes, Remove
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif