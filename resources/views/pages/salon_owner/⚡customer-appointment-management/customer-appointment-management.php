<?php

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use App\Models\Tenant;
use App\Services\BookingService;
use App\Support\PrivacyMasker;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;

new #[Layout('layouts.salon_owner')] class extends Component
{
   public ?int $tenantId = null;

    // ==========================================================
    // FIX: Initialize typed properties with a default value
    // ==========================================================
    #[Url] 
    public string $date = ''; 

    #[Url] 
    public string $statusFilter = 'all';

    public function mount(): void
    {
        $user = Auth::user();
        $tenant = $user->tenant ?? Tenant::where('user_id', $user->id)->first();
        abort_unless($tenant, 403);
        $this->tenantId = $tenant->id;
        
        // If date is empty, set it to today
        if (empty($this->date)) {
            $this->date = now()->toDateString();
        }
    }

    #[Computed]
    public function appointments()
    {
        return Appointment::with(['employee.user:id,name,avatar', 'customer', 'service:id,name', 'order:id,order_number,payment_status'])
            ->where('tenant_id', $this->tenantId)
            ->whereDate('appointment_date', $this->date)
            ->when($this->statusFilter !== 'all', fn ($q) => $q->where('status', $this->statusFilter))
            ->orderBy('employee_id')
            ->orderBy('queue_number')
            ->get();
    }

    public function start(int $id, BookingService $bookingService): void
    {
        $appointment = Appointment::where('tenant_id', $this->tenantId)->findOrFail($id);
        try {
            $bookingService->start($appointment);
            unset($this->appointments);
            session()->flash('message', 'Service started.');
        } catch (\RuntimeException $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function complete(int $id, BookingService $bookingService): void
    {
        $appointment = Appointment::where('tenant_id', $this->tenantId)->findOrFail($id);
        try {
            $bookingService->complete($appointment);
            unset($this->appointments);
            session()->flash('message', 'Service completed.');
        } catch (\RuntimeException $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function cancel(int $id, BookingService $bookingService): void
    {
        $appointment = Appointment::where('tenant_id', $this->tenantId)->findOrFail($id);
        try {
            $bookingService->cancel($appointment);
            unset($this->appointments);
            session()->flash('message', 'Appointment canceled.');
        } catch (\RuntimeException $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function maskName(?string $name): string { return PrivacyMasker::name($name); }
};