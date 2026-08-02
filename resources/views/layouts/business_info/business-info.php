<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

new class extends Component
{
    public $tenant;
    public $user;

    public function mount()
    {
        $this->user = Auth::user();
        $this->tenant = $this->user->tenant;
        
    }

};