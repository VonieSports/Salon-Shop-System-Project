<div class="min-h-screen bg-gray-50" x-data="{ showCategoryModal: false }" x-on:category-created.window="showCategoryModal = false">
    <div class="mx-auto space-y-6">

        <div class="flex items-start justify-between flex-wrap gap-4">
            <div>
                <div class="flex items-center gap-2">
                    <span class="w-8 h-8 rounded-lg bg-[#1E7A4A]/10 flex items-center justify-center">
                        <svg class="w-4 h-4 text-[#1E7A4A]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </span>
                    <h1 class="text-2xl font-bold text-gray-900">Create Service</h1>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <button type="button" wire:click="$set('status', 'draft'); save()" wire:loading.attr="disabled" wire:target="save"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-200 text-gray-700 rounded-full hover:bg-gray-50 transition text-sm font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Save Draft
                </button>
                <a href="{{ route('owner.create_product') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#1E7A4A]/5 text-[#1E7A4A] border border-[#1E7A4A]/20 rounded-full hover:bg-[#1E7A4A]/10 hover:border-[#1E7A4A]/40 transition text-sm font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                    </svg>
                    Switch to Product
                </a>
            </div>
        </div>

        @if (session()->has('message'))
            <div class="bg-green-50 text-green-700 px-5 py-3.5 rounded-xl text-sm font-medium">{{ session('message') }}</div>
        @endif
        @if (session()->has('error'))
            <div class="bg-red-50 text-red-700 px-5 py-3.5 rounded-xl text-sm font-medium">{{ session('error') }}</div>
        @endif

        <form wire:submit.prevent="save">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

                <!-- LEFT COLUMN -->
                <div class="lg:col-span-8 space-y-6">

                    <!-- General Information -->
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100">
                            <h3 class="text-base font-bold text-gray-900">General Information</h3>
                        </div>
                        <div class="p-6 space-y-5">
                            <div>
                                <label for="name" class="block text-xs font-medium text-gray-500 mb-1.5">Service Name</label>
                                <input type="text" id="name" wire:model="name" placeholder="Enter service name"
                                       class="w-full px-4 py-3 bg-gray-100 border border-transparent rounded-xl focus:ring-2 focus:ring-[#1E7A4A]/30 focus:bg-white focus:border-[#1E7A4A]/30 transition text-sm text-gray-900">
                                @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="description" class="block text-xs font-medium text-gray-500 mb-1.5">Description</label>
                                <textarea id="description" wire:model="description" rows="4" placeholder="Describe your service..."
                                          class="w-full px-4 py-3 bg-gray-100 border border-transparent rounded-xl focus:ring-2 focus:ring-[#1E7A4A]/30 focus:bg-white focus:border-[#1E7A4A]/30 transition text-sm text-gray-900 resize-none"></textarea>
                                @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Price & Duration -->
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100">
                            <h3 class="text-base font-bold text-gray-900">Price &amp; Duration</h3>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="price" class="block text-xs font-medium text-gray-500 mb-1.5">Price</label>
                                    <div class="relative">
                                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm">$</span>
                                        <input type="number" id="price" wire:model="price" step="0.01" min="0"
                                               class="w-full pl-8 pr-4 py-3 bg-gray-100 border border-transparent rounded-xl focus:ring-2 focus:ring-[#1E7A4A]/30 focus:bg-white focus:border-[#1E7A4A]/30 transition text-sm">
                                    </div>
                                    @error('price') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label for="duration_minutes" class="block text-xs font-medium text-gray-500 mb-1.5">Duration (minutes)</label>
                                    <input type="number" id="duration_minutes" wire:model="duration_minutes" min="1" max="1440" placeholder="e.g. 60"
                                           class="w-full px-4 py-3 bg-gray-100 border border-transparent rounded-xl focus:ring-2 focus:ring-[#1E7A4A]/30 focus:bg-white focus:border-[#1E7A4A]/30 transition text-sm">
                                    @error('duration_minutes') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Service Options -->
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between flex-wrap gap-3">
                            <h3 class="text-base font-bold text-gray-900">Service Options</h3>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" wire:model.live="hasVariants" class="sr-only peer">
                                <span class="w-10 h-5 bg-gray-200 rounded-full peer-checked:bg-[#1E7A4A] transition-colors block"></span>
                                <span class="absolute left-0.5 top-0.5 w-4 h-4 bg-white rounded-full shadow transition-transform peer-checked:translate-x-5"></span>
                                <span class="ml-2 text-sm font-medium text-gray-700">Has options</span>
                            </label>
                        </div>

                        <div class="p-6">
                            @if ($hasVariants)
                                @include('layouts.partials.variant-option-builder')

                                @if (count($variants) > 0)
                                    <div class="mt-6 border-t border-gray-100 pt-6 space-y-3">
                                        <p class="text-sm font-semibold text-gray-700">{{ count($variants) }} option(s) generated</p>
                                        @foreach ($variants as $index => $variant)
                                            <div wire:key="variant-{{ $index }}" class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                                                <div class="flex items-center gap-3 mb-3 flex-wrap">
                                                    @if ($thumb = $this->variantThumbnail($variant['attributes']))
                                                        <img src="{{ $thumb }}" class="w-10 h-10 rounded-lg object-cover border border-gray-200 shrink-0">
                                                    @endif
                                                    <div class="flex flex-wrap gap-1.5">
                                                        @foreach ($variant['attributes'] as $optionName => $value)
                                                            <span class="text-xs font-semibold bg-white border border-gray-200 px-2.5 py-1 rounded-full text-gray-700">{{ $optionName }}: {{ $value }}</span>
                                                        @endforeach
                                                    </div>
                                                    <span class="text-[11px] text-gray-400 font-mono ml-auto">SKU auto-generated</span>
                                                </div>
                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                                    <div>
                                                        <label class="block text-xs text-gray-500 mb-1">Price Adjustment</label>
                                                        <div class="relative">
                                                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs">$</span>
                                                            <input type="number" wire:model="variants.{{ $index }}.price_adjustment" step="0.01"
                                                                   class="w-full pl-6 pr-3 py-2 bg-white border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#1E7A4A]/30 focus:border-[#1E7A4A]/30 transition text-sm" placeholder="0.00">
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <label class="block text-xs text-gray-500 mb-1">Duration Adjustment (min)</label>
                                                        <input type="number" wire:model="variants.{{ $index }}.duration_adjustment"
                                                               class="w-full px-3 py-2 bg-white border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#1E7A4A]/30 focus:border-[#1E7A4A]/30 transition text-sm" placeholder="0">
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            @else
                                <p class="text-sm text-gray-400">Toggle "Has options" above if this service comes in different durations, add-ons, or packages.</p>
                            @endif
                        </div>
                    </div>

                </div>

                <!-- RIGHT COLUMN -->
                <div class="lg:col-span-4 space-y-6 flex flex-col">

                    <!-- Upload Image -->
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100">
                            <h3 class="text-base font-bold text-gray-900">Upload Image</h3>
                        </div>
                        <div class="p-6">
                            <label class="group relative block aspect-square w-full rounded-2xl border-2 border-dashed border-gray-200 bg-gray-50 overflow-hidden cursor-pointer hover:border-[#1E7A4A] transition">
                                @if($image && $image->temporaryUrl())
                                    <img src="{{ $image->temporaryUrl() }}" alt="Service preview" class="absolute inset-0 w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition flex items-center justify-center">
                                        <span class="opacity-0 group-hover:opacity-100 text-white text-sm font-medium transition">Change image</span>
                                    </div>
                                @else
                                    <div class="absolute inset-0 flex flex-col items-center justify-center text-gray-400 group-hover:text-[#1E7A4A] transition">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M4 8h16M4 4h16a1 1 0 011 1v14a1 1 0 01-1 1H4a1 1 0 01-1-1V5a1 1 0 011-1z"/>
                                        </svg>
                                        <span class="mt-2 text-sm font-medium">Click to upload</span>
                                        <span class="text-xs text-gray-400 mt-0.5">PNG or JPG, up to 2MB</span>
                                    </div>
                                @endif
                                <input type="file" wire:model="image" accept="image/*" class="hidden">
                            </label>
                            @error('image') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                            <div wire:loading wire:target="image" class="mt-2 text-xs text-gray-400">Uploading...</div>
                        </div>
                    </div>

                    <!-- Category -->
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100">
                            <h3 class="text-base font-bold text-gray-900">Category</h3>
                        </div>
                        <div class="p-6 space-y-3">
                            <div>
                                <label for="category" class="block text-xs font-medium text-gray-500 mb-1.5">Service Category</label>
                                <select id="category" wire:model="service_category_id"
                                        class="w-full px-4 py-3 bg-gray-100 border border-transparent rounded-xl focus:ring-2 focus:ring-[#1E7A4A]/30 focus:bg-white focus:border-[#1E7A4A]/30 transition text-sm">
                                    <option value="">Select a category</option>
                                    @foreach($this->categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('service_category_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <button type="button" @click="showCategoryModal = true"
                                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-[#1E7A4A] text-white rounded-xl hover:bg-[#16633c] transition text-sm font-medium">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                                Add Category
                            </button>
                        </div>
                    </div>

                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                <!-- Status Field -->
                <div class="w-full sm:w-auto">
                    <label class="block text-xs font-medium text-gray-500 mb-1.5">Status</label>
                    <div class="flex items-center gap-2 bg-gray-100 rounded-xl p-1 h-12">
                        <label class="flex items-center gap-2 cursor-pointer px-3 py-1 rounded-lg transition-colors duration-200 hover:bg-gray-200/50 flex-1">
                            <input type="radio" wire:model="status" value="draft" class="hidden peer">
                            <div class="w-5 h-5 rounded-full border-2 border-gray-300 bg-white flex items-center justify-center flex-shrink-0 transition-colors duration-200 peer-checked:border-gray-500 peer-checked:bg-gray-200">
                                <div class="w-2.5 h-2.5 rounded-full bg-gray-600 transition-all duration-200 scale-0 peer-checked:scale-100"></div>
                            </div>
                            <span class="text-sm font-medium text-gray-600 peer-checked:text-gray-900 transition-colors whitespace-nowrap">Draft</span>
                        </label>

                        <label class="flex items-center gap-2 cursor-pointer px-3 py-1 rounded-lg transition-colors duration-200 hover:bg-green-100/50 flex-1">
                            <input type="radio" wire:model="status" value="published" class="hidden peer">
                            <div class="w-5 h-5 rounded-full border-2 border-gray-300 bg-white flex items-center justify-center flex-shrink-0 transition-colors duration-200 peer-checked:border-[#1E7A4A] peer-checked:bg-[#1E7A4A]/20">
                                <div class="w-2.5 h-2.5 rounded-full bg-[#1E7A4A] transition-all duration-200 scale-0 peer-checked:scale-100"></div>
                            </div>
                            <span class="text-sm font-medium text-gray-600 peer-checked:text-[#1E7A4A] peer-checked:font-semibold transition-colors whitespace-nowrap">Published</span>
                        </label>
                    </div>
                    @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center gap-3 w-full sm:w-auto flex-shrink-0">
                    <a href="{{ route('owner.dashboard') }}"
                       class="inline-flex items-center justify-center gap-2 px-6 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 hover:border-gray-400 transition text-sm font-medium w-full sm:w-auto whitespace-nowrap">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Cancel
                    </a>

                    <button type="submit" wire:loading.attr="disabled" wire:target="save"
                            class="inline-flex items-center justify-center gap-2 px-8 py-2.5 bg-[#1E7A4A] text-white rounded-xl hover:bg-[#16633c] transition text-sm font-medium shadow-sm w-full sm:w-auto whitespace-nowrap">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span wire:loading.remove wire:target="save">Save Changes</span>
                        <span wire:loading wire:target="save">Saving...</span>
                    </button>
                </div>
            </div>
        </form>

        <!-- Inventory Services -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-base font-bold text-gray-900">Inventory Services</h3>
                <p class="text-xs text-gray-400 mt-0.5">{{ $this->inventoryServices->count() }} services</p>
            </div>
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($this->inventoryServices as $service)
                        <tr wire:key="inventory-{{ $service->id }}">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    @if($service->image)
                                        <img src="{{ Storage::url($service->image) }}" alt="{{ $service->name }}" class="h-8 w-8 rounded-lg object-cover">
                                    @else
                                        <div class="h-8 w-8 bg-gray-100 rounded-lg"></div>
                                    @endif
                                    <div>
                                        <div class="text-sm font-medium text-gray-900 truncate max-w-[160px]">{{ $service->name }}</div>
                                        <div class="text-xs text-gray-400">{{ $service->serviceCategory?->name ?? 'Uncategorized' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-900 font-medium">${{ number_format($service->price ?? 0, 2) }}</td>
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $service->duration_minutes ? $service->duration_minutes . ' min' : '—' }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $service->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ucfirst($service->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex space-x-2">
                                    <button wire:click="editService({{ $service->id }})" class="text-blue-600 hover:text-blue-900">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    </button>
                                    <button wire:click="deleteService({{ $service->id }})" onclick="return confirm('Delete this service? This cannot be undone.')" class="text-red-600 hover:text-red-900">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-4 py-8 text-center text-gray-400 text-sm">No services found. Create your first service!</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

    @include('layouts.partials.category-modal')
</div>