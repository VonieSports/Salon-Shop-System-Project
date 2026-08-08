<?php

use App\Models\Tenant;
use App\Models\Customer;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.admin')] class extends Component
{
    #[Computed]
    public function stats(): array
    {
        return [
            'total_tenants' => Tenant::count(),
            'pending' => Tenant::where('verification_status', 'pending')->where('business_setup_completed', true)->count(),
            'approved' => Tenant::where('verification_status', 'approved')->count(),
            'rejected' => Tenant::where('verification_status', 'rejected')->count(),
            'total_customers' => Customer::count(),
        ];
    }
};