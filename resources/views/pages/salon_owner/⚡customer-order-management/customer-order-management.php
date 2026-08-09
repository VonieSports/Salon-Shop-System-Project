<?php

use App\Models\Order;
use App\Models\Tenant;
use App\Support\PrivacyMasker;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

new #[Layout('layouts.salon_owner')] class extends Component
{
    use WithPagination;

    public ?int $tenantId = null;

    #[Url(as: 'status')]
    public string $statusFilter = 'all';

    #[Url(as: 'q')]
    public string $search = '';

    public ?int $selectedOrderId = null;
    public $selectedOrder = null;

    public const STATUS_FLOW = ['pending', 'confirmed', 'ready_for_pickup', 'completed'];

    public function mount(): void
    {
        $user = Auth::user();
        $tenant = $user->tenant ?? Tenant::where('user_id', $user->id)->first();
        abort_unless($tenant, 403);
        $this->tenantId = $tenant->id;
    }

    public function updatingSearch(): void { $this->resetPage(); }
    public function updatingStatusFilter(): void { $this->resetPage(); }

    #[Computed]
    public function orders()
    {
        return Order::query()
            ->with(['customer:id,name,email,phone', 'items'])
            ->where('tenant_id', $this->tenantId)
            ->when($this->search, function ($q) {
                $q->where(function ($qq) {
                    $qq->where('order_number', 'like', "%{$this->search}%")
                       ->orWhereHas('customer', fn ($qc) => $qc->where('name', 'like', "%{$this->search}%"));
                });
            })
            ->when($this->statusFilter !== 'all', fn ($q) => $q->where('status', $this->statusFilter))
            ->latest()
            ->paginate(12);
    }

    #[Computed]
    public function statusCounts(): array
    {
        return Order::where('tenant_id', $this->tenantId)
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();
    }

    public function viewOrder(int $orderId): void
    {
        $this->selectedOrderId = $orderId;
        $this->selectedOrder = Order::with(['customer', 'items.product'])
            ->where('tenant_id', $this->tenantId)
            ->find($orderId);
    }

    public function closeOrder(): void
    {
        $this->selectedOrderId = null;
        $this->selectedOrder = null;
    }

    public function advanceStatus(int $orderId): void
    {
        $order = Order::where('tenant_id', $this->tenantId)->findOrFail($orderId);
        $currentIndex = array_search($order->status, self::STATUS_FLOW, true);

        if ($currentIndex === false || !isset(self::STATUS_FLOW[$currentIndex + 1])) {
            return;
        }

        $nextStatus = self::STATUS_FLOW[$currentIndex + 1];
        $updateData = ['status' => $nextStatus];
        if ($nextStatus === 'confirmed') $updateData['confirmed_at'] = now();
        if ($nextStatus === 'completed') $updateData['completed_at'] = now();

        $order->update($updateData);

        if ($this->selectedOrderId === $orderId) $this->viewOrder($orderId);
        unset($this->orders);
        unset($this->statusCounts);

        session()->flash('message', 'Order status updated.');
    }

    public function cancelOrder(int $orderId): void
    {
        $order = Order::where('tenant_id', $this->tenantId)->findOrFail($orderId);

        if (!in_array($order->status, ['pending', 'confirmed'], true)) {
            return;
        }

        $order->update(['status' => 'canceled']);

        if ($this->selectedOrderId === $orderId) $this->viewOrder($orderId);
        unset($this->orders);
        unset($this->statusCounts);

        session()->flash('message', 'Order canceled.');
    }

    public function maskName(?string $name): string { return PrivacyMasker::name($name); }
    public function maskPhone(?string $phone): string { return PrivacyMasker::phone($phone); }
    public function maskEmail(?string $email): string { return PrivacyMasker::email($email); }
};