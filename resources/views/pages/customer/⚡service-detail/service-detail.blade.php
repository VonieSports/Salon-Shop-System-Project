<!-- resources/views/livewire/pages/customer/service-detail.blade.php -->
<div class="min-h-screen bg-[#F5F5F5]" x-data="{ activeTab: 'description' }">
    
    <!-- Alerts -->
    @if (session()->has('message') || session()->has('error') || session()->has('warning'))
        <div class="max-w-7xl mx-auto px-4 pt-3">
            @if (session()->has('message'))
                <div class="bg-[#FCE9ED] border border-[#D6657A]/30 text-[#7A3B4A] px-3 py-2 rounded-lg text-sm font-medium flex items-center gap-2">
                    <svg class="w-4 h-4 text-[#D6657A] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('message') }}
                </div>
            @endif
            @if (session()->has('warning'))
                <div class="bg-[#FFF3E0] border border-[#FFE0B2] text-[#E65100] px-3 py-2 rounded-lg text-sm font-medium flex items-center gap-2">
                    <svg class="w-4 h-4 text-[#E65100] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    {{ session('warning') }}
                </div>
            @endif
            @if (session()->has('error'))
                <div class="bg-[#FDE8E8] border border-[#D6657A]/40 text-[#7A2E3A] px-3 py-2 rounded-lg text-sm font-medium flex items-center gap-2">
                    <svg class="w-4 h-4 text-[#D6657A] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    {{ session('error') }}
                </div>
            @endif
        </div>
    @endif

    <div class="max-w-7xl mx-auto px-3 sm:px-4 py-3 sm:py-4">

        <!-- Auto-refresh every 60 seconds to keep date updated -->
        <div wire:poll.60s="refreshDates" class="hidden"></div>

        <!-- Breadcrumb -->
        <nav class="flex items-center gap-1 text-xs text-[#666] mb-3 overflow-x-auto whitespace-nowrap">
            <a href="{{ route('customer.dashboard') }}" class="hover:text-[#D6657A] transition">Home</a>
            <svg class="w-3 h-3 flex-shrink-0 text-[#999]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
            <a href="#" class="hover:text-[#D6657A] transition">{{ $service->serviceCategory?->name ?? 'Services' }}</a>
            <svg class="w-3 h-3 flex-shrink-0 text-[#999]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-[#333] font-medium truncate max-w-32 sm:max-w-xs">{{ $service->name }}</span>
        </nav>

        <!-- Main Service Card - Shopee Style Layout -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-4 p-4">

                <!-- Left: Images - 2 columns -->
                <div class="lg:col-span-2">
                    <div class="relative bg-[#FAFAFA] rounded-lg overflow-hidden aspect-square border border-[#EFEFEF]">
                        @if ($service->image)
                            <img src="{{ Storage::url($service->image) }}" alt="{{ $service->name }}" class="w-full h-full object-contain p-3">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-[#D6657A]/30">
                                <svg class="w-16 h-16" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif

                        <!-- Badges -->
                        <div class="absolute top-2 left-2 flex gap-1.5">
                            <span class="px-2 py-0.5 bg-[#D6657A]/90 text-white text-[10px] font-medium rounded-full flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                Service
                            </span>
                            @if($service->duration_minutes)
                                <span class="px-2 py-0.5 bg-[#D6657A]/80 text-white text-[10px] font-medium rounded-full flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $service->duration_minutes }}m
                                </span>
                            @endif
                        </div>

                        <!-- Share & Favorite -->
                        <div class="flex items-center gap-4 mt-2 text-xs text-[#666]">
                            <button class="flex items-center gap-1 hover:text-[#D6657A] transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                                </svg>
                                Share
                            </button>
                            <button class="flex items-center gap-1 hover:text-[#D6657A] transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                                </svg>
                                Favorite
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Right: Details - 3 columns -->
                <div class="lg:col-span-3 space-y-3">
                    
                    <!-- Shop -->
                    @if ($service->tenant)
                        <div class="flex items-center gap-2 text-xs">
                            <span class="text-[#666]">Shop:</span>
                            <a href="#" class="text-[#D6657A] font-medium hover:underline">{{ $service->tenant->name }}</a>
                            <span class="text-[10px] bg-[#FCE9ED] text-[#D6657A] px-1.5 py-0.5 rounded-full font-medium">Official</span>
                        </div>
                    @endif

                    <!-- Title -->
                    <h1 class="text-lg sm:text-xl font-medium text-[#222] leading-snug">{{ $service->name }}</h1>

                    <!-- Rating & Duration -->
                    <div class="flex items-center flex-wrap gap-2 text-xs">
                        <div class="flex items-center gap-0.5">
                            <span class="text-amber-400 text-sm">★★★★★</span>
                            <span class="text-[#D6657A] ml-0.5 font-medium">{{ $this->ratingCount }}</span>
                            <span class="text-[#666]">Ratings</span>
                        </div>
                        <span class="text-[#CCC]">|</span>
                        <span class="flex items-center gap-1 text-[#666]">
                            <svg class="w-3.5 h-3.5 text-[#D6657A]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-[#222] font-medium">{{ $service->duration_minutes ?? '30' }}</span> min
                        </span>
                        <span class="text-[#CCC]">|</span>
                        <span class="flex items-center gap-1 text-[#666]">
                            <svg class="w-3.5 h-3.5 text-[#D6657A]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            {{ $service->tenant?->address ?? 'Location not set' }}
                        </span>
                    </div>

                    <!-- Price -->
                    <div class="bg-[#FAFAFA] rounded-lg p-3 border border-[#EFEFEF]">
                        <div class="flex items-end gap-2">
                            <p class="text-2xl font-bold text-[#D6657A]">
                                ₱{{ number_format($service->price ?? 0, 2) }}
                            </p>
                            @if($service->duration_minutes)
                                <span class="text-xs text-[#999] mb-0.5">/ {{ $service->duration_minutes }} min</span>
                            @endif
                        </div>
                    </div>

                    <!-- Errors -->
                    @error('employee') <p class="text-[10px] text-[#C25467] font-normal">{{ $message }}</p> @enderror
                    @error('date') <p class="text-[10px] text-[#C25467] font-normal">{{ $message }}</p> @enderror

                    <!-- Description -->
                    <div class="border-t border-[#EFEFEF] pt-2">
                        <div class="text-sm text-[#666] leading-relaxed">
                            @if($service->description)
                                <p>{{ $service->description }}</p>
                            @else
                                <p class="text-[#999] italic">No description available for this service.</p>
                            @endif
                        </div>
                    </div>

                    <!-- Booking Section -->
                    <div class="border-t border-[#EFEFEF] pt-2 space-y-2.5">
                        
                        <!-- Date Selection -->
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label class="text-xs font-medium text-[#666]">Select Date</label>
                                <div class="flex items-center gap-2">
                                    <span class="text-[10px] text-[#999]">Today: {{ now()->format('M j') }}</span>
                                    <button wire:click="refreshDates" 
                                            class="text-[10px] text-[#D6657A] hover:underline transition">
                                        ↻ Reset
                                    </button>
                                </div>
                            </div>
                            <div class="grid grid-cols-7 gap-1">
                                @php $dates = $this->getDateAvailability(); @endphp
                                @foreach(array_slice($dates, 0, 14) as $date)
                                    <button wire:key="date-{{ $date['date'] }}" 
                                            wire:click="selectDate('{{ $date['date'] }}')"
                                            @disabled(!$date['available'])
                                            class="text-center py-1.5 px-0.5 rounded border transition text-[10px]
                                                {{ $selectedDate === $date['date'] 
                                                    ? 'border-[#D6657A] bg-[#D6657A] text-white' 
                                                    : ($date['available'] 
                                                        ? 'border-[#EFEFEF] hover:border-[#D6657A] text-[#333]' 
                                                        : 'border-[#EFEFEF] text-[#CCC] cursor-not-allowed opacity-50') }}">
                                        <div class="font-medium">{{ $date['is_today'] ? 'Today' : substr($date['display'], 0, 3) }}</div>
                                        <div class="text-[8px] {{ $selectedDate === $date['date'] ? 'text-white/80' : 'text-[#999]' }}">
                                            {{ substr($date['display'], 4) }}
                                        </div>
                                    </button>
                                @endforeach
                            </div>
                            
                            <!-- Shop Hours Status -->
                            @php $hours = $this->shopHoursForSelectedDate; @endphp
                            <div class="mt-1.5 flex items-center gap-2 text-[11px]">
                                <span class="inline-flex items-center gap-1 {{ $hours['open'] ? 'text-[#2E7D32]' : 'text-[#C62828]' }}">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $hours['label'] }}
                                </span>
                            </div>
                        </div>

                        <!-- Staff Selection -->
                        <div>
                            <label class="text-xs font-medium text-[#666] block mb-1.5">Choose Staff</label>
                            
                            @if(!$this->hasAssignedStaff)
                                <div class="bg-[#FCE9ED] border border-[#D6657A]/30 rounded-lg p-2.5 flex items-start gap-2">
                                    <svg class="w-4 h-4 text-[#D6657A] shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                    <div>
                                        <p class="text-xs font-medium text-[#7A3B4A]">No Staff Assigned</p>
                                        <p class="text-[10px] text-[#7A3B4A]/70">This service currently has no staff available.</p>
                                    </div>
                                </div>
                            @elseif($this->employeeAvailability->isEmpty())
                                <div class="bg-[#FAFAFA] rounded-lg p-2.5 text-center text-xs text-[#999]">
                                    No staff available on this date
                                </div>
                            @else
                                <div class="space-y-1.5 max-h-40 overflow-y-auto pr-1">
                                    @foreach($this->employeeAvailability as $row)
                                        <button wire:key="emp-{{ $row['employee']->id }}" 
                                                wire:click="toggleEmployee({{ $row['employee']->id }})"
                                                @disabled(!$row['on_duty'])
                                                class="w-full flex items-center gap-3 p-2 rounded-lg border transition text-left
                                                    {{ $selectedEmployeeId === $row['employee']->id 
                                                        ? 'border-[#D6657A] bg-[#FCE9ED]' 
                                                        : ($row['on_duty'] 
                                                            ? 'border-[#EFEFEF] hover:border-[#D6657A]/50' 
                                                            : 'border-[#EFEFEF] opacity-40 cursor-not-allowed') }}">
                                            
                                            <div class="w-9 h-9 rounded-full bg-[#FCE9ED] flex items-center justify-center shrink-0 overflow-hidden">
                                                @if($row['employee']->user?->avatar)
                                                    <img src="{{ Storage::url($row['employee']->user->avatar) }}" 
                                                         class="w-full h-full object-cover">
                                                @else
                                                    <span class="text-xs font-bold text-[#D6657A]">
                                                        {{ strtoupper(substr($row['employee']->user?->name ?? 'S', 0, 1)) }}
                                                    </span>
                                                @endif
                                            </div>
                                            
                                            <div class="flex-1 min-w-0">
                                                <p class="text-xs font-medium text-[#333]">{{ $row['employee']->user?->name }}</p>
                                                <p class="text-[10px] {{ $row['on_duty'] ? ($row['is_busy'] ? 'text-amber-600' : 'text-[#2E7D32]') : 'text-[#999]' }}">
                                                    @if(!$row['on_duty'])
                                                        Not on duty
                                                    @elseif($row['is_busy'])
                                                        {{ $row['queue_length'] }} in queue
                                                    @else
                                                        Available now
                                                        <span class="inline-block w-1.5 h-1.5 rounded-full bg-[#2E7D32] animate-pulse ml-1"></span>
                                                    @endif
                                                </p>
                                            </div>
                                            
                                            @if($selectedEmployeeId === $row['employee']->id)
                                                <svg class="w-4 h-4 text-[#D6657A] shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                            @endif
                                        </button>
                                    @endforeach
                                </div>
                            @endif
                            
                            @error('employee')
                                <p class="text-[10px] text-[#C25467] mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Booking Summary -->
                        @if($selectedEmployeeId && $this->canBook)
                            <div class="bg-[#FAFAFA] rounded-lg p-3 border border-[#EFEFEF]">
                                <p class="text-xs font-medium text-[#333] mb-1.5">Booking Summary</p>
                                <div class="space-y-1 text-xs text-[#666]">
                                    <div class="flex justify-between">
                                        <span>Service:</span>
                                        <span class="font-medium text-[#333]">{{ $service->name }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Date:</span>
                                        <span class="font-medium text-[#333]">{{ \Carbon\Carbon::parse($selectedDate)->format('M d, Y') }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Duration:</span>
                                        <span class="font-medium text-[#333]">{{ $service->duration_minutes ?? '30' }} minutes</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span>Staff:</span>
                                        @php
                                            $selected = $this->employeeAvailability->firstWhere('employee.id', $selectedEmployeeId);
                                        @endphp
                                        <span class="font-medium text-[#333]">{{ $selected['employee']->user?->name ?? 'Selected' }}</span>
                                    </div>
                                    <div class="border-t border-[#EFEFEF] pt-1 mt-1">
                                        <div class="flex justify-between font-medium">
                                            <span>Total:</span>
                                            <span class="text-[#D6657A]">₱{{ number_format($service->price ?? 0, 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Action Buttons -->
                        <div class="grid grid-cols-2 gap-2 pt-1">
                            <button wire:click="bookService"
                                    @disabled(!$this->canBook)
                                    class="w-full py-2.5 bg-[#D6657A] hover:bg-[#C25467] text-white font-semibold rounded-lg transition disabled:opacity-50 disabled:cursor-not-allowed text-sm">
                                <svg class="w-4 h-4 inline mr-1.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Book Now
                            </button>
                            <button class="w-full py-2.5 border-2 border-[#D6657A] text-[#D6657A] font-semibold rounded hover:bg-[#D6657A] hover:text-white transition text-sm">
                                <svg class="w-4 h-4 inline mr-1.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                                Save
                            </button>
                        </div>
                        <p class="text-[9px] text-[#999] text-center">You'll be redirected to checkout</p>

                        <!-- Trust Badges -->
                        <div class="border-t border-[#EFEFEF] pt-2">
                            <div class="flex flex-wrap gap-4 text-xs text-[#666]">
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4 text-[#D6657A]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                    Expert Staff
                                </span>
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4 text-[#D6657A]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                    </svg>
                                    Secure Payment
                                </span>
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4 text-[#D6657A]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                    </svg>
                                    Best Price
                                </span>
                                <span class="flex items-center gap-1">
                                    <svg class="w-4 h-4 text-[#D6657A]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $service->duration_minutes ?? '30' }} min
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs Section -->
        <div class="mt-3 bg-white rounded-lg shadow-sm border border-[#EFEFEF] overflow-hidden">
            <div class="border-b border-[#EFEFEF] px-4 overflow-x-auto">
                <div class="flex gap-6 min-w-max">
                    <button @click="activeTab = 'description'" 
                            class="py-2.5 text-sm font-medium border-b-2 -mb-px transition whitespace-nowrap" 
                            :class="activeTab === 'description' ? 'border-[#D6657A] text-[#D6657A]' : 'border-transparent text-[#666] hover:text-[#D6657A]'">
                        Service Description
                    </button>
                    <button @click="activeTab = 'specifications'" 
                            class="py-2.5 text-sm font-medium border-b-2 -mb-px transition whitespace-nowrap"
                            :class="activeTab === 'specifications' ? 'border-[#D6657A] text-[#D6657A]' : 'border-transparent text-[#666] hover:text-[#D6657A]'">
                        Specifications
                    </button>
                    <button @click="activeTab = 'reviews'" 
                            class="py-2.5 text-sm font-medium border-b-2 -mb-px transition flex items-center gap-1.5 whitespace-nowrap"
                            :class="activeTab === 'reviews' ? 'border-[#D6657A] text-[#D6657A]' : 'border-transparent text-[#666] hover:text-[#D6657A]'">
                        Reviews
                        <span class="bg-[#FCE9ED] text-[#7A3B4A] text-[10px] px-1.5 py-0.5 rounded-full">{{ $this->ratingCount }}</span>
                    </button>
                </div>
            </div>

            <div class="px-4 py-4">
                <!-- Description Tab -->
                <div x-show="activeTab === 'description'" x-cloak>
                    <div class="max-w-3xl">
                        @if ($service->description)
                            <div class="text-[#333] leading-relaxed whitespace-pre-wrap text-sm">{{ $service->description }}</div>
                        @else
                            <p class="text-[#999] italic text-sm">No description available.</p>
                        @endif

                        @if (!empty($service->additional_info) && is_array($service->additional_info))
                            @php
                                $items = $service->additional_info['items'] ?? [];
                                $sectionName = $service->additional_info['section_name'] ?? null;
                            @endphp
                            @if (!empty($items))
                                <div class="mt-3 pt-3 border-t border-[#EFEFEF]">
                                    @if ($sectionName)
                                        <h4 class="text-sm font-semibold text-[#333] mb-2">{{ $sectionName }}</h4>
                                    @endif
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-1.5">
                                        @foreach ($items as $info)
                                            @if (!empty($info['label']) && !empty($info['value']))
                                                <div class="flex items-baseline gap-2 text-sm">
                                                    <span class="text-[#666] min-w-[80px]">{{ $info['label'] }}:</span>
                                                    <span class="text-[#333] font-medium">{{ $info['value'] }}</span>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>

                <!-- Specifications Tab -->
                <div x-show="activeTab === 'specifications'" x-cloak>
                    <div class="max-w-3xl">
                        <div class="bg-[#FAFAFA] rounded-lg overflow-hidden border border-[#EFEFEF]">
                            <table class="w-full text-sm">
                                <tbody>
                                    <tr class="border-b border-[#EFEFEF]">
                                        <td class="px-4 py-2.5 text-[#666] font-medium w-1/3">Category</td>
                                        <td class="px-4 py-2.5 text-[#333]">{{ $service->serviceCategory?->name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr class="border-b border-[#EFEFEF]">
                                        <td class="px-4 py-2.5 text-[#666] font-medium">Duration</td>
                                        <td class="px-4 py-2.5 text-[#333]">{{ $service->duration_minutes ?? '30' }} minutes</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-2.5 text-[#666] font-medium">Type</td>
                                        <td class="px-4 py-2.5 text-[#333] capitalize">{{ $service->type ?? 'Service' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Reviews Tab -->
                <div x-show="activeTab === 'reviews'" x-cloak>
                    <div class="text-center py-8">
                        <div class="w-16 h-16 mx-auto mb-3 bg-[#FAFAFA] rounded-full flex items-center justify-center border border-[#EFEFEF]">
                            <svg class="w-8 h-8 text-[#D6657A]/30" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"/>
                            </svg>
                        </div>
                        <p class="text-[#666] text-base font-medium">No reviews yet</p>
                        <p class="text-[#999] text-sm mt-0.5">Be the first to review this service</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
</style>