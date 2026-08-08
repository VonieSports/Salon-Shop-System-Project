<?php

use App\Models\Customer;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

new #[Layout('layouts.admin')] class extends Component
{
    use WithPagination;

    #[Url(as: 'q')]
    public string $search = '';

    public function updatingSearch(): void { $this->resetPage(); }

    #[Computed]
    public function customers()
    {
        return Customer::query()
            ->with(['user:id,name,email,phone,avatar,is_active,created_at', 'tenant:id,name'])
            ->when($this->search, function ($q) {
                $q->whereHas('user', function ($qu) {
                    $qu->where('name', 'like', "%{$this->search}%")
                       ->orWhere('email', 'like', "%{$this->search}%");
                });
            })
            ->latest('created_at')
            ->paginate(15);
    }
};