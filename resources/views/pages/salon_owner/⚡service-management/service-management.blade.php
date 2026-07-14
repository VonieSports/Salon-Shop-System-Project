
<div>
    <div class="min-h-screen bg-gray-50">
    <div class="mx-auto space-y-6">

        @if (session()->has('message'))
            <div class="bg-green-50 text-green-700 px-5 py-3.5 rounded-xl text-sm font-medium">{{ session('message') }}</div>
        @endif
        @if (session()->has('error'))
            <div class="bg-red-50 text-red-700 px-5 py-3.5 rounded-xl text-sm font-medium">{{ session('error') }}</div>
        @endif

        @if (!$selectedPostId)

            {{-- ============ LIST VIEW ============ --}}
            <div class="flex items-start justify-between flex-wrap gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Services</h1>
                    <p class="text-gray-500 text-sm mt-1">Manage your service offerings</p>
                </div>
                <a href="{{ route('owner.create_service') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#1E7A4A] text-white rounded-full hover:bg-[#16633c] transition text-sm font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    New Service
                </a>
            </div>

            <div class="relative max-w-md">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" wire:model.live.debounce.400ms="search" placeholder="Search services..."
                       class="w-full pl-11 pr-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#1E7A4A]/30 focus:border-[#1E7A4A]/30 transition text-sm">
            </div>

            @if ($this->items->isEmpty())
                <div class="bg-white rounded-2xl border border-gray-100 p-16 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="mt-3 text-sm text-gray-500">No services found</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                    @foreach ($this->items as $item)
                        <button type="button" wire:click="viewItem({{ $item->id }})" wire:key="item-{{ $item->id }}"
                                class="text-left bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden hover:shadow-md hover:border-[#1E7A4A]/30 transition group">
                            <div class="aspect-square bg-gray-100 relative overflow-hidden">
                                @if($item->image)
                                    <img src="{{ Storage::url($item->image) }}" alt="{{ $item->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M4 8h16M4 4h16a1 1 0 011 1v14a1 1 0 01-1 1H4a1 1 0 01-1-1V5a1 1 0 011-1z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="p-4">
                                <p class="text-sm font-semibold text-gray-900 truncate">{{ $item->name }}</p>
                                <p class="text-xs text-gray-400 mt-0.5">{{ $item->serviceCategory?->name ?? 'Uncategorized' }}</p>
                                <div class="flex items-center justify-between mt-3">
                                    <span class="text-sm font-bold text-gray-900">${{ number_format($item->price ?? 0, 2) }}</span>
                                    <span class="px-2 py-0.5 text-[10px] font-semibold rounded-full {{ $item->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </div>
                            </div>
                        </button>
                    @endforeach
                </div>

                <div>{{ $this->items->links() }}</div>
            @endif

        @else

            {{-- ============ DETAIL VIEW ============ --}}
            @if ($this->selectedPost && $this->selectedService)
                @php
                    $post = $this->selectedPost;
                    $service = $this->selectedService;
                    $variants = $this->selectedVariants;
                    $gallery = $this->selectedGallery;
                @endphp

                <div class="bg-gray-900 rounded-3xl overflow-hidden text-white" x-data="{ activeImage: 0 }">

                    <div class="flex items-center justify-between px-6 py-4 border-b border-white/10">
                        <button wire:click="closeItem" class="p-2 rounded-lg hover:bg-white/10 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                        </button>

                        <div class="flex items-center gap-3">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" wire:click="toggleStatus({{ $post->id }})" @checked($post->status === 'published') class="sr-only peer">
                                <span class="w-10 h-5 bg-gray-700 rounded-full peer-checked:bg-emerald-500 transition-colors block"></span>
                                <span class="absolute left-0.5 top-0.5 w-4 h-4 bg-white rounded-full shadow transition-transform peer-checked:translate-x-5"></span>
                                <span class="ml-2 text-sm font-medium">{{ $post->status === 'published' ? 'Published' : 'Draft' }}</span>
                            </label>

                            <a href="{{ route('owner.update_service', $post->id) }}"
                               class="px-4 py-2 bg-emerald-500 text-white rounded-full hover:bg-emerald-600 transition text-sm font-semibold">
                                Edit
                            </a>

                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="p-2 rounded-lg hover:bg-white/10 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v.01M12 12v.01M12 19v.01"/>
                                    </svg>
                                </button>
                                <div x-show="open" @click.away="open = false" x-cloak
                                     class="absolute right-0 mt-2 w-40 bg-white text-gray-900 rounded-xl shadow-xl border border-gray-100 py-1 z-10">
                                    <button wire:click="deleteItem({{ $post->id }})"
                                            onclick="return confirm('Delete this service? This cannot be undone.')"
                                            class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition">
                                        Delete
                                    </button>
                                </div>
                            </div>

                            <div class="flex items-center gap-1 ml-2">
                                <button wire:click="navigateItem('prev')" class="p-2 rounded-lg hover:bg-white/10 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                                </button>
                                <button wire:click="navigateItem('next')" class="p-2 rounded-lg hover:bg-white/10 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 space-y-6">
                        <div>
                            <h1 class="text-2xl font-bold">{{ $post->name }}</h1>
                            <div class="flex items-center gap-2 mt-2 flex-wrap">
                                @if ($variants->count() > 0)
                                    <span class="px-2.5 py-1 bg-emerald-500/15 text-emerald-400 text-xs font-semibold rounded-full">{{ $variants->count() }} options</span>
                                @endif
                                <span class="text-gray-400 text-sm">{{ $post->serviceCategory?->name ?? 'Uncategorized' }}</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                            <div class="lg:col-span-5 space-y-5">
                                <div class="aspect-square bg-white/5 rounded-2xl overflow-hidden relative">
                                    @if($gallery->isNotEmpty())
                                        <template x-for="(img, i) in @js($gallery)" :key="i">
                                            <img :src="'{{ Storage::url('') }}' + img" x-show="activeImage === i" class="w-full h-full object-cover">
                                        </template>
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-600">
                                            <svg class="w-10 h-10" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M4 8h16M4 4h16a1 1 0 011 1v14a1 1 0 01-1 1H4a1 1 0 01-1-1V5a1 1 0 011-1z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                @if($gallery->count() > 1)
                                    <div class="flex gap-2 overflow-x-auto">
                                        @foreach($gallery as $i => $img)
                                            <button @click="activeImage = {{ $i }}"
                                                    :class="activeImage === {{ $i }} ? 'ring-2 ring-emerald-500' : 'ring-1 ring-white/10'"
                                                    class="relative w-16 h-16 rounded-lg overflow-hidden shrink-0 transition">
                                                <img src="{{ Storage::url($img) }}" class="w-full h-full object-cover">
                                                @if ($i === 0)
                                                    <span class="absolute bottom-0 inset-x-0 bg-black/70 text-[8px] text-center py-0.5">PRIMARY</span>
                                                @endif
                                            </button>
                                        @endforeach
                                    </div>
                                @endif

                                <div class="bg-white/5 rounded-2xl p-5 space-y-3">
                                    <h3 class="text-sm font-bold text-gray-300 uppercase tracking-wide">Details</h3>
                                    <div class="grid grid-cols-2 gap-y-2 text-sm">
                                        <span class="text-gray-500">Category</span>
                                        <span class="text-right">{{ $post->serviceCategory?->name ?? 'Uncategorized' }}</span>
                                        <span class="text-gray-500">Duration</span>
                                        <span class="text-right">{{ $service->duration_minutes ? $service->duration_minutes . ' min' : '—' }}</span>
                                        <span class="text-gray-500">Active</span>
                                        <span class="text-right">{{ $service->is_active ? 'Yes' : 'No' }}</span>
                                        <span class="text-gray-500">Created</span>
                                        <span class="text-right">{{ $post->created_at->format('M j, Y') }}</span>
                                        <span class="text-gray-500">Updated</span>
                                        <span class="text-right">{{ $post->updated_at->diffForHumans() }}</span>
                                    </div>
                                    @if ($post->description)
                                        <div class="pt-2 border-t border-white/10">
                                            <p class="text-gray-500 text-xs mb-1">Description</p>
                                            <p class="text-sm text-gray-300">{{ $post->description }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="lg:col-span-7">
                                <h3 class="text-sm font-bold text-gray-300 uppercase tracking-wide mb-3">
                                    {{ $variants->count() > 0 ? 'Options' : 'Pricing' }}
                                </h3>

                                @if ($variants->isEmpty())
                                    <div class="bg-white/5 rounded-2xl p-5">
                                        <div class="flex items-center justify-between">
                                            <span class="text-gray-400 text-sm">Base price</span>
                                            <span class="text-xl font-bold">${{ number_format($service->price ?? 0, 2) }}</span>
                                        </div>
                                        <div class="flex items-center justify-between mt-3 pt-3 border-t border-white/10">
                                            <span class="text-gray-400 text-sm">Duration</span>
                                            <span class="font-semibold">{{ $service->duration_minutes ? $service->duration_minutes . ' min' : '—' }}</span>
                                        </div>
                                    </div>
                                @else
                                    <div class="space-y-2.5 max-h-[520px] overflow-y-auto pr-1">
                                        @foreach ($variants as $variant)
                                            <div class="bg-white/5 hover:bg-white/[0.07] rounded-xl p-4 border border-white/10 transition">
                                                <div class="flex items-center gap-3">
                                                    @if($variant->image)
                                                        <img src="{{ Storage::url($variant->image) }}" class="w-12 h-12 rounded-lg object-cover shrink-0">
                                                    @else
                                                        <div class="w-12 h-12 rounded-lg bg-white/10 shrink-0"></div>
                                                    @endif

                                                    <div class="flex-1 min-w-0">
                                                        <p class="text-sm font-semibold truncate">
                                                            {{ collect($variant->attributes)->map(fn($v) => $v)->implode(' / ') }}
                                                        </p>
                                                        <p class="text-xs text-gray-500 font-mono">{{ $variant->sku }}</p>
                                                    </div>

                                                    <div class="text-right shrink-0">
                                                        <p class="text-sm font-bold">${{ number_format(($service->price ?? 0) + $variant->price_adjustment, 2) }}</p>
                                                        @if ($variant->duration_adjustment)
                                                            <p class="text-xs text-gray-500">
                                                                {{ ($service->duration_minutes ?? 0) + $variant->duration_adjustment }} min
                                                            </p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-2xl border border-gray-100 p-16 text-center">
                    <p class="text-sm text-gray-500">Service not found.</p>
                    <button wire:click="closeItem" class="mt-3 text-sm font-medium text-[#1E7A4A] hover:underline">Back to services</button>
                </div>
            @endif

        @endif
    </div>
</div>
    {{-- The biggest battle is the war against ignorance. - Mustafa Kemal Atatürk --}}
</div>