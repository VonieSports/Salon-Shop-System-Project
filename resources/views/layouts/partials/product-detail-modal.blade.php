@if($selectedPostId)
    <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ 
        activeImage: 0, 
        showVariantGallery: false 
    }">
        <div class="flex items-center justify-center min-h-screen p-4">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-black/40" wire:click="closeItem"></div>
            
            <!-- Modal Card -->
            <div class="relative bg-white rounded shadow-xl w-full max-w-2xl max-h-[90vh] overflow-hidden mx-auto flex flex-col">
                
                <!-- Header: Simple bar -->
                @if($selectedPost)
                <div class="flex items-center justify-between px-4 py-2.5 border-b border-gray-200 bg-gray-50 shrink-0">
                    <h2 class="text-base font-semibold text-gray-800">Product Details</h2>
                    <button wire:click="closeItem" class="text-gray-400 hover:text-gray-700 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Scrollable Body -->
                <div class="overflow-y-auto p-4 flex-1">
                    
                    <!-- Image -->
                    <div class="w-full bg-gray-50 border border-gray-200 rounded mb-4 aspect-square max-w-[150px] mx-auto overflow-hidden relative">
                        @if($selectedGallery && count($selectedGallery) > 0)
                            @foreach ($selectedGallery as $i => $img)
                                <img src="{{ Storage::url($img) }}" alt="{{ $selectedPost->name }}" class="w-full h-full object-contain">
                            @endforeach
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center text-gray-400">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M4 8h16M4 4h16a1 1 0 011 1v14a1 1 0 01-1 1H4a1 1 0 01-1-1V5a1 1 0 011-1z"/>
                                </svg>
                                <span class="text-xs mt-1">No image</span>
                            </div>
                        @endif
                    </div>

                    <!-- Plain List -->
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between border-b border-gray-100 pb-1.5">
                            <span class="text-gray-500">Name</span>
                            <span class="font-medium text-gray-900 text-right">{{ $selectedPost->name }}</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-100 pb-1.5">
                            <span class="text-gray-500">Price</span>
                            <span class="font-medium text-[#1E7A4A] text-right">${{ number_format($selectedPost->price ?? 0, 2) }}</span>
                        </div>
                        @if($selectedProduct && $selectedProduct->cost_price)
                        <div class="flex justify-between border-b border-gray-100 pb-1.5">
                            <span class="text-gray-500">Original Price</span>
                            <span class="font-medium text-gray-400 line-through text-right">${{ number_format($selectedProduct->cost_price, 2) }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between border-b border-gray-100 pb-1.5">
                            <span class="text-gray-500">Category</span>
                            <span class="font-medium text-gray-800 text-right">{{ $selectedPost->productCategory?->name ?? 'Uncategorized' }}</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-100 pb-1.5">
                            <span class="text-gray-500">SKU</span>
                            <span class="font-mono text-gray-800 text-right">{{ $selectedProduct ? $selectedProduct->sku : 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-100 pb-1.5">
                            <span class="text-gray-500">Stock</span>
                            <span class="font-medium text-gray-800 text-right">{{ $selectedProduct ? $selectedProduct->stock : 0 }}</span>
                        </div>
                        <div class="flex justify-between border-b border-gray-100 pb-1.5">
                            <span class="text-gray-500">Status</span>
                            <span class="font-medium text-gray-800 text-right flex items-center gap-1.5 justify-end">
                                <span class="w-2 h-2 rounded-full {{ $selectedPost->status === 'published' ? 'bg-[#1E7A4A]' : 'bg-gray-400' }}"></span>
                                {{ ucfirst($selectedPost->status) }}
                            </span>
                        </div>
                        <div class="flex justify-between border-b border-gray-100 pb-1.5">
                            <span class="text-gray-500">Date Added</span>
                            <span class="text-gray-800 text-right">{{ $selectedPost->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>

                    <!-- Description -->
                    @if ($selectedPost->description)
                        <div class="mt-4 pt-3 border-t border-gray-200">
                            <span class="block text-xs text-gray-400 font-medium uppercase tracking-wider mb-1">Description</span>
                            <p class="text-sm text-gray-700 leading-relaxed">{{ $selectedPost->description }}</p>
                        </div>
                    @endif

                    <!-- Actions -->
                    <div class="mt-5 pt-3 border-t border-gray-200 flex flex-col sm:flex-row gap-2">
                        <a href="{{ route('owner.update_product', $selectedPost->id) }}" class="w-full text-center bg-[#1E7A4A] text-white px-3 py-2 rounded text-sm hover:bg-[#16633c] transition">
                            Update Product
                        </a>
                        <button wire:click="deleteItem({{ $selectedPost->id }})" wire:confirm="Archive this product?" class="w-full text-center border border-gray-300 text-gray-700 px-3 py-2 rounded text-sm hover:bg-gray-50 transition">
                            Archive
                        </button>
                    </div>

                </div>
                
                @else
                    <div class="p-8 text-center">
                        <p class="text-gray-500">Product not found</p>
                        <button wire:click="closeItem" class="mt-3 text-sm font-medium text-[#1E7A4A] hover:underline">Close</button>
                    </div>
                @endif
            </div>
        </div>

        @if($selectedVariants && $selectedVariants->filter(fn($v) => $v->image)->count() > 0)
            @include('layouts.partials.variant-gallery-modal', ['variants' => $selectedVariants,'variantImages' => $selectedVariants->filter(fn($v) => $v->image),'isProduct' => true,'isService' => false])
        @endif
    </div>
@endif