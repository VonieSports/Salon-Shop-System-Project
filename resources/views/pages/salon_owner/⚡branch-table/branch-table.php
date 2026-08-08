<?php

use App\Models\Tenant;
use App\Traits\RequiresTenant;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

new #[Layout('layouts.salon_owner')] class extends Component
{
    use WithPagination, RequiresTenant;

    #[Url(as: 'q')]
    public string $search = '';

    public string $statusFilter = 'all';

    public bool $showUnauthorizedModal = false;

    protected ?Tenant $hqTenant = null;

    protected function resolveHqTenant(): ?Tenant
    {
        if ($this->hqTenant !== null) {
            return $this->hqTenant;
        }

        $tenant = $this->getTenant();

        if ($tenant && $tenant->isMainTenant()) {
            $this->hqTenant = $tenant;
        }

        return $this->hqTenant;
    }

    protected function canViewBranches(): bool
    {
        return $this->resolveHqTenant() !== null;
    }

    public function mount(): void
    {
        if (!$this->canViewBranches()) {
            $this->showUnauthorizedModal = true;
        }
    }

    public function goToDashboard(): void
    {
        $this->redirectRoute('owner.dashboard');
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatusFilter(): void
    {
        $this->resetPage();
    }

    #[Computed]
    public function branches()
    {
        $hqTenant = $this->resolveHqTenant();

        if (!$hqTenant) {
            return Tenant::query()->whereRaw('1 = 0')->paginate(10);
        }

        return Tenant::query()
            ->where('parent_tenant_id', $hqTenant->id)
            ->with(['owner:id,name,email,phone,avatar,is_active,last_login_at,last_activity_at,last_logout_at'])
            ->withCount('employees')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', "%{$this->search}%")
                      ->orWhere('email', 'like', "%{$this->search}%")
                      ->orWhereHas('owner', function ($qOwner) {
                          $qOwner->where('name', 'like', "%{$this->search}%")
                                 ->orWhere('email', 'like', "%{$this->search}%");
                      });
                });
            })
            ->when($this->statusFilter !== 'all', function ($query) {
                match ($this->statusFilter) {
                    'pending' => $query->where('verification_status', 'pending'),
                    'approved' => $query->where('verification_status', 'approved'),
                    'rejected' => $query->where('verification_status', 'rejected'),
                    'active' => $query->where('is_active', true),
                    'inactive' => $query->where('is_active', false),
                    default => null,
                };
            })
            ->latest('created_at')
            ->paginate(10);
    }
};