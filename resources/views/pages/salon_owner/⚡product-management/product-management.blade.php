<div class="min-h-screen bg-gray-50">
    <div class="mx-auto space-y-6">

        @if (session()->has('message'))
        <div class="bg-green-50 text-green-700 px-5 py-3.5 rounded-xl text-sm font-medium">{{ session('message') }}
        </div>
        @endif
        @if (session()->has('error'))
        <div class="bg-red-50 text-red-700 px-5 py-3.5 rounded-xl text-sm font-medium">{{ session('error') }}</div>
        @endif

        <div class="flex items-start justify-between flex-wrap gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Products</h1>
                <p class="text-gray-500 text-sm mt-1">Manage your product catalog</p>
            </div>
            <a href="{{ route('owner.create_product') }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#1E7A4A] text-white rounded-full hover:bg-[#16633c] transition text-sm font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                New Product
            </a>
        </div>

        <div class="flex flex-col sm:flex-row gap-3">
            <select wire:model.live="dateFilter"
                class="px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#1E7A4A]/30 focus:border-[#1E7A4A]/30 transition text-sm">
                <option value="all">All Time</option>
                <option value="today">Today</option>
                <option value="week">This Week</option>
                <option value="month">This Month</option>
                <option value="custom">Custom Range</option>
            </select>

            @if ($dateFilter === 'custom')
            <input type="date" wire:model.live="customDateFrom"
                class="px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#1E7A4A]/30 focus:border-[#1E7A4A]/30 transition text-sm">
            <input type="date" wire:model.live="customDateTo"
                class="px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#1E7A4A]/30 focus:border-[#1E7A4A]/30 transition text-sm">
            @endif

            <div class="relative flex-1">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none"
                    stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" wire:model.live.debounce.400ms="search" placeholder="Search products..."
                    class="w-full pl-11 pr-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#1E7A4A]/30 focus:border-[#1E7A4A]/30 transition text-sm">
            </div>
        </div>

        @if ($this->items->isEmpty())
        <div class="bg-white rounded-2xl border border-gray-100 p-16 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
            <p class="mt-3 text-sm text-gray-500">No products found</p>
        </div>
        @else
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

            <div class="px-5 py-3.5 bg-gray-50 border-b border-gray-100 flex items-center gap-3">
                <input type="checkbox" wire:model.live="selectAll" wire:change="toggleSelectAll"
                    class="w-4 h-4 rounded border-gray-300 text-[#1E7A4A] focus:ring-[#1E7A4A]">
                <span class="text-sm text-gray-500">
                    @if (count($selectedIds) > 0)
                    {{ count($selectedIds) }} selected
                    @else
                    Select all <span class="text-gray-400"></span>
                    @endif
                </span>

                @if (count($selectedIds) > 0)
                <button wire:click="bulkDelete"
                    wire:confirm="Archive {{ count($selectedIds) }} selected product(s)? You can restore them later from the Archive page."
                    class="ml-auto inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition text-xs font-semibold">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Delete Selected
                </button>
                @endif
            </div>

            <div class="divide-y divide-gray-100">
                @foreach ($this->items as $item)
                <div wire:key="item-{{ $item->id }}"
                    class="flex items-center gap-4 px-5 py-3.5 hover:bg-gray-50 transition">
                    <input type="checkbox" wire:model.live="selectedIds" value="{{ $item->id }}"
                        class="w-4 h-4 rounded border-gray-300 text-[#1E7A4A] focus:ring-[#1E7A4A] shrink-0">

                    <button type="button" wire:click="viewItem({{ $item->id }})"
                        class="group flex items-center gap-4 flex-1 min-w-0 text-left">
                        <div class="w-12 h-12 rounded-lg bg-gray-100 overflow-hidden shrink-0">
                            @if($item->image)
                            <img src="{{ Storage::url($item->image) }}" alt="{{ $item->name }}"
                                class="w-full h-full object-cover">
                            @else
                            <div class="w-full h-full flex items-center justify-center text-gray-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M4 8h16M4 4h16a1 1 0 011 1v14a1 1 0 01-1 1H4a1 1 0 01-1-1V5a1 1 0 011-1z" />
                                </svg>
                            </div>
                            @endif
                        </div>

                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-900 truncate">{{ $item->name }}</p>
                            <p class="text-xs text-gray-400 mt-0.5 truncate">{{ $item->productCategory?->name ??
                                'Uncategorized' }} &bull; {{ $item->created_at->format('M j, Y') }}</p>
                        </div>
                        <span class="text-sm font-bold text-gray-900 shrink-0">${{ number_format($item->price ?? 0, 2)
                            }}</span>
                        <span
                            class="px-2 py-0.5 text-[10px] font-semibold rounded-full shrink-0 {{ $item->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ ucfirst($item->status) }}
                        </span>
                        <svg class="w-5 h-5 text-gray-300 group-hover:text-[#1E7A4A] transition shrink-0" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                </div>
                @endforeach
            </div>
        </div>
        <div>{{ $this->items->links() }}</div>
        @endif
    </div>
    @include('layouts.partials.product-detail-modal')
</div>