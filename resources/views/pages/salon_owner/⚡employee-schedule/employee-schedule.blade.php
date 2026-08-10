<div>
    <div class="min-h-screen bg-gray-50 py-6">
        <div class="mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Main Card Wrapper -->
            <div class="bg-white shadow-sm border-x-0 sm:border-x border-gray-200 overflow-hidden rounded-xl">
                
                <!-- GREEN HEADER BAR -->
                <div class="px-3 sm:px-6 py-4 sm:py-5 border-b border-gray-100 bg-[#1E7A4A]">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between flex-wrap gap-3">
                        <div>
                            <h1 class="text-lg sm:text-2xl font-bold text-white">Employee Schedule</h1>
                            <p class="text-white/80 text-xs sm:text-sm mt-0.5">Manage employee shifts and shop availability</p>
                        </div>
                        <a href="{{ route('owner.employee') }}" 
                           class="inline-flex items-center gap-1.5 sm:gap-2 px-3 sm:px-5 py-1.5 sm:py-2 bg-white text-[#1E7A4A] rounded-full hover:bg-gray-50 transition text-xs sm:text-sm font-medium shadow-sm whitespace-nowrap">
                            Back to Employees
                        </a>
                    </div>
                </div>

                <!-- BODY CONTENT -->
                <div class="px-3 sm:px-6 py-3 sm:py-6">

                    <!-- Shop Closed Alert (Inside white body like your Employee page) -->
                    @if(!$this->hasShopHours)
                        <div class="mb-4 p-3 sm:p-4 bg-red-50 border border-red-200 text-red-700 rounded-xl text-sm flex items-center gap-2">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <div>
                                <p class="font-medium text-sm">Shop is currently closed.</p>
                                <p class="text-xs mt-0.5 text-red-600/80">Employees cannot be scheduled until you add operating hours in <a href="{{ route('owner.business_setup') }}" class="underline hover:text-red-800">Business Setup</a>.</p>
                            </div>
                        </div>
                    @endif

                    <!-- Filter Bar (Same spacing as Employee page) -->
                    <div class="flex flex-col sm:flex-row gap-3 mb-4 sm:mb-6">
                        <div class="relative flex-1">
                            <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <input type="text" wire:model.live.debounce.300ms="search"
                                placeholder="Search by name..."
                                class="w-full pl-10 pr-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#1E7A4A]/30 focus:border-[#1E7A4A] transition bg-white">
                        </div>

                        <select wire:model.live="positionFilter"
                            class="px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#1E7A4A]/30 focus:border-[#1E7A4A] transition bg-white w-full sm:w-auto min-w-40 appearance-none">
                            <option value="">All Positions</option>
                            @foreach($this->employees->pluck('position')->unique() as $position)
                                <option value="{{ $position }}">{{ $position }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- THE MAIN TABLE -->
                    @if($this->employees->isEmpty())
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <p class="text-gray-500 text-sm">No employees found matching your search.</p>
                            <p class="text-gray-400 text-sm mt-1">Try adjusting your search or filter.</p>
                        </div>
                    @else
                        <div class="overflow-x-auto -mx-3 sm:mx-0">
                            <table class="w-full min-w-180 sm:min-w-full">
                                <thead class="bg-gray-50 border-b border-gray-200">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider w-[30%]">Employee</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider w-[25%]">Schedule (Shop Hours)</th>
                                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider w-[25%]">Employee Shift</th>
                                        <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider w-[20%]">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($this->employees as $employee)
                                        @php
                                            $isExpanded = $this->expandedEmployeeId === $employee->id;
                                        @endphp

                                        <!-- Parent Row -->
                                        <tr wire:key="emp-{{ $employee->id }}" class="hover:bg-gray-50 transition cursor-pointer bg-white" 
                                            wire:click="toggleExpand({{ $employee->id }})">
                                            <td class="px-4 py-3 w-[30%]">
                                                <div class="flex items-center gap-3">
                                                    @if($employee->user->avatar)
                                                        <img src="{{ Storage::url($employee->user->avatar) }}" class="w-10 h-10 rounded-full object-cover border-2 border-gray-200">
                                                    @else
                                                        <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center border-2 border-gray-200">
                                                            <span class="text-sm font-bold text-emerald-700">
                                                                {{ strtoupper(substr($employee->user->name ?? 'U', 0, 1)) }}
                                                            </span>
                                                        </div>
                                                    @endif
                                                    <div class="min-w-0">
                                                        <p class="text-sm font-semibold text-gray-900 truncate max-w-28 sm:max-w-40">{{ $employee->user->name ?? 'Unknown' }}</p>
                                                        <p class="text-xs text-gray-500 truncate max-w-28 sm:max-w-none">{{ $employee->position }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-3 w-[25%] text-sm text-gray-500"></td>
                                            <td class="px-4 py-3 w-[25%] text-sm text-gray-500"></td>
                                            <td class="px-4 py-3 text-right w-[20%]">
                                                <button wire:click="toggleExpand({{ $employee->id }})"
                                                        class="inline-flex items-center gap-2 text-sm font-medium text-[#1E7A4A] hover:text-[#16633c] transition">
                                                    <span>View Details</span>
                                                    <span class="inline-block transition-transform duration-200 {{ $isExpanded ? 'rotate-180' : '' }}">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                                        </svg>
                                                    </span>
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Child Row -->
                                        <tr wire:key="schedule-{{ $employee->id }}" class="{{ $isExpanded ? '' : 'hidden' }} bg-gray-50/30">
                                            <td colspan="4" class="p-0 border-t border-gray-200">
                                                <div class="bg-white shadow-inner overflow-hidden">
                                                    @php
                                                        $weekSchedule = $this->getEmployeeWeekSchedule($employee->id);
                                                    @endphp
                                                    <table class="w-full text-sm text-left text-gray-600">
                                                        <tbody class="divide-y divide-gray-100/60">
                                                            @foreach($weekSchedule as $day => $data)
                                                                <tr wire:key="day-{{ $employee->id }}-{{ $day }}" class="hover:bg-gray-50/50 transition">
                                                                    <td class="px-4 py-3 font-medium text-gray-700 w-[30%] pl-8">
                                                                        {{ $data['label'] }}
                                                                    </td>
                                                                    <td class="px-4 py-3 w-[25%]">
                                                                        @if($data['shop_open'])
                                                                            <span class="inline-flex items-center gap-1.5 text-emerald-700 text-xs">
                                                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                                                {{ $data['shop_hours'] }}
                                                                            </span>
                                                                        @else
                                                                            <span class="inline-flex items-center gap-1.5 text-red-500 text-xs">
                                                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                                                                Closed
                                                                            </span>
                                                                        @endif
                                                                    </td>
                                                                    <td class="px-4 py-3 w-[25%]">
                                                                        @if($data['employee_shift'])
                                                                            <span class="inline-flex items-center gap-1.5 font-medium text-gray-800 text-xs">
                                                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                                                {{ \Carbon\Carbon::parse($data['employee_shift']->start_time)->format('g:i A') }} 
                                                                                - 
                                                                                {{ \Carbon\Carbon::parse($data['employee_shift']->end_time)->format('g:i A') }}
                                                                            </span>
                                                                        @else
                                                                            <span class="text-gray-400 italic text-xs">No shift</span>
                                                                        @endif
                                                                    </td>
                                                                    <td class="px-4 py-3 text-right w-[20%] pr-4">
                                                                        @if($this->hasShopHours)
                                                                            @if($data['employee_shift'])
                                                                                <button wire:click="removeShift({{ $employee->id }}, '{{ $day }}')"
                                                                                        wire:confirm="Are you sure?"
                                                                                        class="text-red-600 hover:text-red-800 text-xs font-medium hover:underline">
                                                                                    Remove
                                                                                </button>
                                                                            @elseif($data['shop_open'])
                                                                                <button wire:click="openAddShiftModal({{ $employee->id }}, '{{ $day }}')"
                                                                                        class="text-[#1E7A4A] hover:text-[#16633c] text-xs font-medium hover:underline">
                                                                                    + Add
                                                                                </button>
                                                                            @endif
                                                                        @else
                                                                            <span class="text-xs text-gray-400">Closed</span>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4 border-t border-gray-100 pt-4">
                            {{-- Placeholder for pagination if you ever add it to this page --}}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@include('layouts.partials.shift-modal')
</div>