
<div>
<div class="w-full px-4 sm:px-6 lg:px-8 py-6">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Business Information</h1>
            <p class="text-sm text-gray-500 mt-0.5">View your business details</p>
        </div>
        <a href="{{ route('owner.business_setup') }}" 
           class="inline-flex items-center px-4 py-2 bg-[#1E7A4A] text-white rounded-lg hover:bg-[#16653D] transition text-sm font-medium shadow-sm hover:shadow">
            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Edit Business
        </a>
    </div>

    @if ($tenant)
        <!-- Status Cards Row -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <!-- Setup Status -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 flex items-center gap-4">
                <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Setup</p>
                    <p class="text-sm font-bold text-gray-900">Complete</p>
                </div>
                <div class="ml-auto">
                    <span class="text-sm font-bold text-green-600">100%</span>
                </div>
            </div>

            <!-- Verification Status -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 flex items-center gap-4">
                <div class="w-10 h-10 rounded-lg bg-yellow-100 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Verification</p>
                    <p class="text-sm font-bold text-gray-900">Pending</p>
                </div>
                <div class="ml-auto">
                    <span class="text-sm font-bold text-yellow-600">60%</span>
                </div>
            </div>

            <!-- Active Status -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-4 flex items-center gap-4">
                <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider">Status</p>
                    <p class="text-sm font-bold text-gray-900">Active</p>
                </div>
                <div class="ml-auto">
                    <span class="text-sm font-bold text-blue-600">100%</span>
                </div>
            </div>

            <!-- Overall Status -->
            <div class="bg-gradient-to-r from-[#1E7A4A] to-[#2A9D5A] rounded-xl shadow-sm p-4 flex items-center gap-4">
                <div class="w-10 h-10 rounded-lg bg-white/20 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-medium text-white/80 uppercase tracking-wider">Overall</p>
                    <p class="text-sm font-bold text-white">Complete</p>
                </div>
                <div class="ml-auto">
                    <span class="text-sm font-bold text-white">87%</span>
                </div>
            </div>
        </div>

        <!-- Main Content - Two Columns -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Business Details with Logo -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex items-center justify-between">
                        <h2 class="text-sm font-semibold text-gray-700 uppercase tracking-wider">Business Details</h2>
                        @if ($tenant->logo)
                            <img src="{{ Storage::url($tenant->logo) }}" 
                                 alt="{{ $tenant->name }}"
                                 class="w-10 h-10 object-cover rounded-lg border border-gray-200">
                        @endif
                    </div>
                    <div class="px-6 py-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Business Name</label>
                                <p class="text-gray-900 font-medium text-base">{{ $tenant->name }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Business Email</label>
                                <p class="text-gray-800 text-base">{{ $tenant->email ?? 'Not provided' }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Business Phone</label>
                                <p class="text-gray-800 text-base">{{ $tenant->phone ?? 'Not provided' }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Business Address</label>
                                <p class="text-gray-800 text-base">{{ $tenant->address ?? 'Not provided' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Logo & Quick Actions -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Logo Card -->
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                        <h2 class="text-sm font-semibold text-gray-700 uppercase tracking-wider">Business Logo</h2>
                    </div>
                    <div class="px-6 py-5 flex flex-col items-center">
                        @if ($tenant->logo)
                            <img src="{{ Storage::url($tenant->logo) }}" 
                                 alt="{{ $tenant->name }}"
                                 class="w-32 h-32 object-cover rounded-xl border-2 border-gray-200 shadow-sm">
                            <p class="text-xs text-gray-500 mt-3">Current Logo</p>
                        @else
                            <div class="w-32 h-32 rounded-xl bg-gray-100 flex items-center justify-center border-2 border-dashed border-gray-300">
                                <div class="text-center">
                                    <svg class="w-12 h-12 text-gray-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <p class="text-xs text-gray-400 mt-1">No Logo</p>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-3">No business logo uploaded</p>
                        @endif
                    </div>
                </div>
                <!-- Quick Actions Card -->
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