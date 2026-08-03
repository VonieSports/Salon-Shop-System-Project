<div class="min-h-screen bg-gray-50">
    <div class="max-w-[1400px] mx-auto px-3 sm:px-4 lg:px-6 py-4 sm:py-6">
        
        <!-- Hero Banner -->
        <div class="relative rounded-2xl overflow-hidden mb-6 sm:mb-8 bg-gradient-to-r from-emerald-600 to-emerald-800">
            <div class="absolute inset-0 opacity-10">
                <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <pattern id="grid" width="20" height="20" patternUnits="userSpaceOnUse">
                        <circle cx="10" cy="10" r="2" fill="white"/>
                    </pattern>
                    <rect width="100" height="100" fill="url(#grid)"/>
                </svg>
            </div>
            <div class="relative z-10 px-6 sm:px-8 lg:px-12 py-8 sm:py-12 lg:py-16">
                <div class="max-w-2xl">
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-white mb-2">
                        Welcome to Style Station
                    </h1>
                    <p class="text-emerald-100 text-sm sm:text-base mb-4">
                        Discover premium beauty products and services from top-rated salons
                    </p>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-white text-xs font-medium">
                            ✨ 500+ Products
                        </span>
                        <span class="px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-white text-xs font-medium">
                            🏆 Top Rated Salons
                        </span>
                        <span class="px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-white text-xs font-medium">
                            🚀 Fast Delivery
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search & Filters -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6">
            <div class="flex flex-col sm:flex-row gap-3">
                <!-- Search -->
                <div class="flex-1 relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" 
                           wire:model.live.debounce.300ms="search"
                           placeholder="Search products, services, or salons..."
                           class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-sm">
                </div>

                <!-- Filters -->
                <div class="flex flex-wrap gap-2">
                    <select wire:model.live="filter" 
                            class="px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500">
                        <option value="all">All Items</option>
                        <option value="products">Products</option>
                        <option value="services">Services</option>
                    </select>

                    <select wire:model.live="sort" 
                            class="px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500">
                        <option value="newest">Newest</option>
                        <option value="price_low">Price: Low to High</option>
                        <option value="price_high">Price: High to Low</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Category Pills -->
        <div class="flex flex-wrap gap-2 mb-6">
            <button wire:click="$set('selectedCategory', null)" 
                    class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ is_null($selectedCategory) ? 'bg-emerald-600 text-white shadow-md shadow-emerald-200' : 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-200' }}">
                All Categories
            </button>
            @foreach($this->categories as $category)
                <button wire:click="$set('selectedCategory', {{ $category->id }})" 
                        class="px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ $selectedCategory == $category->id ? 'bg-emerald-600 text-white shadow-md shadow-emerald-200' : 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-200' }}">
                    {{ $category->name }}
                </button>
            @endforeach
        </div>

        <!-- Results Count -->
        <div class="flex items-center justify-between mb-4">
            <p class="text-sm text-gray-500">
                Showing <span class="font-semibold text-gray-700">{{ $this->items->firstItem() ?? 0 }}</span> - 
                <span class="font-semibold text-gray-700">{{ $this->items->lastItem() ?? 0 }}</span> 
                of <span class="font-semibold text-gray-700">{{ $this->items->total() }}</span> results
            </p>
        </div>

        <!-- Product Grid -->
        @if($this->items->isEmpty())
            <div class="text-center py-16 bg-white rounded-xl border border-gray-100">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">No items found</h3>
                <p class="text-sm text-gray-500">Try adjusting your search or filters</p>
            </div>
        @else
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3 sm:gap-4">
                @foreach($this->items as $post)
                    <a href="{{ route('customer.item_detail', $post->id) }}" 
                       class="group bg-white rounded-xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                        <!-- Image Container -->
                        <div class="relative aspect-square bg-gray-100 overflow-hidden">
                            @if($post->image)
                                <img src="{{ Storage::url($post->image) }}" 
                                     alt="{{ $post->name }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-300">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            @endif

                            <!-- Favorite Button -->
                            <button wire:click.stop="toggleFavorite({{ $post->id }})" 
                                    class="absolute top-2 right-2 w-8 h-8 bg-white/90 backdrop-blur-sm rounded-full flex items-center justify-center shadow-sm hover:scale-110 transition-transform">
                                <svg class="w-4 h-4 {{ $this->isFavorite($post->id) ? 'text-red-500 fill-red-500' : 'text-gray-400' }}" 
                                     fill="{{ $this->isFavorite($post->id) ? 'currentColor' : 'none' }}" 
                                     stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                            </button>

                            <!-- Badges -->
                            <div class="absolute bottom-2 left-2 flex flex-wrap gap-1">
                                @if($post->type === 'product')
                                    <span class="px-2 py-0.5 bg-emerald-600 text-white text-[10px] font-medium rounded">Product</span>
                                @else
                                    <span class="px-2 py-0.5 bg-purple-600 text-white text-[10px] font-medium rounded">Service</span>
                                @endif
                                @if($post->created_at->diffInDays(now()) < 7)
                                    <span class="px-2 py-0.5 bg-red-500 text-white text-[10px] font-medium rounded animate-pulse">New</span>
                                @endif
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-3">
                            <h3 class="text-sm font-semibold text-gray-900 line-clamp-2 mb-1 group-hover:text-emerald-600 transition">
                                {{ $post->name }}
                            </h3>
                            
                            <div class="flex items-center gap-1.5 mb-1">
                                <span class="text-xs text-gray-500">{{ $post->tenant->name ?? 'Unknown Shop' }}</span>
                                <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                <span class="text-xs text-gray-400">{{ $post->productCategory?->name ?? $post->serviceCategory?->name ?? 'Uncategorized' }}</span>
                            </div>

                            <div class="flex items-center justify-between mt-2">
                                <div>
                                    <span class="text-base font-bold text-emerald-600">${{ number_format($post->price ?? 0, 2) }}</span>
                                    @if($post->type === 'product' && $post->inventory && $post->inventory->stock > 0)
                                        <span class="text-[10px] text-gray-400 block">In Stock</span>
                                    @endif
                                </div>
                                <button class="px-3 py-1.5 bg-emerald-600 text-white text-xs font-medium rounded-lg hover:bg-emerald-700 transition">
                                    View
                                </button>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $this->items->links() }}
            </div>
        @endif
    </div>
</div>