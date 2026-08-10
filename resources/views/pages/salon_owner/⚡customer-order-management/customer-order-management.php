<?php

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Models\Tenant;
use App\Services\PaymentService;
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
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();
    }

    public function viewOrder(int $orderId): void
    {
        $this->selectedOrderId = $orderId;
        $this->selectedOrder = Order::forTenant($this->tenantId)
            ->with(['customer', 'items.product', 'paymentMethod'])
            ->find($orderId);
    }

    public function closeOrder(): void
    {
        $this->selectedOrderId = null;
        $this->selectedOrder = null;
    }

    /**
     * Moves the order forward one stage:
     * Pending -> Confirmed -> Preparing -> Ready for Pickup -> Completed.
     */
    public function advanceStatus(int $orderId): void
    {
        $order = Order::forTenant($this->tenantId)->findOrFail($orderId);
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
        $order = Order::forTenant($this->tenantId)->findOrFail($orderId);

        if (!$order->status->canCancel()) {
            session()->flash('error', 'This order can no longer be canceled.');
            return;
        }

        $order->update(['status' => OrderStatus::CANCELED]);

        if ($this->selectedOrderId === $orderId) $this->viewOrder($orderId);
        unset($this->orders, $this->statusCounts);

        session()->flash('message', 'Order canceled.');
    }

    public function markAsPaid(int $orderId, PaymentService $paymentService): void
    {
        $order = Order::forTenant($this->tenantId)->findOrFail($orderId);

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

    public function maskName(?string $name): string { return PrivacyMasker::name($name); }
    public function maskPhone(?string $phone): string { return PrivacyMasker::phone($phone); }
    public function maskEmail(?string $email): string { return PrivacyMasker::email($email); }
};