<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use Carbon\Carbon;

new #[Layout('layouts.employee')] class extends Component
{
     public $user;
    public $hasPermissions = false;
    public $permissions = [];
    public $employeeData;
    public $status;

    public function mount()
    {
        $this->user = auth()->user();
    
        $this->hasPermissions = $this->user->permissions()->count() > 0;
        $this->permissions = $this->user->permissions()->pluck('name')->toArray();
        $this->employeeData = $this->user->employeeProfile;
    }
};