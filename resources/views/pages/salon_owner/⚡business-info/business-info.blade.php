<div>
<div class="w-full ">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Business Overview</h1>
            <p class="text-sm text-gray-500 mt-0.5">Manage your business profile and settings</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="#" class="inline-flex items-center bg-[#1E7A4A] text-white px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-[#1E7A4A]/200 text-white transition text-sm font-medium">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                Preview Store   
            </a>
           
        </div>
    </div>

    @if ($tenant)
        <!-- Stats Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-xl border border-gray-200 px-5 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Status</p>
                        <p class="text-lg font-bold text-emerald-600 mt-1">Active</p>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-emerald-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl border border-gray-200 px-5 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Verification</p>
                        <p class="text-lg font-bold text-yellow-600 mt-1">Pending</p>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-yellow-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl border border-gray-200 px-5 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Products</p>
                        <p class="text-lg font-bold text-gray-900 mt-1">0</p>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl border border-gray-200 px-5 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Services</p>
                        <p class="text-lg font-bold text-gray-900 mt-1">0</p>
                    </div>
                    <div class="w-10 h-10 rounded-lg bg-purple-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
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
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex items-center justify-between">
                        <h2 class="text-sm font-semibold text-gray-700 uppercase tracking-wider">Business Information</h2>
                        <span class="text-xs text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full font-medium">Complete</span>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1.5">Business Name</label>
                                <div class="flex items-center gap-2">
                                    <p class="text-gray-900 font-medium">{{ $tenant->name }}</p>
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
                                <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1.5">Phone Number</label>
                                <p class="text-gray-800">{{ $tenant->phone ?? 'Not provided' }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1.5">Business Type</label>
                                <p class="text-gray-800">{{ $tenant->business_type ?? 'Not specified' }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1.5">Address</label>
                                <p class="text-gray-800">{{ $tenant->address ?? 'Not provided' }}</p>
                            </div>
                            @if($tenant->description)
                            <div class="md:col-span-2">
                                <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1.5">Description</label>
                                <p class="text-gray-700 text-sm leading-relaxed">{{ $tenant->description }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Business Hours Card -->
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                        <h2 class="text-sm font-semibold text-gray-700 uppercase tracking-wider">Business Hours</h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @php
                                $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                                $hours = $tenant->business_hours ?? [];
                            @endphp
                            @foreach($days as $day)
                                <div class="flex items-center justify-between py-2 border-b border-gray-50 last:border-0">
                                    <span class="text-sm font-medium text-gray-700">{{ $day }}</span>
                                    <span class="text-sm text-gray-500">
                                        {{ $hours[$day]['open'] ?? '9:00 AM' }} - {{ $hours[$day]['close'] ?? '6:00 PM' }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Logo & Quick Actions -->
            <div class="space-y-6">
                <!-- Logo Card -->
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                        <h2 class="text-sm font-semibold text-gray-700 uppercase tracking-wider">Logo</h2>
                    </div>
                    <div class="p-6 flex flex-col items-center">
                        @if ($tenant->logo)
                            <div class="relative group">
                                <img src="{{ Storage::url($tenant->logo) }}" 
                                     alt="{{ $tenant->name }}"
                                     class="w-28 h-28 object-cover rounded-xl border-2 border-gray-200 shadow-sm">
                                <button class="absolute -top-2 -right-2 p-1.5 bg-white rounded-full shadow-md border border-gray-200 hover:bg-gray-50 transition">
                                    <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </button>
                            </div>
                            <p class="text-xs text-gray-500 mt-3">Click the edit icon to change</p>
                        @else
                            <div class="w-28 h-28 rounded-xl bg-gray-100 flex items-center justify-center border-2 border-dashed border-gray-300">
                                <div class="text-center">
                                    <svg class="w-10 h-10 text-gray-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <p class="text-xs text-gray-400 mt-1">Upload Logo</p>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-3">No logo uploaded yet</p>
                        @endif
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                        <h2 class="text-sm font-semibold text-gray-700 uppercase tracking-wider">Quick Actions</h2>
                    </div>
                    <div class="p-4 space-y-2">
                        <a href="{{ route('owner.create_product') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-50 transition group">
                            <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center group-hover:bg-emerald-100 transition">
                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-700">Add New Product</p>
                                <p class="text-xs text-gray-400">Create a new product listing</p>
                            </div>
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                        <a href="{{ route('owner.create_service') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-50 transition group">
                            <div class="w-8 h-8 rounded-lg bg-purple-50 flex items-center justify-center group-hover:bg-purple-100 transition">
                                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-700">Add New Service</p>
                                <p class="text-xs text-gray-400">Create a new service offering</p>
                            </div>
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                        <a href="{{ route('owner.business_setup') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-gray-50 transition group">
                            <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center group-hover:bg-blue-100 transition">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-700">Update Settings</p>
                                <p class="text-xs text-gray-400">Edit business information</p>
                            </div>
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- No Business Found -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-12 text-center">
            <div class="max-w-sm mx-auto">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-5">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No Business Found</h3>
                <p class="text-sm text-gray-500 mb-6">You haven't set up your business information yet. Start by adding your business details.</p>
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

