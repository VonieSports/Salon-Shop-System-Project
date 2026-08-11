<div>
    <div class="min-h-screen bg-gray-50 py-6">
        <div class="mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm border border-gray-200 overflow-hidden rounded-lg">

                <!-- Header -->
                <div class="px-4 sm:px-6 py-5 border-b border-gray-200 bg-[#1E7A4A]">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div>
                            <h1 class="text-2xl font-bold text-white">Employee Schedule &amp; Services</h1>
                            <p class="text-[#cfe8dc] text-base mt-0.5">Manage shifts and assign services for each staff member</p>
                        </div>
                        <a href="{{ route('owner.employee') }}"
                           class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-[#1E7A4A] rounded-lg hover:bg-gray-50 transition text-base font-medium shadow-sm whitespace-nowrap">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Back to Employees
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

                    <!-- Shop Closed Warning -->
                    @if(!$this->hasShopHours)
                        <div class="mb-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                                <div>
                                    <p class="text-base font-medium text-yellow-800">Shop is currently closed.</p>
                                    <p class="text-base text-yellow-700 mt-0.5">Employees cannot be scheduled until you add operating hours in <a href="{{ route('owner.business_setup') }}" class="underline font-medium hover:text-yellow-900">Business Setup</a>.</p>
                                </div>
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
                                placeholder="Search by name..."
                                class="w-full pl-10 pr-4 py-3 text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1E7A4A]/30 focus:border-[#1E7A4A] transition bg-white">
                        </div>

                        <select wire:model.live="positionFilter"
                            class="px-4 py-3 text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#1E7A4A]/30 focus:border-[#1E7A4A] transition bg-white w-full sm:w-auto min-w-44 appearance-none">
                            <option value="">All Positions</option>
                            @foreach($this->employees->pluck('position')->unique() as $position)
                                <option value="{{ $position }}">{{ $position }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Empty State -->
                    @if($this->employees->isEmpty())
                        <div class="text-center py-12 bg-gray-50 rounded-lg border border-gray-200">
                            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <p class="text-gray-600 text-base font-medium">No employees found</p>
                            <p class="text-gray-400 text-base mt-1">Try adjusting your search or filter criteria.</p>
                        </div>
                    @else
                        <!-- Table -->
                        <div class="overflow-x-auto -mx-4 sm:mx-0 border border-gray-200 rounded-lg">
                            <table class="w-full min-w-[800px] sm:min-w-full">
                                <thead class="bg-gray-50 border-b border-gray-200">
                                    <tr>
                                        <th class="px-4 py-3.5 text-left text-sm font-semibold text-gray-500 uppercase tracking-wider">Employee</th>
                                        <th class="px-4 py-3.5 text-left text-sm font-semibold text-gray-500 uppercase tracking-wider">Assigned Services</th>
                                        <th class="px-4 py-3.5 text-right text-sm font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    @foreach($this->employees as $employee)
                                        @php $isExpanded = $this->expandedEmployeeId === $employee->id; @endphp

                                        <!-- Employee Row -->
                                        <tr wire:key="emp-{{ $employee->id }}" class="hover:bg-gray-50 transition">
                                            <td class="px-4 py-3.5">
                                                <div class="flex items-center gap-3">
                                                    @if($employee->user->avatar)
                                                        <img src="{{ Storage::url($employee->user->avatar) }}" class="w-11 h-11 rounded-full object-cover border border-gray-200">
                                                    @else
                                                        <div class="w-11 h-11 rounded-full bg-[#1E7A4A]/10 flex items-center justify-center border border-gray-200">
                                                            <span class="text-base font-bold text-[#1E7A4A]">{{ strtoupper(substr($employee->user->name ?? 'U', 0, 1)) }}</span>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <p class="text-base font-medium text-gray-700">{{ $employee->user->name ?? 'Unknown' }}</p>
                                                        <p class="text-sm text-gray-500">{{ $employee->position }}</p>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="px-4 py-3.5">
                                                @if ($employee->services->isEmpty())
                                                    <span class="text-base text-gray-400">No services assigned</span>
                                                @else
                                                    <div class="flex flex-wrap gap-1.5">
                                                        @foreach ($employee->services as $service)
                                                            <span class="text-sm px-3 py-1 rounded bg-gray-100 text-gray-700">{{ $service->name }}</span>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </td>

                                            <td class="px-4 py-3.5 text-right">
                                                <div class="flex items-center justify-end gap-3 flex-wrap">
                                                    <button wire:click="openServiceModal({{ $employee->id }})"
                                                            class="text-base font-medium text-[#1E7A4A] hover:text-[#145537] transition">
                                                        Assign Services
                                                    </button>
                                                    <button wire:click="toggleExpand({{ $employee->id }})"
                                                            class="inline-flex items-center gap-1.5 text-base font-medium text-gray-600 hover:text-gray-700 transition">
                                                        <span>{{ $isExpanded ? 'Hide' : 'View' }} Schedule</span>
                                                        <svg class="w-4 h-4 transition-transform duration-200 {{ $isExpanded ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Schedule Row -->
                                        <tr wire:key="schedule-{{ $employee->id }}" class="{{ $isExpanded ? '' : 'hidden' }}">
                                            <td colspan="3" class="p-0 bg-gray-50">
                                                <div class="border-t border-gray-200">
                                                    @php $weekSchedule = $this->getEmployeeWeekSchedule($employee->id); @endphp
                                                    <div class="overflow-x-auto">
                                                        <table class="w-full text-base">
                                                            <thead class="bg-gray-100/50">
                                                                <tr>
                                                                    <th class="px-4 py-2.5 text-left text-sm font-semibold text-gray-500 uppercase tracking-wider pl-8">Day</th>
                                                                    <th class="px-4 py-2.5 text-left text-sm font-semibold text-gray-500 uppercase tracking-wider">Shop Hours</th>
                                                                    <th class="px-4 py-2.5 text-left text-sm font-semibold text-gray-500 uppercase tracking-wider">Shift</th>
                                                                    <th class="px-4 py-2.5 text-right text-sm font-semibold text-gray-500 uppercase tracking-wider">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="divide-y divide-gray-200">
                                                                @foreach($weekSchedule as $day => $data)
                                                                    <tr wire:key="day-{{ $employee->id }}-{{ $day }}" class="hover:bg-gray-100/50 transition">
                                                                        <td class="px-4 py-3.5 font-medium text-gray-700 pl-8">{{ $data['label'] }}</td>
                                                                        <td class="px-4 py-3.5">
                                                                            @if($data['shop_open'])
                                                                                <span class="text-base text-gray-700">{{ $data['shop_hours'] }}</span>
                                                                            @else
                                                                                <span class="text-base text-gray-400">Closed</span>
                                                                            @endif
                                                                        </td>
                                                                        <td class="px-4 py-3.5">
                                                                            @if($data['employee_shift'])
                                                                                <span class="text-base font-medium text-gray-800">
                                                                                    {{ \Carbon\Carbon::parse($data['employee_shift']->start_time)->format('g:i A') }} –
                                                                                    {{ \Carbon\Carbon::parse($data['employee_shift']->end_time)->format('g:i A') }}
                                                                                </span>
                                                                            @else
                                                                                <span class="text-base text-gray-400">No shift</span>
                                                                            @endif
                                                                        </td>
                                                                        <td class="px-4 py-3.5 text-right">
                                                                            @if($this->hasShopHours)
                                                                                @if($data['employee_shift'])
                                                                                    <button wire:click="removeShift({{ $employee->id }}, '{{ $day }}')" wire:confirm="Are you sure?"
                                                                                            class="text-base text-red-600 hover:text-red-800 font-medium transition">Remove</button>
                                                                                @elseif($data['shop_open'])
                                                                                    <button wire:click="openAddShiftModal({{ $employee->id }}, '{{ $day }}')"
                                                                                            class="text-base text-[#1E7A4A] hover:text-[#145537] font-medium transition">+ Add Shift</button>
                                                                                @endif
                                                                            @else
                                                                                <span class="text-base text-gray-400">—</span>
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @include('layouts.partials.shift-modal')

 <!-- Service Assignment Modal with Images -->
@if ($showServiceModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center px-4">
        <div class="absolute inset-0 bg-black/40" wire:click="closeServiceModal"></div>
        <div class="relative bg-white rounded-xl shadow-2xl max-w-2xl w-full max-h-[85vh] overflow-y-auto">
            
            <!-- Header -->
            <div class="px-6 sm:px-8 py-5 border-b border-gray-200 sticky top-0 bg-white z-10 rounded-t-xl">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-700">Assign Services</h3>
                        <p class="text-base text-gray-500 mt-1">Select which services this employee can perform.</p>
                    </div>
                    <button wire:click="closeServiceModal" 
                            class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Body -->
            <div class="px-6 sm:px-8 py-6 space-y-3">
                @forelse ($this->allServices as $service)
                    <label class="flex items-center gap-4 p-4 rounded-xl border border-gray-200 hover:bg-gray-50 cursor-pointer transition hover:border-[#1E7A4A]/30">
                        <input type="checkbox" wire:model="selectedServiceIds" value="{{ $service->id }}"
                               class="w-5 h-5 rounded border-gray-300 text-[#1E7A4A] focus:ring-[#1E7A4A]/30 focus:ring-2">
                        
                        <!-- Service Image -->
                        <div class="flex-shrink-0 w-14 h-14 rounded-lg overflow-hidden border border-gray-200 bg-gray-50">
                            @if($service->image)
                                <img src="{{ Storage::url($service->image) }}" 
                                     class="w-full h-full object-cover"
                                     alt="{{ $service->name }}">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                    <svg class="w-7 h-7 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Service Name -->
                        <div class="flex-1">
                            <span class="text-lg font-medium text-gray-700">{{ $service->name }}</span>
                            @if(isset($service->description))
                                <p class="text-sm text-gray-500 mt-0.5 line-clamp-1">{{ Str::limit($service->description, 60) }}</p>
                            @endif
                        </div>
                        
                        <!-- Price -->
                        @if(isset($service->price))
                            <span class="text-lg font-semibold text-gray-700 whitespace-nowrap">₱{{ number_format($service->price, 2) }}</span>
                        @endif
                    </label>
                @empty
                    <div class="text-center py-12">
                        <svg class="w-20 h-20 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0018 4.5h-3.75M9 19.5A2.25 2.25 0 016.75 17.25V6.75A2.25 2.25 0 019 4.5h3.75"/>
                        </svg>
                        <p class="text-lg text-gray-500">No active services available.</p>
                        <p class="text-base text-gray-400 mt-2">Create services in the service management section.</p>
                    </div>
                @endforelse
            </div>

            <!-- Footer -->
            <div class="px-6 sm:px-8 py-5 border-t border-gray-200 bg-gray-50/50 rounded-b-xl flex flex-col sm:flex-row gap-3">
                <div class="flex-1">
                    <p class="text-sm text-gray-500">
                        <span class="font-medium text-gray-700">{{ count($selectedServiceIds) }}</span> service(s) selected
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row gap-3">
                    <button wire:click="closeServiceModal" 
                            class="w-full sm:w-auto px-6 py-3 border border-gray-300 rounded-lg text-base font-medium text-gray-700 hover:bg-gray-50 transition">
                        Cancel
                    </button>
                    <button wire:click="saveServiceAssignment" 
                            class="w-full sm:w-auto px-8 py-3 bg-[#1E7A4A] text-white rounded-lg text-base font-medium hover:bg-[#145537] transition shadow-sm hover:shadow-md flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        Save Changes
                    </button>
                </div>
            </div>
        </div>
    </div>
@endif
</div>