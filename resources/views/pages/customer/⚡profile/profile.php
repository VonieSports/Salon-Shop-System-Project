<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.customer')] class extends Component
{
   public $user;
   public $customer;

   public function mount(){

   $this->user = Auth::user();
   $this->customer = $this->user->customer;
   
   }
};