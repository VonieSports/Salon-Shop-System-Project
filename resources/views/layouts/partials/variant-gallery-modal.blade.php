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
     class="fixed inset-0 z-[60]"
     @click.away="showVariantGallery = false">
    
    <div class="flex items-center justify-center min-h-screen p-3 sm:p-4 md:p-6">
        <div class="fixed inset-0 bg-black/70" @click="showVariantGallery = false"></div>
        
        <div class="relative bg-white rounded-2xl shadow-2xl max-w-5xl w-full max-h-[90vh] overflow-hidden">
            <!-- Header -->
            <div class="sticky top-0 bg-white border-b border-gray-200 px-4 sm:px-6 py-3.5 sm:py-4 flex items-center justify-between shrink-0">
                <h2 class="text-base sm:text-lg font-semibold text-gray-900">
                    {{ $isProduct ? 'Variant Images' : 'Option Images' }}
                </h2>
                <button @click="showVariantGallery = false" class="p-1.5 rounded-lg hover:bg-gray-100 transition">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            <!-- Content -->
            <div class="overflow-y-auto p-4 sm:p-6" style="max-height: calc(90vh - 75px);">
                @if($variantImages->isEmpty())
                    <div class="flex flex-col items-center justify-center py-12 text-center">
                        <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M4 8h16M4 4h16a1 1 0 011 1v14a1 1 0 01-1 1H4a1 1 0 01-1-1V5a1 1 0 011-1z"/>
                        </svg>
                        <p class="mt-3 text-sm text-gray-500">No variant images available.</p>
                    </div>
                @else
                    <!-- Image Grid with Layered Text -->
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3 sm:gap-4">
                        @foreach($variants as $variant)
                            @if($variant->image)
                                <div class="relative aspect-square rounded-xl overflow-hidden border border-gray-200 group bg-gray-50">
                                    <!-- Image -->
                                    <img src="{{ Storage::url($variant->image) }}" 
                                         alt="{{ collect($variant->attributes)->map(fn($v) => $v)->implode(' • ') }}"
                                         class="w-full h-full object-cover">
                                    
                                    <!-- Dark Gradient Overlay - Bottom to Top -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                                    
                                    <!-- Content Overlay - Bottom Left -->
                                    <div class="absolute bottom-0 left-0 right-0 p-3">
                                        <!-- Variant Name -->
                                        <p class="text-sm font-semibold text-white truncate">
                                            {{ collect($variant->attributes)->map(fn($v) => $v)->implode(' • ') }}
                                        </p>
                                        
                                        <!-- SKU and Stock -->
                                        <div class="flex items-center gap-2 mt-0.5 flex-wrap">
                                            <span class="text-[10px] text-white/70 font-mono">SKU: {{ $variant->sku }}</span>
                                            <span class="w-px h-3 bg-white/30"></span>
                                            
                                            @if($isProduct)
                                                <span class="text-[10px] font-medium text-white/90">
                                                    Stock: <span class="font-bold text-white">{{ $variant->stock ?? 0 }}</span>
                                                </span>
                                                @if(isset($variant->price_adjustment) && $variant->price_adjustment != 0)
                                                    <span class="w-px h-3 bg-white/30"></span>
                                                    <span class="text-[10px] font-medium text-emerald-300">
                                                        +${{ number_format($variant->price_adjustment, 2) }}
                                                    </span>
                                                @endif
                                            @elseif($isService)
                                                @if(isset($variant->duration_adjustment) && $variant->duration_adjustment != 0)
                                                    <span class="text-[10px] font-medium text-white/90">
                                                        {{ $variant->duration_adjustment }} min
                                                    </span>
                                                @endif
                                                @if(isset($variant->price_adjustment) && $variant->price_adjustment != 0)
                                                    <span class="w-px h-3 bg-white/30"></span>
                                                    <span class="text-[10px] font-medium text-emerald-300">
                                                        +${{ number_format($variant->price_adjustment, 2) }}
                                                    </span>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <!-- Hover Effect - Brighten on hover -->
                                    <div class="absolute inset-0 bg-white/0 group-hover:bg-white/5 transition-all"></div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>