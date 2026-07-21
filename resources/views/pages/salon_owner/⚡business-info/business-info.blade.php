<div>
    <div class="w-full">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <div class="flex items-center gap-3">
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 tracking-tight">Business Overview</h1>
                </div>
                <p class="text-sm text-gray-500 mt-1">Manage your business profile and settings</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('owner.business_setup') }}" 
                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#1E7A4A] text-white rounded-xl hover:bg-[#16653D] transition text-sm font-medium shadow-sm hover:shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                    </svg>
                    Update Business Information
                </a>
            </div>
        </div>

        @if ($tenant)
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                <!-- Verification Status -->
                <div class="bg-white rounded-2xl border border-gray-200 px-5 py-4 shadow-sm hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Verification</p>
                            <p class="text-lg font-bold mt-1 {{ $tenant->verification_status === 'verified' ? 'text-emerald-600' : 'text-yellow-600' }}">
                                {{ ucfirst($tenant->verification_status ?? 'Pending') }}
                            </p>
                        </div>
                        <div class="w-10 h-10 rounded-xl {{ $tenant->verification_status === 'verified' ? 'bg-emerald-50' : 'bg-yellow-50' }} flex items-center justify-center">
                            @if($tenant->verification_status === 'verified')
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            @else
                                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Products -->
                <div class="bg-white rounded-2xl border border-gray-200 px-5 py-4 shadow-sm hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Products</p>
                            <p class="text-lg font-bold text-gray-900 mt-1">{{ $tenant->products()->count() ?? 0 }}</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                    </div>
                </div>
                
                <!-- Services -->
                <div class="bg-white rounded-2xl border border-gray-200 px-5 py-4 shadow-sm hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Services</p>
                            <p class="text-lg font-bold text-gray-900 mt-1">{{ $tenant->services()->count() ?? 0 }}</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Employees -->
                <div class="bg-white rounded-2xl border border-gray-200 px-5 py-4 shadow-sm hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Employees</p>
                            <p class="text-lg font-bold text-gray-900 mt-1">{{ $tenant->employees()->count() ?? 0 }}</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-orange-50 flex items-center justify-center">
                            <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left Column - Business Details -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Business Info Card -->
                    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-[#1E7A4A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                <h2 class="text-sm font-semibold text-gray-700">Business Information</h2>
                            </div>
                            @if($tenant->business_setup_completed)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-medium bg-emerald-50 text-emerald-700 rounded-full">
                                    <span class="w-1 h-1 bg-emerald-500 rounded-full"></span>
                                    Complete
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-medium bg-yellow-50 text-yellow-700 rounded-full">
                                    <span class="w-1 h-1 bg-yellow-500 rounded-full"></span>
                                    Incomplete
                                </span>
                            @endif
                        </div>
                        <div class="p-6">
                            @if($tenant->business_setup_completed && $tenant->name)
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1.5">Business Name</label>
                                        <div class="flex items-center gap-2">
                                            <p class="text-gray-900 font-semibold">{{ $tenant->name }}</p>
                                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1.5">Business Email</label>
                                        <p class="text-gray-800">{{ $tenant->email ?? 'Not provided' }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1.5">Business Phone</label>
                                        <p class="text-gray-800">{{ $tenant->phone ?? 'Not provided' }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1.5">Business Type</label>
                                        <p class="text-gray-800">{{ $tenant->business_type ?? 'Not specified' }}</p>
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1.5">Business Address</label>
                                        <p class="text-gray-800">{{ $tenant->address ?? 'Not provided' }}</p>
                                    </div>
                                    @if($tenant->description)
                                    <div class="md:col-span-2">
                                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1.5">Business Description</label>
                                        <p class="text-gray-700 text-sm leading-relaxed">{{ $tenant->description }}</p>
                                    </div>
                                    @endif
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <div class="w-16 h-16 bg-yellow-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Business Setup Incomplete</h3>
                                    <p class="text-sm text-gray-500 mb-4">Please complete your business setup to start managing your shop.</p>
                                    <a href="{{ route('owner.business_setup') }}" 
                                       class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#1E7A4A] text-white rounded-xl hover:bg-[#16653D] transition text-sm font-medium shadow-sm hover:shadow-md">
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
                    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white flex items-center gap-3">
                            <svg class="w-5 h-5 text-[#1E7A4A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <h2 class="text-sm font-semibold text-gray-700">Business Hours</h2>
                        </div>
                        <div class="p-6">
                            @php
                                $formattedHours = $tenant->getFormattedBusinessHours();
                            @endphp
                            
                            @if(!empty($formattedHours))
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-1">
                                    @foreach($formattedHours as $day => $data)
                                        <div class="flex items-center justify-between py-2 border-b border-gray-50 last:border-0">
                                            <span class="text-sm font-medium text-gray-700">{{ $data['label'] }}</span>
                                            @if($data['closed'])
                                                <span class="text-xs font-medium text-red-500 bg-red-50 px-2 py-0.5 rounded">Closed</span>
                                            @elseif($data['open'] && $data['close'])
                                                <span class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($data['open'])->format('g:i A') }} - {{ \Carbon\Carbon::parse($data['close'])->format('g:i A') }}</span>
                                            @else
                                                <span class="text-xs text-gray-400">Not set</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-6">
                                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <p class="text-sm text-gray-400">No business hours set yet.</p>
                                    <a href="{{ route('owner.business_setup') }}" class="text-sm text-[#1E7A4A] hover:underline font-medium">Add hours</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right Column - Logo & Quick Actions -->
                <div class="space-y-6">
                    <!-- Logo Card -->
                    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white flex items-center gap-3">
                            <svg class="w-5 h-5 text-[#1E7A4A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <h2 class="text-sm font-semibold text-gray-700">Business Logo</h2>
                        </div>
                        <div class="p-6 flex flex-col items-center">
                            @if ($tenant->logo && $tenant->business_setup_completed)
                                <div class="relative group">
                                    <img src="{{ Storage::url($tenant->logo) }}" 
                                         alt="{{ $tenant->name }}"
                                         class="w-32 h-32 object-cover rounded-2xl border-4 border-gray-200 shadow-lg group-hover:shadow-xl transition">
                                    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/10 rounded-2xl transition"></div>
                                </div>
                                <p class="text-xs text-gray-500 mt-3">{{ $tenant->name }}</p>
                            @else
                                <div class="w-32 h-32 rounded-2xl bg-gray-100 flex items-center justify-center border-2 border-dashed border-gray-300">
                                    <div class="text-center">
                                        <svg class="w-12 h-12 text-gray-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <p class="text-xs text-gray-400 mt-1">No Logo</p>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 mt-3">Upload a logo in <a href="{{ route('owner.business_setup') }}" class="text-[#1E7A4A] hover:underline">business setup</a></p>
                            @endif
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition">
                        <div class="px-6 py-4 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-white flex items-center gap-3">
                            <svg class="w-5 h-5 text-[#1E7A4A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            <h2 class="text-sm font-semibold text-gray-700">Quick Actions</h2>
                        </div>
                        <div class="p-3 space-y-1">
                            <a href="{{ route('owner.business_setup') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-50 transition group">
                                <div class="w-9 h-9 rounded-xl bg-emerald-50 flex items-center justify-center group-hover:bg-emerald-100 transition">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-700">Update Business Info</p>
                                    <p class="text-xs text-gray-400">Edit business details</p>
                                </div>
                                <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                            <a href="{{ route('owner.create_product') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-50 transition group">
                                <div class="w-9 h-9 rounded-xl bg-blue-50 flex items-center justify-center group-hover:bg-blue-100 transition">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-700">Add New Product</p>
                                    <p class="text-xs text-gray-400">Create a new product listing</p>
                                </div>
                                <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                            <a href="{{ route('owner.create_service') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-50 transition group">
                                <div class="w-9 h-9 rounded-xl bg-purple-50 flex items-center justify-center group-hover:bg-purple-100 transition">
                                    <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-700">Add New Service</p>
                                    <p class="text-xs text-gray-400">Create a new service offering</p>
                                </div>
                                <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                            <a href="{{ route('owner.create_employee') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-gray-50 transition group">
                                <div class="w-9 h-9 rounded-xl bg-orange-50 flex items-center justify-center group-hover:bg-orange-100 transition">
                                    <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-700">Add New Employee</p>
                                    <p class="text-xs text-gray-400">Hire a team member</p>
                                </div>
                                <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- No Business Found -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-lg p-12 text-center">
                <div class="max-w-sm mx-auto">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">No Business Found</h3>
                    <p class="text-sm text-gray-500 mb-6">You haven't set up your business information yet. Start by adding your business details.</p>
                    <a href="{{ route('owner.business_setup') }}" 
                       class="inline-flex items-center gap-2 px-6 py-3 bg-[#1E7A4A] text-white rounded-xl hover:bg-[#16653D] transition text-sm font-medium shadow-sm hover:shadow-lg">
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