<!-- resources/views/livewire/pages/customer/bookings-listing.blade.php -->
<div class="min-h-screen bg-[#F5F5F5]">
    <div class="max-w-7xl mx-auto px-3 sm:px-4 py-4 sm:py-6">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
            <div>
                <h1 class="text-2xl font-semibold text-[#222]">Bookings Directory</h1>
                <p class="text-sm text-[#666] mt-0.5">Browse all service bookings from our community</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-sm text-[#666]">
                    <span class="font-medium text-[#222]">{{ $this->stats['total'] }}</span> total bookings
                </span>
                <a href="{{ route('customer.dashboard') }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 bg-[#D6657A] hover:bg-[#C25467] text-white text-sm font-medium rounded-lg transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Book Now
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-6">
            <div class="bg-white rounded-lg shadow-sm border border-[#EFEFEF] p-3 text-center">
                <p class="text-xl font-bold text-[#D6657A]">{{ $this->stats['total'] }}</p>
                <p class="text-xs text-[#666]">Total</p>
            </div>
            <div class="bg-white rounded-lg shadow-sm border border-[#EFEFEF] p-3 text-center">
                <p class="text-xl font-bold text-amber-500">{{ $this->stats['queued'] }}</p>
                <p class="text-xs text-[#666]">Queued</p>
            </div>
            <div class="bg-white rounded-lg shadow-sm border border-[#EFEFEF] p-3 text-center">
                <p class="text-xl font-bold text-blue-500">{{ $this->stats['in_progress'] }}</p>
                <p class="text-xs text-[#666]">In Progress</p>
            </div>
            <div class="bg-white rounded-lg shadow-sm border border-[#EFEFEF] p-3 text-center">
                <p class="text-xl font-bold text-emerald-500">{{ $this->stats['completed'] }}</p>
                <p class="text-xs text-[#666]">Completed</p>
            </div>
        </div>

        <!-- Hotel-Style Layout: Sidebar + Content -->
        <div class="flex flex-col lg:flex-row gap-6">
            
            <!-- LEFT SIDEBAR - Filters -->
            <div class="lg:w-72 flex-shrink-0">
                <div class="bg-white rounded-lg shadow-sm border border-[#EFEFEF] p-4 sticky top-4">
                    
                    <!-- Filter Header -->
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-semibold text-[#222]">Filters</h3>
                        <button wire:click="clearFilters" 
                                class="text-xs text-[#D6657A] hover:underline transition">
                            Clear All
                        </button>
                    </div>

                    <!-- Search -->
                    <div class="mb-4">
                        <label class="text-xs font-medium text-[#666] block mb-1.5">Search</label>
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-[#999]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <input type="text" wire:model.live.debounce.300ms="search" 
                                   placeholder="Search by service, shop, customer..." 
                                   class="w-full pl-9 pr-3 py-2 bg-[#F5F5F5] border-0 rounded-lg focus:ring-2 focus:ring-[#D6657A]/30 text-sm placeholder:text-[#999]">
                        </div>
                    </div>

                    <!-- Status Filter -->
                    <div class="mb-4">
                        <label class="text-xs font-medium text-[#666] block mb-1.5">Status</label>
                        <div class="space-y-1.5">
                            @foreach([
                                ['value' => 'all', 'label' => 'All Statuses', 'count' => $this->stats['total']],
                                ['value' => 'queued', 'label' => 'Queued', 'count' => $this->stats['queued']],
                                ['value' => 'in_progress', 'label' => 'In Progress', 'count' => $this->stats['in_progress']],
                                ['value' => 'completed', 'label' => 'Completed', 'count' => $this->stats['completed']],
                            ] as $option)
                                <label class="flex items-center justify-between cursor-pointer hover:bg-[#F5F5F5] px-2 py-1 rounded transition">
                                    <div class="flex items-center gap-2">
                                        <input type="radio" 
                                               wire:model.live="statusFilter" 
                                               value="{{ $option['value'] }}"
                                               class="w-3.5 h-3.5 text-[#D6657A] focus:ring-[#D6657A]/30">
                                        <span class="text-sm text-[#333]">{{ $option['label'] }}</span>
                                    </div>
                                    <span class="text-xs text-[#999]">{{ $option['count'] }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Shop Filter -->
                    @if($this->shops->isNotEmpty())
                        <div class="mb-4">
                            <label class="text-xs font-medium text-[#666] block mb-1.5">Shop</label>
                            <div class="space-y-1.5 max-h-32 overflow-y-auto">
                                <label class="flex items-center gap-2 cursor-pointer hover:bg-[#F5F5F5] px-2 py-1 rounded transition">
                                    <input type="radio" 
                                           wire:model.live="shopFilter" 
                                           value=""
                                           class="w-3.5 h-3.5 text-[#D6657A] focus:ring-[#D6657A]/30">
                                    <span class="text-sm text-[#333]">All Shops</span>
                                </label>
                                @foreach($this->shops as $shop)
                                    <label class="flex items-center gap-2 cursor-pointer hover:bg-[#F5F5F5] px-2 py-1 rounded transition">
                                        <input type="radio" 
                                               wire:model.live="shopFilter" 
                                               value="{{ $shop->id }}"
                                               class="w-3.5 h-3.5 text-[#D6657A] focus:ring-[#D6657A]/30">
                                        <span class="text-sm text-[#333] truncate">{{ $shop->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Service Filter -->
                    @if($this->services->isNotEmpty())
                        <div class="mb-4">
                            <label class="text-xs font-medium text-[#666] block mb-1.5">Service</label>
                            <div class="space-y-1.5 max-h-32 overflow-y-auto">
                                <label class="flex items-center gap-2 cursor-pointer hover:bg-[#F5F5F5] px-2 py-1 rounded transition">
                                    <input type="radio" 
                                           wire:model.live="serviceFilter" 
                                           value=""
                                           class="w-3.5 h-3.5 text-[#D6657A] focus:ring-[#D6657A]/30">
                                    <span class="text-sm text-[#333]">All Services</span>
                                </label>
                                @foreach($this->services as $service)
                                    <label class="flex items-center gap-2 cursor-pointer hover:bg-[#F5F5F5] px-2 py-1 rounded transition">
                                        <input type="radio" 
                                               wire:model.live="serviceFilter" 
                                               value="{{ $service->id }}"
                                               class="w-3.5 h-3.5 text-[#D6657A] focus:ring-[#D6657A]/30">
                                        <span class="text-sm text-[#333] truncate">{{ $service->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Sort -->
                    <div>
                        <label class="text-xs font-medium text-[#666] block mb-1.5">Sort By</label>
                        <select wire:model.live="sort" 
                                class="w-full px-3 py-2 bg-[#F5F5F5] border-0 rounded-lg focus:ring-2 focus:ring-[#D6657A]/30 text-sm text-[#333]">
                            <option value="newest">Newest First</option>
                            <option value="oldest">Oldest First</option>
                            <option value="price_high">Price: High to Low</option>
                            <option value="price_low">Price: Low to High</option>
                        </select>
                    </div>

                    <!-- Trust Badges -->
                    <div class="mt-4 pt-4 border-t border-[#EFEFEF]">
                        <div class="space-y-2">
                            <div class="flex items-center gap-2 text-xs text-[#666]">
                                <svg class="w-4 h-4 text-[#D6657A]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                                Verified Bookings
                            </div>
                            <div class="flex items-center gap-2 text-xs text-[#666]">
                                <svg class="w-4 h-4 text-[#D6657A]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                                Secure Platform
                            </div>
                            <div class="flex items-center gap-2 text-xs text-[#666]">
                                <svg class="w-4 h-4 text-[#D6657A]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Real-time Updates
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT CONTENT - Bookings Grid -->
            <div class="flex-1 min-w-0">
                
                <!-- Results Header -->
                <div class="flex items-center justify-between mb-4">
                    <p class="text-sm text-[#666]">
                        <span class="font-medium text-[#222]">{{ $this->bookings->total() }}</span> bookings found
                    </p>
                    <div class="flex items-center gap-2 text-xs text-[#666]">
                        <span>Showing {{ $this->bookings->firstItem() ?? 0 }} - {{ $this->bookings->lastItem() ?? 0 }}</span>
                    </div>
                </div>

                <!-- Bookings Grid -->
                @if($this->bookings->isEmpty())
                    <div class="bg-white rounded-lg shadow-sm border border-[#EFEFEF] p-12 text-center">
                        <div class="w-20 h-20 mx-auto mb-4 bg-[#FCE9ED] rounded-full flex items-center justify-center">
                            <svg class="w-10 h-10 text-[#D6657A]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-[#222]">No bookings found</h3>
                        <p class="text-sm text-[#666] mt-1">Try adjusting your filters or check back later</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
                        @foreach($this->bookings as $booking)
                            @php
                                $badge = $this->getStatusBadge($booking->status);
                                $image = $this->getServiceImage($booking);
                                $name = $this->getServiceName($booking);
                                $price = $this->getServicePrice($booking);
                                $duration = $this->getServiceDuration($booking);
                                $customer = $this->getCustomerName($booking);
                                $date = Carbon\Carbon::parse($booking->appointment_date);
                            @endphp
                            
                            <div class="bg-white rounded-lg shadow-sm border border-[#EFEFEF] overflow-hidden hover:shadow-md transition group">
                                <!-- Image -->
                                <div class="relative h-48 bg-[#FAFAFA] overflow-hidden">
                                    @if($image)
                                        <img src="{{ Storage::url($image) }}" 
                                             alt="{{ $name }}" 
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-[#D6657A]/30">
                                            <svg class="w-16 h-16" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                    
                                    <!-- Status Badge -->
                                    <span class="absolute top-3 left-3 inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-medium border {{ $badge['bg'] }} {{ $badge['text'] }} {{ $badge['border'] }}">
                                        {{ $badge['label'] }}
                                    </span>
                                    
                                    <!-- Duration Badge -->
                                    <span class="absolute bottom-3 left-3 inline-flex items-center gap-1 px-2 py-0.5 bg-[#1A1A1A]/80 text-white text-[10px] font-medium rounded-full backdrop-blur-sm">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        {{ $duration }} min
                                    </span>

                                    <!-- Price Badge -->
                                    <span class="absolute bottom-3 right-3 inline-flex items-center gap-1 px-2.5 py-0.5 bg-[#D6657A] text-white text-xs font-bold rounded-full shadow-sm">
                                        ₱{{ number_format($price, 2) }}
                                    </span>
                                </div>

                                <!-- Content -->
                                <div class="p-4">
                                    <h3 class="text-sm font-medium text-[#222] line-clamp-2 min-h-[40px]">{{ $name }}</h3>
                                    
                                    <!-- Customer -->
                                    <p class="text-xs text-[#999] mt-1 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        {{ $customer }}
                                    </p>

                                    <!-- Shop Info -->
                                    @if($booking->tenant)
                                        <p class="text-xs text-[#999] flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                            </svg>
                                            {{ $booking->tenant->name }}
                                        </p>
                                    @endif

                                    <!-- Date & Staff -->
                                    <div class="flex items-center gap-3 text-xs text-[#666] mt-2">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            {{ $date->format('M d, Y') }}
                                        </span>
                                        @if($booking->employee)
                                            <span class="flex items-center gap-1">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                </svg>
                                                {{ $booking->employee->user?->name ?? 'Staff' }}
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Actions -->
                                    <div class="flex items-center justify-end mt-3 pt-3 border-t border-[#EFEFEF]">
                                        <a href="#" class="text-xs text-[#D6657A] hover:underline font-medium">
                                            View Details →
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $this->bookings->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>