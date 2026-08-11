<div class="min-h-screen bg-[#f5f5f5]" x-data="{ activeTab: 'description' }">
    
    <!-- Alerts -->
    @if (session()->has('message') || session()->has('error'))
        <div class="max-w-7xl mx-auto px-4 pt-4">
            @if (session()->has('message'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm font-medium flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('message') }}
                </div>
            @endif
            @if (session()->has('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm font-medium flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    {{ session('error') }}
                </div>
            @endif
        </div>
    @endif

    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-4 sm:py-6">

        <!-- Breadcrumb -->
        <nav class="flex items-center gap-1.5 text-xs text-gray-400 mb-4 overflow-x-auto whitespace-nowrap">
            <a href="{{ route('customer.dashboard') }}" class="hover:text-[#1E7A4A] transition">Home</a>
            <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
            <a href="#" class="hover:text-[#1E7A4A] transition">{{ $post->type === 'product' ? ($post->productCategory?->name ?? 'Products') : ($post->serviceCategory?->name ?? 'Services') }}</a>
            <svg class="w-3 h-3 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-gray-600 font-medium truncate max-w-40 sm:max-w-xs">{{ $post->name }}</span>
        </nav>

        <!-- Main Product Card -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 p-4 sm:p-6">

                <!-- Left: Images -->
                <div>
                    <div class="relative bg-[#fafafa] rounded-lg overflow-hidden aspect-square border border-gray-200">
                        @if ($currentImage)
                            <img src="{{ Storage::url($currentImage) }}" alt="{{ $post->name }}" class="w-full h-full object-contain p-4">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-300">
                                <svg class="w-20 h-20" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
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
                                    class="absolute left-3 top-1/2 -translate-y-1/2 w-9 h-9 bg-white/90 hover:bg-white border border-gray-200 rounded-full flex items-center justify-center shadow-md transition">
                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </button>
                            <button wire:click="nextImage" 
                                    class="absolute right-3 top-1/2 -translate-y-1/2 w-9 h-9 bg-white/90 hover:bg-white border border-gray-200 rounded-full flex items-center justify-center shadow-md transition">
                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                            <span class="absolute bottom-3 left-1/2 -translate-x-1/2 bg-black/60 text-white text-xs px-3 py-1 rounded-full">
                                {{ $currentImageIndex + 1 }} / {{ count($images) }}
                            </span>
                        @endif
                    </div>

                    <!-- Thumbnails -->
                    @if (count($this->allImages) > 1)
                        <div class="flex gap-2 mt-3 overflow-x-auto pb-1">
                            @foreach ($this->allImages as $index => $img)
                                <button wire:key="thumb-{{ $index }}" wire:click="selectImage({{ $index }})"
                                        class="shrink-0 w-16 h-16 rounded-lg border-2 overflow-hidden transition {{ $currentImage === $img ? 'border-[#1E7A4A]' : 'border-gray-200 hover:border-gray-400' }}">
                                    <img src="{{ Storage::url($img) }}" class="w-full h-full object-cover">
                                </button>
                            @endforeach
                        </div>
                    @endif

                    <!-- Share & Favorite -->
                    <div class="flex items-center gap-4 mt-3 text-sm text-gray-500">
                        <button class="flex items-center gap-1.5 hover:text-[#1E7A4A] transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                            </svg>
                            Share
                        </button>
                        <button class="flex items-center gap-1.5 hover:text-[#1E7A4A] transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                            </svg>
                            Favorite
                        </button>
                    </div>
                </div>

                <!-- Right: Details -->
                <div class="space-y-4">
                    <!-- Shop -->
                    @if ($post->tenant)
                        <div class="flex items-center gap-2 text-sm">
                            <span class="text-gray-500">Shop:</span>
                            <a href="#" class="text-[#1E7A4A] font-medium hover:underline">{{ $post->tenant->name }}</a>
                            <span class="text-xs bg-[#1E7A4A]/10 text-[#1E7A4A] px-2 py-0.5 rounded-full">Official Store</span>
                        </div>
                    @endif

                    <!-- Title -->
                    <h1 class="text-xl sm:text-2xl font-semibold text-gray-900 leading-snug">{{ $post->name }}</h1>

                    <!-- Rating & Stock Labels -->
                    <div class="flex items-center flex-wrap gap-3 text-sm">
                        <div class="flex items-center gap-1">
                            <span class="text-amber-400 text-base">★★★★★</span>
                            <span class="text-gray-500 ml-1">{{ $this->reviewCount }} Ratings</span>
                        </div>
                        <span class="text-gray-300">|</span>
                        <span class="text-gray-500">2K+ Sold</span>

                        {{-- STOCK LABELS --}}
                        @if ($post->type === 'product')
                            <span class="text-gray-300">|</span>
                            @if ($this->stockStatus === 'out')
                                <span class="text-red-500 font-semibold">Out of Stock</span>
                            @elseif ($this->stockStatus === 'low')
                                <span class="text-amber-500 font-semibold">Low Stock</span>
                            @elseif ($this->stockStatus === 'select_required')
                                <span class="text-gray-400 italic">Select variant</span>
                                @else
                
                            <span class="text-sm font-medium text-[#1E7A4A]">{{ $this->stock }} in stock</span>
                            @endif
                        @endif
                    </div>

                    <!-- Price (Always Visible) -->
                    <div class="bg-[#fafafa] rounded-lg p-4 border border-gray-100">
                        <div class="flex items-end gap-3">
                            @php
                                $basePrice = (float) ($post->price ?? 0);
                                $displayPrice = $this->displayPrice;
                                $priceIsAdjusted = $this->selectedVariant && $this->selectedVariant->price_adjustment;
                            @endphp

                            <p class="text-3xl font-bold text-[#1E7A4A]">
                                ₱{{ number_format($displayPrice, 2) }}
                            </p>

                            @if ($priceIsAdjusted && $basePrice > 0 && $basePrice !== $displayPrice)
                                <p class="text-sm text-gray-400 line-through mb-1">₱{{ number_format($basePrice, 2) }}</p>
                            @endif
                        </div>
                    </div>

                    <!-- Errors -->
                    @error('variant') <p class="text-xs text-red-600 font-normal">{{ $message }}</p> @enderror
                    @error('stock') <p class="text-xs text-red-600 font-normal">{{ $message }}</p> @enderror
                    @error('employee') <p class="text-xs text-red-600 font-normal">{{ $message }}</p> @enderror

                    <!-- Product Variants -->
                    @if ($post->type === 'product' && !empty($this->availableOptions))
                        <div class="space-y-4 pt-2 border-t border-gray-100">
                            <p class="text-sm font-medium text-gray-900 mb-2">Select Options </p>
                            @foreach ($this->availableOptions as $attributeName => $values)
                                <div>
                                    <p class="text-sm text-gray-700 mb-2">{{ ucfirst($attributeName) }}</p>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach ($values as $value)
                                            @php
                                                $isSelected = ($selectedAttributes[$attributeName] ?? '') === $value;
                                            @endphp
                                            <button wire:key="attr-{{ $attributeName }}-{{ $value }}"
                                                    wire:click="selectAttributeValue('{{ $attributeName }}', '{{ $value }}')"
                                                    class="px-4 py-2 text-sm font-medium rounded-lg border transition cursor-pointer
                                                        {{ $isSelected 
                                                            ? 'border-[#1E7A4A] bg-[#1E7A4A] text-white shadow-sm ring-1 ring-[#1E7A4A]' 
                                                            : 'border-gray-300 text-gray-700 hover:border-[#1E7A4A] hover:bg-gray-50' }}">
                                                {{ $value }}

                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- Product Quantity & Actions -->
                    @if ($post->type === 'product')
                        <div class="border-t border-gray-100 pt-4 space-y-4">
                            
                            {{-- QUANTITY DISABLED IF VARIANT REQUIRED BUT NOT SELECTED --}}
                            <div class="flex items-center gap-4">
                                <span class="text-sm text-gray-600 font-medium">Quantity</span>
                                @if(!empty($this->availableOptions) && !$this->selectedVariantId)
                                    {{-- Disabled State --}}
                                    <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden opacity-50 cursor-not-allowed">
                                        <button disabled class="px-4 py-2 text-gray-300 cursor-not-allowed">−</button>
                                        <span class="w-12 text-center text-base font-medium bg-gray-50 py-2 text-gray-400">1</span>
                                        <button disabled class="px-4 py-2 text-gray-300 cursor-not-allowed">+</button>
                                    </div>
                                    <span class="text-xs text-gray-400">Select variant first</span>
                                @else
                                    {{-- Active State --}}
                                    <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden">
                                        <button wire:click="decrementQuantity" class="px-4 py-2 hover:bg-gray-50 text-gray-600 transition">−</button>
                                        <span class="w-12 text-center text-base font-medium bg-gray-50 py-2">{{ $quantity }}</span>
                                        <button wire:click="incrementQuantity" class="px-4 py-2 hover:bg-gray-50 text-gray-600 transition">+</button>
                                    </div>
                                @endif
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <button wire:click="addToCart" @if($this->stockStatus === 'out') disabled @endif
                                        class="w-full py-3.5 border-2 border-[#1E7A4A] text-[#1E7A4A] font-semibold rounded-lg hover:bg-[#1E7A4A] hover:text-white transition disabled:opacity-50 disabled:cursor-not-allowed text-sm">
                                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                    </svg>
                                    Add to Cart
                                </button>
                                <button wire:click="buyNow" @if($this->stockStatus === 'out') disabled @endif
                                        class="w-full py-3.5 bg-[#1E7A4A] hover:bg-[#145537] text-white font-semibold rounded-lg transition disabled:opacity-50 disabled:cursor-not-allowed text-sm">
                                    Buy Now
                                </button>
                            </div>
                        </div>
                    @else
                        <!-- Service Booking -->
                        @if (!$this->hasAssignedStaff)
                            <div class="border-t border-gray-100 pt-4">
                                <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 flex items-start gap-3">
                                    <svg class="w-5 h-5 text-amber-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                    <div>
                                        <p class="text-sm font-medium text-amber-800">Currently Unavailable</p>
                                        <p class="text-xs text-amber-700 mt-0.5">No staff have been assigned to this service yet.</p>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="border-t border-gray-100 pt-4 space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Select Date</label>
                                    <div class="flex items-center gap-4 flex-wrap">
                                        <input type="date" wire:model.live="selectedDate" min="{{ now()->toDateString() }}"
                                               class="px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-[#1E7A4A]/30 focus:border-[#1E7A4A] transition">
                                        @php $hours = $this->shopHoursForSelectedDate; @endphp
                                        <span class="inline-flex items-center gap-2 text-sm {{ $hours['open'] ? 'text-emerald-700' : 'text-red-600' }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            {{ $hours['label'] }}
                                        </span>
                                    </div>
                                </div>

                                <div>
                                    <p class="text-sm font-medium text-gray-700 mb-3">Choose Staff</p>
                                    @if ($this->employeeAvailability->isEmpty())
                                        <p class="text-sm text-gray-400">No staff on duty for this date. Try another date.</p>
                                    @else
                                        <div class="space-y-2 max-h-60 overflow-y-auto pr-1">
                                            @foreach ($this->employeeAvailability as $row)
                                                <button wire:key="emp-{{ $row['employee']->id }}" 
                                                        wire:click="selectEmployee({{ $row['employee']->id }})"
                                                        @disabled(!$row['on_duty'])
                                                        class="w-full flex items-center gap-4 p-3 rounded-lg border transition text-left disabled:opacity-40 disabled:cursor-not-allowed {{ $selectedEmployeeId === $row['employee']->id ? 'border-[#1E7A4A] bg-[#1E7A4A]/5' : 'border-gray-200 hover:border-gray-400' }}">
                                                    <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center shrink-0 overflow-hidden border border-gray-200">
                                                        @if ($row['employee']->user?->avatar)
                                                            <img src="{{ Storage::url($row['employee']->user->avatar) }}" class="w-full h-full object-cover">
                                                        @else
                                                            <span class="text-sm font-bold text-gray-600">{{ strtoupper(substr($row['employee']->user?->name ?? 'S', 0, 1)) }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <p class="text-sm font-medium text-gray-800">{{ $row['employee']->user?->name }}</p>
                                                        @if (!$row['on_duty'])
                                                            <p class="text-xs text-gray-400">Not on duty this date</p>
                                                        @elseif ($row['is_busy'])
                                                            <p class="text-xs text-amber-600">Busy — {{ $row['queue_length'] }} in queue</p>
                                                        @else
                                                            <p class="text-xs text-emerald-600 font-medium">Available now</p>
                                                        @endif
                                                    </div>
                                                    @if ($selectedEmployeeId === $row['employee']->id)
                                                        <svg class="w-5 h-5 text-[#1E7A4A]" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                        </svg>
                                                    @endif
                                                </button>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>

                                <button wire:click="bookService" @disabled(!$selectedEmployeeId)
                                        class="w-full py-3.5 bg-[#1E7A4A] hover:bg-[#145537] text-white font-semibold rounded-lg transition disabled:opacity-50 disabled:cursor-not-allowed text-sm">
                                    Book This Service
                                </button>
                            </div>
                        @endif
                    @endif

                    <!-- Trust Badges -->
                    <div class="border-t border-gray-100 pt-4">
                        <div class="flex flex-wrap gap-6 text-xs text-gray-500">
                            <span class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-[#1E7A4A]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                                Authentic
                            </span>
                            <span class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-[#1E7A4A]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                                Secure Payment
                            </span>
                            <span class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-[#1E7A4A]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                </svg>
                                Trusted Seller
                            </span>
                            <span class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-[#1E7A4A]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
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
        <div class="mt-6 bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="border-b border-gray-200 px-6 overflow-x-auto">
                <div class="flex gap-8 min-w-max">
                    <button @click="activeTab = 'description'" 
                            class="py-4 text-sm font-medium border-b-2 -mb-px transition whitespace-nowrap" 
                            :class="activeTab === 'description' ? 'border-[#1E7A4A] text-[#1E7A4A]' : 'border-transparent text-gray-500 hover:text-gray-700'">
                        Product Description
                    </button>
                    <button @click="activeTab = 'specifications'" 
                            class="py-4 text-sm font-medium border-b-2 -mb-px transition whitespace-nowrap"
                            :class="activeTab === 'specifications' ? 'border-[#1E7A4A] text-[#1E7A4A]' : 'border-transparent text-gray-500 hover:text-gray-700'">
                        Specifications
                    </button>
                    <button @click="activeTab = 'reviews'" 
                            class="py-4 text-sm font-medium border-b-2 -mb-px transition flex items-center gap-1.5 whitespace-nowrap"
                            :class="activeTab === 'reviews' ? 'border-[#1E7A4A] text-[#1E7A4A]' : 'border-transparent text-gray-500 hover:text-gray-700'">
                        Reviews
                        <span class="bg-gray-100 text-gray-500 text-xs px-2 py-0.5 rounded-full">{{ $this->reviewCount }}</span>
                    </button>
                </div>
            </div>

            <div class="px-6 py-6">
                <!-- Description Tab -->
                <div x-show="activeTab === 'description'" x-cloak>
                    <div class="max-w-3xl">
                        @if ($post->description)
                            <div class="text-gray-700 leading-relaxed whitespace-pre-wrap text-sm">{{ $post->description }}</div>
                        @endif

                        @if (!empty($post->additional_info) && is_array($post->additional_info))
                            @php
                                $items = $post->additional_info['items'] ?? [];
                                $sectionName = $post->additional_info['section_name'] ?? null;
                            @endphp
                            @if (!empty($items))
                                <div class="mt-4 pt-4 border-t border-gray-100">
                                    @if ($sectionName)
                                        <h4 class="text-sm font-semibold text-gray-800 mb-3">{{ $sectionName }}</h4>
                                    @endif
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-2">
                                        @foreach ($items as $info)
                                            @if (!empty($info['label']) && !empty($info['value']))
                                                <div class="flex items-baseline gap-2 text-sm">
                                                    <span class="text-gray-500 min-w-[80px]">{{ $info['label'] }}:</span>
                                                    <span class="text-gray-800 font-medium">{{ $info['value'] }}</span>
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
                        <div class="bg-gray-50 rounded-lg overflow-hidden border border-gray-200">
                            <table class="w-full text-sm">
                                <tbody>
                                    <tr class="border-b border-gray-200">
                                        <td class="px-4 py-3 text-gray-500 font-medium w-1/3">Category</td>
                                        <td class="px-4 py-3 text-gray-800">{{ $post->type === 'product' ? ($post->productCategory?->name ?? 'N/A') : ($post->serviceCategory?->name ?? 'N/A') }}</td>
                                    </tr>
                                    @if($post->type === 'product')
                                        <tr class="border-b border-gray-200">
                                            <td class="px-4 py-3 text-gray-500 font-medium">Stock</td>
                                            <td class="px-4 py-3 text-gray-800">{{ $this->stock }} available</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td class="px-4 py-3 text-gray-500 font-medium">Type</td>
                                        <td class="px-4 py-3 text-gray-800 capitalize">{{ $post->type }}</td>
                                    </tr>
                                    @if($post->type === 'service')
                                        <tr>
                                            <td class="px-4 py-3 text-gray-500 font-medium">Duration</td>
                                            <td class="px-4 py-3 text-gray-800">{{ $post->duration ?? 'N/A' }}</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Reviews Tab - Empty State Only -->
                <div x-show="activeTab === 'reviews'" x-cloak>
                    <div class="text-center py-12">
                        <div class="w-20 h-20 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"/>
                            </svg>
                        </div>
                        <p class="text-gray-500 text-base font-medium">No reviews yet</p>
                        <p class="text-gray-400 text-sm mt-1">Be the first to review this {{ $post->type }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>[x-cloak] { display: none !important; }</style>