@php
    $post = $this->selectedPost;
    $service = $this->selectedService;
    $variants = $this->selectedVariants ? collect($this->selectedVariants) : collect();
    $gallery = $this->selectedGallery ? collect($this->selectedGallery) : collect();
    
    $variantImages = $variants->pluck('image')->filter()->values();
    $hasVariantImages = $variantImages->count() > 0;
    $totalImages = $variantImages->count();
    
    $displayImages = $variantImages->take(4);
    $remaining = $totalImages - 4;
    $hasMore = $remaining > 0;
@endphp

@if ($selectedPostId)
    <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ showVariantGallery: false }">
        <div class="flex items-center justify-center min-h-screen p-3 sm:p-4 md:p-6">
            <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" wire:click="closeItem"></div>
            
            <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-4xl max-h-[92vh] overflow-hidden mx-auto">
                @if ($post && $service)
                    <!-- Header -->
                    <div class="flex items-center justify-between px-4 sm:px-6 py-3 border-b border-gray-100 bg-white shrink-0">
                        <button wire:click="closeItem" class="p-2 rounded-full hover:bg-gray-100 transition">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>

                        <div class="flex items-center gap-2 sm:gap-3">
                            <!-- Status -->
                            <div class="flex items-center gap-2">
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" wire:click="toggleStatus({{ $post->id }})" 
                                           @checked($post->status === 'published') class="sr-only peer">
                                    <span class="w-9 h-5 bg-gray-300 rounded-full peer-checked:bg-emerald-500 transition-colors block"></span>
                                    <span class="absolute left-0.5 top-0.5 w-4 h-4 bg-white rounded-full shadow transition-transform peer-checked:translate-x-4"></span>
                                </label>
                                <span class="text-sm font-medium text-gray-700 min-w-[55px]">
                                    {{ $post->status === 'published' ? 'Published' : 'Draft' }}
                                </span>
                            </div>

                            <a href="{{ route('owner.update_service', $post->id) }}"
                               class="px-4 py-1.5 bg-[#1E7A4A] text-white rounded-full hover:bg-[#16633c] transition text-sm font-medium">
                                Update
                            </a>

                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="p-2 rounded-full hover:bg-gray-100 transition">
                                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v.01M12 12v.01M12 19v.01"/>
                                    </svg>
                                </button>
                                <div x-show="open" @click.away="open = false" x-cloak
                                     class="absolute right-0 mt-2 w-36 bg-white rounded-xl shadow-lg border border-gray-200 py-1 z-10">
                                   <button wire:click="deleteItem({{ $post->id }})"
                                        onclick="return confirm('Archive this service? You can restore it later from the Archive page.')"
                                        class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition">
                                        Delete this item
                                    </button>
                                </div>
                            </div>

                            <div class="flex items-center gap-0.5 ml-1">
                                <button wire:click="navigateItem('prev')" class="p-2 rounded-full hover:bg-gray-100 transition">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                                    </svg>
                                </button>
                                <button wire:click="navigateItem('next')" class="p-2 rounded-full hover:bg-gray-100 transition">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="overflow-y-auto p-4 sm:p-6" style="max-height: calc(92vh - 110px);">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
                            <!-- Left: Images -->
                            <div class="space-y-4">
                                <!-- Main Image -->
                                <div class="aspect-square bg-gray-50 rounded-xl overflow-hidden relative border border-gray-200">
                                    @if($gallery->isNotEmpty() && isset($gallery[0]) && $gallery[0])
                                        <img src="{{ Storage::url($gallery[0]) }}" 
                                             alt="{{ $post->name }}"
                                             class="w-full h-full object-contain p-4">
                                    @else
                                        <div class="w-full h-full flex flex-col items-center justify-center text-gray-300">
                                            <svg class="w-16 h-16" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M4 8h16M4 4h16a1 1 0 011 1v14a1 1 0 01-1 1H4a1 1 0 01-1-1V5a1 1 0 011-1z"/>
                                            </svg>
                                            <span class="text-sm text-gray-400 mt-2">No image</span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Option Images -->
                                @if($hasVariantImages)
                                    <div>
                                        <p class="text-xs text-gray-500 font-medium uppercase tracking-wider mb-2">Option Images</p>
                                        <div class="grid grid-cols-4 gap-2">
                                            @php
                                                $imagesToShow = $variantImages->take(4);
                                                $hasMoreImages = $variantImages->count() > 4;
                                                $remainingCount = $variantImages->count() - 4;
                                            @endphp
                                            
                                            @foreach($imagesToShow as $index => $img)
                                                <div class="relative aspect-square rounded-lg overflow-hidden border border-gray-200">
                                                    <img src="{{ Storage::url($img) }}" 
                                                         alt="Option image {{ $index + 1 }}"
                                                         class="w-full h-full object-cover">
                                                    
                                                    @if($hasMoreImages && $index === 3)
                                                        <div class="absolute inset-0 bg-black/50 flex flex-col items-center justify-center cursor-pointer hover:bg-black/60 transition"
                                                             @click="showVariantGallery = true">
                                                            <span class="text-xl font-bold text-white">+{{ $remainingCount }}</span>
                                                            <span class="text-xs text-white/70">View all</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach

                                            @if($variantImages->count() < 4)
                                                @for($i = 0; $i < (4 - $variantImages->count()); $i++)
                                                    <div class="aspect-square rounded-lg border-2 border-dashed border-gray-200 bg-gray-50 flex items-center justify-center">
                                                        <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M4 8h16M4 4h16a1 1 0 011 1v14a1 1 0 01-1 1H4a1 1 0 01-1-1V5a1 1 0 011-1z"/>
                                                        </svg>
                                                    </div>
                                                @endfor
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Right: Details -->
                            <div class="space-y-4">
                                <div>
                                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900 leading-tight">{{ $post->name }}</h1>
                                    <div class="flex items-center gap-2 mt-1 flex-wrap">
                                        <span class="text-sm text-gray-500">{{ $post->serviceCategory?->name ?? 'Uncategorized' }}</span>
                                    </div>
                                </div>

                                <!-- Price & Duration -->
                                <div class="flex flex-wrap items-center gap-6 p-4 bg-gray-50 rounded-xl">
                                    <div>
                                        <span class="text-xs text-gray-400 font-medium uppercase tracking-wider block">Price</span>
                                        <span class="text-2xl font-bold text-[#1E7A4A]">${{ number_format($service->price ?? 0, 2) }}</span>
                                    </div>
                                    <div class="w-px h-10 bg-gray-300"></div>
                                    <div>
                                        <span class="text-xs text-gray-400 font-medium uppercase tracking-wider block">Duration</span>
                                        <span class="text-xl font-semibold text-gray-800">{{ $service->duration_minutes ? $service->duration_minutes . ' min' : '—' }}</span>
                                    </div>
                                    @if($variants && $variants->count() > 0)
                                        <div class="w-px h-10 bg-gray-300"></div>
                                        <div>
                                            <span class="text-xs text-gray-400 font-medium uppercase tracking-wider block">Options</span>
                                            <span class="text-xl font-semibold text-gray-800">{{ $variants->count() }}</span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Details Grid -->
                                <div class="grid grid-cols-2 gap-x-4 gap-y-3 pt-3 border-t border-gray-100">
                                    <div>
                                        <span class="text-xs text-gray-400 font-medium uppercase tracking-wider">Category</span>
                                        <p class="text-sm text-gray-800 mt-1">{{ $post->serviceCategory?->name ?? 'Uncategorized' }}</p>
                                    </div>
                                    <div>
                                        <span class="text-xs text-gray-400 font-medium uppercase tracking-wider">Status</span>
                                        <p class="text-sm text-gray-800 mt-1">
                                            <span class="inline-flex items-center gap-2">
                                                <span class="w-2.5 h-2.5 rounded-full {{ $service->is_active ? 'bg-emerald-500' : 'bg-yellow-500' }}"></span>
                                                <span>{{ $service->is_active ? 'Active' : 'Inactive' }}</span>
                                            </span>
                                        </p>
                                    </div>
                                    <div>
                                        <span class="text-xs text-gray-400 font-medium uppercase tracking-wider">Added</span>
                                        <p class="text-sm text-gray-800 mt-1">{{ $post->created_at->format('M d, Y') }}</p>
                                    </div>
                                    @if($service->booking_buffer_minutes)
                                        <div>
                                            <span class="text-xs text-gray-400 font-medium uppercase tracking-wider">Buffer Time</span>
                                            <p class="text-sm text-gray-800 mt-1">{{ $service->booking_buffer_minutes }} min</p>
                                        </div>
                                    @endif
                                </div>
                                
                                @if ($post->description)
                                    <div class="pt-3 border-t border-gray-100">
                                        <span class="text-xs text-gray-400 font-medium uppercase tracking-wider">Description</span>
                                        <p class="text-sm text-gray-600 leading-relaxed mt-1.5">{{ $post->description }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    @include('layouts.partials.variant-gallery-modal', ['variantImages' => $variantImages, 'variants' => $variants, 'product' => null, 'service' => $service])
                @else
                    <div class="p-12 text-center">
                        <div class="max-w-sm mx-auto">
                            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-gray-500">Service not found</p>
                            <button wire:click="closeItem" class="mt-4 text-sm font-medium text-[#1E7A4A] hover:underline">Close</button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endif