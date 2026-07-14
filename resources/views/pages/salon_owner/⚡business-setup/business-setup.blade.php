
<div>
<div class="w-full px-4 sm:px-6 lg:px-8 py-6">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">
                {{ $is_setup_complete ? 'Edit Business Information' : 'Set Up Your Business' }}
            </h1>
            <p class="text-sm text-gray-500 mt-0.5">
                {{ $is_setup_complete ? 'Update your business details' : 'Complete your business setup to start accepting customers' }}
            </p>
        </div>
        @if ($is_setup_complete)
            <a href="{{ route('owner.business_info') }}" 
               class="inline-flex items-center px-4 py-2 text-sm text-gray-600 hover:text-gray-900 transition font-medium">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Business Info
            </a>
        @endif
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        
        <!-- Success Message -->
        @if (session()->has('success'))
            <div class="m-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg flex items-center gap-2.5">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <form wire:submit="saveBusinessInfo" enctype="multipart/form-data">
            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <!-- Left Column - Form Fields (2/3) -->
                    <div class="lg:col-span-2 space-y-5">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                Business Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   wire:model="business_name" 
                                   placeholder="Enter your business name"
                                   class="w-full rounded-lg border-gray-300 focus:border-[#1E7A4A] focus:ring-2 focus:ring-[#1E7A4A]/20 transition px-4 py-2.5 text-sm border">
                            @error('business_name') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                Business Email
                            </label>
                            <input type="email" 
                                   wire:model="business_email" 
                                   placeholder="info@yourbusiness.com"
                                   class="w-full rounded-lg border-gray-300 focus:border-[#1E7A4A] focus:ring-2 focus:ring-[#1E7A4A]/20 transition px-4 py-2.5 text-sm border">
                            <p class="text-xs text-gray-400 mt-1">This email will be used for customer communications</p>
                            @error('business_email') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                Business Phone
                            </label>
                            <input type="text" 
                                   wire:model="business_phone" 
                                   placeholder="(555) 000-0000"
                                   class="w-full rounded-lg border-gray-300 focus:border-[#1E7A4A] focus:ring-2 focus:ring-[#1E7A4A]/20 transition px-4 py-2.5 text-sm border">
                            <p class="text-xs text-gray-400 mt-1">Customers will use this to contact your business</p>
                            @error('business_phone') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                Business Address
                            </label>
                            <input type="text" 
                                   wire:model="business_address" 
                                   placeholder="123 Main Street, City, State, ZIP"
                                   class="w-full rounded-lg border-gray-300 focus:border-[#1E7A4A] focus:ring-2 focus:ring-[#1E7A4A]/20 transition px-4 py-2.5 text-sm border">
                            <p class="text-xs text-gray-400 mt-1">Full address where your business is located</p>
                            @error('business_address') <span class="text-red-500 text-xs mt-1 block font-medium">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Right Column - Logo Upload (1/3) -->
                    <div class="lg:col-span-1">
                        <div class="bg-gray-50 rounded-lg p-6">
                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                Business Logo
                            </label>
                            
                            <div class="flex flex-col items-center">
                                <!-- Logo Preview -->
                                <div class="mb-4">
                                    @if ($business_logo)
                                        <img src="{{ $business_logo->temporaryUrl() }}" 
                                             class="w-36 h-36 object-cover rounded-lg border-2 border-[#1E7A4A] shadow-sm">
                                        <p class="text-xs text-center text-green-600 mt-2 font-medium">New Logo</p>
                                    @elseif ($existing_logo)
                                        <img src="{{ Storage::url($existing_logo) }}" 
                                             class="w-36 h-36 object-cover rounded-lg border-2 border-gray-200 shadow-sm">
                                        <p class="text-xs text-center text-gray-500 mt-2">Current Logo</p>
                                    @else
                                        <div class="w-36 h-36 rounded-lg bg-white border-2 border-dashed border-gray-300 flex items-center justify-center">
                                            <div class="text-center">
                                                <svg class="w-12 h-12 text-gray-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                <p class="text-xs text-gray-400 mt-1">No Logo</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <label class="cursor-pointer w-full text-center px-4 py-2.5 bg-[#1E7A4A] text-white rounded-lg hover:bg-[#16653D] transition text-sm font-medium">
                                    <svg class="w-4 h-4 inline mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                    </svg>
                                    Choose Logo
                                    <input type="file" wire:model="business_logo" accept="image/*" class="hidden">
                                </label>
                                
                                <p class="text-xs text-gray-400 mt-2.5 text-center leading-relaxed">
                                    Recommended: Square image<br>
                                    400×400px minimum. JPG or PNG
                                </p>
                                
                                @error('business_logo') <span class="text-red-500 text-xs mt-1 block text-center font-medium">{{ $message }}</span> @enderror
                                @if ($business_logo)
                                    <p class="text-xs text-green-600 mt-2 text-center font-medium">✓ {{ $business_logo->getClientOriginalName() }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-200 flex justify-between items-center">
                <a href="{{ route('owner.business_info') }}" 
                   class="text-sm text-gray-600 hover:text-gray-900 transition font-medium flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-2.5 bg-[#1E7A4A] text-white rounded-lg hover:bg-[#16653D] transition text-sm font-medium shadow-sm hover:shadow"
                        wire:loading.attr="disabled">
                    <span wire:loading.remove> {{ $is_setup_complete ? 'Update Business' : 'Save Business Information' }}</span>
                    <span wire:loading>Saving...</span>
                </button>
            </div>
        </form>
    </div>
</div>
</div>