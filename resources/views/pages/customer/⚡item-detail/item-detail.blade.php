<div class="pb-28 lg:pb-6" x-data="{ activeTab: 'overview' }">

    @if (session()->has('message'))
        <div class="mb-4 bg-green-50 text-green-700 px-5 py-3.5 rounded-xl text-sm font-medium">{{ session('message') }}</div>
    @endif

    <!-- Desktop Back Button -->
    <div class="hidden lg:block mb-6">
        <a href="{{ route('customer.dashboard') }}" class="inline-flex items-center gap-1.5 text-gray-500 hover:text-[#1E7A4A] transition text-sm font-medium">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 p-3 bg-white lg:gap-10 mb-6 lg:mb-10">
        <div class="space-y-4">
            <!-- Main Image Box -->
            <div class="relative lg:rounded-2xl overflow-hidden -mx-4 lg:mx-0 bg-gray-50 lg:bg-gray-50 lg:border lg:border-gray-200 shadow-sm lg:shadow-none aspect-[4/5] lg:aspect-square">
                @if ($currentImage)
                    <img src="{{ Storage::url($currentImage) }}" alt="{{ $post->name }}" class="w-full h-full object-contain bg-white lg:bg-gray-50">
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-300 bg-white">
                        <svg class="w-20 h-20" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                @endif

                <a href="{{ route('customer.dashboard') }}" class="lg:hidden absolute top-4 left-4 z-20 w-9 h-9 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center shadow-lg hover:scale-105 transition-transform text-gray-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>

                <button wire:click="toggleFavorite" class="absolute top-4 right-4 z-20 w-9 h-9 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center shadow-lg hover:scale-105 transition-transform">
                    <svg class="w-4 h-4 {{ $this->isFavorited ? 'text-red-500' : 'text-gray-600' }}" fill="{{ $this->isFavorited ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </button>

                @if ($this->allImages->count() > 1)
                    <button wire:click="previousImage" class="absolute left-2 lg:left-4 top-1/2 -translate-y-1/2 w-9 h-9 lg:w-10 lg:h-10 bg-white/90 backdrop-blur-sm rounded-full shadow-lg flex items-center justify-center hover:bg-white transition text-gray-700 opacity-70 hover:opacity-100 z-20">
                        <svg class="w-4 h-4 lg:w-5 lg:h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <button wire:click="nextImage" class="absolute right-2 lg:right-4 top-1/2 -translate-y-1/2 w-9 h-9 lg:w-10 lg:h-10 bg-white/90 backdrop-blur-sm rounded-full shadow-lg flex items-center justify-center hover:bg-white transition text-gray-700 opacity-70 hover:opacity-100 z-20">
                        <svg class="w-4 h-4 lg:w-5 lg:h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                    </button>
                @endif
            </div>

            @if ($this->allImages->count() > 1)
                <div class="flex gap-3 overflow-x-auto px-4 lg:px-0 pb-2">
                    @foreach ($this->allImages as $index => $img)
                        <button wire:key="thumb-{{ $index }}" wire:click="selectImage({{ $index }})"
                                class="shrink-0 w-20 h-20 lg:w-24 lg:h-24 rounded-xl border-2 overflow-hidden transition-all duration-200 bg-white {{ $currentImage === $img ? 'border-[#1E7A4A] shadow-sm' : 'border-transparent hover:border-gray-200' }}">
                            <img src="{{ Storage::url($img) }}" class="w-full h-full object-cover">
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="space-y-5 pt-2 px-4 lg:px-6 bg-white">
            
            <!-- Brand / Shop Mini-Logo -->
            @if ($post->tenant)
            <div class="flex items-center gap-2">
                <div class="w-5 h-5 rounded-full bg-[#1E7A4A] text-white flex items-center justify-center text-[8px] font-bold">
                    {{ strtoupper(substr($post->tenant->name ?? 'S', 0, 1)) }}
                </div>
                <span class="text-xs font-medium text-gray-700">{{ $post->tenant->name ?? 'Shop' }}</span>
            </div>
            @endif

            <!-- Product Title -->
            <h1 class="text-2xl lg:text-4xl font-bold text-gray-900 leading-tight tracking-tight">{{ $post->name }}</h1>

            <!-- Rating & Stock -->
            <div class="flex flex-wrap items-center gap-3">
                <div class="flex items-center gap-1">
                    <span class="text-yellow-400 text-sm">★★★★★</span>
                    <span class="text-sm font-bold text-gray-900">4.7</span>
                </div>
                <span class="text-xs text-gray-400">({{ $reviewCount }} Reviews)</span>
                
                @if ($this->stockStatus === 'out')
                    <span class="px-2.5 py-0.5 bg-red-100 text-red-600 text-[10px] font-bold rounded border border-red-200">Out of Stock</span>
                @elseif ($this->stockStatus === 'low')
                    <span class="px-2.5 py-0.5 bg-yellow-100 text-yellow-600 text-[10px] font-bold rounded border border-yellow-200">Low Stock</span>
                @elseif ($this->stockStatus === 'in')
                    <span class="px-2.5 py-0.5 bg-green-100 text-green-600 text-[10px] font-bold rounded border border-green-200">In Stock</span>
                @endif
            </div>

            <!-- Clean Description Block -->
            @if ($post->description)
                <div class="text-sm text-gray-600 leading-relaxed border-t border-gray-100 pt-4">
                    <h3 class="text-xs font-bold text-gray-800 mb-1 uppercase tracking-wide">Description</h3>
                    <p>{{ Str::limit($post->description, 240) }}</p>
                </div>
            @endif

            <!-- Big Price -->
            <div class="flex items-baseline gap-3 border-t border-gray-100 pt-4">
                <span class="text-3xl lg:text-4xl font-bold text-gray-900">${{ number_format($this->displayPrice, 2) }}</span>
                @if ($post->price && $this->displayPrice < $post->price)
                    <span class="text-base text-gray-400 line-through">${{ number_format($post->price, 2) }}</span>
                @endif
            </div>

            <!-- Product Variants (Attributes) -->
            @if ($post->type === 'product' && !empty($this->availableOptions))
                <div class="space-y-3 border-t border-gray-100 pt-4">
                    @foreach ($this->availableOptions as $attributeName => $values)
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-wide">{{ ucfirst($attributeName) }}</label>
                            <div class="flex flex-wrap gap-2">
                                @foreach ($values as $value)
                                    <button wire:key="attr-{{ $attributeName }}-{{ $value }}" wire:click="selectAttributeValue('{{ $attributeName }}', '{{ $value }}')"
                                            class="px-5 py-2 text-sm font-medium rounded-lg border transition-all duration-200 {{ ($selectedAttributes[$attributeName] ?? '') === $value ? 'border-[#1E7A4A] bg-[#1E7A4A] text-white shadow-md' : 'border-gray-200 bg-white text-gray-700 hover:border-[#1E7A4A] hover:text-[#1E7A4A]' }}">
                                        {{ $value }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Desktop Purchase Actions -->
            <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                <!-- Quantity Selector -->
                <div class="flex items-center border border-gray-200 rounded-lg overflow-hidden h-11 shrink-0">
                    <button wire:click="decrementQuantity" class="px-3 h-full hover:bg-gray-50 transition text-gray-600 border-r border-gray-200">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4"/></svg>
                    </button>
                    <span class="w-10 h-full flex items-center justify-center text-sm font-semibold text-gray-900 bg-gray-50">{{ $quantity }}</span>
                    <button wire:click="incrementQuantity" class="px-3 h-full hover:bg-gray-50 transition text-gray-600 border-l border-gray-200">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    </button>
                </div>

                <!-- Buttons -->
                <button wire:click="buyNow" @if($this->stockStatus === 'out') disabled @endif
                        class="flex-1 py-3 bg-[#1E7A4A] text-white text-sm font-bold rounded-lg hover:bg-[#175e39] transition shadow-sm disabled:opacity-40 disabled:cursor-not-allowed">
                    Buy Now
                </button>
                
                <button wire:click="addToCart" @if($this->stockStatus === 'out') disabled @endif
                        class="flex-1 py-3 border-2 border-gray-200 text-[#1E7A4A] text-sm font-bold rounded-lg hover:border-[#1E7A4A] hover:text-[#1E7A4A] transition shadow-sm disabled:opacity-40 disabled:cursor-not-allowed bg-white">
                    Add To Cart
                </button>
            </div>

            <div class="text-[10px] text-gray-400 pt-1">SKU: {{ $post->inventory->sku ?? 'N/A' }}</div>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- STICKY TABS                                  -->
    <!-- ========================================== -->
    <div class="sticky top-0 z-30 bg-white/95 backdrop-blur-sm border-b border-gray-200 px-4 lg:px-0 shadow-sm lg:shadow-none">
        <div class="flex overflow-x-auto gap-6 lg:gap-8 px-1">
            <button @click="activeTab = 'overview'" class="py-3 text-xs font-bold uppercase tracking-wider whitespace-nowrap transition-all duration-200 border-b-2" :class="activeTab === 'overview' ? 'text-[#1E7A4A] border-[#1E7A4A]' : 'text-gray-500 hover:text-gray-800 border-transparent'">Overview</button>
            <button @click="activeTab = 'review'" class="py-3 text-xs font-bold uppercase tracking-wider whitespace-nowrap transition-all duration-200 border-b-2" :class="activeTab === 'review' ? 'text-[#1E7A4A] border-[#1E7A4A]' : 'text-gray-500 hover:text-gray-800 border-transparent'">Review</button>
            <button @click="activeTab = 'description'" class="py-3 text-xs font-bold uppercase tracking-wider whitespace-nowrap transition-all duration-200 border-b-2" :class="activeTab === 'description' ? 'text-[#1E7A4A] border-[#1E7A4A]' : 'text-gray-500 hover:text-gray-800 border-transparent'">Description</button>
            <button @click="activeTab = 'recommended'" class="py-3 text-xs font-bold uppercase tracking-wider whitespace-nowrap transition-all duration-200 border-b-2" :class="activeTab === 'recommended' ? 'text-[#1E7A4A] border-[#1E7A4A]' : 'text-gray-500 hover:text-gray-800 border-transparent'">Recommended</button>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- TAB CONTENT                                  -->
    <!-- ========================================== -->
    <div class="px-4 lg:px-0 py-6 lg:py-8">

        <div x-show="activeTab === 'overview'" x-cloak>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-12 bg-gray-50 rounded-xl p-6 lg:p-8">
                <div class="flex flex-col items-center justify-center text-center space-y-1">
                    <span class="text-5xl font-bold text-gray-900">4.7</span>
                    <span class="text-xs text-gray-500 font-medium">out of 5</span>
                    <div class="flex items-center gap-1 text-yellow-400 text-lg">★★★★★</div>
                    <span class="text-xs text-gray-400">({{ $reviewCount }} Reviews)</span>
                </div>
                <div class="col-span-2 space-y-2">
                    @foreach ([5, 4, 3, 2, 1] as $star)
                        @php $percentage = match($star) { 5 => 70, 4 => 20, 3 => 5, 2 => 3, default => 2 }; @endphp
                        <div class="flex items-center gap-4">
                            <span class="text-sm font-medium text-gray-600 w-6">{{ $star }}</span>
                            <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                                <div class="h-full bg-yellow-400 rounded-full" style="width: {{ $percentage }}%"></div>
                            </div>
                            <span class="text-xs text-gray-400 w-10 text-right">{{ $percentage }}%</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div x-show="activeTab === 'review'" x-cloak>
            <p class="text-sm text-gray-500 italic text-center py-8">No customer reviews yet. Be the first to review this product!</p>
        </div>

        <div x-show="activeTab === 'description'" x-cloak>
            <div class="prose prose-sm max-w-none text-gray-600 space-y-4 leading-relaxed">
                @if ($post->description)
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Product Description</h3>
                        <p>{{ $post->description }}</p>
                    </div>
                @endif

                @if (!empty($post->additional_info) && is_array($post->additional_info))
                    @php
                        $sectionName = $post->additional_info['section_name'] ?? 'Product Details';
                        $displayStyle = $post->additional_info['display_style'] ?? 'list';
                        $items = $post->additional_info['items'] ?? [];
                    @endphp
                    @if (!empty($items))
                        <div class="mt-4 border-t border-gray-100 pt-6">
                            @if ($sectionName)
                                <h3 class="text-lg font-bold text-gray-900 mb-3">{{ $sectionName }}</h3>
                            @endif

                            @if ($displayStyle === 'list')
                                <ul class="list-disc pl-5 space-y-1.5 text-sm">
                                    @foreach ($items as $info)
                                        @if (!empty($info['label']) && !empty($info['value']))
                                            <li><span class="font-medium text-gray-900">{{ ucfirst($info['label']) }}:</span> <span class="text-gray-600">{{ $info['value'] }}</span></li>
                                        @endif
                                    @endforeach
                                </ul>
                            @elseif ($displayStyle === 'grid')
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-2">
                                    @foreach ($items as $info)
                                        @if (!empty($info['label']) && !empty($info['value']))
                                            <div class="flex items-center py-2 border-b border-gray-100 last:border-0">
                                                <span class="text-sm font-medium text-gray-500 min-w-[100px]">{{ $info['label'] }}</span>
                                                <span class="text-sm text-gray-900 font-medium">{{ $info['value'] }}</span>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endif
                @endif
            </div>
        </div>

        <div x-show="activeTab === 'recommended'" x-cloak>
            <div class="space-y-4">
                <h3 class="text-lg font-bold text-gray-900">You might also like</h3>

                @if ($this->recommendedProducts->isNotEmpty())
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach ($this->recommendedProducts as $related)
                            <a wire:key="recommended-{{ $related->id }}" href="{{ route('customer.item_detail', $related->id) }}"
                               class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden hover:shadow-md transition group block">
                                <div class="aspect-square bg-gray-50 flex items-center justify-center p-3 relative">
                                    @if ($related->image)
                                        <img src="{{ Storage::url($related->image) }}" alt="{{ $related->name }}" class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-300">
                                    @else
                                        <div class="text-gray-300">
                                            <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-3 border-t border-gray-100">
                                    <p class="text-xs font-medium text-gray-900 truncate leading-tight">{{ $related->name }}</p>
                                    <p class="text-sm font-bold text-gray-900 mt-1">${{ number_format($related->price ?? 0, 2) }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-500 italic text-center py-4">No related products found.</p>
                @endif
            </div>
        </div>
    </div>

    @if ($post->tenant)
        <div class="px-4 lg:px-0 mb-6 bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="flex items-center justify-between p-4 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-full bg-[#1E7A4A] text-white flex items-center justify-center font-bold text-sm lg:text-base shadow-sm flex-shrink-0">
                        {{ strtoupper(substr($post->tenant->name ?? 'S', 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-sm font-bold text-gray-900 leading-tight">{{ $post->tenant->name ?? 'Shop' }}</p>
                        <div class="flex items-center gap-2 mt-0.5">
                            <div class="flex items-center text-[10px] text-yellow-500">★★★★★ <span class="text-gray-400 ml-1">4.9</span></div>
                        </div>
                    </div>
                </div>
                <a href="#" class="px-5 py-1.5 bg-[#1E7A4A] text-white text-xs font-medium rounded-full hover:bg-[#16633c] transition shadow-sm whitespace-nowrap">
                    Visit Shop
                </a>
            </div>

            @if ($this->shopProducts->isNotEmpty())
                <div class="p-4">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-xs font-bold text-gray-800 uppercase tracking-wide">More from this shop</p>
                    </div>
                    <div class="flex gap-3 overflow-x-auto pb-2 snap-x snap-mandatory">
                        @foreach ($this->shopProducts as $shopProduct)
                            <a wire:key="shop-product-{{ $shopProduct->id }}" href="{{ route('customer.item_detail', $shopProduct->id) }}"
                               class="snap-start shrink-0 w-[130px] bg-white rounded-lg border border-gray-200 overflow-hidden hover:shadow-md transition">
                                <div class="aspect-square bg-gray-50 flex items-center justify-center p-2">
                                    @if ($shopProduct->image)
                                        <img src="{{ Storage::url($shopProduct->image) }}" alt="{{ $shopProduct->name }}" class="w-full h-full object-contain">
                                    @else
                                        <div class="text-gray-300">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-2 border-t border-gray-100">
                                    <p class="text-[10px] font-medium text-gray-900 truncate">{{ $shopProduct->name }}</p>
                                    <p class="text-[10px] font-bold text-gray-900 mt-0.5">${{ number_format($shopProduct->price ?? 0, 2) }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    @endif

    <div class="fixed bottom-0 left-0 right-0 z-40 bg-white border-t border-gray-200 shadow-[0_-4px_12px_rgba(0,0,0,0.05)] px-4 py-3 lg:hidden">
        <div class="flex items-center justify-between gap-3">
            <div class="flex items-center gap-2 flex-1">
                <button wire:click="addToCart" @if($this->stockStatus === 'out') disabled @endif
                        class="flex-1 py-2 bg-white border-2 border-[#1E7A4A] text-[#1E7A4A] text-sm font-semibold rounded-full hover:bg-[#1E7A4A] hover:text-white transition shadow-sm disabled:opacity-40 disabled:cursor-not-allowed">
                    Add To Cart
                </button>
                <button wire:click="buyNow" @if($this->stockStatus === 'out') disabled @endif
                        class="flex-1 py-2 bg-[#1E7A4A] text-white text-sm font-semibold rounded-full hover:bg-[#16633c] transition shadow-sm disabled:opacity-40 disabled:cursor-not-allowed">
                    Buy Now
                </button>
            </div>
        </div>
    </div>
</div>