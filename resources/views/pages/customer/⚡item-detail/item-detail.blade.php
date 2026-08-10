<div class="min-h-screen bg-gray-50" x-data="{ activeTab: 'overview' }">
    @if (session()->has('message'))
        <div class="max-w-6xl mx-auto px-4 pt-3">
            <div class="bg-emerald-50 text-emerald-700 px-4 py-2.5 rounded-md text-sm font-medium">
                {{ session('message') }}
            </div>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="max-w-6xl mx-auto px-4 pt-3">
            <div class="bg-red-50 text-red-700 px-4 py-2.5 rounded-md text-sm font-medium">
                {{ session('error') }}
            </div>
        </div>
    @endif

    <div class="max-w-6xl mx-auto px-4 py-5">
        <!-- Back Button -->
        <a href="{{ route('customer.dashboard') }}" class="inline-flex items-center gap-1.5 text-gray-500 hover:text-gray-700 text-xs font-medium mb-4">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to shop
        </a>

        <!-- Shopee-style Product Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            <!-- Left Column - Product Images -->
            <div class="space-y-3">
                <!-- Main Image -->
                <div class="relative bg-white border border-gray-200 rounded-lg overflow-hidden aspect-square">
                    @if ($currentImage)
                        <img src="{{ Storage::url($currentImage) }}" alt="{{ $post->name }}" class="w-full h-full object-contain">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                            <svg class="w-16 h-16" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    @endif

                    <!-- Favorite Button - Visual only -->
                    <button class="absolute top-3 right-3 w-8 h-8 bg-white border border-gray-200 rounded-full flex items-center justify-center shadow-sm hover:shadow-md transition hover:border-red-300 group">
                        <svg class="w-4 h-4 text-gray-400 group-hover:text-red-500 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </button>

                    <!-- Image Navigation - Only show if more than 1 image -->
                    @if (count($this->allImages) > 1)
                        <button wire:click="previousImage" class="absolute left-3 top-1/2 -translate-y-1/2 w-8 h-8 bg-white border border-gray-200 rounded-full flex items-center justify-center shadow-sm hover:shadow-md transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </button>
                        <button wire:click="nextImage" class="absolute right-3 top-1/2 -translate-y-1/2 w-8 h-8 bg-white border border-gray-200 rounded-full flex items-center justify-center shadow-sm hover:shadow-md transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    @endif
                </div>

                <!-- Thumbnails - Only show if more than 1 image -->
                @if (count($this->allImages) > 1)
                    <div class="flex gap-2 overflow-x-auto pb-2">
                        @foreach ($this->allImages as $index => $img)
                            <button wire:key="thumb-{{ $index }}" wire:click="selectImage({{ $index }})"
                                    class="shrink-0 w-16 h-16 rounded-lg border-2 overflow-hidden transition {{ $currentImage === $img ? 'border-[#1E7A4A]' : 'border-gray-200 hover:border-gray-400' }}">
                                <img src="{{ Storage::url($img) }}" class="w-full h-full object-cover">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Right Column - Product Details -->
            <div class="space-y-4">
                <!-- Shop Name -->
                @if ($post->tenant)
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        <a href="#" class="text-sm text-[#1E7A4A] hover:underline">{{ $post->tenant->name }}</a>
                    </div>
                @endif

                <!-- Product Name -->
                <h1 class="text-xl font-semibold text-gray-900 leading-snug">{{ $post->name }}</h1>

                <!-- Rating & Stock -->
                <div class="flex items-center gap-3 text-xs">
                    <div class="flex items-center gap-1">
                        <span class="text-yellow-400">★★★★★</span>
                        <span class="text-gray-500">{{ $this->reviewCount }} reviews</span>
                    </div>
                    <span class="text-gray-300">|</span>
                    @if ($this->stockStatus === 'out')
                        <span class="px-2 py-0.5 bg-red-50 text-red-600 rounded font-medium">Out of Stock</span>
                    @elseif ($this->stockStatus === 'low')
                        <span class="px-2 py-0.5 bg-amber-50 text-amber-600 rounded font-medium">Low Stock</span>
                    @else
                        <span class="text-gray-500">{{ $this->stock }} available</span>
                    @endif
                </div>

                <!-- Price -->
                <div class="bg-gray-50 rounded-lg p-4">
                    <div class="flex items-end gap-2">
                        <span class="text-2xl font-bold text-[#1E7A4A]">₱{{ number_format($this->displayPrice, 2) }}</span>
                    </div>
                    <p class="text-xs text-gray-400 mt-1">VAT included</p>
                </div>

                <!-- Error Messages -->
                @error('variant') <p class="text-sm text-red-600 font-medium">{{ $message }}</p> @enderror
                @error('stock') <p class="text-sm text-red-600 font-medium">{{ $message }}</p> @enderror

                <!-- Product Variants -->
                @if ($post->type === 'product' && !empty($this->availableOptions))
                    <div class="border-t border-gray-100 pt-4">
                        @foreach ($this->availableOptions as $attributeName => $values)
                            <div class="mb-3">
                                <p class="text-xs font-medium text-gray-700 mb-2">{{ ucfirst($attributeName) }}</p>
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($values as $value)
                                        <button wire:key="attr-{{ $attributeName }}-{{ $value }}" 
                                                wire:click="selectAttributeValue('{{ $attributeName }}', '{{ $value }}')"
                                                class="px-3 py-1.5 text-xs font-medium rounded-lg border-2 transition {{ ($selectedAttributes[$attributeName] ?? '') === $value ? 'border-[#1E7A4A] bg-[#1E7A4A] text-white' : 'border-gray-200 text-gray-700 hover:border-[#1E7A4A]' }}">
                                            {{ $value }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Quantity -->
                <div class="border-t border-gray-100 pt-4">
                    <div class="flex items-center gap-4">
                        <span class="text-sm text-gray-600">Quantity</span>
                        <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden">
                            <button wire:click="decrementQuantity" class="px-3 py-1.5 hover:bg-gray-50 text-gray-600 transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                </svg>
                            </button>
                            <span class="w-10 text-center text-sm font-medium bg-gray-50 py-1.5">{{ $quantity }}</span>
                            <button wire:click="incrementQuantity" class="px-3 py-1.5 hover:bg-gray-50 text-gray-600 transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="border-t border-gray-100 pt-4">
                    <div class="grid grid-cols-2 gap-3">
                        <button wire:click="addToCart" @if($this->stockStatus === 'out') disabled @endif
                                class="w-full py-2.5 border-2 border-[#1E7A4A] text-[#1E7A4A] text-sm font-semibold rounded-lg hover:bg-[#1E7A4A] hover:text-white transition disabled:opacity-40">
                            <svg class="w-4 h-4 inline mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                            Add to Cart
                        </button>
                        <button wire:click="buyNow" @if($this->stockStatus === 'out') disabled @endif
                                class="w-full py-2.5 bg-[#1E7A4A] hover:bg-[#16653D] text-white text-sm font-semibold rounded-lg transition disabled:opacity-40">
                            Buy Now
                        </button>
                    </div>
                </div>

                <!-- Product Highlights -->
                <div class="bg-gray-50 rounded-lg p-4 mt-2">
                    <div class="grid grid-cols-2 gap-3 text-xs">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-[#1E7A4A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            <span class="text-gray-600">Authentic Product</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-[#1E7A4A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                            <span class="text-gray-600">Secure Payment</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="mt-8 bg-white rounded-lg border border-gray-200">
            <div class="border-b border-gray-200 px-6">
                <div class="flex gap-8">
                    <button @click="activeTab = 'overview'" 
                            class="py-3 text-sm font-medium border-b-2 transition" 
                            :class="activeTab === 'overview' ? 'border-[#1E7A4A] text-[#1E7A4A]' : 'border-transparent text-gray-500 hover:text-gray-700'">
                        Product Description
                    </button>
                    <button @click="activeTab = 'review'" 
                            class="py-3 text-sm font-medium border-b-2 transition" 
                            :class="activeTab === 'review' ? 'border-[#1E7A4A] text-[#1E7A4A]' : 'border-transparent text-gray-500 hover:text-gray-700'">
                        Reviews
                    </button>
                </div>
            </div>

            <!-- Tab Content -->
            <div class="p-6">
                <!-- Overview Tab -->
                <div x-show="activeTab === 'overview'" x-cloak>
                    <div class="prose prose-sm max-w-none">
                        @if ($post->description)
                            <p class="text-gray-600 leading-relaxed">{{ $post->description }}</p>
                        @endif

                        @if (!empty($post->additional_info) && is_array($post->additional_info))
                            @php
                                $items = $post->additional_info['items'] ?? [];
                                $sectionName = $post->additional_info['section_name'] ?? null;
                            @endphp
                            @if (!empty($items))
                                <div class="mt-4">
                                    @if ($sectionName)
                                        <p class="text-sm font-semibold text-gray-800 mb-2">{{ $sectionName }}</p>
                                    @endif
                                    <ul class="space-y-1.5">
                                        @foreach ($items as $info)
                                            @if (!empty($info['label']) && !empty($info['value']))
                                                <li class="text-sm">
                                                    <span class="text-gray-700 font-medium">{{ $info['label'] }}:</span>
                                                    <span class="text-gray-600">{{ $info['value'] }}</span>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>

                <!-- Reviews Tab - Visual only -->
                <div x-show="activeTab === 'review'" x-cloak>
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        <p class="text-sm text-gray-400">No reviews yet.</p>
                        <p class="text-xs text-gray-400 mt-1">Be the first to review this product!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
</style>