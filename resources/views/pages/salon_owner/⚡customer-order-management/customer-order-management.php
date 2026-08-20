<?php

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Models\Tenant;
use App\Services\OrderRulesService;
use App\Services\PaymentService;
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
        ->forTenant($this->tenantId)
        ->where('type', 'product')
        ->withCustomer()
        ->withItems()
        ->when($this->search, fn ($q) => $q->search($this->search))
        ->when($this->statusFilter !== 'all', fn ($q) => $q->byStatus($this->statusFilter))
        ->latestOrder()
        ->paginate(12);
}
#[Computed]
public function statusCounts(): array
{
    return Order::forTenant($this->tenantId)
        ->where('type', 'product')
        ->selectRaw('status, count(*) as count')
        ->groupBy('status')
        ->pluck('count', 'status')
        ->toArray();
}

  public function viewOrder(int $orderId): void
{
    $this->selectedOrderId = $orderId;
    $this->selectedOrder = Order::forTenant($this->tenantId)
        ->where('type', 'product')
        ->with(['customer', 'items.product', 'paymentMethod'])
        ->find($orderId);
}

    public function closeOrder(): void
    {
        $this->selectedOrderId = null;
        $this->selectedOrder = null;
    }

    public function selectedOrderStepIndex(): int
    {
        if (!$this->selectedOrder) return 0;
        $flow = OrderStatus::getFlow();
        $i = array_search($this->selectedOrder->status, $flow, true);
        return $i === false ? 0 : $i;
    }

    public function canCancelOrder($order): bool
    {
        return app(OrderRulesService::class)->canCancel($order);
    }

    public function advanceStatus(int $orderId): void
    {
        $order = Order::forTenant($this->tenantId)->where('type', 'product')->findOrFail($orderId);
        $next = $order->status->getNextStatus();

        if (!$next) return;

        $updateData = ['status' => $next];
        if ($next === OrderStatus::CONFIRMED) $updateData['confirmed_at'] = now();
        if ($next === OrderStatus::COMPLETED) $updateData['completed_at'] = now();

        $order->update($updateData);

        if ($this->selectedOrderId === $orderId) $this->viewOrder($orderId);
        unset($this->orders, $this->statusCounts);

        session()->flash('message', "Order moved to '{$next->label()}'.");
    }

    public function cancelOrder(int $orderId): void
    {
        $order = Order::forTenant($this->tenantId)->where('type', 'product')->findOrFail($orderId);

        if (!$this->canCancelOrder($order)) {
            $message = ($order->payment_type === 'online' && $order->payment_status === PaymentStatus::PAID)
                ? 'This order was paid online and can no longer be canceled. Please continue processing it to completion.'
                : 'This order can no longer be canceled.';
            session()->flash('error', $message);
            return;
        }

        $order->update(['status' => OrderStatus::CANCELED]);

        if ($this->selectedOrderId === $orderId) $this->viewOrder($orderId);
        unset($this->orders, $this->statusCounts);

        session()->flash('message', 'Order canceled.');
    }

    public function markAsPaid(int $orderId, PaymentService $paymentService): void
    {
       $order = Order::forTenant($this->tenantId)->where('type', 'product')->findOrFail($orderId);

        if ($order->payment_status === PaymentStatus::PAID) return;

        if (!$order->status->canMarkPaid()) {
            session()->flash('error', 'Confirm this order before marking it as paid.');
            return;
        }

        $paymentService->markPaid($order);

        if ($this->selectedOrderId === $orderId) $this->viewOrder($orderId);
        unset($this->orders, $this->statusCounts);

        session()->flash('message', 'Order marked as paid.');
    }
};