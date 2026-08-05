<div class="min-h-screen bg-gray-50" x-data="{ showCategoryModal: false }" x-on:category-created.window="showCategoryModal = false">
    <div class="mx-auto space-y-6">
        @if (session()->has('message'))
            <div class="bg-green-50 text-green-700 px-5 py-3.5 rounded-xl text-sm font-medium">{{ session('message') }}</div>
        @endif
        @if (session()->has('error'))
            <div class="bg-red-50 text-red-700 px-5 py-3.5 rounded-xl text-sm font-medium">{{ session('error') }}</div>
        @endif

        <form wire:submit.prevent="save">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <div class="lg:col-span-8 space-y-6">
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                        <div class="px-6 py-5 border-b border-gray-100 bg-[#1E7A4A]">
                            <div class="flex items-center justify-between flex-wrap gap-4">
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('owner.dashboard') }}" class="p-2 hover:bg-green-100 rounded-lg transition-colors">
                                        <svg class="w-5 h-5 text-neutral-50 hover:text-[#1E7A4A]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                        </svg>
                                    </a>
                                    <div>
                                        <h1 class="text-2xl font-bold text-neutral-50">Create Product</h1>
                                        <p class="text-sm text-neutral-50 mt-0.5">Add a new product to your inventory</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="p-6 space-y-5">
                            <div>
                                <label for="name" class="block text-xs font-medium text-gray-500 mb-1.5">Product Name</label>
                                <input type="text" id="name" wire:model="name" placeholder="Enter product name"
                                       class="w-full px-4 py-3 bg-gray-100 border border-transparent rounded-xl focus:ring-2 focus:ring-[#1E7A4A]/30 focus:bg-white focus:border-[#1E7A4A]/30 transition text-sm text-gray-900">
                                @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="description" class="block text-xs font-medium text-gray-500 mb-1.5">Description</label>
                                <textarea id="description" wire:model="description" rows="4" placeholder="Describe your product..."
                                          class="w-full px-4 py-3 bg-gray-100 border border-transparent rounded-xl focus:ring-2 focus:ring-[#1E7A4A]/30 focus:bg-white focus:border-[#1E7A4A]/30 transition text-sm text-gray-900 resize-none"></textarea>
                                @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100">
                            <h3 class="text-base font-bold text-gray-900">Pricing &amp; Stock</h3>
                        </div>
                        <div class="p-6 space-y-5">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="cost_price" class="block text-xs font-medium text-gray-500 mb-1.5">Cost Price</label>
                                    <div class="relative">
                                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm">$</span>
                                        <input type="number" id="cost_price" wire:model.blur="cost_price" step="0.01" min="0"
                                               class="w-full pl-8 pr-4 py-3 bg-gray-100 border border-transparent rounded-xl focus:ring-2 focus:ring-[#1E7A4A]/30 focus:bg-white focus:border-[#1E7A4A]/30 transition text-sm">
                                    </div>
                                    @error('cost_price') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label for="selling_price" class="block text-xs font-medium text-gray-500 mb-1.5">Selling Price</label>
                                    <div class="relative">
                                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm">$</span>
                                        <input type="number" id="selling_price" wire:model.blur="selling_price" step="0.01" min="0"
                                               class="w-full pl-8 pr-4 py-3 bg-gray-100 border border-transparent rounded-xl focus:ring-2 focus:ring-[#1E7A4A]/30 focus:bg-white focus:border-[#1E7A4A]/30 transition text-sm">
                                    </div>
                                    @error('selling_price') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="gap-4">
                                @if (!$hasVariants)
                                    <div>
                                        <label for="stock" class="block text-xs font-medium text-gray-500 mb-1.5">Stock</label>
                                        <input type="number" id="stock" wire:model="stock" min="0"
                                               class="w-full px-4 py-3 bg-gray-100 border border-transparent rounded-xl focus:ring-2 focus:ring-[#1E7A4A]/30 focus:bg-white focus:border-[#1E7A4A]/30 transition text-sm">
                                        @error('stock') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                    </div>
                                @else
                                    <div class="col-span-2 flex items-end pb-3">
                                        <p class="text-xs text-gray-400">Stock is managed per variant below</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden" id="variants-section">
                        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between flex-wrap gap-3">
                            <h3 class="text-base font-bold text-gray-900">Product Variants</h3>                            
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" wire:model.live="hasVariants" class="sr-only peer">
                                <span class="w-10 h-5 bg-gray-200 rounded-full peer-checked:bg-[#1E7A4A] transition-colors block"></span>
                                <span class="absolute left-0.5 top-0.5 w-4 h-4 bg-white rounded-full shadow transition-transform peer-checked:translate-x-5"></span>
                                <span class="ml-2 text-sm font-medium text-gray-700">Has variants</span>
                            </label>
                        </div>
                        
                        <div class="p-6">
                            @if ($hasVariants)
                                @include('layouts.partials.variant-option-builder')

                                @if (count($variants) > 0)
                                    <div class="mt-6 border-t border-gray-100 pt-6 space-y-3">
                                        <p class="text-sm font-semibold text-gray-700">{{ count($variants) }} variant(s) generated</p>
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
                                                    <span class="text-[11px] text-gray-400 font-mono ml-auto">SKU</span>
                                                </div>
                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                                    <div>
                                                        <label class="block text-xs text-gray-500 mb-1">Stock</label>
                                                        <input type="number" wire:model="variants.{{ $index }}.stock" min="0"
                                                               class="w-full px-3 py-2 bg-white border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#1E7A4A]/30 focus:border-[#1E7A4A]/30 transition text-sm" placeholder="0">
                                                        @error("variants.{$index}.stock") <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                                                    </div>
                                                    <div>
                                                        <label class="block text-xs text-gray-500 mb-1">Price Adjustment</label>
                                                        <div class="relative">
                                                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs">$</span>
                                                            <input type="number" wire:model="variants.{{ $index }}.price_adjustment" step="0.01"
                                                                   class="w-full pl-6 pr-3 py-2 bg-white border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#1E7A4A]/30 focus:border-[#1E7A4A]/30 transition text-sm" placeholder="0.00">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            @else
                                <p class="text-sm text-gray-400">Toggle "Has variants" above if this product comes in different sizes, colors, or other options.</p>
                            @endif
                        </div>
                    </div>

                </div>

                <div class="lg:col-span-4 space-y-6 flex flex-col">
                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100">
                            <h3 class="text-base font-bold text-gray-900">Images</h3>
                        </div>
                        <div class="p-6">
                            <label class="group relative block aspect-square w-full max-w-75 mx-auto rounded-xl border-2 border-dashed border-gray-300 bg-gray-50 overflow-hidden cursor-pointer hover:border-[#1E7A4A] transition">
                                @if($image && $image->temporaryUrl())
                                    <img src="{{ $image->temporaryUrl() }}" alt="Product preview" class="absolute inset-0 w-full h-full object-contain">
                                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition flex items-center justify-center">
                                        <span class="opacity-0 group-hover:opacity-100 text-black text-sm font-medium transition bg-white/80 px-3 py-1 rounded">Change</span>
                                    </div>
                                @else
                                    <div class="absolute inset-0 flex flex-col items-center justify-center text-gray-400 group-hover:text-[#1E7A4A] transition">
                                        <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M4 8h16M4 4h16a1 1 0 011 1v14a1 1 0 01-1 1H4a1 1 0 01-1-1V5a1 1 0 011-1z"/>
                                        </svg>
                                        <span class="text-sm font-medium">Upload main image</span>
                                    </div>
                                @endif
                                <input type="file" wire:model="image" accept="image/*" class="hidden">
                            </label>

                            <div class="mt-3 text-center">
                                <p class="text-[11px] text-gray-500">Dimensions: <span class="font-medium">600 x 600 px.</span> Maximum file size: <span class="font-medium">10 MB</span> (Up to 9 files). Format: JPG, JPEG, PNG</p>
                                @error('image') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror
                                <div wire:loading wire:target="image" class="mt-2 text-xs text-emerald-600 font-medium">Uploading image...</div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100">
                            <h3 class="text-base font-bold text-gray-900">Category</h3>
                        </div>
                        <div class="p-6 space-y-3">
                            <div>
                                <label for="category" class="block text-xs font-medium text-gray-500 mb-1.5">Product Category</label>
                                <select wire:model.blur="product_category_id" 
                                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1E7A4A]/30">
                                    <option value="">Select category</option>
                                    @foreach($this->categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('product_category_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
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

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mt-6">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-base font-bold text-gray-900">Product Details & Highlights</h3>
                        </div>
                        <span class="text-xs text-gray-400">Optional</span>
                    </div>
                </div>
                
                <div class="p-6 space-y-4">
                    <div>
                        <label for="info_section_name" class="block text-xs font-medium text-gray-500 mb-1.5"> Name</label>
                        <input type="text" id="info_section_name" wire:model="info_section_name" 
                               placeholder="e.g. About this product"
                               class="w-full px-4 py-3 bg-gray-100 border border-transparent rounded-xl focus:ring-2 focus:ring-[#1E7A4A]/30 focus:bg-white focus:border-[#1E7A4A]/30 transition text-sm text-gray-900">
                    </div>  

                    <div class="space-y-3 mt-2">
                        @if(!empty($additionalInfo))
                            @foreach($additionalInfo as $index => $info)
                                <div wire:key="info-row-{{ $index }}" class="flex items-center gap-3 bg-gray-50 p-3 rounded-lg border border-gray-200">
                                    <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 gap-2">
                                        <input type="text" 
                                               wire:model="additionalInfo.{{ $index }}.label" 
                                               placeholder="Label (e.g., Brand)"
                                               class="w-full px-3 py-2 bg-white border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#1E7A4A]/30 focus:border-[#1E7A4A]/30 transition text-sm">
                                        <input type="text" 
                                               wire:model="additionalInfo.{{ $index }}.value" 
                                               placeholder="Value (e.g., L'Oréal)"
                                               class="w-full px-3 py-2 bg-white border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#1E7A4A]/30 focus:border-[#1E7A4A]/30 transition text-sm">
                                    </div>
                                    <button wire:click="removeAdditionalInfo({{ $index }})" 
                                            class="text-red-400 hover:text-red-600 transition p-1">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                    </button>
                                </div>
                            @endforeach
                        @endif

                        <button type="button" wire:click="addAdditionalInfo" 
                                class="w-full py-3 border-2 border-dashed border-gray-300 rounded-xl text-gray-500 hover:border-[#1E7A4A] hover:text-[#1E7A4A] transition text-sm font-medium flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                            </svg>
                            Add Highlight / Specification
                        </button>
                    </div>
                </div>
            </div>
            
            <div class="mt-8 pt-6 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="w-full sm:w-auto">
                    <label class="block text-xs font-medium text-gray-500 mb-1.5">Status</label>
                    <div class="flex items-center gap-2 bg-gray-100 rounded-xl p-1 h-12">
                        <label class="flex items-center gap-2 cursor-pointer px-3 py-1 rounded-lg transition-colors duration-200 hover:bg-gray-200/50 flex-1">
                            <input type="radio" wire:model="status" value="draft" class="hidden peer">
                            <div class="w-5 h-5 rounded-full border-2 border-gray-300 bg-white flex items-center justify-center shrink-0 transition-colors duration-200 peer-checked:border-gray-500 peer-checked:bg-gray-200">
                                <div class="w-2.5 h-2.5 rounded-full bg-gray-600 transition-all duration-200 scale-0 peer-checked:scale-100"></div>
                            </div>
                            <span class="text-sm font-medium text-gray-600 peer-checked:text-gray-900 transition-colors whitespace-nowrap">Draft</span>
                        </label>

                        <label class="flex items-center gap-2 cursor-pointer px-3 py-1 rounded-lg transition-colors duration-200 hover:bg-green-100/50 flex-1">
                            <input type="radio" wire:model="status" value="published" class="hidden peer">
                            <div class="w-5 h-5 rounded-full border-2 border-gray-300 bg-white flex items-center justify-center shrink-0 transition-colors duration-200 peer-checked:border-[#1E7A4A] peer-checked:bg-[#1E7A4A]/20">
                                <div class="w-2.5 h-2.5 rounded-full bg-[#1E7A4A] transition-all duration-200 scale-0 peer-checked:scale-100"></div>
                            </div>
                            <span class="text-sm font-medium text-gray-600 peer-checked:text-[#1E7A4A] peer-checked:font-semibold transition-colors whitespace-nowrap">Published</span>
                        </label>
                    </div>
                    @error('status') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center gap-3 w-full sm:w-auto shrink-0">
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
        @include('layouts.partials.category-modal')
    </div>
</div>