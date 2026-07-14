    <!-- Inventory Products -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mt-8">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-base font-bold text-gray-900">Inventory Products</h3>
                <p class="text-xs text-gray-400 mt-0.5">{{ $this->inventoryProducts->count() }} products</p>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($this->inventoryProducts as $product)
                            <tr wire:key="inventory-{{ $product->id }}">
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2">
                                        @if($product->image)
                                            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="h-8 w-8 rounded-lg object-cover">
                                        @else
                                            <div class="h-8 w-8 bg-gray-100 rounded-lg"></div>
                                        @endif
                                        <div>
                                            <div class="text-sm font-medium text-gray-900 truncate max-w-[160px]">{{ $product->name }}</div>
                                            <div class="text-xs text-gray-400">{{ $product->productCategory?->name ?? 'Uncategorized' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900 font-medium">${{ number_format($product->price ?? 0, 2) }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $product->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ ucfirst($product->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex space-x-2">
                                        <button wire:click="editProduct({{ $product->id }})" class="text-blue-600 hover:text-blue-900">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                        </button>
                                        <button wire:click="deleteProduct({{ $product->id }})" onclick="return confirm('Delete this product? This cannot be undone.')" class="text-red-600 hover:text-red-900">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-4 py-8 text-center text-gray-400 text-sm">No products found. Create your first product!</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>