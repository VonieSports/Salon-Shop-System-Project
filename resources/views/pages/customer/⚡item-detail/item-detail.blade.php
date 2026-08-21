<!-- resources/views/livewire/pages/customer/item-detail.blade.php -->
<div class="min-h-screen bg-[#F5F5F5]" x-data="{ activeTab: 'description' }">
    
    <!-- Alerts -->
    @if (session()->has('message') || session()->has('error'))
        <div class="max-w-7xl mx-auto px-4 pt-3">
            @if (session()->has('message'))
                <div class="bg-[#FCE9ED] border border-[#D6657A]/30 text-[#7A3B4A] px-3 py-2 rounded-lg text-sm font-medium flex items-center gap-2">
                    <svg class="w-4 h-4 text-[#D6657A] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('message') }}
                </div>
            @endif
            @if (session()->has('error'))
                <div class="bg-[#FDE8E8] border border-[#D6657A]/40 text-[#7A2E3A] px-3 py-2 rounded-lg text-sm font-medium flex items-center gap-2">
                    <svg class="w-4 h-4 text-[#D6657A] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    {{ session('error') }}
                </div>
            @endif
        </div>
    @endif

    <div class="max-w-7xl mx-auto px-3 sm:px-4 py-3 sm:py-4">

        <!-- Breadcrumb -->
        <nav class="flex items-center gap-1 text-xs text-[#666] mb-3 overflow-x-auto whitespace-nowrap">
            <a href="{{ route('customer.dashboard') }}" class="hover:text-[#D6657A] transition">Home</a>
            <svg class="w-3 h-3 flex-shrink-0 text-[#999]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
            <a href="#" class="hover:text-[#D6657A] transition">{{ $post->productCategory?->name ?? 'Products' }}</a>
            <svg class="w-3 h-3 flex-shrink-0 text-[#999]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-[#333] font-medium truncate max-w-32 sm:max-w-xs">{{ $post->name }}</span>
        </nav>

        <!-- Main Product Card - Shopee Style Layout -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-4 p-4">

                <!-- Left: Images - 2 columns -->
                <div class="lg:col-span-2">
                    <div class="relative bg-[#FAFAFA] rounded-lg overflow-hidden aspect-square border border-[#EFEFEF]">
                        @if ($currentImage)
                            <img src="{{ Storage::url($currentImage) }}" alt="{{ $post->name }}" class="w-full h-full object-contain p-3">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-[#D6657A]/30">
                                <svg class="w-16 h-16" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif

                        <!-- Navigation & Counter -->
                        @if (count($this->allImages) > 1)
                            @php
                                $images = $this->allImages;
                                $currentImageIndex = array_search($this->currentImage, $images, true);
                                if ($currentImageIndex === false) $currentImageIndex = 0;
                            @endphp
                            
                            <button wire:click="previousImage" 
                                    class="absolute left-2 top-1/2 -translate-y-1/2 w-8 h-8 bg-white/90 hover:bg-white border border-[#EFEFEF] rounded-full flex items-center justify-center shadow-sm transition text-[#D6657A] hover:text-[#C25467]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </button>
                            <button wire:click="nextImage" 
                                    class="absolute right-2 top-1/2 -translate-y-1/2 w-8 h-8 bg-white/90 hover:bg-white border border-[#EFEFEF] rounded-full flex items-center justify-center shadow-sm transition text-[#D6657A] hover:text-[#C25467]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                            <span class="absolute bottom-2 left-1/2 -translate-x-1/2 bg-[#D6657A]/80 text-[#FFF7F9] text-[10px] px-2.5 py-0.5 rounded-full">
                                {{ $currentImageIndex + 1 }} / {{ count($images) }}
                            </span>
                        @endif
                    </div>

                    <!-- Thumbnails -->
                    @if (count($this->allImages) > 1)
                        <div class="flex gap-1.5 mt-2 overflow-x-auto pb-0.5">
                            @foreach ($this->allImages as $index => $img)
                                <button wire:key="thumb-{{ $index }}" wire:click="selectImage({{ $index }})"
                                        class="shrink-0 w-14 h-14 rounded-lg border-2 overflow-hidden transition {{ $currentImage === $img ? 'border-[#D6657A]' : 'border-[#EFEFEF] hover:border-[#D6657A]/50' }}">
                                    <img src="{{ Storage::url($img) }}" class="w-full h-full object-cover">
                                </button>
                            @endforeach
                        </div>
                    @endif

                    <!-- Share & Favorite -->
                    <div class="flex items-center gap-4 mt-2 text-xs text-[#666]">
                        <button class="flex items-center gap-1 hover:text-[#D6657A] transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                            </svg>
                            Share
                        </button>
                        <button class="flex items-center gap-1 hover:text-[#D6657A] transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                            </svg>
                            Favorite
                        </button>
                    </div>
                </div>

                <!-- Right: Details - 3 columns -->
                <div class="lg:col-span-3 space-y-3">
                    
                    <!-- Shop -->
                    @if ($post->tenant)
                        <div class="flex items-center gap-2 text-xs">
                            <span class="text-[#666]">Shop:</span>
                            <a href="#" class="text-[#D6657A] font-medium hover:underline">{{ $post->tenant->name }}</a>
                            <span class="text-[10px] bg-[#FCE9ED] text-[#D6657A] px-1.5 py-0.5 rounded-full font-medium">Official</span>
                        </div>
                    @endif

                    <!-- Title -->
                    <h1 class="text-lg sm:text-xl font-medium text-[#222] leading-snug">{{ $post->name }}</h1>

                    <!-- Rating & Stock Labels -->
                    <div class="flex items-center flex-wrap gap-2 text-xs">
                        <div class="flex items-center gap-0.5">
                            <span class="text-amber-400 text-sm">★★★★★</span>
                            <span class="text-[#D6657A] ml-0.5 font-medium">{{ $this->ratingCount }}</span>
                            <span class="text-[#666]">Ratings</span>
                        </div>
                        <span class="text-[#CCC]">|</span>
                        <span class="text-[#666]"><span class="text-[#222] font-medium">2K+</span> Sold</span>

                        @if ($this->stockStatus === 'out')
                            <span class="text-[#C25467] font-semibold">Out of Stock</span>
                        @elseif ($this->stockStatus === 'low')
                            <span class="text-amber-500 font-semibold">Low Stock</span>
                        @elseif ($this->stockStatus === 'select_required')
                            <span class="text-[#999] italic">Select variant</span>
                        @else
                            <span class="text-[#666]"><span class="text-[#222] font-medium">{{ $this->stock }}</span> in stock</span>
                        @endif
                    </div>

                    <!-- Price -->
                    <div class="bg-[#FAFAFA] rounded-lg p-3 border border-[#EFEFEF]">
                        <div class="flex items-end gap-2">
                            @php
                                $basePrice = (float) ($post->price ?? 0);
                                $displayPrice = $this->displayPrice;
                                $priceIsAdjusted = $this->selectedVariant && $this->selectedVariant->price_adjustment;
                            @endphp

                            <p class="text-2xl font-bold text-[#D6657A]">
                                ₱{{ number_format($displayPrice, 2) }}
                            </p>

                            @if ($priceIsAdjusted && $basePrice > 0 && $basePrice !== $displayPrice)
                                <p class="text-sm text-[#999] line-through mb-0.5">₱{{ number_format($basePrice, 2) }}</p>
                                <span class="text-xs text-[#D6657A] font-medium bg-[#FCE9ED] px-1.5 py-0.5 rounded">-{{ round((1 - $displayPrice/$basePrice) * 100) }}%</span>
                            @endif
                        </div>
                    </div>

                    <!-- Errors -->
                    @error('variant') <p class="text-[10px] text-[#C25467] font-normal">{{ $message }}</p> @enderror
                    @error('stock') <p class="text-[10px] text-[#C25467] font-normal">{{ $message }}</p> @enderror

                    <!-- Product Variants -->
                    @if (!empty($this->availableOptions))
                        <div class="space-y-2 pt-1 border-t border-[#EFEFEF]">
                            @foreach ($this->availableOptions as $attributeName => $values)
                                <div class="flex items-start gap-3">
                                    <p class="text-xs text-[#666] font-medium min-w-[60px] pt-0.5">{{ ucfirst($attributeName) }}</p>
                                    <div class="flex flex-wrap gap-1.5">
                                        @foreach ($values as $value)
                                            @php
                                                $isSelected = ($selectedAttributes[$attributeName] ?? '') === $value;
                                            @endphp
                                            <button wire:key="attr-{{ $attributeName }}-{{ $value }}"
                                                    wire:click="selectAttributeValue('{{ $attributeName }}', '{{ $value }}')"
                                                    class="px-3 py-1 text-xs font-medium rounded border transition cursor-pointer
                                                        {{ $isSelected 
                                                            ? 'border-[#D6657A] bg-[#D6657A] text-white' 
                                                            : 'border-[#EFEFEF] text-[#333] hover:border-[#D6657A] hover:bg-[#FFF7F9]' }}">
                                                {{ $value }}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- Product Quantity & Actions -->
                    <div class="border-t border-[#EFEFEF] pt-2 space-y-2.5">
                        
                        <div class="flex items-center gap-3">
                            <span class="text-xs text-[#666] font-medium min-w-[60px]">Quantity</span>
                            @if(!empty($this->availableOptions) && !$this->selectedVariantId)
                                <div class="flex items-center border border-[#EFEFEF] rounded overflow-hidden opacity-50 cursor-not-allowed">
                                    <button disabled class="px-2.5 py-1 text-[#CCC] cursor-not-allowed text-sm">−</button>
                                    <span class="w-8 text-center text-sm font-medium bg-[#FAFAFA] py-1 text-[#999]">1</span>
                                    <button disabled class="px-2.5 py-1 text-[#CCC] cursor-not-allowed text-sm">+</button>
                                </div>
                                <span class="text-[10px] text-[#999]">Select variant first</span>
                            @else
                                <div class="flex items-center border border-[#EFEFEF] rounded overflow-hidden">
                                    <button wire:click="decrementQuantity" class="px-2.5 py-1 hover:bg-[#FAFAFA] text-[#D6657A] transition text-sm">−</button>
                                    <span class="w-8 text-center text-sm font-medium bg-[#FAFAFA] py-1 text-[#222]">{{ $quantity }}</span>
                                    <button wire:click="incrementQuantity" class="px-2.5 py-1 hover:bg-[#FAFAFA] text-[#D6657A] transition text-sm">+</button>
                                </div>
                            @endif
                        </div>

                        <div class="grid grid-cols-2 gap-2">
                            <button wire:click="addToCart" @if($this->stockStatus === 'out') disabled @endif
                                    class="w-full py-2.5 border-2 border-[#D6657A] text-[#D6657A] font-semibold rounded hover:bg-[#D6657A] hover:text-white transition disabled:opacity-50 disabled:cursor-not-allowed text-sm">
                                <svg class="w-4 h-4 inline mr-1.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                                Add to Cart
                            </button>
                            <button wire:click="buyNow" @if($this->stockStatus === 'out') disabled @endif
                                    class="w-full py-2.5 bg-[#D6657A] hover:bg-[#C25467] text-white font-semibold rounded transition disabled:opacity-50 disabled:cursor-not-allowed text-sm">
                                Buy Now
                            </button>
                        </div>
                    </div>

                    <!-- Trust Badges -->
                    <div class="border-t border-[#EFEFEF] pt-2">
                        <div class="flex flex-wrap gap-4 text-xs text-[#666]">
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4 text-[#D6657A]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                                Authentic
                            </span>
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4 text-[#D6657A]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                                Secure Payment
                            </span>
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4 text-[#D6657A]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                                Trusted Seller
                            </span>
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4 text-[#D6657A]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v4h4M21 3v4h-4M3 21v-4h4M21 21v-4h-4"/>
                                </svg>
                                Free Returns
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs Section -->
        <div class="mt-3 bg-white rounded-lg shadow-sm border border-[#EFEFEF] overflow-hidden">
            <div class="border-b border-[#EFEFEF] px-4 overflow-x-auto">
                <div class="flex gap-6 min-w-max">
                    <button @click="activeTab = 'description'" 
                            class="py-2.5 text-sm font-medium border-b-2 -mb-px transition whitespace-nowrap" 
                            :class="activeTab === 'description' ? 'border-[#D6657A] text-[#D6657A]' : 'border-transparent text-[#666] hover:text-[#D6657A]'">
                        Product Description
                    </button>
                    <button @click="activeTab = 'specifications'" 
                            class="py-2.5 text-sm font-medium border-b-2 -mb-px transition whitespace-nowrap"
                            :class="activeTab === 'specifications' ? 'border-[#D6657A] text-[#D6657A]' : 'border-transparent text-[#666] hover:text-[#D6657A]'">
                        Specifications
                    </button>
                    <button @click="activeTab = 'reviews'" 
                            class="py-2.5 text-sm font-medium border-b-2 -mb-px transition flex items-center gap-1.5 whitespace-nowrap"
                            :class="activeTab === 'reviews' ? 'border-[#D6657A] text-[#D6657A]' : 'border-transparent text-[#666] hover:text-[#D6657A]'">
                        Reviews
                        <span class="bg-[#F4D9E2] text-[#7A3B4A] text-[10px] px-1.5 py-0.5 rounded-full">{{ $this->ratingCount }}</span>
                    </button>
                </div>
            </div>

            <div class="px-4 py-4">
                <!-- Description Tab -->
                <div x-show="activeTab === 'description'" x-cloak>
                    <div class="max-w-3xl">
                        @if ($post->description)
                            <div class="text-[#333] leading-relaxed whitespace-pre-wrap text-sm">{{ $post->description }}</div>
                        @endif

                        @if (!empty($post->additional_info) && is_array($post->additional_info))
                            @php
                                $items = $post->additional_info['items'] ?? [];
                                $sectionName = $post->additional_info['section_name'] ?? null;
                            @endphp
                            @if (!empty($items))
                                <div class="mt-3 pt-3 border-t border-[#EFEFEF]">
                                    @if ($sectionName)
                                        <h4 class="text-sm font-semibold text-[#333] mb-2">{{ $sectionName }}</h4>
                                    @endif
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-1.5">
                                        @foreach ($items as $info)
                                            @if (!empty($info['label']) && !empty($info['value']))
                                                <div class="flex items-baseline gap-2 text-sm">
                                                    <span class="text-[#666] min-w-[80px]">{{ $info['label'] }}:</span>
                                                    <span class="text-[#333] font-medium">{{ $info['value'] }}</span>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>

                <!-- Specifications Tab -->
                <div x-show="activeTab === 'specifications'" x-cloak>
                    <div class="max-w-3xl">
                        <div class="bg-[#FAFAFA] rounded-lg overflow-hidden border border-[#EFEFEF]">
                            <table class="w-full text-sm">
                                <tbody>
                                    <tr class="border-b border-[#EFEFEF]">
                                        <td class="px-4 py-2.5 text-[#666] font-medium w-1/3">Category</td>
                                        <td class="px-4 py-2.5 text-[#333]">{{ $post->productCategory?->name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr class="border-b border-[#EFEFEF]">
                                        <td class="px-4 py-2.5 text-[#666] font-medium">Stock</td>
                                        <td class="px-4 py-2.5 text-[#333]">{{ $this->stock }} available</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-2.5 text-[#666] font-medium">Type</td>
                                        <td class="px-4 py-2.5 text-[#333] capitalize">{{ $post->type }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Reviews Tab -->
                <div x-show="activeTab === 'reviews'" x-cloak>
                    <div class="text-center py-8">
                        <div class="w-16 h-16 mx-auto mb-3 bg-[#FAFAFA] rounded-full flex items-center justify-center border border-[#EFEFEF]">
                            <svg class="w-8 h-8 text-[#D6657A]/30" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"/>
                            </svg>
                        </div>
                        <p class="text-[#666] text-base font-medium">No reviews yet</p>
                        <p class="text-[#999] text-sm mt-0.5">Be the first to review this product</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
</style>