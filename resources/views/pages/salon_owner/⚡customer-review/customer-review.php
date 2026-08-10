<?php

use App\Models\Review;
use App\Models\Tenant;
use App\Support\PrivacyMasker;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

new #[Layout('layouts.salon_owner')] class extends Component
{
    use WithPagination;

    public ?int $tenantId = null;

    public function mount(): void
    {
        $user = Auth::user();
        $tenant = $user->tenant ?? Tenant::where('user_id', $user->id)->first();
        abort_unless($tenant, 403);
        $this->tenantId = $tenant->id;
    }

    #[Computed]
    public function reviews()
    {
        return Review::query()
            ->with([
                'customer.user:id,name,avatar', // adjust relation names to your actual schema
                'product:id,name',
            ])
            ->where('tenant_id', $this->tenantId)
            ->latest()
            ->paginate(10);
    }

    public function maskName(?string $name): string { return PrivacyMasker::name($name); }
};