<?php

use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

new #[Layout('layouts.salon_owner')] class extends Component
{
    use WithPagination;

    #[Url(as: 'q')]
    public string $search = '';

    public string $statusFilter = 'all';
    public ?int $tenantId = null;

    public $showPermissionModal = false;
    public $selectedEmployeeId = null;
    public $selectedPermissions = [];
    public $allPermissions = [];

    public function mount(): void
    {
        $tenant = Auth::user()->tenant;
        abort_unless($tenant?->business_setup_completed, 403, 'Please complete your business setup first.');

        $this->tenantId = $tenant->id;
        $this->allPermissions = Permission::all();
    }

    #[Computed]
    public function employees()
    {
        return Employee::query()
            ->with(['user'])
            ->where('tenant_id', $this->tenantId)
            ->when($this->search, function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('phone', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->statusFilter !== 'all', function ($query) {
                $this->applyStatusFilter($query);
            })
            ->latest('hired_at')
            ->paginate(12);
    }

    protected function applyStatusFilter($query)
    {
        switch ($this->statusFilter) {
            case 'online':
                $query->whereHas('user', function ($q) {
                    $q->whereNotNull('last_login_at')
                        ->where(function ($sub) {
                            $sub->whereNull('last_logout_at')
                                ->orWhere('last_activity_at', '>=', now()->subMinutes(5));
                        });
                });
                break;

            case 'offline':
                $query->whereHas('user', function ($q) {
                    $q->whereNotNull('last_logout_at')
                        ->orWhere(function ($sub) {
                            $sub->whereNull('last_activity_at')
                                ->orWhere('last_activity_at', '<', now()->subMinutes(5));
                        });
                });
                break;

            case 'never_logged_in':
                $query->whereHas('user', function ($q) {
                    $q->whereNull('last_login_at');
                });
                break;

            case 'inactive':
                $query->where('is_active', false);
                break;
        }
    }

    public function getOnlineCount(): int
    {
        return Employee::where('tenant_id', $this->tenantId)
            ->where('is_active', true)
            ->whereHas('user', function ($q) {
                $q->whereNotNull('last_login_at')
                    ->where(function ($sub) {
                        $sub->whereNull('last_logout_at')
                            ->orWhere('last_activity_at', '>=', now()->subMinutes(5));
                    });
            })
            ->count();
    }

    public function toggleActive(int $id): void
    {
        $employee = Employee::where('tenant_id', $this->tenantId)
            ->where('id', $id)
            ->firstOrFail();

        if ($employee->user && $employee->user->hasRole('owner')) {
            session()->flash('error', 'Cannot deactivate a shop owner!');
            return;
        }

        $employee->update([
            'is_active' => !$employee->is_active
        ]);

        if ($employee->user) {
            $employee->user->update([
                'is_active' => $employee->is_active
            ]);
        }

        session()->flash('message', 'Employee status updated successfully.');
    }

    public function deleteEmployee(int $id): void
    {
        $employee = Employee::with('user')
            ->where('tenant_id', $this->tenantId)
            ->where('id', $id)
            ->firstOrFail();

        if ($employee->user && $employee->user->hasRole('owner')) {
            session()->flash('error', 'Cannot delete a shop owner!');
            return;
        }

        try {
            DB::transaction(function () use ($employee) {
                if ($employee->user?->avatar) {
                    Storage::disk('public')->delete($employee->user->avatar);
                }

                $user = $employee->user;
                $employee->delete();

                if ($user) {
                    $user->permissions()->detach();
                    $user->delete();
                }
            });

            session()->flash('message', 'Employee deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting employee', [
                'error' => $e->getMessage(),
                'employee_id' => $id,
                'tenant_id' => $this->tenantId
            ]);
            session()->flash('error', 'Failed to delete employee.');
        }
    }

    public function openPermissionModal(int $employeeId)
    {
        $this->selectedEmployeeId = $employeeId;
        $employee = Employee::with('user')->find($employeeId);

        if ($employee && $employee->user) {
            $this->selectedPermissions = $employee->user->permissions()->pluck('name')->toArray();
        }

        $this->showPermissionModal = true;
    }

    public function savePermissions()
    {
        if (!$this->selectedEmployeeId) {
            return;
        }

        $employee = Employee::with('user')->find($this->selectedEmployeeId);

        if (!$employee || !$employee->user) {
            session()->flash('error', 'Employee not found.');
            $this->showPermissionModal = false;
            return;
        }

        if ($employee->user->hasRole('owner')) {
            session()->flash('error', 'Cannot modify owner permissions.');
            $this->showPermissionModal = false;
            return;
        }

        try {
            $employee->user->syncPermissions($this->selectedPermissions);
            session()->flash('message', 'Permissions updated successfully!');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to save permissions.');
        }

        $this->showPermissionModal = false;
        $this->selectedEmployeeId = null;
        $this->selectedPermissions = [];
    }

    public function closePermissionModal()
    {
        $this->showPermissionModal = false;
        $this->selectedEmployeeId = null;
        $this->selectedPermissions = [];
    }
};
