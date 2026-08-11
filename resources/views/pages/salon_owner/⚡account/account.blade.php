<div class="min-h-screen bg-gray-50">
    <div class="w-full">
        <div class="bg-white shadow-sm border border-gray-200 overflow-hidden lg:rounded-lg">
            
            <!-- Header -->
            <div class="px-4 sm:px-6 py-5 border-b border-gray-200 bg-[#1E7A4A]">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <h1 class="text-2xl font-bold text-white">Employee Accounts</h1>
                        <p class="text-[#cfe8dc] text-base mt-0.5">View all employee profiles in your organization</p>
                    </div>
                    <a href="{{ route('owner.create_employee') }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-[#1E7A4A] rounded-lg hover:bg-gray-50 transition text-base font-medium shadow-sm whitespace-nowrap">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                        Add Employee
                    </a>
                </div>
            </div>

            <!-- Stats -->
            <div class="px-4 sm:px-6 py-4 bg-gray-50 border-b border-gray-200">
                <div class="grid grid-cols-3 gap-3 sm:gap-4">
                    <div class="bg-white rounded-lg p-3 sm:p-4 border border-gray-200 text-center">
                        <p class="text-xs text-gray-500 uppercase tracking-wider">Total</p>
                        <p class="text-xl sm:text-2xl font-bold text-[#1E7A4A]">{{ $totalEmployees }}</p>
                    </div>
                    <div class="bg-white rounded-lg p-3 sm:p-4 border border-gray-200 text-center">
                        <p class="text-xs text-gray-500 uppercase tracking-wider">Active</p>
                        <p class="text-xl sm:text-2xl font-bold text-[#1E7A4A]">{{ $activeEmployees }}</p>
                    </div>
                    <div class="bg-white rounded-lg p-3 sm:p-4 border border-gray-200 text-center">
                        <p class="text-xs text-gray-500 uppercase tracking-wider">Inactive</p>
                        <p class="text-xl sm:text-2xl font-bold text-gray-400">{{ $totalEmployees - $activeEmployees }}</p>
                    </div>
                </div>
            </div>

            <!-- Content -->
            <div class="px-4 sm:px-6 py-5">
                <!-- Filters -->
                <div class="flex flex-col sm:flex-row gap-3 mb-5">
                    <div class="relative flex-1">
                        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input type="text" 
                               wire:model.live.debounce.300ms="search" 
                               placeholder="Search by name, email, or phone..."
                               class="w-full pl-10 pr-4 py-3 text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1E7A4A]/30 focus:border-[#1E7A4A] transition bg-white">
                    </div>
                    
                    <select wire:model.live="roleFilter"
                            class="px-4 py-3 text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1E7A4A]/30 focus:border-[#1E7A4A] transition bg-white w-full sm:w-auto min-w-[160px] appearance-none">
                        <option value="all">All Roles</option>
                        <option value="employee">Employees</option>
                        <option value="owner">Owner</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

                <!-- Employee Cards Grid -->
                @if($this->employees->isEmpty())
                    <div class="text-center py-12 bg-gray-50 rounded-lg border border-gray-200">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <p class="text-gray-600 text-base font-medium">No employees found</p>
                        <p class="text-gray-400 text-base mt-1">Start by adding your first team member</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
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
                            
                            <div class="bg-white rounded-lg border border-gray-200 hover:shadow-md transition-shadow duration-200 overflow-hidden">
                                <!-- Cover Photo -->
                                <div class="relative h-20 bg-[#1E7A4A]/10">
                                    @if($user && $user->cover_photo)
                                        <img src="{{ Storage::url($user->cover_photo) }}" 
                                             class="w-full h-full object-cover"
                                             alt="Cover photo">
                                    @else
                                        <div class="w-full h-full bg-[#1E7A4A]/10 flex items-center justify-center">
                                            <svg class="w-8 h-8 text-[#1E7A4A]/20" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                <!-- Card Body - Centered -->
                                <div class="px-4 pb-4 text-center">
                                    <!-- Avatar -->
                                    <div class="relative inline-block -mt-8">
                                        <div class="w-16 h-16 rounded-full overflow-hidden border-4 border-white bg-gray-100 shadow-sm">
                                            @if($user && $user->avatar)
                                                <img src="{{ Storage::url($user->avatar) }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center bg-[#1E7A4A]/10">
                                                    <span class="text-xl font-bold text-[#1E7A4A]">
                                                        {{ strtoupper(substr($user?->name ?? 'U', 0, 1)) }}
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                        @if($status['is_online'] ?? false)
                                            <span class="absolute bottom-1 right-1 w-3.5 h-3.5 bg-green-500 border-2 border-white rounded-full"></span>
                                        @endif
                                    </div>

                                    <!-- Name & Position -->
                                    <div class="mt-2">
                                        <h3 class="text-base font-semibold text-gray-900 truncate">{{ $user?->name ?? 'Unknown' }}</h3>
                                        <p class="text-sm text-gray-500 truncate">{{ $employee->position ?? 'No Position' }}</p>
                                    </div>

                                    <!-- Role Badge -->
                                    <div class="mt-1.5 flex gap-1.5 flex-wrap justify-center">
                                        @if($isOwner)
                                            <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium bg-[#1E7A4A] text-white rounded">Owner</span>
                                        @endif
                                        @if($isAdmin)
                                            <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium bg-blue-100 text-blue-800 rounded">Admin</span>
                                        @endif
                                        @if(!$isOwner && !$isAdmin)
                                            <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium bg-gray-100 text-gray-600 rounded">Employee</span>
                                        @endif
                                    </div>

                                    <!-- Contact Info -->
                                    <div class="mt-3 space-y-1.5 text-sm border-t border-gray-100 pt-3">
                                        <div class="flex items-center justify-center gap-2 text-gray-600">
                                            <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                            </svg>
                                            <span class="truncate text-sm">{{ $user?->email ?? 'No email' }}</span>
                                        </div>
                                        @if($user?->phone)
                                        <div class="flex items-center justify-center gap-2 text-gray-600">
                                            <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                            </svg>
                                            <span class="text-sm">{{ $user->phone }}</span>
                                        </div>
                                        @endif
                                    </div>

                                    <!-- Actions -->
                                    <div class="flex gap-2 mt-3 pt-3 border-t border-gray-100">
                                        <button wire:click="openProfileModal({{ $employee->id }})" 
                                                class="flex-1 text-center px-3 py-2 text-sm font-medium text-[#1E7A4A] bg-[#1E7A4A]/10 hover:bg-[#1E7A4A]/20 rounded-lg transition">
                                            View Profile
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-6 border-t border-gray-200 pt-4">
                        {{ $this->employees->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Employee Profile Modal -->
    @if($showProfileModal && $selectedEmployee)
    <div class="fixed inset-0 z-50 overflow-y-auto" x-data="{ show: true }" x-show="show" x-cloak>
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-900/50"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            
            <div class="relative inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full max-h-[95vh] flex flex-col" role="dialog" aria-modal="true">
                
                <!-- Modal Header -->
                <div class="px-6 py-4 border-b border-gray-200 bg-white flex items-center justify-between shrink-0">
                    <h3 class="text-xl font-semibold text-gray-900">Employee Profile</h3>
                    <button wire:click="closeProfileModal" class="text-gray-400 hover:text-gray-600 transition p-2 rounded-lg hover:bg-gray-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="px-6 py-6 overflow-y-auto flex-1">
                    @php 
                        $user = $selectedEmployee->user;
                        $userRoles = $user ? $user->roles->pluck('name')->toArray() : [];
                        $isOwner = in_array('owner', $userRoles);
                        $isAdmin = in_array('admin', $userRoles);
                        $status = $user ? $user->status : ['is_online' => false];
                    @endphp

                    <!-- Cover Photo -->
                    <div class="relative h-48 bg-[#1E7A4A]/10 rounded-lg overflow-hidden">
                        @if($user && $user->cover_photo)
                            <img src="{{ Storage::url($user->cover_photo) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-[#1E7A4A]/10 flex items-center justify-center">
                                <svg class="w-16 h-16 text-[#1E7A4A]/20" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- Profile Header -->
                    <div class="relative flex items-end -mt-12 sm:-mt-14 px-1">
                        <div class="relative">
                            <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-full overflow-hidden border-4 border-white bg-gray-100 shadow-md">
                                @if($user && $user->avatar)
                                    <img src="{{ Storage::url($user->avatar) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-[#1E7A4A]/10">
                                        <span class="text-3xl sm:text-4xl font-bold text-[#1E7A4A]">
                                            {{ strtoupper(substr($user?->name ?? 'U', 0, 1)) }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                            @if($status['is_online'] ?? false)
                                <span class="absolute bottom-1 right-1 w-4 h-4 bg-green-500 border-2 border-white rounded-full"></span>
                            @endif
                        </div>
                        
                        <div class="ml-4 sm:ml-5 flex-1 pb-1">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                                <div>
                                    <h4 class="text-xl sm:text-2xl font-bold text-gray-900">{{ $user?->name ?? 'Unknown' }}</h4>
                                    <p class="text-base text-gray-500">{{ $selectedEmployee->position ?? 'No Position' }}</p>
                                </div>
                                <div class="flex gap-2 flex-wrap">
                                    @if($isOwner)
                                        <span class="inline-flex items-center px-3 py-1 text-sm font-medium bg-[#1E7A4A] text-white rounded-lg">Owner</span>
                                    @endif
                                    @if($isAdmin)
                                        <span class="inline-flex items-center px-3 py-1 text-sm font-medium bg-blue-100 text-blue-800 rounded-lg">Admin</span>
                                    @endif
                                    @if(!$isOwner && !$isAdmin)
                                        <span class="inline-flex items-center px-3 py-1 text-sm font-medium bg-gray-100 text-gray-600 rounded-lg">Employee</span>
                                    @endif
                                    <span class="inline-flex items-center px-3 py-1 text-sm font-medium {{ $selectedEmployee->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} rounded-lg">
                                        {{ $selectedEmployee->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Details Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 mt-6 pt-4 border-t border-gray-200">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider">Full Name</label>
                            <p class="text-base text-gray-900 font-medium">{{ $user?->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider">Email</label>
                            <p class="text-base text-gray-900">{{ $user?->email ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</label>
                            <p class="text-base text-gray-900">{{ $user?->phone ?? 'Not provided' }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider">Position</label>
                            <p class="text-base text-gray-900">{{ $selectedEmployee->position ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider">Hired Date</label>
                            <p class="text-base text-gray-900">{{ $selectedEmployee->hired_at ? $selectedEmployee->hired_at->format('M d, Y') : 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider">Commission Rate</label>
                            <p class="text-base text-gray-900">{{ number_format($selectedEmployee->commission_rate ?? 0, 2) }}%</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider">Commission Eligible</label>
                            <p class="text-base text-gray-900">{{ $selectedEmployee->is_commission_eligible ? 'Yes' : 'No' }}</p>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider">Last Login</label>
                            <p class="text-base text-gray-900">{{ $user?->last_login_at ? $user->last_login_at->format('M d, Y g:i A') : 'Never' }}</p>
                        </div>
                    </div>

                    <!-- Bio -->
                    @if($user && $user->bio)
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider">Bio</label>
                            <p class="text-base text-gray-700 mt-1 leading-relaxed">{{ $user->bio }}</p>
                        </div>
                    @endif

                    <!-- Permissions -->
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Permissions</label>
                        <div class="flex flex-wrap gap-2">
                            @if($user && $user->permissions->count() > 0)
                                @foreach($user->permissions as $permission)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium bg-[#1E7A4A]/10 text-[#1E7A4A] rounded-lg border border-[#1E7A4A]/20">
                                        <svg class="w-4 h-4 text-[#1E7A4A]" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ ucfirst(str_replace('_', ' ', $permission->name)) }}
                                    </span>
                                @endforeach
                            @else
                                <span class="text-base text-gray-400">No permissions assigned</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="px-6 py-4 bg-gray-50/80 border-t border-gray-200 flex flex-col sm:flex-row sm:justify-end gap-3 shrink-0">
                    <button wire:click="closeProfileModal" 
                            class="w-full sm:w-auto px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition shadow-sm">
                        Close
                    </button>
                    <a href="{{ route('owner.update_employee', $selectedEmployee->id) }}" 
                       class="w-full sm:w-auto px-5 py-2.5 text-sm font-medium text-white bg-[#1E7A4A] rounded-lg hover:bg-[#145537] transition shadow-sm hover:shadow-md flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                        </svg>
                        Edit Profile
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>