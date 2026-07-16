@php
    $isProduct = isset($product) && $product !== null;
    $isService = isset($service) && $service !== null;
@endphp

<!-- Variant Gallery Modal -->
<div x-show="showVariantGallery" 
     x-cloak
     x-transition:enter="transition-opacity duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity duration-300"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-[60] "
     @click.away="showVariantGallery = false">
    
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="fixed inset-0 bg-black/70" @click="showVariantGallery = false"></div>
        
        <div class="relative bg-white mb-10 rounded-2xl shadow-2xl max-w-4xl w-full max-h-[85vh] overflow-hidden">
            <!-- Header -->
            <div class="sticky top-0 bg-white border-b border-gray-200 px-5 py-5 flex items-center justify-between">
                <h2 class="text-base font-semibold text-gray-900">
                    {{ $isProduct ? 'Variant Images' : 'Option Images' }}
                </h2>
                <button @click="showVariantGallery = false" class="p-1.5 rounded-lg hover:bg-gray-100 transition">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <!-- Content -->
            <div class="p-5 overflow-y-auto" style="max-height: calc(85vh - 60px);">
                @if($variantImages->isEmpty())
                    <div class="flex flex-col items-center justify-center py-12 text-center">
                        <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M4 8h16M4 4h16a1 1 0 011 1v14a1 1 0 01-1 1H4a1 1 0 01-1-1V5a1 1 0 011-1z"/>
                        </svg>
                        <p class="mt-3 text-sm text-gray-500">No variant images available.</p>
                    </div>
                @else
                    <!-- Image Grid -->
                    <div class="grid grid-cols-3 sm:grid-cols-4 lg:grid-cols-5 gap-2.5">
                        @foreach($variantImages as $index => $img)
                            <div class="relative aspect-square rounded-lg overflow-hidden border border-gray-200 group">
                                <img src="{{ Storage::url($img) }}" 
                                     alt="Variant image {{ $index + 1 }}"
                                     class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition-all"></div>
                                <span class="absolute bottom-1 right-1.5 text-[10px] font-medium text-white bg-black/50 px-1.5 py-0.5 rounded">
                                    #{{ $index + 1 }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Variant details -->
                    @if($variants && $variants->count() > 0)
                        <div class="mt-5 pt-4 border-t border-gray-200">
                            <p class="text-sm font-semibold text-gray-600 uppercase tracking-wider mb-3">Variant Details</p>
                            <div class="grid grid-cols-1 gap-2.5">
                                @foreach($variants as $variant)
                                    <div class="bg-gray-50 rounded-lg p-3 border border-gray-200 hover:bg-gray-100 transition flex items-center gap-3">
                                        @if($variant->image)
                                            <img src="{{ Storage::url($variant->image) }}" 
                                                 class="w-10 h-10 rounded object-cover shrink-0 border border-gray-200">
                                        @else
                                            <div class="w-10 h-10 rounded bg-gray-200 shrink-0 flex items-center justify-center">
                                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M4 8h16M4 4h16a1 1 0 011 1v14a1 1 0 01-1 1H4a1 1 0 01-1-1V5a1 1 0 011-1z"/>
                                                </svg>
                                            </div>
                                        @endif
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-medium text-gray-900 truncate">
                                                {{ collect($variant->attributes)->map(fn($v) => $v)->implode(' • ') }}
                                            </p>
                                            <div class="flex flex-wrap items-center gap-2 mt-0.5">
                                                <span class="text-xs text-gray-600 font-mono">SKU: {{ $variant->sku }}</span>
                                                <span class="w-px h-3 bg-gray-300"></span>
                                                
                                                @if($isProduct)
                                                    <!-- PRODUCT: Show Stock -->
                                                    <span class="text-xs font-medium text-gray-700">Stock: <span class="font-bold">{{ $variant->stock ?? 0 }}</span></span>
                                                    @if(isset($variant->price_adjustment) && $variant->price_adjustment != 0)
                                                        <span class="w-px h-3 bg-gray-300"></span>
                                                        <span class="text-xs font-medium text-gray-700">Price: <span class="font-bold">+${{ number_format($variant->price_adjustment, 2) }}</span></span>
                                                    @endif
                                                @elseif($isService)
                                                    <!-- SERVICE: Show Duration -->
                                                    @if(isset($variant->duration_adjustment) && $variant->duration_adjustment != 0)
                                                        <span class="text-xs font-medium text-gray-700">Duration: <span class="font-bold">{{ $variant->duration_adjustment }} min</span></span>
                                                    @else
                                                        <span class="text-xs font-medium text-gray-400">Duration: Standard</span>
                                                    @endif
                                                    @if(isset($variant->price_adjustment) && $variant->price_adjustment != 0)
                                                        <span class="w-px h-3 bg-gray-300"></span>
                                                        <span class="text-xs font-medium text-gray-700">Price: <span class="font-bold">+${{ number_format($variant->price_adjustment, 2) }}</span></span>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>