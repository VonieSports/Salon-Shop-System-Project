
<div>
<div>
<div class="w-full lg:px-1 ">
    <!-- TOP ROW: Personal Info (2/3) + Complete Profile (1/3) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-200 h-full flex flex-col">
                <!-- Header -->
                <div class="border-b border-gray-200 px-6 py-5 shrink-0">
                    <div class="flex items-center gap-5">
                        <div class="relative">
                            @if ($user->avatar)
                                <img src="{{ Storage::url($user->avatar) }}" 
                                     alt="{{ $user->name }}"
                                     class="w-20 h-20 rounded-full border-2 border-[#1E7A4A] object-cover shadow-sm">
                            @else
                                <div class="w-20 h-20 rounded-full border-2 border-[#1E7A4A] bg-gray-50 flex items-center justify-center shadow-sm">
                                    <span class="text-2xl font-semibold text-[#111827]">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                                </div>
                            @endif
                            <button class="absolute bottom-0 right-0 bg-white rounded-full p-1 shadow-md hover:bg-gray-50 transition border border-gray-200">
                                <svg class="w-3.5 h-3.5 text-[#111827]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </button>
                        </div>
                        
                        <div class="flex-1">
                            <h1 class="text-2xl font-semibold text-gray-900 tracking-tight">{{ $user->name }}</h1>
                            <p class="text-gray-500 text-sm font-normal">{{ $user->email }}</p>
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-6 flex-1 flex flex-col">
                    <h2 class="text-sm font-semibold text-[#111827] uppercase tracking-wider mb-5">Personal Information</h2>
                    
                    <div class="grid grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-1.5">Full Name</label>
                            <p class="text-gray-900 font-medium text-base">{{ $user->name }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-1.5">Email</label>
                            <p class="text-gray-900 font-normal text-base">{{ $user->email }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-1.5">Phone</label>
                            <p class="text-gray-900 font-normal text-base">{{ $user->phone ?? 'Not provided' }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-1.5">Location</label>
                            <p class="text-gray-900 font-normal text-base">{{ $user->address ?? 'Not provided' }}</p>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="border-t border-gray-100 my-6"></div>

                    <!-- Bio -->
                    <div class="flex-1">
                        <h2 class="text-sm font-semibold text-[#111827] uppercase tracking-wider mb-3">Bio</h2>
                        @if ($user->bio)
                            <p class="text-gray-600 leading-relaxed text-base font-normal">{{ $user->bio }}</p>
                        @else
                            <p class="text-gray-400 text-base font-normal">No bio added yet</p>
                        @endif
                    </div>
                    
                    <!-- Edit Button -->
                    <div class="mt-4 pt-4 flex flex-wrap border-t border-gray-100 justify-between">

                          <div class="flex flex-wrap gap-3">
                     
                    </div>
                        <a href="{{ route('owner.update_profile') }}" 
                           class="inline-flex items-center px-5 py-2.5 bg-[#1E7A4A] text-white rounded-lg hover:bg-[#16653D] transition text-sm font-medium shadow-sm hover:shadow">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Update Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Column 2: Complete Profile (1/3 width) -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-200 h-full flex flex-col">
                <h2 class="text-sm font-semibold text-[#111827] uppercase tracking-wider mb-4">Complete Profile</h2>
                
                <div class="flex-1 flex flex-col items-center justify-center">
                    <!-- Circular Progress -->
                    <div class="relative inline-flex items-center justify-center">
                        <svg class="w-32 h-32 transform -rotate-90">
                            <circle cx="64" cy="64" r="50" 
                                    fill="none" 
                                    stroke="#E5E7EB" 
                                    stroke-width="6"/>
                            <circle cx="64" cy="64" r="50" 
                                    fill="none" 
                                    stroke="#1E7A4A" 
                                    stroke-width="6"
                                    stroke-linecap="round"
                                    class="transition-all duration-500"
                                    stroke-dasharray="314.16"
                                    stroke-dashoffset="{{ 314.16 - (314.16 * ($user->bio && $user->avatar ? 0.8 : ($user->bio || $user->avatar ? 0.6 : 0.2))) }}"/>
                        </svg>
                        <div class="absolute text-center">
                            <span class="text-3xl font-semibold text-[#111827]">
                                {{ $user->bio && $user->avatar ? '80' : ($user->bio || $user->avatar ? '60' : '20') }}%
                            </span>
                            <p class="text-xs font-normal text-gray-400">Complete</p>
                        </div>
                    </div>
                    
                    <!-- Checklist -->
                    <div class="mt-5 space-y-2.5 text-left w-full">
                        <div class="flex items-center gap-3 text-sm {{ $user->name ? 'text-gray-700' : 'text-gray-400' }}">
                            <span class="w-5 h-5 rounded-full {{ $user->name ? 'bg-[#1E7A4A] text-white' : 'bg-gray-200' }} flex items-center justify-center text-xs font-bold">
                                {{ $user->name ? '✓' : '○' }}
                            </span>
                            <span class="font-normal">Setup account</span>
                        </div>
                        <div class="flex items-center gap-3 text-sm {{ $user->avatar ? 'text-gray-700' : 'text-gray-400' }}">
                            <span class="w-5 h-5 rounded-full {{ $user->avatar ? 'bg-[#1E7A4A] text-white' : 'bg-gray-200' }} flex items-center justify-center text-xs font-bold">
                                {{ $user->avatar ? '✓' : '○' }}
                            </span>
                            <span class="font-normal">Upload your photo</span>
                        </div>
                        <div class="flex items-center gap-3 text-sm {{ $user->name ? 'text-gray-700' : 'text-gray-400' }}">
                            <span class="w-5 h-5 rounded-full {{ $user->name ? 'bg-[#1E7A4A] text-white' : 'bg-gray-200' }} flex items-center justify-center text-xs font-bold">
                                {{ $user->name ? '✓' : '○' }}
                            </span>
                            <span class="font-normal">Personal Info</span>
                        </div>
                        <div class="flex items-center gap-3 text-sm {{ $user->address ? 'text-gray-700' : 'text-gray-400' }}">
                            <span class="w-5 h-5 rounded-full {{ $user->address ? 'bg-[#1E7A4A] text-white' : 'bg-gray-200' }} flex items-center justify-center text-xs font-bold">
                                {{ $user->address ? '✓' : '○' }}
                            </span>
                            <span class="font-normal">Location</span>
                        </div>
                        <div class="flex items-center gap-3 text-sm {{ $user->bio ? 'text-gray-700' : 'text-gray-400' }}">
                            <span class="w-5 h-5 rounded-full {{ $user->bio ? 'bg-[#1E7A4A] text-white' : 'bg-gray-200' }} flex items-center justify-center text-xs font-bold">
                                {{ $user->bio ? '✓' : '○' }}
                            </span>
                            <span class="font-normal">Biography</span>
                        </div>
                        <div class="flex items-center gap-3 text-sm text-gray-400">
                            <span class="w-5 h-5 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold">○</span>
                            <span class="font-normal">Notifications</span>
                        </div>
                        <div class="flex items-center gap-3 text-sm text-gray-400">
                            <span class="w-5 h-5 rounded-full bg-gray-200 flex items-center justify-center text-xs font-bold">○</span>
                            <span class="font-normal">Bank details</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- BOTTOM ROW: Business Info (Full Width) -->
    @if ($tenant)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50/50 flex items-center justify-between">
                <h2 class="text-sm font-semibold text-[#111827] uppercase tracking-wider">Business Information</h2>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-[#1E7A4A]/10 text-[#111827]">
                    {{ $tenant->business_setup_completed ? 'Active' : 'Setup Required' }}
                </span>
            </div>
            <div class="px-6 py-5">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <!-- Business Logo -->
                    <div class="flex items-center justify-center md:justify-start">
                        @if ($tenant->logo)
                            <img src="{{ Storage::url($tenant->logo) }}" 
                                 alt="{{ $tenant->name }}"
                                 class="w-20 h-20 object-cover rounded-xl border-2 border-[#1E7A4A]/20 shadow-sm">
                        @else
                            <div class="w-20 h-20 rounded-xl bg-gray-50 flex items-center justify-center border-2 border-dashed border-[#1E7A4A]/30">
                                <svg class="w-8 h-8 text-[#111827]/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- Business Details -->
                    <div>
                        <label class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Business Name</label>
                        <p class="text-gray-900 font-medium text-sm">{{ $tenant->name }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Business Email</label>
                        <p class="text-gray-700 font-normal text-sm">{{ $tenant->email ?? 'Not provided' }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Business Phone</label>
                        <p class="text-gray-700 font-normal text-sm">{{ $tenant->phone ?? 'Not provided' }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-1">Business Address</label>
                        <p class="text-gray-700 font-normal text-sm">{{ $tenant->address ?? 'Not provided' }}</p>
                    </div>
                </div>

                <!-- Status & Actions -->
                <div class="flex flex-wrap items-center justify-between mt-5 pt-5 border-t border-gray-200">
                    <div class="flex flex-wrap gap-3">
                     
                    </div>
                   <a href="{{ route('owner.business_setup') }}" 
                           class="inline-flex items-center px-5 py-2.5 bg-[#1E7A4A] text-white rounded-lg hover:bg-[#16653D] transition text-sm font-medium shadow-sm hover:shadow">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Update Business
                        </a>
                </div>
            </div>
        </div>
    @else
        <!-- No Business Found -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8 text-center">
            <div class="max-w-md mx-auto">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-[#111827]/40" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">No Business Found</h3>
                <p class="text-sm text-gray-500 font-normal mb-4">You haven't set up your business information yet.</p>
                <a href="{{ route('owner.business_setup') }}" 
                   class="inline-flex items-center px-5 py-2.5 bg-[#1E7A4A] text-white rounded-lg hover:bg-[#16653D] transition text-sm font-medium shadow-sm hover:shadow">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Set Up Business
                </a>
            </div>
        </div>
    @endif
</div>
</div>
</div>