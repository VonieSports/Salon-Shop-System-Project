<?php

use App\Models\Order;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.customer')] class extends Component
{
     public Order $order;

    public function mount(Order $order)
    {
        $this->order = $order;
    }
};