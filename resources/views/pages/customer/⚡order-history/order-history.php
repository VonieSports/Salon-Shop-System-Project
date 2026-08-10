<?php

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

new #[Layout('layouts.customer')] class extends Component
{
  
   use WithPagination;

    public string $statusFilter = 'all';

    public function updatingStatusFilter(): void { $this->resetPage(); }

    #[Computed]
    public function orders()
    {
        return Order::query()
            ->with(['tenant:id,name', 'items.product:id,image'])
            ->where('user_id', Auth::id())
            ->when($this->statusFilter !== 'all', fn ($q) => $q->where('status', $this->statusFilter))
            ->latest()
            ->paginate(8);
    }
};