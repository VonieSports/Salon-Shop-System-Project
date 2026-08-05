@if($selectedPostId)
    <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ 
        activeImage: 0, 
        showVariantGallery: false 
    }">
        <div class="flex items-center justify-center min-h-screen p-2 sm:p-3 md:p-4">
            <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" wire:click="closeItem"></div>
            <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-4xl max-h-[92vh] overflow-hidden mx-auto">
                @if($selectedPost)
                    <div class="flex items-center justify-between px-4 sm:px-6 py-3 border-b border-gray-100 bg-white shrink-0">
                        <button wire:click="closeItem" class="p-2 rounded-full hover:bg-gray-100 transition">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                        <div class="flex items-center gap-2 sm:gap-3">
                            <div class="flex items-center gap-2">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" wire:click="toggleStatus({{ $selectedPost->id }})" 
                                           @checked($selectedPost->status === 'published') class="sr-only peer">
                                    <span class="w-9 h-5 bg-gray-300 rounded-full peer-checked:bg-emerald-500 transition-colors block"></span>
                                    <span class="absolute left-0.5 top-0.5 w-4 h-4 bg-white rounded-full shadow transition-transform peer-checked:translate-x-4"></span>
                                </label>
                                <span class="text-sm font-medium text-gray-700 min-w-[55px]">
                                    {{ $selectedPost->status === 'published' ? 'Published' : 'Draft' }}
                                </span>
                            </div>
                            <a href="{{ route('owner.update_product', $selectedPost->id) }}"
                               class="px-4 py-1.5 bg-[#1E7A4A] text-white rounded-full hover:bg-[#16633c] transition text-sm font-medium">
                                Update
                            </a>
                            <button wire:click="deleteItem({{ $selectedPost->id }})"
                                    wire:confirm="Archive this product?"
                                    class="p-2 rounded-full hover:bg-red-50 transition text-red-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="overflow-y-auto p-4 sm:p-6" style="max-height: calc(92vh - 110px);">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 sm:gap-8">
                            <div class="space-y-3">
                                <div class="aspect-square bg-gray-50 rounded-xl overflow-hidden relative border border-gray-200">
                                    @if($selectedGallery && count($selectedGallery) > 0)
                                        @foreach ($selectedGallery as $i => $img)
                                            <img src="{{ Storage::url($img) }}"
                                                 alt="{{ $selectedPost->name }}"
                                                 x-show="activeImage === {{ $i }}"
                                                 class="w-full h-full object-contain p-4">
                                        @endforeach
                                    @else
                                        <div class="w-full h-full flex flex-col items-center justify-center text-gray-300">
                                            <svg class="w-16 h-16" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M4 8h16M4 4h16a1 1 0 011 1v14a1 1 0 01-1 1H4a1 1 0 01-1-1V5a1 1 0 011-1z"/>
                                            </svg>
                                            <span class="text-sm text-gray-400 mt-2">No image</span>
                                        </div>
                                    @endif
                                </div>

                                @php
                                    $mainImages = collect([$selectedProduct?->image, $selectedPost->image])
                                        ->filter()
                                        ->unique()
                                        ->values();
                                    
                                    $variantImages = $selectedVariants ? $selectedVariants->filter(fn($v) => $v->image)->values() : collect();
                                    $totalVariantImages = $variantImages->count();
                                    $variantThumbnails = $variantImages->take(4);
                                    $remainingCount = max(0, $totalVariantImages - 4);
                                @endphp

                                @if($mainImages->count() > 0 || $totalVariantImages > 0)
                                    <div class="grid grid-cols-5 gap-2">
                                        @foreach ($mainImages as $i => $img)
                                            <button type="button" @click="activeImage = {{ $i }}"
                                                    :class="activeImage === {{ $i }} ? 'ring-2 ring-[#1E7A4A]' : 'ring-1 ring-gray-200'"
                                                    class="aspect-square rounded-lg overflow-hidden transition bg-gray-50">
                                                <img src="{{ Storage::url($img) }}" class="w-full h-full object-cover">
                                            </button>
                                        @endforeach

                                        @foreach ($variantThumbnails as $index => $variant)
                                            @php
                                                $variantIndex = $mainImages->count() + $index;
                                                $isLast = ($index === 3) && $remainingCount > 0;
                                                $variantImageUrl = Storage::url($variant->image);
                                            @endphp
                                            <button type="button" 
                                                    @if($isLast)
                                                        @click="showVariantGallery = true"
                                                    @else
                                                        @click="activeImage = {{ $variantIndex }}"
                                                    @endif
                                                    :class="!$isLast && activeImage === {{ $variantIndex }} ? 'ring-2 ring-[#1E7A4A]' : 'ring-1 ring-gray-200'"
                                                    class="aspect-square rounded-lg overflow-hidden transition bg-gray-50 relative group">
                                                <img src="{{ $variantImageUrl }}" class="w-full h-full object-cover">
                                                @if($isLast)
                                                    <div class="absolute inset-0 bg-black/60 flex items-center justify-center text-white font-semibold text-sm">
                                                        +{{ $remainingCount }}
                                                    </div>
                                                @endif
                                            </button>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900 leading-tight">{{ $selectedPost->name }}</h1>
                                    <div class="flex items-center gap-2 mt-1 flex-wrap">
                                        <span class="text-sm text-gray-500">{{ $selectedPost->productCategory?->name ?? 'Uncategorized' }}</span>
                                    </div>
                                </div>

                                <div class="flex items-baseline gap-3">
                                    <span class="text-2xl font-bold text-[#1E7A4A]">${{ number_format($selectedPost->price ?? 0, 2) }}</span>
                                    @if($selectedProduct && $selectedProduct->cost_price)
                                        <span class="text-sm text-gray-400 line-through">${{ number_format($selectedProduct->cost_price, 2) }}</span>
                                    @endif
                                </div>

                                <div class="grid grid-cols-2 gap-x-4 gap-y-3 pt-3 border-t border-gray-100">
                                    <div>
                                        <span class="text-xs text-gray-400 font-medium uppercase tracking-wider">Category</span>
                                        <p class="text-sm text-gray-800 mt-1 truncate">{{ $selectedPost->productCategory?->name ?? 'Uncategorized' }}</p>
                                    </div>
                                    <div>
                                        <span class="text-xs text-gray-400 font-medium uppercase tracking-wider">SKU</span>
                                        <p class="text-sm text-gray-800 font-mono mt-1 truncate">{{ $selectedProduct ? $selectedProduct->sku : 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <span class="text-xs text-gray-400 font-medium uppercase tracking-wider">Stock</span>
                                        <p class="text-sm text-gray-800 font-semibold mt-1">{{ $selectedProduct ? $selectedProduct->stock : 0 }}</p>
                                    </div>
                                    <div>
                                        <span class="text-xs text-gray-400 font-medium uppercase tracking-wider">Added</span>
                                        <p class="text-sm text-gray-800 mt-1">{{ $selectedPost->created_at->format('M d, Y') }}</p>
                                    </div>
                                </div>
                                
                                @if ($selectedPost->description)
                                    <div class="pt-3 border-t border-gray-100">
                                        <span class="text-xs text-gray-400 font-medium uppercase tracking-wider">Description</span>
                                        <p class="text-sm text-gray-600 leading-relaxed mt-1.5">{{ $selectedPost->description }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @else
                    <div class="p-12 text-center">
                        <p class="text-gray-500">Product not found</p>
                        <button wire:click="closeItem" class="mt-4 text-sm font-medium text-[#1E7A4A] hover:underline">Close</button>
                    </div>
                @endif
            </div>
        </div>

        @if($selectedVariants && $selectedVariants->filter(fn($v) => $v->image)->count() > 0)
            @include('layouts.partials.variant-gallery-modal', ['variants' => $selectedVariants,'variantImages' => $selectedVariants->filter(fn($v) => $v->image),'isProduct' => true,
                'isService' => false])
        @endif
    </div>
@endif