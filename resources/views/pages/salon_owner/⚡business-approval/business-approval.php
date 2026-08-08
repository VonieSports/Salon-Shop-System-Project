<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.salon_owner')] class extends Component
{
      public $tenant;

    public function mount(): void
    {
        $this->tenant = Auth::user()->tenant;

        if (!$this->tenant || !$this->tenant->business_setup_completed) {
            $this->redirectRoute('owner.business_setup');
            return;
        }

        if ($this->tenant->verification_status === 'approved') {
            $this->redirectRoute('owner.dashboard');
            return;
        }

        if ($this->tenant->verification_status === 'rejected') {
            $this->redirectRoute('owner.business_rejected');
        }
    }

    public function checkStatus(): void
    {
        $this->tenant->refresh();

        if ($this->tenant->verification_status === 'approved') {
            session()->flash('success', 'Your business has been approved!');
            $this->redirectRoute('owner.dashboard');
            return;
        }

        if ($this->tenant->verification_status === 'rejected') {
            $this->redirectRoute('owner.business_rejected');
            return;
        }

        session()->flash('info', 'Still under review. Please check back later.');
    }
};