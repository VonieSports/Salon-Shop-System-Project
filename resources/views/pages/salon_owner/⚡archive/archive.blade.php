<div>
    <div class="min-h-screen bg-gray-50">
    <div class="mx-auto space-y-6">

        @if (session()->has('message'))
            <div class="bg-green-50 text-green-700 px-5 py-3.5 rounded-xl text-sm font-medium">{{ session('message') }}</div>
        @endif
        @if (session()->has('error'))
            <div class="bg-red-50 text-red-700 px-5 py-3.5 rounded-xl text-sm font-medium">{{ session('error') }}</div>
        @endif

        <div>
            <h1 class="text-2xl font-bold text-gray-900">Archive</h1>
            <p class="text-gray-500 text-sm mt-1">Restore deleted products and services, or remove them permanently</p>
        </div>

        <div class="flex flex-col sm:flex-row gap-3">
            <div class="inline-flex bg-white border border-gray-200 rounded-xl p-1">
                <button wire:click="$set('typeFilter', 'all')" class="px-4 py-2 rounded-lg text-sm font-medium transition {{ $typeFilter === 'all' ? 'bg-[#1E7A4A] text-white' : 'text-gray-600 hover:bg-gray-50' }}">All</button>
                <button wire:click="$set('typeFilter', 'product')" class="px-4 py-2 rounded-lg text-sm font-medium transition {{ $typeFilter === 'product' ? 'bg-[#1E7A4A] text-white' : 'text-gray-600 hover:bg-gray-50' }}">Products</button>
                <button wire:click="$set('typeFilter', 'service')" class="px-4 py-2 rounded-lg text-sm font-medium transition {{ $typeFilter === 'service' ? 'bg-[#1E7A4A] text-white' : 'text-gray-600 hover:bg-gray-50' }}">Services</button>
            </div>

            <div class="relative flex-1">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" wire:model.live.debounce.400ms="search" placeholder="Search archive..."
                       class="w-full pl-11 pr-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#1E7A4A]/30 focus:border-[#1E7A4A]/30 transition text-sm">
            </div>
        </div>

        @if ($this->items->isEmpty())
            <div class="bg-white rounded-2xl border border-gray-100 p-16 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0H4"/>
                </svg>
                <p class="mt-3 text-sm text-gray-500">Archive is empty</p>
                <p class="text-xs text-gray-400 mt-1">Items you delete from Products or Services will appear here</p>
            </div>
        @else
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

                <div class="px-5 py-3.5 bg-gray-50 border-b border-gray-100 flex items-center gap-3 flex-wrap">
                    <input type="checkbox" wire:model.live="selectAll" wire:change="toggleSelectAll"
                           class="w-4 h-4 rounded border-gray-300 text-[#1E7A4A] focus:ring-[#1E7A4A]">
                    <span class="text-sm text-gray-500">
                        @if (count($selectedIds) > 0)
                            {{ count($selectedIds) }} selected
                        @else
                            Select all <span class="text-gray-400">(this page)</span>
                        @endif
                    </span>

                    @if (count($selectedIds) > 0)
                        <div class="ml-auto flex items-center gap-2">
                            <button wire:click="bulkRestore"
                                    wire:confirm="Restore {{ count($selectedIds) }} selected item(s)?"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 text-emerald-700 rounded-lg hover:bg-emerald-100 transition text-xs font-semibold">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                Restore Selected
                            </button>
                            <button wire:click="bulkDeleteForever"
                                    wire:confirm="Permanently delete {{ count($selectedIds) }} selected item(s)? This CANNOT be undone."
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition text-xs font-semibold">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Delete Forever
                            </button>
                        </div>
                    @endif
                </div>

                <div class="divide-y divide-gray-100">
                    @foreach ($this->items as $item)
                        <div wire:key="archived-{{ $item->id }}" class="flex items-center gap-4 px-5 py-3.5 hover:bg-gray-50 transition">
                            <input type="checkbox" wire:model.live="selectedIds" value="{{ $item->id }}"
                                   class="w-4 h-4 rounded border-gray-300 text-[#1E7A4A] focus:ring-[#1E7A4A] shrink-0">

                            <div class="w-12 h-12 rounded-lg bg-gray-100 overflow-hidden shrink-0">
                                @if($item->image)
                                    <img src="{{ Storage::url($item->image) }}" alt="{{ $item->name }}" class="w-full h-full object-cover opacity-75">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M4 8h16M4 4h16a1 1 0 011 1v14a1 1 0 01-1 1H4a1 1 0 01-1-1V5a1 1 0 011-1z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2">
                                    <p class="text-sm font-semibold text-gray-900 truncate">{{ $item->name }}</p>
                                    <span class="px-1.5 py-0.5 text-[9px] font-bold uppercase tracking-wide rounded shrink-0 {{ $item->type === 'product' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">
                                        {{ $item->type }}
                                    </span>
                                </div>
                                <p class="text-xs text-gray-400 mt-0.5 truncate">
                                    {{ $item->productCategory?->name ?? $item->serviceCategory?->name ?? 'Uncategorized' }}
                                    &bull; Archived {{ $item->archived_at->diffForHumans() }}
                                </p>
                            </div>

                            <span class="text-sm font-bold text-gray-900 shrink-0">${{ number_format($item->price ?? 0, 2) }}</span>

                            <div class="flex items-center gap-1.5 shrink-0">
                                <button wire:click="restoreItem({{ $item->id }})"
                                        wire:confirm="Restore this {{ $item->type }}?"
                                        title="Restore"
                                        class="p-2 rounded-lg text-emerald-600 hover:bg-emerald-50 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                </button>
                                <button wire:click="deleteForever({{ $item->id }})"
                                        wire:confirm="Permanently delete this {{ $item->type }}? This CANNOT be undone."
                                        title="Delete Forever"
                                        class="p-2 rounded-lg text-red-500 hover:bg-red-50 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div>{{ $this->items->links() }}</div>
        @endif

    </div>
</div>
</div>