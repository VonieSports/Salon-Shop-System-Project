<div class="min-h-screen bg-[#F5F5F5]" x-data="{ showCategoryModal: false }" x-on:category-created.window="showCategoryModal = false">
    <div class="max-w-7xl mx-auto px-3 sm:px-4 py-4 sm:py-6">

        @if (session()->has('message'))
            <div class="bg-[#FCE9ED] border border-[#D6657A]/30 text-[#7A3B4A] px-4 py-2.5 rounded-lg text-sm font-medium flex items-center gap-2 mb-4">
                <svg class="w-5 h-5 text-[#D6657A] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ session('message') }}
            </div>
        @endif
        
        @if (session()->has('error'))
            <div class="bg-[#FDE8E8] border border-[#D6657A]/40 text-[#7A2E3A] px-4 py-2.5 rounded-lg text-sm font-medium flex items-center gap-2 mb-4">
                <svg class="w-5 h-5 text-[#D6657A] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                {{ session('error') }}
            </div>
        @endif

        <form wire:submit.prevent="save">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                <!-- Left Column - Main Fields (2/3) -->
                <div class="lg:col-span-2 space-y-4">
                    <!-- Main Card -->
                    <div class="bg-white rounded-lg shadow-sm border border-[#EFEFEF] overflow-hidden">
                        <!-- Header with Pink Gradient -->
                        <div class="bg-gradient-to-r from-[#D6657A] to-[#C25467] px-4 sm:px-6 py-3.5">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('owner.dashboard') }}" class="p-1 hover:bg-white/10 rounded-lg transition-colors">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                    </svg>
                                </a>
                                <div>
                                    <h1 class="text-lg sm:text-xl font-bold text-white">Create Product</h1>
                                    <p class="text-white/80 text-sm">Add a new product to your inventory</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-4 space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-[#333] mb-1">
                                    Product Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" wire:model="name" placeholder="Enter product name"
                                       class="w-full px-3 py-2 bg-[#F5F5F5] border-0 rounded-lg focus:ring-2 focus:ring-[#D6657A]/30 text-sm text-[#222] placeholder:text-[#999] transition">
                                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-[#333] mb-1">Description</label>
                                <textarea wire:model="description" rows="3" placeholder="Describe your product..."
                                          class="w-full px-3 py-2 bg-[#F5F5F5] border-0 rounded-lg focus:ring-2 focus:ring-[#D6657A]/30 text-sm text-[#222] placeholder:text-[#999] transition resize-none"></textarea>
                                @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Pricing & Stock -->
                    <div class="bg-white rounded-lg shadow-sm border border-[#EFEFEF] overflow-hidden">
                        <div class="px-4 py-3 border-b border-[#EFEFEF]">
                            <h3 class="text-sm font-semibold text-[#222]">Pricing &amp; Stock</h3>
                        </div>
                        <div class="p-4 space-y-4">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-[#333] mb-1">Cost Price</label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-[#999] text-sm">$</span>
                                        <input type="number" wire:model.blur="cost_price" step="0.01" min="0" placeholder="0.00"
                                               class="w-full pl-7 pr-3 py-2 bg-[#F5F5F5] border-0 rounded-lg focus:ring-2 focus:ring-[#D6657A]/30 text-sm text-[#222] placeholder:text-[#999] transition">
                                    </div>
                                    @error('cost_price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-[#333] mb-1">Selling Price <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-[#999] text-sm">$</span>
                                        <input type="number" wire:model.blur="selling_price" step="0.01" min="0" placeholder="0.00"
                                               class="w-full pl-7 pr-3 py-2 bg-[#F5F5F5] border-0 rounded-lg focus:ring-2 focus:ring-[#D6657A]/30 text-sm text-[#222] placeholder:text-[#999] transition">
                                    </div>
                                    @error('selling_price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            @if (!$hasVariants)
                                <div>
                                    <label class="block text-sm font-medium text-[#333] mb-1">Stock <span class="text-red-500">*</span></label>
                                    <input type="number" wire:model="stock" min="0" placeholder="0"
                                           class="w-full px-3 py-2 bg-[#F5F5F5] border-0 rounded-lg focus:ring-2 focus:ring-[#D6657A]/30 text-sm text-[#222] placeholder:text-[#999] transition">
                                    @error('stock') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                            @else
                                <p class="text-sm text-[#999]">Stock is managed per variant below</p>
                            @endif
                        </div>
                    </div>

                    <!-- Variants -->
                    <div class="bg-white rounded-lg shadow-sm border border-[#EFEFEF] overflow-hidden" id="variants-section">
                        <div class="px-4 py-3 border-b border-[#EFEFEF] flex items-center justify-between flex-wrap gap-2">
                            <h3 class="text-sm font-semibold text-[#222]">Product Variants</h3>                            
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" wire:model.live="hasVariants" class="sr-only peer">
                                <span class="w-9 h-5 bg-[#EFEFEF] rounded-full peer-checked:bg-[#D6657A] transition-colors block"></span>
                                <span class="absolute left-0.5 top-0.5 w-4 h-4 bg-white rounded-full shadow transition-transform peer-checked:translate-x-4"></span>
                                <span class="ml-2 text-sm font-medium text-[#666]">Has variants</span>
                            </label>
                        </div>
                        
                        <div class="p-4">
                            @if ($hasVariants)
                                @include('layouts.partials.variant-option-builder')

                                @if (count($variants) > 0)
                                    <div class="mt-4 border-t border-[#EFEFEF] pt-4 space-y-3">
                                        <p class="text-sm font-semibold text-[#222]">{{ count($variants) }} variant(s) generated</p>
                                        @foreach ($variants as $index => $variant)
                                            <div wire:key="variant-{{ $index }}" class="bg-[#F5F5F5] rounded-lg p-3 border border-[#EFEFEF]">
                                                <div class="flex items-center gap-2 mb-2 flex-wrap">
                                                    @if ($thumb = $this->variantThumbnail($variant['attributes']))
                                                        <img src="{{ $thumb }}" class="w-8 h-8 rounded object-cover border border-[#EFEFEF] shrink-0">
                                                    @endif
                                                    <div class="flex flex-wrap gap-1">
                                                        @foreach ($variant['attributes'] as $optionName => $value)
                                                            <span class="text-xs font-medium bg-white border border-[#EFEFEF] px-2 py-0.5 rounded-full text-[#333]">{{ $optionName }}: {{ $value }}</span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                                    <div>
                                                        <label class="block text-xs text-[#666] mb-0.5">Stock</label>
                                                        <input type="number" wire:model="variants.{{ $index }}.stock" min="0" placeholder="0"
                                                               class="w-full px-2 py-1.5 bg-white border border-[#EFEFEF] rounded focus:ring-2 focus:ring-[#D6657A]/30 text-sm text-[#222] placeholder:text-[#999] transition">
                                                        @error("variants.{$index}.stock") <p class="text-red-500 text-xs mt-0.5">{{ $message }}</p> @enderror
                                                    </div>
                                                    <div>
                                                        <label class="block text-xs text-[#666] mb-0.5">Price Adjustment</label>
                                                        <div class="relative">
                                                            <span class="absolute left-2 top-1/2 -translate-y-1/2 text-[#999] text-xs">$</span>
                                                            <input type="number" wire:model="variants.{{ $index }}.price_adjustment" step="0.01" placeholder="0.00"
                                                                   class="w-full pl-5 pr-2 py-1.5 bg-white border border-[#EFEFEF] rounded focus:ring-2 focus:ring-[#D6657A]/30 text-sm text-[#222] placeholder:text-[#999] transition">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            @else
                                <p class="text-sm text-[#999]">Toggle "Has variants" above if this product comes in different sizes, colors, or other options.</p>
                            @endif
                        </div>
                    </div>

                    <!-- Product Details & Highlights -->
                    <div class="bg-white rounded-lg shadow-sm border border-[#EFEFEF] overflow-hidden">
                        <div class="px-4 py-3 border-b border-[#EFEFEF] flex items-center justify-between">
                            <h3 class="text-sm font-semibold text-[#222]">Product Details & Highlights</h3>
                            <span class="text-xs text-[#999]">Optional</span>
                        </div>
                        
                        <div class="p-4 space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-[#333] mb-1">Section Name</label>
                                <input type="text" wire:model="info_section_name" placeholder="e.g. About this product"
                                       class="w-full px-3 py-2 bg-[#F5F5F5] border-0 rounded-lg focus:ring-2 focus:ring-[#D6657A]/30 text-sm text-[#222] placeholder:text-[#999] transition">
                            </div>  

                            <div class="space-y-2">
                                @if(!empty($additionalInfo))
                                    @foreach($additionalInfo as $index => $info)
                                        <div wire:key="info-row-{{ $index }}" class="flex items-center gap-2 bg-[#F5F5F5] p-2 rounded-lg">
                                            <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 gap-2">
                                                <input type="text" wire:model="additionalInfo.{{ $index }}.label" placeholder="Label"
                                                       class="w-full px-2 py-1.5 bg-white border border-[#EFEFEF] rounded focus:ring-2 focus:ring-[#D6657A]/30 text-sm text-[#222] placeholder:text-[#999] transition">
                                                <input type="text" wire:model="additionalInfo.{{ $index }}.value" placeholder="Value"
                                                       class="w-full px-2 py-1.5 bg-white border border-[#EFEFEF] rounded focus:ring-2 focus:ring-[#D6657A]/30 text-sm text-[#222] placeholder:text-[#999] transition">
                                            </div>
                                            <button wire:click="removeAdditionalInfo({{ $index }})" class="text-red-400 hover:text-red-600 transition p-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                        </div>
                                    @endforeach
                                @endif

                                <button type="button" wire:click="addAdditionalInfo" 
                                        class="w-full py-2 border-2 border-dashed border-[#EFEFEF] rounded-lg text-[#999] hover:border-[#D6657A] hover:text-[#D6657A] transition text-sm font-medium flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    Add Highlight / Specification
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Sidebar (1/3) -->
                <div class="lg:col-span-1 space-y-4">
                    <!-- Images -->
                    <div class="bg-white rounded-lg shadow-sm border border-[#EFEFEF] overflow-hidden">
                        <div class="px-4 py-3 border-b border-[#EFEFEF]">
                            <h3 class="text-sm font-semibold text-[#222]">Images</h3>
                        </div>
                        <div class="p-4">
                            <label class="group relative block aspect-square w-full rounded-lg border-2 border-dashed border-[#EFEFEF] bg-[#F5F5F5] overflow-hidden cursor-pointer hover:border-[#D6657A] transition">
                                @if($image && $image->temporaryUrl())
                                    <img src="{{ $image->temporaryUrl() }}" alt="Product preview" class="absolute inset-0 w-full h-full object-contain">
                                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 transition flex items-center justify-center">
                                        <span class="opacity-0 group-hover:opacity-100 text-white text-sm font-medium transition bg-black/50 px-3 py-1 rounded">Change</span>
                                    </div>
                                @else
                                    <div class="absolute inset-0 flex flex-col items-center justify-center text-[#999] group-hover:text-[#D6657A] transition">
                                        <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M4 8h16M4 4h16a1 1 0 011 1v14a1 1 0 01-1 1H4a1 1 0 01-1-1V5a1 1 0 011-1z"/>
                                        </svg>
                                        <span class="text-sm font-medium">Upload image</span>
                                    </div>
                                @endif
                                <input type="file" wire:model="image" accept="image/*" class="hidden">
                            </label>

                            <div class="mt-2 text-center">
                                <p class="text-[10px] text-[#999]">600×600px. Max 10MB. JPG, PNG</p>
                                @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                <div wire:loading wire:target="image" class="text-xs text-[#D6657A] mt-1 font-medium">Uploading...</div>
                            </div>
                        </div>
                    </div>

                    <!-- Category -->
                    <div class="bg-white rounded-lg shadow-sm border border-[#EFEFEF] overflow-hidden">
                        <div class="px-4 py-3 border-b border-[#EFEFEF]">
                            <h3 class="text-sm font-semibold text-[#222]">Category</h3>
                        </div>
                        <div class="p-4 space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-[#333] mb-1">Product Category <span class="text-red-500">*</span></label>
                                <select wire:model.blur="product_category_id" 
                                        class="w-full px-3 py-2 bg-[#F5F5F5] border-0 rounded-lg focus:ring-2 focus:ring-[#D6657A]/30 text-sm text-[#222] transition appearance-none cursor-pointer">
                                    <option value="">Select category</option>
                                    @foreach($this->categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('product_category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <button type="button" @click="showCategoryModal = true"
                                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 bg-[#D6657A] text-white rounded-lg hover:bg-[#C25467] transition text-sm font-medium">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                </svg>
                                Add Category
                            </button>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="bg-white rounded-lg shadow-sm border border-[#EFEFEF] overflow-hidden">
                        <div class="px-4 py-3 border-b border-[#EFEFEF]">
                            <h3 class="text-sm font-semibold text-[#222]">Status</h3>
                        </div>
                        <div class="p-4">
                            <div class="flex items-center gap-2 bg-[#F5F5F5] rounded-lg p-1">
                                <label class="flex-1 flex items-center justify-center gap-2 cursor-pointer px-3 py-1.5 rounded transition">
                                    <input type="radio" wire:model="status" value="draft" class="hidden peer">
                                    <div class="w-4 h-4 rounded-full border-2 border-[#CCC] bg-white flex items-center justify-center transition peer-checked:border-[#666] peer-checked:bg-[#666]">
                                        <div class="w-2 h-2 rounded-full bg-white transition scale-0 peer-checked:scale-100"></div>
                                    </div>
                                    <span class="text-sm font-medium text-[#666] peer-checked:text-[#222] transition">Draft</span>
                                </label>

                                <label class="flex-1 flex items-center justify-center gap-2 cursor-pointer px-3 py-1.5 rounded transition">
                                    <input type="radio" wire:model="status" value="published" class="hidden peer">
                                    <div class="w-4 h-4 rounded-full border-2 border-[#CCC] bg-white flex items-center justify-center transition peer-checked:border-[#D6657A] peer-checked:bg-[#D6657A]">
                                        <div class="w-2 h-2 rounded-full bg-white transition scale-0 peer-checked:scale-100"></div>
                                    </div>
                                    <span class="text-sm font-medium text-[#666] peer-checked:text-[#D6657A] transition">Published</span>
                                </label>
                            </div>
                            @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="mt-6 pt-4 border-t border-[#EFEFEF] flex flex-col-reverse sm:flex-row justify-between items-center gap-3">
                <a href="{{ route('owner.dashboard') }}" class="text-sm text-[#666] hover:text-[#222] transition font-medium">
                    Cancel
                </a>
                <button type="submit" wire:loading.attr="disabled" wire:target="save"
                        class="w-full sm:w-auto px-6 py-2 bg-[#D6657A] hover:bg-[#C25467] text-white rounded-lg transition text-sm font-semibold shadow-sm flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span wire:loading.remove wire:target="save">Save Product</span>
                    <span wire:loading wire:target="save">Saving...</span>
                </button>
            </div>
        </form>

        @include('layouts.partials.category-modal')
    </div>
</div>