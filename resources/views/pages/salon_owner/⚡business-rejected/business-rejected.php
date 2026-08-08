<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

new  #[Layout('layouts.salon_owner')]  class extends Component
{
     public $tenant;

    public function mount(): void
    {
        $this->tenant = Auth::user()->tenant;

        if (!$this->tenant) {
            $this->redirectRoute('owner.business_setup');
            return;
        }

        if ($this->tenant->verification_status !== 'rejected') {
            $this->redirectRoute(
                $this->tenant->verification_status === 'approved'
                    ? 'owner.dashboard'
                    : 'owner.business_approval'
            );
        }
    }

    public function resubmit(): void
    {
        $this->tenant->update([
            'business_setup_completed' => false,
            'verification_status' => 'pending',
            'rejection_reason' => null,
        ]);

        $this->redirectRoute('owner.business_setup');
    }
};