<?php

use App\Models\Post;
use App\Services\AvailabilityService;
use App\Services\ProfileCompletenessService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.customer')] class extends Component
{
    public Post $service;
    public string $selectedDate;
    public ?int $selectedEmployeeId = null;
    public int $quantity = 1;

    // Add a timestamp to track when dates were last refreshed
    public string $lastRefreshed;

    public function mount(Post $service): void
    {
        abort_unless(
            $service->status === 'published' && 
            is_null($service->archived_at) && 
            $service->type === 'service', 
            404
        );

        // Load relationships
        $this->service = $service->load([
            'tenant:id,name,address,phone,business_hours,logo',
            'serviceCategory:id,name',
            'employees' => function ($query) {
                $query->where('employees.is_active', true)
                      ->with(['user:id,name,avatar']);
            },
        ]);

        // Always set to today's date
        $this->selectedDate = now()->toDateString();
        $this->lastRefreshed = now()->toDateTimeString();
    }

    #[Computed]
    public function eligibleEmployees()
    {
        return app(AvailabilityService::class)->eligibleEmployees($this->service);
    }

    #[Computed]
    public function hasAssignedStaff(): bool
    {
        return $this->eligibleEmployees->isNotEmpty();
    }

    #[Computed]
    public function shopHoursForSelectedDate(): array
    {
        $tenant = $this->service->tenant;
        if (!$tenant) {
            return ['open' => false, 'label' => 'Shop not available'];
        }

        $hours = $tenant->getBusinessHours() ?? [];
        $day = strtolower(Carbon::parse($this->selectedDate)->format('l'));

        if (empty($hours[$day]) || ($hours[$day]['closed'] ?? false)) {
            return ['open' => false, 'label' => 'Closed on this date'];
        }

        $open = $hours[$day]['open'] ?? null;
        $close = $hours[$day]['close'] ?? null;

        if (!$open || !$close) {
            return ['open' => true, 'label' => 'Hours not set'];
        }

        try {
            return [
                'open' => true,
                'label' => Carbon::createFromFormat('H:i', $open)->format('g:i A')
                    . ' – '
                    . Carbon::createFromFormat('H:i', $close)->format('g:i A'),
            ];
        } catch (\Exception $e) {
            return ['open' => true, 'label' => 'Hours not set'];
        }
    }

    #[Computed]
    public function employeeAvailability()
    {
        return app(AvailabilityService::class)->employeeAvailability(
            $this->service,
            Carbon::parse($this->selectedDate),
            $this->eligibleEmployees
        );
    }

    #[Computed]
    public function ratingCount(): int
    {
        if (!class_exists(\App\Models\Rating::class)) {
            return 0;
        }
        
        return \App\Models\Rating::where('service_id', $this->service->id)->count();
    }

    #[Computed]
    public function canBook(): bool
    {
        if (!$this->selectedEmployeeId) {
            return false;
        }
        
        $hours = $this->shopHoursForSelectedDate;
        return $hours['open'] ?? false;
    }

    public function toggleEmployee(int $employeeId): void
    {
        $availability = $this->employeeAvailability;
        
        $isValid = $availability->contains(function ($item) use ($employeeId) {
            return $item['employee']->id === $employeeId && $item['on_duty'];
        });

        if (!$isValid) {
            $this->addError('employee', 'Selected staff is not available.');
            return;
        }

        $this->selectedEmployeeId = ($this->selectedEmployeeId === $employeeId) 
            ? null 
            : $employeeId;
        
        $this->resetErrorBag('employee');
    }

    public function selectDate(string $date): void
    {
        if (Carbon::parse($date)->isPast() && !Carbon::parse($date)->isToday()) {
            $this->addError('date', 'Cannot select past dates.');
            return;
        }

        $this->selectedDate = $date;
        $this->selectedEmployeeId = null;
        $this->resetErrorBag(['employee', 'date']);
    }

    public function refreshDates(): void
    {
        $this->selectedDate = now()->toDateString();
        $this->selectedEmployeeId = null;
        $this->lastRefreshed = now()->toDateTimeString();
        $this->resetErrorBag(['employee', 'date']);
        
        // Force recompute of computed properties
        unset($this->employeeAvailability);
        unset($this->shopHoursForSelectedDate);
    }

    public function bookService(ProfileCompletenessService $profileCheck)
    {
        if (!$this->selectedEmployeeId) {
            $this->addError('employee', 'Please select a staff member.');
            return;
        }

        $availability = $this->employeeAvailability;
        $selected = $availability->firstWhere('employee.id', $this->selectedEmployeeId);
        
        if (!$selected || !$selected['on_duty']) {
            $this->addError('employee', 'Selected staff is no longer available.');
            $this->selectedEmployeeId = null;
            return;
        }

        $user = Auth::user();

        if (!$profileCheck->isComplete($user)) {
            session()->flash('warning', 'Please complete your profile before booking.');
            return redirect()->route('customer.update_profile');
        }

        return redirect()->route('customer.service_checkout', [
            'post' => $this->service->id,
            'employee' => $this->selectedEmployeeId,
            'date' => $this->selectedDate,
        ]);
    }

    /**
     * Get date availability - ALWAYS uses current date
     * Using a method instead of computed property to avoid caching
     */
    public function getDateAvailability(): array
    {
        $dates = [];
        $today = now(); // Always get fresh date
        $tenant = $this->service->tenant;
        
        if (!$tenant) {
            return [];
        }

        $hours = $tenant->getBusinessHours() ?? [];
        
        for ($i = 0; $i < 14; $i++) {
            $date = $today->copy()->addDays($i);
            $day = strtolower($date->format('l'));
            
            $isAvailable = !empty($hours[$day]) && !($hours[$day]['closed'] ?? false);
            
            $dates[] = [
                'date' => $date->toDateString(),
                'display' => $date->format('D, M j'),
                'available' => $isAvailable,
                'is_today' => $i === 0,
            ];
        }
        
        return $dates;
    }

    /**
     * Get current date for display
     */
    public function getCurrentDate(): string
    {
        return now()->toDateString();
    }
};