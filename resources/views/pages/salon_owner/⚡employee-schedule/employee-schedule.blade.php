<div class="min-h-screen bg-[#F5F5F5]">
    <div class="max-w-7xl mx-auto px-3 sm:px-4 py-4 sm:py-6">

        <!-- Single Container Card -->
        <div class="bg-white rounded-lg shadow-sm border border-[#EFEFEF] overflow-hidden">

            <!-- Header with Gradient Background -->
            <div class="bg-gradient-to-r from-[#D6657A] to-[#C25467] px-4 sm:px-6 py-4 sm:py-5">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <h1 class="text-xl sm:text-2xl font-semibold text-white">Employee Schedule & Services</h1>
                        <p class="text-white/80 text-sm mt-0.5">Manage shifts and assign services for each staff member</p>
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

            <!-- Search & Filters - Inside same card -->
            <div class="px-4 sm:px-6 py-4 border-b border-[#EFEFEF]">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <!-- Search -->
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-[#999]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input type="text" wire:model.live.debounce.300ms="search"
                            placeholder="Search by name..."
                            class="w-full pl-9 pr-3 py-2 bg-[#F5F5F5] border-0 rounded-lg focus:ring-2 focus:ring-[#D6657A]/30 text-sm placeholder:text-[#999] transition">
                    </div>

                    <!-- Dropdown -->
                    <div class="relative">
                        <select wire:model.live="positionFilter"
                            class="w-full px-4 py-2 bg-[#F5F5F5] border-0 rounded-lg focus:ring-2 focus:ring-[#D6657A]/30 text-sm text-[#333] transition appearance-none cursor-pointer">
                            <option value="">All Positions</option>
                            <option value="manager">Manager</option>
                            <option value="stylist">Stylist</option>
                            <option value="assistant">Assistant</option>
                            <option value="receptionist">Receptionist</option>
                        </select>
                        <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-[#999] pointer-events-none" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Body -->
            <div class="p-4 sm:p-6">

                <!-- Alerts -->
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

                <!-- Employees Grid -->
                @if($this->employees->isEmpty())
                    <div class="text-center py-12">
                        <div class="w-16 h-16 mx-auto mb-3 bg-[#FCE9ED] rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-[#D6657A]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <p class="text-sm font-medium text-[#222]">No employees found</p>
                        <p class="text-xs text-[#999] mt-1">Add your first team member to get started</p>
                        <a href="{{ route('owner.create_employee') }}" class="inline-block mt-3 px-4 py-2 bg-[#D6657A] text-white text-sm font-medium rounded-lg hover:bg-[#C25467] transition">
                            Add Employee
                        </a>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($this->employees as $employee)
                            @php
                                $user = $employee->user;
                                $isExpanded = $this->expandedEmployeeId === $employee->id;
                                $weekSchedule = $this->getEmployeeWeekSchedule($employee->id);
                            @endphp
                            
                            <div wire:key="emp-{{ $employee->id }}" class="bg-white rounded-lg shadow-sm border border-[#EFEFEF] overflow-hidden hover:shadow-md transition">
                                <!-- Employee Header -->
                                <div class="p-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                    <div class="flex items-center gap-3">
                                        <div class="relative flex-shrink-0">
                                            @if($user?->avatar)
                                                <img src="{{ Storage::url($user->avatar) }}" class="w-10 h-10 rounded-full object-cover border border-[#EFEFEF]">
                                            @else
                                                <div class="w-10 h-10 rounded-full bg-[#FCE9ED] flex items-center justify-center border border-[#EFEFEF]">
                                                    <span class="text-sm font-bold text-[#D6657A]">{{ strtoupper(substr($user?->name ?? 'U', 0, 1)) }}</span>
                                                </div>
                                            @endif
                                            @if($employee->is_active)
                                                <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 bg-[#2E7D32] border-2 border-white rounded-full"></span>
                                            @endif
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-[#222]">{{ $user?->name ?? 'Unknown' }}</p>
                                            <p class="text-xs text-[#999]">{{ $employee->position ?? 'No position' }}</p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <button wire:click="openServiceModal({{ $employee->id }})"
                                            class="px-3 py-1.5 bg-[#D6657A]/10 text-[#D6657A] hover:bg-[#D6657A] hover:text-white text-xs font-medium rounded-lg transition">
                                            Assign Services
                                        </button>
                                        <button wire:click="toggleExpand({{ $employee->id }})"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-[#666] hover:text-[#D6657A] hover:bg-[#FCE9ED] rounded-lg transition">
                                            <span>{{ $isExpanded ? 'Hide' : 'View' }} Schedule</span>
                                            <svg class="w-4 h-4 transition-transform duration-200 {{ $isExpanded ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <!-- Assigned Services -->
                                <div class="px-4 pb-2 flex flex-wrap gap-1.5">
                                    @if($employee->services->isNotEmpty())
                                        @foreach($employee->services as $service)
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-[#FCE9ED] text-[#D6657A] text-[10px] font-medium rounded-full">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                {{ $service->name }}
                                            </span>
                                        @endforeach
                                    @else
                                        <span class="text-xs text-[#999]">No services assigned</span>
                                    @endif
                                </div>

                                <!-- Schedule Expandable Section -->
                                @if($isExpanded)
                                    <div class="border-t border-[#EFEFEF] bg-[#FAFAFA] p-4">
                                        <p class="text-xs font-medium text-[#999] uppercase tracking-wider mb-3">Weekly Schedule</p>
                                        
                                        @if(empty($weekSchedule))
                                            <p class="text-sm text-[#999] text-center py-4">No schedule set for this employee</p>
                                        @else
                                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3">
                                                @foreach($weekSchedule as $day => $data)
                                                    <div class="bg-white rounded-lg border border-[#EFEFEF] p-3">
                                                        <div class="flex items-center justify-between mb-1.5">
                                                            <span class="text-sm font-medium text-[#222]">{{ $data['label'] }}</span>
                                                            @if($data['employee_shift'])
                                                                <span class="text-[10px] font-medium text-[#2E7D32] bg-[#E8F5E9] px-2 py-0.5 rounded-full">Active</span>
                                                            @else
                                                                <span class="text-[10px] font-medium text-[#999] bg-[#F5F5F5] px-2 py-0.5 rounded-full">Off</span>
                                                            @endif
                                                        </div>
                                                        
                                                        @if($data['employee_shift'])
                                                            <p class="text-xs text-[#666]">
                                                                {{ \Carbon\Carbon::parse($data['employee_shift']->start_time)->format('g:i A') }} – 
                                                                {{ \Carbon\Carbon::parse($data['employee_shift']->end_time)->format('g:i A') }}
                                                            </p>
                                                            <button wire:click="removeShift({{ $employee->id }}, '{{ $day }}')"
                                                                class="mt-1.5 text-[10px] text-red-400 hover:text-red-600 transition font-medium">
                                                                Remove Shift
                                                            </button>
                                                        @else
                                                            <button wire:click="openAddShiftModal({{ $employee->id }}, '{{ $day }}')"
                                                                class="mt-1.5 text-xs text-[#D6657A] hover:text-[#C25467] transition font-medium">
                                                                + Add Shift
                                                            </button>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Add Shift Modal -->
    @if($showAddShiftModal)
        <div class="fixed inset-0 bg-black/30 backdrop-blur-sm flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-xl shadow-xl max-w-md w-full border border-[#EFEFEF]">
                <div class="px-6 py-4 border-b border-[#EFEFEF] flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-[#222]">Add Shift</h3>
                    <button wire:click="closeAddShiftModal" class="text-[#999] hover:text-[#222] transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-[#666] mb-1">Start Time</label>
                        <input type="time" wire:model="shiftStart" class="w-full px-3 py-2 bg-[#F5F5F5] border-0 rounded-lg focus:ring-2 focus:ring-[#D6657A]/30 text-sm transition">
                        @error('shiftStart') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-[#666] mb-1">End Time</label>
                        <input type="time" wire:model="shiftEnd" class="w-full px-3 py-2 bg-[#F5F5F5] border-0 rounded-lg focus:ring-2 focus:ring-[#D6657A]/30 text-sm transition">
                        @error('shiftEnd') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="px-6 py-4 bg-[#FAFAFA] border-t border-[#EFEFEF] flex justify-end gap-3">
                    <button wire:click="closeAddShiftModal" class="px-4 py-2 text-sm text-[#666] hover:text-[#222] transition font-medium">
                        Cancel
                    </button>
                    <button wire:click="saveShift" class="px-4 py-2 bg-[#D6657A] hover:bg-[#C25467] text-white text-sm font-medium rounded-lg transition">
                        Save Shift
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Service Assignment Modal -->
    @if($showServiceModal)
        <div class="fixed inset-0 bg-black/30 backdrop-blur-sm flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-xl shadow-xl max-w-lg w-full border border-[#EFEFEF]">
                <div class="px-6 py-4 border-b border-[#EFEFEF] flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-[#222]">Assign Services</h3>
                    <button wire:click="closeServiceModal" class="text-[#999] hover:text-[#222] transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <div class="p-6">
                    <p class="text-sm text-[#666] mb-4">Select services for this employee</p>
                    <div class="space-y-2 max-h-60 overflow-y-auto">
                        @foreach($this->allServices as $service)
                            <label class="flex items-center gap-3 p-2 hover:bg-[#F5F5F5] rounded-lg transition cursor-pointer">
                                <input type="checkbox" wire:model="selectedServiceIds" value="{{ $service->id }}"
                                    class="w-4 h-4 text-[#D6657A] focus:ring-[#D6657A]/30 rounded border-[#EFEFEF]">
                                <span class="text-sm text-[#333]">{{ $service->name }}</span>
                                <span class="ml-auto text-xs text-[#999]">₱{{ number_format($service->price, 2) }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                <div class="px-6 py-4 bg-[#FAFAFA] border-t border-[#EFEFEF] flex justify-end gap-3">
                    <button wire:click="closeServiceModal" class="px-4 py-2 text-sm text-[#666] hover:text-[#222] transition font-medium">
                        Cancel
                    </button>
                    <button wire:click="saveServiceAssignment" class="px-4 py-2 bg-[#D6657A] hover:bg-[#C25467] text-white text-sm font-medium rounded-lg transition">
                        Save Assignments
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>