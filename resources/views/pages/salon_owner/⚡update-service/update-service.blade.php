<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto p-4 sm:p-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <!-- Header -->
            <div class="px-4 sm:px-6 py-4 sm:py-5 border-b border-gray-100 bg-[#1E7A4A]">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2 sm:gap-3">
                        <a href="{{ route('owner.service_management') }}" 
                           class="p-1.5 sm:p-2 hover:bg-green-100 rounded-lg transition-colors">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                        </a>
                        <div>
                            <h1 class="text-lg sm:text-2xl font-bold text-white">Update Service</h1>
                            <p class="text-white/80 text-xs sm:text-sm mt-0.5">Edit your service details</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-4 sm:p-6">
                @if (session()->has('message'))
                    <div class="mb-4 p-3 sm:p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm">{{ session('message') }}</div>
                @endif
                @if (session()->has('error'))
                    <div class="mb-4 p-3 sm:p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">{{ session('error') }}</div>
                @endif

                <form wire:submit.prevent="save" enctype="multipart/form-data">
                    <!-- MOBILE/TABLET: Image & Category at Top -->
                    <div class="block lg:hidden space-y-6 mb-6">
                        <!-- Image - Mobile/Tablet -->
                        <div class="bg-gray-50 rounded-xl p-4 sm:p-5 border border-gray-200">
                            <div class="flex items-center justify-between mb-3">
                                <h2 class="text-sm font-semibold text-[#1E7A4A] uppercase tracking-wider">Service Image</h2>
                                @if($existingImage || $image)
                                    <button type="button" 
                                            wire:click="removeImage"
                                            wire:confirm="Remove this image?"
                                            class="text-xs text-red-500 hover:text-red-700 transition font-medium">
                                        Remove
                                    </button>
                                @endif
                            </div>
                            
                            <div class="relative group max-w-[200px] mx-auto">
                                <label class="relative block aspect-square w-full rounded-xl overflow-hidden cursor-pointer border-2 border-dashed border-gray-300 hover:border-[#1E7A4A] transition group">
                                    @if($image)
                                        <img src="{{ $image->temporaryUrl() }}" class="w-full h-full object-cover">
                                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex flex-col items-center justify-center">
                                            <svg class="w-8 h-8 text-white mb-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M4 8h16M4 4h16a1 1 0 011 1v14a1 1 0 01-1 1H4a1 1 0 01-1-1V5a1 1 0 011-1z"/>
                                            </svg>
                                            <span class="text-white text-sm font-medium">Update</span>
                                        </div>
                                    @elseif($existingImage)
                                        <img src="{{ Storage::url($existingImage) }}" class="w-full h-full object-cover">
                                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex flex-col items-center justify-center">
                                            <svg class="w-8 h-8 text-white mb-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M4 8h16M4 4h16a1 1 0 011 1v14a1 1 0 01-1 1H4a1 1 0 01-1-1V5a1 1 0 011-1z"/>
                                            </svg>
                                            <span class="text-white text-sm font-medium">Update</span>
                                        </div>
                                    @else
                                        <div class="absolute inset-0 flex flex-col items-center justify-center text-gray-400 group-hover:text-[#1E7A4A] transition">
                                            <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M4 8h16M4 4h16a1 1 0 011 1v14a1 1 0 01-1 1H4a1 1 0 01-1-1V5a1 1 0 011-1z"/>
                                            </svg>
                                            <span class="mt-2 text-sm font-medium">Click to upload</span>
                                            <span class="text-xs text-gray-400 mt-0.5">PNG or JPG, up to 2MB</span>
                                        </div>
                                    @endif
                                    <input type="file" wire:model="image" accept="image/*" class="hidden">
                                </label>
                            </div>
                            @error('image') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                            <div wire:loading wire:target="image" class="mt-2 text-xs text-gray-500 text-center">Uploading...</div>
                        </div>

                        <!-- Category - Mobile/Tablet -->
                        <div class="bg-gray-50 rounded-xl p-4 sm:p-5 border border-gray-200">
                            <h2 class="text-sm font-semibold text-[#1E7A4A] uppercase tracking-wider mb-3">Category</h2>
                            <select wire:model="category_id" 
                                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1E7A4A]/30">
                                <option value="">Select category</option>
                                @foreach($this->categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Status - Mobile/Tablet -->
                        <div class="bg-gray-50 rounded-xl p-4 sm:p-5 border border-gray-200">
                            <h2 class="text-sm font-semibold text-[#1E7A4A] uppercase tracking-wider mb-3">Status</h2>
                            <div class="flex items-center gap-4">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" wire:model="status" value="draft" class="hidden peer">
                                    <div class="w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center peer-checked:border-[#1E7A4A] peer-checked:bg-[#1E7A4A]/20 transition">
                                        <div class="w-2.5 h-2.5 rounded-full bg-[#1E7A4A] scale-0 peer-checked:scale-100 transition-all"></div>
                                    </div>
                                    <span class="text-sm text-gray-700 font-medium">Draft</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" wire:model="status" value="published" class="hidden peer">
                                    <div class="w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center peer-checked:border-[#1E7A4A] peer-checked:bg-[#1E7A4A]/20 transition">
                                        <div class="w-2.5 h-2.5 rounded-full bg-[#1E7A4A] scale-0 peer-checked:scale-100 transition-all"></div>
                                    </div>
                                    <span class="text-sm text-gray-700 font-medium">Published</span>
                                </label>
                            </div>
                            @error('status') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- MAIN FORM - LEFT COLUMN (2/3) -->
                        <div class="lg:col-span-2 space-y-6">
                            
                            <!-- BASIC INFORMATION -->
                            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                                <div class="px-4 sm:px-5 py-3 sm:py-4 border-b border-gray-100 bg-gray-50/50">
                                    <h2 class="text-sm font-semibold text-[#1E7A4A] uppercase tracking-wider">Basic Information</h2>
                                </div>
                                <div class="p-4 sm:p-5 space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Service Name</label>
                                        <input type="text" wire:model="name" 
                                               class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1E7A4A]/30 focus:border-[#1E7A4A] transition">
                                        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Description</label>
                                        <textarea wire:model="description" rows="4" 
                                                  class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1E7A4A]/30 focus:border-[#1E7A4A] transition"
                                                  placeholder="Describe your service..."></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- SERVICE DETAILS -->
                            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                                <div class="px-4 sm:px-5 py-3 sm:py-4 border-b border-gray-100 bg-gray-50/50">
                                    <h2 class="text-sm font-semibold text-[#1E7A4A] uppercase tracking-wider">Service Details</h2>
                                </div>
                                <div class="p-4 sm:p-5">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Price</label>
                                            <div class="relative">
                                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 font-medium">$</span>
                                                <input type="number" wire:model="price" step="0.01" min="0"
                                                       class="w-full pl-7 pr-4 py-2.5 rounded-lg border border-gray-300 text-sm focus:ring-2 focus:ring-[#1E7A4A]/30 focus:border-[#1E7A4A] transition">
                                            </div>
                                            @error('price') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1.5">Duration (minutes)</label>
                                            <input type="number" wire:model="duration_minutes" min="1"
                                                   class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1E7A4A]/30 focus:border-[#1E7A4A] transition"
                                                   placeholder="e.g. 60">
                                            @error('duration_minutes') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- SERVICE OPTIONS / VARIANTS -->
                            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden" id="variants-section">
                                <div class="px-4 sm:px-5 py-3 sm:py-4 border-b border-gray-100 bg-gray-50/50 flex items-center justify-between flex-wrap gap-2">
                                    <h2 class="text-sm font-semibold text-[#1E7A4A] uppercase tracking-wider">Service Options</h2>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" wire:model.live="hasVariants" class="sr-only peer">
                                        <span class="w-10 h-5 bg-gray-200 rounded-full peer-checked:bg-[#1E7A4A] transition-colors block"></span>
                                        <span class="absolute left-0.5 top-0.5 w-4 h-4 bg-white rounded-full shadow transition-transform peer-checked:translate-x-5"></span>
                                        <span class="ml-2 text-sm font-medium text-gray-700">Has options</span>
                                    </label>
                                </div>

                                <div class="p-4 sm:p-5">
                                    @if($hasVariants)
                                        @foreach($variants as $index => $variant)
                                            <div wire:key="variant-{{ $index }}" class="bg-gray-50 rounded-xl p-4 border border-gray-200 mb-3">
                                                <div class="flex flex-wrap gap-1.5 mb-3">
                                                    @foreach($variant['attributes'] as $optionName => $value)
                                                        <span class="text-xs font-semibold bg-white border border-gray-200 px-2.5 py-1 rounded-full text-gray-700">
                                                            {{ $optionName }}: {{ $value }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                                
                                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                                    <!-- Variant Image -->
                                                    <div>
                                                        <label class="block text-xs text-gray-500 font-medium mb-2">Option Image</label>
                                                        <div class="flex items-center gap-4">
                                                            <div class="relative group">
                                                                <label class="relative block w-20 h-20 rounded-xl overflow-hidden cursor-pointer border-2 border-dashed border-gray-300 hover:border-[#1E7A4A] transition group">
                                                                    @if(isset($variant['image']) && $variant['image'])
                                                                        <img src="{{ Storage::url($variant['image']) }}" class="w-full h-full object-cover">
                                                                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex flex-col items-center justify-center">
                                                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M4 8h16M4 4h16a1 1 0 011 1v14a1 1 0 01-1 1H4a1 1 0 01-1-1V5a1 1 0 011-1z"/>
                                                                            </svg>
                                                                            <span class="text-white text-xs font-medium">Update</span>
                                                                        </div>
                                                                    @else
                                                                        <div class="absolute inset-0 flex flex-col items-center justify-center text-gray-400 group-hover:text-[#1E7A4A] transition">
                                                                            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M4 8h16M4 4h16a1 1 0 011 1v14a1 1 0 01-1 1H4a1 1 0 01-1-1V5a1 1 0 011-1z"/>
                                                                            </svg>
                                                                            <span class="text-xs text-gray-400 mt-1">Upload</span>
                                                                        </div>
                                                                    @endif
                                                                    <input type="file" wire:model="variantImages.{{ $index }}" accept="image/*" class="hidden">
                                                                </label>
                                                                
                                                            @if(isset($variant['image']) && $variant['image'])
                <button type="button" 
                        wire:click="confirmRemoveVariantImage({{ $index }})"
                        class="absolute -top-1.5 -right-1.5 z-10 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 transition shadow-md"
                        style="pointer-events: auto;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            @endif
                                                            </div>
                                                            
                                                            <div class="flex-1">
                                                                <p class="text-xs text-gray-400">Click image to upload or change</p>
                                                                @error("variantImages.{$index}") <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
                                                                @if(isset($variantImages[$index]) && $variantImages[$index])
                                                                    <p class="text-xs text-green-600 mt-1 font-medium">✓ New image selected</p>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div>
                                                        <label class="block text-xs text-gray-500 font-medium mb-1.5">Price Adjustment</label>
                                                        <div class="relative">
                                                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs">$</span>
                                                            <input type="number" wire:model="variants.{{ $index }}.price_adjustment" step="0.01"
                                                                   class="w-full pl-6 pr-3 py-2 bg-white border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#1E7A4A]/30 text-sm">
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <label class="block text-xs text-gray-500 font-medium mb-1.5">Duration Adjustment (min)</label>
                                                        <input type="number" wire:model="variants.{{ $index }}.duration_adjustment"
                                                               class="w-full px-3 py-2 bg-white border border-gray-200 rounded-lg focus:ring-2 focus:ring-[#1E7A4A]/30 text-sm">
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="text-center py-8">
                                            <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                            </svg>
                                            <p class="text-sm text-gray-400">Toggle "Has options" above if this service comes in different durations, add-ons, or packages.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- SIDEBAR - RIGHT COLUMN (1/3) - DESKTOP ONLY -->
                        <div class="hidden lg:block lg:col-span-1 space-y-6">
                            
                            <!-- IMAGE UPLOAD -->
                            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                                <div class="px-5 py-4 border-b border-gray-100 bg-gray-50/50 flex items-center justify-between">
                                    <h2 class="text-sm font-semibold text-[#1E7A4A] uppercase tracking-wider">Service Image</h2>
                                    @if($existingImage || $image)
                                        <button type="button" 
                                                wire:click="removeImage"
                                                wire:confirm="Remove this image?"
                                                class="text-xs text-red-500 hover:text-red-700 transition font-medium">
                                            Remove Image
                                        </button>
                                    @endif
                                </div>
                                <div class="p-5">
                                    <div class="relative group">
                                        <label class="relative block aspect-square w-full rounded-xl overflow-hidden cursor-pointer border-2 border-dashed border-gray-300 hover:border-[#1E7A4A] transition group">
                                            @if($image)
                                                <img src="{{ $image->temporaryUrl() }}" class="w-full h-full object-cover">
                                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex flex-col items-center justify-center">
                                                    <svg class="w-8 h-8 text-white mb-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M4 8h16M4 4h16a1 1 0 011 1v14a1 1 0 01-1 1H4a1 1 0 01-1-1V5a1 1 0 011-1z"/>
                                                    </svg>
                                                    <span class="text-white text-sm font-medium">Update Image</span>
                                                </div>
                                            @elseif($existingImage)
                                                <img src="{{ Storage::url($existingImage) }}" class="w-full h-full object-cover">
                                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex flex-col items-center justify-center">
                                                    <svg class="w-8 h-8 text-white mb-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M4 8h16M4 4h16a1 1 0 011 1v14a1 1 0 01-1 1H4a1 1 0 01-1-1V5a1 1 0 011-1z"/>
                                                    </svg>
                                                    <span class="text-white text-sm font-medium">Update Image</span>
                                                </div>
                                            @else
                                                <div class="absolute inset-0 flex flex-col items-center justify-center text-gray-400 group-hover:text-[#1E7A4A] transition">
                                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M4 8h16M4 4h16a1 1 0 011 1v14a1 1 0 01-1 1H4a1 1 0 01-1-1V5a1 1 0 011-1z"/>
                                                    </svg>
                                                    <span class="mt-2 text-sm font-medium">Click to upload</span>
                                                    <span class="text-xs text-gray-400 mt-0.5">PNG or JPG, up to 2MB</span>
                                                </div>
                                            @endif
                                            <input type="file" wire:model="image" accept="image/*" class="hidden">
                                        </label>
                                    </div>
                                    @error('image') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                                    <div wire:loading wire:target="image" class="mt-2 text-xs text-gray-500">Uploading...</div>
                                </div>
                            </div>

                            <!-- CATEGORY -->
                            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                                <div class="px-5 py-4 border-b border-gray-100 bg-gray-50/50">
                                    <h2 class="text-sm font-semibold text-[#1E7A4A] uppercase tracking-wider">Category</h2>
                                </div>
                                <div class="p-5">
                                    <select wire:model="category_id" 
                                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#1E7A4A]/30 focus:border-[#1E7A4A] transition">
                                        <option value="">Select category</option>
                                        @foreach($this->categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <!-- STATUS -->
                            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
                                <div class="px-5 py-4 border-b border-gray-100 bg-gray-50/50">
                                    <h2 class="text-sm font-semibold text-[#1E7A4A] uppercase tracking-wider">Status</h2>
                                </div>
                                <div class="p-5">
                                    <div class="flex items-center gap-4">
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="radio" wire:model="status" value="draft" class="hidden peer">
                                            <div class="w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center peer-checked:border-[#1E7A4A] peer-checked:bg-[#1E7A4A]/20 transition">
                                                <div class="w-2.5 h-2.5 rounded-full bg-[#1E7A4A] scale-0 peer-checked:scale-100 transition-all"></div>
                                            </div>
                                            <span class="text-sm text-gray-700 font-medium">Draft</span>
                                        </label>
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="radio" wire:model="status" value="published" class="hidden peer">
                                            <div class="w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center peer-checked:border-[#1E7A4A] peer-checked:bg-[#1E7A4A]/20 transition">
                                                <div class="w-2.5 h-2.5 rounded-full bg-[#1E7A4A] scale-0 peer-checked:scale-100 transition-all"></div>
                                            </div>
                                            <span class="text-sm text-gray-700 font-medium">Published</span>
                                        </label>
                                    </div>
                                    @error('status') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- ACTION BUTTONS -->
                    <div class="flex justify-end gap-3 mt-6 sm:mb-10 pt-6 border-t border-gray-200">
                        <a href="{{ route('owner.service_management') }}" 
                           class="px-4 sm:px-6 py-2 sm:py-2.5 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition text-sm font-medium">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="px-6 sm:px-8 py-2 sm:py-2.5 bg-[#1E7A4A] text-white rounded-lg hover:bg-[#16633c] transition text-sm font-medium shadow-sm hover:shadow"
                                wire:loading.attr="disabled">
                            <span wire:loading.remove>Update Service</span>
                            <span wire:loading>Saving...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@include('layouts.partials.confirmation-modal')