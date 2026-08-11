<div class="min-h-screen bg-gray-50">
    <div class="w-full">
        <div class="bg-white shadow-sm border border-gray-200 overflow-hidden rounded-lg">
            
            <!-- Header -->
            <div class="px-4 sm:px-6 py-5 border-b border-gray-200 bg-[#1E7A4A]">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <h1 class="text-2xl font-bold text-white">Employees</h1>
                        <p class="text-[#cfe8dc] text-base mt-0.5">Manage your team members</p>
                    </div>
                    <a href="{{ route('owner.create_employee') }}"
                        class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-[#1E7A4A] rounded-lg hover:bg-gray-50 transition text-base font-medium shadow-sm whitespace-nowrap">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Add Employee
                    </a>
                </div>
            </div>

            <!-- Body -->
            <div class="px-4 sm:px-6 py-5">

                <!-- Alerts -->
                @if (session()->has('message'))
                    <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg text-base">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>{{ session('message') }}</span>
                        </div>
                    </div>
                @endif
                
                @if (session()->has('error'))
                    <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg text-base">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <span>{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                <!-- Search & Filter -->
                <div class="flex flex-col sm:flex-row gap-3 mb-5">
                    <div class="relative flex-1">
                        <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input type="text" wire:model.live.debounce.300ms="search"
                            placeholder="Search by name, email, or phone..."
                            class="w-full pl-10 pr-4 py-3 text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1E7A4A]/30 focus:border-[#1E7A4A] transition bg-white">
                    </div>

                    <select wire:model.live="statusFilter"
                        class="px-4 py-3 text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1E7A4A]/30 focus:border-[#1E7A4A] transition bg-white w-full sm:w-auto min-w-44 appearance-none">
                        <option value="all">All Status</option>
                        <option value="online">Online Now</option>
                        <option value="offline">Offline</option>
                        <option value="never_logged_in">Never Logged In</option>
                        <option value="has_commission">With Commission</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

                <!-- Empty State -->
                @if($this->employees->isEmpty())
                    <div class="text-center py-12 bg-gray-50 rounded-lg border border-gray-200">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <p class="text-gray-600 text-base font-medium">No employees found</p>
                        <p class="text-gray-400 text-base mt-1">Start by adding your first team member</p>
                    </div>
                @else
                    <!-- Table -->
                    <div class="overflow-x-auto -mx-4 sm:mx-0 border border-gray-200 rounded-lg">
                        <table class="w-full min-w-[800px] sm:min-w-full">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-4 py-3.5 text-left text-sm font-semibold text-gray-500 uppercase tracking-wider">Employee</th>
                                    <th class="px-4 py-3.5 text-left text-sm font-semibold text-gray-500 uppercase tracking-wider hidden sm:table-cell">Contact</th>
                                    <th class="px-4 py-3.5 text-left text-sm font-semibold text-gray-500 uppercase tracking-wider hidden md:table-cell">Position</th>
                                    <th class="px-4 py-3.5 text-right text-sm font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach($this->employees as $employee)
                                    @php
                                        $user = $employee->user;
                                        $status = $user ? $user->status : [
                                            'badge_class' => 'bg-gray-100 text-gray-500',
                                            'dot_class' => 'bg-gray-400',
                                            'label' => 'No User',
                                            'is_online' => false,
                                        ];
                                        $isExpanded = $this->expandedEmployeeId === $employee->id;
                                    @endphp
                                    
                                    <!-- Employee Row -->
                                    <tr wire:key="emp-{{ $employee->id }}" class="hover:bg-gray-50 transition">
                                        <td class="px-4 py-3.5">
                                            <div class="flex items-center gap-3">
                                                <div class="relative flex-shrink-0">
                                                    @if($user?->avatar)
                                                        <img src="{{ Storage::url($user->avatar) }}"
                                                            class="w-11 h-11 rounded-full object-cover border border-gray-200">
                                                    @else
                                                        <div class="w-11 h-11 rounded-full bg-[#1E7A4A]/10 flex items-center justify-center border border-gray-200">
                                                            <span class="text-base font-bold text-[#1E7A4A]">
                                                                {{ strtoupper(substr($user?->name ?? 'U', 0, 1)) }}
                                                            </span>
                                                        </div>
                                                    @endif
                                                    @if(isset($status['is_online']) && $status['is_online'])
                                                        <span class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-green-500 border-2 border-white rounded-full"></span>
                                                    @elseif($user?->last_login_at)
                                                        <span class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-gray-400 border-2 border-white rounded-full"></span>
                                                    @endif
                                                </div>
                                                <div>
                                                    <p class="text-base font-medium text-gray-900">{{ $user?->name ?? 'Unknown' }}</p>
                                                    <p class="text-sm text-gray-500">
                                                        @if(isset($status['is_online']) && $status['is_online'])
                                                            <span class="text-green-600 font-medium">● Online</span>
                                                        @elseif($user?->last_login_at)
                                                            <span class="text-gray-500">● Offline</span>
                                                        @else
                                                            <span class="text-yellow-600">● Not logged in</span>
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="px-4 py-3.5 hidden sm:table-cell">
                                            <p class="text-base text-gray-700 truncate max-w-36">{{ $user?->email ?? 'No email' }}</p>
                                            <p class="text-sm text-gray-500">{{ $user?->phone ?? 'No phone' }}</p>
                                        </td>

                                        <td class="px-4 py-3.5 hidden md:table-cell">
                                            <span class="text-base text-gray-700">{{ $employee->position }}</span>
                                        </td>

                                        <td class="px-4 py-3.5">
                                            <div class="flex items-center justify-end gap-1.5 flex-wrap">
                                                <!-- View Schedule Toggle -->
                                                @if($employee->schedules->isNotEmpty())
                                                    <button wire:click="toggleSchedule({{ $employee->id }})"
                                                            class="inline-flex items-center gap-1.5 px-3.5 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition"
                                                            title="{{ $isExpanded ? 'Hide Schedule' : 'View Schedule' }}">
                                                        <svg class="w-4 h-4 transition-transform duration-200 {{ $isExpanded ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                                        </svg>
                                                        <span class="hidden sm:inline">{{ $isExpanded ? 'Hide' : 'View' }} Schedule</span>
                                                    </button>
                                                @endif

                                                <!-- Edit -->
                                                <a href="{{ route('owner.update_employee', $employee->id) }}"
                                                    class="p-2.5 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition" 
                                                    title="Edit Employee">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                    </svg>
                                                </a>

                                                <!-- Toggle Active -->
                                                <button wire:click="toggleActive({{ $employee->id }})"
                                                    class="p-2.5 rounded-lg transition {{ $employee->is_active ? 'text-yellow-600 hover:bg-yellow-50' : 'text-green-600 hover:bg-green-50' }}" 
                                                    title="{{ $employee->is_active ? 'Deactivate' : 'Activate' }}">
                                                    @if($employee->is_active)
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                                        </svg>
                                                    @else
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                    @endif
                                                </button>

                                                <!-- Permissions -->
                                                <button wire:click="openPermissionModal({{ $employee->id }})"
                                                    class="p-2.5 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition" 
                                                    title="Manage Permissions">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                                    </svg>
                                                </button>

                                                <!-- Delete -->
                                                <button wire:click="deleteEmployee({{ $employee->id }})"
                                                    wire:confirm="Delete this employee? This action cannot be undone."
                                                    class="p-2.5 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-lg transition" 
                                                    title="Delete Employee">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Schedule Expandable Row -->
                                    @if($isExpanded && $employee->schedules->isNotEmpty())
                                        <tr wire:key="schedule-{{ $employee->id }}" class="bg-gray-50">
                                            <td colspan="4" class="p-0">
                                                <div class="border-t border-gray-200">
                                                    <div class="px-4 py-4">
                                                        <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Weekly Schedule</p>
                                                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                                                            @php
                                                                $daysMap = ['monday'=>'Mon', 'tuesday'=>'Tue', 'wednesday'=>'Wed', 'thursday'=>'Thu', 'friday'=>'Fri', 'saturday'=>'Sat', 'sunday'=>'Sun'];
                                                                $orderedDays = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
                                                                
                                                                $schedules = $employee->schedules->groupBy(function($item) {
                                                                    return \Carbon\Carbon::parse($item->start_time)->format('H:i') . '-' . \Carbon\Carbon::parse($item->end_time)->format('H:i');
                                                                });
                                                            @endphp
                                                            
                                                            @foreach($schedules as $timeKey => $group)
                                                                @php
                                                                    $days = $group->pluck('day_of_week')->map(fn($d) => $daysMap[$d] ?? ucfirst($d))->values();
                                                                    $sortedDays = $days->sortBy(fn($d) => array_search($d, $orderedDays))->values();
                                                                    
                                                                    $times = explode('-', $timeKey);
                                                                    $start = \Carbon\Carbon::createFromFormat('H:i', $times[0])->format('g:i A');
                                                                    $end = \Carbon\Carbon::createFromFormat('H:i', $times[1])->format('g:i A');

                                                                    // Check for consecutive days
                                                                    if($sortedDays->count() >= 3 && $sortedDays->first() === 'Mon' && $sortedDays->last() === 'Fri' && $sortedDays->count() === 5) {
                                                                        $dayString = 'Mon - Fri';
                                                                    } elseif($sortedDays->first() === 'Mon' && $sortedDays->last() === 'Sat' && $sortedDays->count() === 6) {
                                                                        $dayString = 'Mon - Sat';
                                                                    } else {
                                                                        $dayString = $sortedDays->implode(', ');
                                                                    }
                                                                @endphp
                                                                <div class="bg-white rounded-lg border border-gray-200 p-3.5">
                                                                    <p class="text-base font-medium text-gray-900">{{ $dayString }}</p>
                                                                    <p class="text-base text-gray-600">{{ $start }} – {{ $end }}</p>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-4 border-t border-gray-200 pt-4">
                        {{ $this->employees->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    @include('layouts.partials.employee-permission-modal')
</div>