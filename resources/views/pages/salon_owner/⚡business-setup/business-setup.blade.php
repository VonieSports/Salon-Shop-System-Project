<div>
    <div class="w-full px-3 sm:px-4 lg:px-6 py-4 sm:py-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-4 mb-6 sm:mb-8">
            <div>
                <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-900 tracking-tight">
                    {{ $is_setup_complete ? 'Edit Business Information' : 'Set Up Your Business' }}
                </h1>
                <p class="text-xs sm:text-sm text-gray-500 mt-1 flex items-center gap-2">
                    <span class="inline-block w-1.5 h-1.5 rounded-full bg-[#1E7A4A]"></span>
                    {{ $is_setup_complete ? 'Update your business details' : 'Complete your business setup' }}
                </p>
            </div>
            @if ($is_setup_complete)
                <a href="{{ route('owner.business_info') }}" 
                   class="inline-flex items-center gap-1.5 px-3 sm:px-4 py-1.5 sm:py-2 text-xs sm:text-sm text-gray-600 hover:text-gray-900 transition font-medium bg-gray-50 hover:bg-gray-100 rounded-lg border border-gray-200">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back
                </a>
            @endif
        </div>

        <!-- Progress Steps (Hidden on mobile, visible on tablet+) -->
        <div class="hidden sm:flex items-center gap-2 md:gap-4 mb-6 md:mb-8">
            <div class="flex-1 flex items-center gap-2 md:gap-3">
                <div class="flex items-center gap-1.5 md:gap-2">
                    <div class="w-6 h-6 md:w-7 md:h-7 rounded-full bg-[#1E7A4A] text-white flex items-center justify-center text-[10px] md:text-xs font-bold">1</div>
                    <span class="text-[10px] md:text-xs font-medium text-[#1E7A4A]">Basic Info</span>
                </div>
                <div class="flex-1 h-0.5 bg-[#1E7A4A]"></div>
                <div class="flex items-center gap-1.5 md:gap-2">
                    <div class="w-6 h-6 md:w-7 md:h-7 rounded-full bg-gray-200 text-gray-600 flex items-center justify-center text-[10px] md:text-xs font-bold">2</div>
                    <span class="text-[10px] md:text-xs font-medium text-gray-500">Hours</span>
                </div>
                <div class="flex-1 h-0.5 bg-gray-200"></div>
                <div class="flex items-center gap-1.5 md:gap-2">
                    <div class="w-6 h-6 md:w-7 md:h-7 rounded-full bg-gray-200 text-gray-600 flex items-center justify-center text-[10px] md:text-xs font-bold">3</div>
                    <span class="text-[10px] md:text-xs font-medium text-gray-500">Logo</span>
                </div>
            </div>
        </div>

        <!-- Main Card -->
        <div class="bg-white rounded-xl sm:rounded-2xl border border-gray-200 shadow-lg shadow-gray-100/50 overflow-hidden">

            <!-- Success Message -->
            @if (session()->has('success'))
                <div class="m-3 sm:m-4 md:m-6 p-3 sm:p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-lg sm:rounded-xl flex items-center gap-2 sm:gap-3">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-xs sm:text-sm font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <form wire:submit="saveBusinessInfo" enctype="multipart/form-data">
                <div class="p-3 sm:p-4 md:p-6 lg:p-8">
                    <!-- Mobile: Tabs for sections -->
                    <div class="flex sm:hidden gap-1 mb-4 bg-gray-100 rounded-lg p-1">
                        <button type="button" 
                                wire:click="$set('activeTab', 'info')"
                                class="flex-1 py-1.5 text-xs font-medium rounded-md transition {{ ($activeTab ?? 'info') === 'info' ? 'bg-white text-[#1E7A4A] shadow-sm' : 'text-gray-500' }}">
                            Info
                        </button>
                        <button type="button" 
                                wire:click="$set('activeTab', 'hours')"
                                class="flex-1 py-1.5 text-xs font-medium rounded-md transition {{ ($activeTab ?? 'info') === 'hours' ? 'bg-white text-[#1E7A4A] shadow-sm' : 'text-gray-500' }}">
                            Hours
                        </button>
                        <button type="button" 
                                wire:click="$set('activeTab', 'logo')"
                                class="flex-1 py-1.5 text-xs font-medium rounded-md transition {{ ($activeTab ?? 'info') === 'logo' ? 'bg-white text-[#1E7A4A] shadow-sm' : 'text-gray-500' }}">
                            Logo
                        </button>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-5 gap-4 sm:gap-6 lg:gap-8">
                        <!-- Left Column - Form Fields -->
                        <div class="lg:col-span-3 space-y-4 sm:space-y-5 {{ ($activeTab ?? 'info') === 'info' ? 'block' : 'hidden sm:block' }}">
                            <!-- Section Title -->
                            <div class="pb-2 border-b border-gray-100">
                                <h2 class="text-base sm:text-lg font-semibold text-gray-900">Basic Information</h2>
                                <p class="text-[10px] sm:text-xs text-gray-500">Essential details about your business</p>
                            </div>

                            <!-- Business Name -->
                            <div>
                                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">
                                    Business Name <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-4 w-4 sm:h-5 sm:w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                    </div>
                                    <input type="text" 
                                           wire:model="business_name" 
                                           placeholder="e.g., BeautyNova Salon"
                                           class="w-full pl-8 sm:pl-10 rounded-lg sm:rounded-xl border-gray-300 focus:border-[#1E7A4A] focus:ring-2 focus:ring-[#1E7A4A]/20 transition px-3 sm:px-4 py-2 sm:py-2.5 text-xs sm:text-sm border shadow-sm">
                                </div>
                                @error('business_name') <span class="text-red-500 text-[10px] sm:text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                            </div>

                            <!-- Business Email -->
                            <div>
                                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">
                                    Business Email
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-4 w-4 sm:h-5 sm:w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <input type="email" 
                                           wire:model="business_email" 
                                           placeholder="info@yourbusiness.com"
                                           class="w-full pl-8 sm:pl-10 rounded-lg sm:rounded-xl border-gray-300 focus:border-[#1E7A4A] focus:ring-2 focus:ring-[#1E7A4A]/20 transition px-3 sm:px-4 py-2 sm:py-2.5 text-xs sm:text-sm border shadow-sm">
                                </div>
                                <p class="text-[10px] sm:text-xs text-gray-400 mt-1">Used for customer communications</p>
                                @error('business_email') <span class="text-red-500 text-[10px] sm:text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                            </div>

                            <!-- Business Phone -->
                            <div>
                                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">
                                    Business Phone
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-4 w-4 sm:h-5 sm:w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                        </svg>
                                    </div>
                                    <input type="text" 
                                           wire:model="business_phone" 
                                           placeholder="+1 (555) 000-0000"
                                           class="w-full pl-8 sm:pl-10 rounded-lg sm:rounded-xl border-gray-300 focus:border-[#1E7A4A] focus:ring-2 focus:ring-[#1E7A4A]/20 transition px-3 sm:px-4 py-2 sm:py-2.5 text-xs sm:text-sm border shadow-sm">
                                </div>
                                <p class="text-[10px] sm:text-xs text-gray-400 mt-1">Customers use this to contact you</p>
                                @error('business_phone') <span class="text-red-500 text-[10px] sm:text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                            </div>

                            <!-- Business Address -->
                            <div>
                                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">
                                    Business Address
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-4 w-4 sm:h-5 sm:w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </div>
                                    <input type="text" 
                                           wire:model="business_address" 
                                           placeholder="123 Main Street, City, State"
                                           class="w-full pl-8 sm:pl-10 rounded-lg sm:rounded-xl border-gray-300 focus:border-[#1E7A4A] focus:ring-2 focus:ring-[#1E7A4A]/20 transition px-3 sm:px-4 py-2 sm:py-2.5 text-xs sm:text-sm border shadow-sm">
                                </div>
                                <p class="text-[10px] sm:text-xs text-gray-400 mt-1">Full address of your business</p>
                                @error('business_address') <span class="text-red-500 text-[10px] sm:text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                            </div>

                            <!-- Business Type -->
                            <div>
                                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">
                                    Business Type
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-4 w-4 sm:h-5 sm:w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                    </div>
                                    <input type="text" 
                                           wire:model="business_type" 
                                           placeholder="e.g., Hair Salon, Nail Spa"
                                           class="w-full pl-8 sm:pl-10 rounded-lg sm:rounded-xl border-gray-300 focus:border-[#1E7A4A] focus:ring-2 focus:ring-[#1E7A4A]/20 transition px-3 sm:px-4 py-2 sm:py-2.5 text-xs sm:text-sm border shadow-sm">
                                </div>
                                @error('business_type') <span class="text-red-500 text-[10px] sm:text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                            </div>

                            <!-- Description -->
                            <div>
                                <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">
                                    Business Description
                                </label>
                                <textarea wire:model="description" 
                                          rows="3"
                                          placeholder="Tell customers about your business..."
                                          class="w-full rounded-lg sm:rounded-xl border-gray-300 focus:border-[#1E7A4A] focus:ring-2 focus:ring-[#1E7A4A]/20 transition px-3 sm:px-4 py-2 sm:py-2.5 text-xs sm:text-sm border shadow-sm resize-none"></textarea>
                                <div class="flex justify-between items-center mt-1">
                                    <p class="text-[10px] sm:text-xs text-gray-400">Brief description of your business</p>
                                    <p class="text-[10px] sm:text-xs text-gray-400">{{ strlen($description ?? '') }}/1000</p>
                                </div>
                                @error('description') <span class="text-red-500 text-[10px] sm:text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Right Column - Logo & Hours -->
                        <div class="lg:col-span-2 space-y-4 sm:space-y-6">
                            <!-- Logo Section -->
                            <div class="{{ ($activeTab ?? 'info') === 'logo' ? 'block' : 'hidden sm:block' }}">
                                <div class="pb-2 border-b border-gray-100">
                                    <h2 class="text-base sm:text-lg font-semibold text-gray-900">Business Logo</h2>
                                    <p class="text-[10px] sm:text-xs text-gray-500">Upload your business branding</p>
                                </div>
                                
                                <div class="mt-3 sm:mt-4 bg-gray-50 rounded-xl sm:rounded-2xl p-4 sm:p-6 border border-gray-200">
                                    <div class="flex flex-col items-center">
                                        <!-- Logo Preview -->
                                        <div class="mb-3 sm:mb-4">
                                            @if ($business_logo)
                                                <div class="relative">
                                                    <img src="{{ $business_logo->temporaryUrl() }}" 
                                                         class="w-24 h-24 sm:w-28 sm:h-28 md:w-32 md:h-32 object-cover rounded-xl sm:rounded-2xl border-4 border-[#1E7A4A] shadow-lg">
                                                    <span class="absolute -top-2 -right-2 px-2 py-0.5 bg-green-500 text-white text-[8px] sm:text-xs rounded-full font-medium">New</span>
                                                </div>
                                            @elseif ($existing_logo)
                                                <img src="{{ Storage::url($existing_logo) }}" 
                                                     class="w-24 h-24 sm:w-28 sm:h-28 md:w-32 md:h-32 object-cover rounded-xl sm:rounded-2xl border-4 border-gray-200 shadow-lg">
                                            @else
                                                <div class="w-24 h-24 sm:w-28 sm:h-28 md:w-32 md:h-32 rounded-xl sm:rounded-2xl bg-white border-2 border-dashed border-gray-300 flex items-center justify-center shadow-sm">
                                                    <div class="text-center">
                                                        <svg class="w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 text-gray-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                        </svg>
                                                        <p class="text-[8px] sm:text-xs text-gray-400 mt-1">Upload</p>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                        <label class="cursor-pointer w-full text-center px-3 sm:px-4 py-2 sm:py-2.5 bg-[#1E7A4A] text-white rounded-lg sm:rounded-xl hover:bg-[#16653D] transition text-xs sm:text-sm font-medium shadow-sm hover:shadow">
                                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 inline mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                            </svg>
                                            Choose Logo
                                            <input type="file" wire:model="business_logo" accept="image/*" class="hidden">
                                        </label>
                                        
                                        <div class="mt-2 flex items-center gap-1.5">
                                            <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <p class="text-[8px] sm:text-xs text-gray-400">400×400px min. JPG or PNG</p>
                                        </div>
                                        
                                        @error('business_logo') <span class="text-red-500 text-[10px] sm:text-xs mt-2 block text-center font-medium">{{ $message }}</span> @enderror
                                        @if ($business_logo)
                                            <p class="text-[10px] sm:text-xs text-green-600 mt-2 text-center font-medium">✓ {{ $business_logo->getClientOriginalName() }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Business Hours Section -->
                            <div class="{{ ($activeTab ?? 'info') === 'hours' ? 'block' : 'hidden sm:block' }}">
                                <div class="pb-2 border-b border-gray-100">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h2 class="text-base sm:text-lg font-semibold text-gray-900">Business Hours</h2>
                                            <p class="text-[10px] sm:text-xs text-gray-500">Set your operating hours</p>
                                        </div>
                                        <button type="button" 
                                                wire:click="$set('business_hours', [])"
                                                class="text-[10px] sm:text-xs text-red-500 hover:text-red-700 font-medium transition">
                                            Clear All
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="mt-3 sm:mt-4 space-y-1.5 sm:space-y-2">
                                    @foreach($days as $day)
                                        @php
                                            $hasDay = isset($business_hours[$day]);
                                            $dayData = $business_hours[$day] ?? null;
                                            $dayLabel = ucfirst($day);
                                        @endphp
                                        <div class="flex flex-wrap items-center gap-1.5 sm:gap-2 p-2 sm:p-2.5 bg-white rounded-lg sm:rounded-xl border border-gray-200 hover:border-[#1E7A4A]/30 transition">
                                            <div class="w-14 sm:w-16 md:w-20 flex-shrink-0">
                                                <span class="text-[10px] sm:text-xs font-semibold text-gray-700">{{ $dayLabel }}</span>
                                            </div>

                                            @if($hasDay)
                                                <div class="flex items-center gap-1.5 flex-1 min-w-[60px]">
                                                    <label class="relative inline-flex items-center cursor-pointer flex-shrink-0">
                                                        <input type="checkbox" 
                                                               wire:change="toggleDayClosed('{{ $day }}')"
                                                               {{ isset($dayData['closed']) && $dayData['closed'] ? 'checked' : '' }}
                                                               class="sr-only peer">
                                                        <div class="w-7 h-4 sm:w-8 sm:h-4.5 bg-gray-200 peer-focus:ring-2 peer-focus:ring-[#1E7A4A]/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-3 after:w-3 sm:after:h-3.5 sm:after:w-3.5 after:transition-all peer-checked:bg-red-500"></div>
                                                        <span class="ml-1 text-[8px] sm:text-[10px] text-gray-500">Closed</span>
                                                    </label>
                                                </div>
                                                <div class="flex items-center gap-1">
                                                    <input type="time" 
                                                           wire:model="business_hours.{{ $day }}.open"
                                                           {{ isset($dayData['closed']) && $dayData['closed'] ? 'disabled' : '' }}
                                                           class="w-[70px] sm:w-20 md:w-24 rounded-lg border-gray-300 focus:border-[#1E7A4A] focus:ring-2 focus:ring-[#1E7A4A]/20 transition px-1.5 sm:px-2 py-1 text-[10px] sm:text-xs border {{ isset($dayData['closed']) && $dayData['closed'] ? 'bg-gray-100 text-gray-400 cursor-not-allowed' : '' }}">
                                                    <span class="text-[10px] sm:text-xs text-gray-400">to</span>
                                                    <input type="time" 
                                                           wire:model="business_hours.{{ $day }}.close"
                                                           {{ isset($dayData['closed']) && $dayData['closed'] ? 'disabled' : '' }}
                                                           class="w-[70px] sm:w-20 md:w-24 rounded-lg border-gray-300 focus:border-[#1E7A4A] focus:ring-2 focus:ring-[#1E7A4A]/20 transition px-1.5 sm:px-2 py-1 text-[10px] sm:text-xs border {{ isset($dayData['closed']) && $dayData['closed'] ? 'bg-gray-100 text-gray-400 cursor-not-allowed' : '' }}">
                                                </div>
                                                <button type="button" 
                                                        wire:click="removeDay('{{ $day }}')"
                                                        class="text-red-400 hover:text-red-600 transition flex-shrink-0">
                                                    <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                    </svg>
                                                </button>
                                            @else
                                                <button type="button" 
                                                        wire:click="addDay('{{ $day }}')"
                                                        class="text-xs sm:text-sm text-[#1E7A4A] hover:text-[#16653D] font-medium transition">
                                                    + Add Hours
                                                </button>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                                <p class="text-[10px] sm:text-xs text-gray-400 mt-2 flex items-center gap-1">
                                    <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Add hours for each day your business is open
                                </p>
                                @error('business_hours') <span class="text-red-500 text-[10px] sm:text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="px-3 sm:px-4 md:px-6 lg:px-8 py-3 sm:py-4 bg-gray-50/80 border-t border-gray-200 flex flex-col-reverse sm:flex-row justify-between items-center gap-3 sm:gap-4">
                    <a href="{{ route('owner.business_info') }}" 
                       class="text-xs sm:text-sm text-gray-600 hover:text-gray-900 transition font-medium flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Cancel
                    </a>
                    <button type="submit" 
                            class="w-full sm:w-auto px-6 sm:px-8 py-2.5 sm:py-3 bg-[#1E7A4A] text-white rounded-lg sm:rounded-xl hover:bg-[#16653D] transition text-xs sm:text-sm font-medium shadow-sm hover:shadow-lg flex items-center justify-center gap-2"
                            wire:loading.attr="disabled">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span wire:loading.remove>{{ $is_setup_complete ? 'Update Business' : 'Save Business' }}</span>
                        <span wire:loading>
                            <svg class="animate-spin h-3.5 w-3.5 sm:h-4 sm:w-4 inline" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Saving...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>