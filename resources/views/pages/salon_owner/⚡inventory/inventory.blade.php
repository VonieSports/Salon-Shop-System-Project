<div>
    <div class="min-h-screen bg-gray-50">
        <div class="mx-auto space-y-6">

            @if (session()->has('message'))
                <div class="bg-green-50 text-green-700 px-5 py-3.5 rounded-xl text-sm font-medium">{{ session('message') }}</div>
            @endif
            @if (session()->has('error'))
                <div class="bg-red-50 text-red-700 px-5 py-3.5 rounded-xl text-sm font-medium">{{ session('error') }}</div>
            @endif

            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Inventory</h1>
                    <p class="text-gray-500 text-sm mt-1">Track stock levels and movement history</p>
                </div>
                <a href="{{ route('owner.create_product') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#1E7A4A] text-white rounded-xl hover:bg-[#16633c] transition text-sm font-medium shadow-sm whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                    </svg>
                    Create Product
                </a>
            </div>

            <!-- Stat cards — #1E7A4A themed -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-[#1E7A4A]/10 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-[#1E7A4A]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs text-gray-400 uppercase tracking-wide truncate">Total Products</p>
                        <p class="text-xl font-bold text-[#1E7A4A] mt-0.5">{{ $this->stats['total'] }}</p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-[#1E7A4A]/10 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-[#1E7A4A]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs text-gray-400 uppercase tracking-wide truncate">Total Stock</p>
                        <p class="text-xl font-bold text-[#1E7A4A] mt-0.5">{{ number_format($this->stats['total_stock']) }}</p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-[#1E7A4A]/10 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-[#1E7A4A]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs text-gray-400 uppercase tracking-wide truncate">Available Categories</p>
                        <p class="text-xl font-bold text-[#1E7A4A] mt-0.5">{{ $this->stats['available_categories'] }}</p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-[#1E7A4A]/10 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-[#1E7A4A]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 13h6m-3-3v6m5.5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-xs text-gray-400 uppercase tracking-wide truncate">Draft</p>
                        <p class="text-xl font-bold text-[#1E7A4A] mt-0.5">{{ $this->stats['draft'] }}</p>
                    </div>
                </div>
            </div>

            <div class="inline-flex bg-white border border-gray-200 rounded-xl p-1">
                <button wire:click="$set('activeTab', 'stock')" class="px-4 py-2 rounded-lg text-sm font-medium transition {{ $activeTab === 'stock' ? 'bg-[#1E7A4A] text-white' : 'text-gray-600 hover:bg-gray-50' }}">Stock Levels</button>
                <button wire:click="$set('activeTab', 'history')" class="px-4 py-2 rounded-lg text-sm font-medium transition {{ $activeTab === 'history' ? 'bg-[#1E7A4A] text-white' : 'text-gray-600 hover:bg-gray-50' }}">Movement History</button>
            </div>

            @if ($activeTab === 'stock')
                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="relative flex-1">
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input type="text" wire:model.live.debounce.400ms="search" placeholder="Search by name or SKU..."
                               class="w-full pl-11 pr-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#1E7A4A]/30 focus:border-[#1E7A4A]/30 transition text-sm">
                    </div>
                    <select wire:model.live="stockFilter"
                            class="px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#1E7A4A]/30 focus:border-[#1E7A4A]/30 transition text-sm">
                        <option value="all">All Stock</option>
                        <option value="low">Low Stock</option>
                        <option value="out">Out of Stock</option>
                    </select>
                </div>

                @if ($this->products->isEmpty())
                    <div class="bg-white rounded-2xl border border-gray-100 p-16 text-center">
                        <p class="text-sm text-gray-500">No products found</p>
                        <a href="{{ route('owner.create_product') }}" class="text-[#1E7A4A] hover:underline text-sm font-medium mt-2 inline-block">Create your first product</a>
                    </div>
                @else
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-100">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SKU</th>
                                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Updated</th>
                                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    @foreach ($this->products as $product)
                                        <tr wire:key="product-{{ $product->id }}" class="hover:bg-gray-50/60 transition">
                                            <td class="px-5 py-3.5">
                                                <div class="flex items-center gap-3 cursor-pointer" wire:click="viewProductById({{ $product->id }})">
                                                    @if($product->image)
                                                        <img src="{{ Storage::url($product->image) }}" class="h-10 w-10 rounded-lg object-cover shrink-0">
                                                    @else
                                                        <div class="h-10 w-10 bg-gray-100 rounded-lg flex items-center justify-center shrink-0">
                                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M4 8h16M4 4h16a1 1 0 011 1v14a1 1 0 01-1 1H4a1 1 0 01-1-1V5a1 1 0 011-1z"/>
                                                            </svg>
                                                        </div>
                                                    @endif
                                                    <div class="min-w-0">
                                                        <p class="text-sm font-medium text-gray-900 hover:text-[#1E7A4A] transition truncate">{{ $product->name }}</p>
                                                        <p class="text-xs text-gray-400 truncate">
                                                            {{ $product->productCategory?->name ?? 'Uncategorized' }}
                                                            @if ($product->variants_count > 0)
                                                                &bull; {{ $product->variants_count }} variant(s)
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-5 py-3.5 text-sm text-gray-500 font-mono">{{ $product->sku ?? '—' }}</td>
                                            <td class="px-5 py-3.5">
                                                @if ($product->is_out_of_stock)
                                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">Out of Stock</span>
                                                @elseif ($product->is_low_stock)
                                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700">Low Stock</span>
                                                @else
                                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">In Stock</span>
                                                @endif
                                            </td>
                                            <td class="px-5 py-3.5 text-sm text-gray-400">{{ $product->updated_at->format('M d, Y') }}</td>
                                            <td class="px-5 py-3.5">
                                                @php $postId = $product->post?->id; @endphp
                                                <div class="flex items-center gap-1.5">
                                                    @if ($postId)
                                                        <a href="{{ route('owner.update_product', $postId) }}"
                                                           class="p-2 text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 rounded-lg transition" title="Update">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                            </svg>
                                                        </a>
                                                        <button wire:click="deleteItem({{ $postId }})"
                                                                wire:confirm="Archive this product? You can restore it from the Archive page."
                                                                class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Archive">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                            </svg>
                                                        </button>
                                                    @endif
                                                    <button wire:click="openStockManager({{ $product->id }})"
                                                            class="p-2 text-gray-400 hover:text-[#1E7A4A] hover:bg-[#1E7A4A]/10 rounded-lg transition" title="Add Stock">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div>{{ $this->products->links() }}</div>
                @endif
            @else
                <div class="flex flex-col sm:flex-row gap-3">
                    <select wire:model.live="logTypeFilter"
                            class="px-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#1E7A4A]/30 focus:border-[#1E7A4A]/30 transition text-sm">
                        <option value="all">All Types</option>
                        <option value="restock">Restock</option>
                        <option value="sale">Sale</option>
                        <option value="adjustment">Adjustment</option>
                        <option value="return">Return</option>
                        <option value="damage">Damage</option>
                    </select>
                </div>

                @if ($this->logs->isEmpty())
                    <div class="bg-white rounded-2xl border border-gray-100 p-16 text-center">
                        <p class="text-sm text-gray-500">No stock movements recorded yet</p>
                    </div>
                @else
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-100">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Before → After</th>
                                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reference</th>
                                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    @foreach ($this->logs as $log)
                                        <tr wire:key="log-{{ $log->id }}">
                                            <td class="px-5 py-3.5 text-sm text-gray-900">{{ $log->product?->name ?? 'Deleted product' }}</td>
                                            <td class="px-5 py-3.5">
                                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full {{ in_array($log->type, ['sale','damage']) ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                                    {{ ucfirst($log->type) }}
                                                </span>
                                            </td>
                                            <td class="px-5 py-3.5 text-sm font-semibold text-gray-900">{{ $log->quantity }}</td>
                                            <td class="px-5 py-3.5 text-sm text-gray-500">{{ $log->stock_before }} → {{ $log->stock_after }}</td>
                                            <td class="px-5 py-3.5 text-sm text-gray-500">{{ $log->reference ?? '—' }}</td>
                                            <td class="px-5 py-3.5 text-sm text-gray-400">{{ $log->created_at->format('M j, Y g:i A') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div>{{ $this->logs->links() }}</div>
                @endif
            @endif
        </div>
    </div>

    @include('layouts.partials.variant-stock-list-modal')
    @include('layouts.partials.stock-adjust-modal')
</div>