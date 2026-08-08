<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.admin')] class extends Component
{
    public $admin;

    public function mount(): void
    {
        $this->admin = Auth::user();
    }
};