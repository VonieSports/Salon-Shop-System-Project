
<div class="min-h-screen bg-gray-50">
    <div class="w-full">
        <div class="bg-white shadow-sm border-x-0 sm:border-x border-gray-200 overflow-hidden">
            <div class="px-3 sm:px-6 py-4 sm:py-5 border-b border-gray-100 bg-[#1E7A4A]">
                <div class="flex items-center justify-between flex-wrap gap-3">
                    <div>
                        <h1 class="text-lg sm:text-2xl font-bold text-white">Employees</h1>
                        <p class="text-white/80 text-xs sm:text-sm mt-0.5">Manage your team members</p>
                    </div>
                    <a href="{{ route('owner.create_employee') }}"
                       class="inline-flex items-center gap-1.5 sm:gap-2 px-3 sm:px-5 py-1.5 sm:py-2 bg-white text-[#1E7A4A] rounded-full hover:bg-gray-50 transition text-xs sm:text-sm font-medium shadow-sm whitespace-nowrap">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                        </svg>
                        <span class="hidden xs:inline">Add Employee</span>
                        <span class="xs:hidden">Add</span>
                    </a>
                </div>
            </div>

            <!-- Content -->
            <div class="px-3 sm:px-6 py-3 sm:py-6">
                @if (session()->has('message'))
                    <div class="mb-4 p-3 sm:p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm">
                        {{ session('message') }}
                    </div>
                @endif
                @if (session()->has('error'))
                    <div class="mb-4 p-3 sm:p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm">
                        {{ session('error') }}
                    </div>
                @endif

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
                    
                    <select wire:model.live="statusFilter"
                            class="px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#1E7A4A]/30 focus:border-[#1E7A4A] transition bg-white w-full sm:w-auto min-w-[160px] appearance-none">
                        <option value="all"> All Status</option>
                        <option value="online"> Online Now</option>
                        <option value="offline"> Offline</option>
                        <option value="never_logged_in"> Never Logged In</option>
                        <option value="has_commission"> With Commission</option>
                        <option value="inactive"> Inactive</option>
                    </select>
                </div>

                <!-- Employee List -->
                @if($this->employees->isEmpty())
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <p class="text-gray-500 text-sm">No employees found</p>
                        <p class="text-gray-400 text-sm mt-1">Start by adding your first team member</p>
                    </div>
                @else
                    <div class="overflow-x-auto -mx-3 sm:mx-0">
                        <table class="w-full min-w-[640px] sm:min-w-full">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-3 sm:px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Employee</th>
                                    <th class="px-3 sm:px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider hidden sm:table-cell">Contact</th>
                                    <th class="px-3 sm:px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider hidden md:table-cell">Position</th>
                                    <th class="px-3 sm:px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider hidden lg:table-cell">Hired</th>
                                    <th class="px-3 sm:px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($this->employees as $employee)
                                    @php 
                                        $user = $employee->user;
                                        // Use the User's status trait directly - NO getEmployeeStatus method needed!
                                        $status = $user ? $user->status : [
                                            'badge_class' => 'bg-gray-100 text-gray-500',
                                            'dot_class' => 'bg-gray-400',
                                            'label' => 'No User',
                                            'is_online' => false,
                                        ];
                                    @endphp
                                    <tr class="hover:bg-gray-50 transition">
                                        <!-- Employee Info -->
                                        <td class="px-3 sm:px-4 py-3">
                                            <div class="flex items-center gap-2 sm:gap-3">
                                                <div class="relative flex-shrink-0">
                                                    @if($user?->avatar)
                                                        <img src="{{ Storage::url($user->avatar) }}" 
                                                             class="w-8 h-8 sm:w-10 sm:h-10 rounded-full object-cover border-2 border-gray-200">
                                                    @else
                                                        <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-emerald-100 flex items-center justify-center border-2 border-gray-200">
                                                            <span class="text-xs sm:text-sm font-bold text-emerald-700">
                                                                {{ strtoupper(substr($user?->name ?? 'U', 0, 1)) }}
                                                            </span>
                                                        </div>
                                                    @endif
                                                    @if(isset($status['is_online']) && $status['is_online'])
                                                        <span class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 sm:w-3 sm:h-3 bg-green-500 border-2 border-white rounded-full animate-pulse"></span>
                                                    @elseif($user?->last_login_at)
                                                        <span class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 sm:w-3 sm:h-3 bg-gray-400 border-2 border-white rounded-full"></span>
                                                    @endif
                                                </div>
                                                <div class="min-w-0">
                                                    <p class="text-sm font-semibold text-gray-900 truncate max-w-[100px] sm:max-w-[150px]">{{ $user?->name ?? 'Unknown' }}</p>
                                                    <p class="text-xs text-gray-400 truncate max-w-[100px] sm:max-w-none">
                                                        @if(isset($status['is_online']) && $status['is_online'])
                                                            <span class="text-green-600 font-medium">● Online</span>
                                                        @elseif($user?->last_login_at)
                                                            <span class="text-gray-400">● Offline</span>
                                                        @else
                                                            <span class="text-yellow-600">● Not logged in</span>
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <!-- Contact -->
                                        <td class="px-3 sm:px-4 py-3 hidden sm:table-cell">
                                            <p class="text-sm text-gray-600 truncate max-w-[150px]">{{ $user?->email ?? 'No email' }}</p>
                                            <p class="text-xs text-gray-400">{{ $user?->phone ?? 'No phone' }}</p>
                                        </td>
                                        
                                        <!-- Position -->
                                        <td class="px-3 sm:px-4 py-3 hidden md:table-cell">
                                            <span class="text-sm text-gray-700">{{ $employee->position }}</span>
                                        </td>
                                        
                                        <!-- Hired Date -->
                                        <td class="px-3 sm:px-4 py-3 hidden lg:table-cell">
                                            <span class="text-sm text-gray-700">
                                                {{ $employee->hired_at ? $employee->hired_at->format('M d, Y') : '-' }}
                                            </span>
                                        </td>
                                        
                                        <td class="px-3 sm:px-4 py-3 text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <!-- Activate/Deactivate Button -->
                                                <button wire:click="toggleActive({{ $employee->id }})"
                                                        class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium rounded-lg transition
                                                               {{ $employee->is_active 
                                                                  ? 'bg-yellow-100 text-yellow-700 hover:bg-yellow-200' 
                                                                  : 'bg-green-100 text-green-700 hover:bg-green-200' }}"
                                                        title="{{ $employee->is_active ? 'Deactivate' : 'Activate' }}">
                                                    @if($employee->is_active)
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                                        </svg>
                                                        Deactivate
                                                    @else
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        </svg>
                                                        Activate
                                                    @endif
                                                </button>

                                                <!-- Permissions Button -->
                                                <button wire:click="openPermissionModal({{ $employee->id }})"
                                                        class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium rounded-lg bg-blue-100 text-blue-700 hover:bg-blue-200 transition"
                                                        title="Manage Permissions">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                                    </svg>
                                                    Permissions
                                                </button>

                                                <!-- Delete Button -->
                                                <button wire:click="deleteEmployee({{ $employee->id }})"
                                                        wire:confirm="Delete this employee? This action cannot be undone."
                                                        class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium rounded-lg bg-red-100 text-red-700 hover:bg-red-200 transition"
                                                        title="Delete Employee">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                    Delete
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4 border-t border-gray-100 pt-4">
                        {{ $this->employees->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    @if($showPermissionModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="mt-3">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">Manage Permissions</h3>
                    <div class="mt-4">
                        @foreach($allPermissions as $permission)
                            <div class="mb-2">
                                <label class="inline-flex items-center">
                                    <input type="checkbox" wire:model="selectedPermissions" value="{{ $permission->name }}"
                                           class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-700">{{ ucfirst(str_replace('_', ' ', $permission->name)) }}</span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <div class="flex justify-end gap-2 mt-4">
                        <button type="button" wire:click="closePermissionModal" 
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                            Cancel
                        </button>
                        <button type="button" wire:click="savePermissions" 
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Save Permissions
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>