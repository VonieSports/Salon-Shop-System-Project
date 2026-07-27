@if($previewFile && is_array($previewFile) && isset($previewFile['path']))
    <div class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/80" 
         x-data="{ show: true }" 
         x-show="show" 
         x-cloak
         @click.away="$wire.set('previewFile', null)"
         @keydown.escape.window="$wire.set('previewFile', null)">
        <div class="relative max-w-[90vw] max-h-[90vh]">
            <button @click="$wire.set('previewFile', null)" 
                    class="absolute -top-12 right-0 text-white hover:text-gray-300 transition p-2 z-10">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            
            @if(isset($previewFile['type']) && $previewFile['type'] === 'image')
                <div class="flex items-center justify-center w-full h-full">
                    <img src="{{ Storage::url($previewFile['path']) }}" 
                         alt="{{ $previewFile['name'] ?? 'Image' }}"
                         class="max-w-[90vw] max-h-[85vh] object-contain rounded-lg shadow-2xl"
                         x-data="{ loaded: false }"
                         x-on:load="loaded = true"
                         x-show="loaded"
                         x-transition:enter="transition-opacity duration-300"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100">
                    <div x-show="!loaded" 
                         class="flex items-center justify-center w-full h-[50vh]">
                        <svg class="animate-spin h-12 w-12 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-lg p-8 max-w-md">
                    <div class="text-center">
                        <svg class="w-20 h-20 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"/>
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-900">{{ $previewFile['name'] ?? 'Document' }}</h3>
                        <p class="text-sm text-gray-500 mt-1">Click the button below to view or download</p>
                        <div class="mt-4 flex gap-3 justify-center flex-wrap">
                            <a href="{{ Storage::url($previewFile['path']) }}" 
                               target="_blank"
                               class="px-4 py-2 bg-[#1E7A4A] text-white rounded-lg hover:bg-[#16633c] transition text-sm">
                                View Document
                            </a>
                            <a href="{{ Storage::url($previewFile['path']) }}" 
                               download
                               class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition text-sm">
                                Download
                            </a>
                            <button @click="$wire.set('previewFile', null)" 
                                    class="px-4 py-2 bg-gray-100 text-gray-600 rounded-lg hover:bg-gray-200 transition text-sm">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endif