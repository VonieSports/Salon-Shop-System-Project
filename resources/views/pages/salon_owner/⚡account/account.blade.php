<div class="min-h-screen bg-gray-50">
    <div class="w-full">
        <div class="bg-white shadow-sm border-x-0 sm:border-x border-gray-200 overflow-hidden lg:rounded-2xl">
            <div class="px-3 sm:px-6 py-4 sm:py-5 border-b border-gray-100 bg-[#1E7A4A]">
                <div class="flex items-center justify-between flex-wrap gap-3">
                    <div>
                        <h1 class="text-lg sm:text-2xl font-bold text-white">Employee Accounts</h1>
                        <p class="text-white/80 text-xs sm:text-sm mt-0.5">View all employee profiles in your organization</p>
                    </div>
                    <a href="{{ route('owner.create_employee') }}"
                       class="inline-flex items-center gap-1.5 sm:gap-2 px-3 sm:px-5 py-1.5 sm:py-2 bg-white text-[#1E7A4A] rounded-full hover:bg-gray-50 transition text-xs sm:text-sm font-medium shadow-sm whitespace-nowrap">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span class="hidden sm:inline">Add Employee</span>
                        <span class="sm:hidden">Add</span>
                    </a>
                </div>
            </div>

            <!-- Stats -->
            <div class="px-3 sm:px-6 py-3 sm:py-4 bg-gray-50 border-b border-gray-100">
                <div class="grid grid-cols-3 gap-3">
                    <div class="bg-white rounded-lg p-3 sm:p-4 shadow-sm border border-gray-100">
                        <p class="text-xs text-gray-500 uppercase tracking-wider">Total</p>
                        <p class="text-lg sm:text-xl font-bold text-gray-900">{{ $totalEmployees }}</p>
                    </div>
                    <div class="bg-white rounded-lg p-3 sm:p-4 shadow-sm border border-gray-100">
                        <p class="text-xs text-gray-500 uppercase tracking-wider">Active</p>
                        <p class="text-lg sm:text-xl font-bold text-green-600">{{ $activeEmployees }}</p>
                    </div>
                    <div class="bg-white rounded-lg p-3 sm:p-4 shadow-sm border border-gray-100">
                        <p class="text-xs text-gray-500 uppercase tracking-wider">Inactive</p>
                        <p class="text-lg sm:text-xl font-bold text-red-600">{{ $totalEmployees - $activeEmployees }}</p>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="px-3 sm:px-6 py-3 sm:py-6">
                <!-- Filters -->
                <div class="flex flex-col sm:flex-row gap-3 mb-4 sm:mb-6">
                    <div class="relative flex-1">
                        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input type="text" 
                               wire:model.live.debounce.300ms="search" 
                               placeholder="Search by name, email, or phone..."
                               class="w-full pl-10 pr-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#1E7A4A]/30 focus:border-[#1E7A4A] transition bg-white">
                    </div>
                    
                    <select wire:model.live="roleFilter"
                            class="px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#1E7A4A]/30 focus:border-[#1E7A4A] transition bg-white w-full sm:w-auto min-w-[140px] appearance-none">
                        <option value="all">All Roles</option>
                        <option value="employee">Employees</option>
                        <option value="owner">Owner</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

                <!-- Employee Cards Grid -->
                @if($this->employees->isEmpty())
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <p class="text-gray-500 text-sm">No employees found</p>
                        <p class="text-gray-400 text-sm mt-1">Start by adding your first team member</p>
                    </div>
                @else
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-4">
                        @foreach($this->employees as $employee)
                            @php 
                                $user = $employee->user;
                                $status = $user ? $user->status : [
                                    'badge_class' => 'bg-gray-100 text-gray-500',
                                    'dot_class' => 'bg-gray-400',
                                    'label' => 'No User',
                                    'is_online' => false,
                                ];
                                $userRoles = $user ? $user->roles->pluck('name')->toArray() : [];
                                $isOwner = in_array('owner', $userRoles);
                                $isAdmin = in_array('admin', $userRoles);
                            @endphp
                            <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200 border border-gray-100 overflow-hidden">
                                <!-- Cover Photo Banner -->
                                <div class="relative h-16 sm:h-20 bg-gradient-to-r from-[#1E7A4A] to-emerald-400">
                                    @if($user && $user->cover_photo)
                                        <img src="{{ Storage::url($user->cover_photo) }}" 
                                             class="w-full h-full object-cover"
                                             alt="Cover photo">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-r from-[#1E7A4A] to-emerald-500">
                                            <svg class="w-6 h-6 sm:w-8 sm:h-8 text-white/20" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                <!-- Card Body -->
                                <div class="px-3 sm:px-4 pb-3 sm:pb-4">
                                    <!-- Avatar - Overlapping cover -->
                                    <div class="relative inline-block -mt-8 sm:-mt-10">
                                        <div class="w-12 h-12 sm:w-16 sm:h-16 rounded-full overflow-hidden border-4 border-white bg-gray-100 shadow-md">
                                            @if($user && $user->avatar)
                                                <img src="{{ Storage::url($user->avatar) }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center bg-emerald-100">
                                                    <span class="text-sm sm:text-xl font-bold text-[#1E7A4A]">
                                                        {{ strtoupper(substr($user?->name ?? 'U', 0, 1)) }}
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                        @if($status['is_online'] ?? false)
                                            <span class="absolute bottom-0 right-0 w-3 h-3 sm:w-3.5 sm:h-3.5 bg-green-500 border-2 border-white rounded-full animate-pulse"></span>
                                        @endif
                                    </div>

                                    <!-- Name & Position -->
                                    <div class="mt-1">
                                        <h3 class="text-sm sm:text-base font-semibold text-gray-900 truncate">{{ $user?->name ?? 'Unknown' }}</h3>
                                        <p class="text-xs sm:text-sm text-gray-500 truncate">{{ $employee->position ?? 'No Position' }}</p>
                                    </div>

                                    <!-- Bio Summary - Hidden on mobile -->
                                    @if($user && $user->bio)
                                        <p class="text-xs text-gray-600 mt-1 line-clamp-2 hidden sm:block">{{ Str::limit($user->bio, 60) }}</p>
                                    @endif
                                    
                                    <!-- Joined date - Hidden on mobile -->
                                    <p class="text-xs text-gray-400 mt-1 hidden sm:block">
                                        Joined {{ $employee->hired_at ? $employee->hired_at->format('M d, Y') : 'N/A' }}
                                    </p>

                                    <!-- Contact Info - Hidden on mobile -->
                                    <div class="mt-2 space-y-0.5 text-sm border-t border-gray-100 pt-2 hidden sm:block">
                                        <div class="flex items-center gap-2 text-gray-600">
                                            <svg class="w-3.5 h-3.5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                            </svg>
                                            <span class="truncate text-xs">{{ $user?->email ?? 'No email' }}</span>
                                        </div>
                                        @if($user?->phone)
                                        <div class="flex items-center gap-2 text-gray-600">
                                            <svg class="w-3.5 h-3.5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                            </svg>
                                            <span class="text-xs">{{ $user->phone }}</span>
                                        </div>
                                        @endif
                                    </div>

                                    <div class="flex gap-2 mt-2 pt-2 border-t border-gray-100">
                                        <button wire:click="openProfileModal({{ $employee->id }})" 
                                                class="flex-1 text-center px-2 sm:px-3 py-1.5 text-[10px] sm:text-xs font-medium text-[#1E7A4A] bg-emerald-50 hover:bg-emerald-100 rounded-lg transition">
                                            View Profile
                                        </button>
                                        <a href="#" class="flex-1 text-center px-2 sm:px-3 py-1.5 text-[10px] sm:text-xs font-medium text-gray-600 bg-gray-50 hover:bg-gray-100 rounded-lg transition">
                                            Message
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-6 border-t border-gray-100 pt-4">
                        {{ $this->employees->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    @include('layouts.partials.employee-info-modal')
</div>