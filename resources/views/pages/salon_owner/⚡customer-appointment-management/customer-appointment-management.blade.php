
<div>
  <div class="min-h-screen bg-gray-50 p-4 space-y-5">
    @if (session()->has('message'))
        <div class="bg-emerald-50 text-emerald-700 px-4 py-3 rounded-lg text-sm font-medium">{{ session('message') }}</div>
    @endif
    @if (session()->has('error'))
        <div class="bg-red-50 text-red-700 px-4 py-3 rounded-lg text-sm font-medium">{{ session('error') }}</div>
    @endif

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
            <h1 class="text-xl font-bold text-gray-900">Service Queue</h1>
            <p class="text-sm text-gray-500 mt-0.5">Manage today's bookings by employee</p>
        </div>
        <input type="date" wire:model.live="date" class="px-3 py-2 border border-gray-200 rounded-lg text-sm">
    </div>

    <div class="flex gap-1.5 overflow-x-auto border-b border-gray-200">
        <button wire:click="$set('statusFilter', 'all')" class="px-3.5 py-2 text-xs font-medium border-b-2 -mb-px {{ $statusFilter === 'all' ? 'border-[#1E7A4A] text-[#1E7A4A]' : 'border-transparent text-gray-500' }}">All</button>
        @foreach (\App\Enums\AppointmentStatus::cases() as $status)
            <button wire:click="$set('statusFilter', '{{ $status->value }}')" class="px-3.5 py-2 text-xs font-medium border-b-2 -mb-px {{ $statusFilter === $status->value ? 'border-[#1E7A4A] text-[#1E7A4A]' : 'border-transparent text-gray-500' }}">{{ $status->label() }}</button>
        @endforeach
    </div>

    @if ($this->appointments->isEmpty())
        <div class="bg-white rounded-lg border border-gray-200 p-16 text-center text-gray-400 text-sm">No bookings for this date.</div>
    @else
        <div class="space-y-3">
            @foreach ($this->appointments->groupBy('employee_id') as $employeeId => $group)
                @php $employee = $group->first()->employee; @endphp
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                    <div class="px-4 py-2.5 bg-gray-50 border-b border-gray-100 flex items-center gap-2.5">
                        <div class="w-7 h-7 rounded-full bg-emerald-100 flex items-center justify-center shrink-0 overflow-hidden">
                            @if ($employee?->user?->avatar)
                                <img src="{{ Storage::url($employee->user->avatar) }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-xs font-bold text-emerald-700">{{ strtoupper(substr($employee?->user?->name ?? 'S', 0, 1)) }}</span>
                            @endif
                        </div>
                        <p class="text-sm font-semibold text-gray-800">{{ $employee?->user?->name }}</p>
                    </div>

                    <div class="divide-y divide-gray-50">
                        @foreach ($group as $appt)
                            <div class="flex items-center gap-4 px-4 py-3">
                                <span class="text-xs font-bold text-gray-400 w-6">#{{ $appt->queue_number }}</span>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm text-gray-800">{{ $appt->service?->name }}</p>
                                    <p class="text-xs text-gray-400">{{ $this->maskName($appt->customer?->name) }} · {{ $appt->order?->order_number }}</p>
                                </div>
                                <span class="px-2 py-0.5 text-xs font-medium rounded {{ $appt->status->badgeClass() }}">{{ $appt->status->label() }}</span>
                                <div class="flex items-center gap-1.5">
                                    @if ($appt->status->canStart())
                                        <button wire:click="start({{ $appt->id }})" class="px-2.5 py-1.5 bg-blue-50 text-blue-700 rounded text-xs font-semibold hover:bg-blue-100">Start</button>
                                    @endif
                                    @if ($appt->status->canComplete())
                                        <button wire:click="complete({{ $appt->id }})" class="px-2.5 py-1.5 bg-emerald-50 text-emerald-700 rounded text-xs font-semibold hover:bg-emerald-100">Complete</button>
                                    @endif
                                    @if ($appt->status->canCancel())
                                        <button wire:click="cancel({{ $appt->id }})" wire:confirm="Cancel this appointment?" class="px-2.5 py-1.5 bg-red-50 text-red-600 rounded text-xs font-semibold hover:bg-red-100">Cancel</button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
</div>