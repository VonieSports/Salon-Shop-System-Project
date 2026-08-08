<?php

use App\Models\Tenant;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

new #[Layout('layouts.admin')] class extends Component
{
    use WithPagination;

    #[Url(as: 'q')]
    public string $search = '';

    public string $statusFilter = 'all';
    public string $typeFilter = 'all';

    public function updatingSearch(): void { $this->resetPage(); }
    public function updatingStatusFilter(): void { $this->resetPage(); }
    public function updatingTypeFilter(): void { $this->resetPage(); }

    #[Computed]
    public function tenants()
    {
        return Tenant::query()
            ->with(['owner:id,name,email,phone,avatar', 'parentTenant:id,name'])
            ->withCount(['employees', 'customers'])
            ->when($this->search, function ($q) {
                $q->where(function ($qq) {
                    $qq->where('name', 'like', "%{$this->search}%")
                       ->orWhere('email', 'like', "%{$this->search}%")
                       ->orWhereHas('owner', function ($qo) {
                           $qo->where('name', 'like', "%{$this->search}%")
                              ->orWhere('email', 'like', "%{$this->search}%");
                       });
                });
            })
            ->when($this->statusFilter !== 'all', fn ($q) => $q->where('verification_status', $this->statusFilter))
            ->when($this->typeFilter === 'hq', fn ($q) => $q->whereNull('parent_tenant_id'))
            ->when($this->typeFilter === 'branch', fn ($q) => $q->whereNotNull('parent_tenant_id'))
            ->latest('created_at')
            ->paginate(12);
    }
};