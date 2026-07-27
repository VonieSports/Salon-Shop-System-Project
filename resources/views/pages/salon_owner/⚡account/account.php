<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use App\Models\Employee;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\WithPagination;


new #[Layout('layouts.salon_owner')] class extends Component
{
    use WithPagination;

    #[Url(as: 'q')]
    public string $search = '';

    public string $roleFilter = 'all';
    public ?int $tenantId = null;

    public $totalEmployees = 0;
    public $activeEmployees = 0;
    public $onlineEmployees = 0;

    public $showProfileModal = false;
    public $selectedEmployee = null;

    public function mount(): void
    {
        $tenant = Auth::user()->tenant;
        abort_unless($tenant?->business_setup_completed, 403, 'Please complete your business setup first.');
        
        $this->tenantId = $tenant->id;
        
        $this->totalEmployees = Employee::where('tenant_id', $this->tenantId)->count();
        $this->activeEmployees = Employee::where('tenant_id', $this->tenantId)->where('is_active', true)->count();
        $this->onlineEmployees = Employee::where('tenant_id', $this->tenantId)
            ->where('is_active', true)
            ->whereHas('user', function($q) {
                $q->whereNotNull('last_login_at')
                  ->whereNull('last_logout_at');
            })
            ->count();
    }

    #[Computed]
    public function employees()
    {
        $query = Employee::with(['user', 'user.roles', 'user.permissions'])
            ->where('tenant_id', $this->tenantId);

        if ($this->search) {
            $query->whereHas('user', function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhere('phone', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->roleFilter !== 'all') {
            $query->whereHas('user.roles', function ($q) {
                $q->where('name', $this->roleFilter);
            });
        }

        return $query->latest('hired_at')->paginate(12);
    }

    public function openProfileModal($employeeId)
    {
        $this->selectedEmployee = Employee::with(['user', 'user.roles', 'user.permissions'])
            ->where('tenant_id', $this->tenantId)
            ->where('id', $employeeId)
            ->first();
        
        $this->showProfileModal = true;
    }

    public function closeProfileModal()
    {
        $this->showProfileModal = false;
        $this->selectedEmployee = null;
    }
};