<?php

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Services\OrderRulesService;
use App\Support\PrivacyMasker;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

new #[Layout('layouts.customer')] class extends Component
{
    public Order $order;

    public function mount(Order $order): void
    {
        abort_unless($order->user_id === Auth::id(), 404);

        $this->order = $order->load([
            'tenant:id,name,address,phone',
            'items.product:id,name,image',
            'items.service:id,name,image',
            'customer',
        ]);
    }

    public function currentStepIndex(): int
    {
        $flow = OrderStatus::getFlow();
        $i = array_search($this->order->status, $flow, true);
        return $i === false ? 0 : $i;
    }

    public function canCancel(): bool
    {
        return app(OrderRulesService::class)->canCancel($this->order);
    }

    public function cancelOrder(): void
    {
        if (!$this->canCancel()) return;

        $this->order->update(['status' => OrderStatus::CANCELED]);
        $this->order->refresh();
        session()->flash('success', 'Your order has been canceled.');
    }

    public function maskedName(): string
    {
        return PrivacyMasker::name(Auth::user()->name);
    }
};