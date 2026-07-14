
<div>
  <div class="w-full ">
 
        <!-- Profile Card -->
        <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-200">
            <!-- Header -->
            <div class="bg-gradient-to-r from-[#1E7A4A] to-[#2A9D5A] px-6 py-6">
                <div class="flex flex-col sm:flex-row items-center sm:items-start gap-4 sm:gap-6">
                    <!-- Avatar -->
                    <div class="relative flex-shrink-0">
                        @if ($user->avatar)
                            <img src="{{ Storage::url($user->avatar) }}" 
                                 alt="{{ $user->name }}"
                                 class="w-24 h-24 sm:w-28 sm:h-28 rounded-full border-4 border-white object-cover shadow-lg">
                        @else
                            <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-full border-4 border-white bg-white/20 flex items-center justify-center shadow-lg">
                                <span class="text-3xl sm:text-4xl font-bold text-white">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                            </div>
                        @endif
                        <a href="{{ route('customer.update_profile') }}" 
                           class="absolute bottom-0 right-0 bg-white rounded-full p-1.5 shadow-md hover:bg-gray-50 transition border border-gray-200">
                            <svg class="w-3.5 h-3.5 text-[#1E7A4A]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </a>
                    </div>
                    
                    <!-- User Info -->
                    <div class="flex-1 text-white text-center sm:text-left">
                        <h1 class="text-2xl sm:text-3xl font-bold">{{ $user->name }}</h1>
                        <p class="text-white/80 text-sm">{{ $user->email }}</p>
                        <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2 mt-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-white/20 text-white">
                                Customer
                            </span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-500/30 text-white">
                                ● Active
                            </span>
                        </div>
                    </div>
                    
                    <!-- Edit Button -->
                    <a href="{{ route('customer.update_profile') }}" 
                       class="shrink-0 inline-flex items-center px-4 py-2 bg-white/20 hover:bg-white/30 text-white rounded-lg text-sm font-medium transition backdrop-blur-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit Profile
                    </a>
                </div>
            </div>

            <!-- Content -->
            <div class="p-6">
                <!-- Personal Info -->
                <div>
                    <h2 class="text-sm font-bold text-[#1E7A4A] uppercase tracking-wider mb-5">Personal Information</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-1.5">Full Name</label>
                            <p class="text-gray-900 font-medium text-base">{{ $user->name }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-1.5">Email</label>
                            <p class="text-gray-900 font-medium text-base">{{ $user->email }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-1.5">Phone</label>
                            <p class="text-gray-900 font-medium text-base">{{ $user->phone ?? 'Not provided' }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-1.5">Location</label>
                            <p class="text-gray-900 font-medium text-base">{{ $user->address ?? 'Not provided' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Divider -->
                <div class="border-t border-gray-200 my-6"></div>

                <!-- Bio -->
                <div>
                    <h2 class="text-sm font-bold text-[#1E7A4A] uppercase tracking-wider mb-3">Bio</h2>
                    @if ($user->bio)
                        <p class="text-gray-700 leading-relaxed text-base">{{ $user->bio }}</p>
                    @else
                        <p class="text-gray-400 italic text-base">No bio added yet</p>
                    @endif
                </div>

                <!-- Customer Details -->
                @if ($customer)
                    <div class="border-t border-gray-200 my-6"></div>
                    <div>
                        <h2 class="text-sm font-bold text-[#1E7A4A] uppercase tracking-wider mb-3">Customer Details</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-1.5">Gender</label>
                                <p class="text-gray-900 font-medium text-base">{{ $customer->gender ?? 'Not specified' }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-1.5">Member Since</label>
                                <p class="text-gray-900 font-medium text-base">{{ $user->created_at->format('F d, Y') }}</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium">Total Appointments</p>
                        <p class="text-xl font-bold text-gray-900">0</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium">Reviews Given</p>
                        <p class="text-xl font-bold text-gray-900">0</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium">Total Spent</p>
                        <p class="text-xl font-bold text-gray-900">$0.00</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>