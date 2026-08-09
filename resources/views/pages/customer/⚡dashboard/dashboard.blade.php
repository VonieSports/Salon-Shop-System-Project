<div class="min-h-screen bg-gray-50">
    <div class="mx-auto px-3 sm:px-4 py-4">

        <!-- Compact flat banner (was oversized gradient hero) -->
        <div class="rounded-lg bg-emerald-700 px-6 py-5 mb-4">
            <h1 class="text-lg sm:text-xl font-bold text-white">{{ $shopName ?? 'Style Station' }}</h1>
            <p class="text-emerald-100 text-xs sm:text-sm mt-0.5">Premium beauty products and services from top-rated salons</p>
        </div>

        <!-- Search + filters row -->
        <div class="bg-white rounded-lg border border-gray-200 p-3 mb-4 flex flex-col sm:flex-row gap-2.5">
            <div class="flex-1 relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search products or services..."
                       class="w-full pl-9 pr-3 py-2 bg-gray-50 border border-gray-200 rounded-md focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500 text-sm">
            </div>
            <select wire:model.live="filter" class="px-3 py-2 bg-gray-50 border border-gray-200 rounded-md text-sm">
                <option value="all">All Items</option>
                <option value="products">Products</option>
                <option value="services">Services</option>
            </select>
            <select wire:model.live="sort" class="px-3 py-2 bg-gray-50 border border-gray-200 rounded-md text-sm">
                <option value="newest">Newest</option>
                <option value="price_low">Price: Low to High</option>
                <option value="price_high">Price: High to Low</option>
            </select>
        </div>

        <!-- Category chips -->
        <div class="flex flex-wrap gap-1.5 mb-4">
            <button wire:click="$set('selectedCategory', null)"
                    class="px-3 py-1.5 rounded text-xs font-medium transition {{ is_null($selectedCategory) ? 'bg-emerald-700 text-white' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">
                All Categories
            </button>
            @foreach($this->categories as $category)
                <button wire:click="$set('selectedCategory', {{ $category->id }})"
                        class="px-3 py-1.5 rounded text-xs font-medium transition {{ $selectedCategory == $category->id ? 'bg-emerald-700 text-white' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }}">
                    {{ $category->name }}
                </button>
            @endforeach
        </div>

        <p class="text-xs text-gray-400 mb-3">
            Showing {{ $this->items->firstItem() ?? 0 }}–{{ $this->items->lastItem() ?? 0 }} of {{ $this->items->total() }} results
        </p>

        @if($this->items->isEmpty())
            <div class="text-center py-16 bg-white rounded-lg border border-gray-200">
                <p class="text-sm text-gray-500">No items found</p>
            </div>
        @else
            <!-- Product grid — Shopee-style 6-col at wide, square image, compact card padding -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-2.5">
                @foreach($this->items as $post)
                    @php
                        $costPrice = $post->inventory?->cost_price;
                        $sellingPrice = $post->price;
                        $discountPercent = ($costPrice && $sellingPrice && $sellingPrice > $costPrice)
                            ? round((($sellingPrice - $costPrice) / $sellingPrice) * 100)
                            : null;
                    @endphp
                    <a href="{{ route('customer.item_detail', $post->id) }}"
                       class="group bg-white rounded-md border border-gray-200 overflow-hidden hover:shadow-md transition">
                        <div class="relative aspect-square bg-gray-50 overflow-hidden">
                            @if($post->image)
                                <img src="{{ Storage::url($post->image) }}" alt="{{ $post->name }}"
                                     class="w-full h-full object-cover group-hover:scale-[1.03] transition-transform duration-200">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-300">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif

                            <button wire:click.stop.prevent="toggleFavorite({{ $post->id }})"
                                    class="absolute top-1.5 right-1.5 w-6 h-6 bg-white/95 rounded-full flex items-center justify-center shadow-sm">
                                <svg class="w-3.5 h-3.5 {{ $this->isFavorite($post->id) ? 'text-red-500' : 'text-gray-400' }}"
                                     fill="{{ $this->isFavorite($post->id) ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                            </button>

                            @if ($discountPercent && $discountPercent > 0)
                                <span class="absolute top-1.5 left-1.5 px-1.5 py-0.5 bg-red-500 text-white text-[10px] font-bold rounded">
                                    -{{ $discountPercent }}%
                                </span>
                            @endif
                        </div>

                        <div class="p-2">
                            <h3 class="text-xs text-gray-800 line-clamp-2 leading-snug min-h-[2rem]">{{ $post->name }}</h3>
                            <p class="text-sm font-bold text-emerald-700 mt-1">${{ number_format($post->price ?? 0, 2) }}</p>
                            <p class="text-[10px] text-gray-400 mt-0.5 truncate">{{ $post->tenant->name ?? 'Unknown Shop' }}</p>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-6">{{ $this->items->links() }}</div>
        @endif
    </div>
</div>