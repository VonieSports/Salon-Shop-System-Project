<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.salon_owner')] class extends Component
{
    public $user;
    public $tenant;

    public function mount(){

        $this->user = Auth::user();
        $this->tenant = $this->user->tenant;
    }
};