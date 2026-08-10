<?php

use App\Models\Employee;
use App\Models\Schedule;
use App\Models\Tenant;
use App\Services\ScheduleService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

new #[Layout('layouts.salon_owner')] class extends Component
{
    use WithPagination;

    public string $search = '';
    public string $positionFilter = '';
    public bool $hasShopHours = false;
    public ?int $expandedEmployeeId = null;

    // Modal Controls
    public bool $showAddShiftModal = false;
    public ?int $modalEmployeeId = null;
    public string $shiftDay = '';
    public string $shiftStart = '';
    public string $shiftEnd = '';

    protected $listeners = ['refreshSchedule' => '$refresh'];

    public function mount(): void
    {
        $tenant = Auth::user()->tenant;

        if (!$tenant || !$tenant->business_setup_completed) {
            abort(403, 'Please complete your business setup first.');
        }

        $this->hasShopHours = $tenant->hasBusinessHours();
    }

    public function toggleExpand(int $employeeId): void
    {
        if ($this->expandedEmployeeId === $employeeId) {
            $this->expandedEmployeeId = null;
        } else {
            $this->expandedEmployeeId = $employeeId;
        }
    }

    public function getEmployeesProperty()
    {
        return Employee::with(['user', 'schedules'])
            ->where('tenant_id', Auth::user()->tenant->id)
            ->where('is_active', true)
            ->when($this->search, function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->positionFilter, function ($query) {
                $query->where('position', $this->positionFilter);
            })
            ->orderBy('position')
            ->get()
            ->filter(fn($emp) => $emp->user && !$emp->user->hasRole('owner'));
    }

    public function getEmployeeWeekSchedule(int $employeeId)
    {
        $employee = Employee::with('schedules')->find($employeeId);
        if (!$employee) return [];

        $tenant = Auth::user()->tenant;
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        $tenantHours = $tenant->getBusinessHours();
        $employeeSchedules = $employee->schedules->keyBy('day_of_week');

        $week = [];
        foreach ($days as $day) {
            $isShopOpen = !empty($tenantHours) && isset($tenantHours[$day]) && !($tenantHours[$day]['closed'] ?? false);
            $week[$day] = [
                'label' => ucfirst($day),
                'shop_open' => $isShopOpen,
                'shop_hours' => $isShopOpen ? ($tenantHours[$day]['open'] ?? '') . ' - ' . ($tenantHours[$day]['close'] ?? '') : 'Closed',
                'employee_shift' => $employeeSchedules->get($day),
            ];
        }
        return $week;
    }

    public function openAddShiftModal(int $employeeId, string $day): void
    {
        $this->modalEmployeeId = $employeeId;
        $this->shiftDay = $day;
        $this->shiftStart = '';
        $this->shiftEnd = '';
        $this->showAddShiftModal = true;
    }

    public function closeAddShiftModal(): void
    {
        $this->showAddShiftModal = false;
        $this->modalEmployeeId = null;
        $this->shiftDay = '';
        $this->shiftStart = '';
        $this->shiftEnd = '';
    }

    public function removeShift(int $employeeId, string $day): void
    {
        Schedule::where('employee_id', $employeeId)
            ->where('day_of_week', $day)
            ->delete();

        $this->dispatch('refreshSchedule');
        session()->flash('message', 'Shift removed successfully.');
    }

    public function saveShift(ScheduleService $scheduleService): void
    {
        if (!$this->modalEmployeeId || !$this->shiftDay) {
            return;
        }

        $this->validate([
            'shiftStart' => 'required|string',
            'shiftEnd' => 'required|string|after:shiftStart',
        ]);

        $tenant = Auth::user()->tenant;

        if (!$scheduleService->isShopOpen($tenant, $this->shiftDay, $this->shiftStart)) {
            $this->addError('shiftStart', 'Shop is closed at this time based on your Business Hours.');
            return;
        }
        if (!$scheduleService->isShopOpen($tenant, $this->shiftDay, $this->shiftEnd)) {
            $this->addError('shiftEnd', 'Shop is closed at this time based on your Business Hours.');
            return;
        }

        try {
            DB::transaction(function () use ($tenant) {
                Schedule::where('employee_id', $this->modalEmployeeId)
                    ->where('day_of_week', $this->shiftDay)
                    ->delete();

                Schedule::create([
                    'tenant_id' => $tenant->id,
                    'employee_id' => $this->modalEmployeeId,
                    'day_of_week' => $this->shiftDay,
                    'start_time' => $this->shiftStart,
                    'end_time' => $this->shiftEnd,
                ]);
            });

            $this->closeAddShiftModal();
            $this->dispatch('refreshSchedule');
            session()->flash('message', 'Shift assigned successfully.');

        } catch (\Exception $e) {
            Log::error('Error saving shift: ' . $e->getMessage());
            session()->flash('error', 'Failed to save shift.');
        }
    }
};