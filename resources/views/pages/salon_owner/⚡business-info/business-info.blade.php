<div class="min-h-screen bg-[#F5F5F5]">
    <div class="max-w-7xl mx-auto px-3 sm:px-4 py-4 sm:py-6">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-5">
            <div>
                <h1 class="text-xl sm:text-2xl font-semibold text-[#222]">Business Overview</h1>
                <p class="text-sm text-[#666] mt-0.5">Manage your business profile and settings</p>
            </div>
            <a href="{{ route('owner.business_setup') }}" 
               class="inline-flex items-center gap-2 px-4 py-2 bg-[#D6657A] hover:bg-[#C25467] text-white text-sm font-medium rounded-lg transition shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                </svg>
                Update Business
            </a>
        </div>

        @if ($tenant)
            <!-- Stats Cards -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-5">
                <!-- Verification Status -->
                <div class="bg-white rounded-lg border border-[#EFEFEF] px-4 py-3 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-medium text-[#999] uppercase tracking-wider">Verification</p>
                            <p class="text-base font-bold mt-0.5 {{ $tenant->verification_status === 'verified' ? 'text-[#D6657A]' : 'text-amber-500' }}">
                                {{ ucfirst($tenant->verification_status ?? 'Pending') }}
                            </p>
                        </div>
                        <div class="w-8 h-8 rounded-lg {{ $tenant->verification_status === 'verified' ? 'bg-[#FCE9ED]' : 'bg-amber-50' }} flex items-center justify-center">
                            @if($tenant->verification_status === 'verified')
                                <svg class="w-4 h-4 text-[#D6657A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            @else
                                <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Products -->
                <div class="bg-white rounded-lg border border-[#EFEFEF] px-4 py-3 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-medium text-[#999] uppercase tracking-wider">Products</p>
                            <p class="text-base font-bold text-[#222] mt-0.5">{{ $tenant->products()->count() ?? 0 }}</p>
                        </div>
                        <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Services -->
                <div class="bg-white rounded-lg border border-[#EFEFEF] px-4 py-3 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-medium text-[#999] uppercase tracking-wider">Services</p>
                            <p class="text-base font-bold text-[#222] mt-0.5">{{ $tenant->services()->count() ?? 0 }}</p>
                        </div>
                        <div class="w-8 h-8 rounded-lg bg-purple-50 flex items-center justify-center">
                            <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Employees -->
                <div class="bg-white rounded-lg border border-[#EFEFEF] px-4 py-3 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-medium text-[#999] uppercase tracking-wider">Employees</p>
                            <p class="text-base font-bold text-[#222] mt-0.5">{{ $tenant->employees()->count() ?? 0 }}</p>
                        </div>
                        <div class="w-8 h-8 rounded-lg bg-orange-50 flex items-center justify-center">
                            <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                <!-- Left Column - Business Details -->
                <div class="lg:col-span-2 space-y-4">
                    <!-- Business Info Card -->
                    <div class="bg-white rounded-lg border border-[#EFEFEF] overflow-hidden shadow-sm">
                        <div class="px-4 py-3 border-b border-[#EFEFEF] flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-[#D6657A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                <h2 class="text-sm font-semibold text-[#222]">Business Information</h2>
                            </div>
                         
                        </div>
                        <div class="p-4">
                            @if($tenant->business_setup_completed && $tenant->name)
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-[10px] font-medium text-[#999] uppercase tracking-wider mb-0.5">Business Name</p>
                                        <p class="text-sm font-semibold text-[#222]">{{ $tenant->name }}</p>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-medium text-[#999] uppercase tracking-wider mb-0.5">Business Type</p>
                                        <p class="text-sm text-[#666]">{{ $tenant->business_type ?? 'Not specified' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-medium text-[#999] uppercase tracking-wider mb-0.5">Business Email</p>
                                        <p class="text-sm text-[#666]">{{ $tenant->email ?? 'Not provided' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-medium text-[#999] uppercase tracking-wider mb-0.5">Business Phone</p>
                                        <p class="text-sm text-[#666]">{{ $tenant->phone ?? 'Not provided' }}</p>
                                    </div>
                                    <div class="sm:col-span-2">
                                        <p class="text-[10px] font-medium text-[#999] uppercase tracking-wider mb-0.5">Business Address</p>
                                        <p class="text-sm text-[#666]">{{ $tenant->address ?? 'Not provided' }}</p>
                                    </div>
                                    @if($tenant->description)
                                    <div class="sm:col-span-2">
                                        <p class="text-[10px] font-medium text-[#999] uppercase tracking-wider mb-0.5">Description</p>
                                        <p class="text-sm text-[#666] leading-relaxed">{{ $tenant->description }}</p>
                                    </div>
                                    @endif
                                </div>
                            @else
                                <div class="text-center py-6">
                                    <div class="w-12 h-12 bg-amber-50 rounded-full flex items-center justify-center mx-auto mb-3">
                                        <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-sm font-semibold text-[#222] mb-1">Setup Incomplete</h3>
                                    <p class="text-xs text-[#999] mb-3">Complete your business setup to start managing</p>
                                    <a href="{{ route('owner.business_setup') }}" 
                                       class="inline-flex items-center gap-2 px-4 py-2 bg-[#D6657A] text-white text-sm font-medium rounded-lg hover:bg-[#C25467] transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                        Complete Setup
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Business Hours Card -->
                    <div class="bg-white rounded-lg border border-[#EFEFEF] overflow-hidden shadow-sm">
                        <div class="px-4 py-3 border-b border-[#EFEFEF] flex items-center gap-2">
                            <svg class="w-4 h-4 text-[#D6657A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <h2 class="text-sm font-semibold text-[#222]">Business Hours</h2>
                        </div>
                        <div class="p-4">
                            @php
                                $formattedHours = $tenant->getFormattedBusinessHours();
                            @endphp
                            
                            @if(!empty($formattedHours))
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-0.5">
                                    @foreach($formattedHours as $day => $data)
                                        <div class="flex items-center justify-between py-1.5 border-b border-[#F5F5F5] last:border-0">
                                            <span class="text-xs font-medium text-[#666]">{{ $data['label'] }}</span>
                                            @if($data['closed'])
                                                <span class="text-[10px] font-medium text-red-500 bg-red-50 px-2 py-0.5 rounded">Closed</span>
                                            @elseif($data['open'] && $data['close'])
                                                <span class="text-xs text-[#666]">{{ \Carbon\Carbon::parse($data['open'])->format('g:i A') }} - {{ \Carbon\Carbon::parse($data['close'])->format('g:i A') }}</span>
                                            @else
                                                <span class="text-[10px] text-[#999]">Not set</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <p class="text-xs text-[#999]">No business hours set yet.</p>
                                    <a href="{{ route('owner.business_setup') }}" class="text-xs text-[#D6657A] hover:underline font-medium">Add hours</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right Column - Logo & Quick Actions -->
                <div class="space-y-4">
                    <!-- Logo Card -->
                    <div class="bg-white rounded-lg border border-[#EFEFEF] overflow-hidden shadow-sm">
                        <div class="px-4 py-3 border-b border-[#EFEFEF] flex items-center gap-2">
                            <svg class="w-4 h-4 text-[#D6657A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <h2 class="text-sm font-semibold text-[#222]">Business Logo</h2>
                        </div>
                        <div class="p-4 flex flex-col items-center">
                            @if ($tenant->logo && $tenant->business_setup_completed)
                                <img src="{{ Storage::url($tenant->logo) }}" 
                                     alt="{{ $tenant->name }}"
                                     class="w-24 h-24 object-cover rounded-lg border-2 border-[#EFEFEF] shadow-sm">
                                <p class="text-xs text-[#999] mt-2">{{ $tenant->name }}</p>
                            @else
                                <div class="w-24 h-24 rounded-lg bg-[#F5F5F5] flex items-center justify-center border-2 border-dashed border-[#EFEFEF]">
                                    <div class="text-center">
                                        <svg class="w-8 h-8 text-[#D6657A]/30 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <p class="text-[10px] text-[#999] mt-1">No Logo</p>
                                    </div>
                                </div>
                                <p class="text-[10px] text-[#999] mt-2">Upload in <a href="{{ route('owner.business_setup') }}" class="text-[#D6657A] hover:underline">setup</a></p>
                            @endif
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white rounded-lg border border-[#EFEFEF] overflow-hidden shadow-sm">
                        <div class="px-4 py-3 border-b border-[#EFEFEF] flex items-center gap-2">
                            <svg class="w-4 h-4 text-[#D6657A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            <h2 class="text-sm font-semibold text-[#222]">Quick Actions</h2>
                        </div>
                        <div class="p-1.5 space-y-0.5">
                            <a href="{{ route('owner.business_setup') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-[#F5F5F5] transition group">
                                <div class="w-7 h-7 rounded-lg bg-[#FCE9ED] flex items-center justify-center">
                                    <svg class="w-3.5 h-3.5 text-[#D6657A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs font-medium text-[#222]">Update Business</p>
                                    <p class="text-[10px] text-[#999]">Edit business details</p>
                                </div>
                                <svg class="w-3.5 h-3.5 text-[#CCC] group-hover:text-[#999] transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                            <a href="{{ route('owner.create_product') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-[#F5F5F5] transition group">
                                <div class="w-7 h-7 rounded-lg bg-blue-50 flex items-center justify-center">
                                    <svg class="w-3.5 h-3.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs font-medium text-[#222]">Add Product</p>
                                    <p class="text-[10px] text-[#999]">Create a new product</p>
                                </div>
                                <svg class="w-3.5 h-3.5 text-[#CCC] group-hover:text-[#999] transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                            <a href="{{ route('owner.create_service') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-[#F5F5F5] transition group">
                                <div class="w-7 h-7 rounded-lg bg-purple-50 flex items-center justify-center">
                                    <svg class="w-3.5 h-3.5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs font-medium text-[#222]">Add Service</p>
                                    <p class="text-[10px] text-[#999]">Create a new service</p>
                                </div>
                                <svg class="w-3.5 h-3.5 text-[#CCC] group-hover:text-[#999] transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                            <a href="{{ route('owner.create_employee') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-[#F5F5F5] transition group">
                                <div class="w-7 h-7 rounded-lg bg-orange-50 flex items-center justify-center">
                                    <svg class="w-3.5 h-3.5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-xs font-medium text-[#222]">Add Employee</p>
                                    <p class="text-[10px] text-[#999]">Hire a team member</p>
                                </div>
                                <svg class="w-3.5 h-3.5 text-[#CCC] group-hover:text-[#999] transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- No Business Found -->
            <div class="bg-white rounded-lg border border-[#EFEFEF] shadow-sm p-8 text-center">
                <div class="max-w-sm mx-auto">
                    <div class="w-16 h-16 bg-[#F5F5F5] rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-[#D6657A]/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-semibold text-[#222] mb-1">No Business Found</h3>
                    <p class="text-sm text-[#999] mb-4">You haven't set up your business information yet.</p>
                    <a href="{{ route('owner.business_setup') }}" 
                       class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#D6657A] text-white text-sm font-medium rounded-lg hover:bg-[#C25467] transition shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Set Up Business
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>