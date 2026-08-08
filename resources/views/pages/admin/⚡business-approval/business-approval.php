<?php

use App\Models\Tenant;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

new #[Layout('layouts.admin')] class extends Component
{
    use WithPagination;

    public ?int $selectedTenantId = null;
    public bool $showRejectModal = false;
    public string $rejectionReason = '';

    #[Computed]
    public function pendingTenants()
    {
        return Tenant::query()
            ->with(['owner:id,name,email,phone,avatar', 'parentTenant:id,name'])
            ->where('verification_status', 'pending')
            ->where('business_setup_completed', true)
            ->latest('submitted_at')
            ->paginate(8);
    }

    #[Computed]
    public function pendingCount(): int
    {
        return Tenant::where('verification_status', 'pending')
            ->where('business_setup_completed', true)
            ->count();
    }

    public function approve(int $tenantId): void
    {
        $tenant = Tenant::where('verification_status', 'pending')->findOrFail($tenantId);

        $tenant->update([
            'verification_status' => 'approved',
            'is_active' => true,
            'rejection_reason' => null,
        ]);

        session()->flash('message', "'{$tenant->name}' has been approved.");
    }

    public function openRejectModal(int $tenantId): void
    {
        $this->selectedTenantId = $tenantId;
        $this->rejectionReason = '';
        $this->showRejectModal = true;
    }

    public function closeRejectModal(): void
    {
        $this->showRejectModal = false;
        $this->selectedTenantId = null;
        $this->rejectionReason = '';
    }

    protected function rules(): array
    {
        return ['rejectionReason' => 'required|string|min:5|max:500'];
    }

    public function reject(): void
    {
        $this->validate();

        $tenant = Tenant::where('verification_status', 'pending')->findOrFail($this->selectedTenantId);

        $tenant->update([
            'verification_status' => 'rejected',
            'is_active' => false,
            'rejection_reason' => $this->rejectionReason,
        ]);

        session()->flash('message', "'{$tenant->name}' has been rejected.");
        $this->closeRejectModal();
    }
};