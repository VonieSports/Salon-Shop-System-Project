<div class="min-h-screen bg-[#F5F5F5]">
    <div class="max-w-7xl mx-auto px-3 sm:px-4 py-4 sm:py-6">

        @if (session()->has('message'))
            <div class="bg-[#FCE9ED] border border-[#D6657A]/30 text-[#7A3B4A] px-4 py-2.5 rounded-lg text-sm font-medium flex items-center gap-2 mb-4">
                <svg class="w-5 h-5 text-[#D6657A] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ session('message') }}
            </div>
        @endif
        
        @if (session()->has('error'))
            <div class="bg-[#FDE8E8] border border-[#D6657A]/40 text-[#7A2E3A] px-4 py-2.5 rounded-lg text-sm font-medium flex items-center gap-2 mb-4">
                <svg class="w-5 h-5 text-[#D6657A] flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                {{ session('error') }}
            </div>
        @endif

        <!-- Main Card - Single Container -->
        <div class="bg-white rounded-lg shadow-sm border border-[#EFEFEF] overflow-hidden">

            <!-- Header with Pink Gradient Background -->
            <div class="bg-gradient-to-r from-[#D6657A] to-[#C25467] px-4 sm:px-6 py-4 sm:py-5">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <h1 class="text-xl sm:text-2xl font-semibold text-white">Employees</h1>
                        <p class="text-white/80 text-sm mt-0.5">Manage your team members</p>
                    </div>
                    <a href="{{ route('owner.create_employee') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-white text-[#D6657A] hover:bg-[#FFF7F9] text-sm font-medium rounded-lg transition shadow-sm whitespace-nowrap">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Add Employee
                    </a>
                </div>
            </div>

            <!-- Search & Filter - Inside Card -->
            <div class="p-4 border-b border-[#EFEFEF]">
                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="relative flex-1">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-[#999]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input type="text" wire:model.live.debounce.300ms="search"
                            placeholder="Search by name, email, or phone..."
                            class="w-full pl-9 pr-3 py-2 bg-[#F5F5F5] border-0 rounded-lg focus:ring-2 focus:ring-[#D6657A]/30 text-sm placeholder:text-[#999] transition">
                    </div>

                    <div class="relative w-full sm:w-auto min-w-40">
                        <select wire:model.live="statusFilter"
                            class="w-full px-4 py-2 bg-[#F5F5F5] border-0 rounded-lg focus:ring-2 focus:ring-[#D6657A]/30 text-sm text-[#333] transition appearance-none cursor-pointer">
                            <option value="all">All Status</option>
                            <option value="online">Online Now</option>
                            <option value="offline">Offline</option>
                            <option value="never_logged_in">Never Logged In</option>
                            <option value="has_commission">With Commission</option>
                            <option value="inactive">Inactive</option>
                        </select>
                        <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-[#999] pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Body -->
            <div class="p-4">

                <!-- Empty State -->
                @if($this->employees->isEmpty())
                    <div class="text-center py-12">
                        <div class="w-16 h-16 mx-auto mb-3 bg-[#FCE9ED] rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-[#D6657A]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <p class="text-sm font-medium text-[#222]">No employees found</p>
                        <p class="text-xs text-[#999] mt-1">Start by adding your first team member</p>
                        <a href="{{ route('owner.create_employee') }}" class="inline-block mt-3 px-4 py-2 bg-[#D6657A] text-white text-sm font-medium rounded-lg hover:bg-[#C25467] transition">
                            Add Employee
                        </a>
                    </div>
                @else
                    <!-- Table -->
                    <div class="overflow-x-auto -mx-4 sm:mx-0 border border-[#EFEFEF] rounded-lg">
                        <table class="w-full min-w-[700px] sm:min-w-full text-sm">
                            <thead class="bg-[#F5F5F5] border-b border-[#EFEFEF]">
                                <tr>
                                    <th class="px-4 py-2.5 text-left text-xs font-medium text-[#666] uppercase tracking-wider">Employee</th>
                                    <th class="px-4 py-2.5 text-left text-xs font-medium text-[#666] uppercase tracking-wider hidden sm:table-cell">Contact</th>
                                    <th class="px-4 py-2.5 text-left text-xs font-medium text-[#666] uppercase tracking-wider hidden md:table-cell">Position</th>
                                    <th class="px-4 py-2.5 text-right text-xs font-medium text-[#666] uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[#EFEFEF] bg-white">
                                @foreach($this->employees as $employee)
                                    @php
                                        $user = $employee->user;
                                        $status = $user ? $user->status : [
                                            'badge_class' => 'bg-[#F5F5F5] text-[#999]',
                                            'dot_class' => 'bg-[#999]',
                                            'label' => 'No User',
                                            'is_online' => false,
                                        ];
                                        $isExpanded = $this->expandedEmployeeId === $employee->id;
                                    @endphp
                                    
                                    <!-- Employee Row -->
                                    <tr wire:key="emp-{{ $employee->id }}" class="hover:bg-[#F5F5F5] transition">
                                        <td class="px-4 py-2.5">
                                            <div class="flex items-center gap-2.5">
                                                <div class="relative flex-shrink-0">
                                                    @if($user?->avatar)
                                                        <img src="{{ Storage::url($user->avatar) }}"
                                                            class="w-9 h-9 rounded-full object-cover border border-[#EFEFEF]">
                                                    @else
                                                        <div class="w-9 h-9 rounded-full bg-[#FCE9ED] flex items-center justify-center border border-[#EFEFEF]">
                                                            <span class="text-xs font-bold text-[#D6657A]">
                                                                {{ strtoupper(substr($user?->name ?? 'U', 0, 1)) }}
                                                            </span>
                                                        </div>
                                                    @endif
                                                    @if(isset($status['is_online']) && $status['is_online'])
                                                        <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-[#2E7D32] border-2 border-white rounded-full"></span>
                                                    @elseif($user?->last_login_at)
                                                        <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-[#999] border-2 border-white rounded-full"></span>
                                                    @endif
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-[#222]">{{ $user?->name ?? 'Unknown' }}</p>
                                                    <p class="text-xs">
                                                        @if(isset($status['is_online']) && $status['is_online'])
                                                            <span class="text-[#2E7D32] font-medium">● Online</span>
                                                        @elseif($user?->last_login_at)
                                                            <span class="text-[#999]">● Offline</span>
                                                        @else
                                                            <span class="text-amber-500">● Not logged in</span>
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="px-4 py-2.5 hidden sm:table-cell">
                                            <p class="text-sm text-[#666] truncate max-w-32">{{ $user?->email ?? 'No email' }}</p>
                                            <p class="text-xs text-[#999]">{{ $user?->phone ?? 'No phone' }}</p>
                                        </td>

                                        <td class="px-4 py-2.5 hidden md:table-cell">
                                            <span class="text-sm text-[#666]">{{ $employee->position ?? 'Not set' }}</span>
                                        </td>

                                        <td class="px-4 py-2.5">
                                            <div class="flex items-center justify-end gap-0.5 flex-wrap">
                                                <!-- View Schedule Toggle -->
                                                @if($employee->schedules->isNotEmpty())
                                                    <button wire:click="toggleSchedule({{ $employee->id }})"
                                                            class="p-1.5 text-[#666] hover:text-[#222] hover:bg-[#F5F5F5] rounded-lg transition"
                                                            title="{{ $isExpanded ? 'Hide Schedule' : 'View Schedule' }}">
                                                        <svg class="w-4 h-4 transition-transform duration-200 {{ $isExpanded ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                                        </svg>
                                                    </button>
                                                @endif

                                                <!-- Edit -->
                                                <a href="{{ route('owner.update_employee', $employee->id) }}"
                                                    class="p-1.5 text-[#666] hover:text-[#222] hover:bg-[#F5F5F5] rounded-lg transition" 
                                                    title="Edit Employee">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                    </svg>
                                                </a>

                                                <!-- Toggle Active -->
                                                <button wire:click="toggleActive({{ $employee->id }})"
                                                    class="p-1.5 rounded-lg transition {{ $employee->is_active ? 'text-amber-500 hover:bg-amber-50' : 'text-[#2E7D32] hover:bg-[#FCE9ED]' }}" 
                                                    title="{{ $employee->is_active ? 'Deactivate' : 'Activate' }}">
                                                    @if($employee->is_active)
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                                        </svg>
                                                    @else
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                    @endif
                                                </button>

                                                <!-- Permissions -->
                                                <button wire:click="openPermissionModal({{ $employee->id }})"
                                                    class="p-1.5 text-blue-500 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition" 
                                                    title="Manage Permissions">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                                    </svg>
                                                </button>

                                                <!-- Delete -->
                                                <button wire:click="deleteEmployee({{ $employee->id }})"
                                                    wire:confirm="Delete this employee? This action cannot be undone."
                                                    class="p-1.5 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition" 
                                                    title="Delete Employee">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Schedule Expandable Row -->
                                    @if($isExpanded && $employee->schedules->isNotEmpty())
                                        <tr wire:key="schedule-{{ $employee->id }}" class="bg-[#F5F5F5]">
                                            <td colspan="4" class="p-0">
                                                <div class="border-t border-[#EFEFEF]">
                                                    <div class="px-4 py-3">
                                                        <p class="text-xs font-medium text-[#666] uppercase tracking-wider mb-2">Schedule</p>
                                                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2">
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

                                                                    if($sortedDays->count() >= 3 && $sortedDays->first() === 'Mon' && $sortedDays->last() === 'Fri' && $sortedDays->count() === 5) {
                                                                        $dayString = 'Mon - Fri';
                                                                    } elseif($sortedDays->first() === 'Mon' && $sortedDays->last() === 'Sat' && $sortedDays->count() === 6) {
                                                                        $dayString = 'Mon - Sat';
                                                                    } else {
                                                                        $dayString = $sortedDays->implode(', ');
                                                                    }
                                                                @endphp
                                                                <div class="bg-white rounded-lg border border-[#EFEFEF] p-2.5">
                                                                    <p class="text-sm font-medium text-[#222]">{{ $dayString }}</p>
                                                                    <p class="text-xs text-[#666]">{{ $start }} – {{ $end }}</p>
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
                    <div class="mt-4 border-t border-[#EFEFEF] pt-4">
                        {{ $this->employees->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    @include('layouts.partials.employee-permission-modal')
</div>